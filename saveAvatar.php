<?php
    session_start();
    require_once('conn.php');

    // Check that the file has been transferred
    if(is_uploaded_file($_FILES['avatar']['tmp_name'])){
        // Get the extension of file
        $ext = pathinfo($_FILES['avatar']['name'])['extension'];
        // Create file name # user name + user id + time in seconds + extension
        $_FILES['avatar']['name'] = $_SESSION['userData']['name'].$_SESSION['userData']['id'].time().".$ext";

        $nameAvatar = $_FILES['avatar']['name'];
        $avatar = $_FILES['avatar']['tmp_name'];

        // Select current avatar from DB
        $queryCheck = "SELECT avatars.id, nameAvatar FROM avatars, accounts WHERE accounts.avatar = avatars.id AND accounts.id = ".$_SESSION['userData']['id'];
        $check = mysqli_fetch_assoc(mysqli_query($conn, $queryCheck));
        // If user have avatar...
        if($check['id'] != 1){
            // Delete current avatar from server 
            unlink($_SERVER['DOCUMENT_ROOT'].'/back/foto/'.$check['nameAvatar']);
            // Add uploaded file to catalog on server
            move_uploaded_file($avatar, $_SERVER['DOCUMENT_ROOT'].'/back/foto/'.$nameAvatar);

            $queryInsert = "
            INSERT INTO avatars SET nameAvatar = '$nameAvatar'
            ";

            // Add avatar to table with avatars name
            $insertAvatar = mysqli_query($conn, $queryInsert);
            // Get id of the last inserted query
            $addedId = mysqli_insert_id($conn);
            // Update avatar id in table with accounts
            $queryUpdate = "UPDATE accounts SET avatar = $addedId WHERE id = ".$_SESSION['userData']['id'];
            $updateAvatar = mysqli_query($conn, $queryUpdate);
            // Delete current avatar from table with avatars
            $queryDelete = "DELETE FROM avatars WHERE id = ".$check['id'];
            $deleteAvatar = mysqli_query($conn, $queryDelete);
        // If user doesn't yet have avatar...
        } else{
            // Add uploaded file to catalog on server
            move_uploaded_file($avatar, $_SERVER['DOCUMENT_ROOT'].'/back/foto/'.$nameAvatar);

            $queryInsert = "
            INSERT INTO avatars SET nameAvatar = '$nameAvatar'
            ";

            // Add avatar to table with avatars name
            $insertAvatar = mysqli_query($conn, $queryInsert);
            $addedId = mysqli_insert_id($conn);
            // Update avatar id in table with accounts
            $queryUpdate = "UPDATE accounts SET avatar = $addedId WHERE id = ".$_SESSION['userData']['id'];
            $updateAvatar = mysqli_query($conn, $queryUpdate);
        }
        // Update data of user
        $query = "SELECT accounts.id, login, name, mail, created_at, nameAvatar FROM accounts, avatars WHERE accounts.id = ".$_SESSION['userData']['id']." AND accounts.avatar = avatars.id";
        $_SESSION['userData'] = mysqli_fetch_assoc(mysqli_query($conn, $query));
        header("Location: editAccount.php");
    } else{
        echo 'Błąd przy przesyłaniu danych!';
    }
?>