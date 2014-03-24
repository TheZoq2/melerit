<?php
	require_once("connect.php");
	//require_once("5.5PasswordFix/fix.php");
	session_start();

    $errorMsg = "";

	if(isset($_SESSION["username"]) && isset($_SESSION["userID"]))
    {
        header("location:index.php");
    }

    
?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <?php
        echo($errorMsg);
    ?>
    <h1>Login</h1>

    <form method="POST" action="requests.php">
    	<label>Username</label>
    	<input type="text" name="username">
    	<label>Password</label>
    	<input type="password" name="password">

    	<input type="submit" name="action" value="Login">
    </form>

    <h1>Register</h1>
    <form method="POST" action="requests.php">
    	<label>Username</label>
    	<input type="text" name="username">
    	<label>Password</label>
    	<input type="password" name="password">

    	<input type="submit" name="action" value="Register"> 
    </form>
</body>
</html>