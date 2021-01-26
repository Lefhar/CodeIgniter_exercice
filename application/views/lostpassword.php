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

                <?php
                if(!empty($error))
                {         echo '<p>'.$error.'</p>';}?>
                <?php
                if(empty($errorjeton)){?>
                <p>* Ces zones sont obligatoires</p>



                <!--
                    form pour login
                 -->


                <p>Reinitialisation du mot de passe</p>
                <?php

                //  balise form début du formulaire
                //<!--balise form début du formulaire-->
                $array =array('name'=>'lostpassword','id'=>'lostpassword','autocomplete'=>'off');
                echo form_open('',$array);
                ?>

                <fieldset><!--début fieldset pour les coordonnées-->

                    <legend>Entrer votre email pour recevoir un lien de réinitialisation</legend>

                    <div class="form-group">
                        <label for="email">Email : * </label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="votre Email"  autocomplete="off" required  value="<?php echo set_value('email');?>">
                        <div id="demail"></div>
                        <?php echo form_error('email');?>
                        <br>
                    </div>



        <div class="form-group">
            <button type="submit"  class="btn btn-jarditou btn-lg">Connexion</button>    <button type="reset" class="btn btn-dark btn-lg">Annuler</button>
        </div>

        </form> <!--balise form fin du formulaire-->

        <?php }else{?>

            <div class="card m-4  p-5"  >
                <div class="card-body">
                    <h5 class="card-title">Nous avons un souci</h5>
                    <p class="card-text"><?php echo $errorjeton;?></p>

                </div>
            </div>

        <?php }?>



        </article>


    </div>
</div>
</div>
<!--
    Footer
-->