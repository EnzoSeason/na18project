<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Home</title>
</head>
<body>
    <?php
    session_start();
    echo '<h3> Bonjour, ' . $_SESSION['userType'] . ' ' . $_SESSION['nom'] . '</h3>' ;
    ?>
    
</body>
</html>