<h1>Mon panier</h1>

<!-- application/views/detail.php -->
<div class="container">
    <div class="row">
<div class="col-12">   
<article>
<?php 
// Si le panier n'existe pas encore  
if ($this->session->panier != null) 
{ 
?>
    <div class="row">
    <div class="col-12"> 
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Prix total</th>
                <th>&nbsp;</th> 
            </tr>   
        </thead>
        <tbody>
        <?php 
        $iTotal = 0;
        foreach($panier as $article){
  


//    var_dump($article);   
//    echo $article;
// echo 'aaa'.$article[$key].'';
// echo 'aaa'.$article["pro_qte"].'';


echo '
'.form_open("panier/ajouter").'
  
    
    <!-- champ visible pour indiquer la quantité à commander -->
    <label for="quantity">Quantité</label> 
    <input type="number" class="form-control" name="pro_qte" id="pro_qte" value="'.$article['pro_qte'].'">
    <input type="text" name="pro_prix" id="pro_prix" value="'.$article['pro_prix'].'">
    <input type="text" name="pro_id" id="pro_id" value="'.$article['pro_id'].'">
    <input type="text" name="pro_libelle" id="pro_libelle" value="'.$article['pro_libelle'].'">
    
    <!-- Bouton Ajouter au panier -->
    <div class="form-group">
    <button class="btn btn-dark btn-sm" style="width:100%" type="submit" id="addcart">Ajouter au panier
    <i class="material-icons left"></i>
  </button>       
    </div>
    </form>


';
}

        
var_dump($panier);
        /* ici, écrire le code pour afficher les produits mis dans le panier...
        * ... oh oh oh! ça sent la boucle...  
        * n'oubliez pas de calculer le total,
        * ni d'ajouter de mettre un champ de type number pour augmenter/diminuer la quantité d'un produit
        */
        ?>
        </tbody>
    </table>
    </div>
    <div>
        <div>
            <h3>Récapitulatif</h3>
            <div>
                <p>TOTAL : <?= str_replace('.', ',' , $iTotal); ?> &euro;</p>
                <p href="<?= site_url("panier/supprimerPanier"); ?>" >Supprimer le panier</a></p> 
                <p><a href="<?= site_url("produits/liste"); ?>">Retour liste des produits</a></p>
            </div>
        </div>
    </div>
    </div>
    <?php 
    } 
    else 
    { 

        ?>
        <div class="alert alert-danger">Votre panier est vide. Pour le remplir, vous pouvez consulter <a href="<?= site_url("produits/liste"); ?>">la liste des produits</a>.</div>
        <?php 
    } 
    ?>
     </article>
        </div>
    </div>
</div>