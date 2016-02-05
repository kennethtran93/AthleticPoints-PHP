/*
 *  filename:       member.js
 */

var formData;
$(document).ready(function () {

    $("#member").validate({
	rules: {
	    username: {
		required: true,
		minlength: 5,
		maxlength: 30
	    },
	    password: {
		required: true,
		minlength: 5
	    }
	},
	messages: {
	    username: {
		required: "Username missing",
		minlength: "Username too short",
		maxlength: "Username too long"
	    },
	    password: {
		required: "Password missing",
		minlength: "Password too short"
	    }
	}
    });

    $("#accountManagement").validate({
	rules: {
	    curUsername: {
		required: true,
		minlength: 5,
		maxlength: 30
	    },
	    curPassword: {
		required: true,
		minlength: 5
	    },
	    newUsername: {
		required: "#newUsername2:filled",
		minlength: 5,
		maxlength: 30
	    },
	    newUsername2: {
		required: "#newUsername:filled",
		minlength: 5,
		maxlength: 30,
		equalTo: "#newUsername"
	    },
	    newPassword: {
		required: "#newPassword2:filled",
		minlength: 5
	    },
	    newPassword2: {
		required: "#newPassword:filled",
		minlength: 5,
		equalTo: "#newPassword"
	    }
	},
	messages: {
	    curUsername: {
		required: "Username missing",
		minlength: "Username too short",
		maxlength: "Username too long"
	    },
	    curPassword: {
		required: "Password missing",
		minlength: "Password too short"
	    },
	    newUsername: {
		required: "New Username missing",
		minlength: "New Username too short",
		maxlength: "New Username too long"
	    },
	    newUsername2: {
		required: "New Username missing",
		minlength: "New Username too short",
		maxlength: "New Username too long",
		equalTo: "New Username does not match"
	    },
	    newPassword: {
		required: "New Password missing",
		minlength: "New Password too short"
	    },
	    newPassword2: {
		required: "New Password missing",
		minlength: "New Password too short",
		equalTo: "New Password does not match"
	    }
	}
    });

    $("#btnLogin").click(function (e) {
	e.preventDefault();
//	login();
    });

    $("#changeAccount").click(function (e) {
	e.preventDefault();
	$("#changeResult").empty();
	if ($("#accountManagement").valid()) {
	    $("#changeAccount, #resetChange").attr("disabled", "disabled");
	    formData = ConvertFormToJSON("#accountManagement");
	    console.log("Data from form (to be sent): ", formData);
	    $.ajax({
		url: "phpinclude/db_changeAccount.php",
		type: "POST",
		dataType: "JSON",
		data: formData,
		success: function (response) {
		    console.log("Data returned from server: ", response);

		    if (response['status'] == "Success") {
			var sendData = {logout: "true"};
			console.log("Logout Data to send: ", sendData);
			$.ajax({
			    url: "/phpinclude/db_logout.php",
			    type: "POST",
			    dataType: "JSON",
			    data: sendData,
			    success: function (data) {
				console.log("Logout data returned: ", data);
				if (location.search.search(/url=/i) !== -1) {
				    window.location.replace("/account.php?msg=updated&" + location.search.substring(location.search.search(/url=/i)));
				} else {
				    window.location.replace("/account.php?msg=updated&url=" + encodeURIComponent(location.pathname));
				}
			    }
			});
		    } else {
			$("#changeResult").html(response['msg']);
			$("#changeAccount, #resetChange").removeAttr("disabled");
		    }

		},
		error: function (jqXHR, textStatus, errorThrown) {
		    console.log(jqXHR);
		    console.log(textStatus);
		    console.log(errorThrown);
		    $("#changeResult").text("Oops - Something went wrong on our end.");
		    $("#changeAccount, #resetChange").removeAttr("disabled");
		}
	    });
	    $("#changeAccount, #resetChange").removeAttr("disabled");
	}
    });

    $("#resetChange").click(function () {
	$("#accountManagement").validate().resetForm();
    });
//
    $("#btnMobileLogout").click(function () {
	logout();
    });

    $("#btnMobileChange").click(function () {
	change();
    });

    $("#btnChangeReturn").click(function () {
	if (window.location.search.search(/url=/i) !== -1) {
	    window.location.replace(QueryStringRedirect("url"));
	} else {
	    window.location.replace(window.location.pathname);
	}
    });

    $("form#member .button").click(function () {
	console.log(this.id);
	switch (this.id) {
	    case "btnLogin":
		login();
		break;
	    case "btnLogout":
		logout();
		break;
	    case "btnRegister":
		register();
		break;
	    case "btnChange":
		change();
		break;
	    default:
		break;
	}
    });
});
// from: http://www.developerdrive.com/2013/04/turning-a-form-element-into-json-and-submiting-it-via-jquery/
function ConvertFormToJSON(form) {
    var array = $(form).serializeArray();
    var json = {};
    /*
     Read the following as:
     For every object in the array, use it's name and value
     to add a new property to the JavaScript object that is
     assigned to the variable 'json'. If the value of the
     input/textArea/select is undefined, use an empty string
     as the value.
     */
    jQuery.each(array, function () {
	json[this.name] = this.value || '';
    });
    return json;
}

