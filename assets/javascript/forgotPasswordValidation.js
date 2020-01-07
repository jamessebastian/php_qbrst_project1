function validate() {

	let errFlag = false;

	if (blankValidate(document.querySelector("#email").value)) {
		if (emailValidate(document.querySelector("#email").value)) {
			document.querySelector("#emailErr").textContent="";
		} else {
			errFlag = true;
			document.querySelector("#emailErr").textContent="Invalid email format";
		}
	} else {
		errFlag = true;
		document.querySelector("#emailErr").textContent="Email is required";
	}

	if (!errFlag) {
		$("#fullWrapper").css({ 'opacity': '0.5' });
		$("#loaderDiv").show();
	}

	return !errFlag;
}
