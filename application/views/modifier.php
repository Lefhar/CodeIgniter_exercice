<!-- application/views/detail.php -->
<div class="container">
    <div class="row">
<div class="col-12">   
<article>

  




 <legend> Formulaire de modification de <?php if(!empty($produit)){echo $produit->pro_libelle;?> </legend>
     <?php 
     
    //  balise form début du formulaire
       echo form_open_multipart('','name="modification_produit" id="modification_produit"'); ?>
          <fieldset>

          <?php    
          //label Référence
        $data = array('class' => 'col-sm-2 col-form-label col-12');
        echo '<div class="form-group row">'.form_label('Référence', 'pro_ref',$data).'
        <div class="col-sm-10 col-12"> ';
         //input Référence
        $data = array('name' => 'pro_ref','id' => 'pro_ref','class' => 'form-control','data-maxlength' => '10','placeholder' => 'Référence (10 caractères MAX)','value' => ''.set_value('pro_ref',$produit->pro_ref).'');
        echo form_input($data).'
        <div id="pro_refError" class="counter"><span>0</span> caractères (10 max)</div> 
        '.form_error('pro_ref').'
        </div>
        </div>'; 
        
        $data = array('class' => 'col-sm-2 col-form-label col-12');
       echo '<div class="form-group row">'.form_label('Libelle', 'pro_libelle',$data).'<br>
       <div class="col-sm-10 col-12">';
         $data = array('name' => 'pro_libelle','id' => 'pro_libelle','class' => 'form-control','data-maxlength' => '200','placeholder' => 'Libelle (200 caractères MAX)','value' => ''.set_value('pro_libelle',$produit->pro_libelle).'');
        echo form_input($data).'
        <div id="pro_libelleError" class="counter"><span>0</span> caractères (200 max)</div> 
        '.form_error('pro_libelle').'
        </div>
        </div> ';    
        

       //label couleur
        $data = array('class' => 'col-sm-2 col-form-label col-12');
         echo '<div class="form-group row">'.form_label('Couleur', 'pro_couleur',$data).'
         <div class="col-sm-10 col-12"> ';
          //input pro couleur
         $data = array('name' => 'pro_couleur','id' => 'pro_couleur','class' => 'form-control','data-maxlength' => '30','placeholder' => 'Couleur (30 caractères MAX)','value' => ''.set_value('pro_couleur',$produit->pro_couleur).'');
        echo form_input($data).'
        <div id="pro_couleurError" class="counter"><span>0</span> caractères (30 max)</div> 
        '.form_error('pro_couleur').'
        </div>
        </div>  ';



        //label Image

        $data = array('class' => 'col-sm-2 col-form-label col-12');

         echo '<div class="form-group row">
         '.form_label('Image', 'pro_photo',$data).'
         <div class="col-sm-10 col-12"> ';
        //input pro Image
         $data = array('name' => 'pro_photo','id' => 'pro_photo','class' => 'form-control-file','type' => 'file','value' => ''.set_value('pro_photo',$produit->pro_id.'.'.$produit->pro_photo).'');
        // echo form_upload($data).'';
        echo '<img  class="img-fluid" width="100" src="'.base_url("assets/images/".$produit->pro_id.".".$produit->pro_photo).'" alt="'.$produit->pro_libelle.'"><br>
        <a class="btn btn-info btn-lg" onclick="add_fields();" >Modifier</a>
        <div id="img" > </div>';
        echo form_error('pro_photo').'';
        if(!empty($sUploadErrors)){echo $sUploadErrors;}
       echo ' </div>
        </div>  ';



        //label Prix
        $data = array('class' => 'col-sm-2 col-form-label col-12');
         echo '<div class="form-group row">
         '.form_label('Prix', 'pro_prix',$data).'
         <div class="col-sm-10 col-12"> ';
        //input Prix
         $data = array('name' => 'pro_prix','id' => 'pro_prix','class' => 'form-control','step' => 'any','type' => 'number','value' => ''.set_value('pro_prix',$produit->pro_prix).'');
        echo form_input($data).'
        '.form_error('pro_prix').'
        </div>
        </div>  ';


        //label stock
        $data = array('class' => 'col-sm-2 col-form-label col-12');
         echo '<div class="form-group row">
         '.form_label('Stock', 'pro_stock',$data).'
         <div class="col-sm-10 col-12"> ';
        //input stock
         $data = array('name' => 'pro_stock','id' => 'pro_stock','class' => 'form-control','type' => 'number', 'value' => ''.set_value('pro_stock',$produit->pro_stock).'');
        echo form_input($data).'
        '.form_error('pro_stock').'
        </div>
        </div>  ';


        //label bloqué
        $data = array('class' => 'col-sm-2 col-form-label col-12');
        if($produit->pro_bloque==1){$bloque = "disabled"; $checked = TRUE; }else{$bloque = "disabled";$checked = FALSE;}
        echo '<div class="form-group row">'.form_label('Produit bloqué', 'pro_bloque',$data).'
        <div class="col-sm-10 col-12">
        <div class="checkbox '.$bloque.'">';
        //input pro bloqué
         $data = array('name' => 'pro_bloque','id' => 'pro_bloque','class' => 'form-control','data-toggle' => 'toggle','data-onstyle'=>'danger','data-offstyle'=>'success', 'data-on' => 'Oui', 'data-off' => 'Non', 'value' => ''.set_value('pro_bloque',$produit->pro_bloque).'');
         echo form_checkbox($data,'',$checked).'
         </div>
          </div>
              </div> ';
        
        //label catégorie
         $data = array('class' => 'col-sm-2 col-form-label col-12');
        echo '<div class="form-group row">
        '.form_label('Catégorie', 'cat_id',$data).'
         <div class="col-sm-10 col-12"> ';
        $option = array();//on déclare le tableau
          if(!empty($categorie)) {
              foreach ($categorie as $key => $row) {

                  $option[$row->cat_id] = $row->cat_nom;// donné du tableaux
              }
          }
        $variable = array('id' => 'cat_id','class' => 'form-control');
        // liste déroulante des catégories
        echo form_dropdown('pro_cat_id',$option,$produit->pro_cat_id,$variable).'
        '.form_error('pro_cat_id').'
        </div>
        </div>  ';

        //label catégorie
        $data = array('class' => 'col-sm-2 col-form-label col-12');
        echo '<div class="form-group row">
        '.form_label('Description produit', 'pro_description',$data).'
        <div class="col-sm-10 col-12"> ';
        $data = array('name' => 'pro_description','id' => 'pro_description','class' => 'form-control','data-maxlength' => '1000','cols' => '30','rows' => '10','placeholder' => 'description (1000 caractères MAX)','value' => ''.set_value('pro_description',$produit->pro_description).'');
       echo form_textarea($data).'
        <div id="pro_descriptionError" class="counter"><span>0</span> caractères (1000 max)</div> 
        '.form_error('pro_description').'
        </div>
        </div>


        <div class="form-group">';
        //bouton ajouter
         echo form_submit('', 'Modifier', 'class="btn btn-dark btn-lg"');
         //bouton pour réinitialiser 
         echo form_reset('', 'Annuler', 'class="btn btn-danger btn-lg"');
        echo ' </div>
        </fieldset>
        <!--balise form fin du formulaire-->';
        echo  form_fieldset_close();
          }
 ?>
 </article>
        </div>
    </div>
</div>