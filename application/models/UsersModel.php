<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class usersModel extends CI_Model {  
    public $_user;
    public function __construct()  
    {  
        $this->load->database();
        $email = $this->session->login;
        $jeton = $this->session->jeton;
        $this->db->select("u_nom, u_prenom, u_d_connect, u_essai_connect, u_d_test_connect, u_mail");
        $this->db->from('users');
        $this->db->where('u_mail',$email);
        $this->db->where('u_jeton_connect',$jeton);
 
       //$aProduit = $this->query();
       $result = $this->db->get();
 
     // Récupération des résultats    
     $view = $result->result(); 
     $this->_user = ['nom' => $view[0]->u_nom,'prenom' => $view[0]->u_prenom,'connect' => $view[0]->u_d_connect, 'essai_connect' => $view[0]->u_essai_connect,'test_connect' => $view[0]->u_d_test_connect,'email' => $view[0]->u_mail];
     // echo $this->_user;
    }
    public function getUser()  
    {  
    return $this->_user;
    }
    public function connexion()  
    {  
        $this->load->helper('form', 'url'); 
        // Chargement de la librairie 'database'
        $this->load->database(); 
        $email = $this->input->post("email");
        $password = $this->input->post('password');  
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "valid_email" => "<div class=\"alert alert-danger\" role=\"alert\">ce n'est pas une adresse %s valide.</div>"));
        $this->form_validation->set_rules('password','Mot de passe','trim|required|min_length[12]|max_length[30]|encode_php_tags', array("required" => "<div class=\"alert alert-danger\" role=\"alert\">%s est obligatoire.</div>", "min_length" => "<div class=\"alert alert-danger\" role=\"alert\">%s ne contient pas au minimum 12 caractéres.</div>", "max_length" => "<div class=\"alert alert-danger\" role=\"alert\">%s ne contient pas au maximum 30 caractéres.</div>"));
 
        $users = $this->db->query("SELECT u_mail, u_password, u_hash, u_essai_connect, u_d_test_connect, u_mail_confirm FROM users WHERE u_mail = ?",$email);
        $aView["users"] = $users->row(); // première ligne du résultat
        if(!empty($aView["users"]->u_mail)){
        $passtest = "?@".$aView["users"]->u_hash."_@".$password."_@".$aView["users"]->u_hash;
        }else{
            $passtest = "";
        }
    var_dump($aView["users"]);

        $aViewHeader = ["title" => "Connexion"];

        // Appel des différents morceaux de vues
        $this->load->view('header', $aViewHeader);
        if ($this->form_validation->run() == TRUE)
        {
        if (!empty($aView["users"]->u_mail)&&password_verify($passtest,$aView["users"]->u_password))   
        {  
            //declaring session  
            $salt = bin2hex(random_bytes("12"));
            $jeton = password_hash($salt, PASSWORD_DEFAULT);
            $data["u_d_connect"] = date("Y-m-d H:i:s");
            $data["u_jeton_connect"] = $jeton;
            $data["u_essai_connect"] = 0;
            $this->db->where('u_mail', $email);
            $this->db->update('users', $data);
            $this->session->set_userdata(array('login'=>$email,'jeton'=>$jeton));  
            $this->load->view('connexion');  
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
        // Chargement de la librairie 'database'
        $this->load->database(); 
        $user = $this->input->post('user');  
        $pass = $this->input->post('pass');  
        $aViewHeader = ["title" => "inscription"];

        // Appel des différents morceaux de vues
        $this->load->view('header', $aViewHeader);
        if ($user=='juhi' && $pass=='123')   
        {  
            //declaring session  
            $this->session->set_userdata(array('user'=>$user));  
            $this->load->view('inscription');  
        }  
        else{  
            $aView['error'] = 'Email ou mot de passe faux';  
            $this->load->view('inscription', $aView);  
        }  
        $this->load->view('footer');
    }  


    public function logout()  
    {  
        //removing session  
        $this->session->unset_userdata('user');  
        redirect("produits/liste");
    }  
  
}  
?>  