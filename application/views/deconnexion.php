<!-- application/views/deconnexion.php -->
<div class="container">
    <div class="row">
<div class="col-12">   
<article>

  
<div class="card m-4 p-5" >
     <div class="card-body">
 <h1 class="card-title">Etes vous sûr de vouloir vous déconnecter ?</h1>
     <?php 
     
    //  balise form début du formulaire
       echo form_open('','name="deconnexion" id="deconnexion"'); ?>

          <?php    

        $data = array('name' => 'confirm','id' => 'confirm','class' => 'form-control','type'=>'hidden','value' => 'yes');
        echo form_input($data);


        echo '<div class="form-group">';
        //bouton Confirmation
         echo form_submit('', 'Confirmer', 'class="btn btn-jarditou btn-lg"');
         //bouton pour réinitialiser 
         echo form_reset('', 'Annuler', 'class="btn btn-danger btn-lg"','onclick="location.href = \''.site_url("produits/liste").'\';"' );
        echo ' </div>
        <!--balise form fin du formulaire-->';
        echo  form_fieldset_close();
 ?>
        </div>
 </div>
 </article>
        </div>
    </div>
</div>