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

<?
	$where = '';
	$from = $_GET['from'];
	$to = $_GET['to'];
	$pro_dirancang = $_GET['proDirancang'];
	$jabatan = $_GET['jabatan'];
	$jabatanArr = explode(",",$jabatan);
	$cntJab = count($jabatanArr);
	
	if($pro_dirancang==1){
		$kosLabel="ANGGARAN";
	}else{
		$kosLabel="PENJIMATAN";
	}
	
	$where .= ($from<>"")? " P.date_start >= '".date("Y-m-d",strtotime($from))."'":"";
	$where .= ($to<>"")? " and":"";
	$where .= ($to<>"")? " P.date_start <= '".date("Y-m-d",strtotime($to))."'":"";

?>
	<div id="report" class="mytable">
    <form action="../include/report/exporttoexcel.php" method="post" 
    onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'>
    <table width="600px" border="0">
        <tr>
          <td></td>
        </tr>
        <tr>
          <td><input type="hidden" id="datatodisplay" name="datatodisplay">
            <input type="submit" value="Eksport ke excel">&nbsp;&nbsp; <input type="Button" value="Printer Friendly" ONCLICK="javascript:window.open('report/PrintReport.php?id=Print2&tajuk=RINGKASAN PROJEK&jabatan=<?=$jabatan?>&from=<?=$from?>&to=<?=$to?>')">
          </td>
        </tr>
     </table>
    </form>

