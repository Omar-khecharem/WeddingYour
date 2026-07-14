<?php
/**
 * Format Helper
 * 
 * Data formatting utilities for currency, dates, numbers,
 * text manipulation, and localized output.
 *
 * @package App\Helpers
 */

namespace App\Helpers;

class Format
{
    /**
     * Format currency amount
     */
    public static function currency(float $amount, string $currency = null): string
    {
        $symbol = $currency ?? APP_CURRENCY;
        return $symbol . ' ' . number_format($amount, 2);
    }

    /**
     * Format currency without decimals for whole numbers
     */
    public static function currencySmart(float $amount): string
    {
        if (fmod($amount, 1) == 0) {
            return APP_CURRENCY . ' ' . number_format($amount);
        }
        return self::currency($amount);
    }

    /**
     * Format percentage
     */
    public static function percentage(float $value, int $decimals = 0): string
    {
        return number_format($value, $decimals) . '%';
    }

    /**
     * Format number with abbreviation (e.g., 1K, 1M)
     */
    public static function numberAbbr(int $number): string
    {
        if ($number >= 10000000) return number_format($number / 10000000, 1) . 'Cr';
        if ($number >= 100000) return number_format($number / 100000, 1) . 'L';
        if ($number >= 1000) return number_format($number / 1000, 1) . 'K';
        return (string)$number;
    }

    /**
     * Format date
     */
    public static function date(string $date, string $format = 'd M, Y'): string
    {
        if (!$date || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
            return '';
        }
        return date($format, strtotime($date));
    }

    /**
     * Format datetime
     */
    public static function datetime(string $date): string
    {
        return self::date($date, 'd M Y, h:i A');
    }

    /**
     * Get relative time
     */
    public static function timeAgo(string $date): string
    {
        $timestamp = strtotime($date);
        $diff = time() - $timestamp;

        $intervals = [
            31536000 => ['year', 'years'],
            2592000 => ['month', 'months'],
            604800 => ['week', 'weeks'],
            86400 => ['day', 'days'],
            3600 => ['hour', 'hours'],
            60 => ['minute', 'minutes'],
            1 => ['second', 'seconds']
        ];

        foreach ($intervals as $seconds => $labels) {
            $count = floor($diff / $seconds);
            if ($count >= 1) {
                $label = $count > 1 ? $labels[1] : $labels[0];
                return "{$count} {$label} ago";
            }
        }
        return 'just now';
    }

    /**
     * Truncate text
     */
    public static function truncate(string $text, int $length = 100, string $ending = '...'): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        $truncated = mb_substr($text, 0, $length - mb_strlen($ending));
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }
        return $truncated . $ending;
    }

    /**
     * Strip HTML and truncate
     */
    public static function plainText(string $html, int $length = 150): string
    {
        $text = strip_tags($html);
        $text = preg_replace('/\s+/', ' ', $text);
        return self::truncate(trim($text), $length);
    }

    /**
     * Generate excerpt with context around search term
     */
    public static function excerpt(string $text, string $term, int $radius = 50): string
    {
        $pos = mb_stripos($text, $term);
        if ($pos === false) {
            return self::truncate($text, $radius * 2);
        }

        $start = max(0, $pos - $radius);
        $length = mb_strlen($term) + ($radius * 2);
        $excerpt = mb_substr($text, $start, $length);

        if ($start > 0) $excerpt = '...' . $excerpt;
        if (($start + $length) < mb_strlen($text)) $excerpt .= '...';

        return $excerpt;
    }

    /**
     * Format phone number
     */
    public static function phone(string $phone): string
    {
        $phone = preg_replace('/[^\d+]/', '', $phone);
        if (strlen($phone) === 12 && substr($phone, 0, 2) === '91') {
            return '+91 ' . substr($phone, 2, 5) . ' ' . substr($phone, 7);
        }
        if (strlen($phone) === 10) {
            return substr($phone, 0, 5) . ' ' . substr($phone, 5);
        }
        return $phone;
    }

    /**
     * Mask email address
     */
    public static function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1] ?? '';

        $masked = substr($name, 0, 2) . str_repeat('*', max(0, strlen($name) - 2));
        return $masked . '@' . $domain;
    }

    /**
     * Format address as single line
     */
    public static function address(array $address): string
    {
        $parts = array_filter([
            $address['address_line1'] ?? '',
            $address['address_line2'] ?? '',
            $address['city'] ?? '',
            $address['state'] ?? '',
            $address['pincode'] ?? ''
        ]);
        return implode(', ', $parts);
    }

    /**
     * Format bytes to human readable
     */
    public static function fileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Convert number to words (Indian system)
     */
    public static function numberToWords(int $number): string
    {
        $words = [
            0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
            18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];

        if ($number < 100) {
            if (isset($words[$number])) return $words[$number];
            return $words[$number - $number % 10] . ' ' . $words[$number % 10];
        }

        if ($number < 1000) {
            return $words[floor($number / 100)] . ' Hundred' . ($number % 100 ? ' ' . self::numberToWords($number % 100) : '');
        }

        if ($number < 100000) {
            return self::numberToWords(floor($number / 1000)) . ' Thousand' . ($number % 1000 ? ' ' . self::numberToWords($number % 1000) : '');
        }

        if ($number < 10000000) {
            return self::numberToWords(floor($number / 100000)) . ' Lakh' . ($number % 100000 ? ' ' . self::numberToWords($number % 100000) : '');
        }

        return self::numberToWords(floor($number / 10000000)) . ' Crore' . ($number % 10000000 ? ' ' . self::numberToWords($number % 10000000) : '');
    }

    /**
     * Pluralize word
     */
    public static function pluralize(string $word, int $count): string
    {
        if ($count === 1) return $word;
        $irregulars = ['child' => 'children', 'person' => 'people', 'man' => 'men', 'woman' => 'women'];
        if (isset($irregulars[$word])) return $irregulars[$word];
        if (in_array(substr($word, -1), ['s', 'x', 'z']) || in_array(substr($word, -2), ['sh', 'ch'])) {
            return $word . 'es';
        }
        if (substr($word, -1) === 'y' && !in_array(substr($word, -2, 1), ['a', 'e', 'i', 'o', 'u'])) {
            return substr($word, 0, -1) . 'ies';
        }
        return $word . 's';
    }
}
