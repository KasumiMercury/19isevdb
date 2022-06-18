<?php

namespace App\Http\Controllers;
use App\Models\Member;
use App\Models\Players;
use Illuminate\Support\Facades\Auth;
use Abraham\TwitterOAuth\TwitterOAuth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

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

}
