<!-- application/views/liste.php -->
<div class="container-fluid">
    <div class="row">
<div class="col-12">   
<article>
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
    <td><a href="'.site_url("detail.php?pro_id='.$row->pro_id.'").'" title="détail" alt="détail">'.$row->pro_libelle.'</a></td>
    <td>'.$row->pro_prix.'&euro;</td>
    <td>'.$row->pro_stock.'</td>
    <td>'.$row->pro_couleur.'</td>
    <td>'.$row->pro_d_ajout.'</td>
    <td>'.$row->pro_d_modif.'</td>
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