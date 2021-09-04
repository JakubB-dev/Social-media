<?php
    include_once("ifNotLogged.php");

    //require_once("destroySession.php");
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Strona główna
        </title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <header>
            <form action="logout.php">
                <button type="submit">
                    <h4>
                        Wyloguj się
                    </h4>
                </button>
            </form><hr>
            <h3>
                Witaj 
                <b>
                    <?php 
                        echo $_SESSION['userData']['name']."!";
                    ?>
                </b>
            </h3>
            <a href='editAccount.php'>
                Edytuj konto
            </a><hr>
            <a href='friends.php'>
                Lista znajomych
            </a><hr>
        </header>
        <content>
            <h1>
                Wyszukaj
            </h1>
            <form action="#">
                <label>
                    Podaj nazwę:<br>
                    <input type="text" name="name">
                </label><br><br>
                <button type="submit">
                    Znajdź
                </button>
            </form><br>
            <?php
                if(isset($_GET['name']) && !empty($_GET['name'])){
                    require_once('conn.php');
                    $name = $_GET['name'];
                    $query = "SELECT name, id FROM accounts WHERE name LIKE '%$name%'";
                    $result = mysqli_query($conn, $query);
                    $i = 1;

                    while($user = mysqli_fetch_row($result)){
                        echo "
                            $i. 
                            <a href='profile.php?id=$user[1]'>
                                $user[0]
                            </a><br>
                        ";
                        $i++;
                    }
                }
            ?>
        </content>
    </body>
</html>