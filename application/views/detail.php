<!-- application/views/detail.php -->
<div class="container-fluid">
    <div class="row">
<div class="col-12">   
<article>
<div class="card m-4" >
<?php 
if(!empty($infoprod)) {
    foreach ($infoprod as $row) {
        $stock = "";
        if (!$row->pro_bloque) {
            $stock = $row->pro_stock - $row->pro_bloque;
        }
        echo ' 
    <img  class="img-fluid" width="160" src="' . base_url('assets/images/' . $row->pro_id . '.' . $row->pro_photo . '') . '" alt="' . $row->cat_nom . ' ' . $row->pro_libelle . ' ' . $row->pro_couleur . '" 
    title="' . $row->cat_nom . ' ' . $row->pro_libelle . ' ' . $row->pro_couleur . '">
    <div class="card-body">
      <h5 class="card-title">' . $row->cat_nom . ' ' . $row->pro_libelle . ' ' . $row->pro_couleur . '</h5>
      <p class="card-text">' . $row->pro_description . '</p>
      <p class="card-text">Prix : ' . $row->pro_prix . '&euro;</p>
      <p class="card-text">Stock : ' . $stock . ' Produit disponible</p>
      <p class="card-text">Référence : ' . $row->pro_ref . '</p>
      <p class="card-text">catégorie : ' . $row->cat_nom . '</p>
      <p class="card-text">Ajouté le : ' . $row->pro_d_ajout . '</p>
      <a href="' . site_url('produits/modifier/' . $row->pro_id) . '" class="btn btn-primary">Modifier</a>   <a href="' . site_url('produits/delete/' . $row->pro_id . '') . '"   class="btn btn-danger">Supprimer le produit</a>
  
  ';

    }
}
?>  </div>
</div>
                </article>
</div>
</div>
</div>