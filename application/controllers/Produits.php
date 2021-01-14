<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Produits extends CI_Controller
{
    public function liste()
    {
        $champs = "";
        $order = "";
        $champs =$this->uri->segment(3);  
        $order =$this->uri->segment(4);  
        // NOUVEAU CODE 
    
        // Chargement du modèle 'produitsModel'
        $this->load->model('produitsModel');
    
        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
        * remarque la syntaxe $this->nomModele->methode()       
        */
        $aListe = $this->produitsModel->liste($champs,$order);
    

    
        // -- fin NOUVEAU CODE
    } // -- liste()  
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
    
 } // -- detail()  
 
    public function ajouter()
    {

      // On créé un tableau de configuration pour l'upload

  
      // Chargement du modèle 'produitsModel'
      $this->load->model('ajouterModel');
    
      /* On appelle la méthode liste() du modèle,
      * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
      * remarque la syntaxe $this->nomModele->methode()       
      */

      $aListe = $this->ajouterModel->ajouter();
    } // -- ajouter()

 
    public function modifier()
    {
        $id =$this->uri->segment(3);  
      // Chargement du modèle 'produitsModel'
      $this->load->model('modifierModel');
    
      /* On appelle la méthode liste() du modèle,
      * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
      * remarque la syntaxe $this->nomModele->methode()       
      */
      $aListe = $this->modifierModel->modifier($id);
    } 

}     

?>