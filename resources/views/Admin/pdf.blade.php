<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Détails de la Demande</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            /* Marge du haut pour laisser place au header fixe */
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
            border-bottom: 3px solid #009879;
            padding: 0 1.5cm;
            /* Padding interne */
        }

        /* Utilisation d'un tableau pour la mise en page fiable du header */
        table.header-layout {
            width: 100%;
            height: 100%;
            border: none;
            border-collapse: collapse;
            margin-top: 10px;
            /* Petit ajustement vertical */
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
            /* Force le centre à prendre de la place */
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
            color: #009879;
            /* Rappel de la couleur principale */
            font-weight: bold;
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
            /* Alignement avec le corps */
        }

        /* --- CORPS DU DOCUMENT --- */
        h1.doc-title {
            text-align: center;
            color: #009879;
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
            color: #009879;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            border-left: 5px solid #009879;
            padding-left: 10px;
            margin-bottom: 10px;
        }

        /* --- TABLEAUX DE DONNÉES --- */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            /* Petite ombre esthétique */
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
            /* Pas de bordure pour la dernière ligne */
        }

        table.data-table td.label {
            font-weight: bold;
            width: 35%;
            background-color: #f9fbfb;
            /* Fond très léger pour les étiquettes */
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
            background-color: #009879;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }

        .bg-success {
            background-color: #009879;
            color: #fff !important;
            padding: 5px 10px;
        }

        .bg-danger {
            background-color: #e74c3c;
            color: #fff !important;
            padding: 5px 10px;
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
        Généré le {{ date('d/m/Y à H:i') }} - Système FDA
    </footer>

    <main>
        <h1 class="doc-title">Fiche Récapitulative</h1>

        <div class="meta-info">
            Soumis le : <strong>{{ $demande->created_at->format('d/m/Y à H:i') }}</strong>
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
                        <td class="value">{{$demande->service ==='Assistance' ? 'Activités de Promotion' : 'Formation / Renforcement de capacités'}}</td>
                    </tr>
                    <tr>
                        <td class="label">Type demandeur</td>
                        <td class="value">@if($demande->type_demande === 'professionnel')
                            Association / Organisations professionnelles
                            @elseif($demande->type_demande === 'structure')
                            Structure formelle
                            @elseif($demande->type_demande === 'ONG')
                            Organisations Non Gouvernementales (ONG)
                            @else
                            {{ $demande->type_demande }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Branche / Corps / Métier</td>
                        <td class="value">
                            {{ $branche ? $branche->nom : 'N/A' }} /
                            {{ $corps ? $corps->nom : 'N/A' }} /
                            {{ $metier ? $metier->nom : 'N/A' }}
                        </td>
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
                            <span style="color: #777; font-size: 11px;">(Durée : {{ $demande->dure_activite }} jours)</span>
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
                        <td class="label">Statut</td>
                        <td class="value ">
                            <span class="{{ $demande->statuts === 'Approuvé' ? 'bg-success' : 'bg-danger' }}">{{ $demande->statuts === 'Approuvé' ? 'Approuvé' : 'Rejeté' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Budget de l'activité</td>
                        <td class="value">
                            <span class="bg-secondary">
                                {{ number_format((float)$demande->buget, 0, ',', ' ') }} FCFA
                            </span>
                        </td>
                    </tr>
                    @if($demande->statuts === 'Approuvé')
                    <tr>
                        <td class="label">Budget accordé</td>
                        <td class="value">
                            <span class="budget-highlight">
                                {{ number_format((float)$demande->buget_prevu, 0, ',', ' ') }} FCFA
                            </span>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>