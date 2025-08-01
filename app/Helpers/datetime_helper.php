<?php
//untuk mengetahui bulan bulan
if (!function_exists('bulan')) {
    function bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

//format tanggal yyyy-mm-dd
if (!function_exists('tgl_indo')) {
    function tgl_indo($tgl)
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);  //memecah variabel berdasarkan -
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun; //hasil akhir
    }
}

//format tanggal timestamp
if (!function_exists('tgl_indo_timestamp')) {

    function tgl_indo_timestamp($tgl)
    {
        $inttime = date('Y-m-d H:i:s', $tgl); //mengubah format menjadi tanggal biasa
        $tglBaru = explode(" ", $inttime); //memecah berdasarkan spaasi

        $tglBaru1 = $tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
        $tglBaru2 = $tglBaru[1]; //mendapatkan fotmat hh:ii:ss
        $tglBarua = explode("-", $tglBaru1); //lalu memecah variabel berdasarkan -

        $tgl = $tglBarua[2];
        $bln = $tglBarua[1];
        $thn = $tglBarua[0];

        $bln = bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
        $ubahTanggal = "$tgl $bln $thn | $tglBaru2 "; //hasil akhir tanggal

        return $ubahTanggal;
    }
}

if (!function_exists('date_convert')) {
    function date_convert($tanggal = null, $format = 'Y-m-d')
    {
        if ($tanggal == null) {
            $tanggal = date('Y-m-d');
        } else {
            $tanggal = date('Y-m-d H:i:s', strtotime($tanggal));
        }

        $hari = array(
            1 => 'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );
        
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split    = explode('-', $tanggal);
        $day = explode(' ', $split[2]);

        $num = date('N', strtotime($tanggal));

        return $data = (object)array(
            'dayName' => $hari[$num],
            'monthName' => $bulan[intval($split[1])],
            'month' => intval($split[1]),
            'year' => intval($split[0]),
            'day' => $day[0],
            'format' => date($format, strtotime($tanggal)),
            'default' => $day[0] . ' ' . $bulan[intval($split[1])] . ' ' . intval($split[0]),
            'time12' => date('H:i A', strtotime($tanggal)),
            'time12_s' => date('H:i:s A', strtotime($tanggal)),
            'time24' => date('H:i', strtotime($tanggal)),
            'time24_s' => date('H:i:s', strtotime($tanggal)),
            'time_s' => date('H:i:s', strtotime($tanggal)),
            'format_full_24' => $day[0] . ' ' . $bulan[intval($split[1])] . ' ' . intval($split[0]) . ', ' . date('H:i', strtotime($tanggal)),
            'format_full_12' => $day[0] . ' ' . $bulan[intval($split[1])] . ' ' . intval($split[0]) . ', ' . date('h:i A', strtotime($tanggal)),
        );
    }
}

if (!function_exists('convertMonth')) {
    function convertMonth($date, $format = 'Y-m-d')
    {
        $month = array(
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        );

        $dateArr = explode(' ', $date);
        @$dateArr[1] = @$month[@$dateArr[1]];
        $date = @("$dateArr[0]-$dateArr[1]-$dateArr[2] $dateArr[3]");

        return $data = (object)array(
            'datetime' => date($format . ' H:i:s', strtotime($date)),
            'date' => date($format . '', strtotime($date)),
            'time12_s' => date('H:i:s A', strtotime($date)),
            'time24_s' => date('H:i:s', strtotime($date)),
            'time24' => date('H:i', strtotime($date)),
            'time12' => date('H:i A', strtotime($date)),
        );
    }
}

if (!function_exists('getMonth')) {
    function getMonth()
    {
        $month = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        );

        return $month;
    }
}

if (!function_exists('getYear')) {
    function getYear()
    {
        //$year[""]=;
        for ($a=date("Y");$a>=2024;$a--)
            $year[$a] = $a; 

        return $year;
    }
}

if (!function_exists('to_mysql_date')) {
    /**
     * Konversi tanggal lokal (dd/mm/yyyy atau yyyy-mm-dd) ke format MySQL DATE (Y-m-d).
     *
     * @param string|null $input
     * @return string|null
     */
    function to_mysql_date(?string $input): ?string
    {
        if (!$input || !is_string($input)) {
            return null;
        }

        // Coba parsing dd/mm/yyyy
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $input, $matches)) {
            [$full, $day, $month, $year] = $matches;
            if (checkdate((int)$month, (int)$day, (int)$year)) {
                return (new \DateTime("$year-$month-$day"))->format('Y-m-d');
            } else {
                return null;
            }
        }

        // Coba parsing yyyy-mm-dd atau format umum lain
        if (strtotime($input)) {
            return (new \DateTime($input))->format('Y-m-d');
        }

        return null;
    }
}

if (!function_exists('to_local_date')) {
    /**
     * Konversi dari format MySQL DATE (Y-m-d) ke format lokal (d/m/Y).
     *
     * @param string|null $input
     * @return string|null
     */
    function to_local_date(?string $input): ?string
    {
        if (!$input || !is_string($input)) {
            return null;
        }

        try {
            $date = new \DateTime($input);
            return $date->format('d/m/Y'); // Format lokal Indonesia
        } catch (\Exception $e) {
            return null;
        }
    }
}
