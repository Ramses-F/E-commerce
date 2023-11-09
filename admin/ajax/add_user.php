<?php
session_start();
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom = $_POST['nom'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $mdp = $_POST['mdp'];
  $contact = $_POST['contact'];
  $question = $_POST['question'];
  $reponse = $_POST['reponse'];
  $localisation = $_POST['user_localisation'];

  if (!empty($nom) && !empty($lname) && !empty($email) && !empty($mdp) && !empty($contact) && 
  !empty($question) && !empty($reponse) && !empty($localisation)) {

    // Vous pouvez ajouter des validations et des vérifications de sécurité ici

    // Utilisation de requête préparée pour éviter les injections SQL
    $adduser = $db->prepare("INSERT INTO tb_users(name_user, lname, email, contact_user, default_address, user_mdp, question, reponse)
    VALUES (:nom, :lname, :email , :contact  , :user_localisation, :mdp, :question, :reponse)");
    $adduser->bindParam(':nom', $nom, PDO::PARAM_STR);
    $adduser->bindParam(':lname', $lname, PDO::PARAM_STR);
    $adduser->bindParam(':email', $email, PDO::PARAM_STR);
    $adduser->bindParam(':contact', $contact, PDO::PARAM_STR);
    $adduser->bindParam(':user_localisation', $localisation, PDO::PARAM_STR);
    $adduser->bindParam(':mdp', $mdp, PDO::PARAM_STR);
    $adduser->bindParam(':question', $question, PDO::PARAM_STR);
    $adduser->bindParam(':reponse', $reponse, PDO::PARAM_STR);

    if ($adduser->execute()) {
      // L'insertion s'est bien déroulée
      echo "0";
    } else {
      // Erreur lors de l'insertion
      echo "Erreur lors de l'inscription.";
    }
  } else {
    // Champs manquants
    echo "Tous les champs doivent être remplis.";
  }
} else {
  // Requête incorrecte
  echo "Requête incorrecte.";
}
?>
