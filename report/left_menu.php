<?	
	if(isset($_GET['sm'])){
		$sm = "sm".urlDecrypt($_GET['sm']);	
	}
	else{
		$sm = "";	
	}
	
	$m = urlDecrypt($_GET['m']);
	
?><script language="javascript">
function effect(i,div){
	
	if(div!='m<?=$m?><?=$sm?>'){		
		if(i=='1'){
			document.getElementById(div).style.backgroundColor='#F9F9F9';
		}else{
			document.getElementById(div).style.backgroundColor='#BED8DC';
		}
	}		
}
</script>
<div id="leftmenu_Report" style="width:200px; height:400px; background-color: #BED8DC; border:#333333 1px solid">

<div class="left_module_label">Laporan</div>
<div class="left_menu_label">Carian Laporan Mengikut</div>
<a onMouseOver="effect('1','m4sm1')" onMouseOut="effect('2','m4sm1')" href="main.php?m=<?=urlEncrypt(4)?>&sm=<?=urlEncrypt(1)?>"><div id="m4sm1" class="left_menu">&raquo; Senarai Projek</div></a>
<!--<a onMouseOver="effect('1','m4sm2')" onMouseOut="effect('2','m4sm2')" href="main.php?m=4&sm=2"><div id="m4sm2" class="left_menu">&raquo; Senarai Projek Mengikut Jenis</div></a>-->
<?
	if($_SESSION['ahli_majlis']==0){
		?>
		<a onMouseOver="effect('1','m4sm9')" onMouseOut="effect('2','m4sm9')" href="main.php?m=<?=urlEncrypt(4)?>&sm=<?=urlEncrypt(9)?>"><div id="m4sm9" class="left_menu">&raquo; Ringkasan Projek</div></a>
        <a onMouseOver="effect('1','m4sm3')" onMouseOut="effect('2','m4sm3')" href="main.php?m=<?=urlEncrypt(4)?>&sm=<?=urlEncrypt(3)?>"><div id="m4sm3" class="left_menu">&raquo; Senarai Kontraktor</div></a
        <a onMouseOver="effect('1','m4sm6')" onMouseOut="effect('2','m4sm6')" href="main.php?m=<?=urlEncrypt(4)?>&sm=<?=urlEncrypt(6)?>"><div id="m4sm6" class="left_menu">&raquo; Kewangan Projek</div></a>
        <div class="left_menu_label">Laporan Mengikut Kawasan</div>
		<a onMouseOver="effect('1','m4sm7')" onMouseOut="effect('2','m4sm7')" href="main.php?m=<?=urlEncrypt(4)?>&sm=<?=urlEncrypt(7)?>"><div id="m4sm7" class="left_menu">&raquo; Ringkasan Projek Kawasan</div></a>
		<a onMouseOver="effect('1','m4sm8')" onMouseOut="effect('2','m4sm8')" href="main.php?m=<?=urlEncrypt(4)?>&sm=<?=urlEncrypt(8)?>"><div id="m4sm8" class="left_menu">&raquo; Ringkasan Keseluruhan Projek</div></a>
        <!--div class="left_menu_label">Analisa/Graf/Carta</div>
        <a onMouseOver="effect('1','m4sm4')" onMouseOut="effect('2','m4sm4')" href="main.php?m=<?=urlEncrypt(4)?>&sm=<?=urlEncrypt(4)?>"><div id="m4sm4" class="left_menu">&raquo; Statistik Projek</div></a>
        <a onMouseOver="effect('1','m4sm5')" onMouseOut="effect('2','m4sm5')" href="main.php?m=<?=urlEncrypt(4)?>&sm=<?=urlEncrypt(5)?>"><div id="m4sm5" class="left_menu">&raquo; Statistik Jabatan</div></a-->
		<?
	}
?>

<!--<a onMouseOver="effect('1','m4sm5')" onMouseOut="effect('2','m4sm5')" href="main.php?m=4&sm=5"><div id="m4sm5" class="left_menu">&raquo; Statistik Jabatan</div></a>-->
<!--<a onMouseOver="effect('1','m4sm6')" onMouseOut="effect('2','m4sm6')" href="main.php?m=4&sm=6"><div id="m4sm6" class="left_menu">&raquo; Analisa Status Projek Mengikut Tahun</div></a>-->
</div>
<?	
	if(isset($_GET['sm'])){
		$sm = "sm".urlDecrypt($_GET['sm']);	
	}
	else{
		$sm = "";	
	}
	
	$m = urlDecrypt($_GET['m']);
	
?>
<script language="javascript">
	if(document.getElementById('m<?=$m?><?=$sm?>')) {
		document.getElementById('m<?=$m?><?=$sm?>').style.backgroundColor='#F5F5F5';
	}
</script>
