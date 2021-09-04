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
            Rejestracja
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
                    Zarejestruj się
                </h2>
                <form action="#" method="POST">
                    <label>
                        Nazwa:<br>
                        <input type="text" name="name" required>
                    </label><br>
                    <label>
                        Login:<br>
                        <input type="text" name="login" required>
                    </label><br>
                    <label>
                        E-mail:<br>
                        <input type="text" name="mail">
                    </label><br>
                    <label>
                        Hasło:<br>
                        <input type="password" name="pass1" required>
                    </label><br>
                    <label>
                        Powtórz hasło:<br>
                        <input type="password" name="pass2" required>
                    </label><br><br>
                    <button type="submit">
                        Zarejestruj
                    </button>
                </form><br>
            </section>
            <section class="rules">
                <h2>
                    Zasady rejestracji:
                </h2>
                Login powinien mieć co najmniej 6 znaków,<br>
                a nazwa oraz hasło 8
            </section>
                <?php
                    $_SESSION['errors'] = 0;

                    if(isset($_POST["name"]) && isset($_POST["login"]) && isset($_POST["pass1"]) && isset($_POST["pass2"]) && isset($_POST["mail"])){
                        require_once("conn.php");
                        $name = $_POST["name"];
                        $login = $_POST["login"];
                        $pass1 = $_POST["pass1"];
                        $pass2 = $_POST["pass2"];
                        $hash = sha1($pass1);
                        if(empty($_POST["mail"])){
                            $mail = null;
                        } else{
                            $mail = $_POST["mail"];
                        }

                        $result0 = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM accounts WHERE name = '$name'"));
                        $result1 = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM accounts WHERE login = '$login'"));
                        $result2 = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM accounts WHERE mail = '$mail'"));
                        $result = [$result0, $result1, $result2];

                        include_once("errors.php");

                        for($i = 0; $i < 3; $i++){
                            if($result[$i] == 1){
                                echo "
                                <p class='error'>
                                    $errors[$i]
                                </p>
                                ";
                                $_SESSION['errors']++;
                            }
                        }
                        
                        if($pass1 != $pass2){
                            echo "
                            <p class='error'>
                                $errors[5]
                            </p>
                            ";
                            $_SESSION['errors']++;
                        }

                        if(!filter_var($mail, FILTER_VALIDATE_EMAIL) && $mail != ""){
                            echo "
                            <p class='error'>
                                $errors[3]
                            </p>
                            ";
                            $_SESSION['errors']++;
                        }

                        if($_SESSION['errors'] == 0){
                            $_SESSION['errors'] = 0;
                            if($mail == ""){
                                $queryInsert = "INSERT INTO accounts SET name = '$name', login = '$login', hash = '$hash'";
                                mysqli_query($conn, $queryInsert);
                            } else{
                                $queryInsert = "INSERT INTO accounts SET name = '$name', login = '$login', hash = '$hash', mail = '$mail'";
                                mysqli_query($conn, $queryInsert);
                            }
                            echo "
                            <p class='success'>
                                Udana rejestracja
                            </p>
                            <p>
                                Za chwilę zostaniesz przeniesiony na stronę logowania
                            </p>";
                            header("Refresh:3; url=login.php");
                        }
                    }
                ?>
        </content> 
    </body>
</html>