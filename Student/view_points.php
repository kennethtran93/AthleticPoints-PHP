<?php
/*
 *  filename:       view_points.php
 */

$thisPage = "View Student Points";
$AuthRoles = ["admin", "student"];
$addScript = ["StudentPoints.js"];
$addCSS = ["view_points.css"];
include_once('../phpinclude/load.php');
?>
<!-- Insert Page Content Below -->
<h1>View Accumulated Points</h1>
<p>This report was generated:  <span id="generated"></span></p>
<?php
if (isset($_SESSION['Group']) && !empty($_SESSION['Group']) && ($_SESSION['Group'] == "Admin")) {
    echo "<select id=\"adminSelectID\"></select>";
}
?>
<button type="button" id="btnRefresh">Refresh Points</button>
<br />
<table id="studentPointsList"></table>
<br />
<table id="minPoints">
    <thead>
	<tr>
	    <th>Minimum Points Needed</th>
	    <th>Name of Point Award</th>
	</tr>
    </thead>
    <tbody>
	<?php
	$stmt = $conn->prepare("SELECT * FROM Point_Award ORDER BY MinPointNeeded");
	$stmt->execute();

	foreach ($stmt->fetchAll() as $r) {
	    echo "<tr><td>" . $r['MinPointNeeded'] . "</td><td>" . $r['Point_AwardName'] . "</td></tr>" . PHP_EOL;
	}
	?>
    </tbody>
</table>
<br />
<div id="report_points">
</div>

<!--Insert Page Content Above -->
<?php
include_once('../phpinclude/sidebar.php');
include_once('../phpinclude/footer.php');
?>