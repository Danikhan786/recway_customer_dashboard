<?php
use Illuminate\Support\Facades\DB;

if (!function_exists('getTranslatedText')) {
    function getTranslatedText($key, $lang = null)
    {
        $lang = $lang ?? app()->getLocale();
        
        $record = DB::table('customer_languages')->where('keys', $key)->first();

        if (!$record) {
            return 'N/A';
        }

        $translations = json_decode($record->value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $key;
        }

        return $translations[$lang] ?? 'N/A';
    }
}