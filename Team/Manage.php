<?php
/*
 *  filename:       Manage.php
 */

$thisPage = "Manage Teams";
$AuthRoles = ["admin", "coach"];
$addScript = ["team_manage.js"];
include_once('../phpinclude/load.php');
?>
<!-- Insert Page Content Below -->
<h1>Team Management</h1>
<p><a href="Create.php">Create New Team</a></p>
<p>This is an optional feature that has yet to be implemented.  We know it's somewhat important, and noted in some personas, but we did not include this as part of the project's user stories.</p>

<!--<p>Select Existing Team below to manage.</p>
<p>This team list was generated:  <span id="generated"></span></p>

<button type="button" id="btnRefresh">Refresh Teams</button>

<table id="teamList"></table>
<br />

<table id="athletes"></table>

<p id="status"></p>-->

<!-- Insert Page Content Above -->
<?php
include_once('../phpinclude/sidebar.php');
include_once('../phpinclude/footer.php');
?>