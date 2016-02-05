<?php
/*
 *  filename:       header.php
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['last_active'] = time();
$NavRole;
if (isset($_SESSION['Group']) && !empty($_SESSION['Group'])) {
    $NavRole = strtolower($_SESSION['Group']);
} else {
    $NavRole = "public";
}

$inAdminDir = stripos(CUR_DIR, "Admin") == FALSE ? FALSE : TRUE;
$inCoachDir = stripos(CUR_DIR, "Coach") == FALSE ? FALSE : TRUE;
$inStudentDir = stripos(CUR_DIR, "Student") == FALSE ? FALSE : TRUE;
$inTeamDir = stripos(CUR_DIR, "Team") == FALSE ? FALSE : TRUE;
$inDir = $inAdminDir || $inCoachDir || $inStudentDir || $inTeamDir;

if (isset($AuthRoles) && !empty($AuthRoles)) {
    IF (!in_array($NavRole, $AuthRoles)) {
	if (isset($_SESSION['username']) && !empty($_SESSION['username']) && $NavRole != "public") {
	    header('Location: ' . ($inDir ? "../" : "") . 'account.php?msg=denied&url=' . urlencode($_SERVER['REQUEST_URI']));
	} else {
	    header('Location: ' . ($inDir ? "../" : "") . 'account.php?msg=login&url=' . urlencode($_SERVER['REQUEST_URI']));
	    exit();
	}
    }
}


//if (isset($requireSSL) && !empty($requireSSL)) {
// if ($_SERVER['HTTPS'] != "on") {
    // $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    // header("Location:$redirect");
    // exit();
// }
//}
header("X-UA-Compatible: IE=Edge");
//header("Content-Security-Policy: script-src 'self' 'unsafe-eval' https://code.jquery.com/ https://ajax.aspnetcdn.com/ajax/jquery.validate/ https://cdn.datatables.net/ https://debug.datatables.net/; frame-src 'self' https://www.google.com/recaptcha/; img-src 'self' https://ssl.gstatic.com/; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com;");
//header("X-Content-Security-Policy: script-src 'self' 'unsafe-eval' https://code.jquery.com/ https://ajax.aspnetcdn.com/ajax/jquery.validate/ https://cdn.datatables.net/ https://debug.datatables.net/; frame-src 'self' https://www.google.com/recaptcha/; img-src 'self' https://ssl.gstatic.com/; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com;");
?>
<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo $inDir ? "../" : "" ?>css/style.css" />
	<?php
	if (isset($addCSS) && !empty($addCSS)) {
	    $addCSS = array_unique($addCSS);
	    foreach ($addCSS as $css) {
		if (strpos($css, "http") === false) {
		    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . ($inDir ? "../" : "") . "css/$css\" />\n";
		} else {
		    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$css\" />\n";
		}
	    }
	}
	?>
	<title>K&amp;Y Athletic Management System<?php echo ($thisPage != "" ? " | $thisPage" : ""); ?></title>

    </head>
    <body>
	<header>
	    <a href="<?php echo $inDir ? "../" : "" ?>index.php"><img src="<?php echo $inDir ? "../" : "" ?>images/banner.png" alt="Banner"/></a>
	</header><!--header-->

	<nav id="navigation"><?php include_once('navigation.php'); ?></nav><!--navigation-->

	<div id="container">
	    <div id="content">
		<div id="contentleft">
		    <div id="breadcrumbs">
			<?php

			// This function will take $_SERVER['REQUEST_URI'] and build a breadcrumb based on the user's current path
			function breadcrumbs() {
			    $separator = ' &#187; ';
			    $home = 'Home';
			    global $thisPage;

			    // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
			    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

			    // This will build our "base URL" ... Also accounts for HTTPS :)
			    $base = ($_SERVER['REQUEST_SCHEME'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

			    // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
			    $breadcrumbs = Array("<a href=\"$base\">$home</a>");

			    // Find out the index for the last value in our path array
			    $arraykeys = array_keys($path);
			    $last = end($arraykeys);

			    // An array for subheadings for no links.
			    $subhead = array("Admin", "Coach", "Team", "Student");

			    // Build the rest of the breadcrumbs
			    foreach ($path AS $x => $crumb) {
				// Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
				$title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));

				// If we are not on the last index, then display an <a> tag
				if ($x != $last)
				// Check if it's a subheading.  Don't create link for subheadings.
				    $breadcrumbs[] = in_array($crumb, $subhead) ? $title : "<a href=\"$base$crumb\">$title</a>";
				// Otherwise, just display the page Title
				else
				    $breadcrumbs[] = $thisPage;
			    }

			    // Build our temporary array (pieces of bread) into one big string :)
			    return implode($separator, $breadcrumbs);
			}

			echo "You are here:  " . breadcrumbs();
			echo "<hr />"
			?>
		    </div>
