<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

$isAdminOrRh = hasAnyRole(['admin', 'rh']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessions - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Gestion des Sessions</h1>
    </div>

    <?php if ($isAdminOrRh): ?>
        <div class="section">
            <h2 class="section-header">Programmer une nouvelle session</h2>
            <form method="POST" action="traitement.php">
                <input type="hidden" name="action" value="ajouter_session">

                <label>Formation :</label>
                <select name="formation" required>
                    <?php
                    $formations = mysqli_query($connexion, "SELECT id, nom FROM formations ORDER BY nom");
                    while ($f = mysqli_fetch_assoc($formations)) {
                        echo "<option value='" . $f['id'] . "'>" . htmlspecialchars($f['nom']) . "</option>";
                    }
                    ?>
                </select>

                <label>Formateur :</label>
                <select name="formateur" required>
                    <?php
                    $formateurs = mysqli_query($connexion, "SELECT id, nom FROM formateurs ORDER BY nom");
                    while ($f = mysqli_fetch_assoc($formateurs)) {
                        echo "<option value='" . $f['id'] . "'>" . htmlspecialchars($f['nom']) . "</option>";
                    }
                    ?>
                </select>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label>Date de début :</label>
                        <input type="date" name="date_debut" required>
                    </div>
                    <div>
                        <label>Date de fin :</label>
                        <input type="date" name="date_fin" required>
                    </div>
                </div>

                <button type="submit">Programmer la session</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="section">
        <h2 class="section-header">Sessions programmées</h2>
        <table>
            <thead>
                <tr>
                    <th>FORMATION</th>
                    <th>FORMATEUR</th>
                    <th>DATES</th>
                    <th>STATUT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT s.*, f.nom as formation_nom, fm.nom as formateur_nom 
                    FROM sessions s
                    JOIN formations f ON s.formation_id = f.id
                    JOIN formateurs fm ON s.formateur_id = fm.id
                    ORDER BY s.date_debut DESC";

                $resultat = mysqli_query($connexion, $sql);

                if (mysqli_num_rows($resultat) > 0) {
                    while ($row = mysqli_fetch_assoc($resultat)) {
                        $debut = strtotime($row['date_debut']);
                        $fin = strtotime($row['date_fin']);
                        $now = time();

                        if ($now < $debut) {
                            $status = '<span style="color: green; font-weight: bold;">À venir</span>';
                        } elseif ($now >= $debut && $now <= $fin) {
                            $status = '<span style="color: orange; font-weight: bold;">En cours</span>';
                        } else {
                            $status = '<span style="color: gray; font-weight: bold;">Terminée</span>';
                        }

                        echo "<tr>";
                        echo "<td><strong>" . htmlspecialchars($row['formation_nom']) . "</strong></td>";
                        echo "<td>" . htmlspecialchars($row['formateur_nom']) . "</td>";
                        echo "<td>Du " . date('d/m/Y', $debut) . " au " . date('d/m/Y', $fin) . "</td>";
                        echo "<td>$status</td>";
                        echo "<td>";
                        if ($_SESSION['role'] === 'employe' && $now < $debut) {
                            echo "<a href='mes_inscriptions.php?session=" . $row['id'] . "' class='btn-details'>S'inscrire</a>";
                        } elseif ($isAdminOrRh) {
                            echo "<a href='inscription.php?session=" . $row['id'] . "' class='btn-details'>Gérer</a>";
                        } else {
                            echo "-";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center;'>Aucune session programmée</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>