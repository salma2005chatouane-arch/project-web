<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

if (!hasRole('employe')) {
    header('Location: access_denied.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Employe - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Mon Espace Formation</h1>
    </div>

    <?php
    $email = $_SESSION['username'] . '@company.fr';
    $nb_inscriptions = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as c FROM inscriptions WHERE email_employe LIKE '%" . $_SESSION['username'] . "%'"))['c'];
    $nb_certificats = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as c FROM inscriptions i JOIN sessions s ON i.session_id = s.id WHERE i.email_employe LIKE '%" . $_SESSION['username'] . "%' AND s.date_fin < CURDATE()"))['c'];
    ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $nb_inscriptions; ?>
            </div>
            <div class="stat-label">Inscriptions</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $nb_certificats; ?>
            </div>
            <div class="stat-label">Certificats Obtenus</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-header">Mes formations en cours</h2>
        <?php
        $sql = "SELECT f.nom, s.date_debut, s.date_fin 
            FROM inscriptions i
            JOIN sessions s ON i.session_id = s.id
            JOIN formations f ON s.formation_id = f.id
            WHERE i.email_employe LIKE '%" . $_SESSION['username'] . "%' 
            AND s.date_debut <= CURDATE() AND s.date_fin >= CURDATE()";

        $result = mysqli_query($connexion, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td><strong>' . htmlspecialchars($row['nom']) . '</strong></td>';
                echo '<td>Fin le ' . date('d/m/Y', strtotime($row['date_fin'])) . '</td>';
                echo '<td><span style="color: green;">En cours</span></td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Aucune formation en cours actuellement.</p>';
        }
        ?>
    </div>

    <div class="section">
        <h2 class="section-header">Formations disponibles</h2>
        <p>Decouvrez les prochaines sessions et developpez vos competences.</p>
        <a href="catalogue_formations.php" class="btn-primary">Voir le catalogue</a>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>