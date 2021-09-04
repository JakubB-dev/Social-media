<?php
    require_once('conn.php');
    include_once("ifNotLogged.php");
    include_once("errors.php");

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
                Edytowanie danych
            </h1><hr>
            <form action="#" method="POST">
                <label>
                    <h2>
                        Nazwa:<br>
                        <input type="text" name="name" value="<?php echo $_SESSION['userData']['name'] ?>">
                    </h2>
                </label>
                <label>
                    <h2>
                        Login:<br>
                        <input type="text" name="login" value="<?php echo $_SESSION['userData']['login'] ?>">
                    </h2>
                </label>
                <label>
                    <h2>
                        E-mail:<br>
                    </h2>
                    <input type="text" name="mail" value="<?php echo $_SESSION['userData']['mail'] ?>">
                </label><br><br>
                <button type="submit">
                    Edytuj
                </button>
            </form><br><hr>
            <form action="#" method="POST">
                <label>
                    <h2>
                        Stare hasło:<br>
                        <input type="password" name="old">
                    </h2>
                    <h2>
                        Nowe hasło:<br>
                        <input type="password" name="new">
                    </h2>
                </label>
                <button type="submit">
                    Zmień hasło
                </button>
            </form><br>
            <?php
                if(isset($_POST['login']) && isset($_POST['name']) && isset($_POST['mail'])){
                    $login = $_POST['login'];
                    $name = $_POST['name'];
                    $mail = $_POST['mail'];

                    $query = "UPDATE accounts SET updated_at = current_timestamp(), login = '$login', name = '$name', mail = '$mail' WHERE id = ".$_SESSION['userData']['id'];
                    $result = mysqli_query($conn, $query);
                    if($result == false){
                        echo "<hr><br><p class='error'>$errors[13]</p>";
                    } else{
                        $query = "SELECT accounts.id, login, name, mail, created_at, nameAvatar FROM accounts, avatars WHERE login = '$login' AND accounts.avatar = avatars.id";
                        $_SESSION['userData'] = mysqli_fetch_assoc(mysqli_query($conn, $query));
                        header("Location: editAccount.php");
                    }
                } else if(isset($_POST['old']) && isset($_POST['new']) && !empty($_POST['old'])){
                    $old = $_POST['old'];
                    $new = $_POST['new'];
                    $hashOld = sha1($old);
                    $hashNew = sha1($new);

                    $queryCheck = "SELECT COUNT(*) FROM accounts WHERE hash = '$hashOld' AND id = ".$_SESSION['userData']['id'];
                    $check = mysqli_fetch_array(mysqli_query($conn, $queryCheck))[0];

                    if($check == 0){
                        echo "<hr><br><p class='error'>$errors[11]</p>";
                    } else if($old == $new){
                        echo "<hr><br><p class='error'>$errors[10]</p>";
                    } else if(strlen($new) < 8){
                        echo "<hr><br><p class='error'>$errors[12]</p>";
                    } else{
                        $queryUpdatePass = "UPDATE accounts SET updated_at = current_timestamp(), hash = '$hashNew' WHERE id = ".$_SESSION['userData']['id'];
                        $resultUpdatePass = mysqli_query($conn, $queryUpdatePass);
                        
                        if($resultUpdatePass == true){
                            echo "<hr><br><p class='success'>Pomyślnie zmieniono hasło</p>";
                        } else{
                            echo "<hr><br><p class='error'>$errors[13]</p>";
                        }
                    }
                }
            ?><br><hr>
            <h1>
                Zmień avatar
            </h1><hr>
            <h2>
                Obecny avatar:
            </h2>
            <a href="/back/foto/<?php echo $_SESSION['userData']['nameAvatar']; ?>">
                <img src="/back/foto/<?php echo $_SESSION['userData']['nameAvatar']; ?>" alt="avatar" class="avatar"><br>
                <small>
                    Kliknij, aby powiększyć
                </small>
            </a>
            <form method="POST" action="saveAvatar.php" enctype="multipart/form-data">
                <label>
                    <h2>
                        Zdjęcie:
                    </h2>
                    <input type="file" name="avatar">
                </label><br><br>
                <button type="submit">
                    Ustaw
                </button>
            </form><hr>
        </content>
    </body>
</html>