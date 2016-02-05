/*
 *  filename:       TeamDirectory.js
 */

$(document).ready(function () {
    $("#viewCoach").hide();

    $("table#teamDirectory").on("click", "button", function () {
	$("#status").empty();
	console.log(this.id);
	var selectTeamID = (this.id).substr(12);
	console.log(selectTeamID);
	loadTeamCoach(selectTeamID);
    });


});

function loadTeamCoach(teamid) {
    $("#errors").empty();
    $.ajax({
	url: "/phpinclude/db_teamDirectory.php",
	type: "GET",
	dataType: "JSON",
	data: {getData: "true", tid: teamid},
	success: function (result) {
	    console.log("Data returned from server: ", result);
	    if (result['status'] == "Success") {
		$("#viewCoach").show();
		$("#errors").empty();
		var coach = result['coach'];
		console.log(coach);
		$("#viewCoach").dataTable({
		    destroy: true,
		    processing: true,
		    responsive: {
			details: {
			    type: 'column',
			    target: 'tr'
			}
		    },
		    data: coach,
		    columns: [
			{
			    className: "control",
			    data: "control",
			    orderable: false
			},
			{
			    data: "Name",
			    orderData: [1]
			},
			{
			    data: "Type"
			},
			{
			    data: "C_Email"
			},
			{
			    data: "C_WorkNumber"
			}
		    ],
		    order: [1, 'asc']
		});

	    } else {
		$("#errors").text(result['msg']);
	    }
	}
    });
}