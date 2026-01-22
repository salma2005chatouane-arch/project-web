<?php
include 'auth_check.php';
include 'connexion.php';

$role = $_SESSION['role'] ?? 'employe';

if ($role === 'admin') {
    header('Location: dashboard_admin.php');
} elseif ($role === 'rh') {
    header('Location: dashboard_rh.php');
} elseif ($role === 'formateur') {
    header('Location: dashboard_formateur.php');
} else {
    header('Location: dashboard_employe.php');
}
exit;
?>