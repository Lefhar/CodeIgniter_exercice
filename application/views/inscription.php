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


                <p>Vous avez un compte ? <a href="<?php echo base_url('users/connexion');?>">Vous connecter</a></p>

                <?php

                //  balise form début du formulaire
                //<!--balise form début du formulaire-->
                $array =array('name'=>'register','id'=>'register','autocomplete'=>'off');
                echo form_open('',$array);

              //  echo form_open_multipart('','name="ajout_produit" id="ajout_produit"');

                ?>

                <fieldset><!--début fieldset pour les coordonnées-->

                    <legend>Inscription</legend>
                    <?php if(!empty($error)){echo $error;}?>
                    <div class="form-group">
                        <label for="nom">Votre nom* :  </label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom"  required value="<?php echo set_value('nom');?>">
                        <div id="dnom"></div>
                        <?php echo form_error('nom');?>
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Votre prénom* :  </label>
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre prénom"  required  value="<?php echo set_value('prenom');?>">
                        <div id="dprenom"></div>
                        <?php echo form_error('prenom');?>
                    </div>

                    <p>Sexe : </p>
                    <div class="form-check  form-check-inline">
                        <input type="radio" name="sexe" id="fem"  class="form-check-input" value="f" >
                        <label for="fem" >Fémimin </label>
                    </div>

                    <div class="form-check  form-check-inline">
                        <input type="radio" name="sexe" id="masc"  class="form-check-input" value="h"  >
                        <label for="masc" >Masculin</label><br>
                    </div>

                    <div class="form-check  form-check-inline">
                        <input type="radio" name="sexe" id="null"  class="form-check-input" value="null"  checked>
                        <label for="null" >Autre</label><br>
                    </div>

                    <div class="form-group">
                        <label for="adresse">Adresse :  </label>
                        <textarea type="text" id="adresse" name="adresse" class="form-control" placeholder="Votre adresse postale"  cols="30" rows="6" ><?php echo set_value('adresse');?></textarea>
                        <div id="dadresse"></div>
                        <?php echo form_error('adresse');?>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="cp">Code postal :  </label>
                        <input type="text" id="cp" class="form-control" name="cp"  value="<?php echo set_value('cp');?>">
                        <div id="dcp"></div>
                        <?php echo form_error('cp');?>
                        <br>

                    </div>



                    <div class="form-group">
                        <label for="ville">Ville :  </label>
                        <input type="tel" id="ville" class="form-control" name="ville"  value="<?php echo set_value('ville');?>">
                        <div id="dville"></div>
                        <?php echo form_error('ville');?>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="tel">Téléphone :  </label>
                        <input type="tel" id="tel" class="form-control" name="tel"    pattern="[0-9]{10}"  value="<?php echo set_value('tel');?>">
                        <div id="dtel"></div>
                        <?php echo form_error('tel');?>
                        <br>
                    </div>


                    <div class="form-group">
                        <label for="email">Email :  </label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="votre Email"  autocomplete="off" required  value="<?php echo set_value('email');?>">
                        <div id="demail"></div>
                        <?php echo form_error('email');?>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe : (votre mot de passe doit contenir au minimum 12 caractéres dont une majuscule un chiffre et un symbole) </label>

                        <div class="input-group">
                            <input type="password" id="password" name="password"  value="<?php echo set_value('password');?>" class="form-control" placeholder="Votre mot de passe"  minlength="12"  autocomplete="off" required="" aria-describedby="viewpassword">
                            <div class="input-group-append" > <span class="input-group-text" id="viewpassword">
    <i class="fa fa-eye-slash" aria-hidden="true" id="eyepassword"></i></span>
                            </div>
                        </div>
                        <div id="dpassword"></div>
                        <?php echo form_error('password');?>
                    </div>

                    <div class="form-group"  id="divconfirmmdp">
                        <label for="confirpassword">Confirmer votre mot de passe :  </label>
                        <div class="input-group" >
                            <input type="password" id="confirpassword" name="confirpassword"  value="<?php echo set_value('confirpassword');?>" class="form-control" minlength="12" placeholder="Confirmer votre mot de passe" autocomplete="off" required="" aria-describedby="viewconfirpassword">
                            <div class="input-group-append" > <span class="input-group-text" id="viewconfirpassword">
    <i class="fa fa-eye-slash" aria-hidden="true" id="eyeconfirmpassword"></i></span>
                            </div>
                        </div>
                        <div id="dconfirpassword"></div>
                        <?php echo form_error('confirpassword');?>
                    </div>
                    <br>
        </div>




        <div class="form-group">
            <button type="submit"  class="btn btn-dark btn-lg">Inscription</button>    <button type="reset" class="btn btn-dark btn-lg">Annuler</button>
        </div>
             </fieldset><!--fin fieldset pour les coordonnées-->
        </form> <!--balise form fin du formulaire-->






        </article>


    </div>
</div>
</div>
<!--
    Footer
-->