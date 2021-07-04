<?php
// application/controllers/detail.php

defined('BASEPATH') OR exit('No direct script access allowed');

class deleteModel extends CI_Model 
{


    /**
     * \brief charge la vu par delete de deleteModel (suppréssion de produit)
     * \param  $id     id du produit
     * \return redirection sur produits/liste
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function delete($id): array
    {
        // Chargement des assistants 'form' et 'url'
        $this->load->helper('form', 'url'); 
    
        // Chargement de la librairie 'database'
        $this->load->database();  
    
        // Chargement de la librairie form_validation
        $this->load->library('form_validation'); 
    
        // Requête de sélection de l'enregistrement souhaité, ici le produit 7 
        $produit = $this->db->query("SELECT * FROM produits  join categories on cat_id = pro_cat_id  WHERE pro_id= ?", $id);
        $aView["produit"] = $produit->row(); // première ligne du résultat

        $config['fileproduit'] = $_SERVER['DOCUMENT_ROOT']. '/ci/assets/images/'.$id.'.'.$aView["produit"]->pro_photo; // chemin où sera stocké le fichier

        if ($this->input->post()) 
        { // 2ème appel de la page: traitement du formulaire

           $data = $this->input->post();
          
    // var_dump($data);
    // echo $this->input->post('confirm');

           if ($this->input->post('confirm') =="yes")
           { // Echec de la validation, on réaffiche la vue formulaire 


              unlink($config['fileproduit']);//on supprime la photo 
            $this->db->where('pro_id', $id);//défini la condition pro_id = id
            $this->db->delete('produits');//on efface le produit de la base
    
             redirect("produits/liste");
          }


        }

        return $aView;
    } // -- modifier()

}