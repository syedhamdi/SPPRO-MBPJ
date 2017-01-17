<?php
include('../MyFCPHPClassCharts/Class/FusionCharts.php');
include('../MyFCPHPClassCharts/Class/DBConn.php');
?>
<html>
  <head>
    <title>First Chart Using FusionCharts PHP Class</title>
    <script language='javascript' src='../MyFCPHPClassCharts/FusionCharts/FusionCharts.js'></script>
  </head>
  <body>
	<?php
	
        $link = connectToDB();
    
        $para1=$_GET['id'];
        $strXML = "<graph xaxisname='Bulan' yaxisname='Peratus (%)' hovercapbg='DEDEBE' hovercapborder='889E6D' rotateNames='1' yAxisMaxValue='100' numdivlines='9' divLineColor='CCCCCC' divLineAlpha='80' decimalPrecision='2' showAlternateHGridColor='1' AlternateHGridAlpha='30' AlternateHGridColor='CCCCCC' caption='Kemajuan Fizikal & Kewangan' subcaption='Bagi Projek' baseFontSize='11'>";
        
        $countColor=0;
        $color=array("1941A5", "AFD8F8", "F6BD0F", "8BBA00", "A66EDD", "F984A1", "CCCC00", "999999", "0099CC", "FF0000", "006F00", "0099FF", "FF66CC", "669966", "7C7CB4", "FF9933", "9900FF", "99FFCC", "CCCCFF", "669900");	

		$sql= "select * from data_project ".
		"where project_id = ".$para1." order by seq desc limit 1" ;
		
		$result = mysql_query($sql) or die(mysql_error());
		if($result)
		{						
			while($row=mysql_fetch_array($result)){
				$durCount=$row['seq'];
			}				
		}
		if(mysql_num_rows($result)==0)
		{
			$durCount="";
		}		
		$no = 1;
		$strXML .="<categories>";
		while($no < $durCount + 1)
		{
			
			if($no==1)
			{
				$strXML .= "<category name='Bulan Pertama' />";				
			}
			else
			{
				$strXML .= "<category name='Bulan Ke-".$no."' />";				
			}			
			$no++;			
		}
		$strXML .="</categories>";
		
		$sqlDataProject= "select * from data_project ".
		"where project_id = ".$para1." order by seq desc limit 1" ;
		
		$datasetDataProject = mysql_query($sqlDataProject) or die(mysql_error());
		if($datasetDataProject)
		{						
			while($orsDatasetDataProject=mysql_fetch_array($datasetDataProject)){
				$numCount=$orsDatasetDataProject['seq'];
			}				
		}
		if(mysql_num_rows($datasetDataProject)==0)
		{
			$numCount="";
		}
			
		$no1=1;
		$setKFizikal="";
		$strXML .= "<dataset seriesname='Kemajuan Fizikal' color='".$color[++$countColor]."' anchorBorderColor='".$color[$countColor]."' anchorBgColor='".$color[$countColor]."'>";
		while($no1 < $numCount + 1)
		{
			//display Kemajuan Fizikal
			$sqlDataset = "select dp.project_id, dp.kemajuan_kewangan as kWang, dp.kemajuan_fizikal as kFizikal, dp.seq as seq ".
			"from data_project dp where dp.project_id='".$para1."' and dp.seq='".$no1."' ";
			//echo $sqlDataset;
			$dataset = mysql_query($sqlDataset) or die(mysql_error());
			if($dataset)
			{						
				while($orsDataset=mysql_fetch_array($dataset)){
					$set=$orsDataset['kFizikal'];
					if($set==0)
					{
						if($setKFizikal==100)
						{
							$strXML .=	"<set value='' />";
						}
						else
						{
							$strXML .=	"<set value='".$setKFizikal."' />";
						}
					}
					else
					{
						$setKFizikal = $orsDataset['kFizikal'];
						$strXML .=	"<set value='".$orsDataset['kFizikal']."' />";
					}
				}
			}
			if(mysql_num_rows($dataset)==0)
			{
				if($setKFizikal==100)
				{
					$strXML .=	"<set value='' />";
				}
				else
				{
					$strXML .=	"<set value='".$setKFizikal."' />";
				}				
			}
			$no1++;			
		}
		$strXML .="</dataset>";
        
		$no2=1;
		$strXML .= "<dataset seriesname='Kemajuan Kewangan' color='".$color[++$countColor]."' anchorBorderColor='".$color[$countColor]."' anchorBgColor='".$color[$countColor]."'>"; 
		$sum2=0;   
		while($no2 < $numCount + 1)
		{
			 //display Kemajuan Kewangan
			$sqlDataset2 = "select dp.project_id, dp.data_project_id, dp.kemajuan_kewangan as kWang, dp.seq ".
						"from data_project dp where dp.project_id='".$para1."' and dp.seq='".$no2."' ";
			//echo $sqlDataset1;
			$dataset2 = mysql_query($sqlDataset2) or die(mysql_error());
			if($dataset2)
			{						
				while($orsDataset2=mysql_fetch_array($dataset2)){
					$sum2 +=$orsDataset2['kWang'];
					$strXML .=	"<set value='".$sum2."' />";	
				}				
			}
			if(mysql_num_rows($dataset2)==0)
			{
				$strXML .=	"<set value='".$sum2."' />";
			}
			$no2++;
		}
        $strXML .="</dataset>";
        
		$no3=1;
		$strXML .= "<dataset seriesname='Kemajuan Kewangan Bulanan' color='".$color[++$countColor]."' anchorBorderColor='".$color[$countColor]."' anchorBgColor='".$color[$countColor]."'>"; 
		$sum3=0;   
		while($no3 < $numCount + 1)
		{
			 //display Kemajuan Kewangan
			$sqlDataset3 = "select dp.project_id, dp.data_project_id, dp.kemajuan_kewangan_bln as kWang, dp.seq ".
						"from data_project dp where dp.project_id='".$para1."' and dp.seq='".$no3."' ";
			//echo $sqlDataset1;
			$dataset3 = mysql_query($sqlDataset3) or die(mysql_error());
			if($dataset3)
			{						
				while($orsDataset3=mysql_fetch_array($dataset3)){
					$sum3=$orsDataset3['kWang'];
					$strXML .=	"<set value='".$sum3."' />";	
				}				
			}
			if(mysql_num_rows($dataset3)==0)
			{
				$strXML .=	"<set value='".$sum3."' />";
			}
			$no3++;
		}
        $strXML .="</dataset>";
        
		$no4=1;
		$strXML .= "<dataset seriesname='Kemajuan Kewangan Tahunan' color='".$color[++$countColor]."' anchorBorderColor='".$color[$countColor]."' anchorBgColor='".$color[$countColor]."'>"; 
		$sum4=0;   
		while($no4 < $numCount + 1)
		{
			 //display Kemajuan Kewangan
			$sqlDataset4 = "select dp.project_id, dp.data_project_id, dp.kemajuan_kewangan_thn as kWang, dp.seq ".
						"from data_project dp where dp.project_id='".$para1."' and dp.seq='".$no4."' ";
			//echo $sqlDataset1;
			$dataset4 = mysql_query($sqlDataset4) or die(mysql_error());
			if($dataset4)
			{						
				while($orsDataset4=mysql_fetch_array($dataset4)){
					$sum4=$orsDataset4['kWang'];
					$strXML .=	"<set value='".$sum4."' />";	
				}				
			}
			if(mysql_num_rows($dataset4)==0)
			{
				$strXML .=	"<set value='".$sum4."' />";
			}
			$no4++;
		}
        $strXML .="</dataset>";

        mysql_close($link);
        //Finally, close <graph> element
        $strXML .= "</graph>";	
        //Create the chart - Pie 3D Chart with data from $strXML
        echo renderChart("../MyFCPHPClassCharts/FusionCharts/FCF_MSLine.swf", "", $strXML, "Pogress", 650, 450);
    ?>
	</body>
</html>