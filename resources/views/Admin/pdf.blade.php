<div>
    <div>
        <p>Nom: {{ $demande->nom }}</p>
        <p>Prénom: {{ $demande->prenom }}</p>
        <!-- Ajoutez les autres champs que vous souhaitez inclure dans le PDF -->
    </div>
</div>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu d'impression</title>
    <style>
        body {
    font-family: Arial, sans-serif;
}

.header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.logo-left, .logo-right {
    max-width: 100px;
}

.header-info {
    text-align: center;
}

.table-title {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    margin: 20px 0;
}

.period-info {
    text-align: right;
    font-size: 12px;
    margin-bottom: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    width: 50%; /* Nouvelle règle pour répartir équitablement l'espace */
}

th {
    background-color: #f2f2f2;
}

/* Nouvelle règle pour centrer les deux logos */
.header-info p {
    margin: 0; /* Supprimez la marge par défaut */
}

.header-info {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
}
    </style>
</head>
<body>

    <div class="header">
        <div>
            <img src="path/to/left-logo.png" alt="Left Logo" class="logo-left">
            <div class="header-info">
                <p>République du Bénin</p>
                <p>Ministère des petites et moyennes entreprises et de promotion de l'emploi</p>
            </div>
        </div>
        
    </div>

    <div class="table-title">
        <p>ETAT RECAPITULATIF DES DEMANDES D'APPUIS</p>
    </div>

    <div class="period-info">
        <p>Période: {{ $demande->created_at }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th colspan="2">Information Générale</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nom de la structure:</td>
                <td>{{ $demande->structure }}</td>
            </tr>
            <tr>
                <td>Service:</td>
                <td>
                    {{ $demande->service }}
                </td>
            </tr>
            <tr>
                <td>Type demandeur:</td>
                <td>
                    {{ $demande->type_demandeur }}
                </td>
            </tr>
            <tr>
                <td>Branche:</td>
                <td>
                    {{ $demande->branche }}
                </td>
            </tr>
            <tr>
                <td>Corps Metier:</td>
                <td>
                    {{ $demande->corps }}
                </td>
            </tr>
            <tr>
                <td>Metier:</td>
                <td>
                    {{ $demande->metier }}
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="2">Information personnelle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nom:</td>
                <td>{{ $demande->nom }}</td>
            </tr>
            <tr>
                <td>Prénom:</td>
                <td>{{ $demande->prenom }}</td>
            </tr>
            <tr>
                <td>Sexe:</td>
                <td>
                    {{ $demande->sexe }}
                </td>
            </tr>
            <tr>
                <td>Mail:</td>
                <td>{{ $demande->email }}</td>
            </tr>
            <tr>
                <td>IFU:</td>
                <td>{{ $demande->ifu }}</td>
            </tr>
            <tr>
                <td>Contact:</td>
                <td>{{ $demande->contact }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="2">Information sur le projet</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Titre de l'activité:</td>
                <td>{{ $demande->titre_activite }}</td>
            </tr>
            <tr>
                <td>Objectif de l'activité:</td>
                <td>{{ $demande->obejectif_activite }}</textarea></td>
            </tr>
            <tr>
                <td>Date début d'exécution:</td>
                <td>{{ $demande->debut_activite }}</td>
            </tr>
            <tr>
                <td>Date fin d'exécution:</td>
                <td>{{ $demande->fin_activite }}</td>
            </tr>
            <tr>
                <td>Durée:</td>
                <td>{{ $demande->dure_activite }}</textarea></td>
            </tr>
            <tr>
                <td>Departement:</td>
                <td>{{ $demande->departement }}</td>
            </tr>
            <tr>
                <td>Commune:</td>
                <td>{{ $demande->commune }}</td>
            </tr>
            <tr>
                <td>Lieu d'exécution:</td>
                <td>{{ $demande->lieux }}</td>
            </tr>
            <tr>
                <td>Nombre de femme touchant:</td>
                <td>{{ $demande->femme_touche }}</td>
            </tr>
            <tr>
                <td>Nombre d'homme touchant:</td>
                <td>{{ $demande->homme_touche }}</td>
            </tr>
            <tr>
                <td>Budget prévisonnel:</td>
                <td>{{ $demande->buget_prevu }}</td>
            </tr>
        </tbody>
    </table>


</body>
</html>

