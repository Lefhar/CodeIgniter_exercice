<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class functionModel extends CI_Model {
   public function salt($number)
    {
        if(!empty($number)&&$number>=10){
            $salt = bin2hex(random_bytes($number));
            return bin2hex($salt) ;
        }
    }

//fonction pour assembler le mot de passe et le sel avec des symboles en plus
    public   function password($password,$salt)
    {
        $resultat="";
        if(!empty($salt)&&!empty($password))
        {
            $resultat = "?@".$salt."_@".$password."_@".$salt;

        }
        return $resultat;
    }



}