function login() {
    if ($("#member").valid()) {
	$("#btnLogin").attr("disabled", "disabled");
	$("#btnRegister").attr("disabled", "disabled");
	formData = ConvertFormToJSON("#member");
	console.log("Data from form (to be sent): ", formData);
	$.ajax({
	    url: "/phpinclude/db_login.php",
	    type: "POST",
	    dataType: "JSON",
	    data: formData,
	    success: function (data) {
		console.log("Data returned from server: ", data);
		if (data['msg'] == "Success") {
		    if (window.location.search.search(/url=/i) !== -1) {
			window.location.replace(QueryStringRedirect("url"));
		    } else if (window.location.pathname.search(/account.php/i) !== -1) {
			window.location.replace(window.location.pathname + "?msg=success");
		    } else {
			window.location.replace(window.location.pathname);
		    }
		} else {
		    $("#accountResult").text(data['msg']);
		    $("#btnLogin, #btnRegister").removeAttr("disabled");
		}


	    },
	    error: function (jqXHR, textStatus, errorThrown) {
//		    console.log(jqXHR);
//		    console.log(textStatus);
//		    console.log(errorThrown);
		$("#accountResult").text("Oops - Something went wrong on our end.");
		$("#btnLogin, #btnRegister").removeAttr("disabled");
	    }
	});
    }
}

function logout() {
    var sendData = {logout: "true"};
    console.log("Logout Data to send: ", sendData);
    $.ajax({
	url: "/phpinclude/db_logout.php",
	type: "POST",
	dataType: "JSON",
	data: sendData,
	success: function (data) {
	    console.log("Logout data returned: ", data);
	    if (location.search.search(/url=/i) !== -1) {
		window.location.replace("/account.php?msg=logout&" + location.search.substring(location.search.search(/url=/i)));
	    } else {
		window.location.replace("/account.php?msg=logout&url=" + encodeURIComponent(location.pathname));
	    }
	},
	error: function (jqXHR, textStatus, errorThrown) {
	    //console.log(jqXHR, textStatus, errorThrown);
	    //console.log(jqXHR.statusText, textStatus);
	}
    });
}

function register() {
    window.location.href = "/register.php";
}

function change() {
    if (window.location.pathname.search(/account.php/i) === -1) {
	if (window.location.search.search(/url=/i) !== -1) {
	    window.location.href = "/account.php?msg=change&" + location.search.substring(location.search.search(/url=/i));
	} else {
	    window.location.href = "/account.php?msg=change&url=" + encodeURIComponent(location.pathname);
	}
    } else {
	window.location.replace("/account.php?msg=change");
    }
}


// From https://css-tricks.com/snippets/javascript/get-url-variables/#comment-1396508
function QueryStringRedirect(variable) {
    try {
	q = location.search.substring(1);
	v = q.split("&");
	for (var i = 0; i < v.length; i++) {
	    p = v[i].split("=");
	    if (p[0] == variable) {
		return decodeURIComponent(p[1]);
	    }
	}
    }
    catch (e) {
	console.log(e);
    }
}