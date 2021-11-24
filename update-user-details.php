<?php

session_start();
include 'config.php';
include 'common.php';

if (!isset($_SESSION['username']))
{
    header("Location: index.php");
    die;
}

if (isset($_COOKIE["update_id"]))
{
    $update_id = $_COOKIE['update_id'];
    $update_id = customDecrypt($update_id);

    if (isset($_POST['submit']))
    {

        $error_bit = 0;

        $firstname_msg = $lastname_msg = $phone_msg = '';

        $firstname = test_input($_POST['firstname']);
        $lastname = test_input($_POST['lastname']);
        $mobileno = test_input($_POST['mobileno']);

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
            $sql = "UPDATE user_posts SET firstname='$firstname', lastname= '$lastname', mobileno='$mobileno' WHERE id='$update_id'";
            $result = mysqli_query($conn, $sql);
            if ($result)
            {
                $success_msg = "User Details Updated Successfully!!!";
                $success_class = "custom-server-error-pass";
            }
            else
            {
                $success_msg = "Error in Updating User Details";
                $success_class = "custom-server-error-fail";
            }
        }
    }
}
else
{
    $update_msg = "Please select the user to update the details";
    $update_class = "custom-server-error-fail";
    setcookie("update_id", "", time() - 3600);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Update User Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css?k=3.5">
</head>
<body class="dashboard-wrapper update-details-wrapper">
    <div class="dashboard-header clearfix">
        <div class="fl">
            <span class="user-id-main"><?php echo $_SESSION['id'] ?></span>
            <?php echo "<h1>Welcome " . $_SESSION['username'] . "</h1>"; ?>
        </div>
        <div class="dashboard-links fr">
            <a href="dashboard.php">Go Back to Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="delete-user-wrapper <?php echo $update_class; ?>">
        <?php echo $update_msg; ?>
    </div>
    
    <?php
    if (isset($_COOKIE["update_id"]))
    {
        $sql = "SELECT firstname,lastname,mobileno FROM user_posts WHERE id='$update_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $firstname = $_POST['firstname'] != '' ? $_POST['firstname'] : $row['firstname'];
                $lastname = $_POST['lastname'] != '' ? $_POST['lastname'] : $row['lastname'];
                $mobileno = $_POST['mobileno'] != '' ? $_POST['mobileno'] : $row['mobileno'];
            }

    ?>
    <div class="custom-server-msg <?php echo $success_class; ?>">
		<?php echo $success_msg; ?>
	</div>
	<div class="custom-container custom-password-wrapper">
		<form action="" method="POST" class="login-form-main" id="dvMainUpdateUserForm">
            <h2 class="form-title-text">Update User Details</h2>
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
				<input type="submit" name="submit" class="primary-btn" onclick="checkAddUserValidation(event)" value="Update User" id="dvAddUserSubmitBtn"/>
			</div>
			<div class="backto-page"><a href="dashboard.php">Go back to Dashboard</a></div>
		</form>
	</div>	
    <?php
    }
    } ?>
    <script type="text/javascript" src="js/script.js?k=4.5"></script>
</body>
</html>
