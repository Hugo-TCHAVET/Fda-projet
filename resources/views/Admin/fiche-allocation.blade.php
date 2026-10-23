<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fiche de fin d'allocation</title>
    <style>
        @page { margin: 0cm 0cm; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 3.5cm 2cm 2cm 2cm;
            color: #444;
            line-height: 1.4;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3cm;
            background-color: #f8f9fa;
            border-bottom: 3px solid #009879;
            padding: 0 1.5cm;
        }

        footer {
            position: fixed;
            bottom: 0.5cm;
            left: 2cm;
            right: 2cm;
            text-align: center;
            font-size: 9px;
            color: #999;
        }

        table.header-layout { width: 100%; height: 100%; border-collapse: collapse; margin-top: 10px; }
        table.header-layout td { vertical-align: middle; padding: 0; }
        .header-logo { width: 80px; max-height: 80px; }
        .header-center { text-align: center; width: 60%; }
        .header-center h2 { margin: 0; font-size: 16px; text-transform: uppercase; color: #2c3e50; letter-spacing: 1px; }
        .header-center p { margin: 5px 0 0 0; font-size: 11px; color: #009879; font-weight: bold; }

        h1 { text-align: center; font-size: 18px; color: #2c3e50; text-transform: uppercase; margin-bottom: 25px; }

        .section { margin-bottom: 25px; }
        .section-title {
            color: #009879;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            border-left: 5px solid #009879;
            padding-left: 10px;
            margin-bottom: 10px;
        }

        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table th, table.data-table td { padding: 8px 12px; text-align: left; border-bottom: 1px solid #eee; }
        table.data-table th { background-color: #009879; color: #fff; }
        table.data-table td.label { font-weight: bold; width: 40%; background-color: #f9fbfb; color: #555; }
    </style>
</head>

<body>
    <header>
        <table class="header-layout">
            <tr>
                <td style="width: 20%;">
                    @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo" class="header-logo">
                    @endif
                </td>
                <td class="header-center">
                    <h2>République du Bénin</h2>
                    <p>Fonds de Développement de l'Artisanat</p>
                </td>
                <td style="width: 20%;"></td>
            </tr>
        </table>
    </header>

    <footer>Généré le {{ date('d/m/Y à H:i') }} - Système FDA</footer>

    <main>
        <h1>Fiche de fin d'allocation</h1>

        <div class="section">
            <div class="section-title">Allocation</div>
            <table class="data-table">
                <tr><td class="label">Code</td><td>{{ $demande->code }}</td></tr>
                <tr><td class="label">Structure</td><td>{{ $demande->structure }}</td></tr>
                <tr><td class="label">Branche</td><td>{{ $libelleBranche }}</td></tr>
                <tr><td class="label">Service</td><td>{{ $libelleService }}</td></tr>
                <tr><td class="label">Montant demandé</td><td>{{ number_format($demande->budget, 0, ',', ' ') }} FCFA</td></tr>
                <tr><td class="label">Appui financier accordé</td><td>{{ number_format($demande->budget_accorde ?? 0, 0, ',', ' ') }} FCFA</td></tr>
                <tr><td class="label">Date d'approbation</td><td>{{ optional($demande->date_approbation)->format('d/m/Y') ?? 'Non renseignée' }}</td></tr>
                <tr><td class="label">Date de dépôt du rapport</td><td>{{ optional($demande->date_depot_rapport)->format('d/m/Y') ?? 'Non renseignée' }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Bénéficiaires formés</div>
            <table class="data-table">
                <tr><th></th><th>Hommes</th><th>Femmes</th><th>Total</th></tr>
                <tr>
                    <td class="label">Personnes formées</td>
                    <td>{{ (int) $demande->effectif_homme_forme }}</td>
                    <td>{{ (int) $demande->effectif_femme_forme }}</td>
                    <td>{{ (int) $demande->effectif_homme_forme + (int) $demande->effectif_femme_forme }}</td>
                </tr>
                <tr>
                    <td class="label">Dont personnes handicapées</td>
                    @if($demande->effectif_handicape_homme === null)
                    <td colspan="3">Non renseigné</td>
                    @else
                    <td>{{ (int) $demande->effectif_handicape_homme }}</td>
                    <td>{{ (int) $demande->effectif_handicape_femme }}</td>
                    <td>{{ (int) $demande->effectif_handicape_homme + (int) $demande->effectif_handicape_femme }}</td>
                    @endif
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Observations</div>
            <p>{{ $demande->observations_rapport ?: 'Aucune observation.' }}</p>
        </div>
    </main>
</body>

</html>
