<?php
$serveur = "localhost";
$port = 3307;
$utilisateur = "root";
$mot_de_passe = "slima";
$base = "gestionn_formations";

try {
    $connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base, $port);
} catch (mysqli_sql_exception $e) {
    die("Echec de la connexion : " . $e->getMessage());
}

if (!$connexion) {
    die("Echec de la connexion : " . mysqli_connect_error());
}

mysqli_set_charset($connexion, "utf8");
?>