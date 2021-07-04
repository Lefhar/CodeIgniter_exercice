<?php
defined('BASEPATH') or exit('No direct script access allowed');

class usersModel extends CI_Model
{
    public $_user;

    /**
     * \brief construct recupére les données de l'utilisateur par la session
     * \return $_user tableau qui retourne toute les informations de l'utilisateur
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function __construct()
    {
        if (!empty($_COOKIE['jt_jarditou'])) {
            $cookie = explode(":", $_COOKIE['jt_jarditou']);
            $this->session->set_userdata(array('login' => $cookie[0], 'jeton' => $cookie[1]));
        }
        $this->load->database();
        if (!empty($this->session->login) && !empty($this->session->jeton)) {
            $email = $this->session->login;
            $jeton = $this->session->jeton;
            $this->db->select("u_nom, u_prenom, u_d_connect, u_essai_connect, u_d_test_connect, u_mail, role");
            $this->db->from('users');
            $this->db->where('u_mail', $email);
            $this->db->where('u_jeton_connect', $jeton);

            //$aProduit = $this->query();
            $result = $this->db->get();

            // Récupération des résultats
            $view = $result->result();
        }
        if (!empty($this->session->login)) {
            $this->_user = ['nom' => $view[0]->u_nom, 'prenom' => $view[0]->u_prenom, 'connect' => $view[0]->u_d_connect, 'essai_connect' => $view[0]->u_essai_connect, 'test_connect' => $view[0]->u_d_test_connect, 'email' => $view[0]->u_mail, 'role' => $view[0]->role];
        } else {
            $this->_user = array();
        }

        // echo $this->_user;
    }

    /**
     * \brief getUser affiche les données du construct
     * \return _user tableau qui retourne toute les informations de l'utilisateur
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function getUser()
    {
        return $this->_user;
    }


    /**
     * \brief connexion charge la vu de connexion
     * \return connexion
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function connexion()
    {
        $this->load->helper('form', 'url', 'cookie');
        // Chargement de la librairie 'database'
        $this->load->database();
        $email = $this->input->post("email");
        $password = $this->input->post('password');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));
        $this->form_validation->set_rules('password', 'Mot de passe', 'trim|required|min_length[12]|max_length[30]|encode_php_tags', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "min_length" => "<div class=\"alert alert-danger\" role=\"alert\">%s ne contient pas au minimum 12 caractéres.</div>", "max_length" => "<div class=\"alert alert-danger\" role=\"alert\">%s ne contient pas au maximum 30 caractéres.</div>"));

        $users = $this->db->query("SELECT u_mail, u_password, u_hash, u_essai_connect, u_d_test_connect, u_mail_confirm FROM users WHERE u_mail = ?", $email);
        $aView["users"] = $users->row(); // première ligne du résultat


        $aViewHeader = ["title" => "Connexion"];

        // Appel des différents morceaux de vues

        if ($this->form_validation->run() == TRUE) {
            if (!empty($aView["users"]->u_mail) && password_verify($this->functionModel->password($password, $aView["users"]->u_hash), $aView["users"]->u_password) && $aView["users"]->u_mail_confirm == 1) {


                $jeton = password_hash($this->functionModel->salt(12), PASSWORD_DEFAULT);
                $data["u_d_connect"] = date("Y-m-d H:i:s");
                $data["u_jeton_connect"] = $jeton;
                $data["u_essai_connect"] = 0;
                $this->db->where('u_mail', $email);
                $this->db->update('users', $data);
                $this->session->set_userdata(array('login' => $email, 'jeton' => $jeton));
                if (!empty($this->input->post('remember')) && $this->input->post('remember') == "on") {
                    $cookie = array(
                        'name' => 'jarditou',
                        'value' => '' . $email . ':' . $jeton . '',
                        'expire' => '16500',
                        'domain' => '' . $_SERVER['HTTP_HOST'] . '',
                        'path' => '/',
                        'prefix' => 'jt_',
                        'secure' => false
                    );
                    $this->input->set_cookie($cookie);
                }
                redirect("produits/liste");

            } elseif ($aView["users"]->u_mail_confirm == 0) {
                $aView['error'] = '<div class="alert alert-danger" role="alert">Vous devez valider votre adresse email <a href="' . site_url('users/resendemail') . '">renvoyer</a></div>';
//
            } else {
                $aView['error'] = '<div class="alert alert-danger" role="alert">Email ou mot de passe faux</div>';

            }
        } else {

        }
        return $aView;
    }


    /**
     * \brief inscription charge la vu de inscription et recupére en post les informations du formulaire
     * \return vu inscription
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function inscription()
    {

        $this->load->helper('form', 'url');

        //recupération des données post
        $salt = $this->functionModel->salt(12);
        //$data = $this->input->post();
        $data['u_password'] = password_hash($this->functionModel->password($this->input->post('password'), $salt), PASSWORD_DEFAULT);// on appel la fonction password comme sa on reprend la même méthode d'assemblage du sel et du mot de passe
        $data['u_d_create'] = date('Y-m-d H:i:s');
        $data['u_mail_hash'] = md5($this->functionModel->password($salt, $salt));
        $data['u_nom'] = $this->input->post('nom');
        $data['u_prenom'] = $this->input->post('prenom');
        $data['u_sexe'] = $this->input->post('sexe');
        $data['u_adresse'] = $this->input->post('adresse');
        $data['u_cp'] = $this->input->post('cp');
        $data['u_city'] = $this->input->post('ville');
        $data['u_tel'] = $this->input->post('tel');
        $data['u_mail'] = $this->input->post('email');
        $data['u_hash'] = $salt;
        // Chargement de la librairie 'database'
        $this->load->database();


        $users = $this->db->query("SELECT u_mail FROM users WHERE u_mail = ?", $this->input->post('email'));
        $aView["users"] = $users->row();
        if (!empty($this->input->post('password')) && !empty($this->input->post('confirpassword')) && $this->input->post('confirpassword') == $this->input->post('password') && empty($aView["users"]->u_mail)) {


            $this->db->insert('users', $data);

            $this->email->from('igor.popoviche@laposte.net', 'Jarditou');
            $this->email->to($this->input->post('email'));
            $this->email->subject('Confirmation email');
            $this->email->message("<!DOCTYPE html>
                        <html lang='fr'>
                        <head>
                        <meta charset='utf-8'>
                        <title>Confirmer votre adresse email</title>   
                        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
                        <link rel='stylesheet' href='" . base_url("assets/css/style.css") . "'>
                        </head>
                        <body>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-12'>
                                  <h1>Confirmez votre adresse email</h1>
                              </div>    
                            </div>   
                            <div class='row'>
                                <div class='col-12'>
                                 <p><a href='" . site_url('/users/validationemail/') . "" . ($data['u_mail_hash']) . "' > Confirmez votre adresse email</a></p>
                                 si vous ne pouvez pas lire cette email suivez copiez ce lien et coller le dans la barre d'adresse Lien " . site_url('/users/validationemail/') . "" . ($data['u_mail_hash']) . "
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
            $this->email->send();
            redirect('users/inscriptionvalide');


        } else {
            $aView['error'] = '<div class="alert alert-danger" role="alert">Une erreur c\'est produite</div>';

        }
        return $aView;
    }


    /**
     * \brief validationemail charge la vu de validationemail c'est la page de vu pour la validation d'email
     * \param  $jeton   recupération dans l'url pour retrouver en base
     * \return vu error
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function validationemail($jeton)
    {

        if (!empty($jeton)) {
//            $this->db->select("u_mail_hash,u_id,u_mail");
//            $this->db->from('users');
//            $this->db->where('u_mail_hash',$jeton);
//            $result = $this->db->get();

            // récupération des résultats
//            $ausers = $result->result();

            $users = $this->db->query("SELECT u_mail_hash,u_id,u_mail FROM users WHERE u_mail_hash = ?", $jeton);
            $aView["jeton"] = $users->row(); // première ligne du résultat


            if (!empty($aView["jeton"]->u_mail)) {
                $id = $aView["jeton"]->u_id;
                $data['u_mail_confirm'] = "1";
                $data['u_mail_hash'] = NULL;
                $this->db->where('u_id', $id);
                $this->db->update('users', $data);
                $data['error'] = '<div class="alert alert-success" role="alert">Merci votre email est validé vous pouvez vous  <a href="' . site_url('users/connexion') . '">connecter</a></div>';

                //redirect('users/connexion');
            } else {
                $data['error'] = '<div class="alert alert-danger" role="alert">Désolé une erreur c\'est produite</div>';

            }
        } else {

            $data['error'] = '<div class="alert alert-danger" role="alert">Désolé une erreur c\'est produite</div>';

        }

        return $data;
    }


    /**
     * \brief deconnexion charge la vu de deconnexion c'est la page de vu pour la deconnexion
     * \return redirige sur produits/liste
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function deconnexion()
    {


        if (
            !empty($this->input->post('confirm'))
            &&
            $this->input->post('confirm') == 'yes'
        ) {

            unset($_COOKIE["jt_jarditou"]);
            $cookie = array(
                'name' => 'jarditou',
                'value' => '',
                'expire' => '-4200',
                'domain' => '' . $_SERVER['HTTP_HOST'] . '',
                'path' => '/',
                'prefix' => 'jt_',
                'secure' => false
            );
            $this->input->set_cookie($cookie);
            $_SESSION['login'] = "";
            $_SESSION['jeton'] = "";
            $this->load->helper('cookie');
            delete_cookie("jt_jarditou");
            session_destroy();
            redirect("produits/liste");
        }

    }


    /**
     * \brief resetpassword charge la vu de resetpassword c'est la page de vu pour refaire le mot de passe
     * \param  $jeton   recupération dans l'url pour retrouver en base
     * \return redirection users/connexion
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function resetpassword($jeton)
    {
        $users = $this->db->query("SELECT u_id, u_reset_hash FROM users WHERE u_reset_hash = ?", $jeton);
        $aView["jeton"] = $users->row(); // première ligne du résultat

        if (empty($jeton) or empty($aView["jeton"]->u_reset_hash)) {

            $error['errorjeton'] = '<div class="alert alert-danger" role="alert">Désolé une erreur c\'est produite jeton incorrect</div>';


        } else {
            $salt = $this->functionModel->salt(12);
            //$data = $this->input->post();
            $data['u_reset_hash'] = NULL;
            $data['u_d_reset'] = date("Y-m-d H:i:s");
            $data['u_password'] = password_hash($this->functionModel->password($this->input->post('password'), $salt), PASSWORD_DEFAULT);// on appel la fonction password comme sa on reprend la même méthode d'assemblage du sel et du mot de passe
            $data['u_hash'] = $salt;

            $id = $aView["jeton"]->u_id;
            //recupération des données post
            $this->db->where('u_id', $id);
            $this->db->update('users', $data);
            redirect('users/connexion');


        }
        return $error;
    }

    /**
     * \brief lostpassword charge la vu de lostpassword c'est la page pour recevoir un lien pour refaire le mot de passe
     * \return vu lostpassword
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function lostpassword()
    {

        $aViewHeader = ["title" => "Mot de passe oublié"];
        $salt = $this->functionModel->salt(12);
        $data['u_reset_hash'] = md5($this->functionModel->password($salt, $salt));
        $data['u_mail'] = $this->input->post('email');

        $users = $this->db->query("SELECT u_id, u_reset_hash, u_mail FROM users WHERE u_mail = ?", $data['u_mail']);
        $aView["jeton"] = $users->row(); // première ligne du résultat


        if (!empty($aView["jeton"]->u_mail)) {
            $id = $aView["jeton"]->u_id;
            $this->db->where('u_id', $id);
            $this->db->update('users', $data);

            $this->email->from('igor.popoviche@laposte.net', 'Jarditou');
            $this->email->to($this->input->post('email'));
            $this->email->subject('Réinitialisation mot de passe');
            $this->email->message("<!DOCTYPE html>
                        <html lang='fr'>
                        <head>
                        <meta charset='utf-8'>
                        <title>Réinitialisation mot de passe</title>   
                        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
                        <link rel='stylesheet' href='" . base_url("assets/css/style.css") . "'>
                        </head>
                        <body>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-12'>
                                  <h1>Réinitialisation mot de passe</h1>
                              </div>    
                            </div>   
                            <div class='row'>
                                <div class='col-12'>
                                 <p><a href='" . site_url('/users/resetpassword/') . "" . ($data['u_reset_hash']) . "' > Réinitialisez votre mot de passe</a></p>
                                 si vous ne pouvez pas lire cette email copiez ce lien et coller le dans la barre d'adresse  " . site_url('/users/resetpassword/') . "" . ($data['u_reset_hash']) . "
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
            $this->email->send();
            $data['error'] = '<div class="alert alert-success" role="alert">Merci un email vous a été envoyé vérifier votre boite de reception ou courrier indésirable</div>';

        } else {
            $data['error'] = '<div class="alert alert-danger" role="alert">Veuillez vérifier votre adresse email</div>';

        }


        return $data;
    }

    /**
     * \brief resendemail charge la vu de resendemail c'est la page recevoir de nouveau le lien de validation de l'adresse email
     * \return vu resendemail
     * \author Harold lefebvre
     * \date 01/02/2021
     */
    public function resendemail()
    {
        $aViewHeader = ["title" => "Renvoyer le lien de confirmation"];
        $salt = $this->functionModel->salt(12);

        $data['u_mail'] = $this->input->post('email');

        $users = $this->db->query("SELECT u_id, u_mail_hash, u_mail FROM users WHERE u_mail = ?", $data['u_mail']);
        $aView["jeton"] = $users->row(); // première ligne du résultat
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));

        if (!empty($aView["jeton"]->u_mail) && !empty($aView["jeton"]->u_mail_hash)) {


            $this->email->from('igor.popoviche@laposte.net', 'Jarditou');
            $this->email->to($aView["jeton"]->u_mail);
            $this->email->subject('Confirmation email');
            $this->email->message("<!DOCTYPE html>
                        <html lang='fr'>
                        <head>
                        <meta charset='utf-8'>
                        <title>Confirmer votre adresse email</title>   
                        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
                        <link rel='stylesheet' href='" . base_url("assets/css/style.css") . "'>
                        </head>
                        <body>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-12'>
                                  <h1>Confirmez votre adresse email</h1>
                              </div>    
                            </div>   
                            <div class='row'>
                                <div class='col-12'>
                                 <p><a href='" . site_url('/users/validationemail/') . "" . $aView["jeton"]->u_mail_hash . "' > Confirmez votre adresse email</a></p>
                                 si vous ne pouvez pas lire cette email suivez copiez ce lien et coller le dans la barre d'adresse Lien " . site_url('/users/validationemail/') . "" . $aView["jeton"]->u_mail_hash . "
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
            $this->email->send();
            $data['error'] = '<div class="alert alert-success" role="alert">Merci un email vous a été envoyé vérifier votre boite de reception ou courrier indésirable</div>';

        } else {
            $data['error'] = '<div class="alert alert-danger" role="alert">Veuillez vérifier votre adresse email</div>';

        }


        return $data;
    }

}