<br />
</div> 
<div id="Print1">
<div id="ProjDiv">
<div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px;">RINGKASAN PROJEK</div>
<?
	for($i=0;$i<$cntJab;$i++){
		
		$dataJab = DataCount($jabatanArr[$i],$where);
		
		$deptChild = process_sql("select count(*) as count from department where parent_id=".$jabatanArr[$i],"count");
		if($deptChild<>0){
			$deptArr = "";
			$sqlDeptChild = "select * from department where parent_id = ".$jabatanArr[$i]." order by seq_no";
			$resultDept = mysql_query($sqlDeptChild);
			while($rowDept = mysql_fetch_array($resultDept)){
				$deptArr = ($deptArr=="")?$rowDept['department_id']:$deptArr.",".$rowDept['department_id'];	
			}
			
			$dept_id = $deptArr;
			$type = 2;

		
		}else{
			$dept_id = $jabatanArr[$i];
			$type = 1;
		}
		
		$dataKerja1 = getDataCount(1,$dept_id,$where,1,1,"project_id",$type);
		$dataPerkhidmatan1 = getDataCount(1,$dept_id,$where,3,1,"project_id",$type);
		$dataBekalan1 = getDataCount(1,$dept_id,$where,2,1,"project_id",$type);
		$totProjek1 = getDataCount(1,$dept_id,$where,"",1,"project_id",$type);
		
		$kosAnggaran1 = getDataCount(2,$dept_id,$where,"",1,"project_costA",$type);
		$kosSebenar1 = getDataCount(2,$dept_id,$where,"",1,"project_cost",$type);
		$pembayaran1 = pembayaran(getDataId(1,$dept_id,$where,"",1,"project_id",$type));

		$dataKerja2 = getDataCount(1,$dept_id,$where,1,2,"project_id",$type);
		$dataPerkhidmatan2 = getDataCount(1,$dept_id,$where,3,2,"project_id",$type);
		$dataBekalan2 = getDataCount(1,$dept_id,$where,2,2,"project_id",$type);
		$totProjek2 = getDataCount(1,$dept_id,$where,"",2,"project_id",$type);
		
		$kosAnggaran2 = getDataCount(2,$dept_id,$where,"",2,"project_costA",$type);
		$kosSebenar2 = getDataCount(2,$dept_id,$where,"",2,"project_cost",$type);
		$pembayaran2 = pembayaran(getDataId(1,$dept_id,$where,"",2,"project_id",$type));
		
		$dataKerja3 = getDataCount(1,$dept_id,$where,1,3,"project_id",$type);
		$dataPerkhidmatan3 = getDataCount(1,$dept_id,$where,3,3,"project_id",$type);
		$dataBekalan3 = getDataCount(1,$dept_id,$where,2,3,"project_id",$type);
		$totProjek3 = getDataCount(1,$dept_id,$where,"",3,"project_id",$type);
		
		$kosAnggaran3 = getDataCount(2,$dept_id,$where,"",3,"project_costA",$type);
		$kosSebenar3 = getDataCount(2,$dept_id,$where,"",3,"project_cost",$type);
		$pembayaran3 = pembayaran(getDataId(1,$dept_id,$where,"",3,"project_id",$type));



		echo "<table border='1' bordercolor='#CCCCCC' bordercolorlight='#CCCCCC' cellpadding='0' cellspacing='0' style='padding:2px; width:100%; border:#999999 1px solid;' id='ReportTable'  >";
		echo "<thead>";
		echo "<tr class='color-header6' height='35px'>";
		echo "<th align='center' style='font-size:20px'>".process_sql("select department_desc from department where department_id =".$jabatanArr[$i],"department_desc")."</th>";
		echo "<tr>";
		echo "</table>";
		
		echo "<table border='1' bordercolor='#CCCCCC' bordercolorlight='#CCCCCC' cellpadding='0' cellspacing='0' style='padding:2px; width:100%; border:#999999 1px solid;' id='ReportTable'  >";
		echo "<tr class='color-header1' height='35px'>";
		echo "<th rowspan='2' align='center' width='13%'>Jabatan</th>";
		echo "<th rowspan='2' align='center'>Kategori Peruntukan</th>";
		echo "<th colspan=3 align='center'>Bilangan Projek</th>";
		echo "<th rowspan='2' align='center'>JUMLAH Projek</th>";
		echo "<th rowspan='2' align='center'>ANGGARAN KOS PROJEK (RM) </th>";
		echo "<th rowspan='2' align='center'>KOS PROJEK SEBENAR(RM) </th>";
		echo "<th rowspan='2' align='center'>PENJIMATAN (RM) </th>";
		echo "<th rowspan='2' align='center'>PENJIMATAN (%)</th>";
		echo "<th rowspan='2' align='center'>PEMBAYARAN (RM)</th>";
		echo "<th rowspan='2' align='center'>BAKI BELUM BERBAYAR (RM)</th>";
		echo "</tr>";
		
		echo "<tr class='color-header1' height='35px'>";
		echo "<th align='center'>Kerja</th>";
		echo "<th align='center'>Perkhidmatan</th>";
		echo "<th align='center'>Bekalan</th>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td rowspan='3'>".process_sql("select department_desc from department where department_id =".$jabatanArr[$i],"department_desc")."</td>";
		echo "<td align='center'>MBPJ 11,12,13</td>";
		echo "<td align='center'>".$dataKerja1."</td>";
		echo "<td align='center'>".$dataPerkhidmatan1."</td>";
		echo "<td align='center'>".$dataBekalan1."</td>";
		echo "<td align='center'>".$totProjek1."</td>";
		$penjimatan1 = $kosAnggaran1 - $kosSebenar1;
		if(($kosSebenar1<>0) && ($kosAnggaran1<>0)){
			$penjimatanPrct1 = ($kosSebenar1/$kosAnggaran1)*100;
			$penjimatanPrct1 = 100 - $penjimatanPrct1;	
		}else{
			$penjimatanPrct1 = 0;	
		}
		
		$baki1 = $kosSebenar1 - $pembayaran1;			
		
		echo "<td align='center'>".number_format($kosAnggaran1,2)."</td>";
		echo "<td align='center'>".number_format($kosSebenar1,2)."</td>";
		echo "<td align='center'>".number_format($penjimatan1,2)."</td>";		
		echo "<td align='center'>".number_format($penjimatanPrct1,2)."</td>";
		echo "<td align='center'>".number_format($pembayaran1,2)."</td>";
		echo "<td align='center'>".number_format($baki1,2)."</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td align='center'>MBPJ - 30</td>";
		echo "<td align='center'>".$dataKerja2."</td>";
		echo "<td align='center'>".$dataPerkhidmatan2."</td>";
		echo "<td align='center'>".$dataBekalan2."</td>";
		echo "<td align='center'>".$totProjek2."</td>";
		$penjimatan2 = $kosAnggaran2 - $kosSebenar2;
		if(($kosSebenar2<>0) && ($kosAnggaran2<>0)){
			$penjimatanPrct2 = ($kosSebenar2/$kosAnggaran2)*100;
			$penjimatanPrct2 = 100 - $penjimatanPrct2;	
		}else{
			$penjimatanPrct2 = 0;	
		}
		
		$baki2 = $kosSebenar2 - $pembayaran2;			
		
		echo "<td align='center'>".number_format($kosAnggaran2,2)."</td>";
		echo "<td align='center'>".number_format($kosSebenar2,2)."</td>";
		echo "<td align='center'>".number_format($penjimatan2,2)."</td>";
		echo "<td align='center'>".number_format($penjimatanPrct2,2)."</td>";
		echo "<td align='center'>".number_format($pembayaran2,2)."</td>";
		echo "<td align='center'>".number_format($baki2,2)."</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align='center'>Akaun Amanah - 50</td>";
		echo "<td align='center'>".$dataKerja3."</td>";
		echo "<td align='center'>".$dataPerkhidmatan3."</td>";
		echo "<td align='center'>".$dataBekalan3."</td>";
		echo "<td align='center'>".$totProjek3."</td>";
		$penjimatan3 = $kosAnggaran3 - $kosSebenar3;
		if(($kosSebenar3<>0) && ($kosAnggaran3<>0)){
			$penjimatanPrct3 = ($kosSebenar3/$kosAnggaran3)*100;
			$penjimatanPrct3 = 100 - $penjimatanPrct3;	
		}else{
			$penjimatanPrct3 = 0;	
		}
		
		$baki3 = $kosSebenar3 - $pembayaran3;			
		
		echo "<td align='center'>".number_format($kosAnggaran3,2)."</td>";
		echo "<td align='center'>".number_format($kosSebenar3,2)."</td>";
		echo "<td align='center'>".number_format($penjimatan3,2)."</td>";
		echo "<td align='center'>".number_format($penjimatanPrct3,2)."</td>";
		echo "<td align='center'>".number_format($pembayaran3,2)."</td>";
		echo "<td align='center'>".number_format($baki3,2)."</td>";
		echo "</tr>";

		echo "</table><br><br>";
				
		if($deptChild<>0){
			
			$result = mysql_query($sqlDeptChild);
			while($row = mysql_fetch_array($result)){
				echo "<table border='1' bordercolor='#CCCCCC' bordercolorlight='#CCCCCC' cellpadding='0' cellspacing='0' style='padding:2px; width:100%; border:#999999 1px solid;' id='ReportTable'  >";
				echo "<tr class='color-header1' height='35px'>";
				echo "<th rowspan='2' align='center' width='13%'>Bahagian</th>";
				echo "<th rowspan='2' align='center'>Kategori Peruntukan</th>";
				echo "<th colspan=3 align='center'>Bilangan Projek</th>";
				echo "<th rowspan='2' align='center'>JUMLAH Projek</th>";
				echo "<th rowspan='2' align='center'>ANGGARAN KOS PROJEK (RM) </th>";
				echo "<th rowspan='2' align='center'>KOS PROJEK SEBENAR(RM) </th>";
				echo "<th rowspan='2' align='center'>PENJIMATAN (RM) </th>";
				echo "<th rowspan='2' align='center'>PENJIMATAN (%)</th>";
				echo "<th rowspan='2' align='center'>PEMBAYARAN (RM)</th>";
				echo "<th rowspan='2' align='center'>BAKI BELUM BERBAYAR (RM)</th>";
				echo "</tr>";
				
				echo "<tr class='color-header1' height='35px'>";
				echo "<th align='center'>Kerja</th>";
				echo "<th align='center'>Perkhidmatan</th>";
				echo "<th align='center'>Bekalan</th>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td rowspan='3'>".process_sql("select department_desc from department where department_id =".$row['department_id'],"department_desc")."</td>";
				echo "<td align='center'>MBPJ 11,12,13</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,1,1,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,2,1,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,3,1,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,"",1,"project_id",1)."</td>";
				$kosAnggaran01 = getDataCount(2,$row['department_id'],$where,"",1,"project_costA",1);
				$kosSebenar01 = getDataCount(2,$row['department_id'],$where,"",1,"project_cost",1);
				$penjimatan01 = $kosAnggaran01 - $kosSebenar01;
				if(($kosSebenar01<>0) && ($kosAnggaran01<>0)){
					$penjimatanPrct01 = ($kosSebenar01/$kosAnggaran01)*100;
					$penjimatanPrct01 = 100 - $penjimatanPrct01;	
				}else{
					$penjimatanPrct01 = 0;	
				}
				
				$pembayaran01 = pembayaran(getDataId(1,$row['department_id'],$where,"",1,"project_id",1));
				$baki01 = $kosSebenar01 - $pembayaran01;			
		
				echo "<td align='center'>".number_format($kosAnggaran01,2)."</td>";
				echo "<td align='center'>".number_format($kosSebenar01,2)."</td>";
				echo "<td align='center'>".number_format($penjimatan01,2)."</td>";		
				echo "<td align='center'>".number_format($penjimatanPrct01,2)."</td>";
				echo "<td align='center'>".number_format($pembayaran01,2)."</td>";
				echo "<td align='center'>".number_format($baki01,2)."</td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align='center'>MBPJ - 30</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,1,2,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,2,2,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,3,2,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,"",2,"project_id",1)."</td>";
				$kosAnggaran02 = getDataCount(2,$row['department_id'],$where,"",2,"project_costA",1);
				$kosSebenar02 = getDataCount(2,$row['department_id'],$where,"",2,"project_cost",1);
				$penjimatan02 = $kosAnggaran02 - $kosSebenar02;
				if(($kosSebenar02<>0) && ($kosAnggaran02<>0)){
					$penjimatanPrct02 = ($kosSebenar02/$kosAnggaran02)*100;
					$penjimatanPrct02 = 100 - $penjimatanPrct02;	
				}else{
					$penjimatanPrct02 = 0;	
				}
				
				$pembayaran02 = pembayaran(getDataId(1,$row['department_id'],$where,"",2,"project_id",1));
				$baki02 = $kosSebenar02 - $pembayaran02;			
		
				echo "<td align='center'>".number_format($kosAnggaran02,2)."</td>";
				echo "<td align='center'>".number_format($kosSebenar02,2)."</td>";
				echo "<td align='center'>".number_format($penjimatan02,2)."</td>";
				echo "<td align='center'>".number_format($penjimatanPrct02,2)."</td>";
				echo "<td align='center'>".number_format($pembayaran02,2)."</td>";
				echo "<td align='center'>".number_format($baki02,2)."</td>";
				echo "</tr>";
		
				echo "<tr>";
				echo "<td align='center'>Akaun Amanah - 50</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,1,3,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,2,3,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,3,3,"project_id",1)."</td>";
				echo "<td align='center'>".getDataCount(1,$row['department_id'],$where,"",3,"project_id",1)."</td>";
				$kosAnggaran03 = getDataCount(2,$row['department_id'],$where,"",3,"project_costA",1);
				$kosSebenar03 = getDataCount(2,$row['department_id'],$where,"",3,"project_cost",1);
				$penjimatan03 = $kosAnggaran03 - $kosSebenar03;
				if(($kosSebenar03<>0) && ($kosAnggaran03<>0)){
					$penjimatanPrct03 = ($kosSebenar03/$kosAnggaran03)*100;
					$penjimatanPrct03 = 100 - $penjimatanPrct03;	
				}else{
					$penjimatanPrct03 = 0;	
				}
				
				$pembayaran03 = pembayaran(getDataId(1,$row['department_id'],$where,"",3,"project_id",1));
				$baki03 = $kosSebenar03 - $pembayaran03;			
		
				echo "<td align='center'>".number_format($kosAnggaran03,2)."</td>";
				echo "<td align='center'>".number_format($kosSebenar03,2)."</td>";
				echo "<td align='center'>".number_format($penjimatan03,2)."</td>";
				echo "<td align='center'>".number_format($penjimatanPrct03,2)."</td>";
				echo "<td align='center'>".number_format($pembayaran03,2)."</td>";
				echo "<td align='center'>".number_format($baki03,2)."</td>";
				echo "</tr>";
		
				echo "</table><br><br>";

			
			}	
		}
	}
