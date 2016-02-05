/*
 *  filename:       register.js
 */

var formData;
$(document).ready(function () {

    $("#valUser").validate({
	rules: {
	    txtID: {
		required: true,
		maxlength: 8,
		digits: true
	    },
	    txtFirstName: {
		required: true,
		maxlength: 30
	    },
	    txtLastName: {
		required: true,
		maxlength: 30
	    },
	    selectUserType: "required"
	},
	messages: {
	    txtID: {
		required: "Please enter your ID",
		maxlength: "ID is too long",
		digits: "ID must be a whole number"
	    },
	    txtFirstName: {
		required: "Please enter your First Name",
		maxlength: "First name is too long"
	    },
	    txtLastName: {
		required: "Please enter your Last Name",
		maxlength: "Last name is too long"
	    },
	    selectUserType: "Please select your Program Role"
	}
    });

    $("#validate").click(function (e) {
	e.preventDefault();
	$("#result").text("");
	if ($("#valUser").valid()) {
	    $("#validate, #reset").attr("disabled", "disabled");
	    formData = ConvertFormToJSON("#valUser");
	    console.log("Data from form (to be sent): ", formData);

	    $.ajax({
		url: "phpinclude/db_valUser.php",
		type: "GET",
		dataType: "JSON",
		data: formData,
		success: function (data) {
		    console.log("Data returned from server: ", data);

		    if (data['status'] == "Success") {
			if (data['valid'] == 1) {

			    var id = formData['txtID'];
			    var fname = formData['txtFirstName'];
			    var lname = formData['txtLastName'];
			    var userRole = formData['selectUserType'];

			    $('#txtID').replaceWith("<span id=\"userID\">" + id + "</span>");
			    $('#txtFirstName').replaceWith("<span id=\"userFirstName\">" + fname + "</span>");
			    $('#txtLastName').replaceWith("<span id=\"userLastName\">" + lname + "</span>");
			    $('#selectUserType').replaceWith("<span id=\"userRole\">" + userRole + "</span>");

			    if (data['registered'] == 1) {
				$('#valUserFormButton').replaceWith("<p id=\"valSuccess\">User Validation Successful.  However, it seems that an account has already been created for this user.  If you have forgotten your login, please contact your school's Athletic Director for assistance.</p>");
			    } else {
				$('#valUserFormButton').replaceWith("<p id=\"valSuccess\">User Validation Successful.  Proceed below to create your account.</p>");
				$('#hiddenID').val(id);
				$('#hiddenRole').val(userRole);
				$('#regUser').css("display", "inline");
			    }
			} else {
			    $("#result").text("User Validation Failed.  Please try again, or contact your school's Athletic Director for assistance.");
			    $("#validate, #reset").removeAttr("disabled");
			}
		    } else {
			$("#result").text(data['msg']);
			$("#validate, #reset").removeAttr("disabled");
		    }
		},
		error: function (jqXHR, textStatus, errorThrown) {
		    //console.log(jqXHR);
		    //console.log(textStatus);
		    //console.log(errorThrown);
		    $("#result").text("Oops - Something went wrong on our end.");
		}
	    });
	    $("#validate, #reset").removeAttr("disabled");
	}
    });

    $("#reset").click(function () {
	$("#valUser").validate().resetForm();
    });

    jQuery.validator.addMethod("tldEmail", function (value, element) {
	// include TLD check.
	return this.optional(element) || /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }, 'Please enter a valid email address.');

    $("#regUser").validate({
	rules: {
	    txtEmail: {
		required: true,
		email: true,
		tldEmail: true
	    },
	    txtUsername: {
		required: true,
		minlength: 5,
		maxlength: 30
	    },
	    txtPassword: {
		required: true,
		minlength: 5
	    },
	    txtPasswordAgain: {
		required: true,
		minlength: 5,
		equalTo: "#txtPassword"
	    }
	},
	messages: {
	    txtEmail: {
		required: "Please enter your email addresss",
		tldEmail: "Please enter a valid email address"
	    },
	    txtUsername: {
		required: "Please provide a username",
		minlength: "Your Username must consist of at least five characters",
		maxlength: "Your Username is too long - max 30 characters"
	    },
	    txtPassword: {
		required: "Please provide a password",
		minlength: "Your Password must be at least five characters"
	    },
	    txtPasswordAgain: {
		required: "Please provide a password",
		minlength: "Your Password must be at least five characters",
		equalTo: "Please enter the same password as above"
	    }
	}
    });

    $("#submitReg").click(function (e) {
	e.preventDefault();
	$("#result").text("");
	if ($("#regUser").valid()) {
	    $("#submitReg, #resetReg").attr("disabled", "disabled");
	    formData = ConvertFormToJSON("#regUser");
	    console.log("Data from form (to be sent): ", formData);
	    $.ajax({
		url: "phpinclude/db_regUser.php",
		type: "POST",
		dataType: "JSON",
		data: formData,
		success: function (data) {
		    console.log("Data returned from server: ", data);

		    if (data['status'] == "Success") {
			var email = formData['txtEmail'];
			var username = formData['txtUsername'];

			$('#txtEmail').replaceWith("<span id=\"userEmail\">" + email + "</span>");
			$('#txtUsername').replaceWith("<span id=\"userUsername\">" + username + "</span>");
			$('#txtPassword').replaceWith("<span id=\"userPassword\">(not shown)</span>");
			$('#retypePassword').remove();
			$('#regUserFormButton').replaceWith("<p id=\"regSuccess\">User Account Registration Successful.  You may now login to the system with the username and password that you provided earlier.</p>");
		    } else {
			$("#result").text(data['msg']);
			$("#submitReg, #resetReg").removeAttr("disabled");
		    }

		},
		error: function (jqXHR, textStatus, errorThrown) {
		    //console.log(jqXHR);
		    //console.log(textStatus);
		    //console.log(errorThrown);
		    $("#result").text("Oops - Something went wrong on our end.");
		    $("#submitReg, #resetReg").removeAttr("disabled");
		}
	    });
	    $("#submitReg, #resetReg").removeAttr("disabled");
	}
    });

    $("#resetReg").click(function () {
	$("#regUser").validate().resetForm();
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

}
);