<?php
include 'auth_check.php';
include 'connexion.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord RH - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Tableau de Bord RH</h1>
    </div>

    <?php
    $total_employes = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(DISTINCT email_employe) as total FROM inscriptions"))['total'];
    $total_formations = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as total FROM formations"))['total'];
    $total_certificats = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as total FROM inscriptions JOIN sessions ON inscriptions.session_id = sessions.id WHERE sessions.date_fin < CURDATE()"))['total'];
    $sessions_en_cours = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as total FROM sessions WHERE date_debut <= CURDATE() AND date_fin >= CURDATE()"))['total'];
    ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $total_employes; ?>
            </div>
            <div class="stat-label">Employes Formes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $total_formations; ?>
            </div>
            <div class="stat-label">Formations Totales</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $total_certificats; ?>
            </div>
            <div class="stat-label">Sessions Terminees</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php echo $sessions_en_cours; ?>
            </div>
            <div class="stat-label">Sessions en Cours</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-header">Competences par Service</h2>
        <table>
            <thead>
                <tr>
                    <th>SERVICE</th>
                    <th>NOMBRE D'INSCRIPTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT service, COUNT(*) as nombre FROM inscriptions GROUP BY service ORDER BY nombre DESC";
                $res = mysqli_query($connexion, $sql);

                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td><strong>" . htmlspecialchars($row['service']) . "</strong></td>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' style='text-align: center;'>Pas de donnees</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>