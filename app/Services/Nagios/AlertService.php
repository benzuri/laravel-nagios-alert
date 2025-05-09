<?php

namespace App\Services\Nagios;

class AlertService
{
    /**
     * Nagios status codes
     */
    const STATUS_OK = 0;
    const STATUS_WARNING = 1;
    const STATUS_CRITICAL = 2;
    const STATUS_UNKNOWN = 3;
    
    /**
     * Default alert message
     */
    const DEFAULT_MESSAGE = 'Incidencia ventas horas';
    
    /**
     * Generate Nagios output for the given violations
     *
     * @param array $violations Array of violations to report
     * @return void
     */
    public function generateOutput(array $violations): void
    {
        // Always use WARNING status as specified in requirements
        $status = self::STATUS_WARNING;
        
        // Start with the status text and message
        $output = $this->getStatusText($status) . " - " . self::DEFAULT_MESSAGE;
        
        // Add violations if any exist
        if (!empty($violations)) {
            $output .= " | " . implode(" | ", $violations);
        }
        
        // Output the formatted string
        echo $output;
        
        // Exit with the appropriate status code
        exit($status);
    }
    
    /**
     * Get the text representation of a status code
     *
     * @param int $status Nagios status code
     * @return string Text representation of the status
     */
    private function getStatusText(int $status): string
    {
        return match ($status) {
            self::STATUS_OK => 'OK',
            self::STATUS_WARNING => 'WARNING',
            self::STATUS_CRITICAL => 'CRITICAL',
            self::STATUS_UNKNOWN => 'UNKNOWN',
            default => 'UNKNOWN',
        };
    }
    
    /**
     * Format a single violation for Nagios output
     *
     * @param string $storeCode Store code from the database
     * @param int $app App identifier (0 or 1)
     * @param float $value The value that violated the condition
     * @return string Formatted violation string
     */
    public function formatViolation(string $storeCode, int $app, float $value): string
    {
        return "store {$storeCode}, app={$app}, valor = {$value}";
    }
}