function getDataCountKeseluruhan($typeGetData,$jabId,$where,$category,$peruntukan,$fieldName){
	$and = ($where<>"")?" and":"";
	
	//typeGetData
	//1 = count
	//2 = sum
	if($typeGetData==1){
		$typeGetData = "count";	
	}else{
		$typeGetData = "sum";	
	}
	if($peruntukan==1){
		$peruntukan = "(p.no_peruntukan LIKE '11%' OR p.no_peruntukan LIKE '12%' OR p.no_peruntukan LIKE '13%')";
	}elseif($peruntukan==2){
		$peruntukan = "(p.no_peruntukan LIKE '30%')";
	}elseif($peruntukan==3){
		$peruntukan = "(p.no_peruntukan LIKE '50%')";
	}
	
	if($category<>""){
		$category = "P.project_category_id = ".$category." AND";
	}else{
		$category="";	
	}
	$sql = "SELECT ".$typeGetData."(".$fieldName.") as cnt ".
			"FROM project AS P ".
			"INNER JOIN department AS D ON P.department_id=D.department_id ".
			"INNER JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
			"WHERE ".$category." ".$peruntukan." and P.department_id in (".$jabId.")".$and.$where;
	
	$data = process_sql($sql,"cnt");
	$data = ($data=="")?"0":$data;
	return $data;	
}

