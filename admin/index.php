<?php
session_start();
if (1) {
}
if (isset($_SESSION['id_admin'])) {
    header('location:dashboard.php');
}else {
    include '../config/db.php';

?>  

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SMALLMARKET - ADMIN</title>
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <style>
        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        a {
            text-decoration: none;
        }

        .header {
            position: fixed;
            height: 80px;
            width: 100%;
            z-index: 100;
            padding: 0 20px;
        }

        .nav {
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        .nav,
        .nav_item {
            display: flex;
            height: 100%;
            align-items: center;
            justify-content: space-between;
        }

        .nav_logo,
        .nav_link,
        .button {
            color: #fff;
        }

        .nav_logo {
            font-size: 25px;
        }

        .nav_item {
            column-gap: 25px;
        }

        .nav_link:hover {
            color: #d9d9d9;
        }

        .button {
            padding: 6px 24px;
            border: 2px solid #fff;
            background: transparent;
            border-radius: 6px;
            cursor: pointer;
        }

        .button:active {
            transform: scale(0.98);
        }

        /* Home */
        .home {
            position: relative;
            height: 100vh;
            width: 100%;
            background-image: url("assets/images/img_1.jpeg");
            background-size: cover;
            background-position: center;
        }

        .home::before {
            content: "";
            position: absolute;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: all 0.5s ease-out;
        }

        .home.show::before {
            opacity: 1;
            pointer-events: auto;
        }

        /* From */
        .form_container {
            position: fixed;
            max-width: 320px;
            width: 100%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1.2);
            z-index: 101;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: rgba(0, 0, 0, 0.1);
            opacity: 0;
            pointer-events: none;
            transition: all 0.4s ease-out;
        }

        .home.show .form_container {
            opacity: 1;
            pointer-events: auto;
            transform: translate(-50%, -50%) scale(1);
        }

        .signup_form {
            display: none;
        }

        .form_container.active .signup_form {
            display: block;
        }

        .form_container.active .login_form {
            display: none;
        }

        .form_close {
            position: absolute;
            top: 10px;
            right: 20px;
            color: #0b0217;
            font-size: 22px;
            opacity: 0.7;
            cursor: pointer;
        }

        .form_container h2 {
            font-size: 22px;
            color: #0b0217;
            text-align: center;
        }

        .input_box {
            position: relative;
            margin-top: 30px;
            width: 100%;
            height: 40px;
        }

        .input_box input {
            height: 100%;
            width: 100%;
            border: none;
            outline: none;
            padding: 0 30px;
            color: #333;
            transition: all 0.2s ease;
            border-bottom: 1.5px solid #aaaaaa;
        }

        .input_box input:focus {
            border-color: #7d2ae8;
        }

        .input_box i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #707070;
        }

        .input_box i.email,
        .input_box i.password {
            left: 0;
        }

        .input_box input:focus~i.email,
        .input_box input:focus~i.password {
            color: #7d2ae8;
        }

        .input_box i.pw_hide {
            right: 0;
            font-size: 18px;
            cursor: pointer;
        }

        .option_field {
            margin-top: 14px;
            display: flex;
            flex-flow: column;
            /* align-items: center;
            justify-content: space-between; */
        }

        .form_container a {
            color: #7d2ae8;
            font-size: 12px;
            text-align: end;
            margin-top: 15px;
        }

        .form_container a:hover {
            text-decoration: underline;
        }

        .checkbox {
            display: flex;
            column-gap: 8px;
            white-space: nowrap;
        }

        .checkbox input {
            accent-color: #7d2ae8;
        }

        .checkbox label {
            font-size: 12px;
            cursor: pointer;
            user-select: none;
            color: #0b0217;
        }

        .form_container .button {
            background: #7d2ae8;
            margin-top: 30px;
            width: 100%;
            padding: 10px 0;
            border-radius: 10px;
        }

        .login_signup {
            font-size: 12px;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header" hidden>
        <nav class="nav">
            <a href="#" class="nav_logo">SMALLMARKET</a>

            <ul class="nav_items">
                <li class="nav_item">
                    <a href="#" class="nav_link">Home</a>
                    <a href="#" class="nav_link">Product</a>
                    <a href="#" class="nav_link">Services</a>
                    <a href="#" class="nav_link">Contact</a>
                </li>
            </ul>

            <button class="button" id="form-open">Connexion</button>
        </nav>
    </header>

    <!-- Home -->
    <section class="home show">
        <div class="form_container">
            <i class="uil uil-times form_close" hidden></i>
            <!-- Login From -->
            <div class="form login_form">
                <form method="post">
                    <h2>Connexion</h2>
                    <?php
                    if (isset($_POST["submit"])) {


                        $email = $_POST["email"];
                        $password = $_POST["password"];

                        if (!empty($email) && !empty($password)) {

                            $requete = $db->prepare("SELECT * FROM tb_admin WHERE email = :email AND admin_mdp = :password_");
                            $requete->bindParam(":email", $email, PDO::PARAM_STR);
                            $requete->bindParam(":password_", $password, PDO::PARAM_STR);
                            $requete->execute();
                            $requete_resultats = $requete->fetchAll(PDO::FETCH_OBJ);
                            if ($requete->rowCount() > 0) {
                                foreach ($requete_resultats as $requete_resultats) {

                                    $idd  = $requete_resultats->id_admin;
                                    $_SESSION["id_admin"] = $idd;
                                    $_SESSION["su_admin"] =  $requete_resultats->su_admin;
                                    $_SESSION["email_admin"] = $email;

                                   // header('location:dashboard.php');
                                   echo "<script>window.location.href='dashboard.php'</script>";
                                }
                            } else {
                                echo ("<p style='color: red;font-size: 1rem;text-align: center;'>Veuillez entrer les bonnes informations.</p>");
                            }
                            // echo ("<p style='color:red;'>Veuillez rééssayer.</p>");
                        } else echo ("<p style='color: red;font-size: 1rem;text-align: center;'>Veuillez remplir tous les champs.</p>");
                    }
                    ?>
                    <div class="input_box">
                        <input type="email" name="email" placeholder="Entrer votre email" required />
                        <i class="uil uil-envelope-alt email"></i>
                    </div>

                    <div class="input_box">
                        <input type="password" name="password" placeholder="Entrer votre mot de passe" required />
                        <i class="uil uil-lock password"></i>
                        <i class="uil uil-eye-slash pw_hide"></i>
                    </div>

                    <div class="option_field">
                        <span class="checkbox">
                            <input type="checkbox" id="check">
                            <label for="check">Se souvenir de moi</label>
                        </span>
                        <a href="#" class="forgot_pw text-right">Mot de passe oublié ?</a>
                    </div>

                    <button class="button" type="submit" name="submit">Se connecter</button>

                </form>
            </div>

        </div>
    </section>

    <script>
        const formOpenBtn = document.querySelector("#form-open"),
            home = document.querySelector(".home"),
            formContainer = document.querySelector(".form_container"),
            formCloseBtn = document.querySelector(".form_close"),
            /*             signupBtn = document.querySelector("#signup"),
                        loginBtn = document.querySelector("#login"), */
            pwShowHide = document.querySelectorAll(".pw_hide");

        formOpenBtn.addEventListener("click", () => home.classList.add("show"));
        formCloseBtn.addEventListener("click", () => home.classList.remove("show"));

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

        /*  signupBtn.addEventListener("click", (e) => {
             e.preventDefault();
             formContainer.classList.add("active");
         });
         loginBtn.addEventListener("click", (e) => {
             e.preventDefault();
             formContainer.classList.remove("active");
         }); */
    </script>
</body>

</html>

<?php
}

?>
