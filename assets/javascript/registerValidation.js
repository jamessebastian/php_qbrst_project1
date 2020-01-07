function setMaxDateToCurrentDate() {
	var todaysDate = new Date();
	var year = todaysDate.getFullYear();
	var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2);
	var day = ("0" + todaysDate.getDate()).slice(-2);
	var maxDate = year + "-" + month + "-" + day; // Results in "YYYY-MM-DD" for today's date

	document.getElementById("dob").max = maxDate;
}

function previewImage(event) {
	document.getElementById("fileErr").style.visibility = "hidden";
	var reader = new FileReader();
	reader.onload = function() {
		var output = document.getElementById("outputImage");
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
}

function showBadMssg(id, idErr, errMssg) {
	document.getElementById(id).classList.add("is-invalid");
	document.getElementById(idErr).classList.add("invalid-feedback");
	document.getElementById(idErr).textContent = errMssg;
}

function showGoodMssg(id, idErr) {
	document.getElementById(id).classList.add("is-valid");
	document.getElementById(idErr).classList.add("valid-feedback");
	document.getElementById(idErr).textContent = "Looks Good";
}

function showGoodMssgForMiddleName(id, idErr) {
	document.getElementById(id).classList.add("is-valid");
	document.getElementById(idErr).textContent = "";
}

function phoneValidate(phone) {
	if (/^\s*\d{3}\d{3}\d{4}\s*$/.test(phone)) {
		return true;
	}
	return false;
}

function dateValidate(date) {
	if (/^\s*\d\d\d\d-\d\d-\d\d\s*$/.test(date)) {
		return true;
	}
	return false;
}

function nameValidate(name) {
	if (/^\s*[a-zA-Z][a-zA-Z ]*$/.test(name)) {
		return true;
	}
	return false;
}

function cityValidate(name) {
	if (/^(?=.*[a-zA-Z])\s*[a-zA-Z0-9][a-zA-Z0-9 ]*$/.test(name)) {
		return true;
	}
	return false;
}

function numberValidate(number) {
	if (/^\s*[1-9][0-9]{5}\s*$/.test(number)) {
		return true;
	}
	return false;
}

function passwordValidate(passsword) {
	if (
		/^(?=.*\d)(?=.*\W)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,}$/.test(passsword)
	) {
		return true;
	}
	return false;
}

function remClass(className1, className2, fromClass) {
	nodeList = document.querySelectorAll("." + fromClass);
	for (i = 0; i < nodeList.length; i += 1) {
		nodeList[i].classList.remove(className1, className2);
	}
}


