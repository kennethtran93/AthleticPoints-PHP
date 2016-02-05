<?php
/*
 *  filename:       contact.php
 */

$thisPage = "Contact Us";
include_once('phpinclude/load.php');
?>
<!-- Insert Page Content Below -->

<h1>Contact Us</h1>
<p>For assistance, please contact one of the following:</p>
<?php
$stmt = $conn->prepare("SELECT Name, Email, Phone, Notes FROM AdminProfile WHERE PublicDisplay = 1 ORDER BY DisplayOrder ASC");
$stmt->execute();

$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
foreach ($stmt->fetchAll() as $r) {
    echo "<table>";
    echo "<tr><td>Name:&nbsp;&nbsp;</td><td>" . $r['Name'] . "</td></tr>";
    echo "<tr><td>Email:&nbsp;&nbsp;</td><td>" . ($r['Email'] == "" ? "<i>none provided</i>" : $r['Email']) . "</td></tr>";
    echo "<tr><td>Phone:&nbsp;&nbsp;</td><td>" . ($r['Phone'] == "" ? "<i>none provided</i>" : $r['Phone']) . "</td></tr>";
    echo "<tr><td>Notes:&nbsp;&nbsp;</td><td>" . ($r['Notes'] == "" ? "<i>none provided</i>" : $r['Notes']) . "</td></tr>";
    echo "</table><br/>";
}
?>

<!-- Insert Page Content Above -->
<?php
include_once('phpinclude/sidebar.php');
include_once('phpinclude/footer.php');
?>