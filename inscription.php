<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

if (!hasAnyRole(['admin', 'rh'])) {
    header('Location: access_denied.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Inscriptions - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Gestion des Inscriptions</h1>
    </div>

    <div class="section">
        <h2 class="section-header">Inscrire un employe</h2>
        <form method="POST" action="traitement.php">
            <input type="hidden" name="action" value="inscrire_employe">

            <label>Employe (Nom) :</label>
            <input type="text" name="nom_employe" required>

            <label>Employe (Prenom) :</label>
            <input type="text" name="prenom" required>

            <label>Email :</label>
            <input type="email" name="email_employe" required>

            <label>Service :</label>
            <input type="text" name="service" required>

            <label>Session :</label>
            <select name="session" required>
                <?php
                $sql = "SELECT s.id, f.nom, s.date_debut 
                FROM sessions s
                JOIN formations f ON s.formation_id = f.id
                WHERE s.date_debut > CURDATE()
                ORDER BY s.date_debut ASC";
                $res = mysqli_query($connexion, $sql);
                while ($s = mysqli_fetch_assoc($res)) {
                    echo "<option value='" . $s['id'] . "'>" . htmlspecialchars($s['nom']) . " (" . date('d/m/Y', strtotime($s['date_debut'])) . ")</option>";
                }
                ?>
            </select>

            <button type="submit">Inscrire</button>
        </form>
    </div>

    <div class="section">
        <h2 class="section-header">Liste des inscriptions</h2>
        <table>
            <thead>
                <tr>
                    <th>EMPLOYE</th>
                    <th>EMAIL</th>
                    <th>FORMATION</th>
                    <th>DATE DEBUT</th>
                    <th>STATUT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT i.id, i.nom_employe, i.prenom_employe, i.email_employe, i.statut, f.nom, s.date_debut 
                FROM inscriptions i
                JOIN sessions s ON i.session_id = s.id
                JOIN formations f ON s.formation_id = f.id
                ORDER BY s.date_debut DESC LIMIT 50";

                $resultat = mysqli_query($connexion, $sql);

                if (mysqli_num_rows($resultat) > 0) {
                    while ($row = mysqli_fetch_assoc($resultat)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['prenom_employe'] . " " . $row['nom_employe']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email_employe']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($row['date_debut'])) . "</td>";
                        echo "<td>" . ucfirst($row['statut']) . "</td>";
                        echo "<td><a href='#'>Modifier</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center;'>Aucune inscription</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>