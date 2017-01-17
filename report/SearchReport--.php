<link rel="stylesheet" type="text/css" media="all" href="CSS/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jquery.1.4.2.js"></script>
<script type="text/javascript" src="js/jsDatePick.jquery.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from", 
			dateFormat:"%d-%m-%Y",
			showAnim:"drop"
			
		});
		new JsDatePick({
			useMode:2,
			target:"to", 
			dateFormat:"%d-%m-%Y"
		});
	};
	function printPopup() {
		url="Report/PrintReport.php?id=ProjDiv";
		window.open(url,'_blank',"width=1000, height=500, directories=no, location=no, status=no, left=100, top=50, toolbar=no, status=no, menubar=no, scrollbars=yes, resizable=yes");				
	}
	function grafPopup(pid) {
	url="report/GrafProjek.php?id="+pid;
	window.open(url,'_blank',"width=1000, height=500, directories=no, location=no, status=no, left=100, top=50, toolbar=no, status=no, menubar=no, scrollbars=yes, resizable=yes");
	}
</script>
<div>
	<div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px;">
	CARIAN MAKLUMAT PROJEK 
	</div>
	<div>
	<form name="theForm" method="post">
    <table width="100%" border="1" bordercolor="#FFFFFF" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid"> 
    <tr>
		<td colspan="4"><strong>Sila masukkan kriteria carian berikut:</strong></td>
	</tr>
    <tr>
    <td width="16%">Nama Projek</td>
    <td colspan="3"><input type="text" name="namaProjek" id="namaProjek"/>&nbsp;&nbsp;*Sila masukkan kata kunci bagi nama projek</td>
    </tr>   
    <tr>
    <td>Kontraktor/Perunding</td>
    <td colspan="3" style="position:relative; z-index:9999999999;">
    <select name="jenisKontraktor" onchange="selectJenis()">
    <option value="">--Semua--</option>
    <option value="0">Semua Kontraktor</option>
    <option value="1">Semua Perunding</option>
    </select>&nbsp;&nbsp;<span id="laporan">
    </span></td>
    </tr>  
    <tr>
    <td>Kontraktor Bumiputera</td>
    <td colspan="3">
    <select name="selBumi">
    <option value="">--Semua--</option>
    <option value="1">Ya</option>
    <option value="0">Tidak</option>
    </select>
    </td>
    </tr> 
    <tr>
	<td>Jabatan</td>
	
	<td colspan="3">
			<?
            	if (isset($_SESSION['selDept'])) {
					if ($_SESSION['selDept']!="") {
						$dept = $_SESSION['selDept'];
					} else {
						$dept = $_SESSION['user_dept'];
					}
				} else {
					if (isset($_SESSION['selDept'])) {
						$_SESSION['selDept'] = $_SESSION['user_dept'];
						$dept = $_SESSION['user_dept'];
					}
				}
				if ($_SESSION['user_group_layer']=="1") {
					$where = "where department_id = ".$_SESSION['user_dept']." or parent_id=".$_SESSION['user_dept'];
				} elseif ($_SESSION['user_group_layer']=="2") {
					$where = "where department_id = ".$_SESSION['user_dept'];
				} elseif ($_SESSION['user_group_layer']=="3") {
					$where = "";
				}
				
				$sql="select * from department ".$where." order by seq_no";
				$result = mysql_query($sql);
				//echo $_SESSION['user_group_id'];
				if (($_SESSION['user_group_id']=="1") or ($_SESSION['user_group_id']=="2")) {
					?><select name="selJabatan" id="selJabatan"><option value="">--Semua--</option><?
				}else
				{
					?><select name="selJabatan" id="selJabatan"><?
				}
				while($row = mysql_fetch_array($result)) {
					if (($row['layer']==2)&&($_SESSION['user_group_layer']!="2")) { $dash="&nbsp;---&nbsp;"; } else { $dash=""; }
					if ($_SESSION['user_group_layer']=="2") {
						?><input type="hidden" id="jabatan" value="<?=$row['department_id']?>">&nbsp;<?=$dash.$row['department_desc']?><?
					} else {
						?><option value="<?=$row['department_id']?>"><?=$dash.$row['department_desc']?></option><?
					}
				}
				if ($_SESSION['user_group_layer']!="2") {
					?></select><?
				}
			?>
    	</td>
	</tr>
    <tr>	
    <td>Kategori Projek</td>
    <td colspan="3">

    <?php 
	$sqlStatus="select * from project_category order by project_category_id";
	$resultStatus = mysql_query($sqlStatus);
	while($rowStatus = mysql_fetch_array($resultStatus)){
		?>			
		 <input type="radio" name="selKategori" id="selKategori" value="<?php echo $rowStatus[0]?>" /><?php echo $rowStatus[1]?>       
		 <?php
	}	
	?>
     <!--input type="radio" name="selKategori" id="selKategori" value="" />Perunding -->
     <input type="radio" name="selKategori" id="selKategori" checked="checked" value="" />Semua      </td>
    </tr>
    <tr>
    <td>Jenis Projek</td>
    <td colspan="3"><select name="selJenis" id="selJenis">  
    <option value="">--Semua--</option> 
    <?php 
	$sqlStatus="select * from project_type order by project_type_id";
	$resultStatus = mysql_query($sqlStatus);
	while($rowStatus = mysql_fetch_array($resultStatus)){
		?>			
		<option value="<?php echo $rowStatus[0]?>"><?php echo $rowStatus[1]?></option>
       <?php
	}	
	?>
	</select>
    </td>
    </tr> 
    <tr>	
    <td>Nombor Peruntukan</td>
    <td colspan="3">

    <select name="no_peruntukan" id="no_peruntukan">  
    <option value="">--Semua--</option> 
    <?php 
	$sqlNOP="SELECT distinct(REPLACE(no_peruntukan,' ','')) as no from project where no_peruntukan <> '' group by left(no_peruntukan,8) order by no";
	$resultNOP = mysql_query($sqlNOP);
	while($rowNOP = mysql_fetch_array($resultNOP)){
		if ($rowNOP[0] <> 'ProjekSelangorku'){
			$rowNOP[0] = $rowNOP[0];	
		}else{
			$rowNOP[0] = 'Projek Selangor';
		}
		?>			
		<option value="<?php echo substr($rowNOP[0],0,8)?>"><?php echo substr($rowNOP[0],0,8)?></option>
       <?php
    }	
	?>
	</select> </td>
    </tr>
    <tr>
    <td>Jenis Projek</td>
    <td colspan="3"><select name="selJenis" id="selJenis">  
    <option value="">--Semua--</option> 
    <?php 
	$sqlStatus="select * from project_type order by project_type_id";
	$resultStatus = mysql_query($sqlStatus);
	while($rowStatus = mysql_fetch_array($resultStatus)){
		?>			
		<option value="<?php echo $rowStatus[0]?>"><?php echo $rowStatus[1]?></option>
       <?php
	}	
	?>
	</select>
    </td>
    </tr>     
	<td>Tempoh Masa Dari</td>	
	<td width="84%"><input type="text" name="from" id="from" />
	&nbsp;Hingga&nbsp;
	&nbsp;
	<input type="text" name="to" id="to"   />
    </tr>
    <tr>
    <td>Harga Projek Dari</td>
    <td colspan="3">
   	<input text="text" name="dari" id="dari" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />&nbsp;&nbsp;Hingga&nbsp;&nbsp;&nbsp;<input type="text" name="ke" id="ke" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></td>
    </tr>
    <tr>
    <!--<tr>   
    <td>Status Projek</td>
    <td colspan="3">
    <select name="selStatus">
	<option value="">--Semua--</option>
	<?php 
	//$sqlStatus="select * from project_status order by project_status_id";
	//$resultStatus = mysql_query($sqlStatus);
	//while($rowStatus = mysql_fetch_array($resultStatus)){
		?>			
		//<option value="< ?php //echo $rowStatus[0]?>">< ?php //echo $rowStatus[1]?></option>
       <?php
	//}	
	?>
    
	</select></td>
    </tr>-->
    <tr>
    	<td>Status Projek
        </td>
        <td><select name="selStatus" id="selStatus">
        <option value="">--Semua--</option>
        <option value="1">Siap Awal</option>
        <option value="2">Siap Mengikut Jadual</option>
        <option value="3">Siap Lewat</option>
        <option value="4">Sedang Dijalankan</option>
        </select>
        </td>
    </tr>
     <tr>
    	<td>Kawasan</td>
       
        <td>
        <select id="kawasan" name="kawasan">
        	<option value=""> --Semua--</option>
            <option value="tidakberkenaan"> --Tidak Berkenaan--</option>
            <option value="semuazon"> --Semua Zon--</option>
         <?
        $sql = "select * from kawasan order by seq_no";
		$result =  mysql_query($sql);
		while($rowKwsn = mysql_fetch_array($result)){
		if($rowKwsn['layer']==1){
			?>			
			<option value="<?php echo $rowKwsn[0]?>"><?=$rowKwsn[1]?></option>
			<?	
		}
		if($rowKwsn['layer']==2){
			?>			
			<option value="<?php echo $rowKwsn[0]?>"><?="--".$rowKwsn[1]?></option>
			<?	
		}
		if($rowKwsn['layer']==3){
			?>			
			<option value="<?php echo $rowKwsn[0]?>"><?="----".$rowKwsn[1]?></option>
			<?	
		}
	}	
	?>
    	</select>
        </td>
    </tr>		
    <tr>
    	<td height="">
        </td>
    </tr>				
	<tr>	
	<td colspan="5" style="background-color:#666666" valign="bottom" align="right">
		<input type="button" name="btn_cari" value="&nbsp;&nbsp;Papar&nbsp;&nbsp;" title="Papar" class="button" onclick="searchData()" />
		<input type="reset" name="btn_reset" value="Set Semula" title="Set Semula" class="button"/>
		<!--<input type="button" name="btn_cancel" value="Batal" title="Batal" class="button" onclick="history.back()"/> -->       
    </td>
	</tr>
	</table>
	</form>
	</div>
       
</div>	