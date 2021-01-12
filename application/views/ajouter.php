<!-- application/views/detail.php -->
<div class="container-fluid">
    <div class="row">
<div class="col-12">   
<article>

  




 <legend> Formulaire d'ajout d'un produit </legend>
     <?php echo validation_errors(); ?>
     <!-- <form action="add_script.php" method="POST" id="ajout_produit"  name="ajout_produit"  >  -->
         <!--balise form début du formulaire-->
        <?php echo form_open('','name="ajout_produit" id="ajout_produit"'); ?>
          <fieldset>

        <div class="form-group row">
        <label for="pro_ref" class="col-sm-2 col-form-label col-12">Référence </label>
        <div class="col-sm-10 col-12"> 
       <?php $data = array('name' => 'pro_ref','id' => 'pro_ref','class' => 'form-control','data-maxlength' => '10','placeholder' => 'Référence (10 caractères MAX)"');
       echo form_input($data).'<br>';?>
        <div id="pro_refError" class="counter"><span>0</span> caractères (10 max)</div> 
        </div>
        </div>  

        <div class="form-group row">
        <label for="pro_libelle" class="col-sm-2 col-form-label col-12">Libelle </label>
        <div class="col-sm-10 col-12"> 
        <?php $data = array('name' => 'pro_libelle','id' => 'pro_libelle','class' => 'form-control','data-maxlength' => '200','placeholder' => 'Libelle (200 caractères MAX)"');
       echo form_input($data).'<br>';?>

        <div id="pro_libelleError" class="counter"><span>0</span> caractères (200 max)</div> 
        </div>
        </div>   

        <div class="form-group row">
        <label for="pro_couleur" class="col-sm-2 col-form-label col-12">Couleur </label>
        <div class="col-sm-10 col-12"> 
        <?php $data = array('name' => 'pro_couleur','id' => 'pro_couleur','class' => 'form-control','data-maxlength' => '30','placeholder' => 'Couleur (30 caractères MAX)"');
       echo form_input($data).'<br>';?>

        <div id="pro_couleurError" class="counter"><span>0</span> caractères (30 max)</div> 
        </div>
        </div>  

        <div class="form-group row">
        <label for="pro_img" class="col-sm-2 col-form-label col-12">Image </label>
        <div class="col-sm-10 col-12"> 
        <?php $data = array('name' => 'pro_img','id' => 'pro_img','class' => 'form-control');
       echo form_input($data).'<br>';?>
        </div>
        </div>   


        <div class="form-group row">
        <label for="pro_prix" class="col-sm-2 col-form-label col-12">Prix </label>
        <div class="col-sm-10 col-12"> 
            <?php $data = array('name' => 'pro_prix','id' => 'pro_prix','class' => 'form-control','step' => 'any','type' => 'number');
            echo form_input($data).'<br>';?>
        </div>
        </div>   


        <div class="form-group row">
        <label for="pro_stock" class="col-sm-2 col-form-label col-12">Stock </label>
        <div class="col-sm-10 col-12"> 
        <?php $data = array('name' => 'pro_stock','id' => 'pro_stock','class' => 'form-control','type' => 'number');
       echo form_input($data).'<br>';?>
        </div>
        </div>   

        <div class="form-group row">
        <label for="cat_id" class="col-sm-2 col-form-label" >Catégorie  </label>
        <div class="col-sm-10 col-12"> 
        <select name="cat_id" id="cat_id" class="form-control">
        <?php   

    foreach ($categorie as $row) 
    {
     echo '<option value="'.$row->cat_id.'">'.$row->cat_nom.'</option>' ;
    }
    ?></select><br>
        </div>
        </div>
           
        <div class="form-group row">
        <label for="pro_description" class="col-sm-2 col-form-label" >Description produit  </label>
        <div class="col-sm-10 col-12"> 
        <textarea rows="8" name="pro_description"   id="pro_description"  data-maxlength="1000" class="form-control" cols="30" rows="10"  placeholder="description (1000 caractères MAX)"></textarea><br>
        <div id="pro_descriptionError" class="counter"><span>0</span> caractères (1000 max)</div> 
        </div>
        </div>

        <div class="form-group">
        <?php echo form_submit('', 'Ajouter', 'class="btn btn-dark btn-lg"');
         echo form_reset('', 'Annuler', 'class="btn btn-danger btn-lg"');?>
         </div>

  </fieldset>
   <!--balise form fin du formulaire-->
     <?php echo  form_fieldset_close();?>
 </article>
</div>
</div>
</div>