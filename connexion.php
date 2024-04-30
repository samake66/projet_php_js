<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connexion à la base de données
    define('DSN', 'mysql:host=localhost;dbname=hotel_BD;charset=utf8');
    define('USER', 'root');
    define('PASS', '');

    try {
        $pdo = new PDO(DSN, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour vérifier les informations de connexion
        $sql = "SELECT * FROM client WHERE email = :email AND password = :password";

        // Préparation de la requête
        $stmt = $pdo->prepare($sql);

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
    } catch(PDOException $e) {
        // Gérer les erreurs de connexion à la base de données
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
    }
}
?>
