<?php
/*
 *  filename:       Register.php
 */

$thisPage = "Registration";
$addScript = ["https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js", "register.js"];
$addCSS = ["register.css"];
$requireSSL = true;
include_once('phpinclude/load.php');
$form_get_token = uniqid('auth', true);
$form_post_token = uniqid('postauth', true);
$_SESSION['GET_FORM_TOKEN'] = $form_get_token;
$_SESSION['POST_FORM_TOKEN'] = $form_post_token;
?>
<!-- Insert Page Content Below -->

<h1>User Account Registration</h1>
<?php if (isset($_SESSION['Group']) && !empty($_SESSION['Group'])) : ?>
    <p>You are currently logged into our system.  Use the navigation bar above to continue to another page, or logout in order to register a new account.  Please note that only one account can be registered per member.</p>
<?php else : ?>
    <p>Please note:  Only those already in our system can create an online account.<br>
        If you belive you are in our system but can't register, please contact one of our administrative team member for assistance.</p>
    <p>Already registered?  <a class="mobile" href="account.php">Click here to login</a><span class="desktop">Use the sidebar to login</span></p>
    <form id="valUser">
        <fieldset>
    	<legend>User Validation</legend>
    	<label for="txtID">ID*</label>
    	<input id="txtID" type="text" name="txtID" maxlength="8" Title="Required Field.  Enter a numberic ID."><br />

    	<label for="txtFirstName">First Name*</label>
    	<input id="txtFirstName" type="text" name="txtFirstName" maxlength="30" Title="Required Field.  Enter your First Name."><br />

    	<label for="txtLastName">Last Name*</label>
    	<input id="txtLastName" type="text" name="txtLastName" maxlength="30" Title="Required Field.  Enter your Last Name."><br />

    	<label for="selectUserType">Program Role*</label>
    	<select id="selectUserType" name="selectUserType">
    	    <option value="">--- Select Role ---</option>
    	    <option value="Coach">Coach</option>
    	    <option value="Student">Student</option>
    	</select><br />
    	<input type="hidden" name="form_token" value="<?php echo $form_get_token; ?>"/>
    	<div id="valUserFormButton">
    	    <br />
    	    <input id="validate" type="submit" value="Validate User">
    	    <input id="reset" type="reset" value="Reset User Validation Form">
    	</div>
        </fieldset>
    </form>
    <form id="regUser">
        <fieldset>
    	<legend>User Registration</legend>
    	<label for="txtEmail">Email*</label>
    	<input id="txtEmail" type="email" name="txtEmail" Title="Required Field.  Enter your email address."><br />

    	<label for="txtUsername">Username*</label>
    	<input id="txtUsername" type="text" name="txtUsername" maxlength="30" Title="Required Field.  Enter the username you wish to use."><br />

    	<label for="txtPassword">Password*</label>
    	<input id="txtPassword" type="password" name="txtPassword" Title="Required Field.  Enter the password you wish to use."><br />

    	<div id="retypePassword">
    	    <label for="txtPasswordAgain">Retype Password*</label>
    	    <input id="txtPasswordAgain" type="password" name="txtPasswordAgain" Title="Required Field.  Enter the same password as above."><br />
    	</div>

    	<input id="hiddenID" type="hidden" name="txtID">
    	<input id="hiddenRole" type="hidden" name="selectUserType">
    	<input type="hidden" name="post_form_token" value="<?php echo $form_post_token; ?>"/>

    	<div id="regUserFormButton">
    	    <br />
    	    <input id="submitReg" type="submit" value="Register User">
    	    <input id="resetReg" type="reset" value="Reset User Registration Form">
    	</div>
        </fieldset>
    </form>

    <p id="result"></p>
<?php endif; ?>
<!-- Insert Page Content Above -->
<?php
include_once('phpinclude/sidebar.php');
include_once('phpinclude/footer.php');
?>