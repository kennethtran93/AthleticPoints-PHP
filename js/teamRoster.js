/* 
 *  filename:       teamRoster.js
 */

$(document).ready(function () {
    if ($("#adminSelectID").length) {
	$("#btnRefresh").attr("disabled", "disabled");
	$("#adminSelectID").empty();
	$("#adminSelectID").removeAttr("disabled");
	$.ajax({
	    url: "/phpinclude/db_selectCoachID.php",
	    type: "GET",
	    dataType: "JSON",
	    data: {getCoachList: "true"},
	    success: function (result) {
		//console.log("Data returned from server: ", result);
		if (result['status'] == "Success") {
		    var studentList = result['list'];
		    if (result['count'] > 0) {
			$("#adminSelectID").append("<option value=\"\">--- Select Coach ---</option>");
			$.each(studentList, function (key, value) {
			    $("#adminSelectID").append("<option value=\"" + value['Coach_ID'] + "\">" + value['FullName'] + "</option>");
			});
		    } else {
			$("#adminSelectID").append("<option value=\"none\">There are currently no coaches in the system yet.  Add a new coach under Coach Management first.");
			$("#adminSelectID").attr("disabled", "disabled");
		    }
		} else {
		    $("#status").text(result['msg']);
		}
	    }
	});
    } else {
	$("#btnRefresh").attr("disabled", "disabled");
	refreshTeams();
	$("#btnRefresh").html("Refresh Teams  (available in 5 seconds)");
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams  (available in 4 seconds)");
	}, 1000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams  (available in 3 seconds)");
	}, 2000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams  (available in 2 seconds)");
	}, 3000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams  (available in 1 second)");
	}, 4000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams");
	    $("#btnRefresh").removeAttr("disabled");
	}, 5000);
    }

    $("#adminSelectID").change(function () {
	if ($(this).val() == "") {
	    $("#btnRefresh").attr("disabled", "disabled");
	    refreshTeams();
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
	refreshTeams();
	$("#btnRefresh").html("Refresh Teams (available in 5 seconds)");
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams  (available in 4 seconds)");
	}, 1000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams  (available in 3 seconds)");
	}, 2000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams  (available in 2 seconds)");
	}, 3000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams  (available in 1 second)");
	}, 4000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Teams");
	    $("#btnRefresh").removeAttr("disabled");
	}, 5000);

    });

    $("table#teamList").on("click", "button", function () {
	$("#status").empty();
	//console.log(this.id);
	var selectTeamID = (this.id).substr(12);
	//console.log(selectTeamID);
	loadTeammates(selectTeamID);
    });


    $("form#pointSubmit").on("click", "input", function (e) {
	if ((this.id).search(/submitPoints/i) > -1) {
	    e.preventDefault();
	    formData = ConvertFormToJSON("#pointSubmit");
	    //console.log(formData);
	    //console.log({teamid: formData['teamid'], json: formData});
	    $.ajax({
		url: "/phpinclude/db_submitPoints.php",
		type: "POST",
		dataType: "JSON",
		data: formData,
		success: function (result) {
		    console.log("Data returned from server: ", result);
		    $("#status").html(result['msg']);

		}
	    });

	}
    });
});

function refreshTeams() {
    $("#teamList, #status").empty();
    $("#teamList").append("<tr><td>Loading Data...</td></tr>");
    //console.log($("#adminSelectID").val());
    $.ajax({
	url: "/phpinclude/db_getTeamList.php",
	type: "GET",
	dataType: "JSON",
	data: {getReport: "true", CoachID: $("#adminSelectID").val()},
	success: function (result) {
	    $("#teamList").empty();
	    //console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		var myteams = result['teams'];
		if (result['count'] > 0) {
		    $("#teamList").append("<thead><tr><th></th><th>Season</th><th>Sport</th><th>Division</th><th>Team Subset</th></tr></thead><tbody></tbody>");
		    $.each(myteams, function (key, value) {
			$("#teamList tbody").append("<tr><td><button type=\"button\" id=\"selectTeamID" + value['Team_ID'] + "\" name=\"selectTeamID" + value['Team_ID'] + "\" class=\"selectTeam\" value=\"" + value['Team_ID'] + "\">Show Roster</button></td><td>" + value['Season_Description'] + "</td><td>" + value['Sport'] + "</td><td>" + value['DivisionName'] + "</td><td>" + (value['TeamSubset'] || "") + "</td></tr>");
		    });
		} else {
		    $("#teamList").append("<tr><td><i>We currently have no records of your team enrollments to date.</i></td></tr>");
		}
	    } else {
		$("#status").text(result['msg']);
	    }
	}
    });
    var date = new Date();
    $("#generated").text(date);
}

function loadTeammates(teamid) {
    $("#athletes, #status").empty();
    $("#athletes").append("<tr><td>Loading Data...</td></tr>");
    $.ajax({
	url: "/phpinclude/db_TeamRosterInfo.php",
	type: "GET",
	dataType: "JSON",
	data: {getTeammates: "true", teamid: teamid},
	success: function (result) {
	    $("#athletes").empty();
	    //console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		var athletes = result['names'];
		if (result['count'] > 0) {
		    $("#athletes").append("<thead><tr><th class=\"control\"></th><th class=\"all\">First Name</th><th class=\"all\">Last Name</th><th>Student No</th><th class=\"min-tablet\">Team Points</th><th class=\"min-tablet\">Bonus Points</th><th class=\"none\"></th></tr></thead><tfoot><tr><th></th><th>First Name</th><th>Last Name</th><th>Student No</th><th>Team Points</th><th>Bonus Points</th><th></th></tr></tfoot><tbody></tbody>");
		    $.each(athletes, function (key, value) {
			$("#athletes tbody").append("<tr><td></td><td>" + value['S_FirstName'] + "</td><td>" + value['S_LastName'] + "</td><td>" + value['StudentNo'] + "</td><td><input id=\"t" + value["StudentNo"] + "\" name=\"t" + value["StudentNo"] + "\" type=\"text\" class=\"textbox\" maxlength=\"3\" value=\"" + parseFloat(value["Point_Team"]) + "\"/></td><td><input id=\"b" + value["StudentNo"] + "\" name=\"b" + value["StudentNo"] + "\" type=\"text\" class=\"textbox\" maxlength=\"1\" value=\"" + value["Point_Bonus"] + "\"/></td></tr>");
		    });
		    $("#pointFormButtons").html("<input id=\"teamid\" name=\"teamid\" type=\"hidden\" value=\"" + teamid + "\" /><input id=\"submitPoints" + teamid + "\" type=\"submit\" value=\"Submit / Update Points\" class=\"button\" /><input id=\"resetPoints\" type=\"reset\" value=\"Reset Form\" />");
		} else {
		    $("#athletes").append("<tr><td><i>Sorry, we couldn't get the team roster at the moment.  Please try again later.</i></td></tr>");
		}
	    } else {
		$("#status").text(result['msg']);
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