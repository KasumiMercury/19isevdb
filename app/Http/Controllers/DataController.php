<?php

namespace App\Http\Controllers;
use App\Models\Players;
use Abraham\TwitterOAuth\TwitterOAuth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Google_Client;
use Google_Service_YouTube;

class DataController extends Controller
{
    public function addTwitter(Request $request){
        $CK = config('twitter.api_key');
        $CS  = config('twitter.secret_key');
        $AT  = config('twitter.access_token');
        $AS  = config('twitter.access_token_secret');
        $connection = new TwitterOAuth( $CK, $CS, $AT, $AS );
        $connection->setApiVersion('2');

        $temp = $request->all();
        $tempLength = count($temp);
        $mediaUrl ="";
        $mediaType ="";

        for($i = 0; $i < $tempLength; $i++){
            $tempId = $temp[$i]["twitterId"];
            $json = $connection->get('tweets', ['ids' => $tempId,'tweet.fields' => 'entities',  'expansions'=> 'attachments.media_keys', 'media.fields'=> 'preview_image_url,url']);
            $getTweet = get_object_vars($json);
            $tempincludes=$getTweet["includes"];
            $Mediaarray = json_decode(json_encode($tempincludes), true);
            $mediaType = $Mediaarray["media"][0]["type"];

            if($mediaType == "photo"){
                $mediaUrl = "";
                $mediaLength = count($Mediaarray["media"]);
                for($k = 0; $k < $mediaLength; $k++){
                    if($k == 0){
                        $mediaUrl = $Mediaarray["media"][0]["url"];
                    }else{
                        $mediaUrl=$mediaUrl.",".$Mediaarray["media"][$k]["url"];
                    }
                }
            }else{
                $entitiesTemp = json_decode(json_encode($getTweet["data"]), true)[0]["entities"]["urls"];
                $urlsTemp  = end($entitiesTemp);
                $mediaUrl = $urlsTemp["expanded_url"];
            }

            $sendArray[$i]["tweetType"] = $mediaType;
            $sendArray[$i]["tweetUrl"]=$mediaUrl;
            $sendArray[$i]["twitter"]=$temp[$i]["twitter"];
            $sendArray[$i]["title"]=$temp[$i]["title"];
            $sendArray[$i]["date"]=$temp[$i]["date"];
            $sendArray[$i]["status"]=0;
            $sendArray[$i]["cate_id"]=$temp[$i]["cate_id"];
            $sendArray[$i]["member_id"]=$temp[$i]["member_id"];
            $sendArray[$i]["createrHN"]=$temp[$i]["createrHN"];
            $sendArray[$i]["created_at"]=$temp[$i]["created_at"];
            $sendArray[$i]["updated_at"]=$temp[$i]["updated_at"];
        }
        DB::table('players')->insert($sendArray);
        \Illuminate\Support\Facades\Artisan::call('batch:convertTitle');
    }
    public function addClip(Request $request){
        $temp = $request->all();
        var_dump($temp);
        DB::table('players')->insert($temp);
        \Illuminate\Support\Facades\Artisan::call('batch:convertTitle');
    }
    public function addYoutube(Request $request){
        $temp = $request->all();
        var_dump($temp);
        DB::table('players')->insert($temp);
        \Illuminate\Support\Facades\Artisan::call('batch:convertTitle');
    }
    public function addYTclip(Request $request){
        $temp = $request->all();
        var_dump($temp);
        DB::table('players')->insert($temp);
        \Illuminate\Support\Facades\Artisan::call('batch:convertTitle');
    }
    
    public function Edit($id,Request $request){
        $player = DB::table('players')->find($id);
        return Inertia::render('EditPage', [
            'player' => $player,
            'id' => $id,
        ]);
    }
    public function editStatus(Request $request){
        $data = Players::find($request->id);
        $data->status = $request->status;
        $data->save();
    }
    public function playerChange(Request $request){
        $data = Players::find($request->id);
        $data->title = $request->title;
        $data->member_id = $request->member_id;
        $data->cate_id = $request->cate_id;
        if($request->type == 'youtube'){
            $data->start = $request->start;
            $data->end = $request->end;
        }

        $data->save();
        \Illuminate\Support\Facades\Artisan::call('batch:convertTitle');
    }

