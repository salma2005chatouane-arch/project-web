<?php
include 'auth_check.php';
include 'connexion.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formateurs - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Gestion des Formateurs</h1>
    </div>

    <div class="section">
        <h2 class="section-header">Ajouter un formateur</h2>
        <form method="POST" action="traitement.php">
            <input type="hidden" name="action" value="ajouter_formateur">

            <label>Nom du formateur :</label>
            <input type="text" name="nom" required>

            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Spécialité :</label>
            <input type="text" name="specialite" required>

            <button type="submit">Ajouter</button>
        </form>
    </div>

    <div class="section">
        <h2 class="section-header">Liste des formateurs</h2>
        <table>
            <thead>
                <tr>
                    <th>NOM</th>
                    <th>EMAIL</th>
                    <th>SPÉCIALITÉ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM formateurs ORDER BY nom ASC";
                $resultat = mysqli_query($connexion, $sql);

                if (mysqli_num_rows($resultat) > 0) {
                    while ($ligne = mysqli_fetch_assoc($resultat)) {
                        echo "<tr>";
                        echo "<td><strong>" . htmlspecialchars($ligne['nom']) . "</strong></td>";
                        echo "<td>" . htmlspecialchars($ligne['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($ligne['specialite']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align: center;'>Aucun formateur</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>