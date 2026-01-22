<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

if (!hasRole('admin')) {
    header('Location: access_denied.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Tableau de Bord Administrateur</h1>
</div>

<?php
$nb_users = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as c FROM users"))['c'];
$nb_formations = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as c FROM formations"))['c'];
$nb_sessions = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as c FROM sessions WHERE date_debut > CURDATE()"))['c'];
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo $nb_users; ?></div>
        <div class="stat-label">Utilisateurs</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $nb_formations; ?></div>
        <div class="stat-label">Formations</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $nb_sessions; ?></div>
        <div class="stat-label">Sessions Futures</div>
    </div>
</div>

<div class="section">
    <h2 class="section-header">Actions Rapides</h2>
    <div class="cards">
        <div class="card">
            <h3>Gerer les Utilisateurs</h3>
            <p>Ajouter, modifier ou supprimer des comptes utilisateurs.</p>
            <a href="admin_users.php">Gerer</a>
        </div>
        <div class="card">
            <h3>Gerer les Formations</h3>
            <p>Creer de nouvelles formations et mettre a jour le catalogue.</p>
            <a href="formations.php">Gerer</a>
        </div>
        <div class="card">
            <h3>Planifier des Sessions</h3>
            <p>Organiser de nouvelles sessions de formation.</p>
            <a href="sessions.php">Planifier</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>