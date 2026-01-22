<?php
include 'auth_check.php';
include 'connexion.php';
require_once 'permissions.php';

$action = '';
if (isset($_POST['action'])) {
    $action = mysqli_real_escape_string($connexion, $_POST['action']);
}

if ($action == 'ajouter_formation') {
    if (!hasAnyRole(['admin', 'rh'])) {
        die('<h2 style="color: red;">ACCES REFUSE</h2>
             <p>Vous n\'avez pas les permissions necessaires.</p>
             <a href="index.php">Retour</a>');
    }

    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $duree = (int) $_POST['duree'];
    $description = mysqli_real_escape_string($connexion, $_POST['description']);

    if (empty($nom) || $duree <= 0) {
        die('<h2>Erreur</h2><p>Nom et duree requis.</p><a href="formations.php">Retour</a>');
    }

    $sql = "INSERT INTO formations (nom, duree, description) VALUES ('$nom', $duree, '$description')";

    if (mysqli_query($connexion, $sql)) {
        echo "<h2>Formation ajoutee avec succes !</h2>";
        echo "<p><strong>$nom</strong> ($duree heures) a ete ajoutee.</p>";
        echo "<a href='formations.php'>Retour aux formations</a>";
    } else {
        echo "<h2>Erreur</h2>";
        echo "<p>Erreur : " . mysqli_error($connexion) . "</p>";
        echo "<a href='formations.php'>Retour</a>";
    }
} elseif ($action == 'ajouter_session') {
    if (!hasAnyRole(['admin', 'rh'])) {
        die('<h2 style="color: red;">ACCES REFUSE</h2>
             <p>Vous n\'avez pas les permissions necessaires.</p>
             <a href="index.php">Retour</a>');
    }

    $formation_id = (int) $_POST['formation'];
    $formateur_id = (int) $_POST['formateur'];
    $date_debut = mysqli_real_escape_string($connexion, $_POST['date_debut']);
    $date_fin = mysqli_real_escape_string($connexion, $_POST['date_fin']);

    if (strtotime($date_debut) >= strtotime($date_fin)) {
        die('<h2>Erreur</h2><p>La date de fin doit etre apres la date de debut.</p><a href="sessions.php">Retour</a>');
    }

    $sql = "INSERT INTO sessions (formation_id, formateur_id, date_debut, date_fin) 
            VALUES ($formation_id, $formateur_id, '$date_debut', '$date_fin')";

    if (mysqli_query($connexion, $sql)) {
        echo "<h2>Session ajoutee avec succes !</h2>";
        echo "<p>Session programmee du " . date('d/m/Y', strtotime($date_debut)) . " au " . date('d/m/Y', strtotime($date_fin)) . "</p>";
        echo "<a href='sessions.php'>Retour aux sessions</a>";
    } else {
        echo "<h2>Erreur</h2>";
        echo "<p>Erreur : " . mysqli_error($connexion) . "</p>";
        echo "<a href='sessions.php'>Retour</a>";
    }
} elseif ($action == 'ajouter_formateur') {
    if (!hasAnyRole(['admin', 'rh'])) {
        die('<h2 style="color: red;">ACCES REFUSE</h2>
             <p>Vous n\'avez pas les permissions necessaires.</p>
             <a href="index.php">Retour</a>');
    }

    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $email = mysqli_real_escape_string($connexion, $_POST['email']);
    $specialite = mysqli_real_escape_string($connexion, $_POST['specialite']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('<h2>Erreur</h2><p>Email invalide.</p><a href="formateurs.php">Retour</a>');
    }

    $sql = "INSERT INTO formateurs (nom, email, specialite) VALUES ('$nom', '$email', '$specialite')";

    if (mysqli_query($connexion, $sql)) {
        echo "<h2>Formateur ajoute avec succes !</h2>";
        echo "<p><strong>$nom</strong> ($email) a ete ajoute.</p>";
        echo "<a href='formateurs.php'>Retour aux formateurs</a>";
    } else {
        echo "<h2>Erreur</h2>";
        echo "<p>Erreur : " . mysqli_error($connexion) . "</p>";
        echo "<a href='formateurs.php'>Retour</a>";
    }
} elseif ($action == 'inscrire_employe') {

    $nom = mysqli_real_escape_string($connexion, $_POST['nom_employe']);
    $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $email = mysqli_real_escape_string($connexion, $_POST['email_employe']);
    $service = mysqli_real_escape_string($connexion, $_POST['service']);
    $session_id = (int) $_POST['session'];

    $check_session = mysqli_query($connexion, "SELECT date_debut FROM sessions WHERE id = $session_id");
    if (mysqli_num_rows($check_session) == 0) {
        die('<h2>Erreur</h2><p>Session inexistante.</p><a href="mes_inscriptions.php">Retour</a>');
    }

    $session_data = mysqli_fetch_assoc($check_session);
    if (strtotime($session_data['date_debut']) < time()) {
        die('<h2>Erreur</h2><p>Impossible de s\'inscrire a une session passee.</p><a href="mes_inscriptions.php">Retour</a>');
    }

    $check_doublon = mysqli_query($connexion, "SELECT id FROM inscriptions WHERE email_employe = '$email' AND session_id = $session_id AND statut != 'annulee'");
    if (mysqli_num_rows($check_doublon) > 0) {
        die('<h2>Deja inscrit</h2><p>Vous etes deja inscrit a cette session.</p><a href="mes_inscriptions.php">Retour</a>');
    }

    $sql = "INSERT INTO inscriptions (nom_employe, prenom_employe, email_employe, service, session_id, statut) 
            VALUES ('$nom', '$prenom', '$email', '$service', $session_id, 'confirmee')";

    if (mysqli_query($connexion, $sql)) {
        echo "<h2>Inscription reussie !</h2>";
        echo "<p><strong>$prenom $nom</strong> a ete inscrit a la session.</p>";
        echo "<a href='mes_inscriptions.php'>Voir mes inscriptions</a> | ";
        echo "<a href='inscription.php'>Nouvelle inscription</a>";
    } else {
        echo "<h2>Erreur</h2>";
        echo "<p>Erreur : " . mysqli_error($connexion) . "</p>";
        echo "<a href='mes_inscriptions.php'>Retour</a>";
    }
} else {
    echo "<h2>Action inconnue</h2>";
    echo "<p>L'action demandee n'existe pas.</p>";
    echo "<a href='index.php'>Retour</a>";
}

mysqli_close($connexion);
?>