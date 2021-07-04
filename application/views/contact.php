<!-- application/views/ajouter.php -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <article>
                <p>* Ces zones sont obligatoires</p>
                <?php echo validation_errors(); ?>
                <?php
                if (empty($error)) {
                    //  balise form début du formulaire
                    echo form_open('', 'name="formulaire_contact" id="formulaire_contact" '); ?>
                    <fieldset>
                        <!--début fieldset pour les coordonnées-->
                        <legend>Vos coordonnées</legend>
                        <div class="form-group">
                            <label for="nom">Votre nom* : </label>
                            <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom" value="<?php echo  set_value('nom'); ?>" required>
                            <div id="dnom"></div>
                            <?php echo form_error('nom'); ?>
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Votre prénom* : </label>
                            <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre prénom" value="<?php echo   set_value('prenom'); ?>" required>
                            <div id="dprenom"></div>
                            <?php echo form_error('prenom'); ?>
                            <br>
                        </div>

                        <p>Sexe* : </p>
                        <div class="form-check  form-check-inline">
                            <input type="radio" name="sexe" id="fem" class="form-check-input" value="féminin" checked>
                            <label for="fem">Fémimin </label>
                        </div>
                        <div class="form-check  form-check-inline">
                            <input type="radio" name="sexe" id="masc" class="form-check-input" value="masculin">
                            <label for="masc">Masculin</label><br>

                        </div>
                        <div class="form-group">
                            <label for="date">Date de naissance* : </label>
                            <input type="date" id="date" name="date" class="form-control" value="<?php echo   set_value('date'); ?>" required>
                            <div id="ddate"></div>
                            <?php echo form_error('date'); ?>
                            <br>
                        </div>

                        <div class="form-group">
                            <label for="cp">Code postal : </label>
                            <input type="text" id="cp" class="form-control" name="cp" value="<?php echo   set_value('cp'); ?>">
                            <div id="dcp"></div>
                            <?php echo form_error('cp'); ?><br>
                        </div>

                        <div class="form-group">
                            <label for="adresse">Adresse : </label>
                            <input type="text" id="adresse" name="adresse" class="form-control" placeholder="Votre adresse postale" value="<?php echo   set_value('adresse'); ?>">
                            <div id="dadresse"></div>
                            <?php echo form_error('cp'); ?>
                            <br>
                        </div>

                        <div class="form-group">
                            <label for="ville">Ville : </label>
                            <input type="text" id="ville" class="form-control" name="ville" value="<?php echo   set_value('ville'); ?>">
                            <div id="dville"></div>
                            <?php echo form_error('ville'); ?><br>
                        </div>

                        <div class="form-group">
                            <label for="email">Email : </label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="votre Email" value="<?php echo   set_value('email'); ?>" required>
                            <div id="demail"></div>
                            <?php echo form_error('email'); ?><br>
                        </div>

                    </fieldset>
                    <!--fin fieldset pour les coordonnées-->

                    <fieldset>
                        <!--début fieldset pour la demande-->
                        <legend>Votre demande</legend>
                        <div class="form-group">
                            <label for="mescommandes"> Sujet* : </label>
                            <?php $variable = array('id' => 'mescommandes', 'name' => 'mescommandes', 'class' => 'form-control');
                            // liste déroulante des catégories
                            $option = array(
                                ''         => 'Choisissez',
                                'Mes commandes'         => 'Mes commandes',
                                'question'           => 'Question sur un produit',
                                'Réclamation'         => 'Réclamation',
                                'Autres'        => 'Autres'
                            );
                            echo form_dropdown('mescommandes', $option, set_value('Choisissez', set_value('mescommandes')), $variable);
                            ?>

                            <div id="dmescommandes"></div><br>
                        </div>

                        <div class="form-group">
                            <label for="question">Votre question* : </label>
                            <textarea name="question" id="question" class="form-control" rows="2" cols="20" required><?php echo set_value('question'); ?></textarea>
                            <div id="dquestion"></div>
                            <?php echo form_error('question'); ?><br>
                        </div>
                    </fieldset>
                    <!--fin fieldset pour la demande-->
                    <br>

                    <div class="form-group">

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cgu" name="cgu" required>
                            <label class="custom-control-label" for="cgu">* J'accepte le traitement informatique de ce formulaire.</label>
                            <div id="dcgu"></div><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-dark btn-lg">Envoyer</button> <button type="reset" class="btn btn-dark btn-lg">Annuler</button>
                    </div>
                <?php echo  form_fieldset_close();
                } else { ?>
                    <div class="card m-4 p-5">
                        <div class="card-body">
                            <h1 class="card-title">Nous contacter</h1>
                            <p class="card-text"> <?php echo $error; ?></p>

                        </div>
                    </div>

                <?php
                }
                ?>

                <!--balise form fin du formulaire-->

            </article>
        </div>
    </div>
</div>