<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

if (!hasAnyRole(['admin', 'rh'])) {
    header('Location: catalogue_formations.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formations - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Gestion des Formations</h1>
    </div>

    <div class="section">
        <h2 class="section-header">Ajouter une formation</h2>
        <form method="POST" action="traitement.php">
            <input type="hidden" name="action" value="ajouter_formation">

            <label>Nom de la formation :</label>
            <input type="text" name="nom" id="nom_formation" required>

            <label>Duree (en heures) :</label>
            <input type="number" name="duree" id="duree" required min="1">

            <label>Description :</label>
            <textarea name="description" rows="4"></textarea>

            <button type="submit">Ajouter</button>
        </form>
    </div>

    <div class="section">
        <h2 class="section-header">Liste des formations</h2>
        <table>
            <thead>
                <tr>
                    <th>NOM</th>
                    <th>DUREE</th>
                    <th>DESCRIPTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM formations ORDER BY nom ASC";
                $resultat = mysqli_query($connexion, $sql);

                if (mysqli_num_rows($resultat) > 0) {
                    while ($ligne = mysqli_fetch_assoc($resultat)) {
                        echo "<tr>";
                        echo "<td><strong>" . htmlspecialchars($ligne['nom']) . "</strong></td>";
                        echo "<td>" . $ligne['duree'] . " heures</td>";
                        echo "<td>" . htmlspecialchars($ligne['description']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align: center;'>Aucune formation</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>