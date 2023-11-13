<?php
session_start();
include "config/db.php";

if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $password = $_POST["mdp"];

  if (!empty($email) && !empty($password)) {
      $requete = $db->prepare("SELECT * FROM tb_users where email = :email");
      $requete->bindParam(":email", $email, PDO::PARAM_STR);
      $requete->execute();
      $requete_resultats = $requete->fetchAll(PDO::FETCH_OBJ);

      if ($requete->rowCount() > 0) {
          // L'utilisateur avec cet e-mail existe, vérifions le mot de passe haché
          $user = $requete_resultats[0]; // Supposons que le résultat est unique

          $hashed_password = $user->user_mdp;

          if (password_verify($password, $hashed_password)) {
              // Mot de passe correct
              $idd = $user->id_user;
              $_SESSION["id_user"] = $idd;
              $_SESSION["email"] = $email;
              header('Location: dashboard.php'); // Redirige l'utilisateur vers la page d'accueil
              exit;
          } else {
              echo "<p style='color: red;font-size: 1rem;text-align: center;'>Mot de passe incorrect.</p>";
          }
      } else {
          echo "<p style='color: red;font-size: 1rem;text-align: center;'>Utilisateur non trouvé.</p>";
      }
  } else {
      echo "<p style='color: red;font-size: 1rem;text-align: center;'>Veuillez remplir tous les champs.</p>";
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
      <li class="bat">
        <a href="login.php" style="border-radius: 15px!important;margin-left:8px;">Log In</a>
      </li>
    </ul>
    <div class="bat-content">
      <!--Log in de l'user-->
        <h1 style="color:black">Connectez-vous !</h1>
        <form action="" method="post">
          <div class="field-wrap">
            <input type="email" name="email" style="color:black" required placeholder="Email" />
          </div>
          <div class="field-wrap">
            <input type="password" name="mdp" style="color:black" required placeholder="Password" />
            <i class="uil uil-eye-slash pw_hide"></i>
          </div>
          <p class="forgot bat-group bat"><a href="forgetmdp.php">Forgot Password?</a></p>
          <button class="button button-block" name="submit">Login</button>
        </form>
      <!--Fin login-->

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