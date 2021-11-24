<?php

session_start();
include 'config.php';
include 'common.php';

if ($_SESSION['is_success'] == '1')
{
    $success_msg = "Success!!! User Registration Completed, Login to continue.";
    $success_class = "custom-server-error-pass";
    $_SESSION['is_success'] = '';
}

if (isset($_SESSION['username']))
{
    header("Location: dashboard.php");
    die;
}

if (isset($_POST['submit']))
{
    $email_msg = $password_msg = '';

    $email = test_input($_POST['email']);
    $password = md5($_POST['password']);

    if (!empty($_POST['password']) && !empty($_POST['email']))
    {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($result->num_rows > 0)
        {
            if ($password != $row['password'])
            {
                $password_msg = "Password is incorrect";
            }
            else
            {
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                header("Location: dashboard.php");
                die;
            }
        }
        else
        {
            if ($email != $row['email'])
            {
                $email_msg = "Email Id is not registered with us";
            }
        }
    }
    else
    {
        $success_msg = "Invalid user credentials! Please try again";
        $success_class = "custom-server-error-fail";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Login Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css?k=4.5">
</head>
<body>
	<div class="custom-server-msg <?php echo $success_class; ?>">
		<?php echo $success_msg; ?>
	</div>
	<div class="custom-container">
		<form action="" method="POST" class="login-form-main" id="dvMainLoginForm">
			<h2 class="form-title-text">Login</h2>
			<div class="custom-field-group">
				<input type="email" placeholder="Email ID" onblur="checkEmailValidation()" id="dvUserEmail" name="email" value="<?php echo $email; ?>">
				<div class="custom-error"><?php echo $email_msg; ?></div>
			</div>
			<div class="custom-field-group">
				<input autocomplete="off" type="password" maxlength="30" oncopy="event.preventDefault();" onpaste="event.preventDefault();" placeholder="Password" onkeyup="checkPasswordValidation()" onblur="checkPasswordValidation()" id="dvUserPassword" name="password" value="<?php echo $_POST['password']; ?>">
				<div class="custom-error"><?php echo $password_msg; ?></div>
			</div>
			<div class="custom-field-group">
				<input type="submit" name="submit" onclick="checkLoginFieldValidation(event)" class="primary-btn" value="Login" id="dvLoginSubmitBtn" />
			</div>
			<div class="form-text-info">Don't have an account? <a href="register.php">Register Here</a></div>
		</form>
	</div>

	<script type="text/javascript" src="js/script.js?k=4.5"></script>
</body>
</html>
