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

        $champs = $this->uri->segment(3);
        $order = $this->uri->segment(4);
        // NOUVEAU CODE




        $this->load->model('usersModel');
        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Liste des produits", "user" => $aViewHeader];


        /**
         * \brief charge model liste
         * \param  $champs    le type dans l'url cat, prix, id etc
         * \param  $order    recupére si desc et asc
         * \return page si l'email est bien envoyé de contact charge le modéle contactModel et usersModel pour si l'utilisateur est connecté
         * \author Harold lefebvre
         * \date 01/02/2021
         */
        $this->load->model('produitsModel');
        $aListe = $this->produitsModel->liste($champs, $order);

        $this->load->view('header', $aViewHeader);
        $this->load->view('liste', $aListe);
        $this->load->view('footer');

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
        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Detail du produit", "user" => $aViewHeader];

        // Chargement du modèle 'produitsModel'
        $this->load->model('detailsModel');

        /* On appelle la méthode liste() du modèle,
            * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau)
            * remarque la syntaxe $this->nomModele->methode()
            */
        $aListe = $this->detailsModel->detail();
        $this->load->view('header', $aViewHeader);
        $this->load->view('detail', $aListe);
        $this->load->view('footer');
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
        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Ajouter un produit", "user" => $aViewHeader];



        if(empty($aViewHeader['user']) or $aViewHeader['user']['role']< 1){
            redirect("produits/liste");
        }

        // Chargement du modèle 'produitsModel'
        $this->load->model('ajouterModel');

        /* On appelle la méthode liste() du modèle,
          * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau)
          * remarque la syntaxe $this->nomModele->methode()
          */

        $aListe = $this->ajouterModel->ajouter();
        $this->load->view('header', $aViewHeader);
        $this->load->view('detail', $aListe);
        $this->load->view('footer');
    } // -- ajouter()


    public function modifier()
    {
        $this->load->model('usersModel');
        $aViewHeader = $this->usersModel->getUser();
        if(empty($aViewHeader['user']) or $aViewHeader['user']['role']< 1){
            redirect("produits/liste");
        }
        $aViewHeader = ["title" => "Ajouter un produit", "user" => $aViewHeader];

        $id = $this->uri->segment(3);
        // Chargement du modèle 'produitsModel'
        $this->load->model('modifierModel');

        /* On appelle la méthode modifier($id) du modèle,
          * qui retourne les champs sur le produit
          * remarque la syntaxe $this->nomModele->methode()
          */
        $aListe = $this->modifierModel->modifier($id);
        $this->load->view('header', $aViewHeader);
        $this->load->view('modifier', $aListe);
        $this->load->view('footer');
    }


    public function delete()
    {
        $this->load->model('usersModel');
        $aViewHeader = $this->usersModel->getUser();
        if(empty($aViewHeader['user']) or $aViewHeader['user']['role']< 1){
            redirect("produits/liste");
        }
        $aViewHeader = ["title" => "Ajouter un produit", "user" => $aViewHeader];
        $id = $this->uri->segment(3);
        // Chargement du modèle 'produitsModel'
        $this->load->model('deleteModel');

        /* On appelle la méthode liste() du modèle,
          * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau)
          * remarque la syntaxe $this->nomModele->methode()
          */
        $aListe = $this->deleteModel->delete($id);
        $this->load->view('header', $aViewHeader);
        $this->load->view('delete', $aListe);
        $this->load->view('footer');
    }

    public function search()
    {
        $this->load->model('produitsModel');
        $aView['search'] = $this->produitsModel->search($this->uri->segment(3));

        $this->load->view('search', $aView);
    }

    public function stockage()
    {
        $champs = $this->uri->segment(3);

        // NOUVEAU CODE
        $this->load->model('usersModel');

        // Chargement du modèle 'produitsModel'
        $this->load->model('stockageModel');

     // on charge le modéle stockage qui va nous retourner la liste de nos produit
        $aView = $this->stockageModel->index($champs);
        $this->load->view('stock', $aView);

        // -- fin NOUVEAU CODE
    }
}