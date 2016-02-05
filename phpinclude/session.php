<?php

/*
 *  filename:       session.php
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['last_active']) && !empty($_SESSION['last_active'])) {
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
	// should still be logged in
	if (time() - $_SESSION['last_active'] > 1800) {
	    // Expired after 30 minutes
	    session_unset();
	    session_destroy();
	    echo FALSE;
	    return;
	} else {
	    // not expired.
	    echo TRUE;
	    return;
	}
    } else {
	// should not be logged in - don't bother checking
	echo TRUE;
	return;
    }
} else {
    // If this is reached, then most likely session already expired.
    echo FALSE;
    return;
}
?>