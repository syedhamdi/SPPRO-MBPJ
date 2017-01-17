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
	$jabatan = $_GET['selJabatan'];
	$from = $_GET['from'];
	$to = $_GET['to'];	
	$kawasan = $_GET['kawasan'];
	$pro_dirancang = 1;
	//$pro_dirancang = $_GET['pro_dirancang'];
	$jenisKontraktor = $_GET['jenisKontraktor'];
	$kategori = $_GET['kategori'];
	
	$jabatanArr = explode(",",$jabatan);
	$cntJab = count($jabatanArr);
	$cntJab2 = $cntJab+4;
	$cntJab3 = $cntJab+2;
	
	$OverallPro=0;
	$OverallProA=0;
	
	$sql = "select * from kawasan where layer = 1 order by seq_no";
	$result =  mysql_query($sql);
	
	if($pro_dirancang==1){
		$kosLabel="ANGGARAN";
	}else{
		$kosLabel="PENJIMATAN";
	}
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
            <input type="submit" value="Eksport ke excel">&nbsp;&nbsp; <input type="Button" value="Printer Friendly" ONCLICK="javascript:window.open('report/PrintReport.php?id=Print1&tajuk=RINGKASAN KESELURUHAN PROJEK&kategori=<?=$kategori?>&kawasan=<?=$kawasan?>')">
          </td>
        </tr>
     </table>
    </form>
    <br />
    </div> 
    <div id="Print1">
    <div id="ProjDiv">
    <div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px;">RINGKASAN PROJEK KAWASAN</div>
<?
	while($rowKwsn = mysql_fetch_array($result)){
		echo "</br>";
		echo "</br>";
		echo "<table border='1' bordercolor='#CCCCCC' bordercolorlight='#CCCCCC' cellpadding='0' cellspacing='0' style='padding:2px; width:100%; border:#999999 1px solid;' id='ReportTable'  >";
		echo "<thead>";
		echo "<tr class='color-header5' height='35px'>";
		echo "<th colspan=".$cntJab2." align='center' style='font-size:20px'>PARLIMEN&nbsp;".$rowKwsn['kwsn_desc']."</th>";
		echo "<tr>";
		echo "<tr class='color-header1' height='35px'>";
		echo "<th rowspan='2' align='center' width='30px'>BIL</th>";
		echo "<th rowspan='2' align='center' width='100px'>ADUN</th>";
		echo "<th colspan=".$cntJab." align='center'>BIL PROJEK MENGIKUT JABATAN</th>";
		echo "<th rowspan='2' align='center' width='80px'>JUMLAH</th>";
		echo "<th rowspan='2' align='center' width='150px'> ".$kosLabel." KOS PROJEK (RM)</th>";
		echo "</tr>";
		echo "<tr class='color-header1'>";
		for($i=0;$i<$cntJab;$i++){
			$sqlJab = "select * from department where department_id = ".$jabatanArr[$i];
			$resultJab =  mysql_query($sqlJab);
			while($rowJab = mysql_fetch_array($resultJab)){	
				echo "<td align='center'>".$rowJab['department_desc']."</td>";
			}
		}
		echo "</tr>";
		echo "</thead>";
		$sqlAdun = "select * from kawasan where layer = 2 and parent_id = ".$rowKwsn['kwsn_id']." order by seq_no";
		$resultAdun =  mysql_query($sqlAdun);
		$cntAdun=1;
		$getBil_ProToAllA = 0;
		$getBil_ProToAll = 0;
		
		while($rowAdun = mysql_fetch_array($resultAdun)){	
			echo "<tr>";
			echo "<td align='center'>".$cntAdun++."</td>";
			echo "<td>".$rowAdun['kwsn_desc']."</td>";
			$getBil_ProTo = 0;
			$getBil_ProToA = 0;
			for($i=0;$i<$cntJab;$i++){
					$getBil_Pro = getBil_Pro($jabatanArr[$i],$rowAdun['kwsn_id'],$from,$to,$kategori,$jenisKontraktor,$pro_dirancang);
					$getBil_ProTo = $getBil_ProTo+$getBil_Pro;
					echo "<td align='center'>".$getBil_Pro."</td>";
					
					$getBil_ProA = getBil_ProAnggaran($jabatanArr[$i],$rowAdun['kwsn_id'],$from,$to,$kategori,$jenisKontraktor,$pro_dirancang);
					$getBil_ProToA = $getBil_ProToA+$getBil_ProA;
			}
			echo "<td align='center'>".$getBil_ProTo."</td>";
			$getBil_ProToAll = $getBil_ProToAll+$getBil_ProTo;
			$getBil_ProToAllA = $getBil_ProToAllA+$getBil_ProToA;
			echo "<td align='right'>".number_format($getBil_ProToA, 2, '.', ',')."</td>";
			echo "</tr>";
		}
		echo "<tr align='center' style='font-weight:bold;'  class='color-row2'>";
		echo "<td colspan=".$cntJab3." height='30px' align='right' style='font-size:18px;'>JUMLAH KESELURUHAN&nbsp;&nbsp;&nbsp;</td>";
		echo "<td align='center' style='font-size:18px;'>".$getBil_ProToAll."</td>";
		echo "<td align='right' style='font-size:18px;'>".number_format($getBil_ProToAllA, 2, '.', ',')."</td>";
		echo "</tr>";	
		echo "</table>";
		
		$OverallPro = $OverallPro+$getBil_ProToAll;
		$OverallProA = $OverallProA+$getBil_ProToAllA;
	}
	echo "<br><br><br>";
	echo "<table border='1' bordercolor='#CCCCCC' bordercolorlight='#CCCCCC' cellpadding='0' cellspacing='0' style='padding:2px; width:50%; border:#999999 1px solid;' >";
	echo "<tr>";
	echo "<td class='color-header5' align='left' style='font-size:18px;''>";
	echo "JUMLAH KESELURUHAN PROJEK";
	echo "</td>";
	echo "<td class='color-row2' align='right' style='font-size:18px;'>";
	echo "<b>".$OverallPro."</b>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='color-header5' align='left' style='font-size:18px;'>";
	echo "JUMLAH KESELURUHAN ".$kosLabel." KOS PROJEK";
	echo "</td>";
	echo "<td align='right' style='font-size:18px;' class='color-row2'>";
	echo "<b>RM&nbsp;".number_format($OverallProA, 2, '.', ',')."</b>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<br>";	
