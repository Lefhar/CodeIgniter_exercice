<!-- application/views/liste.php -->
<div class="container-fluid">
    <div class="row">
<div class="col-12">   
<article>
<h2>Nos produits</h2>
                <div class="dropdown m-2">
          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Trier par
          </button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
            <li class="dropdown-submenu">
              <a class="dropdown-item" tabindex="-1" href="#">Catégorie</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item"><a tabindex="-1" href="<?php echo site_url('produits/liste/cat/asc');?>">Croissant</a></li>
                <li class="dropdown-item"><a tabindex="-1" href="<?php echo site_url('produits/liste/cat/desc');?>">Décroissant</a></li>
              </ul>
            </li>
        
		
            <li class="dropdown-submenu">
              <a class="dropdown-item" tabindex="-1" href="#">Prix</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item"><a tabindex="-1" href="<?php echo site_url('produits/liste/prix/asc');?>">Croissant</a></li>
                <li class="dropdown-item"><a tabindex="-1" href="<?php echo site_url('produits/liste/prix/desc');?>">Décroissant</a></li>
              </ul>
            </li>
         </ul>
         <a class="btn btn-success float-right" href="<?php echo site_url('produits/ajouter');?>">Ajouter un produit</a>
        </div>
<div class="table-responsive">
                <table class="table table-sm table-striped table-striped-warning table-bordered"><!--début du tableau-->
                
            <thead class="thead-light">
              <tr>
              <th  scope="col">Photos</th><!--titre colonne 1-->
              <th scope="col" >ID</th><!--colonne 2-->
              <th scope="col">Référence</th><!--titre colonne 3-->
              <th scope="col">Libellé</th><!--titre colonne 4-->
              <th scope="col">Prix</th><!--titre colonne 5-->
              <th scope="col">Stock</th><!--titre colonne 6-->
              <th scope="col">Couleur</th><!--titre colonne 7-->
              <th scope="col">Ajout</th><!--titre colonne 8-->
              <th scope="col">Modif</th><!--titre colonne 9-->
              <th scope="col">Bloqué</th><!--titre colonne 9-->
            </tr>
            </thead>
            <tbody> 
<?php 

foreach ($liste_produits as $row) 
{

    echo '<tr  class="table-striped-warning">
    <td ><img width="100" src="'.base_url('assets/images/'.$row->pro_id.'.'.$row->pro_photo.'').'" alt="'.$row->cat_nom.' '.$row->pro_libelle.'"  title="'.$row->cat_nom.' '.$row->pro_libelle.'" class="img-fluid" /></td>
    <td>'.$row->pro_id.'</td>
    <td>'.$row->pro_ref.'</td>
    <td><a href="'.site_url("produits/detail/".$row->pro_id."").'" title="détail" alt="détail">'.$row->pro_libelle.'</a></td>
    <td>'.$row->pro_prix.'&euro;</td>
    <td>'.$row->pro_stock.'</td>
    <td>'.$row->pro_couleur.'</td>
    <td>'.$row->pro_d_ajout.'</td>
    <td>'.$row->pro_d_modif.'</td>
    <td>'.form_open("panier/ajouter").'
  
    
    <!-- champ visible pour indiquer la quantité à commander -->
    <label for="quantity">Quantité</label> 
    <input type="number" class="form-control" name="pro_qte" id="pro_qte" value="1">
    <input type="hidden" name="pro_prix" id="pro_prix" value="'.$row->pro_prix.'">
    <input type="hidden" name="pro_id" id="pro_id" value="'.$row->pro_id.'">
    <input type="hidden" name="pro_libelle" id="pro_libelle" value="'.$row->pro_libelle.'">
    
    <!-- Bouton Ajouter au panier -->
    <div class="form-group">
    <button class="btn btn-dark btn-sm" style="width:100%" type="submit" id="addcart">Ajouter au panier
    <i class="material-icons left"></i>
  </button>       
    </div>
    </form>
    <td>';
    
    if($row->pro_bloque ==1){echo '<span class="bloque">bloqué</span></td>';}
 echo '</td></tr>'; 
}

?>
                    </tbody>
                  </table> <!--fin du tableau-->
                  
                </div><!--fermeture de la div table responsive-->
                </article>
</div>
</div>
</div>