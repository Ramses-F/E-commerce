<?php
/**
 * Verifie si le panier existe, le crée sinon
 * @return boolean
 */
function creationPanier(){
	if (!isset($_SESSION['panier'])){
	   $_SESSION['panier']=array();
	   $_SESSION['panier']['id_prod'] = array();
	   $_SESSION['panier']['title'] = array();
	   $_SESSION['panier']['qte'] = array();
	   $_SESSION['panier']['priceProd'] = array();
	   $_SESSION['panier']['verrou'] = false;
	}
	return true;
 }
 
 
 /**
  * Ajoute un article dans le panier
  * @param string $title
  * @param int $qte
  * @param float $priceProd
  * @return void
  */
 function ajouterArticle($title,$qte,$priceProd){
 
	//Si le panier existe
	if (creationPanier() && !isVerrouille())
	{
	   //Si le produit existe déjà on ajoute seulement la quantité
	   $positionProduit = array_search($title,  $_SESSION['panier']['title']);
 
	   if ($positionProduit !== false)
	   {
		  $_SESSION['panier']['qte'][$positionProduit] += $qte ;
	   }
	   else
	   {
		  //Sinon on ajoute le produit
		  array_push( $_SESSION['panier']['title'],$title);
		  array_push( $_SESSION['panier']['qte'],$qte);
		  array_push( $_SESSION['panier']['priceProd'],$priceProd);
	   }
	}
	else
	echo "Un problème est survenu veuillez contacter l'administrateur du site.";
 }
 
 
 
 /**
  * Modifie la quantité d'un article
  * @param $title
  * @param $qte
  * @return void
  */
 function modifierQTeArticle($title,$qte){
	//Si le panier existe
	if (creationPanier() && !isVerrouille())
	{
	   //Si la quantité est positive on modifie sinon on supprime l'article
	   if ($qte > 0)
	   {
		  //Recharche du produit dans le panier
		  $positionProduit = array_search($title,  $_SESSION['panier']['title']);
 
		  if ($positionProduit !== false)
		  {
			 $_SESSION['panier']['qte'][$positionProduit] = $qte ;
		  }
	   }
	   else
	   supprimerArticle($title);
	}
	else
	echo "Un problème est survenu veuillez contacter l'administrateur du site.";
 }
 
 /**
  * Supprime un article du panier
  * @param $title
  * //@return unknown_type
  */
 function supprimerArticle($title){
	//Si le panier existe
	if (creationPanier() && !isVerrouille())
	{
	   //Nous allons passer par un panier temporaire
	   $tmp=array();
	   $tmp['id_prod'] = array();
	   $tmp['title'] = array();
	   $tmp['qte'] = array();
	   $tmp['priceProd'] = array();
	   $tmp['verrou'] = $_SESSION['panier']['verrou'];
 
	   for($i = 0; $i < count($_SESSION['panier']['id_prod']); $i++)
	   {
		  if ($_SESSION['panier']['id_prod'][$i] !== $title)
		  {
			 array_push( $tmp['id_prod'],$_SESSION['panier']['id_prod'][$i]);
			 array_push( $tmp['title'],$_SESSION['panier']['title'][$i]);
			 array_push( $tmp['qte'],$_SESSION['panier']['qte'][$i]);
			 array_push( $tmp['priceProd'],$_SESSION['panier']['priceProd'][$i]);
		  }
 
	   }
	   //On remplace le panier en session par notre panier temporaire à jour
	   $_SESSION['panier'] =  $tmp;
	   //On efface notre panier temporaire
	   unset($tmp);
	}
	else
	echo "Un problème est survenu veuillez contacter l'administrateur du site.";
 }
 
 
 /**
  * Montant total du panier
  * @return int
  */
 function MontantGlobal(){
	$total=0;
	for($i = 0; $i < count($_SESSION['panier']['title']); $i++)
	{
	   $total += $_SESSION['panier']['qte'][$i] * $_SESSION['panier']['priceProd'][$i];
	}
	return $total;
 }
 
 
 /**
  * Fonction de suppression du panier
  * @return void
  */
 function supprimePanier(){
	unset($_SESSION['panier']);
 }
 
 /**
  * Permet de savoir si le panier est verrouillé
  * @return boolean
  */
 function isVerrouille(){
	if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
	return true;
	else
	return false;
 }
 
 /**
  * Compte le nombre d'articles différents dans le panier
  * @return int
  */
 function compterArticles()
 {
	if (isset($_SESSION['panier'])){
		return count($_SESSION['panier']['title']);
	}else{
		return 0;
	}
 }
 
 
 
 
 
 $erreur = false;
 
 $action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
 if($action !== null)
 {
	if(!in_array($action,array('ajout', 'suppression', 'refresh')))
	$erreur=true;
 
	//récupération des variables en POST ou GET
	$l = (isset($_POST['l'])? $_POST['l']:  (isset($_GET['l'])? $_GET['l']:null )) ;
	$p = (isset($_POST['p'])? $_POST['p']:  (isset($_GET['p'])? $_GET['p']:null )) ;
	$q = (isset($_POST['q'])? $_POST['q']:  (isset($_GET['q'])? $_GET['q']:null )) ;
 
	//Suppression des espaces verticaux
	$l = preg_replace('#\v#', '',$l);
	//On vérifie que $p est un float
	$p = floatval($p);
 
	//On traite $q qui peut être un entier simple ou un tableau d'entiers
	 
	if (is_array($q)){
	   $QteArticle = array();
	   $i=0;
	   foreach ($q as $contenu){
		  $QteArticle[$i++] = intval($contenu);
	   }
	}
	else
	$q = intval($q);
	 
 }
 
 if (!$erreur){
	switch($action){
	   Case "ajout":
		  ajouterArticle($l,$q,$p);
		  break;
 
	   Case "suppression":
		  supprimerArticle($l);
		  break;
 
	   Case "refresh" :
		  for ($i = 0 ; $i < count($QteArticle) ; $i++)
		  {
			 modifierQTeArticle($_SESSION['panier']['title'][$i],round($QteArticle[$i]));
		  }
		  break;
 
	   Default:
		  break;
	}
 }