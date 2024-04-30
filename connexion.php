<?php
session_start();

// Inclure le fichier de connexion
require_once "connexion.php";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Appel de la fonction de connexion définie dans le fichier connexion.php
    $connexion = connexionBDD();

    // Requête SQL pour vérifier les informations de connexion
    $sql = "SELECT * FROM client WHERE email = :email AND password = :password";

    // Préparation de la requête
    $stmt = $connexion->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);

    // Exécution de la requête
    $stmt->execute();

    // Vérification du résultat
    if ($stmt->rowCount() > 0) {
        // L'utilisateur est authentifié, rediriger vers une page de succès
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $email;
        header("location: accueil.php");
        exit();
    } else {
        // Afficher un message d'erreur si les informations de connexion sont incorrectes
        $erreur = "Adresse e-mail ou mot de passe incorrect.";
        header("location: inscription.php");
        exit();
    }
}
?>
