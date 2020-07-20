<?php
include_once 'deps/includes.php';

if(isset($_SESSION["username"]))
    header("Location: panel.php");

if(isset($_POST["submit"])){
    $username = $_POST["username"];

    $resp = main\funcs\login($username, $_POST["password"]);

    if($resp == main\responses::success){
        $_SESSION["username"] = htmlentities($username);
        $_SESSION["level"] = main\funcs\get_user_level($username);

        header("Location: panel.php");
    }
    else general\alert($resp);
}
?>
<html>
    <head>
        <title>s</title>
    </head>
    <body>
        <label>login page</label> <br>
        <form method="post">
            <label for="username">username</label> <br>
            <input type="text" id="username" name="username" /> <br>
            <label for="password">password</label> <br>
            <input type="password" id="password" name="password" /> <br>
            <button name="submit">submit</button>
        </form>
    </body>
</html>
