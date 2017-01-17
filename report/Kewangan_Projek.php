<link rel="stylesheet" type="text/css" media="all" href="CSS/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jquery.1.4.2.js"></script>
<script type="text/javascript" src="js/jsDatePick.jquery.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from", 
			dateFormat:"%d-%m-%Y"
			
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
</script>
<div>
        <div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px">
        CARIAN MAKLUMAT KEWANGAN
        </div>
        <div>
        <form name="theForm" method="post">
        <table width="100%" border="1" bordercolor="#FFFFFF" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid"> 
       	<tr>
			<td colspan="4"><strong>Sila masukkan kriteria carian berikut:</strong></td>
		</tr>
        <tr>
        <td>Tempoh Masa Dari</td>	
        <td width="90%"><input type="text" name="from" id="from" style="z-index:99999999999999999999999;"  />
        &nbsp;Hingga&nbsp;
        &nbsp;
        <input type="text" name="to" id="to" style="z-index:99999999999999999999999;"  />
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
				if ($_SESSION['user_group_id']=="1") {
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
        <td width="15%">Nama Kontraktor</td>
        <td><select name="jenisKontraktor" id="jenisKontraktor" onchange="selectJenis()">
        <option value="">--Semua--</option>
        <option value="0">Kontraktor</option>
        <option value="1">Perunding</option>
        </select>
        <span id="laporan"><span></td>
        </tr>
        <tr>
        <tr>
        <td>Jenis Projek</td>
        <td colspan="3"><select name="selJenis">  
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
        <tr><td height="120"></td></tr>
        <tr>  
        <td colspan="5" style="background-color:#666666" align="right">
            <p>
              <input type="button" name="btn_cari" value="&nbsp;&nbsp;Papar&nbsp;&nbsp;" title="Papar" class="button"  onclick="searchWang()" />
              <input type="reset" name="btn_reset" value="Set Semula" title="Set Semula" class="button"/>
              <!--<input type="button" name="btn_cancel" value="Batal" title="Batal" class="button" onclick="history.back()"/>-->
            </p></td>
        </tr>
        </table>
        </form>
        </div>
        <div id="kewangan"></div>
</div>