function getBil_Pro($jabId,$kwsnAdunId,$from,$to,$kategori,$jenisKontraktor,$pro_dirancang){
	
	$dateOne = date("Y-m-d",strtotime ($from));
	$dateTwo = date("Y-m-d",strtotime ($to));
	
	$where = "";
	$where .= ($kwsnAdunId<>"")?" and kwsn_id_a = ".$kwsnAdunId:"";
	$where .= ($from<>"")?" and date_start >= '".$dateOne."'":"";
	$where .= ($to<>"")?" and date_start <= '".$dateTwo."'":"";
	$where .= ($kategori<>"0")?" and project_category_id = '".$kategori."'":"";
	if($pro_dirancang==1){
		$table = "project_dirancang";	
	}else{
		$table = "project";
		$where .= ($jenisKontraktor<>"")?" and perunding = '".$jenisKontraktor."'":"";
	}

	$sql = "SELECT COUNT(project_id) as cnt ".
			"FROM ".$table." ".
			"WHERE department_id IN (".getBahagian($jabId).")".$where ;
	
	$totalPro = process_sql($sql,"cnt");	
	return $totalPro;
	//return getBahagian($jabId);
}
function getBil_ProAnggaran($jabId,$kwsnAdunId,$from,$to,$kategori,$jenisKontraktor,$pro_dirancang){
	
	$dateOne = date("Y-m-d",strtotime ($from));
	$dateTwo = date("Y-m-d",strtotime ($to));
	
	$where = "";
	$where .= ($kwsnAdunId<>"")?" and kwsn_id_a = ".$kwsnAdunId:"";
	$where .= ($from<>"")?" and date_start >= '".$dateOne."'":"";
	$where .= ($to<>"")?" and date_start <= '".$dateTwo."'":"";
	$where .= ($kategori<>"0")?" and project_category_id = '".$kategori."'":"";
	if($pro_dirancang==1){
		$table = "project_dirancang";	
	}elseif($pro_dirancang==0){
		$table = "project";
		$where .= ($jenisKontraktor<>"")?" and perunding = '".$jenisKontraktor."'":"";
	}
	
	$sql = "SELECT sum(project_costA) as cnt ".
			"FROM ".$table." ".
			"WHERE department_id IN (".getBahagian($jabId).")".$where ;
	
	$totalPro = process_sql($sql,"cnt");	
	return $totalPro;
	//return getBahagian($jabId);
}
function getBahagian($jabId){
	$jabatanArr = "";
	$sqlJab = "select * from department where parent_id = ".$jabId;
	$resultJab =  mysql_query($sqlJab);
	if(mysql_num_rows($resultJab)>0){
		while($rowJab = mysql_fetch_array($resultJab)){	
			$jabatanArr = ($jabatanArr == "")?$rowJab['department_id'] : $jabatanArr.",".$rowJab['department_id'];		
		}
		return $jabId.",".$jabatanArr;
	}else{
		return $jabId;
	}		
}
?>
</div>
<br><br>
</div>
</div>
</body>