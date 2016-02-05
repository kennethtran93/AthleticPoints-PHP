<?php
/* 
 *  filename:       navigation.php
 */

?>

<ul>
    <li <?php if ($thisPage == "Welcome!") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inDir ? "../" : "") ?>index.php'><span>Home</span></a></li>

    <?php
    if (isset($_SESSION['Group']) && !empty($_SESSION['Group'])) {
	if ($_SESSION['Group'] == "Student" || $_SESSION['Group'] == "Admin") :
	    ?>
	    <?php if ($_SESSION['Group'] == "Admin") : ?>
	        <li class="has-sub<?php if ($thisPage == "My Team" || $thisPage == "Student Profile Maintenance" || $thisPage == "View Student Points") echo " currentPage"; ?>"><span>Student Functions &#9660;</span>
	    	<ul>
		    <?php endif; ?>
		    <li <?php if ($thisPage == "My Team") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inStudentDir ? "" : ($inDir ? "../" : "") . "Student/") ?>myteam.php'><span>My Team</span></a></li>
		    <li <?php if ($thisPage == "Student Profile Maintenance") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inStudentDir ? "" : ($inDir ? "../" : "") . "Student/") ?>edit_studentprofile.php'><span>Edit Student Profile</span></a></li>
		    <li <?php if ($thisPage == "View Student Points") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inStudentDir ? "" : ($inDir ? "../" : "") . "Student/") ?>view_points.php'><span>View Student Points</span></a></li>
		    <?php if ($_SESSION['Group'] == "Admin") : ?>
	    	</ul>
	        </li>
	    <?php endif; ?>
	    <?php
	endif;
	if ($_SESSION['Group'] == "Coach" || $_SESSION['Group'] == "Admin") :
	    ?>
	    <?php if ($_SESSION['Group'] == "Admin") : ?>
	        <li class="has-sub<?php if ($thisPage == "Coach Profile Maintenance" || $thisPage == "Manage Teams" || $thisPage == "Coach Team Roster") echo " currentPage"; ?>"><span>Coach Functions &#9660;</span>
	    	<ul>
		    <?php endif; ?>
		    <li <?php if ($thisPage == "Coach Profile Maintenance") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inCoachDir ? "" : ($inDir ? "../" : "") . "Coach/") ?>edit_coachprofile.php'><span>Edit Profile</span></a></li>
		    <li <?php if ($thisPage == "Manage Teams") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inDir ? "../" : "") ?>Team/Manage.php'><span>Team Management</span></a></li>
		    <li <?php if ($thisPage == "Coach Team Roster") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inCoachDir ? "" : ($inDir ? "../" : "") . "Coach/") ?>TeamRoster.php'><span>Team Roster</span></a></li>
		    <?php if ($_SESSION['Group'] == "Admin") : ?>
	    	</ul>
	        </li>
	    <?php endif; ?>
	    <?php
	endif;
	if ($_SESSION['Group'] == "Admin") :
	    ?>
    <li class="has-sub<?php if ($thisPage == "Manage News" || $thisPage == "Manage User Accounts" || $thisPage == "Manage Coaches" || $thisPage == "Manage Students" || $thisPage == "Manage Teams" || $thisPage == "Manage Contact Us Page" || $thisPage == "Athletic Point Summary") echo " currentPage"; ?>"><span>Admin Functions &#9660;</span>
		<ul>
		    <li <?php if ($thisPage == "Manage News") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inAdminDir ? "" : ($inDir ? "../" : "") . "Admin/") ?>ManageNews.php'><span>Manage News</span></a></li>
		    <li <?php if ($thisPage == "Manage User Accounts") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inAdminDir ? "" : ($inDir ? "../" : "") . "Admin/") ?>ManageAccounts.php'><span>Manage User Accounts</span></a></li>
		    <li <?php if ($thisPage == "Manage Coaches") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inAdminDir ? "" : ($inDir ? "../" : "") . "Admin/") ?>ManageCoach.php'><span>Manage Coaches</span></a></li>
		    <li <?php if ($thisPage == "Manage Students") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inAdminDir ? "" : ($inDir ? "../" : "") . "Admin/") ?>ManageStudent.php'><span>Manage Students</span></a></li>
		    <li <?php if ($thisPage == "Manage Teams") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inDir ? "../" : "") ?>Team/Manage.php'><span>Manage Teams</span></a></li>
		    <li <?php if ($thisPage == "Manage Contact Us Page") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inAdminDir ? "" : ($inDir ? "../" : "") . "Admin/") ?>editContactUs.php'><span>Edit Contact Us Page</span></a></li>
		    <li <?php if ($thisPage == "Athletic Point Summary") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inAdminDir ? "" : ($inDir ? "../" : "") . "Admin/") ?>Report_Points.php'><span>Athletic Points Summary</span></a></li>
		</ul>
	    </li>
	    <?php
	endif;
    }
    ?>

    <li <?php if ($thisPage == "Team Directory") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inDir ? "../" : "") ?>TeamDirectory.php'><span>Team Directory</span></a></li>

    <li <?php if ($thisPage == "Contact Us") echo " class=\"currentPage\""; ?>><a href='<?php echo ($inDir ? "../" : "") ?>contact.php'><span>Contact Us</span></a></li>

    <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])) : ?>
        <li class="mobile" id="btnMobileChange"><span>Account Maintenance</span></li>
        <li class="mobile" id="btnMobileLogout"><span>Logout</span></li>
    <?php else : ?> 
        <li class="mobile <?php if ($thisPage == "User Account") echo " currentPage"; ?>"><a href="<?php echo ($inDir ? "../" : "") ?>account.php"><span>Sign In</span></a></li>
        <li class="mobile <?php if ($thisPage == "Registration") echo " currentPage"; ?>"><a href="<?php echo ($inDir ? "../" : "") ?>Register.php"><span>Register</span></a></li>
	<?php endif; ?>
</ul>