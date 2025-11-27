<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès refusé</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .error-card {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 480px;
            width: 100%;
        }

        .error-code {
            font-size: 72px;
            font-weight: 700;
            color: #dc3545;
            margin: 0 0 10px;
        }

        p {
            margin: 0 0 20px;
            line-height: 1.5;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-back {
            background: #198754;
            color: #fff;
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
        }

        .btn-dashboard {
            background: #0d6efd;
            color: #fff;
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="error-card">
        <div class="error-code">403</div>
        <h2>Accès refusé</h2>
        <p>Vous n'avez pas les autorisations nécessaires pour consulter cette page. Si vous pensez qu'il s'agit d'une erreur,
            veuillez contacter un administrateur.</p>
        <div class="actions">
            <a href="{{ url()->previous() }}" class="btn btn-back">
                ← Revenir en arrière
            </a>
            <a href="{{ route('home') }}" class="btn btn-dashboard">
                Tableau de bord
            </a>
        </div>
    </div>
</body>

</html>