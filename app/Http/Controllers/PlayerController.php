<?php

namespace App\Http\Controllers;
// use App\Models\Category;
use App\Models\Member;
// use App\Models\User;
use App\Models\Players;
// use App\Models\BookMark;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Pagination\Paginator;
use Abraham\TwitterOAuth\TwitterOAuth;

// use Faker\Core\Number;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function TopPage(Request $request)
    {
        $query = Players::query();
        $query->where('status','!=','3');
            
        if($request->searchWord == null || $request->searchWord == ""){
            $search = "";
        }else{
            $search = $request->searchWord;
            $searchTemp = '%' . addcslashes($search, '%_\\') . '%';
            $query->where('title', 'like', $searchTemp);
        }

        if($request->sortType == null || $request->sortType == ""){
            $sort = "";
            if($request->orderType == "asc"){
                $query->orderBy('id','ASC');
                $order=true;
            }else{
                $query->orderBy('id','DESC');
                $order=false;
            }
        }else{
            $sort = $request->sortType;
            if($sort == 'title'){
                if($request->orderType == "desc"){
                    $query->orderBy('title','DESC');
                    $order=false;
                }else{
                    $query->orderBy('title','ASC');
                    $order=true;
                }
            }else if($sort == 'date'){
                if($request->orderType == "desc"){
                    $query->orderBy('date', 'desc');
                    $order=false;
                }else{
                    $query->orderBy('date', 'ASC');
                    $order=true;
                }
            }else{
                if($request->orderType == "asc"){
                    $query->orderBy('id','ASC');
                    $order=true;
                }else{
                    $query->orderBy('id','DESC');
                    $order=false;
                }
            }
        }

        $players = $query->join('member','players.member_id','=','member.id')->select('players.*','member.name')->paginate(12);
        
        return Inertia::render('TopPage', [
            'players' => $players,
            'searchWord' => $search,
            'sortType' => $sort,
            'order' => $order
        ]);
    }
    public function memberTop($member)
    {
        return redirect()->route('member.latest', ['member' => $member]);
    }
    public function latest(String $member,Request $request)
    {
        $currentMember = DB::table('member')->where('name', $member)->first();

        $query = Players::query();
        $query->whereHas('member', function ($query) use ($member) {
                    $query->whereName($member);
                    })
                ->where('status','!=','3');
            
        if($request->searchWord == null || $request->searchWord == ""){
            $search = "";
        }else{
            $search = $request->searchWord;
            $searchTemp = '%' . addcslashes($search, '%_\\') . '%';
            $query->where('title', 'like', $searchTemp);
        }

        if($request->sortType == null || $request->sortType == ""){
            $sort = "";
            if($request->orderType == "asc"){
                $query->orderBy('id','ASC');
                $order=true;
            }else{
                $query->orderBy('id','DESC');
                $order=false;
            }
        }else{
            $sort = $request->sortType;
            if($sort == 'title'){
                if($request->orderType == "desc"){
                    $query->orderBy('title','DESC');
                    $order=false;
                }else{
                    $query->orderBy('title','ASC');
                    $order=true;
                }
            }else if($sort == 'date'){
                if($request->orderType == "desc"){
                    $query->orderBy('date', 'desc');
                    $order=false;
                }else{
                    $query->orderBy('date', 'ASC');
                    $order=true;
                }
            }else{
                if($request->orderType == "asc"){
                    $query->orderBy('id','ASC');
                    $order=true;
                }else{
                    $query->orderBy('id','DESC');
                    $order=false;
                }
            }
        }

        $players = $query->paginate(12);

        return Inertia::render('PlayerList', [
            'currentMember' => $currentMember,
            'cate' => 0,
            'players' => $players,
            'searchWord' => $search,
            'sortType' => $sort,
            'order' => $order
        ]);
    }
    public function memberCate(string $member,int $cate,Request $request)
    {
        $currentMember = DB::table('member')->where('name', $member)->first();

        $query = Players::query();
        $query ->whereHas('member', function ($query) use ($member) {
                            $query->whereName($member);
                        })
                        ->where('players.cate_id', $cate)
                        ->where('status','!=','3');

        
        if($request->searchWord == null || $request->searchWord == ""){
            $search = "";
        }else{
            $search = $request->searchWord;
        }

        if($request->sortType == null || $request->sortType == ""){
            $sort = "";
            if($request->orderType == "asc"){
                $query->orderBy('id','ASC');
                $order=true;
            }else{
                $query->orderBy('id','DESC');
                $order=false;
            }
        }else{
            $sort = $request->sortType;
            if($sort == 'title'){
                if($request->orderType == "desc"){
                    $query->orderBy('title','DESC');
                    $order=false;
                }else{
                    $query->orderBy('title','ASC');
                    $order=true;
                }
            }else if($sort == 'date'){
                if($request->orderType == "desc"){
                    $query->orderBy('date', 'desc');
                    $order=false;
                }else{
                    $query->orderBy('date', 'ASC');
                    $order=true;
                }
            }else{
                if($request->orderType == "asc"){
                    $query->orderBy('id','ASC');
                    $order=true;
                }else{
                    $query->orderBy('id','DESC');
                    $order=false;
                }
            }
        }

        $players = $query->paginate(12);
        return Inertia::render('PlayerList', [
            'currentMember' => $currentMember,
            'cate' => $cate,
            'players' => $players,
            'searchWord' => $search,
            'sortType' => $sort,
            'order' => $order
        ]);
    }


    public function player($member,$id,Request $request)
    {
        $player = DB::table('players')->find($id);
        $currentMember = DB::table('member')->whereId($player->member_id)->first();
        $list_type = $request->list;
        $list_id = $request->index;

        $user_id = Auth::id();
        if($user_id != null){

            
            if( $list_type == "BM" ){
                $list = DB::table('players')->join('bookmarks','players.id','=','bookmarks.player_id')
                                    ->where('bookmarks.user_id','=', $user_id)
                                    ->where('twitter','=',null)
                                    ->where('YTclipUrl',null)
                                    ->orderBy('bookmarks.id','ASC')
                                    ->join('member','players.member_id','=','member.id')
                                    ->select('players.title','players.date','players.status','players.id','member.name')
                                    ->get()->toArray();

                if($list_id == null){
                    $list_id = 0;
                }

                $related = DB::table('players')->where('member_id','=',$player->member_id)
                                    ->where('players.id','!=', $id)
                                    ->where('status','!=','3')
                                    ->where('status','!=','2')
                                    ->where('twitter','=',null)
                                    ->where('YTclipUrl',null)
                                    ->inRandomOrder()
                                    ->limit(12)
                                    ->join('member','players.member_id','=','member.id')
                                    ->select('players.title','players.date','players.status','players.id','member.name')
                                    ->get()->toArray();
                $relatedNum = count($related);
                if($relatedNum < 12){
                    $temp = DB::table('players')->where('players.id','!=', $id)
                                    ->where('status','!=','3')
                                    ->where('status','!=','2')
                                    ->where('twitter','=',null)
                                    ->where('YTclipUrl',null)
                                    ->inRandomOrder()
                                    ->limit(12 -$relatedNum)
                                    ->join('member','players.member_id','=','member.id')
                                    ->select('players.title','players.date','players.status','players.id','member.name')

                                    ->get()->toArray();
                    $related = array_merge($related,$temp);
                };
            }elseif( $list_type == "add"){
                $user = Auth::user();
                $name = $user["name"];
                $list = DB::table('players')->where('createrHN','=',$name)
                                    ->where('twitter','=',null)
                                    ->where('YTclipUrl',null)
                                    ->orderBy('players.id','DESC')
                                    ->join('member','players.member_id','=','member.id')
                                    ->select('players.title','players.date','players.status','players.id','member.name')
                                    ->get()->toArray();

                if($list_id == null){
                    $list_id = 0;
                }

                $related = DB::table('players')->where('member_id','=',$player->member_id)
                                    ->where('players.id','!=', $id)
                                    ->where('status','!=','3')
                                    ->where('status','!=','2')
                                    ->where('twitter','=',null)
                                    ->where('YTclipUrl',null)
                                    ->inRandomOrder()
                                    ->limit(12)
                                    ->join('member','players.member_id','=','member.id')
                                    ->select('players.title','players.date','players.status','players.id','member.name')
                                    ->get()->toArray();
                $relatedNum = count($related);
                if($relatedNum < 12){
                    $temp = DB::table('players')->where('players.id','!=', $id)
                                    ->where('status','!=','3')
                                    ->where('status','!=','2')
                                    ->where('twitter','=',null)
                                    ->where('YTclipUrl',null)
                                    ->inRandomOrder()
                                    ->limit(12 -$relatedNum)
                                    ->join('member','players.member_id','=','member.id')
                                    ->select('players.title','players.date','players.status','players.id','member.name')

                                    ->get()->toArray();
                    $related = array_merge($related,$temp);
                };

            }else{
                $related = DB::table('players')->where('member_id','=',$player->member_id)
                                    ->where('players.id','!=', $id)
                                    ->where('status','!=','3')
                                    ->where('status','!=','2')
                                    ->where('twitter','=',null)
                                    ->where('YTclipUrl',null)
                                    ->inRandomOrder()
                                    ->limit(12)
                                    ->join('member','players.member_id','=','member.id')
                                    ->select('players.title','players.date','players.status','players.id','member.name')
                                    ->get()->toArray();
                $relatedNum = count($related);
                if($relatedNum < 12){
                    $temp = DB::table('players')->where('players.id','!=', $id)
                                    ->where('status','!=','3')
                                    ->where('status','!=','2')
                                    ->where('twitter','=',null)
                                    ->where('YTclipUrl',null)
                                    ->inRandomOrder()
                                    ->limit(12 -$relatedNum)
                                    ->join('member','players.member_id','=','member.id')
                                    ->select('players.title','players.date','players.status','players.id','member.name')

                                    ->get()->toArray();
                    $related = array_merge($related,$temp);
                };

                $list = null;
            };


        }else{
            $related = DB::table('players')->where('member_id','=',$player->member_id)
                                ->where('players.id','!=', $id)
                                ->where('status','!=','3')
                                ->where('status','!=','2')
                                ->where('twitter','=',null)
                                ->where('YTclipUrl',null)
                                ->inRandomOrder()
                                ->limit(12)
                                ->join('member','players.member_id','=','member.id')
                                ->select('players.title','players.date','players.status','players.id','member.name')
                                ->get()->toArray();
            $relatedNum = count($related);
            if($relatedNum < 12){
                $temp = DB::table('players')->where('players.id','!=', $id)
                                ->where('status','!=','3')
                                ->where('status','!=','2')
                                ->where('twitter','=',null)
                                ->where('YTclipUrl',null)
                                ->inRandomOrder()
                                ->limit(12 -$relatedNum)
                                ->join('member','players.member_id','=','member.id')
                                ->select('players.title','players.date','players.status','players.id','member.name')

                                ->get()->toArray();
                $related = array_merge($related,$temp);
            };
            $list = null;

        }

        return Inertia::render('PlayerPage', [
            'currentMember' => $currentMember,
            'player' => $player,
            'id' => $id,
            'list_type' => $list_type,
            'list_id' => (int)$list_id,
            'list' => $list,
            'related' => $related,
        ]);
    }
    public function sharePlayer($member,$id)
    {
        $player = Players::find($id);
        $currentMember = Member::where('id','=',$player['member_id'])->first();
        $relatedTemp = Players::where('member_id','=',$player['member_id'])
                                ->where('players.id','!=', $id)
                                ->where('status','=','0')
                                ->where('twitter','=',null)
                                ->where('YTclipUrl',null)
                                ->inRandomOrder()
                                ->limit(12)
                                ->join('member','players.member_id','=','member.id')
                                ->select('players.title','players.date','players.status','players.id','member.name')
                                ->get()->toArray();
            $relatedNum = count($relatedTemp);
            if($relatedNum < 12){
                $temp = Players::where('players.id','!=', $id)
                                ->where('status','=','0')
                                ->where('twitter','=',null)
                                ->where('YTclipUrl',null)
                                ->inRandomOrder()
                                ->limit(12 -$relatedNum)
                                ->join('member','players.member_id','=','member.id')
                                ->select('players.title','players.date','players.status','players.id','member.name')
                                ->get()->toArray();
                                $relatedTemp = array_merge($relatedTemp,$temp);
            };

            $related=json_encode($relatedTemp);
            return view('SharePlayer',compact('id','player','currentMember','related'));
    }

    public function bookMark(Request $request)
    {

        $query = Players::query();
        $id = Auth::id();
        $query->join('bookmarks','players.id','=','bookmarks.player_id')
                            ->where('user_id','=',$id)
                            ->where('status','!=','3')
                            ->join('member','players.member_id','=','member.id');
        if($request->searchWord == null || $request->searchWord == ""){
            $search = "";
        }else{
            $search = $request->searchWord;
            $searchTemp = '%' . addcslashes($search, '%_\\') . '%';
            $query->where('players.title', 'like', $searchTemp);
        }

        $players = $query->orderBy('bookmarks.id','ASC')
                         ->select('players.*','member.name')
                         ->paginate(12);

        return Inertia::render('UserPlayer', [
            'Display' => 'BookMark',
            'routeType' => 'user.book',
            'players' => $players,
            'list_type' => 'BM',
            'searchWord' => $search,
        ]);
    }
    public function addedData(Request $request)
    {
        $user = Auth::user();
        $name = $user["name"];
        $query = Players::query();

        $query->where('createrHN','=',$name)
                ->join('member','players.member_id','=','member.id')
                ->where('status','!=','3');

        if($request->searchWord == null || $request->searchWord == ""){
            $search = "";
        }else{
            $search = $request->searchWord;
            $searchTemp = '%' . addcslashes($search, '%_\\') . '%';
            $query->where('players.title', 'like', $searchTemp);
        }

        $players = $query->orderBy('players.id','ASC')
                        ->select('players.*','member.name')
                        ->paginate(12);

        return Inertia::render('UserPlayer', [
            'Display' => 'YourData',
            'routeType' => 'user.added',
            'players' => $players,
            'list_type' => 'add',
            'searchWord' => $search,
        ]);
    }


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
    }
    public function addClip(Request $request){
        $temp = $request->all();
        var_dump($temp);
        DB::table('players')->insert($temp);
    }
    public function addYoutube(Request $request){
        $temp = $request->all();
        var_dump($temp);
        DB::table('players')->insert($temp);
    }
    public function addYTclip(Request $request){
        $temp = $request->all();
        var_dump($temp);
        DB::table('players')->insert($temp);
    }
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
    }
}
