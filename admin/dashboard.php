<?php
session_start();
include '../config/db.php';
if (1){

}
if (isset($_SESSION['id_admin'])){
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>E-Commerce</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
<!--===============================================================================================-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<!--===============================================================================================-->
</head>
<body class="animsition">
<!--Header-->
<div class="header">
    <div class="logo"><h3>Gestion des formations</h3></div>
    <div class="nav-desktop">
        <menu>
            <ul>
                <li><a href="index.php">Acceuil</a></li>
                <li><a href="listprod.php">Liste des produits</a></li>
                <li><a href="../logout.php">Déconnexion</a></li>
            </ul>
        </menu>
    </div>
</div>

<div class="container mt-5">
    <?php
    if(isset($_POST['poster'])){
        $title = $_POST['title'];
        $price = $_POST['prix'];
        $descrip = $_POST['descript'];
        $mail = $_POST['mail_seller'];
        $img = $_POST['image'];
        $cat = $_POST['categorie'];

        if(!empty($nom) && !empty($pric) && !empty($descrip) && !empty($mail) && !empty($cat) && !empty($img)){
                        //Ajout de l'image
            //$dayy = date('Ymdahis', time());
            $dayy = date('Ymdhisa', time());
            $new_name = 'PROD' . $dayy . "." . $extension;
            $addProduit = $db->prepare("INSERT INTO tb_produits(title, price, descrip, id_cat, img_prod, mail_seller)
            VALUES (:titre, :prix, :description_, :id_cat, :img_prod, :mail_seller");
            $addProduit->bindParam(':titre', $title, PDO::PARAM_STR);
            $addProduit->bindParam(':prix', $price, PDO::PARAM_STR);
            $addProduit->bindParam(':descrip', $descript, PDO::PARAM_STR);
            $addProduit->bindParam(':mail_seller', $mail, PDO::PARAM_STR);
            $addProduit->bindParam(':categorie', $cat, PDO::PARAM_STR);
            $addProduit->bindParam(':img', $new_name, PDO::PARAM_STR);
            if($addProduit->execute()) {
                echo "Produit mis en ligne";
            }else{
                echo "Il y a des erreurs";
            }
    }
}
    ?>
    <form action="" method="post">
        <label for="nom">Nom du produit : </label><br/>
        <input type="text" name="title" required placeholder="Entrer le nom de votre produit"><br/>
        <label for="prix">Prix : </label><br/>
        <input type="number" min="0" max="99999999999999999
        "name="prix" required placeholder="Entrer le prix de votre produit"><br/>
        <label for="" class="form-label">Catégorie</label>
        <select class="form-select form-select-lg" id="cat" name="categorie" required>
          <option value="">Choisir...</option>
          <?php
        
          $getCat = $db->prepare("SELECT * FROM tb_categorie");
          if ($getCat->execute()) {
            $getCat_resultats = $getCat->fetchAll(PDO::FETCH_OBJ);
            if ($getCat->rowCount() > 0) {
              foreach ($getCat_resultats as $getCat_resultats) {
          ?>
                <option value="<?php echo $getCat_resultats->id_cat; ?>">
                  <?php echo $getCat_resultats->title; ?>
                </option>
          <?php
              }
            } else echo "vide";
          } else echo ""
          ?>
        
        </select>
        <label for="description">Description : </label><br/>
        <textarea name="descript" rows="8" cols="80" required></textarea><br/>
        <label for="mail_vendeur">Email du vendeur : </label><br/>
        <textarea name="mail_seller" rows="8" cols="80" required></textarea><br/>
        <label for="image">Image : </label><br/>
        <input type="file" accept=".jpg,.png,.jpeg,.gif" name="img" required><br/>
        <button type="submit" name="poster">Poster</button>
    </form>
</div>
</body>
</html>
<?php
}
?>