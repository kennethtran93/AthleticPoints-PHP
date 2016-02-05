/* 
 *  filename:       myteam.js
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
});

function refreshTeams() {
    $("#teamList, #status").empty();
    $("#teamList").append("<tr><td>Loading Data...</td></tr>");
    //console.log($("#adminSelectID").val());
    $.ajax({
	url: "/phpinclude/db_getTeamList.php",
	type: "GET",
	dataType: "JSON",
	data: {getReport: "true", StudentID: $("#adminSelectID").val()},
	success: function (result) {
	    $("#teamList").empty();
	    //console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		var myteams = result['teams'];
		if (result['count'] > 0) {
		    $("#teamList").append("<thead><tr><th></th><th>Season</th><th>Sport</th><th>Division</th><th>Team Subset</th></tr></thead><tbody></tbody>");
		    $.each(myteams, function (key, value) {
			$("#teamList tbody").append("<tr><td><button type=\"button\" id=\"selectTeamID" + value['Team_ID'] + "\" name=\"selectTeamID" + value['Team_ID'] + "\" class=\"selectTeam\" value=\"" + value['Team_ID'] + "\">Show TeamMates</button></td><td>" + value['Season_Description'] + "</td><td>" + value['Sport'] + "</td><td>" + value['DivisionName'] + "</td><td>" + (value['TeamSubset'] || "") + "</td></tr>");
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
    $("#teammates, #status").empty();
    $("#teammates").append("<tr><td>Loading Data...</td></tr>");
    $.ajax({
	url: "/phpinclude/db_getTeamStudentNames.php",
	type: "GET",
	dataType: "JSON",
	data: {getTeammates: "true", teamid: teamid},
	success: function (result) {
	    $("#teammates").empty();
	    //console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		var teammates = result['names'];
		if (result['count'] > 0) {
		    $("#teammates").append("<thead><tr><th>First Name</th><th>Last Name</th></tr></thead><tbody></tbody>");
		    $.each(teammates, function (key, value) {
			$("#teammates tbody").append("<tr><td>" + value['S_FirstName'] + "</td><td>" + value['S_LastName'] + "</td></tr>");
		    });
		} else {
		    $("#teammates").append("<tr><td><i>Sorry, we couldn't get your teammates' names at the moment.  Please try again later.</i></td></tr>");
		}
	    } else {
		$("#status").text(result['msg']);
	    }
	}
    });

    var date = new Date();
    $("#generated").text(date);
}
