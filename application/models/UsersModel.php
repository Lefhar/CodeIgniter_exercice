<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class usersModel extends CI_Model {  
      

    public function connexion()  
    {  
        $this->load->helper('form', 'url'); 
        // Chargement de la librairie 'database'
        $this->load->database(); 
        $email = $this->input->post("email");
        $password = $this->input->post('password');  

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

        if (!empty($aView["users"]->u_mail)&&password_verify($passtest,$aView["users"]->u_password))   
        {  
            //declaring session  
            $this->session->set_userdata(array('login'=>$email,'password'=>$password));  
            $this->load->view('connexion');  
            var_dump($this->session);
        }  
        else{  
            $data['error'] = '<div class="alert alert-danger" role="alert">Email ou mot de passe faux</div>';  
            $this->load->view('connexion', $data);  
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
            $data['error'] = 'Email ou mot de passe faux';  
            $this->load->view('inscription', $data);  
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