
<?
	if(isset($_GET['sm'])){
		$sm = "sm".urlDecrypt($_GET['sm']);	
	}
	else{
		$sm = "";	
	}
	if(isset($_GET['md'])){
		$sm = "sm11";	
	}

	$m = urlDecrypt($_GET['m']);
	
?><script language="javascript">
function effect(i,div){
	
	if(div!='m<?=$m?><?=$sm?>'){		
		if(i=='1'){
			document.getElementById(div).style.backgroundColor='#F5F5F5';
		}else{
			document.getElementById(div).style.backgroundColor='#BED8DC';
		}
	}		
}
</script>
<div id="leftmenu_Admin" style="width:200px; background-color: #BED8DC; border:#333333 1px solid">

<div class="left_module_label">Pentadbir</div>

<div class="left_menu_label">Jabatan/Bahagian/Unit</div>
<a onMouseOver="effect('1','m1sm1')" onMouseOut="effect('2','m1sm1')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(1)?>"><div id="m1sm1" class="left_menu">&raquo; Jabatan/Bahagian/Unit</div></a>
<div class="left_menu_label">Parlimen/Adun/Majlis</div>
<a onMouseOver="effect('1','m1sm13')" onMouseOut="effect('2','m1sm13')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(13)?>"><div id="m1sm13" class="left_menu">&raquo; Parlimen/Adun/Majlis</div></a>
<a onMouseOver="effect('1','m1sm15')" onMouseOut="effect('2','m1sm15')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(15)?>"><div id="m1sm15" class="left_menu">&raquo; Akaun Ahli Majlis</div></a>

<div class="left_menu_label">Pengguna</div>
<a onMouseOver="effect('1','m1sm2')" onMouseOut="effect('2','m1sm2')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(2)?>"><div id="m1sm2" class="left_menu">&raquo; Kumpulan Pengguna</div></a>
<a onMouseOver="effect('1','m1sm3')" onMouseOut="effect('2','m1sm3')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(3)?>"><div id="m1sm3" class="left_menu">&raquo; Jawatan</div></a>
<a onMouseOver="effect('1','m1sm4')" onMouseOut="effect('2','m1sm4')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(4)?>"><div id="m1sm4" class="left_menu">&raquo; Gred</div></a>
<a onMouseOver="effect('1','m1sm5')" onMouseOut="effect('2','m1sm5')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(5)?>"><div id="m1sm5" class="left_menu">&raquo; Akaun Pengguna</div></a>

<div class="left_menu_label">Perunding/Kontraktor</div>
<a onMouseOver="effect('1','m1sm12')" onMouseOut="effect('2','m1sm12')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(12)?>"><div id="m1sm12" class="left_menu">&raquo; Bidang Perunding</div></a>
<a onMouseOver="effect('1','m1sm14')" onMouseOut="effect('2','m1sm14')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(14)?>"><div id="m1sm14" class="left_menu">&raquo; Gred Pendaftaran Kontraktor</div></a>
<!--<a onMouseOver="effect('1','m1sm13')" onMouseOut="effect('2','m1sm13')" href="main.php?m=1&sm=13"><div id="m1sm13" class="left_menu">&raquo; Bidang Kontraktor</div></a>-->
<a onMouseOver="effect('1','m1sm6')" onMouseOut="effect('2','m1sm6')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(6)?>"><div id="m1sm6" class="left_menu">&raquo; Perunding</div></a>
<a onMouseOver="effect('1','m1sm7')" onMouseOut="effect('2','m1sm7')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(7)?>"><div id="m1sm7" class="left_menu">&raquo; Kontraktor</div></a>

<div class="left_menu_label">Projek</div>

<a onMouseOver="effect('1','m1sm8')" onMouseOut="effect('2','m1sm8')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(8)?>"><div id="m1sm8" class="left_menu">&raquo; Jenis Projek</div></a>
<a onMouseOver="effect('1','m1sm9')" onMouseOut="effect('2','m1sm9')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(9)?>"><div id="m1sm9" class="left_menu">&raquo; Kategori Projek</div></a>
<a onMouseOver="effect('1','m1sm10')" onMouseOut="effect('2','m1sm10')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(10)?>"><div id="m1sm10" class="left_menu">&raquo; Senarai Projek</div></a>
<a onMouseOver="effect('1','m1sm11')" onMouseOut="effect('2','m1sm11')" href="main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(10)?>&md=1"><div id="m1sm11" class="left_menu">&raquo; Pendaftaran Projek Baru</div></a>
<!--<a onMouseOver="effect('1','m1sm13')" onMouseOut="effect('2','m1sm13')" href="main.php?m=1&sm=13&md=1"><div id="m1sm13" class="left_menu">&raquo; Pendaftaran Projek Baru (Perunding)</div></a>-->

<!--<div class="left_menu_label">KPI & Penilaian</div>
<a onMouseOver="effect('1','m1sm11')" onMouseOut="effect('2','m1sm11')" href="main.php?m=1&sm=11"><div id="m1sm11" class="left_menu">&raquo; Skala Prestasi</div></a>
<a onMouseOver="effect('1','m1sm12')" onMouseOut="effect('2','m1sm12')" href="main.php?m=1&sm=12"><div id="m1sm12" class="left_menu">&raquo; Kriteria Penilaian Perunding</div></a>
<a onMouseOver="effect('1','m1sm13')" onMouseOut="effect('2','m1sm13')" href="main.php?m=1&sm=13"><div id="m1sm13" class="left_menu">&raquo; KPI Surat Setuju Terima</div> </a>
  
</div>
-->
<?	if(isset($_GET['sm'])){
		$sm = "sm".urlDecrypt($_GET['sm']);	
	}
	else{
		$sm = "";	
	}
	if(isset($_GET['md'])){
		if(urlDecrypt($_GET['sm']) == 10){
		$sm = "sm11";	
		}
	}	
	$m = urlDecrypt($_GET['m']);
	
?>
<script language="javascript">
	if(document.getElementById('m<?=$m?><?=$sm?>')) {
		document.getElementById('m<?=$m?><?=$sm?>').style.backgroundColor='#F5F5F5';
	}
</script>