<?php
/*
 *  filename:       TeamRoster.php
 */

$thisPage = "Coach Team Roster";
$AuthRoles = ["admin", "coach"];
$addScript = ["https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js", "https://cdn.datatables.net/responsive/1.0.6/js/dataTables.responsive.min.js", "https://cdn.datatables.net/fixedheader/2.1.2/js/dataTables.fixedHeader.min.js", "https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js", "teamRoster.js"];
$addCSS = ["TeamRoster.css"];
include_once('../phpinclude/load.php');
?>
<!-- Insert Page Content Below -->
<h1>Team Roster</h1>
<p>Here are the teams that you are coaching.
    To see the list of team members, please click on <i>Show Names</i> button.</p>
<p>This team list was generated:  <span id="generated"></span></p>
<?php
if (isset($_SESSION['Group']) && !empty($_SESSION['Group']) && ($_SESSION['Group'] == "Admin")) {
    echo "<select id=\"adminSelectID\"></select>";
}
?>
<button type="button" id="btnRefresh">Refresh Teams</button>

<table id="teamList"></table>
<br />

<form id='pointSubmit'>
<table id="athletes" class='display responsive'></table>
<div id='pointFormButtons'></div>
</form>

<p id="status"></p>

<!-- Insert Page Content Above -->
<?php
include_once('../phpinclude/sidebar.php');
include_once('../phpinclude/footer.php');
?>