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
	//return true;
	let errFlag = false;

	remClass("is-valid", "is-invalid", "form-control");
	remClass("valid-feedback", "invalid-feedback", "errBox");

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

	if (!errFlag) {
		$("#fullWrapper").css({ 'opacity': '0.5' });
		$("#loaderDiv").show();
	}
	
	return !errFlag;
}
