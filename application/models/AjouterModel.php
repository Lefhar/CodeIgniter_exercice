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
       $sUploadErrors="";
       if ($this->input->post()) 
       { 
           
    
        
         /*
         * On a l'extension du fichier donc on peut enregistrer
         * en base de données 
         */

         /*
         * Pour créer le nom du fichier : il faut récupérer la clé primaire (pro_id) : 
         * - dans le cas du formulaire d'ajout : il faut récupérer avec la méthode $this-db->InsertId();
         * - dans le cas du formulaire de modification : on récupère le pro_id passé dans un champ de type hidden     
         */


        // 2ème appel de la page: traitement du formulaire
    
            $data = $this->input->post();
    
            // Définition des filtres, ici une valeur doit avoir été saisie pour le champ 'pro_ref'
            $this->form_validation->set_rules('pro_ref', 'Référence', 'required|min_length[6]|max_length[10]', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">La %s est obligatoire.</div>", "min_length" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit avoir longueur minimum de 6 caractères.</div>", "max_length" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit avoir longueur minimum de 10 caractères.</div>"));

            // Définition des filtres, ici une valeur doit avoir été saisie pour le champ 'pro_libelle'
            $this->form_validation->set_rules('pro_libelle', 'Libellé', 'required|min_length[6]', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s est obligatoire.</div>", "min_length" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit avoir longueur minimum de 6 caractères.</div>", "max_length" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit avoir longueur minimum de 200 caractères.</div>"));


            // Définition des filtres, ici une valeur doit avoir été saisie pour le champ 'pro_stock'
            $this->form_validation->set_rules('pro_stock', 'Stock', 'required|min_length[1]|numeric', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s est obligatoire.</div>", "min_length" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit avoir longueur minimum de 6 caractères.</div>", "max_length" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit avoir longueur minimum de 200 caractères.</div>", "numeric" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit être une valeur numérique.</div>"));
            
            // Définition des filtres, ici une valeur doit avoir été saisie pour le champ 'pro_prix'
            $this->form_validation->set_rules('pro_prix', 'Prix', 'required|min_length[1]|numeric', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s est obligatoire.</div>", "min_length" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit avoir longueur minimum de 6 caractères.</div>", "max_length" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit avoir longueur minimum de 200 caractères.</div>", "numeric" => "<div class=\"alert alert-danger\" role=\"alert\">Le %s doit être une valeur numérique.</div>"));
            
            // Définition des filtres, ici une valeur doit avoir été saisie pour le champ 'pro_description'
            $this->form_validation->set_rules('pro_description', 'Description', 'required|min_length[10]', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">La %s est obligatoire.</div>", "min_length" => "<div class=\"alert alert-danger\" role=\"alert\">La %s doit avoir une longueur minimum de 10 caractères.</div>", "max_length" => "<div class=\"alert alert-danger\" role=\"alert\">La %s doit avoir une longueur minimum de 1000 caractères.</div>"));


            if ($_FILES) 
            {
               // On extrait l'extension du nom du fichier 
               // Dans $_FILES["pro_photo"], pro_photo est la valeur donnée à l'attribut name du champ de type 'file'  
               $extension = substr(strrchr($_FILES["pro_photo"]["name"], "."), 1);
            }
 

            $config['upload_path'] = $_SERVER['DOCUMENT_ROOT']. '/ci/assets/images/'; // chemin où sera stocké le fichier
            // On indique les types autorisés (ici pour des images)
            $config['allowed_types'] = 'gif|jpg|jpeg|png'; 
            $this->load->library('upload', $config);
            if ($this->form_validation->run() == FALSE or !$this->upload->do_upload('pro_photo'))
            {
                
                // Echec de la validation, on réaffiche la vue formulaire 
              // Echec : on récupère les erreurs dans une variable (une chaîne)
             $sUploadErrors = $this->upload->display_errors("<div class='alert alert-danger'>", "</div>");    

            // on réaffiche la vue du formulaire en passant les erreurs 
            $aView["sUploadErrors"] = $sUploadErrors;

            /* On envoie le message d'erreur dans le fichier php_error.log,
            * voir explications ci-après
            */
            error_log($sUploadErrors, 0);

            /* Pour l'utilisateur, on envoie un message flash
            * n'oubliez pas, cela nécessite la librairie 'session'
            */ 
            $this->load->library('session'); 
            $this->session->set_flashdata('sUploadError2','Le téléchargement de la photo a échoué.');
            $this->load->view('ajouter', $aView);
            }
            else
            { // La validation a réussi, nos valeurs sont bonnes, on peut insérer en base
    
               $this->db->insert('produits', $data);
             // nom du fichier final
             
             $config['file_name'] = $this->db->insert_id().'.'.$extension; 
             // On initialise la config 

             $this->upload->initialize($config);

             rename($config['upload_path']."".$_FILES["pro_photo"]["name"],$config['upload_path']."".$config['file_name']);
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