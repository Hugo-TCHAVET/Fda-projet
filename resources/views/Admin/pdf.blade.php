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
            margin-top: 3.5cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            color: #333;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            background-color: #f8f9fa;
            border-bottom: 2px solid #009879;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding-top: 0.5cm;
        }

        .header-content {
            width: 100%;
            text-align: center;
        }

        .header-content h2 {
            margin: 5px;
            font-size: 14px;
            text-transform: uppercase;
            color: #2c3e50;
        }

        .header-content p {
            margin: 2px 0;
            font-size: 10px;
            color: #555;
        }

        h1.doc-title {
            text-align: center;
            color: #009879;
            text-transform: uppercase;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .meta-info {
            text-align: right;
            font-size: 10px;
            margin-bottom: 20px;
            color: #666;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            background-color: #009879;
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px 4px 0 0;
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        table th,
        table td {
            padding: 10px 15px;
            text-align: left;
            border: 1px solid #e0e0e0;
            vertical-align: top;
        }

        table tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        table td.label {
            font-weight: bold;
            width: 35%;
            background-color: #fdfdfd;
            color: #444;
        }

        table td.value {
            width: 65%;
            color: #222;
        }

        footer {
            position: fixed;
            bottom: 1cm;
            left: 0cm;
            right: 0cm;
            height: 1.5cm;
            background-color: #f8f9fa;
            color: #777;
            text-align: center;
            line-height: 1.5cm;
            font-size: 9px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>

<body>

    <header>
        <div class="header-content">
            <h2>République du Bénin</h2>
            <p>Ministère des Petites et Moyennes Entreprises</p>
            <p>et de la Promotion de l'Emploi</p>
            <p>FDA</p>
        </div>
    </header>

    <footer>
        Généré le {{ date('d/m/Y à H:i') }} - FDA
    </footer>

    <main>
        <h1 class="doc-title">Fiche Récapitulative de Demande d'Appui</h1>

        <div class="meta-info">
            <strong>Date de soumission :</strong> {{ $demande->created_at->format('d/m/Y H:i') }}
        </div>

        <!-- Informations Générales -->
        <div class="section">
            <div class="section-title">Informations Générales</div>
            <table>
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
                        <td class="label">Branche</td>
                        <td class="value">{{ $branche ? $branche->nom : 'Non spécifié' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Corps de Métier</td>
                        <td class="value">{{ $corps ? $corps->nom : 'Non spécifié' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Métier</td>
                        <td class="value">{{ $metier ? $metier->nom : 'Non spécifié' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Informations Personnelles -->
        <div class="section">
            <div class="section-title">Informations Personnelles</div>
            <table>
                <tbody>
                    <tr>
                        <td class="label">Nom & Prénom</td>
                        <td class="value">{{ $demande->nom }} {{ $demande->prenom }}</td>
                    </tr>
                    <tr>
                        <td class="label">Sexe</td>
                        <td class="value">{{ $demande->sexe }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="value">{{ $demande->email }}</td>
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

        <!-- Informations sur le Projet -->
        <div class="section">
            <div class="section-title">Détails du Projet</div>
            <table>
                <tbody>
                    <tr>
                        <td class="label">Titre de l'activité</td>
                        <td class="value">{{ $demande->titre_activite }}</td>
                    </tr>
                    <tr>
                        <td class="label">Objectif</td>
                        <td class="value">{{ $demande->obejectif_activite }}</td>
                    </tr>
                    <tr>
                        <td class="label">Période d'exécution</td>
                        <td class="value">Du {{ $demande->debut_activite }} au {{ $demande->fin_activite }}</td>
                    </tr>
                    <tr>
                        <td class="label">Durée</td>
                        <td class="value">{{ $demande->dure_activite }}</td>
                    </tr>
                    <tr>
                        <td class="label">Localisation</td>
                        <td class="value">
                            {{ $departement ? $departement->nom : 'Dép. Inconnu' }} -
                            {{ $commune ? $commune->nom : 'Com. Inconnue' }}
                            <br>
                            <small>Lieu précis : {{ $demande->lieux }}</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Cibles</td>
                        <td class="value">
                            Femmes : {{ $demande->femme_touche }} <br>
                            Hommes : {{ $demande->homme_touche }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Budget Prévisionnel</td>
                        <td class="value" style="font-weight: bold; color: #009879;">{{ number_format((float)$demande->buget_prevu, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>