function pembayaranKeseluruhan($idArr){
	if($idArr == ""){
		$pembayaran = 0;
	}else{
		$sql = "select sum(amount) as sum from data_payment where data_project_id in (".$idArr.")";
		$pembayaran = process_sql($sql,"sum");	
	}
	
	return $pembayaran;
}

function getDataIdKeseluruhan($typeGetData,$jabId,$where,$category,$peruntukan,$fieldName){
	$and = ($where<>"")?" and":"";
	
	//typeGetData
	//1 = count
	//2 = sum
	if($typeGetData==1){
		$typeGetData = "count";	
	}else{
		$typeGetData = "sum";	
	}
	if($peruntukan==1){
		$peruntukan = "(p.no_peruntukan LIKE '11%' OR p.no_peruntukan LIKE '12%' OR p.no_peruntukan LIKE '13%')";
	}elseif($peruntukan==2){
		$peruntukan = "(p.no_peruntukan LIKE '30%')";
	}elseif($peruntukan==3){
		$peruntukan = "(p.no_peruntukan LIKE '50%')";
	}
	
	if($category<>""){
		$category = "P.project_category_id = ".$category." AND";
	}else{
		$category="";	
	}
	$dataArr = "";
	$sql = "SELECT * ".
			"FROM project AS P ".
			"INNER JOIN department AS D ON P.department_id=D.department_id ".
			"INNER JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
			"WHERE ".$category." ".$peruntukan." and P.department_id in (".$jabId.")".$and.$where;
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$dataArr = ($dataArr=="")?$row["project_id"]:$dataArr.",".$row["project_id"];	
	}
	//$data = process_sql($sql,"cnt");
	//$data = ($data=="")?"0":$data;
	return $dataArr;	
}

