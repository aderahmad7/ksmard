<?php

if (!function_exists('toDecimal')) {
    function toDecimal($val)
    {
        $val = preg_replace("/[^0-9.,]/", "", $val);
        $val = str_replace(".", "", $val); // hapus pemisah ribuan
        $val = str_replace(",", ".", $val); // ubah desimal jadi titik
        return $val;
    }

}
if (!function_exists('safe_div')) {
    /**
     * Fungsi pembagian aman
     */
    function safe_div($numerator, $denominator, $precision = 2)
    {
        return $denominator == 0 ? 0 : round($numerator / $denominator, $precision);
    }
}
