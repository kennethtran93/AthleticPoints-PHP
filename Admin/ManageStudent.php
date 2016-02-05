<?php
/*
 *  filename:       ManageStudent.php
 */

$thisPage = "Manage Students";
$AuthRoles = ['admin'];
include_once('../phpinclude/load.php');
?>
<!-- Insert Page Content Below -->
<h1>Manage Students</h1>
<p>Here is where students may be added or deleted.  This is an optional feature that has yet to be implemented.  We know it's somewhat important, but it is not a part of the project's scope/user stories.</p>
<p>To Maintain the Student Profiles, please navigate to the Edit Profile section of the Student's Function.</p>

<br/>
<!-- Insert Page Content Above -->

<?php
include_once("../phpinclude/sidebar.php");
include_once("../phpinclude/footer.php");
?>        
