<?php
    include 'config.php';
    session_start();
    $msg = "";

    if(!isset($_SESSION['SESSION_EMAIL'])){
        header("Location: index.php");
        die();
    } else{
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");
        
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);
            $msg = "Welcome {$row['login']}";
        }
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        echo $msg;
        echo "<br>";
        echo "<a href='logout.php'>Logout</a>"
    ?>
</body>
</html>