function trimString(str) {
	while(str.charAt(0) == ' ') str = str.substring(1);
	while(str.charAt(str.length - 1) == ' ') str = str.substring(0, str.length - 1);
	return str;
}

function validateUserName() {
	var userNameObj = document.getElementById('dvUserName'),
		userName = trimString(userNameObj.value);
	if(userName.length == 0) {
		userNameObj.parentElement.classList.add("invalid");
		userNameObj.nextElementSibling.innerHTML = "Please enter a valid Username";
		return false;
	} else if(userName.length < 3) {
		userNameObj.parentElement.classList.add("invalid");
		userNameObj.nextElementSibling.innerHTML = "Username should contain min 3 characters";
		return false;
	} else if(!validateName(userName)) {
		userNameObj.parentElement.classList.add("invalid");
		userNameObj.nextElementSibling.innerHTML = "Only Alphabets, Numbers, Space, - , _ allowed";
		return false;
	} else {
		userNameObj.parentElement.classList.remove("invalid");
		userNameObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function validateEmail(email) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function validateName(name) {
	var re = /^([a-zA-Z0-9 _-]+)$/;
	return re.test(name);
}

function checkEmailValidation() {
	var userEmailObj = document.getElementById("dvUserEmail"),
		userEmail = trimString(userEmailObj.value);
	if(userEmail.length == 0) {
		userEmailObj.parentElement.classList.add("invalid");
		userEmailObj.nextElementSibling.innerHTML = "Please enter your Email Id";
		return false;
	} else if(!validateEmail(userEmail)) {
		userEmailObj.parentElement.classList.add("invalid");
		userEmailObj.nextElementSibling.innerHTML = "Please enter a valid Email Id";
		return false;
	} else {
		userEmailObj.parentElement.classList.remove("invalid");
		userEmailObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function checkPasswordValidation() {
	var regexSpecial = /^(?=.*[0-9_\W]).+$/,
		regCap = /^(?=.*[A-Z]).+$/,
		regSmall = /^(?=.*[a-z]).+$/,
		userPasswordObj = document.getElementById("dvUserPassword"),
		userPassword = userPasswordObj.value;
	if(userPassword.length == 0) {
		userPasswordObj.parentElement.classList.add("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "Please enter your Password";
		return false;
	} else if(userPassword.length < 8) {
		userPasswordObj.parentElement.classList.add("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "Password should be of min 8 characters";
		return false;
	} else if(!regSmall.test(userPassword) || !regCap.test(userPassword)) {
		userPasswordObj.parentElement.classList.add("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "A combination of upper and lower case letters";
		return false;
	} else if(!regexSpecial.test(userPassword)) {
		userPasswordObj.parentElement.classList.add("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "Password should contain atleast one number or symbol";
		return false;
	} else {
		userPasswordObj.parentElement.classList.remove("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function checkConfirmPasswordValidation() {
	var userCnfPasswordObj = document.getElementById("dvCnfUserPassword"),
		userCnfPassword = userCnfPasswordObj.value,
		userPasswordObj = document.getElementById("dvUserPassword"),
		userPassword = userPasswordObj.value;
	if(userCnfPassword.length == 0) {
		userCnfPasswordObj.parentElement.classList.add("invalid");
		userCnfPasswordObj.nextElementSibling.innerHTML = "Please enter your Password";
		return false;
	} else if(userPassword != userCnfPassword) {
		userCnfPasswordObj.parentElement.classList.add("invalid");
		userCnfPasswordObj.nextElementSibling.innerHTML = "Your passwords do not match";
		userCnfPasswordObj.value = "";
		return false;
	} else {
		userCnfPasswordObj.parentElement.classList.remove("invalid");
		userCnfPasswordObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function checkLoginFieldValidation(event) {
	var isFormValid = true;
	if(!checkEmailValidation()) isFormValid = false;
	if(!checkPasswordValidation()) isFormValid = false;
	if(!isFormValid) event.preventDefault();
	return isFormValid;
}

function checkRegisterFieldValidation(event) {
	var isFormValid = true;
	if(!validateUserName()) isFormValid = false;
	if(!checkEmailValidation()) isFormValid = false;
	if(!checkContactNo()) isFormValid = false;
	if(!checkPasswordValidation()) isFormValid = false;
	if(!checkConfirmPasswordValidation()) isFormValid = false;
	if(!isFormValid) event.preventDefault();
	return isFormValid;
}

function changePasswordValidation(event) {
	var isFormValid = true;
	if(!checkOldPasswordValidation()) isFormValid = false;
	if(!checkPasswordValidation()) isFormValid = false;
	if(!checkConfirmPasswordValidation()) isFormValid = false;
	if(!isFormValid) event.preventDefault();
	return isFormValid;
}

function checkContactNo() {
	var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im,
		phoneNoObj = document.getElementById('dvUserPhoneNo'),
		phoneNo = trimString(phoneNoObj.value);
	if(phoneNo.length == 0) {
		phoneNoObj.parentElement.classList.add("invalid");
		phoneNoObj.nextElementSibling.innerHTML = "Please enter your Phone No";
		return false;
	} else if(!re.test(phoneNo)) {
		phoneNoObj.parentElement.classList.add("invalid");
		phoneNoObj.nextElementSibling.innerHTML = "Please enter valid Phone No";
		return false;
	} else {
		phoneNoObj.parentElement.classList.remove("invalid");
		phoneNoObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function deleteUserRowFromDb(id, event) {
	event.preventDefault();
	var confirmDelete = confirm("Are you sure you want to delete this user?");
	if(confirmDelete == true) {
		document.cookie = "userid=" + id + ";expires=Wed, 18 Dec 2026 12:00:00 GMT";
		window.location.href = "delete.php";
	} else {
		return false;
	}
}

function updateUserRowDetails(id, event) {
	event.preventDefault();
	document.cookie = "update_id=" + id + ";expires=Wed, 18 Dec 2024 12:00:00 GMT";
	window.location.href = "update-user-details.php";
}

function checkOldPasswordValidation() {
	var regexSpecial = /^(?=.*[0-9_\W]).+$/,
		regCap = /^(?=.*[A-Z]).+$/,
		regSmall = /^(?=.*[a-z]).+$/,
		userPasswordObj = document.getElementById("dvOldUserPassword"),
		userPassword = userPasswordObj.value;
	if(userPassword.length == 0) {
		userPasswordObj.parentElement.classList.add("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "Please enter your Old Password";
		return false;
	} else if(userPassword.length < 8) {
		userPasswordObj.parentElement.classList.add("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "Password should be of min 8 characters";
		return false;
	} else if(!regSmall.test(userPassword) || !regCap.test(userPassword)) {
		userPasswordObj.parentElement.classList.add("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "A combination of upper and lower case letters";
		return false;
	} else if(!regexSpecial.test(userPassword)) {
		userPasswordObj.parentElement.classList.add("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "Password should contain atleast one number or symbol";
		return false;
	} else {
		userPasswordObj.parentElement.classList.remove("invalid");
		userPasswordObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function checkUpdateProfileValidation(event) {
	var isFormValid = true;
	if(!validateUserName()) isFormValid = false;
	if(!checkEmailValidation()) isFormValid = false;
	if(!checkContactNo()) isFormValid = false;
	if(!isFormValid) event.preventDefault();
	return isFormValid;
}

function checkMobileNo() {
	var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im,
		phoneNoObj = document.getElementById('dvUserMobileNo'),
		phoneNo = trimString(phoneNoObj.value);
	if(phoneNo.length == 0) {
		phoneNoObj.parentElement.classList.add("invalid");
		phoneNoObj.nextElementSibling.innerHTML = "Please enter your Mobile No";
		return false;
	} else if(!re.test(phoneNo)) {
		phoneNoObj.parentElement.classList.add("invalid");
		phoneNoObj.nextElementSibling.innerHTML = "Please enter valid Mobile No";
		return false;
	} else {
		phoneNoObj.parentElement.classList.remove("invalid");
		phoneNoObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function validateFirstName() {
	var userNameObj = document.getElementById('dvFirstName'),
		userName = trimString(userNameObj.value);
	if(userName.length == 0) {
		userNameObj.parentElement.classList.add("invalid");
		userNameObj.nextElementSibling.innerHTML = "Please enter a valid Firstname";
		return false;
	} else if(!validateName(userName)) {
		userNameObj.parentElement.classList.add("invalid");
		userNameObj.nextElementSibling.innerHTML = "Only Alphabets, Numbers, Space, - , _ allowed";
		return false;
	} else {
		userNameObj.parentElement.classList.remove("invalid");
		userNameObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function validateLastName() {
	var userNameObj = document.getElementById('dvLastName'),
		userName = trimString(userNameObj.value);
	if(userName.length == 0) {
		userNameObj.parentElement.classList.add("invalid");
		userNameObj.nextElementSibling.innerHTML = "Please enter a valid Lastname";
		return false;
	} else if(!validateName(userName)) {
		userNameObj.parentElement.classList.add("invalid");
		userNameObj.nextElementSibling.innerHTML = "Only Alphabets, Numbers, Space, - , _ allowed";
		return false;
	} else {
		userNameObj.parentElement.classList.remove("invalid");
		userNameObj.nextElementSibling.innerHTML = "";
		return true;
	}
}

function checkAddUserValidation(event) {
	var isFormValid = true;
	if(!validateFirstName()) isFormValid = false;
	if(!validateLastName()) isFormValid = false;
	if(!checkMobileNo()) isFormValid = false;
	if(!isFormValid) event.preventDefault();
	return isFormValid;
}