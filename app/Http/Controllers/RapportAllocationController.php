<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Demande;
use Illuminate\Support\Facades\Storage;

class RapportAllocationController extends Controller
{
    public function fiche($id)
    {
        $demande = Demande::allocations()->where('rapport_depose', true)->findOrFail($id);
        $libelleBranche = $demande->branche?->nom ?? 'Non renseigné';
        $libelleService = Demande::libelleService($demande->service);

        $logoPath = public_path('Client/assets/lofoFDA.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : '';

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('Admin.fiche-allocation', compact('demande', 'libelleBranche', 'libelleService', 'logoBase64'))->render());
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="fiche_allocation_' . $demande->code . '.pdf"',
        ]);
    }

    public function fichier($id)
    {
        $demande = Demande::findOrFail($id);
        $chemin = $demande->cheminRapportSur();
        abort_unless($chemin && Storage::disk('local')->exists($chemin), 404);

        return Storage::disk('local')->download($chemin, 'rapport_' . $demande->code . '.pdf');
    }
}
