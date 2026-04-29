<?php

namespace App\Services;

class QrisService
{
    /**
     * Generate dynamic QRIS by injecting transaction amount
     */
    public static function generateDynamic($baseQris, $amount)
    {
        // 1. Remove old CRC (last 4 characters)
        $qrisWithoutCrc = substr($baseQris, 0, -4);
        
        // 2. We need to check if tag 54 (Transaction Amount) already exists.
        // For simplicity in standard QRIS generation, it usually doesn't exist in static QRIS, 
        // or we just remove it if it exists. 
        // Typically, we just insert Tag 54 before Tag 58 (Country Code) or before Tag 63 (CRC).
        // Let's find Tag 58 (Country Code)
        $tag58Index = strpos($qrisWithoutCrc, '5802ID');
        
        if ($tag58Index === false) {
            // If tag 58 not found, just insert before tag 63.
            $tag63Index = strpos($qrisWithoutCrc, '6304');
            $insertIndex = $tag63Index !== false ? $tag63Index : strlen($qrisWithoutCrc);
        } else {
            $insertIndex = $tag58Index;
        }
        
        // Format amount tag: '54' + length(amount) + amount
        $amountStr = (string) $amount;
        $amountLength = str_pad(strlen($amountStr), 2, '0', STR_PAD_LEFT);
        $tag54 = '54' . $amountLength . $amountStr;
        
        // 3. Inject Tag 54
        $part1 = substr($qrisWithoutCrc, 0, $insertIndex);
        $part2 = substr($qrisWithoutCrc, $insertIndex);
        
        // Ensure Tag 63 is at the end properly
        // Static QRIS usually ends with 6304.
        // We will just reconstruct the string.
        $modifiedQris = $part1 . $tag54 . $part2;
        
        // 4. Calculate new CRC16
        $newCrc = self::calculateCRC16($modifiedQris);
        
        return $modifiedQris . $newCrc;
    }

    /**
     * Calculate CRC16 CCITT
     */
    private static function calculateCRC16($str)
    {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($str); $i++) {
            $crc ^= (ord($str[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc = $crc << 1;
                }
            }
        }
        $hex = strtoupper(dechex($crc & 0xFFFF));
        return str_pad($hex, 4, '0', STR_PAD_LEFT);
    }
}