function DataCount($jabId,$where){
	$and = ($where<>"")?" and":"";
	$sql = "select count(*) as cnt from project p where (p.no_peruntukan LIKE '11%' OR p.no_peruntukan LIKE '12%' OR p.no_peruntukan LIKE '13%' OR p.no_peruntukan LIKE '30%' OR p.no_peruntukan LIKE '50%') and p.department_id =".$jabId.$and.$where;
	$data = process_sql($sql,"cnt");
	return $sql;	
}

function getDataCount($typeGetData,$jabId,$where,$category,$peruntukan,$fieldName,$type){
	$and = ($where<>"")?" and":"";
	//type
	//1 = bahagian
	//2 = keseluruhan
	
	//typeGetData
	//1 = count
	//2 = sum
	if($typeGetData==1){
		$typeGetData = "count";	
	}else{
		$typeGetData = "sum";	
	}
	if($peruntukan==1){
		$peruntukan = "(p.no_peruntukan LIKE '11%' OR p.no_peruntukan LIKE '12%' OR p.no_peruntukan LIKE '13%')";
	}elseif($peruntukan==2){
		$peruntukan = "(p.no_peruntukan LIKE '30%')";
	}elseif($peruntukan==3){
		$peruntukan = "(p.no_peruntukan LIKE '50%')";
	}
	
	if($category<>""){
		$category = "P.project_category_id = ".$category." AND";
	}else{
		$category="";	
	}
	if($type==1){
		$sql = "SELECT ".$typeGetData."(".$fieldName.") as cnt ".
				"FROM project AS P ".
				"INNER JOIN department AS D ON P.department_id=D.department_id ".
				"INNER JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
				"WHERE ".$category." ".$peruntukan." and P.department_id=".$jabId.$and.$where;
	}elseif($type==2){
		$sql = "SELECT ".$typeGetData."(".$fieldName.") as cnt ".
		"FROM project AS P ".
		"INNER JOIN department AS D ON P.department_id=D.department_id ".
		"INNER JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
		"WHERE ".$category." ".$peruntukan." and P.department_id in (".$jabId.")".$and.$where;

	}
	$data = process_sql($sql,"cnt");
	$data = ($data=="")?"0":$data;
	return $data;	
}

