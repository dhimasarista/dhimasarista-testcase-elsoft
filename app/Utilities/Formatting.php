<?php

namespace App\Utilities;

class Formatting
{
    public static function capitalize($input)
    {
        if (empty($input) || trim($input) === '') {
            return $input;
        }

        // Memecah string menjadi kata-kata berdasarkan spasi
        $words = explode(' ', trim($input));

        // Memproses setiap kata untuk membuat huruf pertama menjadi besar
        foreach ($words as $key => $word) {
            if (strlen($word) > 0) {
                $words[$key] = ucfirst(strtolower($word));
            }
        }

        // Menggabungkan kata-kata kembali dengan spasi
        return implode(' ', $words);
    }

    public static function formatRupiah($amount)
    {
        // Memformat jumlah menjadi format Rupiah
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public static function formatUrl($params)
    {
        $queryString = http_build_query($params);
        return '?' . str_replace('%20', '+', $queryString);
    }

    public static function formatDateLong($date)
    {
        // Memformat tanggal menjadi format dd MMM yyyy
        return date_format(date_create($date), 'd M Y');
    }

    public static function formatDateShort($date)
    {
        // Memformat tanggal menjadi format dd/MM/yyyy
        return date_format(date_create($date), 'd/m/Y');
    }
}

// Contoh penggunaan
// $queryParams = [
//     'code' => '500',
//     'title' => 'Internal Server Error',
//     'message' => 'We will fix it as soon as possible...'
// ];

// $formattedUrl = Formatting::formatUrl($queryParams);
