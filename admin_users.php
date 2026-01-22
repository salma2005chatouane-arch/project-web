<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create_user') {
        $username = mysqli_real_escape_string($connexion, $_POST['username']);
        $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
        $role = mysqli_real_escape_string($connexion, $_POST['role']);
        $password = mysqli_real_escape_string($connexion, $_POST['password']);

        $sql = "INSERT INTO users (username, password, nom, role) VALUES ('$username', '$password', '$nom', '$role')";

        if (mysqli_query($connexion, $sql)) {
            $success = "Utilisateur créé avec succès !";
        } else {
            $error = "Erreur SQL : " . mysqli_error($connexion);
        }
    }

    if ($action === 'delete_user') {
        $user_id = (int) $_POST['user_id'];
        mysqli_query($connexion, "DELETE FROM users WHERE id = $user_id");
        $success = "Utilisateur supprimé avec succès !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Utilisateurs - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="page-header">
        <h1 class="page-title">Gestion des Utilisateurs</h1>
        <p style="color: var(--text-muted); margin-top: 0.5rem;">Administration des comptes et attribution des rôles</p>
    </div>

    <?php if (isset($error)): ?>
        <div
            style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div
            style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>


    <div class="section">
        <h2 class="section-header">Créer un nouvel utilisateur</h2>
        <form method="POST" style="max-width: 600px;">
            <input type="hidden" name="action" value="create_user">

            <label>Nom d'utilisateur :</label>
            <input type="text" name="username" required>

            <label>Nom complet :</label>
            <input type="text" name="nom" required>

            <label>Mot de passe :</label>
            <input type="password" name="password" required minlength="6">

            <label>Rôle :</label>
            <select name="role" required>
                <option value="">Sélectionner un rôle</option>
                <option value="admin">Administrateur</option>
                <option value="rh">Responsable RH</option>
                <option value="formateur">Formateur</option>
                <option value="employe">Employé</option>
            </select>

            <button type="submit">Créer l'utilisateur</button>
        </form>
    </div>


    <div class="section">
        <h2 class="section-header">Liste des Utilisateurs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOM D'UTILISATEUR</th>
                    <th>NOM COMPLET</th>
                    <th>RÔLE</th>
                    <th>DATE CRÉATION</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM users ORDER BY created_at DESC";
                $result = mysqli_query($connexion, $sql);

                while ($user = mysqli_fetch_assoc($result)) {
                    $role_colors = [
                        'admin' => '#dc2626',
                        'rh' => '#2563eb',
                        'formateur' => '#10b981',
                        'employe' => '#64748b'
                    ];

                    $role_labels = [
                        'admin' => 'Administrateur',
                        'rh' => 'RH',
                        'formateur' => 'Formateur',
                        'employe' => 'Employé'
                    ];

                    $color = $role_colors[$user['role']] ?? '#64748b';
                    $label = $role_labels[$user['role']] ?? $user['role'];

                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td><strong>" . htmlspecialchars($user['username']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($user['nom']) . "</td>";
                    echo "<td><span style='background: $color; color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.85rem;'>$label</span></td>";
                    echo "<td>" . date('d/m/Y H:i', strtotime($user['created_at'])) . "</td>";
                    echo "<td>";
                    if ($user['id'] != $_SESSION['user_id']) {
                        echo "<form method='POST' style='display:inline; padding:0; margin:0; box-shadow:none; border:none;' onsubmit='return confirm(\"Supprimer cet utilisateur ?\");'>";
                        echo "<input type='hidden' name='action' value='delete_user'>";
                        echo "<input type='hidden' name='user_id' value='" . $user['id'] . "'>";
                        echo "<button type='submit' style='background:#dc2626; padding:0.4rem 0.8rem; margin:0; font-size:0.85rem;'>Supprimer</button>";
                        echo "</form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <div class="stats-grid">
        <?php
        $total_users = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as count FROM users"))['count'];
        $total_formations = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as count FROM formations"))['count'];
        $total_sessions = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as count FROM sessions"))['count'];
        $total_inscriptions = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT COUNT(*) as count FROM inscriptions"))['count'];
        ?>

        <div class="stat-card">
            <div class="stat-number">
                <?php echo $total_users; ?>
            </div>
            <div class="stat-label">Utilisateurs Total</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">
                <?php echo $total_formations; ?>
            </div>
            <div class="stat-label">Formations</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">
                <?php echo $total_sessions; ?>
            </div>
            <div class="stat-label">Sessions</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">
                <?php echo $total_inscriptions; ?>
            </div>
            <div class="stat-label">Inscriptions</div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>