	<div id="footer">
	<small><a href="<?php echo AUTOR_DOMAIN; ?>" target="_blank">&#169; <?php echo AUTOR_NAME; ?></a>
	</small>
	</div>
</div>
<?php
if (isset($_SESSION['notification_output']) && $_SESSION['notification_output'] != "") { echo $_SESSION['notification_output']; $_SESSION['notification_output'] = ""; }
if (isset($_SESSION['notification_success']) && $_SESSION['notification_success'] != "" || isset($_SESSION['notification_information']) && $_SESSION['notification_information'] != "" || isset($_SESSION['notification_attention']) && $_SESSION['notification_attention'] != "" || isset($_SESSION['notification_error']) && $_SESSION['notification_error'] != "")
{
	echo "<div class=\"nofitication_wrapper\">";
	if (isset($_SESSION['notification_success']) && $_SESSION['notification_success'] != "") { echo "<div class=\"notification success\"><div>".$_SESSION['notification_success']."</div></div>"; $_SESSION['notification_success'] = ""; }
	if (isset($_SESSION['notification_information']) && $_SESSION['notification_information'] != "") { echo "<div class=\"notification information\"><div>".$_SESSION['notification_information']."</div></div>"; $_SESSION['notification_information'] = ""; }
	if (isset($_SESSION['notification_attention']) && $_SESSION['notification_attention'] != "") { echo "<div class=\"notification attention\"><div>".$_SESSION['notification_attention']."</div></div>"; $_SESSION['notification_attention'] = ""; }
	if (isset($_SESSION['notification_error']) && $_SESSION['notification_error'] != "") { echo "<div class=\"notification error\"><div>".$_SESSION['notification_error']."</div></div>"; $_SESSION['notification_error'] = ""; }
		echo "<script language=\"javascript\">var delkaZobrazeni = ($('.nofitication_wrapper').html()).length * ".CONST_MAX_DELAY_NOTIFICATION_CHAR."; if(delkaZobrazeni > ".CONST_MAX_DELAY_NOTIFICATION.") {delkaZobrazeni = ".CONST_MAX_DELAY_NOTIFICATION."; } $('.nofitication_wrapper').animate({opacity: 1,left: '-2'}, 500, function() {}).delay(delkaZobrazeni).animate({opacity: 0,left: '-402'}, 500, function() {});</script>";
	}
	echo "</div>";
if (isset($_SESSION['notification_alert']) && $_SESSION['notification_alert'] != "") { echo "<script type=\"text/javascript\">$(document).ready(function() { alert(\"".$_SESSION['notification_alert']."\"); });</script>"; $_SESSION['notification_alert'] = ""; }
$_SESSION['admin_last_url'] = getUrl();
?>
</body> 
</html>