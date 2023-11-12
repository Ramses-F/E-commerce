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
<div class="starter">
    <h1>Liste des formations </h1>
</div>

<div class="table">
    <table>
        <thead>
            <tr>
                <th><strong>Image du produit</strong></th>
                <th><strong>Nom produit</strong></th>
                <th><strong>Description</strong></th>
                <th><strong>Prix</strong></th>
                <th><strong>Email du vendeur</strong></th>
            </tr>
        </thead>
        <tbody>
            <?php

            $req = $db->prepare('SELECT * FROM tb_produit');
            $req->execute();
            if($req->rowCount()){
            $results = $req->fetchAll(PDO::FETCH_OBJ);
            foreach ($results as $req) {
                $title = $req->title;
                $desc = $req->descrip;
                $price = $req->price;
                $mail = $req->mail_seller;
                $img = $req->img_prod;
            ?>
                <tr>
                    <td><?php echo $img;?></td>
                    <td><?php echo $title?></td>
                    <td><?php echo $desc;?></td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $mail; ?></td>
                </tr>
            <?php
                }
            }



            ?>
        </tbody>
    </table>
</div>

</tbody>
</table>

</body>
</html>
<?php
}
?>