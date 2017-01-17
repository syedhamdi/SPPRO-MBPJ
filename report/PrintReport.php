<?
include '../include/connection.php';
include '../include/serversidescript.php';
?>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<link href="../CSS/Style.css" rel="stylesheet" type="text/css">
   <style type="text/css">
		@media print
		{
		  table { page-break-after:auto }
		  tr    { page-break-inside:avoid; page-break-after:auto }
		  td    { page-break-inside:avoid; page-break-after:auto }
		  thead { display:table-header-group }
		  tfoot { display:table-footer-group }
		  .papar_imej{ display:none;}
		}
  </style>
</head>
<body>
<script language="javascript" type="text/javascript" src="../js/jquery-1.9.1.js"></script>
<?php
	$id = $_GET["id"];
	$tajuk = $_GET["tajuk"];
	if(isset($_GET["kategori"])){
		$kategoriVal = $_GET["kategori"];
	}
	if(isset($_GET["kategori"])){
		$kawasanVal = $_GET["kawasan"];
	}
	if(isset($_GET["jabatan"])){
		$jabatan = $_GET["jabatan"];
	}
	if(isset($_GET["from"])){
		$from = $_GET["from"];
	}
	if(isset($_GET["to"])){
		$to = $_GET["to"];
	}
if($id=="Print1"){	
?>
<table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="5" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid; display:" id="ReportTable2">	
  <tr>
    <td width="9%" height="33"  style="font-size:14px">TAJUK</td>
    <td width="75%" style="font-size:14px"><strong><?=$tajuk?></strong></td>
    <td width="8%" rowspan="5"><img src="../images/mbpj_logo.gif" width="103" height="122"></td>
    <td width="8%" rowspan="5" align="center"><p><strong>MAJLIS BANDARAYA</strong> <strong>PETALING JAYA</strong> </p></td>
    </tr>
  <tr>
    <td height="42"  style="font-size:14px">KATEGORI</td>
    <td style="font-size:14px">
    	<?
        	if($kategoriVal == ""){
				echo "<strong>-</strong>";
			}else if($kategoriVal == 0){
				echo "<strong>SEMUA</strong>";	
			}else{
				$kategori = strtoupper(process_sql("select * from project_category where project_category_id = ".$kategoriVal,"project_category_desc"));
				echo "<strong>".$kategori."</strong>";	
			}
			
			if($kawasanVal == ""){
				$kawasan = "<b>SEMUA</b>";	
			}
			elseif($kawasanVal == "tidakberkenaan"){
				$kawasan = "-";	
			}
			elseif($kawasanVal == "semuazon"){
				  $kawasan = "<b>SEMUA ZON</b>";	
			}else{
				$level = process_sql("select * from kawasan where kwsn_id = ".$kawasanVal,"layer");
				if($level == 1){
					$kawasan = "<b>PARLIMEN :</b> ".strtoupper(process_sql("select * from kawasan where kwsn_id = ".$kawasanVal,"kwsn_desc"));		
				}
				if($level == 2){
					$parlimenP = process_sql("select * from kawasan where kwsn_id = ".$kawasanVal,"parent_id");
					$parlimen = process_sql("select * from kawasan where kwsn_id = ".$parlimenP,"kwsn_desc");
					$adun = process_sql("select * from kawasan where kwsn_id = ".$kawasanVal,"kwsn_desc");
					$kawasan = "<b>PARLIMEN :</b> ".$parlimen."&nbsp;&nbsp;<br><b>&nbsp;&nbsp;ADUN&nbsp;:&nbsp;</b>".$adun;
		
				}
				if($level == 3){
					$adunP = process_sql("select * from kawasan where kwsn_id = ".$kawasanVal,"parent_id");
					$adun = process_sql("select * from kawasan where kwsn_id = ".$adunP,"kwsn_desc");
										
					$parlimenP = process_sql("select * from kawasan where kwsn_id = ".$adunP,"parent_id");
					$parlimen = process_sql("select * from kawasan where kwsn_id = ".$parlimenP,"kwsn_desc");
					
					$majlis = process_sql("select * from kawasan where kwsn_id = ".$kawasanVal,"kwsn_desc");
					$kawasan = "<b>PARLIMEN :</b> ".$parlimen."&nbsp;&nbsp;<br><b>&nbsp;&nbsp;ADUN&nbsp;:&nbsp;</b>".$adun."&nbsp;&nbsp;<br><b>&nbsp;&nbsp;MAJLIS&nbsp;:&nbsp;</b>".$majlis;
		
				}
				//$kawasan = 
			}
		?></td>
    </tr>
 <tr>
    <td height="41"  style="font-size:14px">TEMPOH MASA</td>
    <?
    	$to=($to=="")?"-":$to;
	?>
    <td  style="font-size:14px"><b><?=$from?> Hingga <?=$to?></b></td>
  </tr>
  <tr>
    <td height="41"  style="font-size:14px">KAWASAN</td>
    <td  style="font-size:14px"><?=$kawasan?></td>
  </tr>
  <tr>
    <td height="41"  style="font-size:14px">TARIKH CETAK</td>
    <td  style="font-size:14px"><strong><?=date('d-m-Y'); ?></strong></td>
    </tr>
</table>
<?
}elseif($id=="Print2"){
?>
<table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="5" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid; display:" id="ReportTable2">	
  <tr>
    <td width="9%" height="33"  style="font-size:14px">TAJUK</td>
    <td width="75%" style="font-size:14px"><strong><?=$tajuk?></strong></td>
    <td width="8%" rowspan="4"><img src="../images/mbpj_logo.gif" width="103" height="122"></td>
    <td width="8%" rowspan="4" align="center"><p><strong>MAJLIS BANDARAYA</strong> <strong>PETALING JAYA</strong> </p></td>
    </tr>
  <tr>
    <td height="42"  style="font-size:14px">JABATAN</td>
    <td style="font-size:14px">
    <?
		$jabatanNameStr = "";
    	$jabatanArr = explode(",",$jabatan);
		$cntJab = count($jabatanArr);
		for($i=0;$i<$cntJab;$i++){
			$jabatanName = "<b>".process_sql("select department_desc from department where department_id = ".$jabatanArr[$i],"department_desc")."</b>";
			$jabatanNameStr = ($jabatanNameStr=="")?$jabatanName:$jabatanNameStr.",&nbsp;".$jabatanName;
		}
		echo $jabatanNameStr;
	?>	
    </td>
   </tr>
  <tr>
    <td height="41"  style="font-size:14px">TEMPOH MASA</td>
    <?
    	$to=($to=="")?"-":$to;
	?>
    <td  style="font-size:14px"><b><?=$from?> Hingga <?=$to?></b></td>
  </tr>
  <tr>
    <td height="41"  style="font-size:14px">TARIKH CETAK</td>
    <td  style="font-size:14px"><strong><?=date('d-m-Y'); ?></strong></td>
    </tr>
</table>
<?	
}
?>
<br>
<br>
<br>
    <span id="columnprint" >
    </span>
	<script language="javascript">
		
		document.getElementById('columnprint').innerHTML = opener.document.getElementById('ProjDiv').innerHTML;
		$(".papar_imej").hide() 
		//data.style.width="100%";
		function effect2(i,fld,clr){
			if(i=='1'){
				fld.style.backgroundColor='#FBF995';
			}else{
				fld.style.backgroundColor=clr;
			}
		}
		function pagePrint() {
			//document.getElementById("printPage").style.visibility='hidden';
			window.print();
		}
	</script>



