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
$sql = "SELECT * FROM user_posts WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css?k=4.8">
</head>
<body class="dashboard-wrapper">
<form action="" method="POST">
    <div class="dashboard-header clearfix">
        <div class="fl">
            <span class="user-id-main"><?php echo $_SESSION['id'] ?></span>
            <?php echo "<h1>Welcome " . $_SESSION['username'] . "</h1>"; ?>
        </div>
        <div class="dashboard-links fr">
            <a href="add-user.php">Add User</a>
            <a href="update-profile.php">Edit Admin Profile</a>
            <a href="change-password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Admin ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Mobile No</th>
                <th>Type</th>
                <th>Date</th>
                <th>Action</th>   
            </tr>
        </thead>
        <tbody>	
            <?php
                if (mysqli_num_rows($result) > 0)
                {
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        if ($_SESSION['id'] == $row['user_id'])
                        {
                            $encrypt_val = customEncrypt($row["id"]);
                            $edit_user = '<a href="javascript:void(0)" onclick="updateUserRowDetails(' . "'" . $encrypt_val . "'" . ', event);" class="secondary-btn">Edit User</a>';
                            $delete_user = '<a href="javascript:void(0)" onclick="deleteUserRowFromDb(' . "'" . $encrypt_val . "'" . ', event);" class="secondary-btn delete-btn">Delete</a>';
            ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['mobileno']; ?></td>
                <td>User</td>
                <td><?php echo $row['user_date']; ?></td>
                <td><?php echo $edit_user;
            echo $delete_user; ?></td>
            </tr>          
            <?php
                    }
                }
            }
            else
            { ?>
                <tr class="no-record"><td colspan="7">No Users to display, Add Users by clicking <a href="add-user.php">here</a></td></tr>
                <?php
            }
            ?>             
        </tbody>
    </table>
</form>
<script type="text/javascript" src="js/script.js?k=4.6"></script>
</body>
</html>
