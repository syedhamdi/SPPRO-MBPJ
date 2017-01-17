<div>
        <div style="border-bottom:#666666 1px solid; color: #006699; font-size: 14px; font-weight:bold; margin-bottom:5px">
        Statistik Projek
        </div>
        <?php
		$group = $_SESSION['user_group_id'];
		?>
        <div>
        <form name="theForm" method="post">
        <table width="100%" border="1" bordercolor="#FFFFFF" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid">
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
        <td>TAHUN</td>
        <td><select name="selTahun" id="selTahun">
		<?php 		
        $year=date('Y');		
        while($year!=1990){
            ?>
            <option value="<?php echo $year?>"><?php echo $year?></option>
            <?php
            $year--;	
        }		
		?>
        </select>
        </td>
      	<tr>  
        <td colspan="5" style="background-color:#666666" align="right">
            <p>
              <input type="button" name="btn_cari" value="Papar" title="Papar" class="button" onclick="searchAnalisis()" />
              <input type="reset" name="btn_reset" value="Set Semula" title="Set Semula" class="button"/>
              <!--<input type="button" name="btn_cancel" value="Batal" title="Batal" class="button" onclick="history.back()"/>-->
            </p></td>
        </tr>
        </table>
        </form>
        </div>
        <div id="analisis"></div>
</div>