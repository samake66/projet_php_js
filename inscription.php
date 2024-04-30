<?php
// Connexion à la base de données
include 'connec.php';

class Client {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registerClient($name, $email, $password) {
        // Vérifier si le client existe déjà
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM client WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return "Un compte avec cet e-mail existe déjà.";
        }

        // Insérer le client dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO client (name, email, password) VALUES (:name, :email, :password)");
        $result = $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        if ($result) {
            return "Inscription réussie.";
        } else {
            return "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        }
    }
}

// Traitement des informations d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Créer une instance de la classe Client
    $client = new Client($pdo);

    // Appeler la méthode d'inscription
    $message = $client->registerClient($name, $email, $password);

    // Retourner le message à l'utilisateur
    echo $message;
}
?>
