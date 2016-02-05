<?php
/*
 *  filename:       TeamDirectory.php
 */

$thisPage = "Team Directory";
$addScript = ["https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js", "https://cdn.datatables.net/responsive/1.0.6/js/dataTables.responsive.min.js", "https://cdn.datatables.net/fixedheader/2.1.2/js/dataTables.fixedHeader.min.js", "TeamDirectory.js"];
$addCSS = ["https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css", "https://cdn.datatables.net/responsive/1.0.6/css/dataTables.responsive.css", "https://cdn.datatables.net/fixedheader/2.1.2/css/dataTables.fixedHeader.css", "TeamDirectory.css"];
include_once('phpinclude/load.php');
?>
<!-- Insert Page Content Below -->

<h1>Team Directory</h1>
<form>
    <?php
    $stmt = $conn->prepare('SELECT Team_ID, Season_Description, Sport, DivisionName, TeamSubset FROM team t JOIN sport s ON t.Sport_ID = s.Sport_ID JOIN season se ON t.Season_ID = se.Season_ID');
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo "<table id=\"teamDirectory\">";
    echo "<thead><tr><th></th><th>Season</th><th>Sport</th><th>Division</th><th>Team Subset</th></tr></thead>";
    echo "<tbody>";
    foreach ($stmt->fetchAll() as $r) {
        echo "<tr><td><button type=\"button\" id=\"selectTeamID" . $r['Team_ID'] . "\" name=\"selectTeamID" . $r['Team_ID'] . "\" class=\"selectTeam\" value=\"" . $r['Team_ID'] . " \">Show Coaches</button></td>";
        echo "<td>" . $r['Season_Description'] . "</td>";
        echo "<td>" . $r['Sport'] . "</td>";
        echo "<td>" . $r['DivisionName'] . "</td>";
        echo "<td>" . ($r['TeamSubset'] == "" ? "" : $r['TeamSubset']) . "</td></tr>";
    }
    echo "</tbody>";
    echo "</table><br/>";
    ?>
</form>
<table id="viewCoach" class="display responsive">
    <thead>
	<tr>
	    <th class="control"></th>
	    <th class="all">Coach Name</th>
	    <th>Coach Type</th>
	    <th>Email</th>
	    <th>Phone Number</th>
	</tr>
    </thead>
    <tfoot>
	<tr>
	    <th></th>
	    <th>Coach Name</th>
	    <th>Coach Type</th>
	    <th>Email</th>
	    <th>Phone Number</th>
	</tr>
    </tfoot>
</table>
<p id="errors"></p>

<!-- Insert Page Content Above -->
<?php
include_once('phpinclude/sidebar.php');
include_once('phpinclude/footer.php');
?>
