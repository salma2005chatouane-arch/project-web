<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

if (!isset($_GET['id'])) {
    header('Location: catalogue_formations.php');
    exit;
}

$id = (int) $_GET['id'];
$query = "SELECT * FROM formations WHERE id = $id";
$result = mysqli_query($connexion, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header('Location: catalogue_formations.php');
    exit;
}

$formation = mysqli_fetch_assoc($result);

$query_sessions = "SELECT s.*, f.nom as formateur_nom 
                   FROM sessions s 
                   JOIN formateurs f ON s.formateur_id = f.id 
                   WHERE s.formation_id = $id AND s.date_debut >= CURDATE() 
                   ORDER BY s.date_debut ASC";
$sessions = mysqli_query($connexion, $query_sessions);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo htmlspecialchars($formation['nom']); ?> - Formation Manager
    </title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="main-content">
        <a href="catalogue_formations.php" class="btn-back">Retour au catalogue</a>

        <div class="formation-hero">
            <h1 class="formation-title">
                <?php echo htmlspecialchars($formation['nom']); ?>
            </h1>
            <div class="formation-meta">
                <div class="meta-item">
                    Duree :
                    <?php echo $formation['duree']; ?> heures
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>Description</h2>
            <p>
                <?php echo nl2br(htmlspecialchars($formation['description'])); ?>
            </p>
        </div>

        <div class="info-section">
            <h2>Sessions a venir</h2>
            <?php if (mysqli_num_rows($sessions) > 0): ?>
                <?php while ($session = mysqli_fetch_assoc($sessions)): ?>
                    <div class="session-card">
                        <div class="session-header">
                            <div class="session-dates">
                                Du
                                <?php echo date('d/m/Y', strtotime($session['date_debut'])); ?>
                                au
                                <?php echo date('d/m/Y', strtotime($session['date_fin'])); ?>
                            </div>
                            <span class="session-status status-disponible">Disponible</span>
                        </div>

                        <div class="session-info">
                            <div class="info-item">
                                Formateur :
                                <?php echo htmlspecialchars($session['formateur_nom']); ?>
                            </div>
                        </div>

                        <?php if ($_SESSION['role'] === 'employe'): ?>
                            <a href="mes_inscriptions.php?session=<?php echo $session['id']; ?>" class="btn-inscrire">S'inscrire</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Aucune session programmee pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>