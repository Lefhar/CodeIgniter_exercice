<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>"> 
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!--bouton sur mobile-->
            <a class="nav-brand navbar-text" href="index.php">Jarditou</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link" href="<?php echo site_url("contact.php");?>">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url("accueil.php");?>">A propos</a>
                </li>
              
            </ul>
            <!--
                barre de recherche dans la nav bar
            -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <form class="form-inline ml-auto">
                  <div class="md-form my-0">
                    <input class="form-control" id="search"  name="search" type="text" placeholder="Votre promotion" aria-label="Search">
                  </div>
                  <button class="btn btn-outline-success btn-md my-0 ml-sm-2" type="submit">Rechercher</button>
                </form>
            
              </div>
        </div>
    </nav>
    <div class="container-fluid"><div class="row"><img src="<?php echo base_url("assets/images/promotion.jpg"); ?>" class="w-100" alt="Jarditou" title="Jarditou"></div></div>
    </header> 