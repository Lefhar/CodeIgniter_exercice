<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class usersModel extends CI_Model
{
    public $_user;


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
            $this->db->select("u_nom, u_prenom, u_d_connect, u_essai_connect, u_d_test_connect, u_mail");
            $this->db->from('users');
            $this->db->where('u_mail', $email);
            $this->db->where('u_jeton_connect', $jeton);

            //$aProduit = $this->query();
            $result = $this->db->get();

            // Récupération des résultats
            $view = $result->result();
        }
        if (!empty($this->session->login)) {
            $this->_user = ['nom' => $view[0]->u_nom, 'prenom' => $view[0]->u_prenom, 'connect' => $view[0]->u_d_connect, 'essai_connect' => $view[0]->u_essai_connect, 'test_connect' => $view[0]->u_d_test_connect, 'email' => $view[0]->u_mail];
        } else {
            $this->_user = array();
        }

        // echo $this->_user;
    }

    public function getUser()
    {
        return $this->_user;
    }

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
        $this->load->view('header', $aViewHeader);
        if ($this->form_validation->run() == TRUE) {
            if (!empty($aView["users"]->u_mail) && password_verify($this->functionModel->password($password, $aView["users"]->u_hash), $aView["users"]->u_password)) {


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
            } else {
                $aView['error'] = '<div class="alert alert-danger" role="alert">Email ou mot de passe faux</div>';
                $this->load->view('connexion', $aView);
            }
        } else {
            $this->load->view('connexion', $aView);
        }
        $this->load->view('footer');
    }

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
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));
        $this->form_validation->set_rules('password', 'Mot de passe', 'required|regex_match[`^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{12,})$`]', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">%s doit contenir au minimum 12 caractéres dont une majuscule un symbole.</div>"));
        $this->form_validation->set_rules('confirpassword', 'Confirmation mot de passe', 'required|regex_match[`^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{12,})$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        $this->form_validation->set_rules('prenom', 'Prenom', 'required|regex_match[`^[a-zA-Z]{2,}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        $this->form_validation->set_rules('nom', 'Nom', 'required|regex_match[`^[a-zA-Z]{2,}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));

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

        //si téléphone est posté on contrôle alors si cela est correct
        if (!empty($this->input->post('tel'))) {
            $this->form_validation->set_rules('tel', 'Téléphone', 'regex_match[`^[0-9]{10}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        }


        if (!empty($this->session->login) && !empty($this->session->jeton)) {
            redirect('produits/liste');
            exit();
        }
        if ($this->form_validation->run() == TRUE) {

            $users = $this->db->query("SELECT u_mail FROM users WHERE u_mail = ?", $this->input->post('email'));
            $aView["users"] = $users->row();
            if (!empty($this->input->post('password')) && !empty($this->input->post('confirpassword')) && $this->input->post('confirpassword') == $this->input->post('password') && empty($aView["users"]->u_mail)) {


                $this->db->insert('users', $data);


                $this->load->library('email');
                $config = array();
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'smtp.laposte.net';
                $config['smtp_user'] = 'igor.popoviche@laposte.net';
                $config['smtp_pass'] = '4vefg7kK';
                $config['smtp_port'] = 587;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
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
                            <title>Confirmer votre adresse email</title>
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
                if ($this->input->post('confirpassword') != $this->input->post('password')) {
                    $aView['error'] = '<div class="alert alert-danger" role="alert">les deux champs mot de passe ne correspondre pas</div>';
                } else
                    if (!empty($aView["users"]->u_mail)) {
                        $aView['error'] = '<div class="alert alert-danger" role="alert">Vous êtes déjà inscrit <a href="' . site_url('users/connexion') . '">Connexion</a>?</div>';
                    } else {
                        $aView['error'] = '<div class="alert alert-danger" role="alert">Une erreur c\'est produite</div>';
                    }
                $this->load->view('header');
                $this->load->view('inscription', $aView);
                $this->load->view('footer');

            }

        } else {

            $this->load->view('header');
            $this->load->view('inscription');
            $this->load->view('footer');
        }
    }

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
                $this->load->view('header');
                $this->load->view('validationemail', $data);
                $this->load->view('footer');
                //redirect('users/connexion');
            } else {
                $data['error'] = '<div class="alert alert-danger" role="alert">Désolé une erreur c\'est produite</div>';
                $this->load->view('header');
                $this->load->view('validationemail', $data);
                $this->load->view('footer');
            }
        } else {

            $data['error'] = '<div class="alert alert-danger" role="alert">Désolé une erreur c\'est produite</div>';
            $this->load->view('header');
            $this->load->view('validationemail', $data);
            $this->load->view('footer');
        }


    }

    public function deconnexion()
    {

        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Déconnexion", "user" => $aViewHeader];
        $this->load->view('header', $aViewHeader);
        //removing session  
        $this->load->view('deconnexion');
        if (
            !empty($this->input->post('confirm'))
            &&
            $this->input->post('confirm') == 'yes'
        ) {

            unset($_COOKIE["jt_jarditou"]);
            setcookie("jt_jarditou", '', time() - 4200, '/');
            $_SESSION['login'] = "";
            $_SESSION['jeton'] = "";
            session_destroy();
            redirect("produits/liste");
        }
        $this->load->view('footer');
    }

    public function inscriptionvalide()
    {

        $this->load->view('header');
        $this->load->view('inscriptionvalide');
        $this->load->view('footer');
    }

    public function resetpassword($jeton)
    {
        $users = $this->db->query("SELECT u_id, u_reset_hash FROM users WHERE u_reset_hash = ?", $jeton);
        $aView["jeton"] = $users->row(); // première ligne du résultat

        if (empty($jeton) or empty($aView["jeton"]->u_reset_hash)) {

            $data['errorjeton'] = '<div class="alert alert-danger" role="alert">Désolé une erreur c\'est produite jeton incorrect</div>';
            $this->load->view('header');
            $this->load->view('resetpassword', $data);
            $this->load->view('footer');

        } else {
            $salt = $this->functionModel->salt(12);
            //$data = $this->input->post();
            $data['u_reset_hash'] = NULL;
            $data['u_d_reset'] = date("Y-m-d H:i:s");
            $data['u_password'] = password_hash($this->functionModel->password($this->input->post('password'), $salt), PASSWORD_DEFAULT);// on appel la fonction password comme sa on reprend la même méthode d'assemblage du sel et du mot de passe
            $data['u_hash'] = $salt;
                $this->form_validation->set_rules('password', 'Mot de passe', 'required|regex_match[`^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{12,})$`]', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">%s doit contenir au minimum 12 caractéres dont une majuscule un symbole.</div>"));
            $this->form_validation->set_rules('confirpassword', 'Confirmation mot de passe', 'required|matches[password]', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "matches" => "<div class=\"alert alert-danger\" role=\"alert\">%s ne correspond pas au mot de passe.</div>"));
            $this->load->helper('form', 'url');
            if ($this->form_validation->run() == FALSE) {
                $aViewHeader = ["title" => "réinitialisation mot de passe"];
                $this->load->view('header', $aViewHeader);
                $this->load->view('resetpassword');
                $this->load->view('footer');
            } else {
                $id = $aView["jeton"]->u_id;
                //recupération des données post
                $this->db->where('u_id', $id);
                $this->db->update('users', $data);
  redirect('users/connexion');
            }

        }

    }


    public function lostpassword()
    {

        $aViewHeader = ["title" => "Mot de passe oublié"];
        $salt = $this->functionModel->salt(12);
        $data['u_reset_hash'] = md5($this->functionModel->password($salt, $salt));
        $data['u_mail'] = $this->input->post('email');

        $users = $this->db->query("SELECT u_id, u_reset_hash, u_mail FROM users WHERE u_mail = ?", $data['u_mail']);
        $aView["jeton"] = $users->row(); // première ligne du résultat
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('header', $aViewHeader);
            $this->load->view('lostpassword');
            $this->load->view('footer');
        } else {
            if(!empty($aView["jeton"]->u_mail)) {
                $id = $aView["jeton"]->u_id;
                $this->db->where('u_id', $id);
                $this->db->update('users', $data);
                $this->load->library('email');
                $config = array();
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'smtp.laposte.net';
                $config['smtp_user'] = 'igor.popoviche@laposte.net';
                $config['smtp_pass'] = '4vefg7kK';
                $config['smtp_port'] = 587;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
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
                            <title>Confirmer votre adresse email</title>
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
                $this->load->view('header', $aViewHeader);
                $this->load->view('lostpassword',$data);
                $this->load->view('footer');
            }else{
                $data['error'] = '<div class="alert alert-danger" role="alert">Veuillez vérifier votre adresse email</div>';
                $this->load->view('header', $aViewHeader);
                $this->load->view('lostpassword',$data);
                $this->load->view('footer');
            }


        }
    }
}