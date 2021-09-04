<?php
    if(isset($_POST['recipientID'])){
        require_once("conn.php");
        session_start();
    
        $myID = $_SESSION['userData']['id'];
        $friendID = $_POST['recipientID'];
        
        $queryDeleteInvite = "DELETE FROM invites WHERE sender = $friendID AND recipient = $myID";
        mysqli_query($conn, $queryDeleteInvite);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else{
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>