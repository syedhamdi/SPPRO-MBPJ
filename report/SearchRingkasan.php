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
			dateFormat:"%d-%m-%Y",
			showAnim:"drop"
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
	
	function proDirancangS(obj){
		if(document.getElementById(obj).checked == true){
			document.getElementById("konTr").style.display = "none"
			document.getElementById("BumiTr").style.display = "none"
			document.getElementById("StatTr").style.display = "none"
			document.getElementById("kategoriSemua").style.display = "inline"
			document.getElementById("StatTrD").style.display = "inline"
		}else{
			document.getElementById("StatTrD").style.display = "none"
			document.getElementById("kategoriSemua").style.display = "none"
			document.getElementById("konTr").style.display = "inline"
			document.getElementById("BumiTr").style.display = "inline"
			document.getElementById("StatTr").style.display = "inline"
		}
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
    <tr style="display:none;">
    <td width="16%">Projek Dirancang</td>
    <td colspan="3"><input type="checkbox" name="proDirancang" id="proDirancang"/></td>
    </tr> 
    <td>Jabatan</td>	
	<td colspan="3">
		<div id="jabatan">
        <table border="0">
        <?php
        	$sql = "select * from department where layer = 1";
			$result =  mysql_query($sql);
			$cntJab = 0;
			echo "<tr>";
			while($rowJabatan = mysql_fetch_array($result)){
				$cntJab = $cntJab + 1;
					echo "<td>";
					echo "<input type='checkbox' name='checkbox_jabatan[]' value=".$rowJabatan['department_id']." id='checkbox_jabatan' />";
					echo $rowJabatan['department_desc'];
					echo "</td>";
				if($cntJab%3==0){
					echo "</tr>";
					echo "<tr>";
				}
			}
			echo "</tr>";
		?>
        </table>
        </div>		
    </td>
	</tr>
    <tr style="display:none;">	
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
    	<input type="radio" checked="checked" name="selKategori" id="selKategori" value="0" />Semua       
     <!--input type="radio" name="selKategori" id="selKategori" value="" />Perunding -->
     <!--input type="radio" name="selKategori" id="selKategori" checked="checked" value="" >Semua     <--> </td>
    </tr>
    <!--tr>	
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
    </tr-->
    <tr  style="display:none;">	
    <td>Ketegori Peruntukan</td>
    <td colspan="3">
    <select name="no_peruntukan" id="no_peruntukan">  
    <option value="">--Semua--</option> 
    <option value="1"> MBPJ 11,12,13 </option>
    <option value="2"> MBPJ 30 </option>
    <option value="3"> Akaun Amanah 50 </option>
	</select></td>
    </tr>
    <tr>
    </tr>     
	<td>Tempoh Masa Dari</td>	
	<td width="84%"><input type="text" name="from" id="from"/>
	&nbsp;Hingga&nbsp;
	&nbsp;
	<input type="text" name="to" id="to"/>
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
    <tr id="StatTrD" style="display:none;">
    	<td>Status Projek
        </td>
        <td><select name="selStatusD" id="selStatusD">
        <option value="">--Semua--</option>
        <option value="0">Dalam Perancangan</option>
        <option value="1">Dalam Pelaksanaan</option>
        </select>
        </td>
    </tr>
    <tr>
    	<td height="">
        </td>
    </tr>				
	<tr>	
	<td colspan="5" style="background-color:#666666" valign="bottom" align="right">
		<input type="button" name="btn_cari" value="&nbsp;&nbsp;Papar&nbsp;&nbsp;" title="Papar" class="button" onclick="searchRingkasan()" />
		<input type="reset" name="btn_reset" value="Set Semula" title="Set Semula" class="button"/>
		<!--<input type="button" name="btn_cancel" value="Batal" title="Batal" class="button" onclick="history.back()"/> -->       
    </td>
	</tr>
	</table>
	</form>
	</div>
       
</div>	