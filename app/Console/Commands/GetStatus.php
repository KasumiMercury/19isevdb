<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use Google_Client;
use Google_Service_YouTube;

class GetStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:GetStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get live status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Google_Client();
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $youtube = new Google_Service_YouTube($client);

        $data = DB::connection('mysql_liveinfo')->table('stock')->where('status','>','0')->get();
        $dataNum = count($data);

        if($dataNum != 0){
            $VideoIDarray = [];
            if($dataNum > 30){
                $queryNum = 30;
            }else{
                $queryNum = $dataNum;
            }
    
            for($i = 0; $i < $queryNum; $i++){
                $tempData = json_decode(json_encode($data[$i]), true);
                array_push($VideoIDarray,$tempData["VideoID"]);
            }
            $query = join(",",$VideoIDarray);
    
            $items = $youtube->videos->listVideos("snippet",
                array('id' => $query)
            );
    
            $resultArray = [];
            
            for($k = 0; $k < count($items); $k++){
                $tempStatus = $items[$k]["snippet"]["liveBroadcastContent"];
                    if($tempStatus == "none"){
                        $newStauts = 0;
                        $newPublic = 0;
                    }elseif($tempStatus == "upcoming"){
                        $newStauts = 1;
                        $newPublic = 2;
                    }elseif($tempStatus == "live"){
                        $newStauts = 2;
                        $newPublic = 2;
                    }else{
                        $newStauts = 3;
                        $newPublic = 2;
                    }
                    $resultArray[]=[
                        "id"=>$items[$k]["id"],
                        "newStauts"=>$newStauts,
                        "newPublic"=>$newPublic
                    ];
            }
            
            $IDArray = array_column($resultArray, 'id');
            for($m = 0; $m < count($VideoIDarray); $m++){    
                $isExsit = array_search($VideoIDarray[$m], $IDArray);
    
                if($isExsit === false){
                    DB::connection('mysql_liveinfo')->table('stock')->where('VideoID', $VideoIDarray[$m])
                                        ->update([
                                            'status' => 0,
                                            'public' => 3,
                                        ]);
                    Log::info('getStatus', ['id' => $tempData["id"],'APIstatus' => $tempStatus,'status' => $newStauts]);
                }else{
                    DB::connection('mysql_liveinfo')->table('stock')->where('VideoID', $VideoIDarray[$m])
                                        ->update([
                                            'status' => $resultArray[$m]["newStauts"],
                                            'public' => $resultArray[$m]["newPublic"],
                                        ]);
                    Log::info('getStatus', ['id' => $tempData["id"],'APIstatus' => $tempStatus,'status' => $newStauts]);
                }
            }
            var_dump($items);
        }
    }
}
