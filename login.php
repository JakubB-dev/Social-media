<?php
    include_once("ifLogged.php");
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Logowanie
        </title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <header>
            <h1>
                <a href="index.php">
                    Home
                </a><hr>
                <a href="login.php">
                    Login
                </a><hr>
                <a href="register.php">
                    Register
                </a><hr>
            </h1>
        </header>
        <content>
            <section class="login-box">
                <h2>
                    Zaloguj się
                </h2>
                <form action="#" method="POST">
                    <label>
                        Login:<br>
                        <input type="text" name="login" required>
                    </label><br>
                    <label>
                        Hasło:<br>
                        <input type="password" name="pass" required>
                    </label><br>
                    <?php
                        if(isset($_POST["login"]) && isset($_POST["pass"])){
                            require_once("conn.php");
                            $login = $_POST["login"];
                            $pass = $_POST["pass"];
                            $hash = sha1($pass);

                            $query = "SELECT login, hash FROM accounts WHERE login = '$login' AND hash = '$hash'";

                            $result = mysqli_num_rows(mysqli_query($conn, $query));

                            if($result == 1){
                                $_SESSION['logged'] = true;
                                include_once("userData.php");
                                header("Location: home.php");
                            } else{
                                echo "<p class='error'>Spróbuj ponownie</p>";
                            }
                        }
                    ?><br>
                    <button type="submit">
                        Zaloguj
                    </button>
                </form>
            </section>
        </content>
    </body>
</html>