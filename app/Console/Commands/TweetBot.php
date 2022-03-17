<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Noweh\TwitterApi\Client;
use Illuminate\Support\Facades\DB;

class TweetBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:TweetBot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拡散ツイート';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = [
            'account_id' => 1234567,
            'consumer_key' => config('twitter.api_key'),
            'consumer_secret' => config('twitter.secret_key'),
            'bearer_token' => config('twitter.bearer_token'),
            'access_token' => config('twitter.access_token'),
            'access_token_secret' => config('twitter.access_token_secret')
        ];
        $client = new Client($settings);

        $randomData = DB::table('players')->where('status','0')->where('twitter',null)->where('YTclipUrl',null)->inRandomOrder()->first();
        $dataMember = DB::table('member')->where('id',$randomData->member_id)->first();
        $dataCategory = DB::table('category')->where('id',$randomData->cate_id)->first();
        $DBname = "非公式".$dataMember->display."DB No.".$randomData->id." ".$dataCategory->title."カテゴリー";
        $DBtitle = '"'.$randomData->title.'"';
        $DBurl = "https://isevdb.sakura.ne.jp/".$dataMember->name."/share/".$randomData->id;
        $tag = "#非公式いせぶいDB"." #非公式".$dataMember->display."DB";
        $tag2 = "#Vtuber #VTuberを発掘せよ #Vtuberお探しですか";
        $tweetArray = [$DBname,$DBtitle,$DBurl,$tag,$tag2];
        $tweetText =  join("\n",$tweetArray);
        $TWreturn = $client->tweet()->performRequest('POST', ['text' => $tweetText]);

        $originURL = "元動画：https://www.youtube.com/watch?v=".$randomData->VideoID;
        $memberName = "いせぶい所属　".$dataMember->display."さん　チャンネル：https://www.youtube.com/channel/".$dataMember->ChannelID;

        $threadArray = [$originURL,$memberName];
        $threadText = join("\n",$threadArray);
        $TWinfo = json_decode(json_encode($TWreturn), true);
        $replyId = ["in_reply_to_tweet_id"=> $TWinfo["data"]["id"]];
        $TRreturn = $client->tweet()->performRequest('POST', ['text' => $threadText,'reply'=>$replyId]);
    }
}
