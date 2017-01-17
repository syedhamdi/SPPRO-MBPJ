<html>
<head>
<script language="javascript">


function loadTable() {
	Form.submit();
}

function printReport(){
	//window.open("report/printreport.php", "", "width=400,height=500,top=50,left=280, 
	//resizable,toolbar,scrollbars,menubar,"); 	
}
</script>
<style type="text/css">
		@media print
		{
		  table { page-break-after:auto }
		  tr    { page-break-inside:avoid; page-break-after:auto }
		  td    { page-break-inside:avoid; page-break-after:auto }
		  thead { display:table-header-group }
		  tfoot { display:table-footer-group }
		}
  </style>
</head>
<body>    
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
		$jimat_lebih2=0;
		$Control=0;
		$Control1=0;
		$Control2=0;
		$Control3=0;

	$dateOne = date("Y-m-d",strtotime ($from));
	$dateTwo = date("Y-m-d",strtotime ($to));
	$where="";
	$whereStr="";		
	$statusSql = "";

	if($namaProjek != ""){
		$whereStr = "P.project_name like '%".$namaProjek."%'";	
		$where = "where ";
	}else{
		$whereStr = "";	
	}
	
	if($jabatan!=""){
		$jabatanlevel = process_sql("select * from department where department_id =".$jabatan,"layer");
		$jabatanParent = process_sql("select * from department where department_id =".$jabatan,"parent_id");
		if($jabatanlevel==2){
			if($whereStr != ""){
				$whereStr = $whereStr." and P.department_id = ".$jabatan."";
				$where = "where ";
			}else{
				$whereStr = " P.department_id = ".$jabatan."";
				$where = "where ";
			}	
		}else{
			if($whereStr != ""){
				$whereStr = $whereStr." and (D.parent_id = ".$jabatan." or P.department_id=".$jabatan.") ";
				$where = "where ";
			}else{
				$whereStr = " (D.parent_id = ".$jabatan." or P.department_id=".$jabatan.") ";
				$where = "where ";
			}	
		}	
	}
	
	if($kategori != "0"){
		if($whereStr != ""){
			$whereStr = $whereStr." and P.project_category_id = ".$kategori."";
			$where = "where ";
		}else{
			$whereStr = " P.project_category_id = ".$kategori."";
			$where = "where ";
		}		
	}
	
	if($jenis != ""){
		if($whereStr != ""){
			$whereStr = $whereStr." and P.project_type_id = ".$jenis."";
			$where = "where ";
		}else{
			$whereStr = " P.project_type_id = ".$jenis."";
			$where = "where ";
		}		
	}
	
	if($from != ""){
		if($whereStr != ""){
			$whereStr = $whereStr." and P.date_start >= '".$dateOne."'";
			$where = "where ";
		}else{
			$whereStr = " P.date_start >= '".$dateOne."'";
			$where = "where ";
		}		
	}
	
	if($to != ""){
		if($whereStr != ""){
			$whereStr = $whereStr." and P.date_start <= '".$dateTwo."'";
			$where = "where ";
		}else{
			$whereStr = " P.date_start <= '".$dateTwoad."'";
			$where = "where ";
		}		
	}
	
	if($dari != ""){
		if($whereStr != ""){
			$whereStr = $whereStr." and P.project_cost >= '".str_replace(",","",$dari)."'";
			$where = "where ";
		}else{
			$whereStr = " P.project_cost >= '".str_replace(",","",$dari)."'";
			$where = "where ";
		}		
	}
	
	if($ke != ""){
		if($whereStr != ""){
			$whereStr = $whereStr." and P.project_cost <= '".str_replace(",","",$ke)."'";
			$where = "where ";
		}else{
			$whereStr = " P.project_cost <= '".str_replace(",","",$ke)."'";
			$where = "where ";
		}		
	}
	
	if($selStatusD != ""){
		if($whereStr != ""){
			$whereStr = $whereStr." and P.p_award = '".$selStatusD."'";
			$where = "where ";
		}else{
			$whereStr = " P.p_award = '".$selStatusD."'";
			$where = "where ";
		}		
	}
	//if($no_peruntukan!=""){
	//	if($whereStr != ""){
	//		$whereStr = $whereStr." and p.no_peruntukan like '%".$no_peruntukan."%'";
	//		$where = "where ";
	//	}else{
	//		$whereStr = " p.no_peruntukan like '%".$no_peruntukan."%'";
	//		$where = "where ";
	//	}	
	//}
	if($no_peruntukan!=""){
		if($no_peruntukan==1){
			$param = "11";
			$param2 = " or p.no_peruntukan LIKE '12%' or p.no_peruntukan LIKE '13%'";
		}elseif($no_peruntukan==2){
			$param = "30";
			$param2 = "";
		}elseif($no_peruntukan==3){
			$param = "50";
			$param2 = "";
		}
		
		if($whereStr != ""){
			$whereStr = $whereStr." and (p.no_peruntukan like '".$param."%' ".$param2.")";
			$where = "where ";
		}else{
			$whereStr = " p.no_peruntukan like '".$param."%'";
			$where = "where ";
		}	
	}
	if($kawasan!=""){
		if($kawasan == "tidakberkenaan"){
			if($whereStr != ""){
				$where2 = " and (p.kwsn_id_p IS NULL or p.kwsn_id_p = 0) and (p.kwsn_id_a IS NULL or p.kwsn_id_a = 0) and (p.kwsn_id_m IS NULL  or p.kwsn_id_m = 0) and (p.semuazon = 0)";
			}else{
				$where2 = "where (p.kwsn_id_p IS NULL  or p.kwsn_id_p = 0) and (p.kwsn_id_a IS NULL or p.kwsn_id_a = 0) and (p.kwsn_id_m IS NULL or p.kwsn_id_m = 0) and (p.semuazon = 0)";
			}
			
		}
		elseif($kawasan == "semuazon"){
			if($whereStr != ""){
				$where2 = "and (p.semuazon = 1)";
			}else{
				$where2 = "where (p.semuazon = 1)";
			}
			
		}else{
		$layer = process_sql("select layer from kawasan where kwsn_id = ".$kawasan,"layer");
			if($layer == 3){
				if($whereStr != ""){
					$where2 = " and (p.kwsn_id_m = ".$kawasan.")";
				}else{
					$where2 = "where (p.kwsn_id_m = ".$kawasan.")";
				}
			}
			if($layer == 2){
				if($whereStr != ""){
					$where2 = " and (p.kwsn_id_a = ".$kawasan.")";
				}else{
					$where2 = "where (p.kwsn_id_a = ".$kawasan.")";
				}
			}
			if($layer == 1){
				if($whereStr != ""){
					$where2 = " and (p.kwsn_id_p = ".$kawasan.")";
				}else{
					$where2 = "where (p.kwsn_id_p = ".$kawasan.")";
				}
			}
		}
	}else{
		$where2 = "";
	}
	$sqlDept="SELECT distinct(d.department_id) ".
			  "D.department_desc, PC.project_category_desc, PT.project_type_desc, PC.project_category_short, P.perunding,P.project_cost_month,P.project_cost_year,P.no_peruntukan ".
			  "FROM project_dirancang AS P ".
			  $statusSql.
			  "INNER JOIN department AS D ON P.department_id=D.department_id ".
			  "LEFT JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
			  "INNER JOIN project_type PT ON P.project_type_id=PT.project_type_id ".
			  "LEFT JOIN kawasan kwsn ON P.kwsn_id_p=kwsn.kwsn_id ".
			  $where.$whereStr.$where2.
			  " order by D.seq_no";
			  
 	$sql="SELECT *,P.project_reference, P.project_name, P.project_cost, P.date_start, P.date_end, P.pegawai_projek, P.pen_pegawai_projek, P.ptbk,
			  P.project_duration, P.project_id, P.catatan, P.project_type_id, P.project_category_id, ".
			  "D.department_desc, PC.project_category_desc, PT.project_type_desc, PC.project_category_short, P.perunding,P.project_cost_month,P.project_cost_year,P.no_peruntukan ".
			  "FROM project_dirancang AS P ".
			  $statusSql.
			  "INNER JOIN department AS D ON P.department_id=D.department_id ".
			  "LEFT JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
			  "INNER JOIN project_type PT ON P.project_type_id=PT.project_type_id ".
			  "LEFT JOIN kawasan kwsn ON P.kwsn_id_p=kwsn.kwsn_id ".
			  $where.$whereStr.$where2.
			  " ORDER BY P.seq_year,P.seq_category,P.seq";
	//echo $selKontraktor;
	//echo $sql;		
	//$dept = $_SESSION['user_dept'];
	$name = $_SESSION['user_name'];
	$login = $_SESSION['user_login'];
	
	$total_cost = 0;
	$totalPayment = 0;

	$date_max = 0;
	$date_min = 9999999;
	$arrId = "";
	$totalCostY = 0;
	$costM = 0;
	$totalstartY = 0;
	$totalstartY2 = 0;
	$totalstartYx = 0;
	//$group = $_SESSION['user_group'];
	//echo exit();
	?>    
    <div id="report" class="mytable">
    <form action="report/exporttoexcel.php" method="post" 
    onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'>
    <table width="600px" border="0">
        <tr>
          <td></td>
        </tr>
        <tr>
          <td><input type="hidden" id="datatodisplay" name="datatodisplay">
            <input type="submit" value="Eksport ke excel">&nbsp;&nbsp; <input type="Button" value="Printer Friendly" ONCLICK="javascript:window.open('report/PrintReport.php?id=Print1&tajuk=LAPORAN MAKLUMAT PROJEK&kategori=<?=$kategori?>&kawasan=<?=$kawasan?>&from=<?=$from?>&to=<?=$to?>')">
          </td>
        </tr>
     </table>
    </form>
    <br />
    </div> 
    <div id="Print1">
    <div id="ProjDiv">
    <div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px;">LAPORAN MAKLUMAT PROJEK DIRANCANG</div>
