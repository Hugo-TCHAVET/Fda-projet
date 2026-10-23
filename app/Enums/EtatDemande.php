<?php

namespace App\Enums;

enum EtatDemande: string
{
    case EnAttente = 'en_attente';
    case Transmise = 'transmise';
    case Suspendue = 'suspendue';
    case Approuvee = 'approuvee';

    public function libelle(): string
    {
        return match ($this) {
            self::EnAttente => 'En attente',
            self::Transmise => 'En cours de traitement',
            self::Suspendue => 'Suspendue',
            self::Approuvee => 'Approuvée',
        };
    }
}
