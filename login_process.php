<?php
session_start();
include 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connexion, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connexion, $sql);

    if ($row = mysqli_fetch_assoc($result)) {

        if ($password == $row['password']) {

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['nom'] = $row['nom'];

            if ($row['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } elseif ($row['role'] == 'rh') {
                header("Location: dashboard_rh.php");
            } elseif ($row['role'] == 'formateur') {
                header("Location: dashboard_formateur.php");
            } else {
                header("Location: dashboard_employe.php");
            }
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
?>