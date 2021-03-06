<?php
include_once '../deps/includes.php';

if(!isset($_SESSION["level"]) || $_SESSION["level"] < 1) // 1 = admin?
    header("Location: ../panel.php");

if(isset($_POST["gen"])) {
    $to_die = '';
    $licenses = main\admin\generate_licenses($_POST["amount"], $_POST["days"], $_POST["level"]);

    foreach($licenses as $license)
        $to_die .= $license . '<br>';

    die($to_die);
}

if(isset($_POST["reset"]))
    general\alert(main\admin\reset_user_hwid($_POST["username"]));

?>
<html>
<head>
    <title>s</title>
</head>
<body>
<label>hey <?php echo $_SESSION["username"]; ?></label> <br> <br>

<label>reset user hwid : </label> <br>
<form method="post">

    <label for="username">username</label> <br>
    <input type="text" id="username" name="username" /> <br>

    <button name="reset">submit</button>
</form> <br>

<label>generate licenses : </label> <br>
<form method="post">
    <label for="amount">amount</label> <br>
    <input type="text" id="amount" name="amount" /> <br>

    <label for="days">days</label> <br>
    <input type="text" id="days" name="days" /> <br>

    <label for="level">level</label> <br>
    <input type="text" id="level" name="level" /> <br>

    <button name="gen">submit</button>
</form> <br>

<label>All licenses : </label>
<table>
    <tr>
        <th>License</th>
        <th>Days</th>
        <th>Level</th>
        <th>Used</th>
    </tr>
    <?php
    $all = main\admin\fetch_all_licenses();
    foreach($all as $single){
        echo "<tr><td>{$single["license"]}</td>";
        echo "<td>{$single["days"]}</td>";
        echo "<td>{$single["level"]}</td>";
        echo "<td>{$single["used"]}</td></tr>";
    }
    ?>
</table>

</body>
</html>

