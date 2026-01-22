<div class="top-nav">
    <div class="logo">
        <span class="logo-icon">FM</span>
        <span>Formation Manager</span>
    </div>

    <nav class="main-nav">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        $role = $_SESSION['role'] ?? 'employe';

        if ($role === 'admin') {
            echo '<a href="dashboard_admin.php" ' . ($current_page == 'dashboard_admin.php' ? 'class="active"' : '') . '>Tableau de bord</a>';
            echo '<a href="formateurs.php" ' . ($current_page == 'formateurs.php' ? 'class="active"' : '') . '>Formateurs</a>';
            echo '<a href="formations.php" ' . ($current_page == 'formations.php' ? 'class="active"' : '') . '>Formations</a>';
            echo '<a href="sessions.php" ' . ($current_page == 'sessions.php' ? 'class="active"' : '') . '>Sessions</a>';
            echo '<a href="inscription.php" ' . ($current_page == 'inscription.php' ? 'class="active"' : '') . '>Inscriptions</a>';
            echo '<a href="tableau-rh.php" ' . ($current_page == 'tableau-rh.php' ? 'class="active"' : '') . '>Statistiques</a>';
        } elseif ($role === 'rh') {
            echo '<a href="dashboard_rh.php" ' . ($current_page == 'dashboard_rh.php' ? 'class="active"' : '') . '>Tableau de bord</a>';
            echo '<a href="formations.php" ' . ($current_page == 'formations.php' ? 'class="active"' : '') . '>Formations</a>';
            echo '<a href="sessions.php" ' . ($current_page == 'sessions.php' ? 'class="active"' : '') . '>Sessions</a>';
            echo '<a href="inscription.php" ' . ($current_page == 'inscription.php' ? 'class="active"' : '') . '>Inscrire</a>';
            echo '<a href="certificats.php" ' . ($current_page == 'certificats.php' ? 'class="active"' : '') . '>Certificats</a>';
            echo '<a href="tableau-rh.php" ' . ($current_page == 'tableau-rh.php' ? 'class="active"' : '') . '>Statistiques</a>';
        } elseif ($role === 'formateur') {
            echo '<a href="dashboard_formateur.php" ' . ($current_page == 'dashboard_formateur.php' ? 'class="active"' : '') . '>Tableau de bord</a>';
            echo '<a href="sessions.php" ' . ($current_page == 'sessions.php' ? 'class="active"' : '') . '>Mes Sessions</a>';
            echo '<a href="catalogue_formations.php" ' . ($current_page == 'catalogue_formations.php' ? 'class="active"' : '') . '>Formations</a>';
        } else {
            echo '<a href="dashboard_employe.php" ' . ($current_page == 'dashboard_employe.php' ? 'class="active"' : '') . '>Accueil</a>';
            echo '<a href="mes_inscriptions.php" ' . ($current_page == 'mes_inscriptions.php' ? 'class="active"' : '') . '>M\'inscrire</a>';
            echo '<a href="catalogue_formations.php" ' . ($current_page == 'catalogue_formations.php' ? 'class="active"' : '') . '>Catalogue</a>';
            echo '<a href="sessions.php" ' . ($current_page == 'sessions.php' ? 'class="active"' : '') . '>Sessions</a>';
            echo '<a href="certificats.php" ' . ($current_page == 'certificats.php' ? 'class="active"' : '') . '>Mes Certificats</a>';
        }
        ?>
    </nav>

    <div class="user-section">
        <div class="user-avatar">
            <?php echo strtoupper(substr($_SESSION['nom'] ?? 'U', 0, 1)); ?>
        </div>
        <span style="color: white; font-weight: 500;">
            <?php echo htmlspecialchars($_SESSION['nom'] ?? 'Utilisateur'); ?>
        </span>
        <a href="logout.php" class="btn-logout">Deconnexion</a>
    </div>
</div>

<div class="layout-container">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <?php
            if ($role === 'admin') {
                echo '<a href="dashboard_admin.php" ' . ($current_page == 'dashboard_admin.php' ? 'class="active"' : '') . '>Vue d\'ensemble</a>';
                echo '<a href="admin_users.php" ' . ($current_page == 'admin_users.php' ? 'class="active"' : '') . '>Utilisateurs</a>';
                echo '<a href="formateurs.php" ' . ($current_page == 'formateurs.php' ? 'class="active"' : '') . '>Formateurs</a>';
                echo '<a href="formations.php" ' . ($current_page == 'formations.php' ? 'class="active"' : '') . '>Formations</a>';
                echo '<a href="sessions.php" ' . ($current_page == 'sessions.php' ? 'class="active"' : '') . '>Sessions</a>';
                echo '<a href="inscription.php" ' . ($current_page == 'inscription.php' ? 'class="active"' : '') . '>Inscriptions</a>';
                echo '<a href="certificats.php" ' . ($current_page == 'certificats.php' ? 'class="active"' : '') . '>Certificats</a>';
                echo '<a href="tableau-rh.php" ' . ($current_page == 'tableau-rh.php' ? 'class="active"' : '') . '>Rapports</a>';
            } elseif ($role === 'rh') {
                echo '<a href="dashboard_rh.php" ' . ($current_page == 'dashboard_rh.php' ? 'class="active"' : '') . '>Vue d\'ensemble</a>';
                echo '<a href="formations.php" ' . ($current_page == 'formations.php' ? 'class="active"' : '') . '>Formations</a>';
                echo '<a href="sessions.php" ' . ($current_page == 'sessions.php' ? 'class="active"' : '') . '>Sessions</a>';
                echo '<a href="inscription.php" ' . ($current_page == 'inscription.php' ? 'class="active"' : '') . '>Inscriptions</a>';
                echo '<a href="certificats.php" ' . ($current_page == 'certificats.php' ? 'class="active"' : '') . '>Certificats</a>';
                echo '<a href="tableau-rh.php" ' . ($current_page == 'tableau-rh.php' ? 'class="active"' : '') . '>Statistiques</a>';
            } elseif ($role === 'formateur') {
                echo '<a href="dashboard_formateur.php" ' . ($current_page == 'dashboard_formateur.php' ? 'class="active"' : '') . '>Tableau de bord</a>';
                echo '<a href="sessions.php" ' . ($current_page == 'sessions.php' ? 'class="active"' : '') . '>Mes Sessions</a>';
                echo '<a href="catalogue_formations.php" ' . ($current_page == 'catalogue_formations.php' ? 'class="active"' : '') . '>Formations</a>';
            } else {
                echo '<a href="dashboard_employe.php" ' . ($current_page == 'dashboard_employe.php' ? 'class="active"' : '') . '>Vue d\'ensemble</a>';
                echo '<a href="mes_inscriptions.php" ' . ($current_page == 'mes_inscriptions.php' ? 'class="active"' : '') . '>M\'inscrire</a>';
                echo '<a href="catalogue_formations.php" ' . ($current_page == 'catalogue_formations.php' ? 'class="active"' : '') . '>Catalogue</a>';
                echo '<a href="sessions.php" ' . ($current_page == 'sessions.php' ? 'class="active"' : '') . '>Sessions</a>';
                echo '<a href="certificats.php" ' . ($current_page == 'certificats.php' ? 'class="active"' : '') . '>Mes Certificats</a>';
            }
            ?>
        </nav>
    </div>

    <div class="main-content">