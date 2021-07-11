<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */


    /**
     * \brief charge usersModel chargement de la page connexion
     * \return usersModel
     * \author Harold lefebvre
     * \date 01/02/2021
     *  @property UsersModel $usersModel
     */

    public function connexion()
    {
        // Chargement du modèle 'produitsModel'




        $this->load->model('usersModel');
        $aViewHeader = $this->usersModel->getUser();
        $aView =  $this->usersModel->connexion();

        $aViewHeader = ["title" => "Connexion",
            "url" => "/connexion", "user" => $aViewHeader];
        $this->load->view('header',$aViewHeader);
        $this->load->view('connexion',$aView);
        $this->load->view('footer');
    }

    /**
     * \brief charge usersModel chargement de la page inscription
     * \return usersModel
     * \author Harold lefebvre
     * \date 01/02/2021
     *  @property UsersModel $usersModel
     */
    public function inscription()
    {

        $this->load->model('usersModel');
        $aViewHeader = $this->usersModel->getUser();
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "%s est obligatoire.", "valid_email" => "ce n'est pas une adresse %s valide."));
        $this->form_validation->set_rules('password', 'Mot de passe', 'required|regex_match[`^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{12,})$`]', array("required" => "%s est obligatoire.", "regex_match" => "%s doit contenir au minimum 12 caractéres dont une majuscule un symbole."));
        $this->form_validation->set_rules('confirpassword', 'Confirmation mot de passe', 'required|matches[password]', array("regex_match" => "le %s ne correspond pas au champs mot de passe.","required" => "%s obligatoire."));
        $this->form_validation->set_rules('prenom', 'Prenom', 'required|regex_match[`^[a-zA-Z]{2,}$`]', array("regex_match" => "ce n'est pas un %s correct."));
        $this->form_validation->set_rules('nom', 'Nom', 'required|regex_match[`^[a-zA-Z]{2,}$`]', array("regex_match" => "ce n'est pas un %s correct."));

        //si Adresse est posté on contrôle alors si cela est correct
        if (!empty($this->input->post('adresse'))) {
            $this->form_validation->set_rules('adresse', 'Adresse', 'regex_match[/[0-9]{1,}\s+[a-z]{2,}\s+[a-z]{2,}/]', array("regex_match" => "ce n'est pas une %s correct."));
        }

        //si ville est posté on contrôle alors si cela est correct
        if (!empty($this->input->post('ville'))) {
            $this->form_validation->set_rules('ville', 'Ville', 'regex_match[`^[a-zA-Z]{1,}$`]', array("regex_match" => "ce n'est pas une %s correct."));
        }

        //si Code postal est posté on contrôle alors si cela est correct
        if (!empty($this->input->post('cp'))) {
            $this->form_validation->set_rules('cp', 'Code postal', 'regex_match[`^[0-9]{4,5}$`]', array("regex_match" => "ce n'est pas un %s correct."));
        }

        //si téléphone est posté on contrôle alors si cela est correct
        if (!empty($this->input->post('tel'))) {
            $this->form_validation->set_rules('tel', 'Téléphone', 'regex_match[`^[0-9]{10}$`]', array("regex_match" => "ce n'est pas un %s correct."));
        }


        if (!empty($this->session->login) && !empty($this->session->jeton)) {
            redirect('produits/liste');
            exit();
        }
        $aViewHeader = ["title" => "inscription",
            "url" => "/inscription","user" => $aViewHeader];
        $this->load->view('header',$aViewHeader);
        if ($this->form_validation->run() == TRUE) {
            $aView = $this->usersModel->inscription();
            $this->load->view('inscription',$aView);
        }else{
            $this->load->view('inscription');
        }



        $this->load->view('footer');
    }

    /**
     * \brief charge usersModel chargement de la page deconnexion
     * \return usersModel
     * \author Harold lefebvre
     * \date 01/02/2021
     *  @property UsersModel $usersModel
     */
    public function deconnexion()
    {
        // Chargement du modèle 'produitsModel'
        $this->load->model('usersModel');

        $this->usersModel->deconnexion();


        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Déconnection",
            "url" => "/deconnexion", "user" => $aViewHeader];
        $this->load->view('header',$aViewHeader);
        $this->load->view('deconnexion');
        $this->load->view('footer');
    }


    /**
     * \brief charge usersModel chargement de la page inscriptionvalide
     * \return usersModel
     * \author Harold lefebvre
     * \date 01/02/2021
     *  @property UsersModel $usersModel
     */
    public function inscriptionvalide()
    {
        // Chargement du modèle 'produitsModel'
        $this->load->model('usersModel');

        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau)
        * remarque la syntaxe $this->nomModele->methode()
        */

        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Validation d'inscription",
            "url" => "/inscriptionvalide","user" => $aViewHeader];
        $this->load->view('header',$aViewHeader);
        $this->load->view('inscriptionvalide');
        $this->load->view('footer');
    }


    /**
     * \brief charge usersModel chargement de la page validationemail
     * \return usersModel
     * \author Harold lefebvre
     * \date 01/02/2021
     *  @property UsersModel $usersModel
     */
    public function validationemail()
    {

        $this->load->model('usersModel');


        $aViewHeader = $this->usersModel->getUser();

        $aView =  $this->usersModel->validationemail($this->uri->segment(3));
        $aViewHeader = ["title" => "Validation email",
            "url" => "/validationemail","user" => $aViewHeader];
        $this->load->view('header',$aViewHeader);
        $this->load->view('validationemail', $aView);
        $this->load->view('footer');
    }


    /**
     * \brief charge usersModel chargement de la page resetpassword
     * \return usersModel
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function resetpassword()
    {
        // Chargement du modèle 'produitsModel'
        $this->load->model('usersModel');

        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau)
        * remarque la syntaxe $this->nomModele->methode()
        */

        $aViewHeader = $this->usersModel->getUser();

        if (!empty($this->session->login) && !empty($this->session->jeton)) {
            redirect('produits/liste');
            exit();
        }
        $aViewHeader = ["title" => "réinitialisation mot de passe",
            "url" => "/resetpassword","user" => $aViewHeader];


        $this->load->view('header',$aViewHeader);

        $this->form_validation->set_rules('password', 'Mot de passe', 'required|regex_match[`^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{12,})$`]', array("required" => "%s est obligatoire.", "regex_match" => "%s doit contenir au minimum 12 caractéres dont une majuscule un symbole."));
        $this->form_validation->set_rules('confirpassword', 'Confirmation mot de passe', 'required|matches[password]', array("required" => "%s est obligatoire.", "matches" => "%s ne correspond pas au mot de passe."));


        if($this->form_validation->run() == TRUE) {
           $aViews =  $this->usersModel->resetpassword($this->uri->segment(3));
            $this->load->view('resetpassword',$aViews);
        }else{
        $this->load->view('resetpassword');
        }
        $this->load->view('footer');
    }


    /**
     * \brief charge usersModel chargement de la page lostpassword
     * \return usersModel
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function lostpassword()
    {
        $this->load->model('usersModel');

        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau)
        * remarque la syntaxe $this->nomModele->methode()
        */
        $aView =  $this->usersModel->lostpassword($this->uri->segment(3));

        if($this->form_validation->run() == TRUE) {
            $aView =  $this->usersModel->lostpassword($this->uri->segment(3));
        }
        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Mot de passe perdu",
            "url" => "/lostpassword", "user" => $aViewHeader];
        $this->load->view('header',$aViewHeader);


        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "%s est obligatoire.", "valid_email" => "ce n'est pas une adresse %s valide."));


        $this->load->view('lostpassword',$aView);
        $this->load->view('footer');
    }


    /**
     * \brief charge usersModel chargement de la page resendemail
     * \return usersModel
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function resendemail()
    {

        $this->load->model('usersModel');

        /* On appelle la méthode liste() du modèle,
        * qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau)
        * remarque la syntaxe $this->nomModele->methode()
        */
        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Renvoi validation email",
            "url" => "/resendemail","user" => $aViewHeader];
        $this->load->view('header',$aViewHeader);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));
        if ($this->form_validation->run() == TRUE) {
            $aView = $this->usersModel->resendemail();
            $this->load->view('resendemail',$aView);
        }else{
            $this->load->view('resendemail');
        }



        $this->load->view('footer');
    }
}
