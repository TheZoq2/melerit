<?php
    require_once("connect.php");

    session_start();

    if(isset($_SESSION["username"]) == false)
    {
        header("location:login.php");
    }
?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Hello world</h1>
</body>
</html>