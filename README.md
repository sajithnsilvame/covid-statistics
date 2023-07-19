<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## PROJECT DESCRIPTION
To fetch data from the Health Promotion Bureau API and store it in the database, you can create a custom Artisan command in Laravel. This command can be scheduled to run periodically using a cron job. Here's a step-by-step guide on how to achieve this:

#### Step 1: Create a new Artisan Command
1. Open a terminal window and navigate to your Laravel project directory.
2. Use the following Artisan command to create a new custom command:


```bash
  php artisan make:command FetchCovidData

```

This will create a new file named FetchCovidData.php inside the **app/Console/Commands** directory.

#### Step 2: Define the Command Signature and Description
In the **FetchCovidData.php** file, update the **$signature** and **$description** properties to provide information about the command:

```bash
protected $signature = 'covid:fetch';
protected $description = 'Fetch COVID-19 data from the Health Promotion Bureau API and store it in the database.';

```

#### Step 3: Implement the Command Logic
Within the **handle()** method of the **FetchCovidData** class, you can make the API request to the Health Promotion Bureau API and save the data to the database. Here's an example of how you can do this:

```bash
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CovidData;

class FetchCovidData extends Command
{
    protected $signature = 'covid:fetch';
    protected $description = 'Fetch COVID-19 data from the Health Promotion Bureau API and store it in the database.';

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

```

#### Step 4: Schedule the Command
Open the **app/Console/Kernel.php** file, and inside the **schedule()** method, add the following line to schedule the **covid:fetch** command to run every hour (you can adjust the frequency as needed):

```bash
protected function schedule(Schedule $schedule)
{
    $schedule->command('covid:fetch')->hourly();
}

```

#### Step 5: Run the Scheduled Command
To test the command and ensure it's working correctly, you can run the following Artisan command manually:

```bash
php artisan covid:fetch

```

This will fetch the latest COVID-19 data from the API and store it in the database. To automate this process, you can set up the cron job to run the scheduled tasks in Laravel. The frequency of the cron job depends on your requirements, but you can set it to run every hour, as shown in the scheduling code above.
