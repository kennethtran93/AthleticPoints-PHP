<?php
/*
 *  filename:       footer.php
 */

?>
</div><!--content-->
</div><!--container-->

<footer>
    <p>Copyright &copy;2015 ACIT2910 - Projects - A2 - YJ.KT</p>
    <br/>
</footer><!--footer-->

<!--[if !IE]><!--><script src="https://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script><!--<![endif]-->
<!--[if IE]><script src="https://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script><![endif]-->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src='../js/script.js'></script>
<script src="../js/session.js"></script>
    <?php
if (isset($addScript) && !empty($addScript)) {
    $addScript = array_unique($addScript);
    foreach ($addScript as $script) {
	if (strpos($script, "http") === false) {
	    echo "<script src=\"../js/$script\"></script>\n";
	} else {
	    echo "<script src=\"$script\"></script>\n";
	}
    }
}
?>
</body>
</html>