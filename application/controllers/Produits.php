<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Produits extends CI_Controller
{
    public function liste()
    {
    
    
        // NOUVEAU CODE 
    
        // Chargement du modèle 'produitsModel'
        $this->load->model('produitsModel');
    
        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
        * remarque la syntaxe $this->nomModele->methode()       
        */
        $aListe = $this->produitsModel->liste();
    

    
        // -- fin NOUVEAU CODE
    } // -- liste()  
}     

?>