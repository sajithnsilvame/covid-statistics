<?php

namespace App\Console\Commands;

use App\Models\CovidData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchCovidData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch COVID-19 data from the Health Promotion Bureau API and store it in the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Make an API request to the Health Promotion Bureau API
        $response = Http::get('https://hpb.health.gov.lk/api/get-current-statistical');

        // Check if the API request was successful
        if ($response->ok()) {
            $data = $response->json();

            // Extract the necessary data from the API response
            $totalCases = $data['data']['local_total_cases'];
            $deaths = $data['data']['local_deaths'];
            $recoveries = $data['data']['local_recovered'];

            // Save the data to the database
            CovidData::create([
                'total_cases' => $totalCases,
                'deaths' => $deaths,
                'recoveries' => $recoveries,
                // Add more fields as needed based on the API response
            ]);

            // Output success message
            $this->info('COVID-19 data fetched and stored successfully!');
        } else {
            // Output error message
            $this->error('Failed to fetch COVID-19 data from the API.');
        }

    }
}
