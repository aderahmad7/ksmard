<?php

namespace App\Validation;

class CustomRules
{
    /**
     * Validasi apakah tanggal berada di bulan sebelum tanggal acuan.
     *
     * @param string $date      Tanggal yang diinput (format YYYY-MM-DD)
     * @param string $reference Tanggal acuan (format YYYY-MM-DD)
     * @param array  $data      Semua data input
     */
    public function is_last_month(string $date, string $reference = '', array $data = []): bool
    {
        if (!strtotime($date) || !strtotime($reference)) {
            return false;
        }

        $inputDate = new \DateTime($date);
        $refDate = new \DateTime($reference);
        $prevMonth = (clone $refDate)->modify('-1 month');

        return $inputDate->format('Y-m') === $prevMonth->format('Y-m');
    }
}
