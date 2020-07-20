<?php
include_once 'deps/includes.php';

if(isset($_POST["submit"])){
    $username = $_POST["username"];

    if($_POST["password"] === $_POST["repeat_password"]) {
        $resp = main\funcs\register($username, $_POST["password"]);

        if ($resp != main\responses::success)
            general\alert($resp);

        header("Location: login.php");
    }
    else general\alert('repeated password is wrong');
}
?>
<html>
<head>
    <title>s</title>
</head>
<body>
<label>register page</label> <br>
<form method="post">
    <label for="username">username</label> <br>
    <input type="text" id="username" name="username" /> <br>
    <label for="password">password</label> <br>
    <input type="password" id="password" name="password" /> <br>
    <label for="repeat_password">repeat password</label> <br>
    <input type="password" id="repeat_password" name="repeat_password" /> <br>
    <button name="submit">submit</button>
</form>
</body>
</html>
