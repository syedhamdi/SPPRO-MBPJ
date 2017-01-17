<script language="javascript">

function loadTable() {
	Form.submit();
}
</script>

<div style="position:absolute; border:0px red solid; top:5px; right:5px; cursor:hand;" onClick="printPopup();"><img src="./images/printer.gif">&nbsp;print</div>
<div>
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
          
    $criteria = $_GET['criteria'];
    if($criteria!="")
    {
        $criteria2 = $_GET["criteria2"];
    }
    $bumi = $_GET['selBumi'];
    $jabatan = $_GET['selJabatan'];	
    $status = $_GET['selSenarai'];	
    
     $where="";
     $jab="";
     
     if($criteria!=""){
     	if($criteria=="0"){
			$where.= "where c.contractor_id = ".$criteria2.""; 
		}
		if($criteria=="1"){
			$where.= "where c.contractor_id = ".$criteria2.""; 
		}
		if($criteria=="2"){
			$where.= "where o.owner_name = '".$criteria2."'"; 
		}
		if($criteria=="3"){
			$where.= "where o.no_ic = ".$criteria2.""; 
		}                        
     }
     
	 if($bumi!=""){
		if($where==""){
			$where.="where c.bumiputra = ".$bumi.""; 
		}else{
			$where.=" and c.bumiputra = ".$bumi.""; 
		} 
	 }
	 
	 if($jabatan!=""){
		if($where==""){
			$where.="where d.department_id = ".$jabatan.""; 
		}else{
			$where.=" and d.department_id = ".$jabatan.""; 
		} 
	 }
	 
	  if($status!=""){
		if($where==""){
			$where.="where c.contractor_status_id = ".$status.""; 
		}else{
			$where.=" and c.contractor_status_id = ".$status.""; 
		} 
	 }	 	 
     $sqlPhase="select * ".
                "from project p inner join contractor c on p.contractor_id=c.contractor_id inner join department d on p.department_id=d.department_id ".
				"INNER JOIN owner o ON c.contractor_id = o.contractor_id ".				
                 $where." ".
                 "group by p.project_id order by c.contractor_id";
    //echo $sqlPhase;
                
    $dept = $_SESSION['user_dept'];
    $name = $_SESSION['user_name'];
    $login = $_SESSION['user_login'];
    //$group = $_SESSION['user_group'];
    //echo $sqlPhase;
    ?>
    <div id="report" class="mytable">
    <form action="report/exporttoexcel.php" method="post" 
    onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable1").eq(0).clone() ).html() )'>
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
LAPORAN MAKLUMAT KONTRAKTOR
</div> 
 <div id="ProjDiv" style="display:inline; position:relative; border:0px red solid; width:100%; overflow-X:auto; overflow-Y:hidden;">
<table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid" id="ReportTable1">
			<strong>
            <tr class="color-header1" height="35px">
				<td width="1%" align="center">BIL</td>
				<td width="29%" align="center">NAMA KONTRAKTOR/ALAMAT KONTRAKTOR/NO. TEL</td>
				<td width="20%" align="center">NAMA PEMILIK/NO. TEL/NO. IC</td>
                <td width="40%" align="center">PROJEK YANG SEDANG/TELAH DIJALANKAN</td>
				<td width="10%" align="center">STATUS KONTRAKTOR</td>
			</tr>
            </strong> 
            <?php				
			   $phase = mysql_query($sqlPhase);
			   $phaseTmp="";
			   $phaseCnt=0;
			   while($rowPhase = mysql_fetch_array($phase)) {
				   
				   if(($phaseCnt % 2)==1) {
						  $class='color-row';
						  $color='#fafafa';
					  } else {
						  $class='color-row2';
						  $color='#E9E9E9';
					  }
				   echo "<tr class='".$class."'>";	
				   echo "<td align='center'>&nbsp;".($phaseCnt+1).".</td>";
				   echo "<td align='center'>".$rowPhase['contractor_name']."<br>";
				   echo "<br>".$rowPhase['contractor_address']."<br>";
				   echo "<br><b>".$rowPhase['contractor_phone']."</b><br>";
				   echo "</td>";
				   echo "<td align='center'>";
				   if ($rowPhase['contractor_id']!="") {
					   $sqlProj = "SELECT owner_id, owner_name, no_tel, no_ic, address FROM owner ".
														"WHERE contractor_id=".$rowPhase['contractor_id']." ";						
					   $proj = mysql_query($sqlProj);
					   while ($rowSystem = mysql_fetch_array($proj)) {
								  echo $rowSystem['owner_name']."<br>";
								  echo $rowSystem['no_ic']."<br>";
								  echo $rowSystem['no_tel']."<br><br>";
							  }
					   if (mysql_num_rows($proj)==0)	
					   {
						   echo "<b>Tiada</b>";
					   }									
					   echo "</td>";							
				   }
				   echo "<td>";
				   echo "<b>".$rowPhase['project_reference']."</b><br>";
				   echo $rowPhase['project_name']."<br><br>";
				   echo "Kos Projek: RM".number_format($rowPhase['project_cost'], 2, '.', ',')."<br>";
				   echo "Tarikh Mula: ".date("d-M-Y", strtotime($rowPhase['date_start']))."<br>";
				   echo "Tarikh Siap: ".date("d-M-Y", strtotime($rowPhase['date_end']))."<br>";
				   echo "Jabatan/Bahagian: ".$rowPhase['department_desc']."<br><br>";
				   echo "<td valign='middle' align='center'>";
				   if($rowPhase['contractor_status_id']==0)
				   {
					   echo "Putih";
				   }
				   else
				   {
					   echo "Hitam";
				   }
				   echo "</td>";
				   echo "</tr>";	
				   $phaseCnt++;
			   }		 
			   if(mysql_num_rows($phase)==0)
			   {
				   echo "<td align='center' colspan='5'>Tiada Rekod</td></tr>";
			   }
			   //echo $sql;
		  ?>	
			</table>
	<br><br>
</div>
	<br><br>
</div>