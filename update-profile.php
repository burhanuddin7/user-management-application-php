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

    $username_msg = $email_msg = $phone_msg = '';

    $username = test_input($_POST['username']);
    $email = test_input($_POST['email']);
    $phoneno = test_input($_POST['phoneno']);

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

    if (!$error_bit)
    {
        $sql = "SELECT username,email FROM users WHERE (username='$username' or email='$email') AND id!='$user_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);

            if (strtolower($username) == strtolower($row['username']))
            {
                $username_msg = "Please enter a unique username";
                $success_msg = "Sorry, Username already taken";
                $success_class = "custom-server-error-fail";
                $error_bit = 1;
            }
            elseif (strtolower($email) == strtolower($row['email']))
            {
                $email_msg = 'Please enter a different email';
                $success_msg = "Email Id Already Exists in DB";
                $success_class = "custom-server-error-fail";
                $error_bit = 1;
            }
        }
    }

    if (!$error_bit)
    {
        $sql = "UPDATE users SET username='$username', email= '$email', phoneno='$phoneno' WHERE id='$user_id'";
        $result = mysqli_query($conn, $sql);
        if ($result)
        {
            $success_msg = "Admin Details Updated Successfully!!!";
            $success_class = "custom-server-error-pass";
            $_SESSION['username'] = $_POST['username'];
        }
        else
        {
            $success_msg = "Error in Updating Admin Details";
            $success_class = "custom-server-error-fail";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Update User Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css?k=2.5">
</head>
<body>
    <?php
	if (isset($_SESSION['id']))
	{
		$sql = "SELECT username,email,phoneno FROM users WHERE id='$user_id'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0)
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				$username = $_POST['username'] != '' ? $_POST['username'] : $row['username'];
				$email = $_POST['email'] != '' ? $_POST['email'] : $row['email'];
				$phoneno = $_POST['phoneno'] != '' ? $_POST['phoneno'] : $row['phoneno'];
			}

	?>
    <div class="custom-server-msg <?php echo $success_class; ?>">
		<?php echo $success_msg; ?>
	</div>
	<div class="custom-container custom-password-wrapper">
		<form action="" method="POST" class="login-form-main" id="dvMainProfileForm">
            <h2 class="form-title-text">Update Profile</h2>
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
				<input type="submit" name="submit" class="primary-btn" onclick="checkUpdateProfileValidation(event)" value="Update" id="dvUpdateProfileBtn"/>
			</div>
			<div class="backto-page"><a href="dashboard.php">Go back to Dashboard</a></div>
		</form>
	</div>

	<script type="text/javascript" src="js/script.js?k=4.5"></script>
    <?php
    }
    else
    {
        header('Location: dashboard.php');
        die;
    }
	} ?>
</body>
</html>
