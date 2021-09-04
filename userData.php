<?php
    // Get data of user with DB
    $query = "SELECT accounts.id, login, name, mail, created_at, nameAvatar FROM accounts, avatars WHERE login = '$login' AND accounts.avatar = avatars.id";
    $_SESSION['userData'] = mysqli_fetch_assoc(mysqli_query($conn, $query));
?>