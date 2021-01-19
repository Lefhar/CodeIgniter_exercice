<!-- application/views/detail.php -->
<div class="container">
    <div class="row">
<div class="col-12">   
<article>

  
<div class="card m-4 p-4" >
<?php echo '<img  class="img-fluid" width="160" src="'.base_url('assets/images/'.$produit->pro_id.'.'.$produit->pro_photo.'').'" alt="'.$produit->cat_nom.' '.$produit->pro_libelle.' '.$produit->pro_couleur.'" 
    title="'.$produit->cat_nom.' '.$produit->pro_libelle.' '.$produit->pro_couleur.'">';?>
     <div class="card-body">
 <h1 class="card-title">Etes vous sûr de vouloir supprimer <?php echo $produit->cat_nom.' '.$produit->pro_libelle.' '.$produit->pro_couleur.'';?> de la base de données ?</h1>
     <?php 
     
    //  balise form début du formulaire
       echo form_open('','name="suppression_produit" id="suppression_produit"'); ?>

          <?php    

        $data = array('name' => 'confirm','id' => 'confirm','class' => 'form-control','type'=>'hidden','value' => 'yes');
        echo form_input($data);


        echo '<div class="form-group">';
        //bouton Confirmation
         echo form_submit('', 'Confirmer', 'class="btn btn-dark btn-lg"');
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