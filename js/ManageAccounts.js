/* 
 *  filename:       ManageAccount.js
 */

$(document).ready(function () {
    $("#editUser").validate({
	rules: {
	    editUsername: {
		minlength: 5,
		maxlength: 30
	    },
	    editPassword: {
		minlength: 5
	    }
	},
	messages: {
	    editUsername: {
		minlength: "Username too short",
		maxlength: "Username too long"
	    },
	    editPassword: {
		minlength: "Password too short"
	    }
	}
    });

    $("#editUser").hide();
    $("#btnRefresh").attr("disabled", "disabled");
    $("#adminSelectGroup").empty();
    $("#adminSelectGroup").removeAttr("disabled");
    $.ajax({
	url: "/phpinclude/db_selectUserGroup.php",
	type: "GET",
	dataType: "JSON",
	data: {getUserGroup: "true"},
	success: function (result) {
	    //console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		var groups = result['groups'];
		$.each(groups, function (key, value) {
		    $("#adminSelectGroup").append("<option value=\"" + value['RoleID'] + "\">" + value['GroupName'] + "</option>");
		});
		$("#adminSelectGroup").val("1");
		$("#btnRefresh").removeAttr("disabled");
		$("#btnRefresh").click();
	    } else {
		$("#errors").text(result['msg']);
	    }
	}
    });
    $("#btnRefresh").removeAttr("disabled");
    $("#adminSelectGroup").val("1");
    $("#btnRefresh").click();

    $("#adminSelectGroup").change(function () {
	$("#adminSelectGroup").attr("disabled", "disabled");
	$("#btnRefresh").click();
	$("#adminSelectGroup").removeAttr("disabled");

    });

    $("#btnRefresh").click(function () {
	$("#editUser").hide();
	$("#btnRefresh").attr("disabled", "disabled");
	loadAccounts();
	$("#btnRefresh").removeAttr("disabled");
    });

    $("#adminSelectGroup").val("1");
    $("#btnRefresh").click();

    $("table#userAccounts").on("click", "button", function () {
	$("#resetEdit").click();
	$(this).text("Edit Account - Scroll Down");
	$("#error, #editStatus").empty();
	var user = (this.id).split("_");
	$("#oldUsername").val(user[1]);
	if (user[2] == 1) {
	    $("#editAccess").prop("checked", true);
	} else {
	    $("#editAccess").removeProp("checked");
	}
	$("#editingUser").html("Editing User Account Data for:  <b>" + user[3] + " " + user[4] + "</b>");
	$("#fullName").val(user[3] + " " + user [4]);
	$("#editUsername").val("");
	$("#editPassword").val("");
	$("#editUser").show();
    });

    $("#editAccount").click(function (e) {
	e.preventDefault();
	$("#errors, #editStatus").empty();
	if ($("#editUser").valid()) {
	    $("#editAccount, #resetEdit").attr("disabled", "disabled");
	    formData = ConvertFormToJSON("#editUser");
	    console.log("Data from form (to be sent): ", formData);
	    $.ajax({
		url: "/phpinclude/db_editAccount.php",
		type: "POST",
		dataType: "JSON",
		data: formData,
		success: function (response) {
		    console.log("Data returned from server: ", response);

		    if (response['status'] == "Success") {
			$("#editStatus").text(response['msg']);
			$("#editUsername").val("");
			$("#editPassword").val("");
			$("#editAccess").removeProp("checked");
			$("#editUser").hide();
			$("#btnRefresh").click();
		    } else {
			$("#errors").html(response['msg']);
			$("#editAccount, #resetEdit").removeAttr("disabled");
		    }

		},
		error: function (jqXHR, textStatus, errorThrown) {
		    //console.log(jqXHR);
		    //console.log(textStatus);
		    //console.log(errorThrown);
		    $("#errors").text("Oops - Something went wrong on our end.");
		    $("#editAccount, #resetEdit").removeAttr("disabled");
		}
	    });
	    $("#editAccount, #resetEdit").removeAttr("disabled");
	}
    });

    $("#hideFormEdit").click(function () {
	$("#editUser").hide();
    });

});

function loadAccounts() {
    $("#errors").empty();
    $("#errors").text("Loading Data...");
    $.ajax({
	url: "/phpinclude/db_userAccounts.php",
	type: "GET",
	dataType: "JSON",
	data: {getData: "true", group: $("#adminSelectGroup").val()},
	success: function (result) {
	    //console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		$("#errors").empty();

		var accounts = result['accounts'];
		console.log(accounts);

		$("#userAccounts").dataTable({
		    destroy: true,
		    processing: true,
		    responsive: {
			details: {
			    type: 'column',
			    target: 'tr'
			}
		    },
		    data: accounts,
		    columns: [
			{
			    className: "control",
			    data: "control",
			    orderable: false
			},
			{
			    data: "LastName",
			    orderData: [1, 2, 3]
			},
			{
			    data: "FirstName",
			    orderData: [2, 1, 3]
			},
			{
			    data: "ID",
			    type: "num"
			},
			{
			    data: "Username"
			},
			{
			    data: "GrantAccess",
			    className: "dt-center"
			},
			{
			    data: "DateRegistered",
			    type: "date"
			},
			{
			    data: "LastUpdated",
			    type: "date"
			},
			{
			    data: null,
			    orderable: false,
			    render: function (data, type, row, meta) {
				return "<button id=\"edit_" + row["Username"] + "_" + row["GrantAccess"] + "_" + row["FirstName"] + "_" + row["LastName"] + "\" class=\"button\" type=\"button\">Edit Account</button>";
			    }
			}
		    ],
		    order: [1, 'asc']
		});
	    } else {
		$("#errors").text(result['msg']);
	    }
	}
    });
    var date = new Date();
    $("#generated").text(date);
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