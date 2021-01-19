    <!--
        content

    -->   

    <div class="container">
   
    <div class="row">
    <!-- 
        colonne central
    -->
      <div class="col-12">
      <article>
         <p>* Ces zones sont obligatoires</p>



<!-- 
    form pour login
 -->
   

         <p>Vous n'avez pas de compte ? <a href="inscription.php">Vous inscrires</a></p>
         <form action="" method="post"  id="connexion"  name="connexion"  autocomplete="off"> <!--balise form début du formulaire-->
         <fieldset><!--début fieldset pour les coordonnées-->
             <legend>Connexion</legend>
    <input type="hidden" id="connect"  name="connect" value="yes">

              <div class="form-group">
                 <label for="email">Email* :  </label>
                 <input type="email" id="email" name="email" class="form-control" placeholder="votre Email"  autocomplete="off" required>
                <div id="demail"></div><br>
             </div>

             <div class="form-group">
                 <label for="password">Mot de passe* :  </label>
               
                 <div class="input-group">
             <input type="password" id="password" name="password" class="form-control" placeholder="Votre mot de passe"  minlength="12"  autocomplete="off" required="" aria-describedby="viewpassword" required>
      <div class="input-group-append" > <span class="input-group-text" id="viewpassword">
    <i class="fa fa-eye-slash" aria-hidden="true" id="eyepassword"></i></span>
      </div>
    </div>
    <div id="dpassword"></div>
    </div>


    <div class="form-check">
                 <input type="checkbox" id="remember" name="remember" class="form-check-input">
                 <label for="remember" class="form-check-label">Se souvenir de moi</label>
             </div>
        
                <br>
             </div>
            
     
  
            
        <div class="form-group">
              <button type="submit"  class="btn btn-dark btn-lg">Connexion</button>    <button type="reset" class="btn btn-dark btn-lg">Annuler</button>
         </div>
         </fieldset><!--fin fieldset pour les coordonnées-->
     </form> <!--balise form fin du formulaire-->




     
      </div>
    </article>

   
        </div>
    </div>
</div> 
    <!--
        Footer
    -->