<?php
// application/controllers/detail.php

defined('BASEPATH') OR exit('No direct script access allowed');

class ajouterModel extends CI_Model 
{

    public function ajouter()
    {
       // Chargement des assistants 'form' et 'url'
       $this->load->helper('form', 'url'); 
    
       // Chargement de la librairie 'database'
       $this->load->database(); 
       $results = $this->db->query("SELECT cat_nom, cat_id  FROM  categories  ORDER BY cat_nom asc");  

       // Récupération des résultats    
       $aCat = $results->result(); 
       $aView["categorie"] = $aCat;
       $aViewHeader = ["title" => "Ajouter un produit"];
       // Chargement de la librairie form_validation
       $this->load->library('form_validation'); 
       $this->load->view('header', $aViewHeader);
       if ($this->input->post()) 
       { // 2ème appel de la page: traitement du formulaire
    
            $data = $this->input->post();
    
            // Définition des filtres, ici une valeur doit avoir été saisie pour le champ 'pro_ref'
            $this->form_validation->set_rules("pro_ref", "Référence", "required");
    
            if ($this->form_validation->run() == FALSE)
            { // Echec de la validation, on réaffiche la vue formulaire 
             
                  $this->load->view('ajouter', $aView);
            }
            else
            { // La validation a réussi, nos valeurs sont bonnes, on peut insérer en base
    
                $this->db->insert('produits', $data);
    
                redirect("produits/liste");
            }       
        } 
        else 
        { // 1er appel de la page: affichage du formulaire
               $this->load->view('ajouter', $aView);
        }
        $this->load->view('footer');
    } // -- ajouter() 
}