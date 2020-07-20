<?php
include_once 'deps/includes.php';

if(!isset($_SESSION["username"]))
    header("Location: login.php");

if(isset($_POST["submit"]))
    general\alert(main\funcs\activate($_SESSION["username"], $_POST["license"]));

?>
<html>
<head>
    <title>s</title>
</head>
<body>
<label>hey <?php echo $_SESSION["username"]; ?></label> <br>
<?php if($_SESSION["level"] >= 1) echo "<a href='admin/index.php'> admin panel </a><br><br>"; ?>
<label>activate sub form</label>
<form method="post">
    <label for="license">license</label> <br>
    <input type="text" id="license" name="license" /> <br>
    <button name="submit">submit</button>
</form>
</body>
</html>
