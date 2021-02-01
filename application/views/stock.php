<?php if(!empty($liste_produits)){
    $excel = "";
    $excel .=  "pro_id\tcat_nom\tpro_libelle\tpro_prix\tpro_couleur\tpro_ref\tpro_stock\tpro_d_ajout\tpro_d_modif\tpro_bloque\n";

    foreach($liste_produits as $row) {
        $excel .= "$row->pro_id\t$row->cat_nom\t$row->pro_libelle\t$row->pro_prix\t$row->pro_couleur\t$row->pro_ref\t$row->pro_stock\t$row->pro_d_ajout\t$row->pro_d_modif\t$row->pro_bloque\n";
    }

  header("Content-type: application/vnd.ms-excel");
  header("Content-disposition: attachment; filename=stock-jarditou.xls");

//   var_dump($excel);
    print $excel;

    exit;















}