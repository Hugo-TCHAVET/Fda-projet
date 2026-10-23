<?php

namespace App\Support;

use DateTimeImmutable;

/**
 * Converts the free-text amounts, counts and dates of legacy rows into typed values, or rejects them.
 */
class Normalisation
{
    // A separator is accepted only between groups of three digits: "250000.00" must not become 25 000 000.
    public static function montant(?string $valeur): ?int
    {
        $valeur = trim((string) $valeur);
        if ($valeur === '') {
            return null;
        }

        if (!preg_match('/^\d+$|^\d{1,3}([\s\x{00A0}\x{202F}.,]\d{3})+$/u', $valeur)) {
            throw new ValeurInvalide("Montant entier en FCFA attendu : « {$valeur} »");
        }

        return (int) preg_replace('/\D/', '', $valeur);
    }

    public static function entier(?string $valeur, int $maximum = PHP_INT_MAX): ?int
    {
        $valeur = trim((string) $valeur);
        if ($valeur === '') {
            return null;
        }

        if (!ctype_digit($valeur)) {
            throw new ValeurInvalide("Nombre entier attendu : « {$valeur} »");
        }

        if (strlen(ltrim($valeur, '0')) > strlen((string) $maximum) || (int) $valeur > $maximum) {
            throw new ValeurInvalide("Nombre supérieur au maximum {$maximum} : « {$valeur} »");
        }

        return (int) $valeur;
    }

    public static function date(?string $valeur): ?string
    {
        $valeur = trim((string) $valeur);
        if ($valeur === '') {
            return null;
        }

        foreach (['Y-m-d', 'd/m/Y'] as $format) {
            $date = DateTimeImmutable::createFromFormat('!'.$format, $valeur);
            if ($date && $date->format($format) === $valeur) {
                return $date->format('Y-m-d');
            }
        }

        throw new ValeurInvalide("Date non reconnue : « {$valeur} »");
    }
}
