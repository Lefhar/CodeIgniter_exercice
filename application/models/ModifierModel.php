<?php
// application/controllers/detail.php

defined('BASEPATH') OR exit('No direct script access allowed');

class modifierModel extends CI_Model 
{
    public function modifier($id)
    {
        // Chargement des assistants 'form' et 'url'
        $this->load->helper('form', 'url'); 
    
        // Chargement de la librairie 'database'
        $this->load->database();  
    
        // Chargement de la librairie form_validation
        $this->load->library('form_validation'); 
    
        // Requête de sélection de l'enregistrement souhaité, ici le produit 7 
        $produit = $this->db->query("SELECT * FROM produits WHERE pro_id= ?", $id);
        $aView["produit"] = $produit->row(); // première ligne du résultat
        $aViewHeader = ["title" => "Modifier un produit"];
        $this->load->view('header', $aViewHeader);
        if ($this->input->post()) 
        { // 2ème appel de la page: traitement du formulaire
    
           $data = $this->input->post();
    
           // Définition des filtres, ici une valeur doit avoir été saisie pour le champ 'pro_ref'
           $this->form_validation->set_rules('pro_ref', 'Référence', 'required');
    
           if ($this->form_validation->run() == FALSE)
           { // Echec de la validation, on réaffiche la vue formulaire 
               $this->load->view('modifier', $aView);
           }
           else
           { // La validation a réussi, nos valeurs sont bonnes, on peut modifier en base  
    
              /* Utilisation de la méthode where() toujours 
              * avant select(), insert() ou update()
              * dans cette configuration sur plusieurs lignes 
              */  
              $this->db->where('pro_id', $id);
              $this->db->update('produits', $data);
    
              redirect("produits/liste");
          }
        } 
        else 
        { // 1er appel de la page: affichage du formulaire             
           $this->load->view('modifier', $aView);
        }
        $this->load->view('footer');
    } // -- modifier()

}