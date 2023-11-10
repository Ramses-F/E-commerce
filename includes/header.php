<!-- Header -->
<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar" style="background:transparent">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="right-top-bar flex-w h-full">
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->
					<a href="#" class="logo">
						<button class="p-3 mx-4" style="border: none; font-size:1.3em;font-weight:bolder;"
						data-bs-toggle="offcanvas" data-bs-target="#menu">
						Menu
						</button>
						<img src="images/icons/logo-01.png" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop offcanvas-->
					<div class="offcanvas offcanvas-start" id="menu">
						<div class="offcanvas-header">
    						<h1 class="offcanvas-title">Menu</h1>
    						<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    					</div>
						<hr>
						<div class="menu-desktop offcanvas-body">
							<ul class="main-menu flex-wrap flex-column justify-items-justify">
								<li class="active-menu">
									<a href="index.php">Home</a>
								</li>
								<li>
									<a href="product.php">Shop</a>
								</li>
								<li class="label1" data-label1="hot">
									<a href="shoping-cart.php">Features</a>
								</li>
								<li class="dropdown">
									<a href="" class="dropdown-toggle" data-bs-toggle="dropdown">Category</a>
									<ul class="dropdown-menu">
										<li><a href="product.php?prod=all" id="all" class="dropdown-item">All</a></li>
										<li><a href="product.php?prod=men" id="men" class="dropdown-item">Mens</a></li>
										<li><a href="product.php?prod=women" id="women" class="dropdown-item">Womens</a></li>
										<li><a href="product.php?prod=kids" id="kids" class="dropdown-item">Kids</a></li>
										<li><a href="product.php?prod=access" id="access" class="dropdown-item">Accessories</a></li>
									</ul>
								</li>
								<li>
									<a href="about.php">About</a>
								</li>
								<li>
									<a href="contact.php">Contact</a>
								</li>
							</ul>
						</div>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<?php
						    if (isset($_SESSION['id_user'])) {
						?>
						<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11"
						data-bs-toggle="modal" data-bs-target="#modall">
							<i class="zmdi zmdi-account"></i>
						</a>
						<?php
							}else{
						?>
						<a href="login.php" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
							<i class="zmdi zmdi-account-add"></i>
						</a>
						<?php
							}
						?>

						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<div class="icon-header-item cl2 hov-cl 1 trans-04 p-l-22 p-r-11 icon-header-noti">
							<a href="shoping-cart.php" style="text-decoration: none; color: cl2"><i class="zmdi zmdi-shopping-cart"></i></a>
						</div>
					</div>
				</nav>
			</div>
		</div>

		<!-- Modal -->
			<div class="modal fade" id="modall" style="padding-top:80px">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
	  				<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>
						<!--Modal body-->
						<div class="modal-body">`
								<div id="account">
									<div class="col-md-11 bg-white rounded-2 d-flex flex-column">
										<div class="proprio-infos d-flex row">
											<div class="col-md-6 justify-content-center">
												<div class="col-3 d-flex align-items-center justify-content-center">

													<div class="imggg d-flex align-items-center justify-content-center" style="height: 150px;width: auto;">
														<img src="images/avatar-01.jpg ?>" alt=""
														style="height: 100%;" class="rounded-2">
													</div>
												</div>
												<div class="public">
													<p class="proprio-type d-flex justify-content-start rounded-2 mb-4"
														style="color:#000; font-weight:bolder; font-size: 1.5em;"> BBB I AM
													</p>
													<p class="location">
														<i class="fa-solid fa-location-dot"></i>
														<span>&nbsp;&nbsp; <br> Abidjan, Côte
															d'Ivoire</span>
													</p>
													<p class="nb-ads"> 280 Achats
													</p>
													<p class="member-since">Membre depuis le
														<span>27/02/2021
														</span>
													</p>
												</div>
											</div>
											<div class="col-md-6 d-flex flex-column justify-content-start">
												<div class="apropos">
													<h5 style="font-weight:bolder; text-decoration:underline;">Informations du compte</h5>
												</div>
												<form action="" method="post">
												<div class="desboutons row py-3">
													<?php
														if (isset($_POST['subnew'])){
															$nom = $_POST["nom"];
															$email = $_POST["mail"];
															$num = $_POST["num"];
															$address = $_POST["adress"];

															$modinfos = $db->prepare("UPDATE tb_users SET name_user = :nom, contact = :num, email = :mail, default_address = :adress WHERE id_user = :id");
                                    						$modinfos->bindParam(":nom", $nom, PDO::PARAM_STR);
                                    						$modinfos->bindParam(":num", $num, PDO::PARAM_STR);
                                    						$modinfos->bindParam(":mail", $email, PDO::PARAM_STR);
                                    						$modinfos->bindParam(":adress", $address, PDO::PARAM_STR);
                                    						$modinfos->bindParam(":id", $id_user, PDO::PARAM_INT);
                                    						$modinfos->execute();
														}

														$getInfosClient = $db->prepare("SELECT * FROM tb_users  WHERE id_user= :id ");
														  $getInfosClient->bindParam(":id", $id_user, PDO::PARAM_INT);
														
														  if ($getInfosClient->execute()) {
															$getInfosClient_resultats = $getInfosClient->fetchAll(PDO::FETCH_OBJ);
															if ($getInfosClient->rowCount() > 0) {
															  foreach ($getInfosClient_resultats as $getInfosClient_resultats) {
																$nom_user = $getInfosClient_resultats->name_user;
																$email = $getInfosClient_resultats->email;
																$def_add = $getInfosClient_resultats->default_address;
																$contact = $getInfosClient_resultats->contact;
															  }
															}
														  }
													?>
													<div class="col mx-1">
														<label for="" style="font-weight: bolder;">Email :</label>
														<input type="text" name="mail" id="" value="<?php echo $email?>"
														style="border: none; border-bottom:2px solid gold">
														<label for="" class="pt-3" style="font-weight: bolder;">Nom :</label>
														<input type="text" name="nom" id="" value="<?php echo $nom_user?>"
														style="border: none; border-bottom:2px solid gold">
														<label for="" class="pt-3" style="font-weight: bolder;">Password :</label><br>
														<button onclick="window.location.href='changemdp.php'"
														style="border: none; border:2px solid gold"> Change the password </button><br>
														<label for="" class="pt-3" style="font-weight: bolder;">Address :</label>
														<input type="text" name="adress" id="" value="<?php echo $def_add?>"
														style="border: none; border-bottom:2px solid gold">
													</div>
													<div class="col">
														<label for="" style="font-weight: bolder;">Number :</label>
														<input type="text" name="num" id="" value="<?php echo $contact?>"
														style="border: none; border-bottom:2px solid gold">
													</div>
												</div>
												<button type="submit" name="subnew"
												class="btn btn-success d-flex align-item-center justify-content-end">Save changes</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div id="buying">
									<h3 class="my-4" style="font-weight:bolder; text-decoration:underline;">Liste de mes achats</h3>
									<table class="table" style="border:1px; width:100%">
                            			<thead>
                            			  <tr style="color:orange">
                            			    <th style="font-size: 1.2rem;">Nom article</th>
                            			    <th style="font-size: 1.2rem;">Catégorie</th>
                            			    <th style="font-size: 1.2rem;">Prix unitaire</th>
                            			    <th style="font-size: 1.2rem;">Quantité commandée</th>
                            			    <th style="font-size: 1.2rem;">Statut achat</th>
                            			  </tr>
                            			</thead>
                            			<tbody>
                            			    <tr style="font-weight:bold; font-size: 1.1rem;">
                            			        <td colspan="5">
													<center>
														Date des achats : <span> 18/09/2023 </span> 
													</center>
												</td>
                            			    </tr>
                            			    <tr style="color:#000; font-size:1rem; font-weight:bold;">
                            			        <td>T-shirts elephants</td>
                            			        <td>T-shirts</td>
                            			        <td>12000 FCFA</td>
                            			        <td>3</td>
                            			        <td>Livré</td>
                            			    </tr>
                            			    <tr style="color:#000; font-size:1rem; font-weight:bold;">
                            			        <td>T-shirts elephants</td>
                            			        <td>T-shirts</td>
                            			        <td>12000 FCFA</td>
                            			        <td>3</td>
                            			        <td>Livré</td>
                            			    </tr>
                            			    <tr style="color:#000; font-size:1rem; font-weight:bold;">
                            			        <td>T-shirts elephants</td>
                            			        <td>T-shirts</td>
                            			        <td>12000 FCFA</td>
                            			        <td>3</td>
                            			        <td>Livré</td>
                            			    </tr>
                            			</tbody>
									</table>
								</div>

						</div>
						<!--Modal footer-->
						<div class="modal-footer">
							<button type="button" href="#account" class="btn btn-primary tab active">Mon compte</button>
		  					<a style="margin:3px; background-color:red; text-decoration:none; color:#fff" href="logout.php">Disconnect</a>
						</div>
	  				</div>
					</form>
				</div>
  			</div>
			<!--End modal-->

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
				<a href="index.php"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11">
					<i class="zmdi zmdi-account"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="login.php" class="flex-c-m p-lr-10 trans-04">
							Login
						</a>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.php" style="text-decoration: none;">Home</a>
				</li>

				<li>
					<a href="product.php">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="product.php">Category</a>
					<ul class="sub-menu-m">
						<li><a href="#">Mens</a></li>
						<li><a href="#">Womens</a></li>
						<li><a href="#">Kids</a></li>
						<li><a href="#">Accessories</a></li>
						<li><a href="#">Pins</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>
				<li>
					<a href="about.php">About</a>
				</li>

				<li>
					<a href="contact.php">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15" action="resultsearch.php" method="get">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart" hidden>
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="images/item-cart-01.jpg" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								White Shirt Pleat
							</a>

							<span class="header-cart-item-info">
								1 x $19.00
							</span>
						</div>
					</li>

					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="images/item-cart-02.jpg" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								Converse All Star
							</a>

							<span class="header-cart-item-info">
								1 x $39.00
							</span>
						</div>
					</li>

					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="images/item-cart-03.jpg" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								Nixon Porter Leather
							</a>

							<span class="header-cart-item-info">
								1 x $17.00
							</span>
						</div>
					</li>
				</ul>
				
				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						Total: $75.00
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="shoping-cart.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="shoping-cart.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Check Out
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

		

	<!-- Slider -->
	<section class="section-slide" id="blur">
		<div class="wrap-slick1">
			<div class="slick1">
				<div class="item-slick1" style="background-image: url(images/can.jpg);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Célébrons ensemble
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									la can
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(images/abidjan.jpg);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-101 cl2 respon2" style="color:#fff">
									Repartez avec des souvenirs
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1" style="color:#fff">
									d'Abidjan
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
								<a href="product.php?prod=access"
								class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04"
								style="color:#fff">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(images/shirts.png);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Des maillots 2023
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									originaux !
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>
