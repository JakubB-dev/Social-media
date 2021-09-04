<?php
    $secondsToDestroy = 600;

    if(isset($_SESSION["lastTime"])){
        if(($_SESSION["lastTime"] + $secondsToDestroy) < time()){
            session_destroy();
        }
    }
    
    $_SESSION["lastTime"] = time();
?>