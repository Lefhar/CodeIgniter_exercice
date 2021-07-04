<?php
$tab['produit'] = array();
foreach($search as $row){
    $tabJson = ['title'=> $row->cat_nom.' '.$row->pro_libelle.' '.$row->pro_couleur, "picture"=>base_url('assets/images/' . $row->pro_id . '.' . $row->pro_photo . ''),"link"=>site_url('produits/detail/' . $row->pro_id)];
array_push($tab['produit'],$tabJson);
}
header('content-type:application/json');
echo json_encode($tab); 