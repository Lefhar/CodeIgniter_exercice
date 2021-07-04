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
                if (!empty($error)) {
                    echo $error;
                } ?>
                <?php
                if (empty($errorjeton)){
                ?>
                <p>* Ces zones sont obligatoires</p>


                <!--
                    form pour login
                 -->


                <p>Reinitialisation du mot de passe</p>
                <?php

                //  balise form début du formulaire
                //<!--balise form début du formulaire-->
                $array = array('name' => 'resetpassword', 'id' => 'resetpassword', 'autocomplete' => 'off');
                echo form_open('', $array);
                ?>

                <fieldset><!--début fieldset pour les coordonnées-->

                    <legend>Nouveau mot de passe</legend>

                    <div class="form-group">
                        <label for="password">Mot de passe : (votre mot de passe doit contenir au minimum 12 caractéres
                            dont une majuscule un chiffre et un symbole) *</label>

                        <div class="input-group">
                            <input type="password" id="password" name="password"
                                   value="<?php echo set_value('password'); ?>" class="form-control"
                                   placeholder="Votre mot de passe" minlength="12" autocomplete="off" required=""
                                   aria-describedby="viewpassword">
                            <div class="input-group-append"> <span class="input-group-text" id="viewpassword">
    <i class="fa fa-eye-slash" aria-hidden="true" id="eyepassword"></i></span>
                            </div>
                        </div>
                        <div id="dpassword"></div>
                        <?php echo form_error('password'); ?>
                    </div>

                    <div class="form-group" id="divconfirmmdp">
                        <label for="confirpassword">Confirmer votre mot de passe : * </label>
                        <div class="input-group">
                            <input type="password" id="confirpassword" name="confirpassword"
                                   value="<?php echo set_value('confirpassword'); ?>" class="form-control"
                                   minlength="12" placeholder="Confirmer votre mot de passe" autocomplete="off"
                                   required="" aria-describedby="viewconfirpassword">
                            <div class="input-group-append">
                                <span class="input-group-text" id="viewconfirpassword"><i class="fa fa-eye-slash"
                                                                                          aria-hidden="true"
                                                                                          id="eyeconfirmpassword"></i></span>
                            </div>
                        </div>
                        <div id="dconfirpassword"></div>
                        <?php echo form_error('confirpassword'); ?>
                    </div>
                    <br>
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-jarditou btn-lg">Reinitialiser</button>
            <button type="reset" class="btn btn-dark btn-lg">Annuler</button>
        </div>

        </form> <!--balise form fin du formulaire-->

        <?php } else {
            ?>

            <div class="card m-4  p-5">
                <div class="card-body">
                    <h5 class="card-title">Nous avons un souci</h5>
                    <p class="card-text"><?php echo $errorjeton; ?></p>

                </div>
            </div>

        <?php } ?>


        </article>


    </div>
</div>
</div>
<!--
    Footer
-->