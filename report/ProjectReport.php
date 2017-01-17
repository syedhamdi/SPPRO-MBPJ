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
            thead
            {
                display:  table-header-group;    
            }
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
		$CountAwal=0;
		$CountLewat=0;
		$CountTepat=0;
		$CountTerbengkalai=0;
		$CountBerjalan=0;
		$percentAwal=0;
		$percentBerjalan=0;
		$percentLewat=0;
		$percentTepat=0;
		$percentTerbengkalai=0;
		
		$strQuery = "select project_id as pid, date_end as dateEnd from project where date_end > current_date";
				  
		$result = mysql_query($strQuery) or die(mysql_error());
		if ($result) 
		{
			
			$setArrayOver = array();
			while($ors = mysql_fetch_array($result))
			{			
				$setArrayLess[$Control++]=$ors['pid'];
				$sqlDatasetOne = "select project_id, kemajuan_kewangan, kemajuan_fizikal, tahun, date_data ".
								"from data_project ".
								"where project_id=".$ors['pid']." order by seq desc, tahun desc limit 1";
				$dataSetOne = mysql_query($sqlDatasetOne) or die(mysql_error());
				if($dataSetOne)
				{
					while($setDataOne = mysql_fetch_array($dataSetOne))
					{	
						if($setDataOne['kemajuan_fizikal']==100)
						{							
							$setArrayAwal[$percentAwal++]=$ors['pid'];
							++$CountAwal;
						}
						if($setDataOne['kemajuan_fizikal']!=100)
						{
							$setArrayBerjalan[$percentBerjalan++]=$ors['pid'];
							++$CountBerjalan;
						}
					}
					if(mysql_num_rows($dataSetOne)==0)
					{
						$setArrayBerjalan[$percentBerjalan++]=$ors['pid'];
						++$CountBerjalan;
					}
				}
			}
		}
		$strQuery = "select project_id as pid, date_end as dateEnd from project where date_end < current_date";
				  
		$result = mysql_query($strQuery) or die(mysql_error());
		if ($result) 
		{		
			$setArrayLess = array();
			while($ors = mysql_fetch_array($result))
			{				
				$setArrayLess[$Control1++]=$ors['pid'];
				$sqlDatasetOne = "select project_id, kemajuan_kewangan, kemajuan_fizikal, tahun, date_data ".
								 "from data_project ".
							     "where project_id=".$ors['pid']." order by seq desc, tahun desc limit 1";
				$dataSetOne = mysql_query($sqlDatasetOne) or die(mysql_error());
				if($dataSetOne)
				{
					while($setDataOne = mysql_fetch_array($dataSetOne))
					{	
						if($setDataOne['kemajuan_fizikal']==100 && $setDataOne['date_data'] > $ors['dateEnd'])
						{
							$setArrayLewat[$percentLewat++]=$ors['pid'];
							++$CountLewat;
						}
						if($setDataOne['kemajuan_fizikal']==100 && $setDataOne['date_data'] < $ors['dateEnd'])
						{
							$setArrayAwal[$percentAwal++]=$ors['pid'];
							++$CountAwal;
						}
						if($setDataOne['kemajuan_fizikal']==100 && $setDataOne['date_data'] = $ors['dateEnd'])
						{
							$setArrayTepat[$percentTepat++]=$ors['pid'];
							++$CountTepat;
						}
						if($setDataOne['kemajuan_fizikal']!=100)
						{
							$setArrayTerbengkalai[$percentTerbengkalai++]=$ors['pid'];
							++$CountTerbengkalai;
						}
					}	
					if(mysql_num_rows($dataSetOne)==0)
					{
						$setArrayTerbengkalai[$percentTerbengkalai++]=$ors['pid'];
						++$CountTerbengkalai;
					}			
				}						
			}
		}	
			
		$strQuery = "select project_id as pid, date_end as dateEnd from project where date_end = current_date";
				  
		$result = mysql_query($strQuery) or die(mysql_error());
		if ($result) 
		{
			$setArrayEqual = array();
			while($ors = mysql_fetch_array($result))
			{
				
				$setArrayEqual[$Control2++]=$ors['pid'];
				$sqlDatasetOne = "select project_id, kemajuan_kewangan, kemajuan_fizikal, tahun, date_data ". 
				"from data_project ".
				"where project_id=".$ors['pid']." order by seq desc, tahun desc limit 1";
				$dataSetOne = mysql_query($sqlDatasetOne) or die(mysql_error());
				if($dataSetOne)
				{
					while($setDataOne = mysql_fetch_array($dataSetOne))
					{	
						if($setDataOne['kemajuan_fizikal']==100)
						{
							$setArrayTepat[$percentTepat++]=$ors['pid'];
							++$CountTepat;
						}
					}				
				}	
			}
		}
	?>
	<?php		
	
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
	
	if($jenisKontraktor!=""){
		if($jenisKontraktor==0){
			if($selKontraktor!=""){
				if($whereStr != ""){
					$whereStr = $whereStr." and C.contractor_id = ".$selKontraktor."";
					$where = "where ";
				}else{
					$whereStr = " C.contractor_id = ".$selKontraktor."";
					$where = "where ";
				}		
			}else{
				if($whereStr != ""){
					$whereStr = $whereStr." and p.perunding = 0";
					$where = "where ";
				}else{
					$whereStr = " p.perunding = 0";
					$where = "where ";
				}
			}
		}
		elseif($jenisKontraktor==1){
			if($selKontraktor!=""){
				if($whereStr != ""){
					$whereStr = $whereStr." and C.contractor_id = ".$selKontraktor."";
					$where = "where ";
				}else{
					$whereStr = " C.contractor_id = ".$selKontraktor."";
					$where = "where ";
				}		
			}else{
				if($whereStr != ""){
					$whereStr = $whereStr." and p.perunding = 1";
					$where = "where ";
				}else{
					$whereStr = " p.perunding = 1";
					$where = "where ";
				}
			}
		}else{
			if($whereStr != ""){
				$whereStr = $whereStr." and C.contractor_id = ".$selKontraktor."";
				$where = "where ";
			}else{
				$whereStr = " C.contractor_id = ".$selKontraktor."";
				$where = "where ";
			}		
		}		
	}
	
	if($selBumi!=""){
		if($whereStr != ""){
			$whereStr = $whereStr." and C.bumiputra = ".$selBumi."";
			$where = "where ";
		}else{
			$whereStr = " C.bumiputra = ".$selBumi."";
			$where = "where ";
		}	
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
	
	if($kategori != ""){
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
			$whereStr = " P.date_start <= '".$dateTwo."'";
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
	if($selStatus  != ""){
		$statusSql = "LEFT JOIN data_project dp ON p.project_id = dp.project_id ";			 
		if($selStatus  == 1){
			$status="Siap Awal";
			if($whereStr != ""){
				$whereStr = $whereStr." and dp.kemajuan_fizikal = 100 AND DATE_FORMAT(p.eot,'%y %m') > DATE_FORMAT(dp.date_data,'%y %m')";
				$where = "where ";
			}else{
				$whereStr = " dp.kemajuan_fizikal = 100 AND DATE_FORMAT(p.eot,'%y %m') > DATE_FORMAT(dp.date_data,'%y %m')";
				$where = "where ";
			}
		}
		if($selStatus  == 2){
			$status="Siap Mengikut Jadual";
			if($whereStr != ""){
				$whereStr = $whereStr." and dp.kemajuan_fizikal = 100 AND DATE_FORMAT(p.eot,'%y %m') = DATE_FORMAT(dp.date_data,'%y %m')";
				$where = "where ";
			}else{
				$whereStr = " dp.kemajuan_fizikal = 100 AND DATE_FORMAT(p.eot,'%y %m') = DATE_FORMAT(dp.date_data,'%y %m')";
				$where = "where ";
			}
		}
		if($selStatus  == 3){
			$status="Lewat";
			if($whereStr != ""){
				$whereStr = $whereStr." and dp.kemajuan_fizikal = 100 AND DATE_FORMAT(p.eot,'%y %m') < DATE_FORMAT(dp.date_data,'%y %m')";
				$where = "where ";
			}else{
				$whereStr = " dp.kemajuan_fizikal = 100 AND DATE_FORMAT(p.eot,'%y %m') < DATE_FORMAT(dp.date_data,'%y %m')";
				$where = "where ";
			}
		}
		if($selStatus  == 4){
			$status="Sedang Dijalankan";
			$statusSql = "";	 
			$id = "";
			$sql_siap = "select project_id from data_project where kemajuan_fizikal = 100";
			$result_siap = mysql_query($sql_siap);
			while($rowsiap=mysql_fetch_array($result_siap)){
				if($id == ""){
					$id = $rowsiap['project_id'];
				}else{
					$id = $id ." and p.project_id <>".$rowsiap['project_id'];
				}
			}
			if($whereStr != ""){
				$whereStr = $whereStr." and p.project_id <> ".$id;
				$where = "where ";
			}else{
				$whereStr = " p.project_id <> ".$id;
				$where = "where ";
			}
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
	
 	if($where.$whereStr.$where2 == ""){
		$where3 = " C.contractor_name <> '-TIADA-'";	
	}else{
		$where3 = " and C.contractor_name <> '-TIADA-'";	
	}
	if($where.$whereStr.$where2.$where3 == ""){
		$where4 = " p.p_award = 1";	
	}else{
		$where4 = " and p.p_award = 1";	
	}
 	$sql="SELECT *,P.project_reference, P.project_name, P.project_cost, P.date_start, P.date_end, P.pegawai_projek, P.pen_pegawai_projek, P.ptbk,
			  C.contractor_regno, C.contractor_name, C.contractor_phone, C.contractor_id, C.bumiputra, P.project_duration, P.project_id, ".
			  "D.department_desc, PC.project_category_desc, PT.project_type_desc, PC.project_category_short, P.perunding,P.project_cost_month,P.project_cost_year,P.no_peruntukan ".
			  "FROM project AS P ".
			  $statusSql.
			  "INNER JOIN contractor AS C ON P.contractor_id=C.contractor_id ".
			  "INNER JOIN department AS D ON P.department_id=D.department_id ".
			  "LEFT JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
			  "INNER JOIN project_type PT ON P.project_type_id=PT.project_type_id ".
			  "LEFT JOIN kawasan kwsn ON P.kwsn_id_p=kwsn.kwsn_id ".
			  $where.$whereStr.$where2.$where3;
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
    <div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px;">LAPORAN MAKLUMAT PROJEK</div>
<table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid;" id="ReportTable" >
            <thead>
            <tr class="color-header1" height="35px"  style="page-break-inside: avoid;">
           		<th rowspan="2">BIL</th>				
				<th rowspan="2">NO. KONTRAK/ NAMA PEMILIK</th>
				<th rowspan="2">NAMA PROJEK/ LOKASI/ MAJLIS/ NEGERI/ PERSEKUTUAN</th>
				<th rowspan="2">PEGAWAI BERTANGGUNGJAWAB</th>
				<th rowspan="2">HARGA KONTRAK SEBENAR/ANGGARAN(RM)</th>
                <th rowspan="2">BAYARAN SEMASA(RM)</th>				
				<th rowspan="2">TARIKH MULA</th>
				<th rowspan="2">TARIKH SIAP</th>
                <th colspan="2">KEMAJUAN KEWANGAN</th>
                <?
                	if($kategori == 1){
						?>
						 <th colspan="2">KEMAJUAN FIZIKAL</th>
						<?	
					}else{
						?>
						 <th rowspan="2">PRESTASI KONTRAKTOR</th>
						<?	
					}
				?>               
                <th rowspan="2">JABATAN / BAHAGIAN</th>
                <!--<th rowspan="2">KATEGORI PROJEK</th>
                <th rowspan="2">JENIS PROJEK</th>-->
                <th rowspan="2">STATUS PROJEK</th>
				<th rowspan="2">CATATAN (TERKINI)</th>
                <th rowspan="2">KAWASAN</th>
			</tr>
            <tr class="color-header1">
                <th>SEBELUM</th>
                <th>TERKINI</th>
                 <?
                	if($kategori == 1){
						?>
						 <th>DIRANCANG</th>
               			 <th>SEBENAR</th>
						<?	
					}				
				?>                
            </tr>
            </thead>
        	 <tbody>
            	<?php	
					$phase = mysql_query($sql);
					$phaseTmp="";
					$phaseCnt=0;
					 
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
							 echo "<td valign='middle' align='center'>No. Kontrak: <div style='cursor:pointer; color:blue;' onclick='grafPopup(".$rowPhase['project_id'].")'><u>".$rowPhase['project_reference']."</u></div>";
							 if($rowPhase['no_peruntukan']=="")
							 {
								 $rowPhase['no_peruntukan']="TIADA";
							 }
							 echo "<br>No. Peruntukan: <br>".$rowPhase['no_peruntukan']."";
							 echo "<br><br><b>Mengurus</b><br>";
							 
							 if ($rowPhase['contractor_id']!="") {
								 echo "<br>";
								 $sqlProj = "SELECT owner_id, owner_name, no_tel, no_ic, address FROM owner ".
														"WHERE contractor_id=".$rowPhase['contractor_id']." ";						
								 $proj = mysql_query($sqlProj);
								 while ($rowSystem = mysql_fetch_array($proj)) {
											echo $rowSystem['owner_name']."<br>";
											echo $rowSystem['no_tel']."<br><br>";	// system
										}
								 if (mysql_num_rows($proj)==0)	
								 {
									 echo "<b>TIADA</b>";
								 }									
								 echo "</td>";							
							 }
							 $set="";
							 if($rowPhase['bumiputra']==0)
							 {
								 $set="BB";
							 }
							 if($rowPhase['bumiputra']==1)
							 {
								 $set="B";
							 }
							 if($rowPhase['contractor_phone']<>""){
								 $nophone = $rowPhase['contractor_phone'];
							 }else{
								$nophone = "TIADA";	 
							 }							 
							 echo "<td align='left'>".$rowPhase['project_name']."<br><br><b>".$rowPhase['contractor_name']."</b><br>(".$set.")<br><br>No. Tel:<br><b>".$nophone."</b><br><br>Tempoh siap: ".$rowPhase['project_duration']."<br>";
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
							 echo "Pegawai Projek: ".$pegName."<br><br>";	
							 echo "Penolong Pegawai Projek: ".$rowPhase['pen_pegawai_projek']."<br><br>PTBK/PTB/Juruteknik: ".$rowPhase['ptbk']."<br>";							
							 echo "<td align='center'><b>Sebenar</b><br>".number_format($rowPhase['project_cost'], 2, '.', ',')."<br><br>";
							 echo "<b>Anggaran</b><br>".number_format($rowPhase['project_costA'], 2, '.', ',')."<br><br>";
							 //echo "<b>Penjimatan/Lebihan</b><br>";
							 
							 if($rowPhase['project_costA']==0.00000){
								echo "<b>Penjimatan/Lebihan</b><br>(-)"; 	 
								$jimat_lebih = 0; 
							 }else{
								$jimat_lebih = $rowPhase['project_costA'] - $rowPhase['project_cost'];
								if($jimat_lebih > 0.0000){
									echo "<b>Penjimatan</b><br>".number_format($jimat_lebih, 2, '.', ','); 	 
								}elseif($jimat_lebih < 0.0000){
									$jimat_lebihStr = str_replace("-","",$jimat_lebih);
									echo "<b>Lebihan</b><br>".number_format($jimat_lebihStr, 2, '.', ','); 	 
								}else{
									echo "<b>Penjimatan/Lebihan</b><br>(0.00)"; 	 
								}								
							 }							 
							 		 
							 if($rowPhase['project_cost_month']> 0.00)
							 {
								 echo "<br>Bulanan: ".number_format($rowPhase['project_cost_month'], 2, '.', ',')."";
							 }
							 if($rowPhase['project_cost_year']> 0.00)
							 {
								 echo "<br>Tahunan: ".number_format($rowPhase['project_cost_year'], 2, '.', ',')."";
							 }
							 echo "<br><br><strong>"; 
							 echo "<div align='center'>(Lanjutan&nbsp;Kos)</div></strong><br>";
							 if ($rowPhase['project_id']!="") {
								 $sqlEoc = "SELECT cost FROM eoc ".
											"WHERE project_id=".$rowPhase['project_id']." order by date_eoc desc";							
								 $eoc = mysql_query($sqlEoc);
								 $cnt=1;
								while ($rowEoc = mysql_fetch_array($eoc)) {
									echo $cnt.".&nbsp;".number_format($rowEoc['cost'], 2, '.', ',')."<br>";
									$cnt++;
								}
								if (mysql_num_rows($eoc)==0)	
								{
								echo "<div align='center'>TIADA</div>";
								}
								echo "</td>";
							 }					 						 
							 echo "<td align='right'>";
							 if ($rowPhase['project_id']!="") {
								 $sqlBayaran = "SELECT DP.amount FROM project P ".
											"INNER JOIN data_payment DP ON P.project_id=DP.project_id ".
											"WHERE DP.project_id=".$rowPhase['project_id']."";							
								 $bayaran = mysql_query($sqlBayaran);
								 $cnt=1;
								 while ($rowBayaran = mysql_fetch_array($bayaran)) {
											echo $cnt.".&nbsp;".number_format($rowBayaran['amount'], 2, '.', ',')."<br>";
											$cnt++;
										}
								 if (mysql_num_rows($bayaran)==0)	
								 {
									 echo "<div align='center'>TIADA</div>";
								 }
								 echo "</td>";							
							 }					 
							
							 include 'include_edited.php';
                             							 
							 if ($rowPhase['project_id']!="") {
								 $year = date('Y');
								 $month = date('m');
								 
								 //Kemajuan Kewangan Bulan Lepas
								 $sqlData =  "SELECT DP.data_project_id, ".
													"DP.project_reference, DP.kemajuan_kewangan, DP.kemajuan_kewangan_bln, DP.kemajuan_kewangan_thn, DP.kemajuan_fizikal, DP.date_data, DP.tahun, DP.catatan FROM project P ".
												"INNER JOIN data_project DP ON P.project_id=DP.project_id ".
												"WHERE DP.project_id=".$rowPhase['project_id']. " ".
												"ORDER BY DP.kemajuan_kewangan desc LIMIT 1,1";
								 //echo $sqlData;						
								 $data = mysql_query($sqlData);							
								 while ($rowData = mysql_fetch_array($data)) {
								 		if ($rowData['kemajuan_kewangan']==""){ $kewangan=0; } else { $kewangan = $rowData['kemajuan_kewangan']; }
										if ($rowData['kemajuan_kewangan_bln']=="") { $kewangan_bln=0; } else { $kewangan_bln = $rowData['kemajuan_kewangan_bln']; }
										if ($rowData['kemajuan_kewangan_thn']=="") { $kewangan_thn=0; } else { $kewangan_thn = $rowData['kemajuan_kewangan_thn']; }
											echo "<td align='center'>";
											echo "".$kewangan."%<br />";
											echo "Bulanan: ".$kewangan_bln."%<br />";
											echo "Tahunan: ".$kewangan_thn."%";
											echo  "</td>";
								 }							 
								 if (mysql_num_rows($data)==0)
								 {
									 echo "<td align='center'>0%<br />";
									 echo "Bulanan: 0%<br />";
									 echo "Tahunan: 0%";
									 echo "</td>";
								 }
								 
								 //Kemajuan Kewangan Bulan Ini
								  $sqlDataBefore = "SELECT DP.data_project_id, ".
													"DP.project_reference, DP.kemajuan_kewangan, DP.kemajuan_kewangan_bln, DP.kemajuan_kewangan_thn, DP.kemajuan_fizikal, DP.date_data, DP.tahun, DP.catatan FROM project P ".
												"INNER JOIN data_project DP ON P.project_id=DP.project_id ".
												"WHERE DP.project_id=".$rowPhase['project_id']. " ".
												"ORDER BY DP.kemajuan_kewangan desc LIMIT 1";	
									 $dataBefore = mysql_query($sqlDataBefore);	
											
									 while ($rowDataBefore = mysql_fetch_array($dataBefore)) {	
										if ($rowDataBefore['kemajuan_kewangan']=="") { $kewangan=0; } else { $kewangan = $rowDataBefore['kemajuan_kewangan']; }
										if ($rowData['kemajuan_kewangan_bln']=="") { $kewangan_bln=0; } else { $kewangan_bln = $rowData['kemajuan_kewangan_bln']; }
										if ($rowData['kemajuan_kewangan_thn']=="") { $kewangan_thn=0; } else { $kewangan_thn = $rowData['kemajuan_kewangan_thn']; }
											echo "<td align='center'>";
											echo "".$kewangan."%<br />";
											echo "Bulanan: ".$kewangan_bln."%<br />";
											echo "Tahunan: ".$kewangan_thn."%";
											echo  "</td>";
																				
									 }							
									 if (mysql_num_rows($dataBefore)==0)
									 {
										 echo "<td align='center'>0%<br />";
										 echo "Bulanan: 0%<br />";
										 echo "Tahunan: 0%";
										 echo "</td>";
									 }
									 
								//Kemajuan Fizikal Dirancang
								$sqlData = "SELECT DP.data_project_id, ".
													"DP.project_reference, DP.kemajuan_dirancang, DP.kemajuan_kewangan_bln, DP.kemajuan_kewangan_thn, DP.kemajuan_fizikal, DP.date_data, DP.tahun, DP.catatan FROM project P ".
												"INNER JOIN data_project DP ON P.project_id=DP.project_id ".
												"WHERE DP.project_id=".$rowPhase['project_id']. " ".
												"ORDER BY DP.kemajuan_fizikal desc LIMIT 1";	
														
								 $data = mysql_query($sqlData);							
								 while ($rowData = mysql_fetch_array($data)) {
									 	if($rowData['kemajuan_dirancang']==""){
											$kemajuanDirancang = "-";
										}else{
											$kemajuanDirancang = $rowData['kemajuan_dirancang'];
										}	
										//echo "<td align='center'>".$kemajuanDirancang."</td>";		 	
								 }							 
								 if (mysql_num_rows($data)==0)
								 {
									 $kemajuanDirancang = 0;
									 //echo "<td align='center'>0%</td>";
								 }
								 
								 //Kemajuan Fizikal sebenar
								 $sqlDataBefore = "SELECT DP.data_project_id, ".
													"DP.project_reference, DP.kemajuan_fizikal, DP.kemajuan_kewangan_bln, DP.kemajuan_kewangan_thn, DP.kemajuan_fizikal, DP.date_data, DP.tahun, DP.catatan FROM project P ".
												"INNER JOIN data_project DP ON P.project_id=DP.project_id ".
												"WHERE DP.project_id=".$rowPhase['project_id']. " ".
												"ORDER BY DP.kemajuan_fizikal desc LIMIT 1";	
								//echo $sqlDataBefore ;			
									 $dataBefore = mysql_query($sqlDataBefore);	
											
									 while ($rowDataBefore = mysql_fetch_array($dataBefore)) {
										 $kemajuanSebenar = $rowDataBefore['kemajuan_fizikal'];
										 $catatanTerkini = $rowDataBefore['catatan'];
										//echo "<td align='center'>".$rowDataBefore['kemajuan_fizikal']."%</td>";	
																				
									 }							
									 if (mysql_num_rows($dataBefore)==0)
									 {
										 $kemajuanSebenar = 0;
										 $catatanTerkini = "";
										//echo "<td align='center'>0%</td>";
									 }
								 
							 }
							 $styleC = "";
							 if($kategori == 1){								
								 if($kemajuanDirancang != "-"){
									 if($kemajuanDirancang > $kemajuanSebenar){
										 $styleC = ";color:#FF0000;";
									 }
									 echo "<td align='center' style='font-weight:bold;".$styleC."'>".$kemajuanDirancang." %</td>";
								 }else{
									  echo "<td align='center' style='font-weight:bold;".$styleC."'>".$kemajuanDirancang."</td>";
								 } 
						     }
							
							 echo "<td align='center' style='font-weight:bold;".$styleC."' >".$kemajuanSebenar. " %</td>";
							 echo "<td align='center'>".$rowPhase['department_desc']."</td>";	
							 
							 //Status Projek						 
							 if($selStatus=="")
							 {
								 for($k=0; $k<$percentAwal; $k++)
								 {							 
									 if($rowPhase['project_id']==$setArrayAwal[$k])
									 {
										 $status="Siap Awal";	
									 }
								 }
								 for($l=0; $l<$percentTepat; $l++)
								 {							 
									 if($rowPhase['project_id']==$setArrayTepat[$l])
									 {
										 $status="Siap Mengikut Jadual";	
									 }
								 }
								 for($m=0; $m<$percentLewat; $m++)
								 {							 
									 if($rowPhase['project_id']==$setArrayLewat[$m])
									 {
										 $status="Siap Mengikut Jadual";//"Siap Lewat3";	
									 }
								 }
								 for($i=0; $i< $percentBerjalan; $i++)
								 {							 
									 if($rowPhase['project_id']==$setArrayBerjalan[$i])
									 {
										 $status="Sedang Dijalankan";	
									 }
								 }					
								
								for($j=0; $j<$percentTerbengkalai; $j++)
								 {							 
									 if($rowPhase['project_id']==$setArrayTerbengkalai[$j])
									 {
										 $status="Sedang Dijalankan";//belum siap	
									 }
								 }			
							 }
							 echo "<td align='center'>".$status."<br><input class='papar_imej' type='button' value='Papar Imej' onclick='viewImej(".$rowPhase['project_id'].")'/></td>";
							 echo "<td align='left'>".$catatanTerkini."";							
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
							 $jimat_lebih2 = $jimat_lebih2+$jimat_lebih;
					}
					if(mysql_num_rows($phase)==0)
					{
						echo "<tr><td colspan='17' align='center'>TIADA REKOD</td></tr>";
					}
				?>
         </tbody>               
	  </table>
	<br><br>
    
    <?
	//echo $date_max;
    //echo $date_min;
	$date_minTemp =  $date_min;
	//echo $totalYear;
	if(mysql_num_rows($phase)!=0){
	?>
    <table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:80%; border:#999999 1px solid; page-break-before:always">			
    	<tr class="color-header1" height="35px">
        	<th style="font-size:12px">RINGKASAN</th>
            <?
			$column = 0;
			while($column<=$totalYear) {
				echo "<th style='font-size:12px'>".$date_minTemp++."</th>";
			$column++;
			}
			$date_minTemp = $date_min;
			?>
            <th style="font-size:12px">JUMLAH BESAR</th>            
        </tr>
        <tr height="35px">
        	<td style="font-size:12px"><strong>KOS PROJEK</strong></td>
            <? 
			$column = 0;
			while($column<=$totalYear) {
				$sql = "select sum(cost) as cost from cost_peryear where year = ".$date_minTemp++ ;
				$cost = process_sql($sql,"cost");				
				echo "<td align='right'>".number_format($cost,2)."</td>";
			$column++;
			}
			$date_minTemp = $date_min;
			?>
            <td align="right"><?=number_format($total_cost,2)?></td>
        </tr>
        <tr height="35px">
        	<td style="font-size:12px"><strong>STATUS BAYARAN</strong></td>
            <?
			
			$column = 0;
			 while($column<=$totalYear) {
				$sqlbayaranyear = "select sum(amount) as amount from data_payment where (year(date_add) = ".$date_minTemp++." and project_id in (".$arrId."))"; 
				//echo $sqlbayaranyear;
				$bayaranYear = process_sql($sqlbayaranyear,"amount");
				if($bayaranYear == ""){
					$bayaranYear = 0.00;	
				}else{
					$bayaranYear = $bayaranYear;
				}
				echo "<td align='right'>".number_format($bayaranYear,2)."</td>";
			$column++;
			}
			$date_minTemp = $date_min;
			?>
            <td align="right"><?=number_format($totalPayment,2)?></td>
        </tr>
         <tr height="35px">
        	<td style="font-size:12px"><strong>BAKI</strong></td>
            <?
			$column = 0;
			 while($column<=$totalYear) {
				$sql = "select sum(cost) as cost from cost_peryear where year = ".$date_minTemp++;
				$cost = process_sql($sql,"cost");
				
				$date_minTemp--;
				$sqlbayaranyear = "select sum(amount) as amount from data_payment where (year(date_add) = ".$date_minTemp++." and project_id in (".$arrId."))"; 
				$bayaranYear = process_sql($sqlbayaranyear,"amount");
				if($bayaranYear == ""){
					$bayaranYear = 0.00;	
				}else{
					$bayaranYear = $bayaranYear;
				}
				$blncPerYear = $cost -	$bayaranYear;
				echo "<td align='right'>".number_format($blncPerYear,2)."</td>";
			$column++;
			}
			$date_minTemp = $date_min;
			?>
            <td align="right"><?=number_format($balancePayment = $total_cost-$totalPayment,2)?></td>
        </tr>
         </tbody>
    </table>
  	<?
    $sql = "delete from cost_peryear";
	mysql_query($sql);
	
	}
	?>
    <br>
    <table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:20%; border:#999999 1px solid; page-break-before:always">			
    	<tr>
        	<?
            	if($jimat_lebih2 > 0){
					$title = "Jumlah Penjimatan";	
					$jimat_lebih2 = number_format($jimat_lebih2, 2, '.', ',');	
				}elseif($jimat_lebih2 < 0){
					$title = "Jumlah Lebihan";
					$jimat_lebihStr = str_replace("-","",$jimat_lebih2);
					$jimat_lebih2 = number_format($jimat_lebihStr, 2, '.', ',');	
				}else{
					$title = "Jumlah Penjimatan/Lebihan";
					$jimat_lebih2 = "(-)";
				}
			?>
        	<td   class="color-header1" height="35px" style="font-size:12px" align="center"><?=$title?></td>                 
        </tr>
        <tr>
        	<td align="center" style="font-size:12px"><strong><?=$jimat_lebih2?></strong></td>
        </tr>
     </table>
   
</div>
<br><br>
</div>
</div>

</body>

