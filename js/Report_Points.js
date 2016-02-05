/* 
 *  filename:       Report_Points.js
 */

$(document).ready(function () {
    $("#btnRefresh").attr("disabled", "disabled");
    refreshPoints();
    $("#btnRefresh").html("Refresh Report  (available in 3 seconds)");
    setTimeout(function () {
	$("#btnRefresh").html("Refresh Report  (available in 2 seconds)");
    }, 1000);
    setTimeout(function () {
	$("#btnRefresh").html("Refresh Report  (available in 1 second)");
    }, 2000);
    setTimeout(function () {
	$("#btnRefresh").html("Refresh Report");
	$("#btnRefresh").removeAttr("disabled");
    }, 3000);

    $("#btnRefresh").click(function () {
	$("#btnRefresh").attr("disabled", "disabled");
	refreshPoints();
	$("#btnRefresh").html("Refresh Report (available in 3 seconds)");
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Report (available in 2 seconds)");
	}, 1000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Report (available in 1 second)");
	}, 2000);
	setTimeout(function () {
	    $("#btnRefresh").html("Refresh Report");
	    $("#btnRefresh").removeAttr("disabled");
	}, 3000);

    });
});

function refreshPoints() {
    $("#smallT, #bigT, #silverMedallion, #goldMedallion, #report_points").empty();
    $(".sumAward").remove();
    $("#smallT, #bigT, #silverMedallion, #goldMedallion").append("<tr><td>Loading Data...</td></tr>");

    $.ajax({
	url: "/phpinclude/db_pointsReport.php",
	type: "GET",
	dataType: "JSON",
	data: {getReport: "true"},
	success: function (data) {
	    $("#smallT, #bigT, #silverMedallion, #goldMedallion").empty();
	    //console.log("Data returned from server: ", data);
	    if (data['status'] == "Success") {
		var smallT = data['smallT'];
		var bigT = data['bigT'];
		var silverM = data['silverM'];
		var goldM = data['goldM'];
		if (data['smallTcount'] > 0) {
		    $("#smallT").before("<p class=\"sumAward\">Total Athletes for Small T award:  <b>" + data['smallTcount'] + "</b></p>");
		    $("#smallT").append("<thead><tr><th>Student No</th><th>Last Name</th><th>First Name</th><th>Homeroom</th><th>Gender</th><th>Total Points</th></tr></thead><tbody></tbody>");
		    $.each(smallT, function (key, value) {
			$("#smallT tbody").append("<tr><td>" + value['StudentNo'] + "</td><td>" + value['LastName'] + "</td><td>" + value['FirstName'] + "</td><td>" + value['Homeroom'] + "</td><td>" + value['Gender'] + "</td><td>" + parseFloat(value['SumPoints']) + "</td></tr>");
		    });
		    $("#smallT").after("<p class=\"sumAward\">Total Athletes for Small T award:  <b>" + data['smallTcount'] + "</b></p>");
		} else {
		    $("#smallT").append("<tr><td><i>No Athletes have reached this milestone yet.</i></td></tr>");
		}
		if (data['bigTcount'] > 0) {
		    $("#bigT").before("<p class=\"sumAward\">Total Athletes for Big T award:  <b>" + data['bigTcount'] + "</b></p>");
		    $("#bigT").append("<thead><tr><th>Student No</th><th>Last Name</th><th>First Name</th><th>Homeroom</th><th>Gender</th><th>Total Points</th></tr></thead><tbody></tbody>");
		    $.each(bigT, function (key, value) {
			$("#bigT tbody").append("<tr><td>" + value['StudentNo'] + "</td><td>" + value['LastName'] + "</td><td>" + value['FirstName'] + "</td><td>" + value['Homeroom'] + "</td><td>" + value['Gender'] + "</td><td>" + parseFloat(value['SumPoints']) + "</td></tr>");
		    });
		    $("#bigT").after("<p class=\"sumAward\">Total Athletes for Big T award:  <b>" + data['bigTcount'] + "</b></p>");
		} else {
		    $("#bigT").append("<tr><td><i>No Athletes have reached this milestone yet.</i></td></tr>");
		}
		if (data['silverMcount'] > 0) {
		    $("#silverMedallion").before("<p class=\"sumAward\">Total Athletes for Silver Medallion award:  <b>" + data['silverMcount'] + "</b></p>");
		    $("#silverMedallion").append("<thead><tr><th>Student No</th><th>Last Name</th><th>First Name</th><th>Homeroom</th><th>Gender</th><th>Total Points</th></tr></thead><tbody></tbody>");
		    $.each(silverM, function (key, value) {
			$("#silverMedallion tbody").append("<tr><td>" + value['StudentNo'] + "</td><td>" + value['LastName'] + "</td><td>" + value['FirstName'] + "</td><td>" + value['Homeroom'] + "</td><td>" + value['Gender'] + "</td><td>" + parseFloat(value['SumPoints']) + "</td></tr>");
		    });
		    $("#silverMedallion").after("<p class=\"sumAward\">Total Athletes for Silver Medallion award:  <b>" + data['silverMcount'] + "</b></p>");
		} else {
		    $("#silverMedallion").append("<tr><td><i>No Athletes have reached this milestone yet.</i></td></tr>");
		}
		if (data['goldMcount'] > 0) {
		    $("#goldMedallion").before("<p class=\"sumAward\">Total Athletes for Gold Medallion award:  <b>" + data['goldMcount'] + "</b></p>");
		    $("#goldMedallion").append("<thead><tr><th>Student No</th><th>Last Name</th><th>First Name</th><th>Homeroom</th><th>Gender</th><th>Total Points</th></tr></thead><tbody></tbody>");
		    $.each(goldM, function (key, value) {
			$("#goldMedallion tbody").append("<tr><td>" + value['StudentNo'] + "</td><td>" + value['LastName'] + "</td><td>" + value['FirstName'] + "</td><td>" + value['Homeroom'] + "</td><td>" + value['Gender'] + "</td><td>" + parseFloat(value['SumPoints']) + "</td></tr>");
		    });
		    $("#goldMedallion").after("<p class=\"sumAward\">Total Athletes for Gold Medallion award:  <b>" + data['goldMcount'] + "</b></p>");
		} else {
		    $("#goldMedallion").append("<tr><td><i>No Athletes have reached this milestone yet.</i></td></tr>");
		}
	    } else {
		$("#report_points").text(data['msg']);
	    }
	}
    });
    var date = new Date();
    $("#generated").text(date);
}
