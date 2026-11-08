<?php

namespace App\Services;

class PhoneNumberService
{
    /** Retourne le numéro en chiffres au format international (ex. 221771234567), ou null s'il est invalide. */
    public static function normalize(?string $raw): ?string
    {
        if ($raw === null || trim($raw) === '') {
            return null;
        }

        $raw = trim($raw);
        $digits = preg_replace('/\D+/', '', $raw);
        $international = str_starts_with($raw, '+') || str_starts_with($raw, '00');

        if (str_starts_with($raw, '00')) {
            $digits = substr($digits, 2);
        }

        if (! $international) {
            if (strlen($digits) === 9) {
                return '221' . $digits;
            }
            if (strlen($digits) === 12 && str_starts_with($digits, '221')) {
                return $digits;
            }
            return null;
        }

        if (str_starts_with($digits, '221')) {
            return strlen($digits) === 12 ? $digits : null;
        }

        return (strlen($digits) >= 8 && strlen($digits) <= 15) ? $digits : null;
    }

    /** Affichage lisible : +221 77 123 45 67 */
    public static function format(?string $number): string
    {
        if (! $number) {
            return '';
        }

        if (str_starts_with($number, '221') && strlen($number) === 12) {
            $n = substr($number, 3);
            return '+221 ' . substr($n, 0, 2) . ' ' . substr($n, 2, 3) . ' '
                . substr($n, 5, 2) . ' ' . substr($n, 7, 2);
        }

        return '+' . $number;
    }
}