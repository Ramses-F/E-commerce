<?php
session_start();
include "config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["submit"])) {
    $nom = $_POST['nom'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $contact = $_POST['contact'];
    $question = $_POST['question'];
    $reponse = $_POST['reponse'];
    $localisation = $_POST['user_localisation'];

    var_dump($_POST);

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
  } elseif (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!empty($email) && !empty($password)) {
      $requete = $db->prepare("SELECT * FROM tb_users where email = :email AND user_mdp = :password_");
      $requete->bindParam(":email", $email, PDO::PARAM_STR);
      $requete->bindParam(":password_", $password, PDO::PARAM_STR);
      $requete->execute();
      $requete_resultats = $requete->fetchAll(PDO::FETCH_OBJ);

      if ($requete->rowCount() > 0) {
        foreach ($requete_resultats as $requete_resultats) {
          $idd = $requete_resultats->id_user;
          $_SESSION["id_user"] = $idd;
          $_SESSION["email_user"] = $email;
          header('Location: index.php'); // Redirige l'utilisateur vers la page d'accueil
          exit;
        }
      }
      echo "<p style='color: red;font-size: 1rem;text-align: center;'>Veuillez entrer les bonnes informations.</p>";
    } else {
      echo "<p style='color: red;font-size: 1rem;text-align: center;'>Veuillez remplir tous les champs.</p>";
    }
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
      <li class="bat active">
        <a href="addaccount.php" style="border-radius: 15px!important;margin-right:8px;">Sign Up</a>
      </li>
      <li class="bat"><a href="login.php" style="border-radius: 15px!important;margin-left:8px;">Log In</a></li>
    </ul>
    <div class="bat-content">

      <!--Mot de passe oublié-->
        <div id="forget">
            <h1 style="color:black">Retrouvez votre mot de passe</h1>
            <form action="" method="post">
                <div class="field-wrap">
                  <input type="text" name="quest" style="color:black" required placeholder="Enter your question" />
                </div>
                <div class="field-wrap">
                  <input type="test" name="answer" style="color:black" required placeholder="Enter your answer" />
                </div>
                <button class="button button-block" />Answer</button>
            </form>
        </div>
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