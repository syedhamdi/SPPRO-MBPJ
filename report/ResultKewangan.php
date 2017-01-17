<script language="javascript">

function loadTable() {
	Form.submit();
}
</script>

<div style="position:absolute; border:0px red solid; top:5px; right:5px; cursor:hand;" onClick="printPopup();"><img src="./images/printer.gif">&nbsp;print</div>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr align="center">
	<td colspan="2">
	</td>    
    <tr>
    <td align="right">
    </td>	
    </tr>
</tr>
</table>
	<?php	
	  $dateOne = date("Y-m-d",strtotime ($dari));
	  $dateTwo = date("Y-m-d",strtotime ($ke));
	  $where="";
	 
	  $dept = $_SESSION['user_dept'];
	  $name = $_SESSION['user_name'];
	  $login = $_SESSION['user_login'];
	  //$group = $_SESSION['user_group'];
	  //echo $sql;
	?>
    <div id="report" class="mytable">
    <form action="report/exporttoexcel.php" method="post" 
    onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable2").eq(0).clone() ).html() )'>
    <table width="600px" border="0">
        <tr>
          <td></td>
        </tr>
        <tr>
          <td><input type="hidden" id="datatodisplay" name="datatodisplay">
            <input type="submit" value="Eksport ke excel">
          </td>
        </tr>
     </table>
    </form>
    <br />
    </div> 
    <div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px">
    LAPORAN MAKLUMAT KEWANGAN
    </div>
 <div id="ProjDiv" style="display:inline; position:relative; border:0px red solid; width:98%; overflow-X:auto; overflow-Y:hidden;">
