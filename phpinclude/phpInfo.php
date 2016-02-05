<?php

if (isset($_GET['display']) && !empty($_GET['display'])) {
    if ($_GET['display'] == "please") {
	phpinfo();
    }
}
?>