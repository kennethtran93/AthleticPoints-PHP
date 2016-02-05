<?php
/*
 *  filename:       Report_Points.php
 */

$thisPage = "Athletic Point Summary";
$AuthRoles = ["admin"];
$addScript = ["Report_Points.js"];
include_once('../phpinclude/load.php');
?>
<!-- Insert Page Content Below -->
<h1>Athletic Points Summary</h1>
<p>This report was generated:  <span id="generated"></span></p>
<button type="button" id="btnRefresh">Refresh Report</button>
<br />
<h5>Small T Recipients (30 ~ 44 Points)</h5>
<table id="smallT">
</table>

<h5>Big T Recipients (45 ~ 59 Points)</h5>
<table id="bigT">
</table>

<h5>Silver Medallion Recipients (60 ~ 74 Points)</h5>
<table id="silverMedallion">
</table>

<h5>Gold Medallion Recipients (75+ Points)</h5>
<table id="goldMedallion">
</table>
<div id="report_points">
</div>
<!-- Insert Page Content Above -->
<?php
include_once('../phpinclude/sidebar.php');
include_once('../phpinclude/footer.php');
?>