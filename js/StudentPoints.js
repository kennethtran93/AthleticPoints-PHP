/* 
 *  filename:       StudentPoints.js
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
		    $("#report_points").text(result['msg']);
		}
	    }
	});
    } else {
	$("#btnRefresh").attr("disabled", "disabled");
	refreshPoints();
	$("#btnRefresh").html("Refresh Points  (available in 5 seconds)");
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points  (available in 4 seconds)");
	}, 1000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points  (available in 3 seconds)");
	}, 2000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points  (available in 2 seconds)");
	}, 3000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points  (available in 1 second)");
	}, 4000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points");
	    $("#btnRefresh").removeAttr("disabled");
	}, 5000);
    }

    $("#adminSelectID").change(function () {
	if ($(this).val() == "") {
	    $("#btnRefresh").attr("disabled", "disabled");
	    refreshPoints();
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
	refreshPoints();
	$("#btnRefresh").html("Refresh Points (available in 5 seconds)");
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points  (available in 4 seconds)");
	}, 1000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points  (available in 3 seconds)");
	}, 2000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points  (available in 2 seconds)");
	}, 3000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points  (available in 1 second)");
	}, 4000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Points");
	    $("#btnRefresh").removeAttr("disabled");
	}, 5000);

    });
});

function refreshPoints() {
    $("#studentPointsList, #report_points").empty();
    $(".sumPoints").remove();
    $("#studentPointsList").append("<tr><td>Loading Data...</td></tr>");
    //console.log($("#adminSelectID").val());
    $.ajax({
	url: "/phpinclude/db_pointsStudent.php",
	type: "GET",
	dataType: "JSON",
	data: {getReport: "true", StudentID: $("#adminSelectID").val()},
	success: function (result) {
	    $("#studentPointsList").empty();
	    //console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		var studentPoints = result['points'];
		if (result['count'] > 0) {
		    $("#studentPointsList").before("<p class=\"sumPoints\">Total Points Accumulated to date:  <b>" + parseFloat(result['sumPoints']) + "</b></p>");
		    $("#studentPointsList").append("<thead><tr><th>Season</th><th>Sport</th><th>Division</th><th>Team Subset</th><th>Team Points</th><th>Bonus Points</th><th>Total</th></tr></thead><tbody></tbody>");
		    $.each(studentPoints, function (key, value) {
			$("#studentPointsList tbody").append("<tr><td>" + value['Season_Description'] + "</td><td>" + value['Sport'] + "</td><td>" + value['DivisionName'] + "</td><td>" + (value['TeamSubset'] || "") + "</td><td>" + parseFloat(value['Point_Team']) + "</td><td>" + parseFloat(value['Point_Bonus']) + "</td><td>" + parseFloat(value['SumPoints']) + "</td></tr>");
		    });
		    $("#studentPointsList").after("<p class=\"sumPoints\">Total Points Accumulated to date:  <b>" + parseFloat(result['sumPoints']) + "</b></p>");
		} else {
		    $("#studentPointsList").append("<tr><td><i>We currently have no records of your earned points to date.</i></td></tr>");
		}
	    } else {
		$("#report_points").text(result['msg']);
	    }
	}
    });
    var date = new Date();
    $("#generated").text(date);
}
