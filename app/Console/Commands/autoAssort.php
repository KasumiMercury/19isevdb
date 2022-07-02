<?php

namespace App\Console\Commands;

use Faker\Core\Number;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class autoAssort extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:autoAssort';

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
        date_default_timezone_set('Asia/Tokyo');
        $search = array(array("恋惡まよ","まよすけ","まよ抜き"),array("星降あめる","あめる","切り取るあめる"),array("綵てまり","てまりん","てまらいぶ"),array("心寧はな","まぢかよはな"),array("羽奏こはく","わかちこ","羽奏を見よ"),array("泉谷このみ","このみん"),array("勇未つかさ"),array("紅月うる","うるち","うるこま","うるカット"),array("稲荷こまち","いなこま","うるこま","いなこま切れ"),array("神白ニア","ニア","ニア刈り"));

        $data = DB::connection('mysql_autoregister')->table('stock')->where('status',0)->get();
        $dataNum = count($data);
        for($i=0;$i<$dataNum;$i++){
            $memberNum=array();
            $tempTitle = $data[$i]->title;
            $tempDesc = $data[$i]->description;
            for($k=0;$k<count($search);$k++){
                $tempSearch = $search[$k];
                for($m=0;$m<count($tempSearch);$m++){
                    $tempWord = $tempSearch[$m];
                    if(strpos($tempTitle,$tempWord) !== false){
                        $isExist = in_array(intval($k+1), $memberNum);
                        if(!$isExist){
                            array_push($memberNum,intval($k+1));
                        }
                    }
                    if(strpos($tempDesc,$tempWord) !== false){
                        $isExist = in_array(intval($k+1), $memberNum);
                        if(!$isExist){
                            array_push($memberNum,intval($k+1));
                        }
                    }
                }
            }
            if(count($memberNum)==0){
                DB::connection('mysql_autoregister')->table('stock')->where('VideoID',$data[$i]->VideoID)->update(['status'=>3]);
            }else{
                for($m=0;$m<count($memberNum);$m++){
                    $isNew = DB::table('players')->where('VideoID',$data[$i]->VideoID)->where('member_id',$memberNum[$m])->doesntExist();
                    if($isNew){
                        $infoArray["title"]=$data[$i]->title;
                        $infoArray["date"]=$data[$i]->date;
                        $infoArray["VideoID"]=$data[$i]->VideoID;
                        $infoArray["VideoTitle"]=$data[$i]->title;
                        $infoArray["start"]=0;
                        $infoArray["end"]=0;
                        $infoArray["status"]=0;
                        $infoArray["cate_id"]=4;
                        $infoArray["member_id"]=$memberNum[$m];
                        $infoArray["created_at"]= date('Y-m-d H:i:s');
                        $infoArray["updated_at"]= date('Y-m-d H:i:s');
                        $infoArray["CreaterHN"]=$data[$i]->createrHN;
                        $infoArray["isShow"]=1;
                        DB::table('players')->insert($infoArray);
    
                        $player = DB::table('players')->where('VideoID',$data[$i]->VideoID)->where('member_id',$memberNum[$m])->first();
                        $relateArray["user_id"]=$data[$i]->user_id;
                        $relateArray["stock_id"]=$data[$i]->id;
                        $relateArray["player_id"]=$player->id;
                        DB::connection('mysql_autoregister')->table('relates')->insert($relateArray);
    
                        DB::connection('mysql_autoregister')->table('stock')->where('VideoID',$data[$i]->VideoID)->update(['status'=>1]);
                    }else{
                        DB::connection('mysql_autoregister')->table('stock')->where('VideoID',$data[$i]->VideoID)->update(['status'=>2]);
                    }
                }
            }
        }
    }
}