    public function addAuto(Request $request){
        $api = 'AIzaSyCv9gZE-50Vj3fVj1dgk0IPv0O1MoDsiHI';
        $temp = $request->all();
        $isNew = DB::connection('mysql_autoregister')->table('user')->where('ChannelID',$temp[0]["channelID"])->doesntExist();
        if($isNew){
            DB::connection('mysql_autoregister')->table('user')->updateOrInsert([
                'ChannelID' => $temp[0]["channelID"],
                'CreaterHN' => $temp[0]["createrHN"]
            ]);
            $id = DB::connection('mysql_autoregister')->getPdo()->lastInsertId();
            $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='. $temp[0]["channelID"] .'&maxResults=50&order=date&type=video&key='.$api;
            $items = json_decode(file_get_contents($url))->items;
            if(count($items) != 0){
                for($i = 0; $i < count($items); $i++){
                    $tempItem = $items[$i];
                    $tempData = json_decode(json_encode($tempItem), true);
                    $tempSnip = $tempData["snippet"];
                    $tempId = $tempData["id"];
                    $sendArray[$i]["title"] = $tempSnip["title"];
                    $sendArray[$i]["description"] = $tempSnip["description"];
                    $sendArray[$i]["VideoID"] = $tempId["videoId"];
                    $sendArray[$i]["date"] = date('Y-m-d H:i:s', strtotime($tempSnip["publishedAt"]));
                    $sendArray[$i]["status"] = 0;
                    $sendArray[$i]["createrHN"] = $temp[0]["createrHN"];
                    $sendArray[$i]["user_id"] = $id;
                }
                DB::connection('mysql_autoregister')->table('stock')->insert($sendArray);
                \Illuminate\Support\Facades\Artisan::call('batch:autoAssort');
            }
        }else{
            ;
        }
    }

    public function channelCollation(Request $request){
        $player = array();
        $userName = $request->input('user');
        $user = DB::connection('mysql_autoregister')->table('user')->where('CreaterHN',$userName)->first();
        $stock = DB::connection('mysql_autoregister')->table('stock')->where('user_id',$user->id)->get();
        for($i=0;$i<count($stock);$i++){
            $tempArray = array();
            if($stock[$i]->status == 1){
                $player_id = DB::connection('mysql_autoregister')->table('relates')->where('stock_id',$stock[$i]->id)->get()->toArray();
                $tempArray["stock"] = json_decode(json_encode($stock[$i]), true);
                $playerArray = array();
                for($k=0;$k<count($player_id);$k++){
                    $tempPlayer = DB::table('players')->where('players.id',$player_id[$k]->player_id)->join('member','players.member_id','=','member.id')->select('players.*','member.name')->first();
                    $playerInfo = json_decode(json_encode($tempPlayer), true);
                    $playerArray[] = $playerInfo;
                }
                $tempArray["player"] = $playerArray;
                array_push($player,$tempArray);
            }else if($stock[$i]->status == 2){
                $tempArray["stock"] = json_decode(json_encode($stock[$i]), true);
                $playerArray = array();
                $tempPlayer = DB::table('players')->where('players.VideoID',$stock[$i]->VideoID)->join('member','players.member_id','=','member.id')->select('players.*','member.name')->first();
                $playerInfo = json_decode(json_encode($tempPlayer), true);
                $playerArray[] = $playerInfo;
                $tempArray["player"] = $playerArray;
                array_push($player,$tempArray);
            }else{
                $tempArray["stock"] = json_decode(json_encode($stock[$i]), true);
                array_push($player,$tempArray);
            }
        }
        return response()->json(
            [
                'player' => $player,
            ]
        );
    }
    
    public function getVideoMember(int $id,Request $request){
        $videos = DB::connection('mysql_liveinfo')->table('stock')->where('member_id',$id)->where('public','!=',3)->orderBy('id', 'desc')->limit(20)->get();
        return response()->json(
            [
                'videos' => $videos,
            ]
        );
    }
}
