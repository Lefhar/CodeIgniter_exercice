<!-- application/views/liste.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des produits</title>
</head>
<body>
    <h1>Liste des produits</h1>
    <p><?php foreach($produit as $item):?>
 
 <p><?php echo $item;?></p>
  
 <?php endforeach;?></p>
</body>
</html>