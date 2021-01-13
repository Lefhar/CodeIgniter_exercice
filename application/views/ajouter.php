<!-- application/views/detail.php -->
<div class="container">
    <div class="row">
<div class="col-12">   
<article>

  




 <legend> Formulaire d'ajout d'un produit </legend>
     <?php echo validation_errors(); 
    //  balise form début du formulaire
       echo form_open('','name="ajout_produit" id="ajout_produit"'); ?>
          <fieldset>

          <?php    
          //label Référence
        $data = array('class' => 'col-sm-2 col-form-label col-12');
        echo '<div class="form-group row">'.form_label('Référence', 'pro_ref',$data).'
        <div class="col-sm-10 col-12"> ';
         //input Référence
        $data = array('name' => 'pro_ref','id' => 'pro_ref','class' => 'form-control','data-maxlength' => '10','placeholder' => 'Référence (10 caractères MAX)"');
        echo form_input($data).'
        <div id="pro_refError" class="counter"><span>0</span> caractères (10 max)</div> 
        </div>
        </div>'; 
        
        $data = array('class' => 'col-sm-2 col-form-label col-12');
       echo '<div class="form-group row">'.form_label('Libelle', 'pro_libelle',$data).'<br>
       <div class="col-sm-10 col-12">';
         $data = array('name' => 'pro_libelle','id' => 'pro_libelle','class' => 'form-control','data-maxlength' => '200','placeholder' => 'Libelle (200 caractères MAX)"');
        echo form_input($data).'<div id="pro_libelleError" class="counter"><span>0</span> caractères (200 max)</div> 
        </div>
        </div> ';    
        

       //label couleur
        $data = array('class' => 'col-sm-2 col-form-label col-12');
         echo '<div class="form-group row">'.form_label('Couleur', 'pro_couleur',$data).'
         <div class="col-sm-10 col-12"> ';
          //input pro couleur
         $data = array('name' => 'pro_couleur','id' => 'pro_couleur','class' => 'form-control','data-maxlength' => '30','placeholder' => 'Couleur (30 caractères MAX)"');
        echo form_input($data).'
        <div id="pro_couleurError" class="counter"><span>0</span> caractères (30 max)</div> 
        </div>
        </div>  ';



        //label Image
        $data = array('class' => 'col-sm-2 col-form-label col-12');
         echo '<div class="form-group row">
         '.form_label('Image', 'pro_img',$data).'
         <div class="col-sm-10 col-12"> ';
        //input pro Image
         $data = array('name' => 'pro_img','id' => 'pro_img','class' => 'form-control');
        echo form_input($data).'
        </div>
        </div>  ';



        //label Prix
        $data = array('class' => 'col-sm-2 col-form-label col-12');
         echo '<div class="form-group row">
         '.form_label('Prix', 'pro_prix',$data).'
         <div class="col-sm-10 col-12"> ';
        //input Prix
         $data = array('name' => 'pro_prix','id' => 'pro_prix','class' => 'form-control','step' => 'any','type' => 'number');
        echo form_input($data).'
        </div>
        </div>  ';


        //label Prix
        $data = array('class' => 'col-sm-2 col-form-label col-12');
         echo '<div class="form-group row">
         '.form_label('Stock', 'pro_stock',$data).'
         <div class="col-sm-10 col-12"> ';
        //input Prix
         $data = array('name' => 'pro_stock','id' => 'pro_stock','class' => 'form-control','type' => 'number');
        echo form_input($data).'
        </div>
        </div>  ';
        
        //label catégorie
         $data = array('class' => 'col-sm-2 col-form-label col-12');
        echo '<div class="form-group row">
        '.form_label('Catégorie', 'cat_id',$data).'
         <div class="col-sm-10 col-12"> ';
        $option = array();//on déclare le tableau
            foreach ($categorie as $key => $row) 
            {
                
            $option[$row->cat_id] = $row->cat_nom;// donné du tableaux
            }

        $variable = array('id' => 'cat_id','class' => 'form-control');
        // liste déroulante des catégories
        echo form_dropdown('pro_cat_id',$option,'',$variable).'
        </div>
        </div>  ';

        //label catégorie
        $data = array('class' => 'col-sm-2 col-form-label col-12');
        echo '<div class="form-group row">
        '.form_label('Description produit', 'pro_description',$data).'
        <div class="col-sm-10 col-12"> ';
        $data = array('name' => 'pro_description','id' => 'pro_description','class' => 'form-control','data-maxlength' => '1000','cols' => '30','rows' => '10','placeholder' => 'description (1000 caractères MAX)');
       echo form_textarea($data).'
        <div id="pro_descriptionError" class="counter"><span>0</span> caractères (1000 max)</div> 
        </div>
        </div>

        <div class="form-group">';
        //bouton ajouter
         echo form_submit('', 'Ajouter', 'class="btn btn-dark btn-lg"');
         //bouton pour réinitialiser 
         echo form_reset('', 'Annuler', 'class="btn btn-danger btn-lg"');
        echo ' </div>
        </fieldset>
        <!--balise form fin du formulaire-->';
        echo  form_fieldset_close();
 ?>
 </article>
        </div>
    </div>
</div>