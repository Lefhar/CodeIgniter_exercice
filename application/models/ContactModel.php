<?php
// application/controllers/detail.php

defined('BASEPATH') or exit('No direct script access allowed');

class contactModel extends CI_Model
{


    /**
     * \brief charge la vu par defaut de contact (le formulaire)
     * \return vu contact par defaut
     * \author Harold lefebvre
     * \date 01/02/2021
     */


public  function sendEmail(){
    $this->load->library('email');
    $data = array();
            $this->email->set_newline("\r\n");
            $this->email->from("igor.popoviche@laposte.net", $this->input->post('nom') . ' ' . $this->input->post('prenom'));
            $this->email->to("igor.popoviche@laposte.net");
            $this->email->subject($this->input->post('mescommandes'));
            $this->email->message("<!DOCTYPE html>
                        <html lang='fr'>
                        <head>
                        <meta charset='utf-8'>
                        <title>message de " . $this->input->post('email') . "</title>
                        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
                        <link rel='stylesheet' href='" . base_url("assets/css/style.css") . "'>
                        </head>
                        <body>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-12'>
                                  <h1>message de " . $this->input->post('email') . " </h1>
                              </div>
                            </div>
                            <div class='row'>
                                <div class='col-12'>
                                 <p>Sujet : " . $this->input->post('mescommandes') . "</p>
                                 <p>" . $this->input->post('question') . "</p>
                                 <p>Coordonnée :</p>
                                 <p>Nom : " . $this->input->post('nom') . "</p>
                                 <p>Prenom : " . $this->input->post('prenom') . "</p>
                                 <p>adresse : " . $this->input->post('adresse') . "</p>
                                 <p>" . $this->input->post('cp') . " " . $this->input->post('ville') . "</p>
                                 <p>Date de naissance : " . $this->input->post('date') . "</p>
                                 <p>Sexe : " . $this->input->post('sexe') . "</p>
                              </div>
                            </div>
                            <div class='row'>
                                <div class='col-12'>
                                  <img src='" . base_url("assets/images/jarditou_logo.jpg") . "' title='Logo' alt='Logo' class='img-fluid'>
                                </div>
                            </div>
                        </div>

                        <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                        <script src='" . base_url("assets/css/script.js") . "'></script>
                        <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
                        </body>
                        </html>");
          if($this->email->send()){
              redirect('contact/sendok');
    }else{
              $data['error'] = '<div class="alert alert-success" role="alert">Une erreur c\'est produite</div>';
          }

          redirect('contact/sendok');
          return $data;
}
    /**
     * \brief charge la vu par sendok de contact (validation de l'envoi du message)
     * \return vu sendok de contact
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function sendok()
    {
        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Message envoyé", "user" => $aViewHeader];
        $data['error'] = '<div class="alert alert-success" role="alert">Votre email à bien était envoyé</div>';
        return $data;
    }

}