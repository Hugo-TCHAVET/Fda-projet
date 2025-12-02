<?php

namespace App\Exports;

use App\Models\Demande;
use App\Models\Brache;
use App\Models\Corp;
use App\Models\Metier;
use App\Models\Departement;
use App\Models\Commune;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DemandesApprouveesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Demande::where('valide', 2)
            ->where('buget_prevu', '!=', null)
            ->where('archivee', false)
            ->orderBy('date_approbation', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Structure',
            'Service',
            'Type demandeur',
            'Branche',
            'Corps',
            'Métier',
            'Nom',
            'Prénom',
            'Sexe',
            'IFU',
            'Contact',
            'Titre activité',
            'Objectif activité',
            'Début activité',
            'Fin activité',
            'Durée activité',
            'Département',
            'Commune',
            'Lieux',
            'Personnes prévues',
            'Budget de l\'activité',
            'Appui financier accordé',
            'Date d\'approbation',
            'Statut',
        ];
    }

    public function map($demande): array
    {
        // Récupérer les noms des relations
        $brancheNom = null;
        if ($demande->branche) {
            $branche = Brache::find($demande->branche);
            $brancheNom = $branche ? $branche->nom : null;
        }

        $corpsNom = null;
        if ($demande->corps) {
            $corps = Corp::find($demande->corps);
            $corpsNom = $corps ? $corps->nom : null;
        }

        $metierNom = null;
        if ($demande->metier) {
            $metier = Metier::find($demande->metier);
            $metierNom = $metier ? $metier->nom : null;
        }

        $departementNom = null;
        if ($demande->departement) {
            $departement = Departement::find($demande->departement);
            $departementNom = $departement ? $departement->nom : null;
        }

        $communeNom = null;
        if ($demande->commune) {
            $commune = Commune::find($demande->commune);
            $communeNom = $commune ? $commune->nom : null;
        }

        // Personnalisation du type de demande
        $typeDemandeLibelle = match ($demande->type_demande) {
            'professionnel' => 'Association / Organisations professionnelles',
            'structure' => 'Structures formelles',
            'ONG' => 'Organisations Non Gouvernementales (ONG)',
            default => $demande->type_demande ?? 'N/A',
        };

        // Personnalisation du service
        $serviceLibelle = match ($demande->service) {
            'Assistance' => 'Activités de Promotion',
            'Formation' => 'Formation / Renforcement de capacités',
            default => $demande->service ?? 'N/A',
        };

        return [
            $demande->structure,
            $serviceLibelle,
            $typeDemandeLibelle,
            $brancheNom ?? 'N/A',
            $corpsNom ?? 'N/A',
            $metierNom ?? 'N/A',
            $demande->nom,
            $demande->prenom,
            $demande->sexe,
            $demande->ifu,
            $demande->contact ?? 'N/A',
            $demande->titre_activite,
            $demande->obejectif_activite,
            $demande->debut_activite ?? 'N/A',
            $demande->fin_activite ?? 'N/A',
            $demande->dure_activite ?? 'N/A',
            $departementNom ?? 'N/A',
            $communeNom ?? 'N/A',
            $demande->lieux ?? 'N/A',
            $demande->homme_touche ?? '0',
            number_format((float) str_replace(' ', '', $demande->budget ?? 0), 0, ',', ' '),
            number_format((float) str_replace(' ', '', $demande->buget_prevu ?? 0), 0, ',', ' '),
            $demande->date_approbation ? $demande->date_approbation->format('d/m/Y') : 'N/A',
            $demande->statuts ?? 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '009879']]],
        ];
    }
}
