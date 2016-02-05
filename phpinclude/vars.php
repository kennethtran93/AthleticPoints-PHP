<?php
/*
 *  filename:       vars.php
 */

function getCurDir() {
    $curdir = dirname($_SERVER['REQUEST_URI']);
    return $curdir;
}

//Current Directory (inside ROOT Directory)
define('CUR_DIR', getCurDir());

?>