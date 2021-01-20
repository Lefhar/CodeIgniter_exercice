<?php
// application/controllers/detail.php

defined('BASEPATH') OR exit('No direct script access allowed');

class deleteModel extends CI_Model 
{
    public function delete($id)
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
        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Confirmation de suppréssion du produit","user" => $aViewHeader];
        $this->load->view('header', $aViewHeader);
        if ($this->input->post()) 
        { // 2ème appel de la page: traitement du formulaire

           $data = $this->input->post();
          
    // var_dump($data);
    // echo $this->input->post('confirm');

           if ($this->input->post('confirm') !="yes")
           { // Echec de la validation, on réaffiche la vue formulaire 
               $this->load->view('delete', $aView);
           }
           else
           { 
               // La validation a réussi, nos valeurs sont bonnes, on peut supprimer en base  
    
              /* Utilisation de la méthode where() toujours 
              * avant select(), insert() ou update()
              * dans cette configuration sur plusieurs lignes 
              */  
              unlink($config['fileproduit']);//on supprime la photo 
            $this->db->where('pro_id', $id);//défini la condition pro_id = id
            $this->db->delete('produits');//on efface le produit de la base
    
             redirect("produits/liste");
          }
        } 
        else 
        { // 1er appel de la page: affichage du formulaire             
           $this->load->view('delete', $aView);
        }
        $this->load->view('footer');
    } // -- modifier()

}