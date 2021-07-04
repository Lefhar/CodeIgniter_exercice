<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
{


    public function index()
    {
        $this->load->model('usersModel');
        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "A propos de notre entreprise", "user" => $aViewHeader];
        $this->load->view('header', $aViewHeader);
        $this->load->view('apropos');
        $this->load->view('footer');
    }
}