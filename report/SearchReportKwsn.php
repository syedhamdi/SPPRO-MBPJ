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
    <td width="16%">Projek Dirancang</td>
    <td colspan="3"><input type="checkbox" name="proDirancang" id="proDirancang" /></td>
    </tr> 
    <tr>
    </tr>     
	<td>Tempoh Masa Dari</td>	
	<td width="84%"><input type="text" name="from" id="from" />
	&nbsp;Hingga&nbsp;
	&nbsp;
	<input type="text" name="to" id="to"   />
    <font color="#FF0000">
	<?
		$dateS = "";
		$dateE = "";
    	if($_SESSION['ahli_majlis']<>0){
			$dateS = process_sql("select dateS from ahli where ahli_id = ".$_SESSION['ahli_majlis'],"dateS");
			$dateE = process_sql("select dateE from ahli where ahli_id = ".$_SESSION['ahli_majlis'],"dateE");
			if($dateE == "2999-01-01"){
				$dateE = "Sekarang";	
			}else{
				$dateE = date("d-m-Y", strtotime($dateE));	
			}
			$dateS = date("d-m-Y", strtotime($dateS));
			echo "&nbsp;&nbsp;Tarikh Efektif ".$dateS." hingga ".$dateE."";	
		}
	?>
    </font>
    </tr>
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
    	<td>Kawasan</td>
       
        <td>
        <select id="kawasan" name="kawasan">
        <?
        if($_SESSION['ahli_majlis']==0){
			?>
				<option value="0"> -- SEMUA --</option>
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
					<option value="<?php echo $rowKwsn[0]?>"><?="--&nbsp;".$rowKwsn[1]?></option>
					<?	
				}
				if($rowKwsn['layer']==3){
					?>			
					<option value="<?php echo $rowKwsn[0]?>"><?="----&nbsp;".$rowKwsn[1]?></option>
					<?	
				}
			}
		}else{
			if($_SESSION['peringkat_id']==1){
				
				$sql_1 = "select * from kawasan where kwsn_id = ".$_SESSION['kawasan_id']." order by seq_no";
				$result_1 = mysql_query($sql_1);
				while($rowKwsn_1 = mysql_fetch_array($result_1)){		
					?>			
					<option value="<?php echo $rowKwsn_1[0]?>"><?=$rowKwsn_1[1]?></option>
					<?						
					$sql_2 = "select * from kawasan where parent_id = ".$_SESSION['kawasan_id']." order by seq_no";
					$result_2 = mysql_query($sql_2);
					while($rowKwsn_2 = mysql_fetch_array($result_2)){		
						?>			
						<option value="<?php echo $rowKwsn_2[0]?>"><?="--&nbsp;".$rowKwsn_2[1]?></option>
						<?						
						$sql_3 = "select * from kawasan where parent_id = ".$rowKwsn_2['kwsn_id']." order by seq_no";
						$result_3 = mysql_query($sql_3);
						while($rowKwsn_3 = mysql_fetch_array($result_3)){		
							?>			
							<option value="<?php echo $rowKwsn_3[0]?>"><?="----&nbsp;".$rowKwsn_3[1]?></option>
							<?						
						}	
					}	
				}				
			}else if($_SESSION['peringkat_id']==2){
				$sql_1 = "select * from kawasan where kwsn_id = ".$_SESSION['kawasan_id']." order by seq_no";
				$result_1 = mysql_query($sql_1);
				while($rowKwsn_1 = mysql_fetch_array($result_1)){		
					?>			
					<option value="<?php echo $rowKwsn_1[0]?>"><?=$rowKwsn_1[1]?></option>
					<?						
					$sql_2 = "select * from kawasan where parent_id = ".$_SESSION['kawasan_id']." order by seq_no";
					$result_2 = mysql_query($sql_2);
					while($rowKwsn_2 = mysql_fetch_array($result_2)){		
						?>			
						<option value="<?php echo $rowKwsn_2[0]?>"><?="--&nbsp;".$rowKwsn_2[1]?></option>
						<?						
					}	
				}
			}else if($_SESSION['peringkat_id']==3){
				$sql_1 = "select * from kawasan where kwsn_id = ".$_SESSION['kawasan_id']." order by seq_no";
				$result_1 = mysql_query($sql_1);
				while($rowKwsn_1 = mysql_fetch_array($result_1)){		
					?>			
					<option value="<?php echo $rowKwsn_1[0]?>"><?="----&nbsp;".$rowKwsn_1[1]?></option>
					<?						
				}
			}
		}
		?>
    	</select>
        
        <input type="hidden" id="dateS" name="dateS" value="<?=$dateS?>" />
    	<input type="hidden" id="dateE" name="dateE" value="<?=$dateE?>" />
        <input type="hidden" id="ahli_majlis" name="ahli_majlis" value="<?=$_SESSION['ahli_majlis']?>">
        </td>
    </tr>		
    <tr>
    	<td height="">
        </td>
    </tr>				
	<tr>	
	<td colspan="5" style="background-color:#666666" valign="bottom" align="right">
		<input type="button" name="btn_cari" value="&nbsp;&nbsp;Papar&nbsp;&nbsp;" title="Papar" class="button" onclick="searchDataKwsn()" />
		<input type="reset" name="btn_reset" value="Set Semula" title="Set Semula" class="button"/>
		<!--<input type="button" name="btn_cancel" value="Batal" title="Batal" class="button" onclick="history.back()"/> -->       
    </td>
	</tr>
	</table>
	</form>
	</div>
       
</div>	