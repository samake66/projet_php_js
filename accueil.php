<?php
// CONNEXION À LA BASE DE DONNÉES AVEC PDO
include 'connec.php';


@$val_recherche=$_POST['recherche'];
@$val_search=$_POST['search'];
session_start();




if(isset($val_search) && !empty(trim($val_recherche))){
  //requette
  $query="SELECT * FROM chambre as c
  INNER JOIN hotel as h ON c.hotel_idhotel = h.idhotel
  WHERE h.adresse LIKE '%$val_recherche%' ";

  $statement=$pdo->prepare($query);
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  $statement->execute();
  $chambres=$statement->fetchAll();
  $affiche_resultat="oui";
  //var_dump($book_author);
}

?>




<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="">HOME</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a class="nav-link active" href="index.php?page=hotel"><i class="fa-solid fa-layer-group"></i> Hotel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php?page=chambre"><i class="fa-light fa-book"></i> Chambre</a>
        </li>
       
 
      </ul> 
      <?php
      if(isset($_SESSION['login'])){ ?>
        <button class="btn btn-secondary"  type="button">
          <a href="deconnexion.php">Deconnexion</a>
        </button>
    <?php
      } ?>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
       <button class="btn btn-outline-info"  type="button">
          <a href="form_connexion.php">Connexion</a>
        </button>
        <button class="btn btn-outline-info"  type="button">
          <a href="form_inscription.php">Inscription</a>
        </button>
      </div>
      
    </div>
  </div>
</nav>

<div>
<form class="d-flex" role="search" action="" method="post">
        <input class="form-control me-2" type="search" name="recherche" value="<?php echo $val_recherche ?>" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" name="search" type="submit">Search</button>
      </form>
</div>

<?php
if(@$affiche_resultat== "oui"){?>


<div class="div_resultat">
    <?php
    //{}
    if(empty($chambres)){ ?>
    <div class="resultat2"> 
    <?php
      echo "Aucun resultat pour votre recherche!";
    }
    else{?>
      
    <div class="resultat1"> 
        <div class="titre_resultat">
        <h2> Les résultats de votre recherche : </h2>
        </div>
      <div class="row row-cols-1 row-cols-md-4 g-4">
      <?php
      foreach($chambres as $list_chambre){

        $id_chambre=$list_chambre['idchambre'];
        //requette nom de hotel
        $id_hotel=$list_chambre['hotel_idhotel'];
        $statement1=$pdo->query("select * from hotel where idhotel='$id_hotel'");
        //type de chambre
        $id_type=$list_chambre['type_idtype'];
        $statement2=$pdo->query("select name from type where idtype='$id_type'");
        //image de la chambre
        $query="SELECT * FROM image as i
          WHERE i.chambre_idchambre=$id_chambre ";
        $statement3=$pdo->query($query);


        //Recupere
        $hotel=$statement1->fetch(PDO::FETCH_ASSOC);
        $type=$statement2->fetch(PDO::FETCH_ASSOC);
        $image=$statement3->fetch(PDO::FETCH_ASSOC);
        ?>

      <div class="col">
        <h2><?=$hotel['name']?></h2>
        <img src="<?=$image['name']?>" alt="<?=$image['name']?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h3><?=$type['name']?></h3>
          <p class="card-text">(superficie: <?=$list_chambre['superficie'] ?>, prix: <?=$list_chambre['prix'] ?>)</p>
          <a href="reserver.php?id=<?=$list_chambre['idchambre']?>" class="btn btn-primary" >Reserver</a>
        </div>
      </div>
        <?php
      }?>
      
      </div>
    </div>
      <?php

    }
    
    ?>
  </div>
</div>
<?php } ?>
