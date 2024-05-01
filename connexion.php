<?php
session_start(); // Démarre la session PHP

// Inclure le fichier de connexion
include "connec.php";

$pdo = new \PDO(DSN, USER, PASS);


// Vérifie si l'utilisateur est déjà connecté, si oui, redirige-le vers une autre page
//if (isset($_SESSION['idclient'])) {
  //  header("Location: accueil.php"); exit;}

$errorMessage = null;

// Vérifie si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    var_dump($_POST);

    // Validation de l'email

        $sql = "SELECT * FROM client   WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($client);

        // Vérifie si l'utilisateur existe et si le mot de passe est correct
        if(!empty($client)){

        echo $client['password'];
        if ($password == $client['password']) {
            // Stocke l'identifiant du client et l'email dans la session
            $_SESSION['idclient'] = $client['idclient'];
            $_SESSION['login'] = $client['email'];  // Ajouter l'email à la session
        }

            // Redirige l'utilisateur vers la page d'accueil
            header("Location: accueil.php");
        } else {
            echo "Adresse e-mail ou mot de passe incorrect.";?>
            <form action="connexion.php" method="POST">
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@example.com">
            <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <div class="alert alert-success" role="alert">
        Bonjour <?php echo htmlspecialchars($_SESSION['login']); ?> et bienvenue sur le site !
    </div>
       <?php }
    }

?>



    