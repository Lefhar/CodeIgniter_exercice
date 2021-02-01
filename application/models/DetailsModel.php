<?php
// application/controllers/detail.php

defined('BASEPATH') OR exit('No direct script access allowed');

class detailsModel extends CI_Model 
{


    /**
     * \brief charge la vu de detail par detailsModel (édition de produit)
     * \return redirection sur produits/liste
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function detail()
    {
            // Charge la librairie 'database'
    $this->load->database();

      // Exécute la requête 
      $pro_id =$this->uri->segment(3);          
       $this->db->select("pro_id, cat_nom , cat_id, pro_libelle, pro_prix, pro_couleur, pro_photo, pro_description, pro_bloque, pro_stock, pro_ref, pro_d_ajout");
       $this->db->from('produits');
       $this->db->join('categories', 'cat_id = pro_cat_id');
       $this->db->where('pro_id',$pro_id);

      //$aProduit = $this->query();
      $result = $this->db->get();

    // Récupération des résultats    
    $aProduit = $result->result(); 

        // Ajoute des résultats de la requête au tableau des variables à transmettre à la vue   
        $aView["infoprod"] = $aProduit;
        // Déclaration du tableau associatif à tranmettre à la vue
        // var_dump($aProduit);
        $aViewHeader = $this->usersModel->getUser();

        foreach ($aProduit as $head)
{
        $aViewHeader = ["title" => "$head->cat_nom $head->pro_libelle","description" => "Modification de $head->cat_nom $head->pro_libelle","user" => $aViewHeader];
}
    // Appel des différents morceaux de vues

    $this->load->view('header', $aViewHeader);
    $this->load->view('detail', $aView);

    /* On pourrait très bien avoir des variables à passer au morceau de vue 'footer', 
    * mais, juste pour vous embêter, ce n'est pas le cas dans cet exemple ! 
    */
    $this->load->view('footer');
    }
}