function getDataId($typeGetData,$jabId,$where,$category,$peruntukan,$fieldName,$type){
	$and = ($where<>"")?" and":"";
	//type
	//1 = bahagian
	//2 = keseluruhan


	//typeGetData
	//1 = count
	//2 = sum
	if($typeGetData==1){
		$typeGetData = "count";	
	}else{
		$typeGetData = "sum";	
	}
	if($peruntukan==1){
		$peruntukan = "(p.no_peruntukan LIKE '11%' OR p.no_peruntukan LIKE '12%' OR p.no_peruntukan LIKE '13%')";
	}elseif($peruntukan==2){
		$peruntukan = "(p.no_peruntukan LIKE '30%')";
	}elseif($peruntukan==3){
		$peruntukan = "(p.no_peruntukan LIKE '50%')";
	}
	
	if($category<>""){
		$category = "P.project_category_id = ".$category." AND";
	}else{
		$category="";	
	}
	$dataArr = "";
	if($type==1){
		$sql = "SELECT * ".
				"FROM project AS P ".
				"INNER JOIN department AS D ON P.department_id=D.department_id ".
				"INNER JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
				"WHERE ".$category." ".$peruntukan." and P.department_id=".$jabId.$and.$where;
	}elseif($type==2){
		$sql = "SELECT * ".
		"FROM project AS P ".
		"INNER JOIN department AS D ON P.department_id=D.department_id ".
		"INNER JOIN project_category PC ON P.project_category_id=PC.project_category_id ".
		"WHERE ".$category." ".$peruntukan." and P.department_id in (".$jabId.")".$and.$where;
	}
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$dataArr = ($dataArr=="")?$row["project_id"]:$dataArr.",".$row["project_id"];	
	}
	//$data = process_sql($sql,"cnt");
	//$data = ($data=="")?"0":$data;
	return $dataArr;	
}

function pembayaran($idArr){
	if($idArr == ""){
		$pembayaran = 0;
	}else{
		$sql = "select sum(amount) as sum from data_payment where data_project_id in (".$idArr.")";
		$pembayaran = process_sql($sql,"sum");	
	}
	
	return $pembayaran;
}
?>
</div>
<br><br>
</div>
</div>
</body>