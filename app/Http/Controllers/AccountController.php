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

class AccountController extends Controller
{
    public function addLike(Request $request){
        $temp = $request->all();
        var_dump($temp);
        DB::table('bookmarks')->insert($temp);
    }
    public function DisLike(Request $request){
        $playerId = $request->get('player_id');
        $userId = $request->get('user_id');
        DB::table('bookmarks')->where('player_id',$playerId)->where('user_id',$userId)->delete();
    }
    
    public function postIsShow(Request $request)
    {
        $temp = $request->all();
        $isExsit = DB::table('user_isshow')->where('CreaterHN',$request["CreaterHN"])->exists();
        if($isExsit){
            DB::table('user_isshow')->where('CreaterHN',$temp["CreaterHN"])->update($temp);
        }else{
            DB::table('user_isshow')->insert($request["data"]);
        }
        DB::table('players')->where('CreaterHN',$temp["CreaterHN"])->update(['isShow'=> $temp["isShow"]]);
    }
    public function registerShow($id)
    {
        $user = DB::table('users')->where('id',$id)->get()->toArray();
        $name = $user[0]->name;
        
        $isExsit = DB::table('user_isshow')->where('createrHN','=',$name)->exists();
        if($isExsit){
            $showTemp = DB::table('user_isshow')->where('createrHN','=',$name)->get();
            $isShow = $showTemp[0]->isShow;
        }else{
            $isShow = 1;
        }

        return response()->json(
            [
                'isShow' => $isShow,
            ]);
    }
}
