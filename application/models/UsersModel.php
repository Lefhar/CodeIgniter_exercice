<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class usersModel extends CI_Model {  
    public $_user;


    public function __construct()
    {  
        if(!empty($_COOKIE['jt_jarditou'])){
            $cookie = explode(":",$_COOKIE['jt_jarditou']);
            $this->session->set_userdata(array('login'=>$cookie[0],'jeton'=>$cookie[1]));  
        }
        $this->load->database();
        if(!empty($this->session->login)&&!empty($this->session->jeton)) {
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
     if(!empty($this->session->login)){
     $this->_user = ['nom' => $view[0]->u_nom,'prenom' => $view[0]->u_prenom,'connect' => $view[0]->u_d_connect, 'essai_connect' => $view[0]->u_essai_connect,'test_connect' => $view[0]->u_d_test_connect,'email' => $view[0]->u_mail];
     }else{
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
        $this->load->helper('form', 'url','cookie'); 
        // Chargement de la librairie 'database'
        $this->load->database(); 
        $email = $this->input->post("email");
        $password = $this->input->post('password');  
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));
        $this->form_validation->set_rules('password','Mot de passe','trim|required|min_length[12]|max_length[30]|encode_php_tags', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "min_length" => "<div class=\"alert alert-danger\" role=\"alert\">%s ne contient pas au minimum 12 caractéres.</div>", "max_length" => "<div class=\"alert alert-danger\" role=\"alert\">%s ne contient pas au maximum 30 caractéres.</div>"));
 
        $users = $this->db->query("SELECT u_mail, u_password, u_hash, u_essai_connect, u_d_test_connect, u_mail_confirm FROM users WHERE u_mail = ?",$email);
        $aView["users"] = $users->row(); // première ligne du résultat


        $aViewHeader = ["title" => "Connexion"];

        // Appel des différents morceaux de vues
        $this->load->view('header', $aViewHeader);
        if ($this->form_validation->run() == TRUE)
        {
        if (!empty($aView["users"]->u_mail)&&password_verify($this->functionModel->password($password,$aView["users"]->u_hash),$aView["users"]->u_password))
        {  
          

            $jeton = password_hash($this->functionModel->salt(12), PASSWORD_DEFAULT);
            $data["u_d_connect"] = date("Y-m-d H:i:s");
            $data["u_jeton_connect"] = $jeton;
            $data["u_essai_connect"] = 0;
            $this->db->where('u_mail', $email);
            $this->db->update('users', $data);
            $this->session->set_userdata(array('login'=>$email,'jeton'=>$jeton));  
        if(!empty($this->input->post('remember'))&&$this->input->post('remember')=="on"){
            $cookie = array(
                'name'   => 'jarditou',
                'value'  => ''.$email.':'.$jeton.'',
                'expire' => '16500',
                'domain' => ''.$_SERVER['HTTP_HOST'].'',
                'path'   => '/',
                'prefix' => 'jt_',
                'secure' => false
            );
            $this->input->set_cookie($cookie);
        }
           redirect("produits/liste");
        }  
        else{  
            $aView['error'] = '<div class="alert alert-danger" role="alert">Email ou mot de passe faux</div>';  
            $this->load->view('connexion', $aView);  
        }  
    }else{
        $this->load->view('connexion', $aView);  
        }  
        $this->load->view('footer');
    }

    public function inscription()  
    {

        $this->load->helper('form', 'url');

        //recupération des données post
        $data = $this->input->post();

        // Chargement de la librairie 'database'
        $this->load->database();
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));
        $this->form_validation->set_rules('password','Mot de passe','required|regex_match[`^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{12,})$`]', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">%s doit contenir au minimum 12 caractéres dont une majuscule un symbole.</div>"));
        $this->form_validation->set_rules('confirpassword','Confirmation mot de passe','required|regex_match[`^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{12,})$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        $this->form_validation->set_rules('prenom','Prenom','required|regex_match[`^[a-zA-Z]{2,}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        $this->form_validation->set_rules('nom','Nom','required|regex_match[`^[a-zA-Z]{2,}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));

        //si Adresse est posté on contrôle alors si cela est correct
        if(!empty($this->input->post('adresse'))){
            $this->form_validation->set_rules('adresse','Adresse','regex_match[/[0-9]{1,}\s+[a-z]{2,}\s+[a-z]{2,}/]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une %s correct.</div>"));
        }

        //si ville est posté on contrôle alors si cela est correct
        if(!empty($this->input->post('ville'))){
            $this->form_validation->set_rules('ville','Ville','regex_match[`^[a-zA-Z]{1,}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une %s correct.</div>"));
        }

        //si Code postal est posté on contrôle alors si cela est correct
        if(!empty($this->input->post('cp'))){
            $this->form_validation->set_rules('cp','Code postal','regex_match[`^[0-9]{4,5}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        }

        //si téléphone est posté on contrôle alors si cela est correct
        if(!empty($this->input->post('tel'))){
            $this->form_validation->set_rules('tel','Téléphone','regex_match[`^[0-9]{10}$`]', array("regex_match" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas un %s correct.</div>"));
        }

        $salt = $this->functionModel->salt(12);







        if(!empty($this->session->login)&&!empty($this->session->jeton)){
            redirect('produits/liste');
            exit();
        }
        if ($this->form_validation->run() == TRUE) {


            if(!empty($this->input->post('password'))&&!empty($this->input->post('confirpassword'))&&$this->input->post('confirpassword')==$this->input->post('password')){
                $data['u_password'] = password_hash($this->functionModel->password($this->input->post('password'),$salt), PASSWORD_DEFAULT);// on appel la fonction password comme sa on reprend la même méthode d'assemblage du sel et du mot de passe
                $data['u_d_create'] = date('Y-m-d H:i:s');
                $data['u_mail_hash']  = password_hash($this->functionModel->password($salt,$salt), PASSWORD_DEFAULT);


                $this->db->insert('users', $data);
            }else{

                $this->load->view('header');
                $this->load->view('inscription');
                $this->load->view('footer');

            }









        }else{

            $this->load->view('header');
            $this->load->view('inscription');
            $this->load->view('footer');
        }
    }

    public function validationemail($jeton)
    {

        if(!empty($jeton)){
//            $this->db->select("u_mail_hash,u_id,u_mail");
//            $this->db->from('users');
//            $this->db->where('u_mail_hash',$jeton);
//            $result = $this->db->get();

            // récupération des résultats
//            $ausers = $result->result();

            $users = $this->db->query("SELECT u_mail_hash,u_id,u_mail FROM users WHERE u_mail_hash = ?",$jeton);
            $aView["jeton"] = $users->row(); // première ligne du résultat




            if(!empty($aUsers)){
                $id = $aView["jeton"]->u_id;
                $data['u_mail_confirm'] = "1";
                $data['u_mail_hash'] = NULL;
                $this->db->where('u_id', $id);
                $this->db->update('users', $data);
            }else{
                $data['error']= '<div class="alert alert-danger" role="alert">Désolé une erreur c\'est produite</div>';
                $this->load->view('header');
                $this->load->view('validationemail',$data);
                $this->load->view('footer');
            }
        }else {

        $data['error']= '<div class="alert alert-danger" role="alert">Désolé une erreur c\'est produite</div>';
            $this->load->view('header');
            $this->load->view('validationemail',$data);
            $this->load->view('footer');
        }


    }

    public function deconnexion()  
    {  

        $aViewHeader = $this->usersModel->getUser();
        $aViewHeader = ["title" => "Déconnexion","user" => $aViewHeader];
        $this->load->view('header', $aViewHeader);
        //removing session  
        $this->load->view('deconnexion');  
        if(
        !empty($this->input->post('confirm'))
        &&
        $this->input->post('confirm')== 'yes'
        )
        {

       unset($_COOKIE["jt_jarditou"]);
       setcookie("jt_jarditou", '', time() - 4200, '/');
       $_SESSION['login'] = "";
       $_SESSION['jeton'] = "";
       session_destroy();
        redirect("produits/liste");
        }  
        $this->load->view('footer');
    }
  
}