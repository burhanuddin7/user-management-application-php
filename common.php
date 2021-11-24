<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function customEncrypt($string)
{
    $result = '';
    for ($i = 0, $k = strlen($string);$i < $k;$i++)
    {
        $char = substr($string, $i, 1);
        $keychar = '9';
        $char = chr(ord($char) + ord($keychar) + 9999);
        $result .= $char;
    }
    return base64_encode($result);
}

function customDecrypt($string)
{
    $result = '';
    $string = base64_decode($string);
    for ($i = 0, $k = strlen($string);$i < $k;$i++)
    {
        $char = substr($string, $i, 1);
        $keychar = '9';
        $char = chr(ord($char) - ord($keychar) - 9999);
        $result .= $char;
    }
    return $result;
}

function validateUserName($username)
{
    if (empty($username))
    {
        $username_msg = 'Please enter a valid Username';
    }
    elseif (strlen($username) < 3)
    {
        $username_msg = 'Username should contain min 3 characters';
    }
    elseif (!preg_match("/^([a-zA-Z0-9 _-]+)$/", $username))
    {
        $username_msg = 'Only Alphabets, Numbers, Space, - , _ allowed';
    }
    else
    {
        $username_msg = '';
    }
    return $username_msg;
}

function validateEmailId($email)
{
    if (empty($email))
    {
        $email_msg = 'Please enter your Email Id';
    }
    elseif (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
    {
        $email_msg = 'Please enter a valid Email Id';
    }
    else
    {
        $email_msg = '';
    }
    return $email_msg;
}

function validatePhoneNo($phoneno)
{
    if (empty($phoneno))
    {
        $phone_msg = 'Please enter your Phone No';
    }
    elseif (!preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $phoneno))
    {
        $phone_msg = 'Please enter valid Phone No';
    }
    else
    {
        $phone_msg = '';
    }
    return $phone_msg;
}

function validatePassword($password, $cpassword)
{
    if (!empty($password) && ($password == $cpassword))
    {
        if (strlen($password) < 8)
        {
            $password_msg = 'Password should be of min 8 characters';
        }
        elseif (!preg_match("/^(?=.*[A-Z]).+$/", $password) || !preg_match("/^(?=.*[a-z]).+$/", $password))
        {
            $password_msg = 'A combination of upper and lower case letters';
        }
        elseif (!preg_match("/^(?=.*[0-9_\W]).+$/", $password))
        {
            $password_msg = 'Password should contain atleast one number or symbol';
        }
        else
        {
            $password_msg = '';
        }
    }
    else
    {
        $password_msg = 'Please check your Password';
    }
    return $password_msg;
}

function validateCnfPassword($password, $cpassword)
{
    if (empty($cpassword))
    {
        $cnfpassword_msg = 'Please check your Password';
    }
    elseif ($password != $cpassword)
    {
        $cnfpassword_msg = 'Your Password does not match';
    }
    else
    {
        $cnfpassword_msg = '';
    }
    return $cnfpassword_msg;
}

function validateOldPassword($old_password)
{
    if (!empty($old_password))
    {
        if (strlen($old_password) < 8)
        {
            $oldpassword_msg = 'Password should be of min 8 characters';
        }
        elseif (!preg_match("/^(?=.*[A-Z]).+$/", $old_password) || !preg_match("/^(?=.*[a-z]).+$/", $old_password))
        {
            $oldpassword_msg = 'A combination of upper and lower case letters';
        }
        elseif (!preg_match("/^(?=.*[0-9_\W]).+$/", $old_password))
        {
            $oldpassword_msg = 'Password should contain atleast one number or symbol';
        }
        else
        {
            $oldpassword_msg = '';
        }
    }
    else
    {
        $oldpassword_msg = 'Please check your Old Password';
    }
    return $oldpassword_msg;
}

function validateFirstName($firstname)
{
    if (empty($firstname))
    {
        $firstname_msg = 'Please enter a valid Username';
    }
    elseif (!preg_match("/^([a-zA-Z0-9 _-]+)$/", $firstname))
    {
        $firstname_msg = 'Only Alphabets, Numbers, Space, - , _ allowed';
    }
    else
    {
        $firstname_msg = '';
    }
    return $firstname_msg;
}

function validateLastName($lastname)
{
    if (empty($lastname))
    {
        $lastname_msg = 'Please enter a valid Username';
    }
    elseif (!preg_match("/^([a-zA-Z0-9 _-]+)$/", $lastname))
    {
        $lastname_msg = 'Only Alphabets, Numbers, Space, - , _ allowed';
    }
    else
    {
        $lastname_msg = '';
    }
    return $lastname_msg;
}
?>
