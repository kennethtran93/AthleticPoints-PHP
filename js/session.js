/*
 *  filename:       session.js
 */

//http://www.phpgang.com/popup-alert-on-session-expiry-using-php-and-jquery_506.html
function session_check() {
    $.post("/phpinclude/session.php", function (valid) {
	//console.log(valid);
	if (!valid) {
	    window.location.replace("/account.php?msg=expired&url=" + encodeURIComponent(location.pathname));
	}
    });
}
setInterval(session_check, 10000);