<?php

namespace App\Console\Commands;

use App\Models\Child;
use App\Models\Configuration;
use App\Models\Presence;
use Illuminate\Console\Command;
use DB;
use Log;

class GenerateAbsence extends Command
{
    protected $signature = 'generate:absence';

    protected $description = 'Generate absence';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Generating absence');

        $end_time = Configuration::getValue('end_time');
        $check_in = time();
        $date = date('Y-m-d', $check_in);
        $day = date('w', $check_in);
        DB::beginTransaction();
        try {
            if(date('H:i:s') >= $end_time && $day == 0) { // only Sunday
                Log::info('Starting...');
                $child = Child::orderBy('name')->get(['id']);

                $bar = $this->output->createProgressBar(count($child));
                $bar->start();

                foreach($child as $c) {
                    $child_id = $c->id;
                    $model = Presence::where(function($q) use($date, $child_id) {
                        $q->whereRaw("FROM_UNIXTIME(check_in, '%Y-%m-%d') = '$date'");
                        $q->where('child_id', $child_id);
                    })->count();

                    $bar->advance();

                    if($model == 0) {
                        Presence::create([
                            'child_id' => $child_id,
                            'check_in' => strtotime($date.' 00:00:00'),
                            'month' => date('n'),
                            'year' => date('Y')
                        ]);
                    }
                }

                $bar->finish();
                Log::info('Finish');
            }
            DB::commit();
            Log::info('Generated absence');
        } catch(\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            Log::error('Error generate absence: '.$ex->getMessage());
        }
    }
}
