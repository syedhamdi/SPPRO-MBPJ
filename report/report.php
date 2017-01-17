<script language="javascript">
	document.body.style.overflowX="auto";
</script>
<?php 
include './include/connection.php';
?>

<table border="" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td width="1%" style="padding:3px">
		<?php include 'left_menu.php';?>
	</td>
	
	<td style="padding:5px;">
		<?php 
			if(!(isset($_GET['sm']))){
				include 'report_main.php';		
			}elseif(urlDecrypt($_GET['sm'])=='1') {
				include 'SearchReport.php';
			}
			elseif(urlDecrypt($_GET['sm'])=='3'){
				include 'SearchKontraktor.php';
			}
			elseif(urlDecrypt($_GET['sm'])=='4'){
				include 'SearchAnalisis.php';
			}
			elseif(urlDecrypt($_GET['sm'])=='5'){
				include 'GrafJab.php';
			}
			elseif(urlDecrypt($_GET['sm'])=='6'){
				include 'Kewangan_Projek.php';
			}
			elseif(urlDecrypt($_GET['sm'])=='7') {
				include 'SearchReportKwsn.php';
			}
			elseif(urlDecrypt($_GET['sm'])=='8') {
				include 'SearchReportRingkasan.php';
			}
			elseif(urlDecrypt($_GET['sm'])=='9') {
				include 'SearchRingkasan.php';
			}

		?>
	</td>
</tr>
</table>