<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import SIPA Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        $adjustments = [];

        if (($handle = fopen($this->argument('file'), "r")) !== FALSE) {
            $row = 1;

            while (($col = fgetcsv($handle, null, ',')) !== FALSE) {

                if($row === 1) {
                    $row++;
                    continue;
                }

                $adjustment = [
                    'name' => trim($col[4]),
                    'hemo' => $this->bool($col[0]),
                    'pseudo' => $this->bool($col[1]),
                    'obesity' => $this->bool($col[2]),
                    'patientType' => trim($col[3]),
                    'route' => $col[7],
                    'bmiMin' => intval($col[9]),
                    'bmiMax' => intval($col[10]),
                    'weightType' => trim($col[11]),
                    'weightMin' => intval($col[12]),
                    'weightMax' => intval($col[13]),
                    'ageMin' => intval($col[14]),
                    'ageMax' => intval($col[15]),
                    'crClMin' => intval($col[16]),
                    'crClMax' => intval($col[17]),
                    'dailyDose' => $this->bool($col[19]),
                    'postDialysis' => $this->bool($col[20]),
                    'loadingDose' => $this->bool($col[21]),
                    'nbLoadingDose' => $this->bool($col[22]),
                    'doseUnit' => trim($col[23]),
                    'doseMin' => floatval($col[24]),
                    'doseMax' => floatval($col[25]),
                    'freqMin' => intval($col[26]),
                    'freqMax' => intval($col[27]),
                    'minDailyDose' => floatval($col[28]) ?: null,
                    'maxDailyDose' => floatval($col[29]) ?: null,
                    'comment' => trim($col[31])
                ];

                $adjustments[] = $adjustment;

                $row++;
            }

            fclose($handle);
        }

        // Write file
        $fp = fopen('resources/js/data.json', 'w');
        fwrite($fp, json_encode($adjustments));
        fclose($fp);
    }

    public function bool($boolString)
    {
        return $boolString === "TRUE";
    }
}
