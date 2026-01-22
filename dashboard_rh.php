<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

if (!hasRole('rh')) {
    header('Location: access_denied.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace RH - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Espace Ressources Humaines</h1>
    </div>

    <?php
    $employes_formes = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(DISTINCT email_employe) as c FROM inscriptions"))['c'];
    $sessions_actives = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as c FROM sessions WHERE date_debut <= CURDATE() AND date_fin >= CURDATE()"))['c'];
    $formations_totales = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as c FROM formations"))['c'];
    ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $employes_formes; ?>
            </div>
            <div class="stat-label">Employes Formes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $sessions_actives; ?>
            </div>
            <div class="stat-label">Sessions Actives</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $formations_totales; ?>
            </div>
            <div class="stat-label">Formations au Catalogue</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-header">Gestion des Formations</h2>
        <div class="cards">
            <div class="card">
                <h3>Catalogue</h3>
                <p>Gerer les formations disponibles.</p>
                <a href="formations.php">Acceder</a>
            </div>
            <div class="card">
                <h3>Sessions</h3>
                <p>Planifier et suivre les sessions.</p>
                <a href="sessions.php">Planifier</a>
            </div>
            <div class="card">
                <h3>Inscriptions</h3>
                <p>Gerer les inscriptions des employes.</p>
                <a href="inscription.php">Gerer</a>
            </div>
            <div class="card">
                <h3>Certificats</h3>
                <p>Consulter les certificats delivres.</p>
                <a href="certificats.php">Consulter</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>