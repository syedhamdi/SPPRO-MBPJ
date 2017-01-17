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
	$from = $_GET['from'];
	$to = $_GET['to'];	
	$kawasan = $_GET['kawasan'];
	$proDirancang = $_GET['proDirancang'];
	
	$parlimen= '';
	$adun='';
	$sqlParlimen='';
	$sqlAdun='';
	$sqlMajlis='';
	$sqlFrom='';
	$sqlTo='';
	$sqlStart='';
	$sqlEnd='';
	
	if($proDirancang==1){
		$tablePro="project_dirancang";
		$label="ANGGARAN";
	}else{
		$tablePro="project";
		$label="PENJIMATAN";
	}
	
	if($from!=""){
		$from=date("Y-m-d",strtotime($from));
		$sqlFrom=" and p.date_start>='".$from."'";
		$sqlStart=" and a.dateE>='".$from."'";
	}
	
	if($to!=""){
		$to=date("Y-m-d",strtotime($to));
		$sqlTo=" and p.date_start<='".$to."'";
		$sqlEnd=" and a.dateS<='".$to."'";
	}
	
	if($kawasan!=0)
		$kawasan_desc=$kawasan;
	else
		$kawasan_desc="";
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
            <input type="submit" value="Eksport ke excel">&nbsp;&nbsp; <input type="Button" value="Printer Friendly" ONCLICK="javascript:window.open('report/PrintReport.php?id=Print1&tajuk=LAPORAN MAKLUMAT PROJEK&kategori=&kawasan=<?=$kawasan_desc?>')">
          </td>
        </tr>
     </table>
    </form>
    <br />
    </div> 
    <div id="Print1">
    <div id="ProjDiv">
    <div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px;">RINGKASAN PROJEK KAWASAN</div>
	<table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; padding-top:10px; padding-bottom:10px; width:100%; border:#999999 1px solid;" id="ReportTable" >
        <?
			if($kawasan!=0)
				$layer=process_sql("select layer from kawasan where kwsn_id=".$kawasan,"layer");
			else
				$layer=0;
				
			if($layer==1){
				$sqlParlimen = "select * from kawasan where layer=1 and kwsn_id=".$kawasan;
				$sqlAdun="select * from kawasan where layer=2 and parent_id=".$kawasan;
			}
			else if($layer==2){
				$parentAdun=process_sql("select parent_id from kawasan where kwsn_id=".$kawasan,"parent_id");
				$sqlParlimen = "select * from kawasan where layer=1 and kwsn_id=".$parentAdun;
				$sqlAdun = "select * from kawasan where layer=2 and kwsn_id=".$kawasan;
				$sqlMajlis = "select * from kawasan k ".
							 "inner join ahli a on k.kwsn_id=a.kawasan_id ".
							 "where k.layer=3 and k.parent_id=".$kawasan.$sqlStart.$sqlEnd;
			}
			else if($layer==3){
				$parentMajlis=process_sql("select parent_id from kawasan where kwsn_id=".$kawasan,"parent_id");
				$parentAdun=process_sql("select parent_id from kawasan where kwsn_id=".$parentMajlis,"parent_id");
				$sqlParlimen = "select * from kawasan where layer=1 and kwsn_id=".$parentAdun;
				$sqlAdun = "select * from kawasan where layer=2 and kwsn_id=".$parentMajlis;
				$sqlMajlis = "select * from kawasan k ".
							 "inner join ahli a on k.kwsn_id=a.kawasan_id ".
							 "where k.layer=3 and k.kwsn_id=".$kawasan.$sqlStart.$sqlEnd;
			}
			else{
				$sqlParlimen="select * from kawasan where layer=1";
			}
			
			//echo $sqlParlimen;
			$resultP = mysql_query($sqlParlimen) or die(mysql_error());
			while($rowParlimen = mysql_fetch_array($resultP)){
			?>
                <tr class="color-header5">
                    <th colspan="9"><font size="6">PARLIMEN <?=$rowParlimen['kwsn_desc']?></font></th>
                </tr>
			<?
				if($kawasan==0){
					$sqlAdun="select * from kawasan where layer=2 and parent_id=".$rowParlimen['kwsn_id'];
				}
				
				$resultA = mysql_query($sqlAdun) or die(mysql_error());
				while($rowAdun = mysql_fetch_array($resultA)){
			?>
					<tr class="color-header4">
						<th colspan="9"><font size="4">ADUN <?=$rowAdun['kwsn_desc']?></font></th>
					</tr>
			<?	
			?>
                    </tr>
                        <tr class="color-header1" height="35px" style="page-break-inside: avoid;" align="center">
                        <td rowspan="2" width="5%">BIL</th>				
                        <td rowspan="2" colspan="2" width="30%">AHLI MAJLIS</th>
                        <td rowspan="2" width="10%">ZON</th>
                        <td colspan="3" width="30%">BILANGAN PROJEK</th>		
                        <td rowspan="2" width="10%">JUMLAH PROJEK</th>
                        <td rowspan="2" width="15%"><?=$label?> (RM)</th>
                    </tr>
                    <tr class="color-header1" align="center">
                        <td width="10%">KERJA</th>
                        <td width="10%">BEKALAN</th>
                        <td width="10%">PERKHIDMATAN</th>
                    </tr>
            <?
					if($layer!=2 && $layer!=3){
						$sqlMajlis = "select * from kawasan k ".
									 "inner join ahli a on k.kwsn_id=a.kawasan_id ".
									 "where k.layer=3 and k.parent_id=".$rowAdun['kwsn_id'].$sqlStart.$sqlEnd;
					}
					//echo $sqlMajlis;
					$cnt=1;
					
					$resultM = mysql_query($sqlMajlis) or die(mysql_error());
					while($rowMajlis = mysql_fetch_array($resultM)){
						
						//bil projek ahli majlis
						$sqlKerja = "select count(*) as kerja from ".$tablePro." p where p.project_category_id=1 and p.kwsn_id_m=".$rowMajlis['kwsn_id'].$sqlFrom.$sqlTo;
						$totKerja = process_sql($sqlKerja,"kerja");
						
						$sqlBekalan = "select count(*) as bekalan from ".$tablePro." p where p.project_category_id=2 and p.kwsn_id_m=".$rowMajlis['kwsn_id'].$sqlFrom.$sqlTo;
						$totBekalan = process_sql($sqlBekalan,"bekalan");
						
						$sqlPerkhidmatan = "select count(*) as perkhidmatan from ".$tablePro." p where p.project_category_id=3 and p.kwsn_id_m=".$rowMajlis['kwsn_id'].$sqlFrom.$sqlTo;
						$totPerkhidmatan = process_sql($sqlPerkhidmatan,"perkhidmatan");
						
						$sqlAll = "select count(*) as total from ".$tablePro." p where p.kwsn_id_m=".$rowMajlis['kwsn_id'].$sqlFrom.$sqlTo;
						$totAll = process_sql($sqlAll,"total");
						
						//penjimatan ahli majlis
						$anggaranM=process_sql("select sum(project_costA) as anggaran from ".$tablePro." p where p.project_costA<>0 and p.kwsn_id_m=".$rowMajlis['kwsn_id'].$sqlFrom.$sqlTo,"anggaran");
						$sebenarM=process_sql("select sum(project_cost) as sebenar from ".$tablePro." p where p.project_costA<>0 and p.kwsn_id_m=".$rowMajlis['kwsn_id'].$sqlFrom.$sqlTo,"sebenar");
						$penjimatanM=$anggaranM-$sebenarM;
						
					?>
                    	<tr class="color-row">
                        	<td><?=$cnt?></td>
                            <td colspan="2"><?=$rowMajlis['nama_ahli']?></td>
                            <td><?=$rowMajlis['kwsn_desc']?></td>
                            <td align="center"><?=$totKerja?></td>
                            <td align="center"><?=$totBekalan?></td>
                            <td align="center"><?=$totPerkhidmatan?></td>
                            <td align="center"><?=$totAll?></td>
                            <td align="right"><?=number_format($penjimatanM, 2, '.', ',')?></td>
                        </tr>
                    <?
						$cnt=$cnt+1;
					}
						$sqlAhliAdun = "select * from ahli a where a.kawasan_id=".$rowAdun['kwsn_id'].$sqlStart.$sqlEnd;
						$resultAA = mysql_query($sqlAhliAdun) or die(mysql_error());
						$num_rowsA = mysql_num_rows($resultAA);
						$row_cnt = 0;
						while($rowAhliAdun = mysql_fetch_array($resultAA)){
							$row_cnt=$row_cnt+1;
							
							//bil projek adun
							$sqlKerja = "select count(*) as kerja from ".$tablePro." p where p.project_category_id=1 and p.kwsn_id_a=".$rowAdun['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliAdun['dateS']."' and p.date_start<='".$rowAhliAdun['dateE']."'";
							$totKerjaA = process_sql($sqlKerja,"kerja");
							
							$sqlBekalan = "select count(*) as bekalan from ".$tablePro." p where p.project_category_id=2 and p.kwsn_id_a=".$rowAdun['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliAdun['dateS']."' and p.date_start<='".$rowAhliAdun['dateE']."'";
							$totBekalanA = process_sql($sqlBekalan,"bekalan");
							
							$sqlPerkhidmatan = "select count(*) as perkhidmatan from ".$tablePro." p where p.project_category_id=3 and p.kwsn_id_a=".$rowAdun['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliAdun['dateS']."' and p.date_start<='".$rowAhliAdun['dateE']."'";
							$totPerkhidmatanA = process_sql($sqlPerkhidmatan,"perkhidmatan");
							
							$sqlAll = "select count(*) as total from ".$tablePro." p where p.kwsn_id_a=".$rowAdun['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliAdun['dateS']."' and p.date_start<='".$rowAhliAdun['dateE']."'";
							$totAllA = process_sql($sqlAll,"total");
							
							//penjimatan adun
							$anggaranA = process_sql("select sum(project_costA) as anggaran from ".$tablePro." p where p.project_costA<>0 and p.kwsn_id_a=".$rowAdun['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliAdun['dateS']."' and p.date_start<='".$rowAhliAdun['dateE']."'","anggaran");
							$sebenarA = process_sql("select sum(project_cost) as sebenar from ".$tablePro." p where p.project_costA<>0 and p.kwsn_id_a=".$rowAdun['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliAdun['dateS']."' and p.date_start<='".$rowAhliAdun['dateE']."'","sebenar");
							$penjimatanA = $anggaranA - $sebenarA;
							
							if($row_cnt!=1)
								$dsp='none';
							else
								$dsp='';
							
							if($layer==3)
								$dspAdun='none';
							else
								$dspAdun='';
							
						?>	
							<tr class="color-row" style="display:<?=$dspAdun?>">
								<th colspan="2" rowspan="<?=$num_rowsA?>" style="display:<?=$dsp?>" width="25%">JUMLAH KESELURUHAN ADUN <?=$rowAdun['kwsn_desc']?></th>
								<th colspan="2"><?=$rowAhliAdun['nama_ahli']?></th>
								<th><?=$totKerjaA?></th>
								<th><?=$totBekalanA?></th>
								<th><?=$totPerkhidmatanA?></th>
								<th><?=$totAllA?></th>
								<th align="right"><?=number_format($penjimatanA, 2, '.', ',')?></th>
							</tr>
                     	<?
						}
					}
					
                    $sqlAhliParlimen = "select * from ahli a where a.kawasan_id=".$rowParlimen['kwsn_id'].$sqlStart.$sqlEnd;
                    $resultAP = mysql_query($sqlAhliParlimen) or die(mysql_error());
					$num_rowsP = mysql_num_rows($resultAP);
                    while($rowAhliParlimen = mysql_fetch_array($resultAP)){
                        
                        //bil projek parlimen
                        $sqlKerja = "select count(*) as kerja from ".$tablePro." p where p.project_category_id=1 and p.kwsn_id_p=".$rowParlimen['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliParlimen['dateS']."' and p.date_start<='".$rowAhliParlimen['dateE']."'";
						$totKerjaP = process_sql($sqlKerja,"kerja");
                        
                        $sqlBekalan = "select count(*) as bekalan from ".$tablePro." p where p.project_category_id=2 and p.kwsn_id_p=".$rowParlimen['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliParlimen['dateS']."' and p.date_start<='".$rowAhliParlimen['dateE']."'";
                        $totBekalanP = process_sql($sqlBekalan,"bekalan");
                        
                        $sqlPerkhidmatan = "select count(*) as perkhidmatan from ".$tablePro." p where p.project_category_id=3 and p.kwsn_id_p=".$rowParlimen['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliParlimen['dateS']."' and p.date_start<='".$rowAhliParlimen['dateE']."'";
                        $totPerkhidmatanP = process_sql($sqlPerkhidmatan,"perkhidmatan");
                        
                        $sqlAll = "select count(*) as total from ".$tablePro." p where p.kwsn_id_p=".$rowParlimen['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliParlimen['dateS']."' and p.date_start<='".$rowAhliParlimen['dateE']."'";
                        $totAllP = process_sql($sqlAll,"total");
                        
                        //penjimatan parlimen
                        $anggaranP = process_sql("select sum(project_costA) as anggaran from ".$tablePro." p where p.project_costA<>0 and p.kwsn_id_p=".$rowParlimen['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliParlimen['dateS']."' and p.date_start<='".$rowAhliParlimen['dateE']."'","anggaran");
                        $sebenarP = process_sql("select sum(project_cost) as sebenar from ".$tablePro." p where p.project_costA<>0 and p.kwsn_id_p=".$rowParlimen['kwsn_id'].$sqlFrom.$sqlTo." and p.date_start>='".$rowAhliParlimen['dateS']."' and p.date_start<='".$rowAhliParlimen['dateE']."'","sebenar");
                        $penjimatanP = $anggaranP - $sebenarP;
						
						if($layer==3 or $layer==2)
							$dspParlimen='none';
						else
							$dspParlimen='';
                    ?>	
                        <tr class="color-header5" style="display:<?=$dspParlimen?>;">
                            <th colspan="2" rowspan="<?=$num_rowsP?>"><font size="3px">JUMLAH KESELURUHAN PARLIMEN <?=$rowParlimen['kwsn_desc']?></font></th>
                            <th colspan="2"><font size="3px"><?=$rowAhliParlimen['nama_ahli']?></font></th>
                            <th><font size="3px"><?=$totKerjaP?></font></th>
                            <th><font size="3px"><?=$totBekalanP?></font></th>
                            <th><font size="3px"><?=$totPerkhidmatanP?></font></th>
                            <th><font size="3px"><?=$totAllP?></font></th>
                            <th align="right"><font size="3px"><?=number_format($penjimatanP, 2, '.', ',')?></font></th>
                        </tr>
                    <?
                }
				
			?>
            	<tr  style="page-break-after:always"><td colspan="9">&nbsp;</td></tr>
            <?
			}
            ?>
	</table>
</div>
<br><br>
</div>
</div>
</body>