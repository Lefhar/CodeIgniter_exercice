<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Details extends CI_Controller
{
    public function detail()
    {
    
    
        // NOUVEAU CODE 
    
        // Chargement du modèle 'produitsModel'
        $this->load->model('detailsModel');
    
        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
        * remarque la syntaxe $this->nomModele->methode()       
        */
        $aListe = $this->detailsModel->detail();
    
     
 
    
        // -- fin NOUVEAU CODE
    } // -- liste()  
}     

?>