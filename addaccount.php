<?php
session_start();
include "config/db.php";
if(1){
}

if (isset($_POST["submit"])) {

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $conmdp = $_POST['conmdp'];
    $contact = $_POST['contact'];
    $question = $_POST['question'];
    $reponse = $_POST['reponse'];
    $localisation = $_POST['user_localisation'];
    $date_insc = $_POST['date_insc'];

    //var_dump($_POST);

    if (!empty($nom) && !empty($email) && !empty($mdp) && !empty($contact) &&
    !empty($question) && !empty($reponse) && !empty($localisation)) {

    // Vous pouvez ajouter des validations et des vérifications de sécurité ici
    // Vérification de la conformité du mot de passe (par exemple, 8 caractères minimum)
    if (strlen($mdp) < 8) {
    echo "Le mot de passe doit comporter au moins 8 caractères.";
    exit; // Arrête le script si le mot de passe n'est pas conforme
    }
    // Vérification que les mots de passe correspondent
    if ($mdp !== $conmdp) {
        echo "Les mots de passe ne correspondent pas.";
        exit; // Arrête le script si les mots de passe ne correspondent pas
    }


    // Hachage du mot de passe
    $mdpHache = password_hash($mdp, PASSWORD_DEFAULT);
    $date_insc = date('y-m-d');

      // Utilisation de requête préparée pour éviter les injections SQL
      $adduser = $db->prepare("INSERT INTO tb_users(name_user, email, contact, default_address, user_mdp, question, reponse, date_insc)
      VALUES (:nom, :email , :contact  , :user_localisation, :mdp, :question, :reponse, :date_insc)");
      $adduser->bindParam(':nom', $nom, PDO::PARAM_STR);
      $adduser->bindParam(':email', $email, PDO::PARAM_STR);
      $adduser->bindParam(':contact', $contact, PDO::PARAM_STR);
      $adduser->bindParam(':user_localisation', $localisation, PDO::PARAM_STR);
      $adduser->bindParam(':mdp', $mdpHache, PDO::PARAM_STR);
      $adduser->bindParam(':question', $question, PDO::PARAM_STR);
      $adduser->bindParam(':reponse', $reponse, PDO::PARAM_STR);
      $adduser->bindParam(':date_insc', $date_insc, PDO::PARAM_STR);

      if ($adduser->execute()) {
        // L'insertion s'est bien déroulée
        $_SESSION["id_user"] = $db->lastInsertId();
        $_SESSION["email_user"] = $email;
        header('Location: index.php'); // Redirige l'utilisateur vers la page d'accueil
        exit;
      } else {
        // Erreur lors de l'insertion
        echo "Erreur lors de l'inscription.";
      }
    } else {
      // Champs manquants
      echo "Tous les champs doivent être remplis.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/stylelog.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
</head>
<body>
  <div class="form">
    <ul class="bat-group">
      <li class="bat">
        <a href="addaccount.php" style="border-radius: 15px!important;margin-right:8px;">Sign Up</a>
      </li>
      <li class="bat"><a href="login.php" style="border-radius: 15px!important;margin-left:8px;">Log In</a></li>
    </ul>
    <div class="bat-content">

      <!--Register a user-->
      <div id="signup">
        <h1 style="color:black">Inscription</h1>
        <form action="" id="form_add_user" method="post">
            <div class="field-wrap">
              <input type="text" name="nom" required style="color:black" placeholder="First Name" />
            </div>
            <div class="field-wrap">
              <input type="text" name="question" required style="color:black" placeholder="Question secrète" />
            </div>
            <div class="field-wrap">
              <input type="text" name="reponse" required style="color:black" placeholder="Reponse à la question" />
            </div>
            <div class="field-wrap">
              <input type="text" name="contact" required style="color:black" placeholder="Contact"/>
            </div>
            <div class="field-wrap">
              <input type="text" name="email" required style="color:black" placeholder="Email Address"/>
            </div>
            <div class="field-wrap">
              <input type="text" name="user_localisation" required style="color:black" placeholder="Address"/>
            </div>
            <div class="field-wrap">
              <input type="password" name="mdp" required style="color:black" placeholder="Password" />
              <i class="uil uil-eye-slash pw_hide"></i>
            </div>
            <div class="field-wrap">
              <input type="password" name="conmdp" required style="color:black" placeholder="Confirm password" />
              <i class="uil uil-eye-slash pw_hide"></i>
            </div>
            <button type="submit" class="button button-block" name="submit" />Sign Up</button>
        </form>
      </div>
      <!--Fin register part-->
      
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/log.js"></script>
  <script>
    const pwShowHide = document.querySelectorAll(".pw_hide");
            pwShowHide.forEach((icon) => {
            icon.addEventListener("click", () => {
                let getPwInput = icon.parentElement.querySelector("input");
                if (getPwInput.type === "password") {
                    getPwInput.type = "text";
                    icon.classList.replace("uil-eye-slash", "uil-eye");
                } else {
                    getPwInput.type = "password";
                    icon.classList.replace("uil-eye", "uil-eye-slash");
                }
            });
        });


        /*const form = document.querySelector("#form_add_user");

    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const fd = new FormData(form);

      fetch('admin/ajax/add_user.php', {
          method: "POST",
          body: fd,
        })
        .then((response) => response.text())
        .then((resultats) => {
          console.log(resultats);

          if (resultats == 0) {
            console.log("succès 1");
             } else {
                  alert('Une erreur est survenue lors de l\'enregistrement ');
                }
              })
          })*/

  </script>
</body>
</html>