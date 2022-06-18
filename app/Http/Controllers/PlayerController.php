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

            $spaceConversion = mb_convert_kana($search, 's');

            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


            foreach($wordArraySearched as $value) {
                $convertWord = mb_convert_kana($value,"KVaCs","utf-8");
                $optWord = '%' . addcslashes($convertWord, '%_\\') . '%';
                $query->where('search', 'like', $optWord);
            }

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
        $shareUrl = URL::full();
        $routeName = str("TopPage");

        return Inertia::render('TopPage', [
            'players' => $players,
            'searchWord' => $search,
            'sortType' => $sort,
            'order' => $order,
            'shareUrl' => $shareUrl,
            'routeName' => $routeName
        ]);
    }
    public function category(int $cate,Request $request)
    {
        $query = Players::query();
        $query->where('cate_id',$cate)->where('status','!=','3');
            
        if($request->searchWord == null || $request->searchWord == ""){
            $search = "";
        }else{
            $search = $request->searchWord;

            $spaceConversion = mb_convert_kana($search, 's');

            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


            foreach($wordArraySearched as $value) {
                $convertWord = mb_convert_kana($value,"KVaCs","utf-8");
                $optWord = '%' . addcslashes($convertWord, '%_\\') . '%';
                $query->where('search', 'like', $optWord);
            }

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
        $shareUrl = URL::full();
        $routeName = str("player.category");

        return Inertia::render('CategoryList', [
            'players' => $players,
            'searchWord' => $search,
            'sortType' => $sort,
            'order' => $order,
            'shareUrl' => $shareUrl,
            'routeName' => $routeName,
            'cate' => $cate
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

            $spaceConversion = mb_convert_kana($search, 's');

            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


            foreach($wordArraySearched as $value) {
                $convertWord = mb_convert_kana($value,"KVaCs","utf-8");
                $optWord = '%' . addcslashes($convertWord, '%_\\') . '%';
                $query->where('search', 'like', $optWord);
            }
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
        $shareUrl = URL::full();
        $directTW = null;

        return Inertia::render('PlayerList', [
            'currentMember' => $currentMember,
            'cate' => 0,
            'players' => $players,
            'searchWord' => $search,
            'sortType' => $sort,
            'order' => $order,
            'shareUrl' => $shareUrl,
            'directTW' => $directTW
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

            $spaceConversion = mb_convert_kana($search, 's');

            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


            foreach($wordArraySearched as $value) {
                $convertWord = mb_convert_kana($value,"KVaCs","utf-8");
                $optWord = '%' . addcslashes($convertWord, '%_\\') . '%';
                $query->where('search', 'like', $optWord);
            }
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
        $shareUrl = URL::full();
        $directTW = null;
        
        return Inertia::render('PlayerList', [
            'currentMember' => $currentMember,
            'cate' => $cate,
            'players' => $players,
            'searchWord' => $search,
            'sortType' => $sort,
            'order' => $order,
            'shareUrl' => $shareUrl,
            'directTW' => $directTW
        ]);
    }

    public function player($member,$id,Request $request)
    {
        $player = DB::table('players')->find($id);

        if($player == null){
            return redirect()->route('TopPage');
        }

        $currentMember = DB::table('member')->whereId($player->member_id)->first();

        if($player->twitter == null){
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
        }else{
            $related = DB::table('players')->where('member_id','=',$player->member_id)
                                ->where('players.id','!=', $id)
                                ->where('status','!=','3')
                                ->where('twitter','!=',null)
                                ->inRandomOrder()
                                ->limit(12)
                                ->join('member','players.member_id','=','member.id')
                                ->select('players.*','member.name')
                                ->get()->toArray();
            $relatedNum = count($related);
            if($relatedNum < 12){
                $temp = DB::table('players')->where('players.id','!=', $id)
                                ->where('status','!=','3')
                                ->where('twitter','!=',null)
                                ->inRandomOrder()
                                ->limit(12 -$relatedNum)
                                ->join('member','players.member_id','=','member.id')
                                ->select('players.*','member.name')
                                ->get()->toArray();
                $related = array_merge($related,$temp);
            };

            return Inertia::render('TWshowPage', [
                'currentMember' => $currentMember,
                'player' => $player,
                'id' => $id,
                'related' => $related,
            ]);
        }
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

        $players = $query->orderBy('bookmarks.id','DESC')
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

        $players = $query->orderBy('players.id','DESC')
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
    
    public function newData()
    {
        $players = DB::table('players')
                        ->where('status','!=','3')
                        ->where('member_id','1')
                        ->where('twitter','=',null)
                        ->where('YTclipUrl',null)
                        ->orderBy('id','DESC')->limit(10)->get();

        return response()->json(
            [
                'players' => $players,
            ]
        );
    }
}
