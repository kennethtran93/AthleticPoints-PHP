<?php
/*
 *  filename:       edit_studentprofile.php
 */

$thisPage = "Student Profile Maintenance";
$AuthRoles = ["admin", "student"];
$addScript = ["studentProfile.js"];
include_once('../phpinclude/load.php');
?>
<!-- Insert Page Content Below -->
<h1>Student Profile Maintenance</h1>

<p>The student profile was generated:  <span id="generated"></span></p>
<?php
if (isset($_SESSION['Group']) && !empty($_SESSION['Group']) && ($_SESSION['Group'] == "Admin")) {
    echo "<select id=\"adminSelectID\"></select>";
}
?>
<button type="button" id="btnRefresh">Refresh Profile</button>
<br />
<form id='studentProfile'>

    <?php if (isset($_SESSION['Group']) && !empty($_SESSION['Group']) && ($_SESSION['Group'] == "Admin")) : ?>
        <label for='studentNo'>Student No</label>
        <input id="studentNo" type="text" name="studentNo" class="textbox" maxlength="7" />
        <br />
        <label for='firstName'>First Name</label>
        <input id="firstName" type="text" name="firstName" class="textbox" maxlength="30" />
        <br />
        <label for='lastName'>Last Name</label>
        <input id="lastName" type="text" name="lastName" class="textbox" maxlength="30" />
        <br />
        <label for='homeroom'>Homeroom</label>
        <input id="homeroom" type="text" name="homeroom" class="textbox" maxlength="2" />
        <br />
        <label for='gender'>Gender</label>
        <input id="gender" type="text" name="gender" class="textbox" maxlength="6" />
        <br />
        <label for='DOB'>Date of Birth (YYYY-MM-DD)</label>
        <input id="DOB" type="date" name="DOB" class="textbox" />
    <?php else : ?>
        <span>Student No </span>
        <span id='studentNo'></span>
        <br />
        <span>First Name </span>
        <span id='firstName'></span>
        <br />
        <span>Last Name </span>
        <span id='lastName'></span>
        <br />
        <span>Homeroom </span>
        <span id='homeroom'></span>
        <br />
        <span>Gender </span>
        <span id='gender'></span>
        <br />
        <span>Date of Birth (YYYY-MM-DD)</span>
        <span id='DOB'></span>
    <?php endif; ?>
    <br />
    <label for='email'>Email</label>
    <input id='email' type='text' name='email' class='textbox' maxlength='250' />
    <br />
    <label for='mobileNumber'>Mobile Number</label>
    <input id='mobileNumber' type='text' name='mobileNumber' class='textbox' maxlength='25' />
    <br />
    <label for='homeNumber'>Home Number</label>
    <input id='homeNumber' type='text' name='homeNumber' class='textbox' maxlength='25' />
    <br />
    <br />
    <input id='oldStudentNumber' type='hidden' name='oldStudentNo' value='' />
    <input id='submitStudent' type='submit' value='Update Student Profile' />
</form>

<p id='profileResult'></p>
<!-- Insert Page Content Above -->
<?php
include_once('../phpinclude/sidebar.php');
include_once('../phpinclude/footer.php');
?>