<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php if(!empty($title)){echo $title;}?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css?id=".date('si').""); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.css"); ?>"> 
    <link rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.min.css"); ?>"> 
</head>
<body>
     
<header>
   <!--
        header

    -->   
        <!--

            logo du site avec le titre à droite
        -->
        <div class="container-fluid">
            <div class="row">
                <div class="col 12 col-lg-2 pt-2">
         
                <img src="<?php echo base_url("assets/images/jarditou_logo.jpg"); ?>"  class="img-fluid" alt="Jarditou" title="Jarditou">   
              </div>
            
              <div class="col 12 col-lg-10 pt-2">
                <div class="text-right h1">Tout le jardin</div>
            </div>
            </div>
    </div>
    <!--
        barre du menu
    -->
    <nav class="navbar navbar-expand-lg navbar-jarditou bg-jarditou">
            <!--bouton sur mobile-->
            <a class="nav-brand navbar-text text-light" href="">Jarditou</a>
              <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                      <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url("index.php");?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url("produits/liste");?>">Nos produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url("contact");?>">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url("about");?>">A propos</a>
                </li>
                <?php 
              

                if (empty($user['email'])) {
                    echo '<li class="nav-item ">
                    <a class="nav-link" href="'.site_url('users/connexion').'">Mon compte</a>
                    </li>';
                    
                }else{
                    echo '<li class="nav-item dropdown  bg-jarditou">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$user['nom'].' '.$user['prenom'].'
                    </a>
                    <div class="dropdown-menu bg-jarditou" aria-labelledby="navbarDropdown">
                    <a class="nav-link" href="account.php">Mon compte</a>
                            <a class="nav-link" href="'.site_url("users/deconnexion").'">Déconnexion</a>
                    </div>
                  </li>';
                }
                    ?>
            </ul>
            <!--
                barre de recherche dans la nav bar
            -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <form class="form-inline ml-auto">
                <div class="form-group">
<div class="md-form my-0">
<input class="form-control" id="search" name="search" type="text" placeholder="Votre promotion" aria-label="Search" autocomplete="off">
</div>
<button class="btn btn-outline-light btn-md my-0 ml-sm-2" type="submit">Rechercher</button>
    <div id="resultat"></div>
    </div>
                </form>
            
              </div>
        </div>
    </nav>
    <div class="container-fluid"><div class="row"><img src="<?php echo base_url("assets/images/promotion.jpg"); ?>" class="w-100" alt="Jarditou" title="Jarditou"></div></div>
    </header> 