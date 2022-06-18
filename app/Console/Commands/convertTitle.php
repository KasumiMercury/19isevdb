<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class convertTitle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:convertTitle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'convert title to search';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = DB::table('players')->where('search',null)->get();
        $num = count($data);
        
        for($i = 0; $i < $num; $i++){
            $tempData = json_decode(json_encode($data[$i]), true);
            $kana = mb_convert_kana($tempData["title"],"KVaCs","utf-8");
            DB::table('players')->where('id', $tempData["id"])
                                                    ->update([
                                                        'search' => $kana,
                                                    ]);
        }
    }
}
