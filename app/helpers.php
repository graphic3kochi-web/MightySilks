<?php

if (! function_exists('inr')) {
    /** "₹ 1,25,000.00": rupees with Indian digit grouping, as the storefront prints prices. */
    function inr(float|string|null $value, bool $paise = true): string
    {
        [$int, $dec] = explode('.', number_format((float) $value, 2, '.', ''));
        $negative = str_starts_with($int, '-');
        $int = ltrim($int, '-');
        $last3 = substr($int, -3);
        $rest = substr($int, 0, -3);
        $grouped = ($rest !== '' ? preg_replace('/\B(?=(\d{2})+$)/', ',', $rest).',' : '').$last3;

        return ($negative ? '−' : '').'₹ '.$grouped.($paise ? ".$dec" : '');
    }
}
