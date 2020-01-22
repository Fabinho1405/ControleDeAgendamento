<?php


    echo $_SERVER['LOCAL_ADDR'];
    echo "<br>";
    echo inet_ntop($_SERVER['LOCAL_ADDR'] );
    echo "<br>";
    echo getenv("REMOTE_ADDR");


?>