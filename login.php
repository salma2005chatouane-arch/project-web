<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion des Formations</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 450px;
            margin: 5rem auto;
            padding: 3rem;
            background-color: var(--bg-surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .login-form {
            padding: 0;
            margin: 0;
            box-shadow: none;
            border: none;
            background: transparent;
        }

        .error-message {
            background-color: #fef2f2;
            border: 1px solid var(--primary);
            color: var(--primary-dark);
            padding: 1rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .info-box {
            background-color: #eff6ff;
            border: 1px solid #3b82f6;
            color: #1e40af;
            padding: 1rem;
            border-radius: var(--radius-md);
            margin-top: 2rem;
            font-size: 0.85rem;
        }

        .info-box strong {
            display: block;
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🔐 Connexion</h1>
            <p>Gestion des Formations en Entreprise</p>
        </div>

        <?php
        session_start();

        if (isset($_SESSION['error'])) {
            echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <form method="POST" action="login_process.php" class="login-form">
            <label>Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" required autofocus>

            <label>Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Se connecter</button>
        </form>

        <div class="info-box">
            <strong>Comptes de test :</strong>
            admin / password123 <br>
            rh / password123 <br>
            employe / password123
        </div>
    </div>
</body>

</html>