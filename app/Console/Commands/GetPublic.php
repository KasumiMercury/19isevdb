<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Google_Client;
use Google_Service_YouTube;

class GetPublic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:getPublic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Google_Client();
        // $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $client->setDeveloperKey("AIzaSyAw2K7uOnkbTSb6UiJHadI1RHd_3oLaqBE");
        $youtube = new Google_Service_YouTube($client);

        $VideoIDarray = [];

        for($m = 1; $m < 11; $m++){
            $data = DB::connection('mysql_liveinfo')->table('stock')->where('member_id',$m)->where('public','!=',3)->orderBy('id','desc')->limit(20)->get();
            $dataNum = count($data);
    
            for($i = 0; $i < $dataNum; $i++){
                $tempData = json_decode(json_encode($data[$i]), true);
                array_push($VideoIDarray,$tempData["VideoID"]);
            }
        }
        $requestArray = array_chunk( $VideoIDarray, 50 );
        $resultArray = [];
    
        for($i = 0; $i < count($requestArray); $i++){
            $query = join(",",$requestArray[$i]);
            $items = $youtube->videos->listVideos("snippet,status",
                array('id' => $query)
            );
            for($k = 0; $k < count($items); $k++){
                $VideoID = $items[$k]["id"];
                $public = $items[$k]["status"]["privacyStatus"];
                $newStatus = 0;

                if($public == "unlisted"){
                    $newStatus = 1;
                }else if($public == "private"){
                    $newStatus = 2;
                }else{
                    $newStatus = 0;
                }
                $publishedAt = $items[$k]["snippet"]["publishedAt"];
                $resultArray[]=[
                    "id"=>$VideoID,
                    "public"=>$newStatus,
                    "publishedAt"=>date('Y-m-d H:i:s', strtotime($publishedAt))
                ];
            }
        }

        $IDArray = array_column($resultArray, 'id');
        for($k = 0; $k < count($VideoIDarray); $k++){    
            $isExsit = array_search($VideoIDarray[$k], $IDArray);
            if($isExsit === false){
                DB::connection('mysql_liveinfo')->table('stock')->where('VideoID', $VideoIDarray[$k])
                                    ->update([
                                        "public"=>3,
                                        "publishedAt"=>null
                                    ]);
            }else{
                DB::connection('mysql_liveinfo')->table('stock')->where('VideoID', $VideoIDarray[$k])
                                    ->update([
                                        "public"=>$resultArray[$isExsit]["public"],
                                        "publishedAt"=>$resultArray[$isExsit]["publishedAt"]
                                    ]);
            }
        }
        var_dump($resultArray);
    }
}
