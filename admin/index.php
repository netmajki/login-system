<?php
include_once '../deps/includes.php';

if(!isset($_SESSION["level"]) || $_SESSION["level"] != 1) // 1 = admin?
    header("Location: ../panel.php");

if(isset($_POST["submit"])) {
    $to_die = '';
    $licenses = main\admin\generate_licenses($_POST["amount"], $_POST["days"], $_POST["level"]);

    foreach($licenses as $license)
        $to_die .= $license . '<br>';

    die($to_die);
}

?>
<html>
<head>
    <title>s</title>
</head>
<body>
<label>hey <?php echo $_SESSION["username"]; ?></label> <br>
<label>generate licenses : </label> <br>

<form method="post">
    <label for="amount">amount</label> <br>
    <input type="text" id="amount" name="amount" /> <br>

    <label for="days">days</label> <br>
    <input type="text" id="days" name="days" /> <br>

    <label for="level">level</label> <br>
    <input type="text" id="level" name="level" /> <br>

    <button name="submit">submit</button>
</form>
</body>
</html>

