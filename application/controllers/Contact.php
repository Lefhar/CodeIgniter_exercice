<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */


    /**
     * \brief vu par defaut contact
     * \return page par defaut de contact charge le modéle contactModel et usersModel pour si l'utilisateur est connecté
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function index()
    {

        $this->load->model('usersModel');
        $aViewHeader = $this->usersModel->getUser();
        $this->load->model('contactModel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));
        $this->form_validation->set_rules('prenom', 'Prenom', 'required|regex_match[`^[a-zA-Z]{2,}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        $this->form_validation->set_rules('nom', 'Nom', 'required|regex_match[`^[a-zA-Z]{2,}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        $this->form_validation->set_rules('question', 'Question', 'required|regex_match[`[a-zA-Z\d]{5}`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une %s correct.</div>"));

        //si Adresse est posté on contrôle alors si cela est correct
        if (!empty($this->input->post('adresse'))) {
            $this->form_validation->set_rules('adresse', 'Adresse', 'regex_match[/[0-9]{1,}\s+[a-z]{2,}\s+[a-z]{2,}/]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une %s correct.</div>"));
        }

        //si ville est posté on contrôle alors si cela est correct
        if (!empty($this->input->post('ville'))) {
            $this->form_validation->set_rules('ville', 'Ville', 'regex_match[`^[a-zA-Z]{1,}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une %s correct.</div>"));
        }

        //si Code postal est posté on contrôle alors si cela est correct
        if (!empty($this->input->post('cp'))) {
            $this->form_validation->set_rules('cp', 'Code postal', 'regex_match[`^[0-9]{4,5}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        }
        $aViewHeader = ["title" => "Nous contacter",
            "url" => "/contact", "user" => $aViewHeader];
        $this->load->view('header', $aViewHeader);

        if ($this->form_validation->run() == false) {
            $this->load->view('contact');
        } else {
            $aView = $this->contactModel->sendEmail();
            $this->load->view('contact', $aView);
        }
        $this->load->view('footer');

    }

    /**
     * \brief vu email envoyé contact
     * \return page si l'email est bien envoyé de contact charge le modéle contactModel et usersModel pour si l'utilisateur est connecté
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function sendok()
    {

        $this->load->model('usersModel');
        $aViewHeader = $this->usersModel->getUser();

        $this->load->model('contactModel');


        $aView = $this->contactModel->sendok();

        $aViewHeader = ["title" => "Nous contacter",
            "url" => "/contact", "user" => $aViewHeader];
        $this->load->view('header', $aViewHeader);
        $this->load->view('contact', $aView);
        $this->load->view('footer');
    }
}