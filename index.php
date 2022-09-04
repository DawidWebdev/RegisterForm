<?php
    session_start();
    include 'config.php';
    $msg = "";

    if(isset($_SESSION['SESSION_EMAIL'])){
        header("Location: welcome.php");
        die();
    }

    if(isset($_GET['change-password'])){
        $msg = "<div class='alert-success'>Password changed has been successfully completed!</div>";
    }

    if(isset($_GET['verification'])){
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0){
            $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");

            if($query){
                $msg = "<div class='alert-success'>Account verification has been successfully completed!</div>";
            }
        } 
    }

    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);

            if(empty($row['code'])){
                $_SESSION['SESSION_EMAIL'] = $email;
                header("Location: welcome.php");
            } else{
                $msg = "<div class='alert-info'>Verify your account and try again.</div>";
            }
        } else{
            $msg = "<div class='alert-error'>Email or password do not match.</div>";
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
        <div class="container">
            <div class="content">
                <div class="content-left panel"></div>
                <div class="content-right panel">
                    <h2>Login Now</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <?php echo $msg?>
                    <form action="" method="post">
                        <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if(isset($_POST['submit'])) echo $email; ?>" required>
                        <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                        <a href="forgot-password.php" class="forgot">Forgot Password?</a>
                        <button name="submit" class="btn" type="submit">Login</button>
                    </form>
                    <span class="create-account">Create account! <a href="register.php">Register</a></span>
                </div>
            </div>
        </div>
</body>
</html>