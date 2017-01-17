<div align="center">
<div><br><b>KOS KESELURUHAN PROJEK MENGIKUT JABATAN/BAHAGIAN</b></div>
<?php	
			
			$dept = $_SESSION['user_dept'];
		  	$countColor=0;
			$color=array("1941A5", "AFD8F8", "F6BD0F", "8BBA00", "A66EDD", "F984A1", "CCCC00", "999999", "0099CC", "FF0000", "006F00", "0099FF", "FF66CC", "669966", "7C7CB4", "FF9933", "9900FF", "99FFCC", "CCCCFF", "669900");
			$strXML = "<graph xaxisname='Tahun' yaxisname='Kos Projek' formatNumberScale='0' numberPrefix='RM' decimalPrecision='0' showvalues='0' numDivLines='4'>";
			
			$strXML .="<categories>";
			$strQuery = "select year(date_start) as latestDate from project where year(date_start)=year(current_date) group by year(current_date)";			
			$result = mysql_query($strQuery) or die(mysql_error());
			if ($result){
				while($ors = mysql_fetch_array($result)) {     
					$strXML .= "<category name='".$ors['latestDate']."' />";
				}
			}
			$strXML .="</categories>";		
			
			if (($_SESSION['user_group_id']==1)||($_SESSION['user_group_id']==2)) {
				
				$strQuery1 = "select sum(p.project_cost) as kos, d.department_desc, p.date_start from project p inner join department d on ".
						 "p.department_id=d.department_id where year(date_start)=year(current_date) group by d.department_id";
			}
			else
			{
				$strQuery1 = "select sum(p.project_cost) as kos, d.department_desc, p.date_start from project p inner join department d on ".
						 "p.department_id=d.department_id where year(date_start)=year(current_date) and (d.department_id='".$dept."' or d.parent_id='".$dept."') group by d.department_id";
			}
			
					
			$result1 = mysql_query($strQuery1) or die(mysql_error());
			//echo $strQuery1;
			if ($result1){
				while($ors1 = mysql_fetch_array($result1)) {  
					$strXML .="<dataset seriesname='".$ors1['department_desc']."' color='".$color[++$countColor]."' >";   
					$strXML .= "<set value='".$ors1['kos']."' />";
					$strXML .="</dataset>";					
				}
			}
			$strXML .= "</graph>";
			echo renderChartHTML("MyFCPHPClassCharts/FusionCharts/FCF_MSColumn3D.swf", "", $strXML, "KosJab", 800, 500);
?>
</div>
<table width="50%" style=" border-bottom:gray 1px solid; border-left: #999999 1px solid; border-right: gray 1px solid; border-top: #999999 1px solid;" align="center">
          <tr>
           <td height="34" background="images/GradientBlue.JPG" class="Color-header1">Bil.</td>
            <td height="34" background="images/GradientBlue.JPG" class="Color-header1">Jabatan/Bahagian</td>
            <td height="34" background="images/GradientBlue.JPG" class="Color-header1" align="right">Jumlah Kos Projek (RM)</td>
          </tr>
          <?php
		  $num=0;
		  $strQuery = "select sum(p.project_cost) as kos, d.department_desc, p.date_start from project p inner join department d on ".
					  "p.department_id=d.department_id where year(date_start)=year(current_date) group by d.department_id";
		  //echo $strQuery;
		  $result = mysql_query($strQuery) or die(mysql_error());
		  if ($result) {
			  while($ors = mysql_fetch_array($result)) {
				 	$num++;
				    echo "<tr>";
					echo "<td>".$num.".</td>";
					echo "<td height='20'>".$ors['department_desc']."</td>";
					echo "<td height='20' align='right'>".number_format($ors['kos'], 2, '.', ',')."</td>";
					echo "</tr>";	
					}	  
			}
		  ?>
          </table>