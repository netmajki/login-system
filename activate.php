<?php
include_once 'deps/includes.php';

if(isset($_POST["submit"]))
    general\alert(main\funcs\activate($_POST["username"], $_POST["license"]));

?>
<html>
<head>
    <title>s</title>
</head>
<body>
<label>activation page</label> <br>
<form method="post">
    <label for="username">username</label> <br>
    <input type="text" id="username" name="username" /> <br>
    <label for="license">license</label> <br>
    <input type="text" id="license" name="license" /> <br>
    <button name="submit">submit</button>
</form>
</body>
</html>
