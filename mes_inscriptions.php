<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

if (!hasRole('employe')) {
    header('Location: access_denied.php');
    exit;
}

$email_employe = $_SESSION['username'] . '@company.fr';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Inscriptions - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Mes Inscriptions</h1>
    </div>

    <div class="section">
        <h2 class="section-header">Mes inscriptions actuelles</h2>
        <table>
            <thead>
                <tr>
                    <th>FORMATION</th>
                    <th>DATES</th>
                    <th>STATUT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT i.id, i.statut, f.nom, s.date_debut, s.date_fin 
                    FROM inscriptions i
                    JOIN sessions s ON i.session_id = s.id
                    JOIN formations f ON s.formation_id = f.id
                    WHERE i.email_employe LIKE '%" . $_SESSION['username'] . "%'
                    ORDER BY s.date_debut DESC";

                $resultat = mysqli_query($connexion, $sql);

                if (mysqli_num_rows($resultat) > 0) {
                    while ($row = mysqli_fetch_assoc($resultat)) {
                        echo "<tr>";
                        echo "<td><strong>" . htmlspecialchars($row['nom']) . "</strong></td>";
                        echo "<td>Du " . date('d/m/Y', strtotime($row['date_debut'])) . " au " . date('d/m/Y', strtotime($row['date_fin'])) . "</td>";
                        echo "<td><span class='status-" . $row['statut'] . "'>" . ucfirst($row['statut']) . "</span></td>";
                        echo "<td>";
                        if (strtotime($row['date_debut']) > time() && $row['statut'] != 'annulee') {
                            echo "<a href='#' style='color: red;'>Se desinscrire</a>";
                        } else {
                            echo "-";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align: center;'>Aucune inscription trouvee</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2 class="section-header">S'inscrire a une session</h2>
        <form method="POST" action="traitement.php">
            <input type="hidden" name="action" value="inscrire_employe">
            <input type="hidden" name="nom_employe" value="<?php echo $_SESSION['nom']; ?>">
            <input type="hidden" name="prenom" value="<?php echo $_SESSION['username']; ?>">
            <input type="hidden" name="email_employe" value="<?php echo $email_employe; ?>">

            <label>Choisir une session disponible :</label>
            <select name="session" required>
                <?php
                $sql = "SELECT s.id, f.nom, s.date_debut 
                    FROM sessions s
                    JOIN formations f ON s.formation_id = f.id
                    WHERE s.date_debut > CURDATE()
                    ORDER BY s.date_debut ASC";
                $res = mysqli_query($connexion, $sql);
                while ($s = mysqli_fetch_assoc($res)) {
                    echo "<option value='" . $s['id'] . "'>" . htmlspecialchars($s['nom']) . " - " . date('d/m/Y', strtotime($s['date_debut'])) . "</option>";
                }
                ?>
            </select>

            <label>Votre Service :</label>
            <input type="text" name="service" required placeholder="Ex: Informatique, RH...">

            <button type="submit">Confirmer l'inscription</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>