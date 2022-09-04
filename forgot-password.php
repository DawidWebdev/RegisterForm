<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';  

    include 'config.php';
    session_start();
    $msg = "";

    if(isset($_SESSION['SESSION_EMAIL'])){
        header("Location: welcome.php");
        die();
    }

    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $code = mysqli_real_escape_string($conn, md5(rand()));

        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0){
            $sql = "UPDATE users SET code='{$code}' WHERE email='{$email}'";
            $result = mysqli_query($conn, $sql);
            if($result){
                echo "<div style='display: none;'>";
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'dawidwebdv@gmail.com';                     //SMTP username
                        $mail->Password   = 'ltsbqfyytjwgmeua';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('dawidwebdv@gmail.com', 'Dawid Poniewierski');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'no reply';
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost/loginregisterform/change-password.php?reset='.$code.'">http://localhost/loginregisterform/change-password.php?reset='.$code.'</a></b>';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div class='alert-info'>We've send a verification link to your email address.</div>";
            }
        } else{
            $msg = "<div class='alert-error'>{$email} - This email not exists.</div>";
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
                    <h2>Forgot Password</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <?php echo $msg?>
                    <form action="" method="post">
                        <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if(isset($_POST['submit'])) echo $email; ?>" required>
                        <button name="submit" class="btn" type="submit">Send Reset Link</button>
                    </form>
                    <span class="create-account">Back to <a href="index.php">Login</a></span>
                </div>
            </div>
        </div>
</body>
</html>