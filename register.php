<?php

session_start();
include 'config.php';
include 'common.php';

if (isset($_SESSION['username']))
{
    header("Location: index.php");
    die;
}

if (isset($_POST['submit']))
{

    $error_bit = 0;

    $username_msg = $email_msg = $phone_msg = $cnfpassword_msg = $password_msg = '';

    $username = test_input($_POST['username']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $cpassword = test_input($_POST['cpassword']);
    $phoneno = test_input($_POST['phoneno']);
    $date = test_input($_POST['date']);

    // UserName validation
    if (validateUserName($username) != '')
    {
        $username_msg = validateUserName($username);
        $error_bit = 1;
    }

    // Email validation
    if (validateEmailId($email) != '')
    {
        $email_msg = validateEmailId($email);
        $error_bit = 1;
    }

    //Phone No validation
    if (validatePhoneNo($phoneno) != '')
    {
        $phone_msg = validatePhoneNo($phoneno);
        $error_bit = 1;
    }

    //Password Validation
    if (validatePassword($password, $cpassword) != '')
    {
        $password_msg = validatePassword($password, $cpassword);
        $error_bit = 1;
    }

    //Confirm Password Validation
    if (validateCnfPassword($password, $cpassword) != '')
    {
        $cnfpassword_msg = validateCnfPassword($password, $cpassword);
        $error_bit = 1;
    }

    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);

    if (!$error_bit)
    {
        $sql = "SELECT username,email FROM users WHERE (username='$username' or email='$email')";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            if (strtolower($username) == strtolower($row['username']))
            {
                $username_msg = "Sorry, Username already taken";
            }
            elseif (strtolower($email) == strtolower($row['email']))
            {
                $email_msg = 'Email Id Already Exists in DB';
            }
        }
        else
        {
            $sql = "INSERT INTO users (username, email, password, phoneno, date)
					VALUES ('$username', '$email', '$password', '$phoneno', '$date')";
            $result = mysqli_query($conn, $sql);
            if ($result)
            {
                $_POST = array();
                $_SESSION['is_success'] = '1';
                header("Location: index.php");
                die;
            }
            else
            {
                echo "<script>alert('Error in Connection.')</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Registration Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css?k=4.5">
</head>
<body>
	<div class="custom-container">
		<form action="" method="POST" class="login-form-main" id="dvMainRegisterForm">
			<input type="hidden" id="dvUserDateTime" name="date" value="<?php echo date('F j, Y, g:i a'); ?>"/>
            <h2 class="form-title-text">Register</h2>
			<div class="custom-field-group">
				<input type="text" placeholder="Username" id="dvUserName" maxlength="30" onblur="validateUserName()" name="username" value="<?php echo $username; ?>">
				<div class="custom-error"><?php echo $username_msg; ?></div>
			</div>
			<div class="custom-field-group">
				<input type="email" placeholder="Email ID" onblur="checkEmailValidation()" name="email" id="dvUserEmail" value="<?php echo $email; ?>">
				<div class="custom-error"><?php echo $email_msg; ?></div>
			</div>
			<div class="custom-field-group">
				<input type="text" placeholder="Phone no" maxlength="10" name="phoneno" onblur="checkContactNo()" id="dvUserPhoneNo" value="<?php echo $phoneno; ?>">
				<div class="custom-error"><?php echo $phone_msg; ?></div>
            </div>
			<div class="custom-field-group">
				<input autocomplete="off" oncopy="event.preventDefault();" maxlength="30" onpaste="event.preventDefault();" type="password" placeholder="Password" name="password" onkeyup="checkPasswordValidation()" onblur="checkPasswordValidation()" id="dvUserPassword" value="<?php echo $_POST['password']; ?>">
				<div class="custom-error"><?php echo $password_msg; ?></div>
            </div>
            <div class="custom-field-group">
				<input autocomplete="off" oncopy="event.preventDefault();" maxlength="30" onpaste="event.preventDefault();" type="password" placeholder="Confirm Password" onblur="checkConfirmPasswordValidation()" name="cpassword" id="dvCnfUserPassword" value="<?php echo $_POST['cpassword']; ?>">
				<div class="custom-error"><?php echo $cnfpassword_msg; ?></div>
			</div>
			<div class="custom-field-group">
				<input type="submit" name="submit" class="primary-btn" onclick="checkRegisterFieldValidation(event)" value="Register" id="dvRegisterSubmitBtn"/>
			</div>
			<div class="form-text-info">Already have an account? <a href="index.php">Login Here</a></div>
		</form>
	</div>

	<script type="text/javascript" src="js/script.js?k=4.5"></script>
</body>
</html>