function validate() {
	
	let errFlag = false;

	remClass("is-valid", "is-invalid", "custom-select");
	remClass("is-valid", "is-invalid", "form-control");
	remClass("valid-feedback", "invalid-feedback", "errBox");
	remClass("is-valid", "is-invalid", "form-check-input");

	if (blankValidate(document.querySelector("#fName").value)) {
		if (nameValidate(document.querySelector("#fName").value)) {
			showGoodMssg("fName", "fNameErr");
		} else {
			errFlag = true;
			showBadMssg(
				"fName",
				"fNameErr",
				"Only letters and white space allowed"
			);
		}
	} else {
		errFlag = true;
		showBadMssg("fName", "fNameErr", "First name is required");
	}

	if (blankValidate(document.querySelector("#mName").value)) {
		if (nameValidate(document.querySelector("#mName").value)) {
			showGoodMssg("mName", "mNameErr");
		} else {
			errFlag = true;
			showBadMssg(
				"mName",
				"mNameErr",
				"Only letters and white space allowed"
			);
		}
	} else {
		showGoodMssgForMiddleName("mName", "mNameErr");
	}

	if (blankValidate(document.querySelector("#lName").value)) {
		if (nameValidate(document.querySelector("#lName").value)) {
			showGoodMssg("lName", "lNameErr");
		} else {
			errFlag = true;
			showBadMssg(
				"lName",
				"lNameErr",
				"Only letters and white space allowed"
			);
		}
	} else {
		errFlag = true;
		showBadMssg("lName", "lNameErr", "Last name is required");
	}

	if (blankValidate(document.querySelector("#email").value)) {
		if (emailValidate(document.querySelector("#email").value)) {
			$.ajax({ 
				type 		: 'POST', 
				async       : false,
				url 		: 'checkEmailExists.php', 
				data 		: {'email':document.querySelector("#email").value},
				dataType 	: 'json',
				success 	: function(data) {
				    			if (data.success) { 

				    				errFlag=true;
				    				// alert("errFlag after email checking->");
				    				// alert(errFlag);
									showBadMssg("email", "emailErr", "Email already existss");	
				    			} else {
				    				showGoodMssg("email", "emailErr");
				    			}
							}
			});	
			//showGoodMssg("email", "emailErr");
		} else {
			errFlag = true;
			showBadMssg("email", "emailErr", "Invalid email format");
		}
	} else {
		errFlag = true;
		showBadMssg("email", "emailErr", "Email is required");
	}

	if (blankValidate(document.querySelector("#phone").value)) {
		if (phoneValidate(document.querySelector("#phone").value)) {
			showGoodMssg("phone", "phoneErr");
		} else {
			errFlag = true;
			showBadMssg(
				"phone",
				"phoneErr",
				"Phone number should be in the format- 1112222222"
			);
		}
	} else {
		errFlag = true;
		showBadMssg("phone", "phoneErr", "Phone number is required");
	}

	if (blankValidate(document.querySelector("#dob").value)) {
		if (dateValidate(document.querySelector("#dob").value)) {
			showGoodMssg("dob", "dobErr");
		} else {
			errFlag = true;
			showBadMssg(
				"dob",
				"dobErr",
				"Date of birth should be in the format 1165-11-12"
			);
		}
	} else {
		errFlag = true;
		showBadMssg("dob", "dobErr", "Date of birth is required");
	}

	if (blankValidate(document.forms["regForm"]["gender"].value)) {
		showGoodMssg("useless", "genderErr");
	} else {
		errFlag = true;
		showBadMssg("useless", "genderErr", "Select gender");
	}

	if (
		blankValidate(
			document.forms["regForm"]["emailNotificationFrequency"].value
		)
	) {
		showGoodMssg("useless", "emailNotificationFrequencyErr");
	} else {
		errFlag = true;
		showBadMssg(
			"useless",
			"emailNotificationFrequencyErr",
			"Select email notification frequency"
		);
	}

	if (blankValidate(document.querySelector("#address1").value)) {
		showGoodMssg("address1", "address1Err");
	} else {
		errFlag = true;
		showBadMssg("address1", "address1Err", "Address is required");
	}

	if (blankValidate(document.querySelector("#city").value)) {
		if (cityValidate(document.querySelector("#city").value)) {
			showGoodMssg("city", "cityErr");
		} else {
			errFlag = true;
			showBadMssg(
				"city",
				"cityErr",
				"City name should only contain letters, spaces and digits"
			);
		}
	} else {
		errFlag = true;
		showBadMssg("city", "cityErr", "City is required");
	}

	if (blankValidate(document.querySelector("#state").value)) {
		showGoodMssg("state", "stateErr");
	} else {
		errFlag = true;
		showBadMssg("state", "stateErr", "Select state");
	}

	if (blankValidate(document.querySelector("#pin").value)) {
		if (numberValidate(document.querySelector("#pin").value)) {
			showGoodMssg("pin", "pinErr");
		} else {
			errFlag = true;
			showBadMssg(
				"pin",
				"pinErr",
				"PIN should be of the format - 123456"
			);
		}
	} else {
		errFlag = true;
		showBadMssg("pin", "pinErr", "PIN is required");
	}

	if (blankValidate(document.querySelector("#confirmPassword").value)) {
		if (
			document.querySelector("#password").value !==
			document.querySelector("#confirmPassword").value
		) {
			errFlag = true;
			showBadMssg(
				"confirmPassword",
				"confirmPasswordErr",
				"Password should be same"
			);
		} else {
			showGoodMssg("confirmPassword", "confirmPasswordErr");
		}
	} else {
		errFlag = true;
		showBadMssg(
			"confirmPassword",
			"confirmPasswordErr",
			"Confirm password is required"
		);
	}

	if (blankValidate(document.querySelector("#password").value)) {
		if (passwordValidate(document.querySelector("#password").value)) {
			showGoodMssg("password", "passwordErr");
		} else {
			errFlag = true;
			showBadMssg(
				"password",
				"passwordErr",
				"Password should contain - minimum 8 character, a symbol, no spaces, a capital letter, a digit"
			);
			showBadMssg("confirmPassword", "confirmPasswordErr", "");
		}
	} else {
		errFlag = true;
		showBadMssg("password", "passwordErr", "Password is required");
	}

	if (document.querySelector("#tAndC").checked) {
		showGoodMssg("tAndC", "tAndCErr");
	} else {
		errFlag = true;
		showBadMssg(
			"tAndC",
			"tAndCErr",
			"You need to accept the terms and conditions"
		);
	}

	if (!errFlag) {
		$("#fullWrapper").css({ 'opacity': '0.5' });
		$("#loaderDiv").show();
	}

	return !errFlag;
}

setMaxDateToCurrentDate();