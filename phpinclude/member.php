<?php
/* 
 *  filename:       member.php
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($form_login_token) || empty($form_login_token) || !isset($_SESSION['LOGIN_FORM_TOKEN']) || empty($_SESSION['LOGIN_FORM_TOKEN'])) {
    $form_login_token = uniqid('loginauth', true);
    $_SESSION['LOGIN_FORM_TOKEN'] = $form_login_token;
}
if (isset($addScript) && !empty($addScript)) {
    array_push($addScript, "https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js", "member.js");
} else {
    $addScript = ["https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js", "member.js"];
}
?>
<form id="member">
    <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])) : ?>
        <div class='navPublic'><p>Welcome, <?php echo $_SESSION['FirstName'] . " " . $_SESSION['LastName'] . " (" . $_SESSION['Group'] ?>)</p>
    	<button type='button' id='btnLogout' class="button">Logout</button>
	    <?php if (!strpos($_SERVER['PHP_SELF'], "account.php") || (strpos($_SERVER['PHP_SELF'], "account.php") && !(isset($_GET['msg']) && !empty($_GET['msg']) && $_GET['msg'] == "change"))) : ?> <button type="button" id="btnChange" class="button">Account Maintenance</button><?php endif; ?>
        </div>
    <?php else : ?>
        <label for='username'>UserName*:</label>
        <input type='text' name='username' id='username' class="textbox" maxlength="30" />
        <br/>
        <label for='password' >Password*:</label>
        <input type='password' name='password' id='password' class="textbox" maxlength="30" />
        <br/>
        <input type="hidden" name="login_token" value="<?php echo $form_login_token; ?>"/>
        <input type='submit' class="button" id="btnLogin" name='Login' value='Login'/>
        <button type="button" id="btnRegister" class="button">Not a member?  Click here to register</button>
    <?php endif; ?>
</form>
<hr/>
<p id='accountResult'>
    <?php
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
	if ($_GET['msg'] != "expired" || (isset($_SESSION['username']) && !empty($_SESSION['username']))) {
	    switch ($_GET['msg']) {
		case "logout":
		    echo "You have been successfully logged out.";
		    if (isset($_GET['url']) && !empty($_GET['url'])) {
			if (stripos($_GET['url'], "teamDirectory.php") === FALSE || stripos($_GET['url'], "contact.php") === FALSE || stripos($_GET['url'], "index.php") === FALSE || stripos($_GET['url'], "account.php") === FALSE) {
			    echo "  To view that page again simply login using the form above.";
			}
		    }
		    break;
		case "invalid":
		    echo "Invalid Username and/or Password.  Please try again.";
		    break;
		case "login":
		    echo "You must login to access the requested page.";
		    break;
		case "denied":
		    echo "Your current account does not allow access to the requested page.  If you believe you should have access please contact your school's Athletic Director.";
		    break;
		case "success":
		    echo "You have been successfully logged in.  Use the navigation bar at the top of the page to continue.";
		    break;
		case "updated":
		    echo "Your User Account Credential has been successfully updated.  Please login with your new credentials to be redirected back to where you previously were.";
		    break;
	    }
	} else {
	    echo "Session Timeout - You were inactive for too long ( 30+ minutes ) that your session has expired.  To continue simply login again.";
	}
    }
    ?>
</p>

<?php
if (isset($_SESSION['username']) && !empty($_SESSION['username']) && isset($_GET['msg']) && !empty($_GET['msg']) && $_GET['msg'] == "change") :
    ?>
    <h3>Change Username and/or Password</h3>
    <p>Please note that you will be automatically logged out once you have successfully changed your username and/or password.</p>
    <form id="accountManagement">
        <label for="curUsername">Old (Current) Username:</label>
        <input id="curUsername" name="curUsername" type="text" class="textbox" maxlength="30" />
        <br />
        <label for="curPassword">Old (Current) Password:</label>
        <input id="curPassword" name="curPassword" type="password" class="textbox" maxlength="30" />
        <br />
        <label for="newUsername">New Username:</label>
        <input id="newUsername" name="newUsername" type="text" class="textbox" maxlength="30" />
        <br />
        <label for="newUsername2">Repeat New Username:</label>
        <input id="newUsername2" name="newUsername2" type="text" class="textbox" maxlength="30" />
        <br />
        <label for="newPassword">New Password:</label>
        <input id="newPassword" name="newPassword" type="password" class="textbox" maxlength="30" />
        <br />
        <label for="newPassword2">Repeat New Password:</label>
        <input id="newPassword2" name="newPassword2" type="password" class="textbox" maxlength="30" />
        <br />
        <br />
        <input id="changeAccount" type="submit" class="button" value="Change User Account" />
        <input id="resetChange" type="reset" value="Reset Form" />
    </form>
    <p id="changeResult"></p>
    <button id="btnChangeReturn" type="button">Return to Previous Page</button>
<?php endif; ?>