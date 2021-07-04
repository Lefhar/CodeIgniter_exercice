<?php
// application/controllers/Produits.php

defined('BASEPATH') or exit('No direct script access allowed');

class stockageModel extends CI_Model
{


    /**
     * \brief stockageModel petit défit de germain de générer par l'id un exel des stocks jarditou
     * \param  $champs   id catégorie
     * \return vu stock
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function index($champs)
    {



        $this->db->select('pro_id, cat_nom , pro_libelle, pro_prix, pro_couleur, pro_photo, pro_ref, pro_stock, pro_d_ajout, pro_d_modif, pro_bloque');
        $this->db->from('produits');
        $this->db->join('categories', 'cat_id = pro_cat_id');
        $this->db->where('pro_cat_id',$champs);
        $result = $this->db->get();
        $aListe = $result->result();
        // Ajoute des résultats de la requête au tableau des variables à transmettre à la vue
        $aView["liste_produits"] = $aListe;


        /* On pourrait très bien avoir des variables à passer au morceau de vue 'footer', 
        * mais, juste pour vous embêter, ce n'est pas le cas dans cet exemple ! 
        */
        return $aView;
    }
}