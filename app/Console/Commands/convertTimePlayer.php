<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class convertTimePlayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:convertTime:player';

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
        $data = DB::table('players')->get();
        $num = count($data);
        
        for($i = 0; $i < $num; $i++){
            $tempData = json_decode(json_encode($data[$i]), true);
            $dateFormat = date('Y-m-d H:i:s', strtotime($tempData["date"]));
            $createFormat = date('Y-m-d H:i:s', strtotime($tempData["created_at"]));
            $updateFormat = date('Y-m-d H:i:s');
            DB::table('players')->where('id', $tempData["id"])
                                                    ->update([
                                                        'date' => $dateFormat,
                                                        'created_at' => $createFormat,
                                                        'updated_at' => $updateFormat,
                                                    ]);
        }
    }
}
