<!-- application/views/liste.php -->
<div class="container-fluid">
    <div class="row">
<div class="col-12">   
<article>
<h2>Nos produits</h2>
                <div class="dropdown m-2">
          <button class="btn btn-jarditou dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
         <a class="btn btn-jarditou float-right" href="<?php echo site_url('produits/ajouter');?>">Ajouter un produit</a>
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
              <th scope="col">Panier <?php if(!empty($this->session->panier)){ 
                $iTotal =0;
                        foreach($this->session->panier as $article){
                          $iTotal += $article['pro_qte'] ;
                        }
                
                
                echo  '<span class="badge badge-info">'.$iTotal.' Produit(s)</span> ';
                
                //sizeof($this->session->panier);
                
                
                      
                }?><a href="<?php echo site_url('panier/afficherPanier');?>">Voir</a></th><!--titre colonne 9-->
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
';
    
    if($row->pro_bloque ==1){echo '<td><span class="bloque">bloqué</span></td>';}else{echo '<td></td>';}
    if($row->pro_bloque !=1){
  echo '  <td>'.form_open('panier/ajouter','class="form-inline"').'
  
  
    <!-- champ visible pour indiquer la quantité à commander -->
 
 <!--<input type="number" class="form-control" id="pro_qte['.$row->pro_id.']" name="pro_qte" value="1">-->
 <div class="col-sm-8">
    <div class="input-group">
          <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-number d-none d-md-block" data-type="minus" data-field="pro_qte['.$row->pro_id.']">
                <span class="fa fa-minus"></span>
              </button>
          </span>
          <input type="text" id="pro_qte['.$row->pro_id.']" name="pro_qte" class="form-control input-number sm" value="'.set_value('pro_qte','1').'" min="1" max="100">
          <span class="input-group-btn">
              <button type="button" class="btn btn-success btn-number d-none d-md-block" data-type="plus" data-field="pro_qte['.$row->pro_id.']">
                  <span class="fa fa-plus"></span>
              </button>
          </span>
          <span class="input-group-btn input-group-btn d-md-ml-1">
          <button class="btn btn-dark " type="submit">  <span class="fa fa-shopping-cart"></span> </button>
        </span>
      </div>

      <input type="hidden" name="pro_prix" id="pro_prix" value="'.$row->pro_prix.'">
      <input type="hidden" name="pro_id" id="pro_id" value="'.$row->pro_id.'">
      <input type="hidden" name="pro_libelle" id="pro_libelle" value="'.$row->cat_nom.' '.$row->pro_libelle.'">
    <!-- Bouton Ajouter au panier -->
    </div>
    </form>
    </td>';
    }else{ echo '<td> </td>';}
 echo '</tr>'; 
}

?>
                    </tbody>
                  </table> <!--fin du tableau-->
                  
                </div><!--fermeture de la div table responsive-->
                </article>
</div>
</div>
</div>