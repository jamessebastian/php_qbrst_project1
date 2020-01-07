function emailValidate(email) {
	if (
		/^\s*[A-Za-z0-9_.+-]{3,}@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+\s*$/.test(email)
	) {
		return true;
	}
	return false;
}

function blankValidate(val) {
	if (val !== "") {
		return true;
	}
	return false;
}

function min3LettersValidate(val) {
	if ( /^.{3,}$/.test(val) || (val == "" )) {
		return true;
	}
	return false;
}
