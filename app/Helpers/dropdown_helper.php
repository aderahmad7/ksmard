<?php

if (!function_exists('getKategoriTbs')) {
    function getKategoriTbs($jenis=null)
    {

        $tbs = array(
            "cpo" => 'CPO',
            "inti" => 'KERNEL'
        );
        
        return ($jenis==null?$tbs:$tbs[$jenis]);
    }
}

if (!function_exists('getKategoriPenjualan')) {
    function getKategoriPenjualan()
    {
        $tbs = array(
            0 => 'Lokal',
            1 => 'Ekspor'
        );

        return $tbs;
    }
}

if (!function_exists('getKategoriProduksi')) {
    function getKategoriProduksi()
    {
        $tbs = array(
            "TBS INTI" => 'TBS INTI',
            "TBS PLASMA" => 'TBS PLASMA',
            "TBS Kemitraan Permanen" => 'TBS Kemitraan Permanen',
            "TBS Luar" => 'TBS Luar'
        );

        return $tbs;
    }
}

