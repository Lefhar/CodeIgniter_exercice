<?php
// application/controllers/Produits.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produits extends CI_Controller 
{

    public function liste()
    {
            // Charge la librairie 'database'
    $this->load->database();
      // Exécute la requête 
      $results = $this->db->query("SELECT * FROM produits");  

    // Récupération des résultats    
    $aListe = $results->result(); 

        // Ajoute des résultats de la requête au tableau des variables à transmettre à la vue   
        $aView["liste_produits"] = $aListe;
        // Déclaration du tableau associatif à tranmettre à la vue
        $aProduits = array();
        $aViewHeader = ["title" => "Liste des produits"];

    // Appel des différents morceaux de vues
    $this->load->view('header', $aViewHeader);
    $this->load->view('liste', $aView);

    /* On pourrait très bien avoir des variables à passer au morceau de vue 'footer', 
    * mais, juste pour vous embêter, ce n'est pas le cas dans cet exemple ! 
    */
    $this->load->view('footer');
    }
}