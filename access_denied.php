<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Refusé - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .access-denied {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            text-align: center;
            padding: 2rem;
        }

        .access-denied-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
        }

        .access-denied h1 {
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .access-denied p {
            color: var(--text-muted);
            margin-bottom: 2rem;
            max-width: 500px;
        }

        .btn-back {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: var(--radius-md);
            font-weight: 600;
        }

        .btn-back:hover {
            background: var(--primary-dark);
        }
    </style>
</head>

<body>
    <div class="access-denied">
        <div class="access-denied-icon">🚫</div>
        <h1>Accès Refusé</h1>
        <p>
            Vous n'avez pas les permissions nécessaires pour accéder à cette page.
            <br>
            Veuillez contacter un administrateur si vous pensez qu'il s'agit d'une erreur.
        </p>
        <a href="index.php" class="btn-back">← Retour à l'accueil</a>
    </div>
</body>

</html>