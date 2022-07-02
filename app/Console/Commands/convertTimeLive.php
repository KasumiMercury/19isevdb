<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class convertTimeLive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:convertTime:live';

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
        $data = DB::connection('mysql_liveinfo')->table('stock')->whereNotNull('schedule')->get();
        $num = count($data);
        
        for($i = 0; $i < $num; $i++){
            $tempData = json_decode(json_encode($data[$i]), true);
            $format = date('Y-m-d H:i:s', strtotime($tempData["schedule"]));
            DB::connection('mysql_liveinfo')->table('stock')->where('id', $tempData["id"])
                                                    ->update([
                                                        'schedule' => $format,
                                                    ]);
        }
    }
}
