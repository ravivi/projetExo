<?php 
//initialisation
$nom=$lprenom=$date=$sexe=$commune="";
$succes=false;
$error=false;
//la session au tout début!
session_start(); 
//si $post existe
if(isset($_POST['nom']) AND isset($_POST['prenom'])AND isset($_POST['date'])AND isset($_POST['sexe'])AND isset($_POST['commune']))
{
//on verifi que les variables ne son pas vide
if(!empty($_POST['nom']) AND !empty($_POST['prenom'])AND !empty($_POST['date'])AND !empty($_POST['sexe'])AND !empty($_POST['commune'])){
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$date = $_POST['date'];
$sexe = $_POST['sexe'];
$commune = $_POST['commune'];
//connection a la bdd
$bdd = new PDO('mysql:host=localhost;dbname=dimanche', 'root', '');
     $req = $bdd->prepare('SELECT * FROM user WHERE nom = ? and prenom = ?');
    $req->execute(array($nom, $prenom));
    while($ligne = $req->fetch())
    { 
        if($ligne['nom'] == $nom and $ligne['prenom']== $prenom)
        { 
            echo'Ce nom et ce prenom sont déja pris';
            echo'<br><br><br><br>';
            echo"<a href='index.php'>Retour</a>";
    
        }
        die();
    }
//insertion à la bdd 
$req = $bdd->prepare('INSERT INTO user (nom,prenom,date, sexe,commune) VALUES (:nom, :prenom, :date, :sexe, :commune)');
$req->execute(array( 'nom'=>$nom, 'prenom'=>$prenom,'date' => $date, 'sexe' => $sexe,'commune' => $commune));
    $succes=true;
//      $suc="reussi";
}
else 
{ 
  $error=true;
}
}
?>






<?php 
$login=$mdp="";
$messageError="";
$verif=false;
$messageError=false;
//session_start();
//    ;
if(isset($_POST['login']) AND isset($_POST['mdp']))
   
{
     if(!empty($_POST['login']) OR !empty($_POST['mdp']))
    {
        
    
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    $bdd = new PDO('mysql:host=localhost;dbname=dimanche', 'root', '');
    //on selectionne tout dans la bdd avec le log et mdp poster
    $req = $bdd->prepare('SELECT * FROM admin WHERE login = ? and mdp = ?');
    $req->execute(array($login, $mdp));
    while($ligne = $req->fetch())
    { 
        if($ligne['login'] == $login and $ligne['mdp']== $mdp)
        { 
            $verif = true;
        }
        else
        {
            $verif = false;
        }
    }
    if ($verif == true) 
    {
        $_SESSION['login'] = $ligne['login'];
        $_SESSION['mdp'] = $ligne['mdp'];
        header('Location: admin.php');
  exit();
    }
    elseif ($verif == false)
    {
      $messageError=true;
    } 
         }
}
?>














<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script><script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <title>INSCRIPTION</title>
</head>
<body>
    <nav id="navbar-example2" class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">Express Ci</a>
   <a class="navbar-brand"><div class="alert alert-primary" role="alert" style="display:<?php if($succes) echo 'block'; else echo'none'?>">
  Bienvenu <?php echo $nom.' '.$prenom;?>
</div></a>
  <a class="navbar-brand"><div class="alert alert-danger" role="alert" style="display:<?php if($error) echo 'block'; else echo'none'?>">
  Vous n'êtes pas encore un abonné réessayez encore!!!!!
</div></a>
 </div></a>
   <a class="navbar-brand"><div class="alert alert-danger" role="alert" style="display:<?php if($messageError) echo 'block'; else echo'none'?>">
  Vous n'êtes pas un administrateur
</div></a>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a class="nav-link" href="#fat">Accueil</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#mdo" data-toggle="modal" data-target="#user">Inscription</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="com.php">Communauté</a>
      
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#mdo" data-toggle="modal" data-target="#admin">Espace admin</a>
    </li>
  </ul>
</nav>
       <div class="bd-example">
  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/maison1.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Express Ci tout en UN</h5>
          <p>Conçu pour les gens pas pour l'argent.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/maison2.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
           <h5>Express Ci tout en UN</h5>
          <p>Conçu pour les gens pas pour l'argent.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/maison3.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Express Ci tout en UN</h5>
          <p>Conçu pour les gens pas pour l'argent.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Formulaire d'inscription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form class="form-horizontal"  method="post" action="">
               
               
        <!-- Champ du nom et prenom de celui qui poste le commentaire-->
                <div class="form-group">
                    <label class="col-md-6 control-label" for="nom">Nom</label>  
                    <div class="col-lg-12">
                    <input type="text" id="nom" name="nom" placeholder="" class="form-control input-lg">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-md-6 control-label" for="prenom">Prenom</label>  
                    <div class="col-lg-12">
                    <input type="text" id="prenom" name="prenom" placeholder="" class="form-control input-lg">
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-6 control-label" for="date">Date de naissance</label>  
                  <div class="col-lg-12">
                  <input type="text" id="date" name="date" placeholder="" class="form-control input-lg">

                  </div>
                </div>
                 <div class="row">
                  <div class="input-group col-md-6">
  <div class="input-group-prepend">
    <label class="input-group-text" for="sexe">Sexe</label>
  </div>
  <select class="custom-select" id="sexe" name="sexe">
    <option selected>Choisissez</option>
    <option>Homme</option>
      <option>Femme</option>
  </select>
</div>
                                   <div class="input-group col-md-6">
  <div class="input-group-prepend">
    <label class="input-group-text" for="commune">Commune</label>
  </div>
  <select class="custom-select" id="commune" name="commune">
      <option selected>Choisissez</option>
      <option>Abobo</option>
      <option>Adjamé</option>
      <option>Attécoubé</option>
      <option>Cocody</option>
      <option>Koumassi</option>
      <option>Marcory</option>
      <option>Plateau</option>
      <option>Port-Bouet</option>
      <option>Treichville</option>
      <option>Yopougon</option>

  </select>
</div>

                  </div>
                  </div>
                
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>

                </div>
   
        </form>
       <!--   Fin du formulaire     -->
      </div>
<!--
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
-->
    </div>
  </div>
</div>



<div class="modal fade" id="admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Formulaire d'inscription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form class="form-horizontal"  method="post" action="">
               
               
        <!-- Champ du nom et prenom de celui qui poste le commentaire-->
                <div class="form-group">
                    <label class="col-md-6 control-label" for="login">Login</label>  
                    <div class="col-lg-12">
                    <input type="text" id="login" name="login" placeholder="" class="form-control input-lg">
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-6 control-label" for="mdp">Mot de passe</label>  
                  <div class="col-lg-12">
                  <input type="password" id="mdp" name="mdp" placeholder="" class="form-control input-lg">

                  </div>
                </div>
                
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>

                </div>
   
        </form>
       <!--   Fin du formulaire     -->
      </div>
    </div>
  </div>
</div>

</body>
</html>