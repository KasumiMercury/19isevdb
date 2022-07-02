<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Google_Client;
use Google_Service_YouTube;

class AutoRss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:autoRss';

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
        $client->setDeveloperKey("AIzaSyBM38qOc5rKP_GV47QXMP0x8lFHGvRixw0");
        $youtube = new Google_Service_YouTube($client);

        $user = DB::connection('mysql_autoregister')->table('user')->get();
        $userArray = json_decode(json_encode($user), true);
        $userNum = count($userArray);
        $sendArray = array();
        for($i = 0; $i < $userNum; $i++){
            $feed='https://www.youtube.com/feeds/videos.xml?channel_id='.$userArray[$i]["ChannelID"];
            $xml = simplexml_load_file($feed);
            $obj = get_object_vars($xml);

            $exisit = array_key_exists("entry", $obj);
            if($exisit){
                $obj_entry = $obj["entry"];

                for($k = 0; $k < count($obj_entry); $k++){
                    $infoArray = array();
                    $temp = $obj_entry[$k];
                    $tempArray = json_decode(json_encode($temp), true);
                    $isNew = DB::connection('mysql_autoregister')->table('stock')->where('VideoID',str_replace('yt:video:', '', $tempArray["id"]))->doesntExist();
                    if($isNew){
                        $infoArray["title"] = $tempArray["title"];
                        $infoArray["VideoID"] = str_replace('yt:video:', '', $tempArray["id"]);
                        $infoArray["date"] = date('Y-m-d H:i:s', strtotime($tempArray["published"]));
                        $infoArray["status"] = 0;
                        $infoArray["createrHN"] = $userArray[$i]["CreaterHN"];
                        $infoArray["user_id"] = $userArray[$i]["id"];
                        array_push($sendArray,$infoArray);
                    }
                }
            }
        }
        $videoArray = array();
        $dataNum = count($sendArray);
        if($dataNum > 30){
            $queryCount = floor($dataNum/30);
            $queryNum = $dataNum - 30*$queryCount;
        }else{
            $queryCount = 0;
            $queryNum = $dataNum;
        }

        for($p = 0;$p <= $queryCount;$p++){
            for($q = 0; $q < $queryNum; $q++){
                array_push($videoArray,$sendArray[$q+$p*30]["VideoID"]);
            }
            $query = join(",",$videoArray);
            $items = $youtube->videos->listVideos("snippet",
                array('id' => $query)
            );
            $itemNum = count($items);
            if($queryNum == $itemNum){
                for($r=0;$r<$itemNum;$r++){
                    $sendArray[$p*30+$r]["description"] = $items[$r]["snippet"]["description"];
                }
            }
        }
        DB::connection('mysql_autoregister')->table('stock')->insert($sendArray);
    }
}
