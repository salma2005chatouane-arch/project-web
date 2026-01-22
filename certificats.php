<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

$is_rh_admin = hasAnyRole(['admin', 'rh']);
$is_employe = hasRole('employe');

if ($is_employe) {
    $email_recherche = $_SESSION['username'] . '@company.fr';
} elseif (isset($_GET['email_recherche'])) {
    $email_recherche = $_GET['email_recherche'];
} else {
    $email_recherche = null;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificats - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .certificate-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .cert-badge {
            background: #10b981;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Mes Certificats</h1>
</div>

<?php if ($is_rh_admin): ?>
<div class="section">
    <h2 class="section-header">Rechercher un certificat</h2>
    <form method="GET" action="certificats.php">
        <label>Email de l'employe :</label>
        <input type="email" name="email_recherche" required value="<?php echo htmlspecialchars($email_recherche ?? ''); ?>">
        <button type="submit">Rechercher</button>
    </form>
</div>
<?php endif; ?>

<?php if ($email_recherche): ?>
<div class="section">
    <h2 class="section-header">Resultats pour : <?php echo htmlspecialchars($email_recherche); ?></h2>
    <?php
    $email = mysqli_real_escape_string($connexion, $email_recherche);
    $sql = "SELECT i.*, f.nom as formation_nom, f.duree, s.date_fin 
            FROM inscriptions i
            JOIN sessions s ON i.session_id = s.id
            JOIN formations f ON s.formation_id = f.id
            WHERE i.email_employe = '$email' AND s.date_fin < CURDATE()";
    
    $res = mysqli_query($connexion, $sql);

    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            echo '<div class="certificate-card">';
            echo '<h3>' . htmlspecialchars($row['formation_nom']) . '</h3>';
            echo '<p>Obtenu le : ' . date('d/m/Y', strtotime($row['date_fin'])) . '</p>';
            echo '<p>Duree : ' . $row['duree'] . ' heures</p>';
            echo '<span class="cert-badge">Certifie</span>';
            echo '</div>';
        }
    } else {
        echo "<p>Aucun certificat trouve.</p>";
    }
    ?>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
</body>
</html>