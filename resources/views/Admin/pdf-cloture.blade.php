<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Détails de la Demande Clôturée</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin-top: 3.5cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            color: #444;
            line-height: 1.4;
        }

        /* --- EN-TÊTE (HEADER) --- */
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            background-color: #f8f9fa;
            border-bottom: 3px solid #dc3545;
            padding: 0 1.5cm;
        }

        table.header-layout {
            width: 100%;
            height: 100%;
            border: none;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.header-layout td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .header-logo {
            width: 80px;
            height: auto;
            max-height: 80px;
            object-fit: contain;
        }

        .header-center {
            text-align: center;
            width: 60%;
        }

        .header-center h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
            color: #2c3e50;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .header-center p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #dc3545;
            font-weight: bold;
        }

        .cloture-badge {
            background-color: #dc3545;
            color: white;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* --- PIED DE PAGE (FOOTER) --- */
        footer {
            position: fixed;
            bottom: 0.5cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            background-color: transparent;
            color: #777;
            text-align: center;
            font-size: 9px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin: 0 2cm;
        }

        /* --- CORPS DU DOCUMENT --- */
        h1.doc-title {
            text-align: center;
            color: #dc3545;
            text-transform: uppercase;
            font-size: 20px;
            margin-top: 0px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ccc;
        }

        .meta-info {
            text-align: right;
            font-size: 10px;
            margin-bottom: 30px;
            color: #555;
            font-style: italic;
        }

        /* --- STYLES DES SECTIONS --- */
        .section {
            margin-bottom: 30px;
        }

        .section-title {
            color: #dc3545;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            border-left: 5px solid #dc3545;
            padding-left: 10px;
            margin-bottom: 10px;
        }

        /* --- TABLEAUX DE DONNÉES --- */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }

        table.data-table th,
        table.data-table td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        table.data-table tr:last-child td {
            border-bottom: none;
        }

        table.data-table td.label {
            font-weight: bold;
            width: 35%;
            background-color: #f9fbfb;
            color: #555;
            border-right: 1px solid #eee;
        }

        table.data-table td.value {
            width: 65%;
            color: #222;
        }

        /* Highlight pour le budget */
        .budget-highlight {
            font-weight: bold;
            color: #fff;
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <header>
        <table class="header-layout">
            <tr>
                <td style="text-align: left; width: 20%;">
                    @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo Gauche" class="header-logo">
                    @endif
                </td>
                <td class="header-center">
                    <h2>République du Bénin</h2>
                    <p>Fonds de Développement de l'Artisanat</p>
                    <span class="cloture-badge">Exercice {{ $demande->annee_exercice_cloture }} Clôturé</span>
                </td>
                <td style="text-align: right; width: 20%;">
                    @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo Droite" class="header-logo">
                    @endif
                </td>
            </tr>
        </table>
    </header>

    <footer>
        Généré le {{ date('d/m/Y à H:i') }} - Système FDA - Demande Clôturée
    </footer>

    <main>
        <h1 class="doc-title">Fiche Récapitulative - Demande Clôturée</h1>

        <div class="meta-info">
            Soumis le : <strong>{{ \Carbon\Carbon::parse($demande->created_at)->format('d/m/Y à H:i') }}</strong><br>
            Clôturé le : <strong>{{ $demande->date_cloture ? \Carbon\Carbon::parse($demande->date_cloture)->format('d/m/Y à H:i') : 'N/A' }}</strong>
        </div>

        <div class="section">
            <div class="section-title">Informations Générales</div>
            <table class="data-table">
                <tbody>
                    <tr>
                        <td class="label">Nom de la structure</td>
                        <td class="value">{{ $demande->structure }}</td>
                    </tr>
                    <tr>
                        <td class="label">Service</td>
                        <td class="value">{{ $demande->service }}</td>
                    </tr>
                    <tr>
                        <td class="label">Type demandeur</td>
                        <td class="value">{{ $demande->type_demande }}</td>
                    </tr>
                    <tr>
                        <td class="label">Classification</td>
                        <td class="value">
                            {{ $branche ? $branche->nom : 'N/A' }} /
                            {{ $corps ? $corps->nom : 'N/A' }} /
                            {{ $metier ? $metier->nom : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Année d'exercice clôturée</td>
                        <td class="value"><strong>{{ $demande->annee_exercice_cloture }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Informations du Demandeur</div>
            <table class="data-table">
                <tbody>
                    <tr>
                        <td class="label">Nom & Prénom</td>
                        <td class="value">{{ $demande->nom }} {{ $demande->prenom }}</td>
                    </tr>
                    <tr>
                        <td class="label">Genre</td>
                        <td class="value">{{ $demande->sexe }}</td>
                    </tr>
                    <tr>
                        <td class="label">Numéro IFU</td>
                        <td class="value">{{ $demande->ifu }}</td>
                    </tr>
                    <tr>
                        <td class="label">Contact</td>
                        <td class="value">{{ $demande->contact }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Détails du Projet</div>
            <table class="data-table">
                <tbody>
                    <tr>
                        <td class="label">Titre de l'activité</td>
                        <td class="value">{{ $demande->titre_activite }}</td>
                    </tr>
                    <tr>
                        <td class="label">Objectif</td>
                        <td class="value" style="text-align: justify;">{{ $demande->obejectif_activite }}</td>
                    </tr>
                    <tr>
                        <td class="label">Calendrier</td>
                        <td class="value">
                            Du {{ $demande->debut_activite }} au {{ $demande->fin_activite }} <br>
                            <span style="color: #777; font-size: 11px;">(Durée : {{ $demande->dure_activite }})</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Localisation</td>
                        <td class="value">
                            {{ $departement ? $departement->nom : 'N/A' }},
                            {{ $commune ? $commune->nom : 'N/A' }} <br>
                            <small>Lieu : {{ $demande->lieux }}</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Cibles</td>
                        <td class="value">{{ $demande->homme_touche }} personnes</td>
                    </tr>
                    <tr>
                        <td class="label">Budget Prévisionnel</td>
                        <td class="value">
                            <span class="budget-highlight">
                                {{ number_format((float)$demande->buget_prevu, 0, ',', ' ') }} FCFA
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>