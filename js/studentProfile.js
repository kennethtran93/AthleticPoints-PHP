/* 
 *  filename:       studentProfile.js
 */

$(document).ready(function () {
    if ($("#adminSelectID").length) {
	$("#btnRefresh").attr("disabled", "disabled");
	$("#adminSelectID").empty();
	$("#adminSelectID").removeAttr("disabled");
	$.ajax({
	    url: "/phpinclude/db_selectStudentID.php",
	    type: "GET",
	    dataType: "JSON",
	    data: {getStudentList: "true"},
	    success: function (result) {
		//console.log("Data returned from server: ", result);
		if (result['status'] == "Success") {
		    var studentList = result['list'];
		    if (result['count'] > 0) {
			$("#adminSelectID").append("<option value=\"\">--- Select Student ---</option>");
			$.each(studentList, function (key, value) {
			    $("#adminSelectID").append("<option value=\"" + value['StudentNo'] + "\">" + value['FullName'] + "</option>");
			});
		    } else {
			$("#adminSelectID").append("<option value=\"none\">There are currently no students in the system yet.  Add a new student under Student Management first.");
			$("#adminSelectID").attr("disabled", "disabled");
		    }
		} else {
		    $("#profileResult").text(result['msg']);
		}
	    }
	});

    } else {
	$("#btnRefresh").attr("disabled", "disabled");
	getStudent();
	$("#btnRefresh").html("Refresh Profile  (available in 5 seconds)");
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile  (available in 4 seconds)");
	}, 1000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile  (available in 3 seconds)");
	}, 2000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile  (available in 2 seconds)");
	}, 3000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile  (available in 1 second)");
	}, 4000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile");
	    $("#btnRefresh").removeAttr("disabled");
	}, 5000);
    }

    $("#adminSelectID").change(function () {
	if ($(this).val() == "") {
	    $("#btnRefresh").attr("disabled", "disabled");
	    getStudent();
	} else {
	    $("#adminSelectID").attr("disabled", "disabled");
	    $("#btnRefresh").click();
	    setTimeout(function () {
		$("#adminSelectID").removeAttr("disabled");
	    }, 5000);
	}
    });

    $("#btnRefresh").click(function () {
	$("#btnRefresh").attr("disabled", "disabled");
	getStudent();
	$("#btnRefresh").html("Refresh Profile (available in 5 seconds)");
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile  (available in 4 seconds)");
	}, 1000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile  (available in 3 seconds)");
	}, 2000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile  (available in 2 seconds)");
	}, 3000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile  (available in 1 second)");
	}, 4000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Profile");
	    $("#btnRefresh").removeAttr("disabled");
	}, 5000);

    });
    
    $("#submitStudent").click(function(e) {
	e.preventDefault();
	updateStudent();
    });
});

function getStudent() {
    $("#studentNo, #firstName, #lastName, #homeroom, #gender, #DOB, #email, #mobileNumber, #homeNumber, #profileResult").empty();
    $("#profileResult").text("Loading Data...");
    //console.log($("#adminSelectID").val());
    $.ajax({
	url: "/phpinclude/db_studentMgmt.php",
	type: "GET",
	dataType: "JSON",
	data: {getStudent: "true", StudentID: $("#adminSelectID").val()},
	success: function (result) {
	    $("#studentNo, #firstName, #lastName, #homeroom, #gender, #DOB, #email, #mobileNumber, #homeNumber, #profileResult").empty();
	    console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		var studentProfile = result['profile'];
		$("#oldStudentNumber").val(studentProfile['studentNo']);
		$.each(studentProfile, function (key, value) {
		    // Should only work on span elements
		    $("#" + key).text(value);
		    // Should only work with input elements
		    $("#" + key).val(value);
		});
	    } else {
		$("#profileResult").text(result['msg']);
	    }
	}
    });
    var date = new Date();
    $("#generated").text(date);
}

function updateStudent() {
    $("#profileResult").empty();
    $("#profileResult").text("Updating Data...");
    formData = ConvertFormToJSON("#studentProfile");
    console.log("Data from form (to be sent): ", formData);
    $.ajax({
	url: "/phpinclude/db_studentMgmt.php",
	type: "POST",
	dataType: "JSON",
	data: formData,
	success: function (result) {
	    console.log("Data returned from server: ", result);
	    $("#profileResult").text(result['msg']);
	}
    });
}

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