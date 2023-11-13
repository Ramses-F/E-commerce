<?php
session_start();
include 'config/db.php';

if(1){}
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    // Code pour ajouter une commande à la table tb_commandes
    if (isset($_POST['valid_panier'])) {
        $id_cart = $_SESSION['current_cart_id'];

        // Vérifier si un e-mail a déjà été envoyé pour ce panier
        $check_email_sent = $db->prepare("SELECT COUNT(*) FROM tb_commandes WHERE id_cart = :id_cart");
		$check_email_sent->bindParam(':id_cart', $id_cart, PDO::PARAM_STR);
        $check_email_sent->execute();
        $email_sent_count = $check_email_sent->fetchColumn();

        if ($email_sent_count == 0) {
            // Récupérer l'e-mail et le numéro de téléphone de l'utilisateur depuis la table tb_users
            $get_user_info = $db->prepare("SELECT email, contact FROM tb_users WHERE id_user = :id_user");
			$get_user_info->bindParam(':id_user', $id_user, PDO::PARAM_STR);
            $get_user_info->execute();
            $user_info = $get_user_info->fetch(PDO::FETCH_ASSOC);

            $user_email = $user_info['email'];
            $user_phone = $user_info['contact'];

            // Insérer la commande dans la table tb_commandes
            $insert_commande = $db->prepare("INSERT INTO tb_commandes (id_cart, id_user, date_com, email_user, phone_user)
			VALUES (:id_cart, :id_user, NOW(), :email_user, :phone_user)");
			$check_email_sent->bindParam(':id_cart', $id_cart, PDO::PARAM_STR);
			$check_email_sent->bindParam(':id_user', $id_user, PDO::PARAM_STR);
			$check_email_sent->bindParam(':email_user', $user_email, PDO::PARAM_STR);
			$check_email_sent->bindParam(':phone_user', $user_phone, PDO::PARAM_STR);
            $insert_commande->execute();

            // Mettre à jour le statut du panier
            $update_cart_status = $db->prepare("UPDATE tb_carts SET status = 'Traitée' WHERE id_cart = :id_cart");
			$update_cart_status->bindParam(':id_cart', $id_cart, PDO::PARAM_STR);
            $update_cart_status->execute();

            // Réinitialiser l'id du panier actuel dans la session
            unset($_SESSION['current_cart_id']);

            // Récupérer les détails de la commande pour l'e-mail
            $get_cart_details = $db->prepare("SELECT p.title, p.price, oi.size_prod, oi.color, ci.quantity
                                             FROM tb_items_cart ci
                                             JOIN tb_option oi ON ci.id_opt = oi.id_opt
                                             JOIN tb_produit p ON ci.id_prod = p.id_prod
                                             WHERE ci.id_cart = :id_cart");
			$get_cart_details->bindParam(':id_cart', $id_cart, PDO::PARAM_STR);
            $get_cart_details->execute();
            $cart_details = $get_cart_details->fetchAll(PDO::FETCH_ASSOC);

            // Construire le corps de l'e-mail avec les détails de la commande
            $email_subject = "Confirmation de commande";
            $email_body = "Merci pour votre commande. Voici les détails de votre commande :\n";
            $email_body .= "Numéro de téléphone : $user_phone\n";

            foreach ($cart_details as $item) {
                $email_body .= "Produit: {$item['title']} | Taille: {$item['size_prod']} | Couleur: {$item['color']} | Prix: {$item['price']} | Quantité: {$item['quantity']}\n";
            }

            // Envoyer l'e-mail de confirmation
            mail($user_email, $email_subject, $email_body, "From: kamagatefallet3@gmail.com"); // Remplacez par votre adresse e-mail

            echo "Commande validée. Vous recevrez un e-mail de confirmation.";
        } else {
            echo "Un e-mail de confirmation a déjà été envoyé pour ce panier.";
        }
    }


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
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Shoping Cart
			</span>
		</div>
	</div>
		

	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85" action="" method="post">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<?php
								$id_cart = $_SESSION['current_cart_id'];
								if (isset($_POST['refresh_cart_item'])) {
									$id_cart_item = $_POST['id_cart_items'];
									$quantity = $_POST['quantity'];
									$color = $_POST['color'];
								
									// Mettre à jour la quantité et la couleur dans la table tb_items_cart
									$update_cart_item = $db->prepare("UPDATE tb_items_cart
									SET quantity = :quantity, color = :color
									WHERE id_cart_item =:id_cart_items");
									$update_cart_item->bindParam(':quantity', $quantity, PDO::PARAM_STR);
									$update_cart_item->bindParam(':color', $color, PDO::PARAM_STR);
									$update_cart_item->bindParam(':id_cart_items', $id_cart_item, PDO::PARAM_STR);
									$update_cart_item->execute();
								
									echo "Produit mis à jour dans le panier.";
								}
								// Récupérer les informations du panier
								$get_cart_items = $db->prepare("SELECT ci.*, p.title, p.price, oi.size_prod, oi.color
															   FROM tb_items_cart ci
															   JOIN tb_produit p ON ci.id_prod = p.id_prod
															   LEFT JOIN tb_option oi ON ci.id_opt = oi.id_opt
															   WHERE ci.id_cart = :id_cart");
								$get_cart_items->bindParam('id_cart', $id_cart, PDO::PARAM_STR);
								$get_cart_items->execute();
							
								if ($get_cart_items->rowCount() > 0) {
							?>
							<table class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Product</th>
									<th class="column-2">Titlte</th>
									<th class="column-3">Price</th>
									<th class="column-4">Size</th>
									<th class="column-5">Color</th>
									<th class="column-6">Quantity</th>
									<th class="column-7">Total produit</th>
									<th class="column-8">Action</th>
								</tr>

								<tr class="table_row">
								<?php
									$total_panier = 0;
					
									while ($cart_item = $get_cart_items->fetch(PDO::FETCH_ASSOC)) {
										$total_produit = $cart_item['price'] * $cart_item['quantity'];
										$total_panier += $total_produit;
								?>
									<td class="column-1">
										<div class="how-itemcart1">
											<img src="ima6ges/item-cart-04.jpg" alt="IMG">
										</div>
									</td>
									<td class="column-2"><?php echo $cart_item['title']; ?></td>
									<td class="column-3"><?php echo $cart_item['price']; ?></td>
									<td class="column-4">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">
											<input class="mtext-104 cl3 txt-center num-product" type="text" name="size" style="border-bottom: 2px solid violet;" value="<?php echo $cart_item['size_prod']; ?>?>">
										</div>
									</td>
									<td class="column-5">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">
											<input class="mtext-104 cl3 txt-center num-product"
											type="text" name="color" style="border-bottom: 2px solid violet;" 
											value="<?php echo $cart_item['color']; ?>?>">
										</div>
									</td>
									<td class="column-6">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" 
											type="number" name="qte" style="border-bottom: 2px solid violet;" 
											value="<?php echo $cart_item['qteProd']; ?>?>" min="1">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
									</td>
									<td class="column-7"><?php echo $total_produit; ?></td>
									<?php
										}
									?>
									<td class="column-8">
										<form action="" method="post">
											<button type="submit" style="margin:5px;" class="cl3 txt-center hov-cl1" name="refresh_cart_item">
												Refresh
											</button>
										</form>
									</td>
								</tr>

								<tr class="table_row">
									<td class="column-1">
										<div class="how-itemcart1">
											<img src="images/item-cart-05.jpg" alt="IMG">
										</div>
									</td>
									<td class="column-2">Lightweight Jacket</td>
									<td class="column-3">$ 16.00</td>
									<td class="column-4">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product2" value="1">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
									</td>
									<td class="column-5">$ 16.00</td>
								</tr>
							</table>
							<?php
								} else {
								    echo "Pas de panier.";
								}
							?>
						</div>

						<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
							<div class="flex-w flex-m m-r-20 m-tb-5">
								<input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="total" value="Total : <?php echo $total_panier();?>">
									
								<div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
									Update Cart
								</div>
							</div>

							<div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
								Submit Cart
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Cart Totals
						</h4>

						<div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Shipping:
								</span>
							</div>

							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								<p class="stext-111 cl6 p-t-2">
									There are no shipping methods available. Please double check your address, or contact us if you need any help.
								</p>
								
								<div class="p-t-15">
									<div class="bor8 bg0 m-b-22">
										<?php
											$getInfosProd = $db->prepare("SELECT * FROM tb_users");
											if ($getInfosProd->execute()) {
												$getInfosProd_resultats = $getInfosProd->fetchAll(PDO::FETCH_OBJ);
												if ($getInfosProd->rowCount() > 0) {
												  foreach ($getInfosProd_resultats as $getInfosProd_resultats) {
													$address = $getInfosProd_resultats->default_address;
											  
										?>
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="adress" value="<?php echo $address?>">
										<?php
												}
											}
										}
										?>
									</div>
									
									<div class="flex-w">
										<button type="submit" class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
											Update Totals
										</button>
									</div>
								</div>
							</div>
						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
									<?php echo $total_panier;?>
								</span>
							</div>
						</div>

						<button type="submit" name="valid_panier"
						class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Proceed to Checkout
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
		
	
		

	<!-- Footer -->


<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<?php
include_once 'includes/footer.php';
}
?>
</body>
</html>