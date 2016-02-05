<?php
/*
 *  filename:       index.php
 */

$thisPage = "Welcome!";
include_once('phpinclude/load.php');
?>
<!-- Insert Page Content Below -->

<h1>Welcome to Project SAMS</h1>
<i><b><u>S</u></b>chool <b><u>A</u></b>thletic <b><u>M</u></b>anagement <b><u>S</u></b>ystem</i>
<?php if ($NavRole == "admin") : ?>
    <h2>Administrative News</h2>
    <?php
    $stmt = $conn->prepare("SELECT NewsID, NewsSubject, NewsBody, StartDate FROM News WHERE AdminView = 1 ORDER BY StartDate DESC");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
	foreach ($stmt->fetchAll() as $r) {
	    echo "<div id=\"newsAdmin" . $r['NewsID'] . "\" class=\"news\">" . PHP_EOL;
	    echo "<span class=\"newsPosted\"><i>Posted Date: " . date("Y-M-d (D)", strtotime($r['StartDate'])) . "</i></span><br />" . PHP_EOL;
	    echo "<h3 class=\"newsTitle\">" . $r['NewsSubject'] . "</h3>" . PHP_EOL;
	    echo "<p class=\"newsBody\">" . $r['NewsBody'] . "</p>" . PHP_EOL;
	    echo "</div>" . PHP_EOL;
	}
    } else {
	echo "<i>None at the moment.</i>" . PHP_EOL;
    }
    echo "<hr />" . PHP_EOL;
endif;
if ($NavRole == "coach" || $NavRole == "admin") :
    ?>
    <h2>Coach News</h2>
    <?php
    $stmt = $conn->prepare("SELECT NewsID, NewsSubject, NewsBody, StartDate FROM News WHERE CoachView = 1 ORDER BY StartDate DESC");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
	foreach ($stmt->fetchAll() as $r) {
	    echo "<div id=\"newsCoach" . $r['NewsID'] . "\" class=\"news\">" . PHP_EOL;
	    echo "<span class=\"newsPosted\"><i>Posted Date: " . date("Y-M-d (D)", strtotime($r['StartDate'])) . "</i></span><br />" . PHP_EOL;
	    echo "<h3 class=\"newsTitle\">" . $r['NewsSubject'] . "</h3>" . PHP_EOL;
	    echo "<p class=\"newsBody\">" . $r['NewsBody'] . "</p>" . PHP_EOL;
	    echo "</div>" . PHP_EOL;
	}
    } else {
	echo "<i>None at the moment.</i>" . PHP_EOL;
    }
    echo "<hr />" . PHP_EOL;
endif;
if ($NavRole == "student" || $NavRole == "admin") :
    ?>
    <h2>Student News</h2>
    <?php
    $stmt = $conn->prepare("SELECT NewsID, NewsSubject, NewsBody, StartDate FROM News WHERE StudentView = 1 ORDER BY StartDate DESC");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
	foreach ($stmt->fetchAll() as $r) {
	    echo "<div id=\"newsStudent" . $r['NewsID'] . "\" class=\"news\">" . PHP_EOL;
	    echo "<span class=\"newsPosted\"><i>Posted Date: " . date("Y-M-d (D)", strtotime($r['StartDate'])) . "</i></span><br />" . PHP_EOL;
	    echo "<h3 class=\"newsTitle\">" . $r['NewsSubject'] . "</h3>" . PHP_EOL;
	    echo "<p class=\"newsBody\">" . $r['NewsBody'] . "</p>" . PHP_EOL;
	    echo "</div>" . PHP_EOL;
	}
    } else {
	echo "<i>None at the moment.</i>" . PHP_EOL;
    }
    echo "<hr />" . PHP_EOL;
endif;
?>
<h2>Community News</h2>
<?php
$stmt = $conn->prepare("SELECT NewsID, NewsSubject, NewsBody, StartDate FROM News WHERE PublicView = 1 ORDER BY StartDate DESC");
$stmt->execute();

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $r) {
	echo "<div id=\"newsPublic" . $r['NewsID'] . "\" class=\"news\">" . PHP_EOL;
	echo "<span class=\"newsPosted\"><i>Posted Date: " . date("Y-M-d (D)", strtotime($r['StartDate'])) . "</i></span><br />" . PHP_EOL;
	echo "<h3 class=\"newsTitle\">" . $r['NewsSubject'] . "</h3>" . PHP_EOL;
	echo "<p class=\"newsBody\">" . $r['NewsBody'] . "</p>" . PHP_EOL;
	echo "</div>" . PHP_EOL;
    }
} else {
    echo "<i>None at the moment.</i>";
}
?>

<!-- Insert Page Content Above -->
<?php
include_once('phpinclude/sidebar.php');
include_once('phpinclude/footer.php');
?>