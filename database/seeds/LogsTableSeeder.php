<?php

use Illuminate\Database\Seeder;

class LogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $d = [];
        $faker = Faker\Factory::create();
        $jam = 7;

        $detik = 1;
        // $tstamp = now();
        $tstamp = date('Y-m-d H:i:s');
        for ($i = 0; $i <= 8000; $i++) {
            $tstamp = date('Y-m-d H:i:s');
            // $tstamp = $tstamp->addMinute(1);
            // $tstamp = $tstamp->addMinute(1);
            $Suhu = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'Suhu',
                'created_at' => Carbon\Carbon::now(2),
            ];

            $DHL = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'DHL',
                'created_at' => Carbon\Carbon::now(),
            ];

            $TDS = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'TDS',
                'created_at' => Carbon\Carbon::now(),
            ];

            $Salinitas = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'Salinitas',
                'created_at' => Carbon\Carbon::now(),
            ];

            $DO = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'DO',
                'created_at' => Carbon\Carbon::now(),
            ];

            $PH = [
                'tstamp' => $tstamp,
                'value' => rand(0, 14),
                'tag_name' => 'PH',
                'created_at' => Carbon\Carbon::now(),
            ];

            $Turbidity = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'Turbidity',
                'created_at' => Carbon\Carbon::now(),
            ];

            $Kedalaman = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'Kedalaman',
                'created_at' => Carbon\Carbon::now(),
            ];

            $SwSG = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'SwSG',
                'created_at' => Carbon\Carbon::now(),
            ];

            $Nitrat = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'Nitrat',
                'created_at' => Carbon\Carbon::now(),
            ];

            $Nitrit = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'Nitrit',
                'created_at' => Carbon\Carbon::now(),
            ];

            $Amonia = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'Amonia',
                'created_at' => Carbon\Carbon::now(),
            ];

            $ORP = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'ORP',
                'created_at' => Carbon\Carbon::now(),
            ];

            $COD = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'COD',
                'created_at' => Carbon\Carbon::now(),
            ];

            $BOD = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'BOD',
                'created_at' => Carbon\Carbon::now(),
            ];

            $COD = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'COD',
                'tag_name' => 'COD',
                'created_at' => Carbon\Carbon::now(),
            ];

            $TSS = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'TSS',
                'created_at' => Carbon\Carbon::now(),
            ];

            $NH3N = [
                'tstamp' => $tstamp,
                'value' => rand(0, 100),
                'tag_name' => 'NH3N',
                'created_at' => Carbon\Carbon::now(),
            ];

            $debit = [
                'tstamp' => $tstamp,
                'value' => rand(1000, 2000),
                'tag_name' => 'Debit',
                'created_at' => Carbon\Carbon::now(),
            ];

            DB::table('logs')->insert($Suhu);
            DB::table('logs')->insert($DHL);
            DB::table('logs')->insert($TDS);
            DB::table('logs')->insert($Salinitas);
            DB::table('logs')->insert($DO);
            DB::table('logs')->insert($PH);
            DB::table('logs')->insert($Turbidity);
            DB::table('logs')->insert($Kedalaman);
            DB::table('logs')->insert($SwSG);
            DB::table('logs')->insert($Nitrat);
            DB::table('logs')->insert($Nitrit);
            DB::table('logs')->insert($Amonia);
            DB::table('logs')->insert($ORP);
            DB::table('logs')->insert($BOD);
            DB::table('logs')->insert($COD);
            DB::table('logs')->insert($TSS);
            DB::table('logs')->insert($NH3N);
            DB::table('logs')->insert($debit);
            sleep(1);
        }
    }

}
