<?php 
/*
 *  filename:       sidebar.php
 */

?>
</div><!--contentleft-->
<aside>
    <div class="sidebar-element">
	<h3>Member's Area</h3>
<?php include_once('member.php'); ?>
    </div>

    <div class="sidebar-element">
        <h3>Contact Our Staffs</h3>
        <ul>
	    <?php
	    if (strpos($_SERVER['PHP_SELF'], "contact.php")) {
		echo "<li>See content area</li>" . PHP_EOL ;
	    } else {
		$stmt = $conn->prepare("SELECT Name, Email, Phone FROM AdminProfile WHERE PublicDisplay = 1 ORDER BY DisplayOrder ASC");
		$stmt->execute();

		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		foreach ($stmt->fetchAll() as $r) {
		    echo "<li>" . $r['Name'] . PHP_EOL;
		    echo "<ul>" . PHP_EOL . "<li>" . $r['Email'] . "</li>" . PHP_EOL;
		    echo "<li>" . $r['Phone'] . "</li>" . PHP_EOL . "</ul>" . PHP_EOL . "</li>" . PHP_EOL;
		}
	    }
	    ?>
        </ul>
    </div>
</aside><!--sidebar-->