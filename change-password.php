<?php

session_start();
include 'config.php';
include 'common.php';

if (!isset($_SESSION['username']))
{
    header("Location: index.php");
    die;
}
$user_id = $_SESSION['id'];
setcookie("update_id", "", time() - 3600);
if (isset($_POST['submit']))
{
    $error_bit = 0;
    $oldpassword_msg = $password_msg = $cnfpassword_msg = '';

    $old_password = test_input($_POST['old_password']);
    $password = test_input($_POST['password']);
    $cpassword = test_input($_POST['cpassword']);

    //Old password validation
    if (validateOldPassword($old_password) != '')
    {
        $oldpassword_msg = validateOldPassword($old_password);
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
    $old_password = md5($_POST['old_password']);

    if (!$error_bit)
    {
        $sql = "SELECT password FROM users WHERE id='$user_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            if ($row['password'] == $old_password)
            {
                if ($password == $cpassword)
                {
                    $pass_sql = "UPDATE users set password='$password' WHERE id='$user_id'";
                    $res = mysqli_query($conn, $pass_sql);
                    if ($res)
                    {
                        $success_msg = "Password updated Successfully!!!";
                        $success_class = "custom-server-error-pass";
                        $_POST = array();
                    }
                    else
                    {
                        $success_msg = "Error in connection";
                        $success_class = "custom-server-error-fail";
                    }
                }
                else
                {
                    $success_msg = "Your New and Confirm Password does not match";
                    $success_class = "custom-server-error-fail";
                }
            }
            else
            {
                $success_msg = "Your Old Password is Incorrect";
                $success_class = "custom-server-error-fail";
                $oldpassword_msg = 'Please check your Old Password';
            }
        }
        else
        {
            $success_msg = "Error in connection";
            $success_class = "custom-server-error-fail";
        }
    }

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Change Password Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css?k=3.5">
</head>
<body>
	<div class="custom-server-msg <?php echo $success_class; ?>">
		<?php echo $success_msg; ?>
	</div>
	<div class="custom-container custom-password-wrapper">
		<form action="" method="POST" class="login-form-main" id="dvMainPasswordForm">
			<h2 class="form-title-text">Change Password</h2>
			<div class="custom-field-group">
				<input autocomplete="off" type="password" maxlength="30" oncopy="event.preventDefault();" onpaste="event.preventDefault();" placeholder="Enter your old password" onkeyup="checkOldPasswordValidation()" onblur="checkOldPasswordValidation()" id="dvOldUserPassword" name="old_password" value="<?php echo $_POST['old_password']; ?>">
				<div class="custom-error"><?php echo $oldpassword_msg; ?></div>
			</div>
			<div class="custom-field-group">
				<input autocomplete="off" type="password" maxlength="30" oncopy="event.preventDefault();" onpaste="event.preventDefault();" placeholder="Enter your new password" onkeyup="checkPasswordValidation()" onblur="checkPasswordValidation()" id="dvUserPassword" name="password" value="<?php echo $_POST['password']; ?>">
				<div class="custom-error"><?php echo $password_msg; ?></div>
			</div>
            <div class="custom-field-group">
				<input autocomplete="off" oncopy="event.preventDefault();" maxlength="30" onpaste="event.preventDefault();" type="password" placeholder="Confirm your new password" onblur="checkConfirmPasswordValidation()" name="cpassword" id="dvCnfUserPassword" value="<?php echo $_POST['cpassword']; ?>">
				<div class="custom-error"><?php echo $cnfpassword_msg; ?></div>
			</div>
			<div class="custom-field-group">
				<input type="submit" name="submit" onclick="changePasswordValidation(event)" class="primary-btn" value="Update" id="dvChangePassSubmitBtn" />
			</div>
			<div class="backto-page"><a href="dashboard.php">Go back to Dashboard</a></div>
		</form>
	</div>

	<script type="text/javascript" src="js/script.js?k=4.5"></script>
</body>
</html>