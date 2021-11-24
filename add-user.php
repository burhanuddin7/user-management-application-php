<?php

session_start();
include 'config.php';
include 'common.php';

if (!isset($_SESSION['username']))
{
    header("Location: index.php");
    die;
}
setcookie("update_id", "", time() - 3600);
$user_id = $_SESSION['id'];

if (isset($_POST['submit']))
{

    $error_bit = 0;

    $firstname_msg = $lastname_msg = $phone_msg = '';

    $firstname = test_input($_POST['firstname']);
    $lastname = test_input($_POST['lastname']);
    $mobileno = test_input($_POST['mobileno']);
    $user_date = test_input($_POST['user_date']);

    // First Name validation
    if (validateFirstName($firstname) != '')
    {
        $firstname_msg = validateFirstName($firstname);
        $error_bit = 1;
    }

    // Last Name validation
    if (validateLastName($lastname) != '')
    {
        $lastname_msg = validateLastName($lastname);
        $error_bit = 1;
    }

    //Phone No validation
    if (validatePhoneNo($mobileno) != '')
    {
        $phone_msg = validatePhoneNo($mobileno);
        $error_bit = 1;
    }

    if (!$error_bit)
    {
        $sql = "INSERT INTO user_posts (firstname, lastname, mobileno, user_id, user_date)
                VALUES ('$firstname', '$lastname', '$mobileno', '$user_id', '$user_date')";
        $result = mysqli_query($conn, $sql);
        if ($result)
        {
            $firstname = '';
            $lastname = '';
            $mobileno = '';
            $success_msg = "User Added Successfully!!!";
            $success_class = "custom-server-error-pass";
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
	<title>Add User Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css?k=4.5">
</head>
<body>
    <div class="custom-server-msg <?php echo $success_class; ?>">
		<?php echo $success_msg; ?>
	</div>
	<div class="custom-container custom-password-wrapper">
		<form action="" method="POST" class="login-form-main" id="dvAddUserorm">
            <input type="hidden" id="dvUserDate" name="user_date" value="<?php echo date('F j, Y, g:i a'); ?>"/>
            <h2 class="form-title-text">Add User</h2>
			<div class="custom-field-group">
				<input type="text" placeholder="First Name" id="dvFirstName" maxlength="30" onblur="validateFirstName()" name="firstname" value="<?php echo $firstname; ?>">
				<div class="custom-error"><?php echo $firstname_msg; ?></div>
			</div>
            <div class="custom-field-group">
				<input type="text" placeholder="Last Name" id="dvLastName" maxlength="30" onblur="validateLastName()" name="lastname" value="<?php echo $lastname; ?>">
				<div class="custom-error"><?php echo $lastname_msg; ?></div>
			</div>
			<div class="custom-field-group">
				<input type="text" placeholder="Mobile no" maxlength="10" name="mobileno" onblur="checkContactNo()" id="dvUserMobileNo" value="<?php echo $mobileno; ?>">
				<div class="custom-error"><?php echo $phone_msg; ?></div>
            </div>
			<div class="custom-field-group">
				<input type="submit" name="submit" class="primary-btn" onclick="checkAddUserValidation(event)" value="Add User" id="dvAddUserSubmitBtn"/>
			</div>
			<div class="backto-page"><a href="dashboard.php">Go back to Dashboard</a></div>
		</form>
	</div>

	<script type="text/javascript" src="js/script.js?k=4.6"></script>
</body>
</html>
