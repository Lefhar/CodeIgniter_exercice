<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Produits extends CI_Controller
{


    /**
     * \brief vu par defaut de la liste des produit
     * \return page si l'email est bien envoyé de contact charge le modéle contactModel et usersModel pour si l'utilisateur est connecté
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function liste()
    {
        $champs = "";
        $order = "";
        $champs =$this->uri->segment(3);  
        $order =$this->uri->segment(4);  
        // NOUVEAU CODE 
        $this->load->model('usersModel');
  
        // Chargement du modèle 'produitsModel'
        $this->load->model('produitsModel');
    
        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
        * remarque la syntaxe $this->nomModele->methode()       
        */


        /**
         * \brief charge model liste
         * \param  $champs    le type dans l'url cat, prix, id etc
         * \param  $order    recupére si desc et asc
         * \return page si l'email est bien envoyé de contact charge le modéle contactModel et usersModel pour si l'utilisateur est connecté
         * \author Harold lefebvre
         * \date 01/02/2021
         */
        $aListe = $this->produitsModel->liste($champs,$order);
    

    
        // -- fin NOUVEAU CODE
    } // -- liste()

    /**
     * \brief charge detailsModel
     * \return page détail du produit par l'id appeler dans le model
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function detail()
    {
    
      $this->load->model('usersModel');
    

        // Chargement du modèle 'produitsModel'
        $this->load->model('detailsModel');
    
        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
        * remarque la syntaxe $this->nomModele->methode()       
        */
        $aListe = $this->detailsModel->detail();
    
 } // -- detail()  


    /**
     * \brief charge ajouterModel
     * \return ajouterModel
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function ajouter()
    {
      $this->load->model('usersModel');

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
      $this->load->model('usersModel');

        $id =$this->uri->segment(3);  
      // Chargement du modèle 'produitsModel'
      $this->load->model('modifierModel');
    
      /* On appelle la méthode modifier($id) du modèle,
      * qui retourne les champs sur le produit 
      * remarque la syntaxe $this->nomModele->methode()       
      */
      $aListe = $this->modifierModel->modifier($id);
    } 


    public function delete()
    {
      $this->load->model('usersModel');
        $id =$this->uri->segment(3);  
      // Chargement du modèle 'produitsModel'
      $this->load->model('deleteModel');
    
      /* On appelle la méthode liste() du modèle,
      * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
      * remarque la syntaxe $this->nomModele->methode()       
      */
      $aListe = $this->deleteModel->delete($id);
    }

    public function stockage()
    {
        $champs = "";
        $order = "";
        $champs =$this->uri->segment(3);

        // NOUVEAU CODE
        $this->load->model('usersModel');

        // Chargement du modèle 'produitsModel'
        $this->load->model('stockageModel');

        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau)
        * remarque la syntaxe $this->nomModele->methode()
        */
         $this->stockageModel->index($champs);



        // -- fin NOUVEAU CODE
    }
}     

