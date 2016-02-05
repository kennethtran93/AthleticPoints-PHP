<?php
/*
 *  filename:       ManageAccounts.php
 */

$thisPage = "Manage User Accounts";
$AuthRoles = ["admin"];
$addCSS = ["https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css", "https://cdn.datatables.net/responsive/1.0.6/css/dataTables.responsive.css", "https://cdn.datatables.net/fixedheader/2.1.2/css/dataTables.fixedHeader.css"];
$addScript = ["https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js", "https://cdn.datatables.net/responsive/1.0.6/js/dataTables.responsive.min.js", "https://cdn.datatables.net/fixedheader/2.1.2/js/dataTables.fixedHeader.min.js", "https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js", "ManageAccounts.js"];
include_once('../phpinclude/load.php');
?>
<!-- Insert Page Content Below -->
<h1>Manage User Accounts</h1>
<p>Here you can manage all user accounts in the system.  Click on the rows for additional details and to edit.</p>
<p>This list was generated:  <span id="generated"></span></p>

<select id="adminSelectGroup"></select>

<button type="button" id="btnRefresh">Refresh User Accounts</button>
<br />
<table id="userAccounts" class="display responsive">
    <thead>
	<tr>
	    <th class="control"></th>
	    <th class="all">Last Name</th>
	    <th class="all">First Name</th>
	    <th>ID</th>
	    <th>Username</th>
	    <th>Grant Access</th>
	    <th class="none">Date Registered</th>
	    <th class="none">Last Updated</th>
	    <th class="none"></th>
	</tr>
    </thead>
    <tfoot>
	<tr>
	    <th></th>
	    <th>Last Name</th>
	    <th>First Name</th>
	    <th>ID</th>
	    <th>Username</th>
	    <th>Grant Access</th>
	    <th>Date Registered</th>
	    <th>Last Updated</th>
	    <th></th>
	</tr>
    </tfoot>
</table>
<br />
<form id="editUser">
    <hr />
    <p id="editingUser"></p>
    <label for="editUsername">New Username:</label>
    <input id="editUsername" name="editUsername" type="text" class="textbox" maxlength="30"/>
    <br />
    <label for="editPassword">New Password:</label>
    <input id="editPassword" name="editPassword" type="password" class="textbox" maxlength="30"/>
    <br />
    <label for="editAccess">Grant Access (uncheck to lock out account):</label>
    <input id="editAccess" name="editAccess" type="checkbox"/>
    <br />
    <br />
    <input id="fullName" type="hidden" name="name" value="" />
    <input id="oldUsername" type="hidden" name="oldUsername" value="" />
    <input id="editAccount" type="submit" class="button" value="Change User Account" />
    <input id="resetEdit" type="reset" value="Reset Form" />
    <input id="hideFormEdit" type="reset" value="Hide Edit Form" />
</form>
<p id="editStatus"></p>
<p id="errors"></p>
<!-- Insert Page Content Above -->
<?php
include_once('../phpinclude/sidebar.php');
include_once('../phpinclude/footer.php');
?>
