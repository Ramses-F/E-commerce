<?php
session_start();
include 'config/db.php';
error_reporting(0);
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
<!--===============================================================================================-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<!--===============================================================================================-->
</head>
<body class="animsition">
<?php include 'includes/header.php';?>

<section class="bg0 p-t-23 p-b-140">
	<div class="container">
	<!-- Product -->
	<div class="bg0 m-t-23 p-b-140">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
                <?php
                    if (!empty($_GET['search'])) {
                        // Recherche par mot clé dans les titres des annonces
                        $requete = "SELECT * FROM tb_produit WHERE LOWER(`title`) LIKE '%" . strtolower($_GET["search"]) . "%'";
                        $stmt = $db->prepare($requete);
                        $stmt->execute();
                        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
                        $cnt = $stmt->rowCount();
                        if ($stmt->rowCount() > 0) {
                ?>
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<h4 class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1">
						Vous avez cherché : <?php echo strtolower($_GET['search'])?> (<?php echo $cnt?> produits trouvés)
                    </h4>
				</div>
            </div>
            <div class="row isotope-grid">
                <?php
                    foreach ($results as $result) {
                        $id_prod = $result->id_prod;
                        $title = $result->title;
                        $descrip = $result->descrip;
                        $price = $result->price;
                ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
				    	<!-- Block2 -->
				    	<div class="block2">
				    		<div class="block2-pic hov-img0">
				    			<img src="images/product-01.jpg" alt="IMG-PRODUCT">

				    			<a href="product-detail.php?pid=<?php echo $id_prod?>" 
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
				    				View
				    			</a>
				    		</div>

				    		<div class="block2-txt flex-w flex-t p-t-14">
				    			<div class="block2-txt-child1 flex-col-l ">
				    				<a href="product-detail.php?pid=<?php echo $id_prod?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
				    					<?php echo $title?>
				    				</a>

				    				<span class="stext-105 cl3">
				    					<?php echo $price?> FCFA
				    				</span>
				    			</div>

				    			<div class="block2-txt-child2 flex-r p-t-3" hidden>
				    				<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
				    					<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png" alt="ICON">
				    					<img class="icon-heart2 dis-block trans-04 ab-t-l" src="images/icons/icon-heart-02.png" alt="ICON">
				    				</a>
				    			</div>
				    		</div>
				    	</div>
				    </div>
				    <?php
				    		}
				    	}else{
				    		echo 'Aucun produit trouvé pour : '.strtolower($_GET['search']);
				    	}
				    }
				    ?>
            </div>
		</div>
	</div>
    </div>
</section>
<?php
include 'includes/footer.php';
?>
</body>
</html>