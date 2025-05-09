<?php

namespace App\Console\Commands;

use App\Services\Nagios\AlertService;
use App\Services\StoreOrders\StoreOrderAnalysisService;
use Illuminate\Console\Command;

class CheckStoreOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check store orders and generate Nagios alert';

    /**
     * Execute the console command.
     */
    public function handle(AlertService $alertService, StoreOrderAnalysisService $analysisService)
    {
        $csvPath = storage_path('app/data/datos.csv');
        
        // Check if CSV file exists
        if (!file_exists($csvPath)) {
            $this->error('CSV file not found!');
            return 1;
        }
        
        // Process CSV and get violations using the service
        $violations = $analysisService->processOrders($csvPath);
        
        // Generate Nagios output
        $alertService->generateOutput($violations);
        
        return 0;
    }
}
