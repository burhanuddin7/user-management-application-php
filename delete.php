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
if (isset($_COOKIE["userid"]))
{
    $user_id = $_COOKIE['userid'];
    $user_id = customDecrypt($user_id);

    $sql = "DELETE FROM user_posts WHERE id='$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result === true)
    {
        $delete_msg = 'User Record Deleted Successfully!!';
        $delete_class = 'user-active';
        setcookie("userid", "", time() - 3600);
    }
    else
    {
        $delete_msg = 'Something wrong!!';
    }
}
else
{
    $delete_class = 'user-active';
    $delete_msg = 'Please select a user to Delete from Dashboard';
}
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css?k=4.5">
</head>
<body class="dashboard-wrapper">
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
    <div class="delete-user-wrapper <?php echo $delete_class; ?>">
        <?php echo $delete_msg; ?>
    </div>
    <script type="text/javascript" src="js/script.js?k=4.5"></script>
</body>
</html>
