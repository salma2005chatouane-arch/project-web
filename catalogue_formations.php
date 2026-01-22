<?php
include 'auth_check.php';
include 'connexion.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des Formations - Formation Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Catalogue des Formations</h1>
        <p style="color: var(--text-muted); margin-top: 0.5rem;">
            Decouvrez toutes les formations disponibles et developpez vos competences
        </p>
    </div>

    <?php
    $total_formations = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as count FROM formations"))['count'];
    $total_sessions = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as count FROM sessions WHERE date_debut >= CURDATE()"))['count'];
    ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_formations; ?></div>
            <div class="stat-label">Formations disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_sessions; ?></div>
            <div class="stat-label">Sessions a venir</div>
        </div>
    </div>

    <div class="section">
        <input type="text" id="searchInput" placeholder="Rechercher une formation..."
            style="width: 100%; padding: 1rem;">
    </div>

    <div class="formation-grid" id="formationsGrid">
        <?php
        $sql = "SELECT formations.*, COUNT(DISTINCT sessions.id) as nb_sessions 
                FROM formations 
                LEFT JOIN sessions ON formations.id = sessions.formation_id AND sessions.date_debut >= CURDATE() 
                GROUP BY formations.id 
                ORDER BY formations.nom ASC";

        $result = mysqli_query($connexion, $sql);

        if ($result && mysqli_num_rows($result) > 0):
            while ($formation = mysqli_fetch_assoc($result)):
                ?>
                <div class="formation-card" data-name="<?php echo htmlspecialchars($formation['nom']); ?>">
                    <h3 class="formation-name"><?php echo htmlspecialchars($formation['nom']); ?></h3>

                    <span class="formation-duration"><?php echo $formation['duree']; ?> heures</span>

                    <?php if ($formation['nb_sessions'] > 0): ?>
                        <span class="formation-badge"><?php echo $formation['nb_sessions']; ?> session(s)</span>
                    <?php endif; ?>

                    <p class="formation-description">
                        <?php echo htmlspecialchars(substr($formation['description'], 0, 100)) . '...'; ?>
                    </p>

                    <div class="formation-actions">
                        <a href="formation_details.php?id=<?php echo $formation['id']; ?>" class="btn-details">Voir les
                            details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucune formation disponible.</p>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.formation-card').forEach(card => {
                const name = card.getAttribute('data-name').toLowerCase();
                card.style.display = name.includes(searchTerm) ? 'flex' : 'none';
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>