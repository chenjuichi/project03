export const is404 = function(err) {
	return isErrorWithResponseAndStatus(err) && 404 === err.response.status;
};

export const is422 = function(err) {
	return isErrorWithResponseAndStatus(err) && 422 === err.response.status;
};

const isErrorWithResponseAndStatus = function(err) {
	return err.response && err.response.status;
};

export const isRegexpDate = function(myDate) {
	let reg = /^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
	let regExp = new RegExp(reg);

	return regExp.test(myDate);
};