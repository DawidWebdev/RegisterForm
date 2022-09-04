<?php
    include 'config.php';
    $msg = "";

    if(isset($_GET['reset'])){
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0){
            if(isset($_POST['submit'])){
                $password = mysqli_real_escape_string($conn, md5($_POST['password']));
                $query = mysqli_query($conn, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

                if($query){
                    header("Location: index.php?change-password=true");
                } else{
                    $msg = "<div class='alert-error'>Reset went wrong.</div>";
                }
            }
        } else{
            $msg = "<div class='alert-error'>Reset link do not match.</div>";
            header("Location: forgot-password.php");
        }
    } else{
        header("Location: forgot-password.php");
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
        <div class="container">
            <div class="content">
                <div class="content-left panel"></div>
                <div class="content-right panel">
                    <h2>Change Password</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <?php echo $msg?>
                    <form action="" method="post">
                        <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                        <button name="submit" class="btn" type="submit">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
</body>
</html>