<table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid" id="ReportTable2">			
            <tr class="color-header1" height="35px">
				<td rowspan="2" align="center">JENIS PEROLEHAN</td>
				<td align="center" colspan="2">SYARIKAT BUMIPUTRA</td>
				<td align="center" colspan="2">SYARIKAT BUKAN BUMIPUTRA</td>
                <td align="center" colspan="2">JUMLAH BESAR</td>
			</tr> 
            <tr class="color-header1" height="35px">
				<td align="center">Bil.</td>
                <td align="center">Jumlah Nilai Perolehan RM</td>
                <td align="center">Bil.</td>
                <td align="center">Jumlah Nilai Perolehan RM</td>
                <td align="center">Bil.</td>
                <td align="center">Jumlah Nilai Perolehan RM</td>
			</tr> 
            <tr>
            	<?php
					$sqlKategori="select project_category_id, project_category_desc from project_category";
					$phase = mysql_query($sqlKategori);
					$phaseTmp="";
					$phaseCnt=0;
					$jumBilBumi=0;
					$jumKosBumi=0;
					$jumBilNonBumi=0;
					$jumKosNonBumi=0;					
					$jumlahBilBumi=0;
					$jumlahKosBumi=0;
					$jumlahBilNonBumi=0;
					$jumlahKosNonBumi=0;
					$semuaBil=0;
					$semuaKos=0;
					while($rowPhase = mysql_fetch_array($phase)) {
						   
						if(($phaseCnt % 2)==1) {
							$class='color-row';
							$color='#fafafa';
						} else {
							$class='color-row2';
							$color='#E9E9E9';
						}
						if($jenis!="")
						{
							$where=" and p.project_type_id='".$jenis."' ";
						}
						if($jabatan!="")
						{
							$where=" and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') ";
						}
						if($dari!="" and $ke!="")
						{
							$where=" and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' ";
						}
						if($jenisKontraktor!="")
						{
							if($selKontraktor!="")
							{
								$where="and c.contractor_id='".$selKontraktor."' and p.perunding='".$jenisKontraktor."' ";
							}
							else
							{
								$where="and p.perunding='".$jenisKontraktor."' ";			
							}
						}
						if($jenis!="" and $jabatan!="")
						{
							$where=" and p.project_type_id='".$jenis."' and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') ";
						}
						if($jenis!="" and $dari!="" and $ke!="")
						{
							$where=" and p.project_type_id='".$jenis."' and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' ";
						}
						if($jenis!="" and $jenisKontraktor!="")
						{
							if($selKontraktor!="")
							{
								$where=" and p.project_type_id='".$jenis."' and c.contractor_id='".$selKontraktor."' ".
								"and p.perunding='".$jenisKontraktor."' ";
							}
							else
							{
								$where=" and p.project_type_id='".$jenis."' and p.perunding='".$jenisKontraktor."' "; 		
							}
							
						}
						if($jabatan!="" and $jenisKontraktor!="")
						{
							if($selKontraktor!="")
							{
								$where=" and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and c.contractor_id='".$selKontraktor."' ".
								"and p.perunding='".$jenisKontraktor."' ";
							}
							else
							{
								$where=" and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and p.perunding='".$jenisKontraktor."' "; 		
							}
							
						}
						if($dari!="" and $ke!="" and $jenisKontraktor!="")
						{
							if($selKontraktor!="")
							{
								$where=" and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' and ".
								"c.contractor_id='".$selKontraktor."' and p.perunding='".$jenisKontraktor."' ";
							}
							else
							{
								$where=" and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' and ".
								"p.perunding='".$jenisKontraktor."' "; 		
							}
							
						}
						if($jabatan!="" and $dari!="" and $ke!="")
						{
							$where=" and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' ";
						}
						if($jenis!="" and $jabatan!="" and $dari!="" and $ke!="")
						{
							$where=" and p.project_type_id='".$jenis."' and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' ";
						}
						if($jenis!="" and $jabatan!="" and $jenisKontraktor!="")
						{
							if($selKontraktor!="")
							{
								$where=" and p.project_type_id='".$jenis."' and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and c.contractor_id='".$selKontraktor."' and p.perunding='".$jenisKontraktor."' ";
							}
							else
							{
								$where=" and p.project_type_id='".$jenis."' and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and p.perunding='".$jenisKontraktor."' ";	
							}						
						}
						if($jenis!="" and $dari!="" and $ke!="" and $jenisKontraktor!="")
						{
							if($selKontraktor!="")
							{
								$where=" and p.project_type_id='".$jenis."' and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' and c.contractor_id='".$selKontraktor."' and p.perunding='".$jenisKontraktor."' ";
							}
							else
							{
								$where=" and p.project_type_id='".$jenis."' and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' and p.perunding='".$jenisKontraktor."' ";	
							}						
						}
						if($dari!="" and $ke!="" and $jabatan!="" and $jenisKontraktor!="")
						{
							if($selKontraktor!="")
							{
								$where=" and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and c.contractor_id='".$selKontraktor."' and p.perunding='".$jenisKontraktor."' ";
							}
							else
							{
								$where=" and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and p.perunding='".$jenisKontraktor."' ";	
							}						
						}
						if($jenis!="" and $dari!="" and $ke!="" and $jabatan!="" and $jenisKontraktor!="")
						{
							if($selKontraktor!="")
							{
								$where=" and p.project_type_id='".$jenis."' and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and c.contractor_id='".$selKontraktor."' and p.perunding='".$jenisKontraktor."' ";
							}
							else
							{
								$where=" and p.project_type_id='".$jenis."' and p.date_start > '".$dateOne."' and p.date_start < '".$dateTwo."' and (d.department_id='".$jabatan."' or d.parent_id='".$jabatan."') and p.perunding='".$jenisKontraktor."' ";	
							}						
						}
						echo "<tr class='".$class."'>";	
						echo "<td>".$rowPhase['project_category_desc']. " ";
						$sqlData="select sum(p.project_cost) as jumlahKos, count(c.bumiputra) as jumlahBil from project p ".
								"inner join project_type pt on p.project_type_id=pt.project_type_id ".
								"inner join project_category pc on p.project_category_id=pc.project_category_id ".
								"inner join contractor c on p.contractor_id=c.contractor_id ".
								"inner join department d on p.department_id=d.department_id ".
								"where c.bumiputra=1 and p.project_category_id='".$rowPhase['project_category_id']."' ".$where." ";
						//echo $sqlData;
						$phaseData = mysql_query($sqlData);
						while($rowPhaseData = mysql_fetch_array($phaseData)) {
								//echo $sqlData;
								echo "<td align='center'>".$rowPhaseData['jumlahBil']."</td>";
								echo "<td align='right'>".number_format($rowPhaseData['jumlahKos'], 2, '.', ',')."</td>";
								$jumBilBumi+=$rowPhaseData['jumlahBil'];
								$jumKosBumi+=$rowPhaseData['jumlahKos'];
						}						
						$sqlData="select sum(p.project_cost) as jumlahKos, count(c.bumiputra) as jumlahBil from project p ".
								"inner join project_type pt on p.project_type_id=pt.project_type_id ".
								"inner join project_category pc on p.project_category_id=pc.project_category_id ".
								"inner join contractor c on p.contractor_id=c.contractor_id ".
								"inner join department d on p.department_id=d.department_id ".
								"where c.bumiputra=0 and p.project_category_id='".$rowPhase['project_category_id']."' ".$where." ";
						//echo $sqlData;
						$phaseData = mysql_query($sqlData);
						while($rowPhaseData = mysql_fetch_array($phaseData)) {
								
								echo "<td align='center'>".$rowPhaseData['jumlahBil']."</td>";
								echo "<td align='right'>".number_format($rowPhaseData['jumlahKos'], 2, '.', ',')."</td>";
								$jumBilNonBumi+=$rowPhaseData['jumlahBil'];
								$jumKosNonBumi+=$rowPhaseData['jumlahKos'];
						}	
						$jumlahBilBumi+=$jumBilBumi;
						$jumlahKosBumi+=$jumKosBumi;
						$jumlahBilNonBumi+=$jumBilNonBumi;
						$jumlahKosNonBumi+=$jumKosNonBumi;
						
						
						$jumBilBumi+=$jumBilNonBumi;
						$jumKosBumi+=$jumKosNonBumi;
						
						$semuaBil+=$jumBilBumi;
						$semuaKos+=$jumKosBumi;						
						echo "<td align='center'>".$jumBilBumi."</td>";
						echo "<td align='right'>".number_format($jumKosBumi, 2, '.', ',')."</td>";
						$jumBilBumi=0;
						$jumBilNonBumi=0;
						$jumKosBumi=0;
						$jumKosNonBumi=0;
						
					}
					echo "</td>";
					echo "</tr>";
					echo "<tr class='color-header1' height='35px'>";
					echo "<td>JUMLAH</td>";
					echo "<td align='center'>".$jumlahBilBumi."</td>";
					echo "<td align='right'>".number_format($jumlahKosBumi, 2, '.', ',')."</td>";
					echo "<td align='center'>".$jumlahBilNonBumi."</td>";
					echo "<td align='right'>".number_format($jumlahKosNonBumi, 2, '.', ',')."</td>";
					echo "<td align='center'>".$semuaBil."</td>";
					echo "<td align='right'>".number_format($semuaKos, 2, '.', ',')."</td>";
					echo "</tr>";				
                ?>
                </table>
	<br><br>
</div>
	<br><br>
</div>