<table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; padding-top:10px; padding-bottom:10px; width:100%; border:#999999 1px solid;" id="ReportTable" >
            <thead>
            <tr class="color-header1" height="35px"  style="page-break-inside: avoid;">
           		<th rowspan="2">BIL</th>				
				<th rowspan="2">NO. PERUNTUKAN</th>
				<th rowspan="2">NAMA PROJEK</th>
				<th rowspan="2">PEGAWAI BERTANGGUNGJAWAB</th>
				<th rowspan="2">HARGA KONTRAK (RM)</th>				
				<th rowspan="2">TARIKH MULA</th>
				<th rowspan="2">TARIKH SIAP</th>
                <th rowspan="2">TEMPOH</th>
                <th rowspan="2">NAMA KONTRAKTOR</th>
                <!--th rowspan="2">KOS SEBENAR PROJEK</th-->
                <!--th rowspan="2">TARIKH MULA</th>
                <th rowspan="2">TARIKH SIAP</th-->
                <th rowspan="2">STATUS DOKUMEN</th>
                <th rowspan="2">STATUS PROJEK</th>
                <!--<th rowspan="2">KATEGORI PROJEK</th>
                <th rowspan="2">JENIS PROJEK</th>-->
				<th rowspan="2">CATATAN</th>
                <th rowspan="2">KAWASAN</th>
			</tr>
            </thead>
        	<tbody>
            	<?php	
					$phase = mysql_query($sql);
					$phaseTmp="";
					$phaseCnt=0;
					$statDoc0 = 0;
					$statDoc1 = 0;
					$statDoc2 = 0;
					$statDoc3 = 0;
					$statDoc4 = 0;
					$statDoc5 = 0;
					 
					while($rowPhase = mysql_fetch_array($phase)) {	
					set_time_limit(0);

					//list all id
					if($arrId=="")
						$arrId = $rowPhase['project_id'];
					else{
						$arrId = $arrId.",".$rowPhase['project_id'];	
					}	

							
							 if(($phaseCnt % 2)==1) {
									$class='color-row';
									$color='#fafafa';
								} else {
									$class='color-row2';
									$color='#E9E9E9';
								}						
							 
							 	if($phaseCnt==0) {
									$pgBreak='avoid';
								} else if(($phaseCnt % 2)==0) {
									$pgBreak='always';
								} else {
									$pgBreak='avoid';
								}
								
							 echo "<tr class='".$class."' style='page-break-before: ".$pgBreak." '>";	
							 echo "<td valign='middle'>&nbsp;<b>".($phaseCnt+1)."."."</b></td>";
							 echo "<td valign='middle' align='center'>";
							 if($rowPhase['no_peruntukan']=="")
							 {
								 $rowPhase['no_peruntukan']="TIADA";
							 }
							 
							 echo "".$rowPhase['no_peruntukan']."<br><br><b>Jenis Projek:</b><br>".process_sql("select * from project_type where project_type_id = ".$rowPhase["project_type_id"]."","project_type_desc")."<br><br><b>Kategori Projek:</b><br>".process_sql("select * from project_category where project_category_id = ".$rowPhase["project_category_id"]."","project_category_desc")."</td>";
							 echo "<td align='left'>".$rowPhase['project_name']."</td>";
							 echo "<td>";
							 $pegName="";
							 if($rowPhase['pegawai_projek']!=0)
							 {
								 $sqlPeg = "SELECT user_name FROM user ".
										   "WHERE user_id=".$rowPhase['pegawai_projek']."";							
								 $peg = mysql_query($sqlPeg);
								 while($rowPeg = mysql_fetch_array($peg)){
									 $pegName = $rowPeg['user_name'];
								 }
							 }
							 else
							 {
								 $pegName="TIADA";
							 }	
							 if($rowPhase['pen_pegawai_projek']=="")
							 {
								 $rowPhase['pen_pegawai_projek']="TIADA";
							 }
							 if($rowPhase['ptbk']=="")
							 {
								 $rowPhase['ptbk']="TIADA";
							 }
							 echo "<b>Pegawai Projek:</b><br>".$pegName."<br><br>";	
							 echo "<b>Penolong Pegawai Projek:</b><br>".$rowPhase['pen_pegawai_projek']."<br><br><b>PTBK/PTB/Juruteknik:</b><br>".$rowPhase['ptbk']."<br>";							
							 echo "<td align='center'><br><b>Anggaran :</b><br>";
							 //kos sebenar
							 $sqlKosA ="select p.project_costA from project p ".
									"inner join project_dirancang pd on p.dr_Pro_Dirancang = pd.project_id ".
									"where pd.project_id = ".$rowPhase['project_id'];
							 $KosA = number_format(process_sql($sqlKosA,"project_costA"),2)."<br>";	 
							 if($KosA == 0){
								$KosA = "&nbsp;";	 
							 }
							 
							 $sqlKosPM ="select p.project_cost_month from project p ".
									"inner join project_dirancang pd on p.dr_Pro_Dirancang = pd.project_id ".
									"where pd.project_id = ".$rowPhase['project_id'];
							 $KosPM = number_format(process_sql($sqlKosPM,"project_cost_month"),2);
							 if($KosPM == "0.00"){
								$KosPM = "&nbsp;";	 	 
							 }else{
								$KosPM = "Bulanan:&nbsp;".number_format(process_sql($sqlKosPM,"project_cost_month"),2)."<br>";	 
							 }
							 
							 $sqlKosPY ="select p.project_cost_year from project p ".
									"inner join project_dirancang pd on p.dr_Pro_Dirancang = pd.project_id ".
									"where pd.project_id = ".$rowPhase['project_id'];							 
							 $KosPY = number_format(process_sql($sqlKosPY,"project_cost_year"),2);
							 if($KosPY == "0.00"){
								$KosPY = "&nbsp;";	 
							 }else{
								$KosPY = "Tahunan:&nbsp;".number_format(process_sql($sqlKosPY,"project_cost_year"),2);	 
							 }
							 
							 if($KosA.$KosPM.$KosPY == "&nbsp;&nbsp;&nbsp;"){
								 $kosSebenar = "";
							 }else{
								 $kosSebenar = $KosA.$KosPM.$KosPY; 
							 }
							
							 echo number_format($rowPhase['project_costA'], 2, '.', ',')."";
							 $totalCostY=$totalCostY+$rowPhase['project_costA'];
							 if($rowPhase['project_cost_month']> 0.00)
							 {
								 echo "<br>Bulanan: ".number_format($rowPhase['project_cost_month'], 2, '.', ',')."";
							 }
							 if($rowPhase['project_cost_year']> 0.00)
							 {
								 echo "<br>Tahunan: ".number_format($rowPhase['project_cost_year'], 2, '.', ',')."";
							 } 
							 
							 $sqlDS ="select p.date_start from project p ".
									"inner join project_dirancang pd on p.dr_Pro_Dirancang = pd.project_id ".
									"where pd.project_id = ".$rowPhase['project_id'];
							 
							 $dateStart = process_sql($sqlDS,"date_start");
							 
							 $sqlDE ="select p.date_end from project p ".
									"inner join project_dirancang pd on p.dr_Pro_Dirancang = pd.project_id ".
									"where pd.project_id = ".$rowPhase['project_id'];
							 
							 $dateEnd = process_sql($sqlDE,"date_end");
							 
							 $sqlDateTS = "select tarikhMasukTS from contractor c ".
									"inner join project p on p.contractor_id = c.contractor_id ".
									"inner join project_dirancang pd on p.dr_Pro_Dirancang = pd.project_id ".
									"where pd.project_id =".$rowPhase['project_id'] ;
	
							 $dateTS = process_sql($sqlDateTS,"tarikhMasukTS");
							 
							 if($rowPhase['p_award']==1){
							 	$dateStart = date("d/m/Y", strtotime($dateStart));
								$dateEnd = date("d/m/Y", strtotime($dateEnd));	
								$dateTS = date("d/m/Y", strtotime($dateTS));
								$dateTS = cnvrtMonthYear($dateTS);
							 }else{
								$dateStart = "&nbsp;";
								$dateEnd = "&nbsp;";
								$dateTS = "&nbsp;";
							 }
							 echo "<br><br><b>Sebenar :</b><br>".$kosSebenar;
							 echo "</td>";
							 echo "<td align='center'><b>Anggaran :</b><br>".date("d/m/Y", strtotime($rowPhase['date_start']))."<br><br><b>Sebenar :</b><br>".$dateStart."</td>";
							 echo "<td align='center'><b>Anggaran :</b><br>".date("d/m/Y", strtotime($rowPhase['date_end']))."<br><br><b>Sebenar :</b><br>".$dateEnd."</td>";
							 echo "<td align='center'>".$rowPhase['project_duration']."</td>";
							 
							 $sqlCN = "select contractor_name from contractor c ".
									"inner join project p on p.contractor_id = c.contractor_id ".
									"inner join project_dirancang pd on p.dr_Pro_Dirancang = pd.project_id ".
									"where pd.project_id =".$rowPhase['project_id'] ;
	
							 $contractorName = process_sql($sqlCN,"contractor_name")."";
							 
							 echo "<td align='center'>".$contractorName."&nbsp;</td>";
							 //echo "<td align='center'>".$kosSebenar."&nbsp;</td>";							 
							 //echo "<td align='center'>".$dateStart."&nbsp;</td>";
							 //echo "<td align='center'>".$dateEnd."&nbsp;</td>";
							 
							 if($rowPhase['tarikhDirancangTS']==""){
							 	$tarikhDirancangTS = "&nbsp;";
							 }else{
							 	$tarikhDirancangTS = date("d/m/Y", strtotime($rowPhase['tarikhDirancangTS']));
								$tarikhDirancangTS = cnvrtMonthYear($tarikhDirancangTS);
							 }
							 
							 if($rowPhase['p_award']==0){
								 $statusP = "<font color=''><b>Dalam Perancangan</b></font>";
							 }else{
							 	 $statusP = "<font color=''><b>Dalam Perlaksanaan</b></font>";
							 }
							 
							 if($rowPhase['statDoc']==0){
								 $statDoc = "Tiada Status";
								 $bgColor = "";
								 $statDoc0 = $statDoc0+1;
							 }elseif($rowPhase['statDoc']==1){
							 	 $statDoc = "Penyediaan&nbsp;Dokumen";
							 	 $bgColor = "#FF3C3C";
								 $statDoc1 = $statDoc1+1;
							 }elseif ($rowPhase['statDoc']==2){
							 	 $statDoc = "Pelawaan";
								 $bgColor = "#FFFF2F";
								 $statDoc2 = $statDoc2+1;
							 }elseif($rowPhase['statDoc']==3){
							 	 $statDoc = "Penilaian";
								 $bgColor = "#FF9900";
								 $statDoc3 = $statDoc3+1;
							 }elseif($rowPhase['statDoc']==4){
							 	 $statDoc = "Pelantikan";
								 $bgColor = "#28FF28";
								 $statDoc4 = $statDoc4+1;
							 }elseif($rowPhase['statDoc']==5){
							 	 $statDoc = "Sedang&nbsp;Dijalankan";
								 $bgColor = "#5E5EFF";
								 $statDoc5 = $statDoc5+1;
							 }
							 
							 //echo "<td align='center'>".$tarikhDirancangTS."<br><br><b>Status Projek:</b><br>".$statusP."<br><br><b>Status&nbsp;Dokumen:</b><br>".$statDoc."</td>";
							 echo "<td align='center' bgcolor='".$bgColor."'><b>Status&nbsp;Dokumen:</b><br>".$statDoc."</td>";
							 echo "<td align='center'>".$statusP."<br>".$dateTS."</td>";
							 if($rowPhase['catatan']==""){
								 $rowPhase['catatan']="-";
							 }
							 echo "<td align='left'>".$rowPhase['catatan']."";							
							 //echo "<td align='left'><b>".$rowPhase['project_category_short']."</b>";	 
							 echo "</td>";
							 echo "<td align='center'>";
							
							 if($rowPhase["semuazon"]<> 1){
							 
								 if(($rowPhase['kwsn_id_p']!="") && (!is_null($rowPhase['kwsn_id_p'])) && ($rowPhase['kwsn_id_p']!=0)){
									 $parlimen = "<strong>PARLIMEN</strong> :<br>".process_sql("select kwsn_desc from kawasan where kwsn_id = ".$rowPhase['kwsn_id_p'],"kwsn_desc")."<br><br>";
									if(($rowPhase['kwsn_id_a']!="") && ($rowPhase['kwsn_id_a'] != 0) && (!is_null($rowPhase['kwsn_id_a']))){
										$majlis = "<strong>ADUN</strong> :<br>".process_sql("select kwsn_desc from kawasan where kwsn_id = ".$rowPhase['kwsn_id_a'],"kwsn_desc")."<br><br>";	
									}else{
										$majlis = "";	
									}
									if(($rowPhase['kwsn_id_m']!="") && ($rowPhase['kwsn_id_m'] != 0) && (!is_null($rowPhase['kwsn_id_m']))){
										$zon = "<strong>A.MAJLIS</strong> :<br>".process_sql("select kwsn_desc from kawasan where kwsn_id = ".$rowPhase['kwsn_id_m'],"kwsn_desc")."<br><br><b>".process_sql("select nama_ahli from ahli where (dateS <= '".$rowPhase['date_start']."' and dateE >= '".$rowPhase['date_start']."') and kawasan_id = ".$rowPhase['kwsn_id_m'],"nama_ahli")."</b>";	
									}else{
										$zon = "";	
									}		 
								 }else{
									$parlimen = "TIADA";
									$majlis = "";
									$zon = "";	 
								 }
								 
								 echo $parlimen;
								 echo $majlis;
								 echo $zon;
								 
							 }else{
								echo "<b>ZON&nbsp;1&nbsp;-&nbsp;ZON&nbsp;24</b>";	 
							 }
							 echo "</td>";
							 echo "</tr>";	
							 $phaseCnt++;
					}
					if(mysql_num_rows($phase)==0)
					{
						echo "<tr><td colspan='17' align='center'>TIADA REKOD</td></tr>";
					}
				?>
         </tbody>               
	  </table>
	<br><br>
    
    <? if(mysql_num_rows($phase)<>0) {?>
    <?
    	$totalProjekStat = $statDoc0+$statDoc1+$statDoc2+$statDoc3+$statDoc4
	?>
    <table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:30%; border:#999999 1px solid; page-break-before:auto">			
    	<tr class="color-header1" height="35px">
        	<th colspan="3" style="font-size:12px">STATUS DOKUMEN PROJEK DIRANCANG</th>           
        </tr>
        <tr height="35px">
            <td align="center" bgcolor="#FF3C3C">&nbsp;&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;Penyediaan Dokumen</td>
            <td align="center">&nbsp;&nbsp;&nbsp;<?=$statDoc1?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr height="35px">
            <td align="center" bgcolor="#FFFF2F">&nbsp;&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;Pelawaan</td>
            <td align="center">&nbsp;&nbsp;&nbsp;<?=$statDoc2?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr height="35px">
            <td align="center" bgcolor="#FF9900">&nbsp;&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;Penilaian</td>
            <td align="center">&nbsp;&nbsp;&nbsp;<?=$statDoc3?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr height="35px">
            <td align="center" bgcolor="#28FF28">&nbsp;&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;Pelantikan</td>
            <td align="center">&nbsp;&nbsp;&nbsp;<?=$statDoc4?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr height="35px">
            <td align="center" bgcolor="#5E5EFF">&nbsp;&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;Sedang Dijalankan</td>
            <td align="center">&nbsp;&nbsp;&nbsp;<?=$statDoc5?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
         <tr height="35px">
            <td align="right" colspan="3"><b>JUMLAH PROJEK&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;<?=$totalProjekStat?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <br>
    <table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:30%; border:#999999 1px solid; page-break-before:auto">			
    	<tr class="color-header1" height="35px">
        	<th style="font-size:12px">JUMLAH ANGGARAN KOS PROJEK</th>           
        </tr>
        <tr height="35px">
            <td align="center">RM <?=number_format($totalCostY,2)?></td>
        </tr>
    </table>
    <? } ?>
</div>
<br><br>
</div>
</div>

</body>

