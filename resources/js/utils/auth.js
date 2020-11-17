export function isLoggedIn() {
	return localStorage.getItem('isLoggedIn') === 'true';
}

export function logIn() {
	localStorage.setItem('isLoggedIn', true);
}

export function logOut() {
	localStorage.setItem('isLoggedIn', false);
}

export function xsrfToken() {
	return localStorage.getItem('XSRF-TOKEN');
}

export function laravelSession() {
	return localStorage.getItem('laravel_session');
}
