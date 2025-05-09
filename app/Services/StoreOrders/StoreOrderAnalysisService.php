<?php

namespace App\Services\StoreOrders;

use App\Models\StoreWebsite;
use Spatie\SimpleExcel\SimpleExcelReader;

class StoreOrderAnalysisService
{
    /**
     * Reference store ID used for comparisons
     * 
     * @var int
     */
    protected const REFERENCE_STORE_ID = 1;

    /**
     * Process CSV file and identify violations
     *
     * @param string $path Path to the CSV file
     * @return array Array of formatted violation strings
     */
    public function processOrders(string $path): array
    {
        // Get store codes from database
        $stores = StoreWebsite::pluck('code', 'website_id')->toArray();
        
        // Get reference values from CSV (store_id = 1)
        $referenceValues = $this->getReferenceValues($path);
        
        // Initialize violations array
        $violations = [];
        
        // Read CSV with SimpleExcel
        SimpleExcelReader::create($path)
            ->useDelimiter(';')
            ->getRows()
            ->each(function (array $row) use ($referenceValues, $stores, &$violations) {
                // Skip reference store
                if ((int)$row['store_id'] === self::REFERENCE_STORE_ID) {
                    return;
                }
                
                $hour = (int)$row['hora'];
                $storeId = (int)$row['store_id'];
                $app = (int)$row['app'];
                $value = (float)$row['pedidos_minimos'];
                
                // Skip if store doesn't exist in our database
                if (!isset($stores[$storeId])) {
                    return;
                }
                
                // Get reference value for this hour and app
                $referenceKey = "{$hour}_{$app}";
                
                if (!isset($referenceValues[$referenceKey])) {
                    return;
                }
                
                $referenceValue = $referenceValues[$referenceKey];
                $halfReferenceValue = $referenceValue / 2;
                
                // Check if value is equal to or less than half of reference value
                if ($value <= $halfReferenceValue) {
                    // Format violation string
                    $storeCode = $stores[$storeId];
                    $violations[] = "store {$storeCode}, app={$app}, valor = {$value}";
                }
            });
        
        return $violations;
    }
    
    /**
     * Get reference values from CSV (store_id = 1)
     *
     * @param string $path Path to the CSV file
     * @return array Array of reference values indexed by hour_app
     */
    private function getReferenceValues(string $path): array
    {
        $referenceValues = [];
        
        SimpleExcelReader::create($path)
            ->useDelimiter(';')
            ->getRows()
            ->each(function (array $row) use (&$referenceValues) {
                if ((int)$row['store_id'] === self::REFERENCE_STORE_ID) {
                    $hour = (int)$row['hora'];
                    $app = (int)$row['app'];
                    $value = (float)$row['pedidos_minimos'];
                    
                    // Create a unique key for each hour and app combination
                    $key = "{$hour}_{$app}";
                    $referenceValues[$key] = $value;
                }
            });
        
        return $referenceValues;
    }
}
