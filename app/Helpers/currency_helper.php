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
