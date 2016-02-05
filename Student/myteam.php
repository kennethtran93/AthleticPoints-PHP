<?php
/*
 *  filename:       myteam.php
 */

$thisPage = "My Team";
$AuthRoles = ["student", "admin"];
$addCSS = ["MyTeam.css"];
$addScript = ['myteam.js'];
include_once('../phpinclude/load.php');
?>
<!-- Insert Page Content Below -->
<h1>View My Enrolled Team</h1>
<p>You are currently enrolled in the team(s) below.
    <br/>
    To see the list of team members, please click on <i>Show TeamMate</i> button.</p>
<p>This team list was generated:  <span id="generated"></span></p>
<?php
if (isset($_SESSION['Group']) && !empty($_SESSION['Group']) && ($_SESSION['Group'] == "Admin")) {
    echo "<select id=\"adminSelectID\"></select>";
}
?>
<button type="button" id="btnRefresh">Refresh Teams</button>

<table id="teamList"></table>
<br />

<table id="teammates"></table>

<p id="status"></p>

<!-- Insert Page Content Above -->
<?php
include_once('../phpinclude/sidebar.php');
include_once('../phpinclude/footer.php');
?>