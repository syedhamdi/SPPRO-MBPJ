<table width="100%">
<tr>
    <td width="100%">
    <div align="center">
    <div><br><b>KOS KESELURUHAN PROJEK MENGIKUT JABATAN</b></div>
    <?php	
                
                $dept = $_SESSION['user_dept'];
                $countColor=0;
                $color=array("1941A5", "AFD8F8", "F6BD0F", "8BBA00", "A66EDD", "F984A1", "CCCC00", "999999", "0099CC", "FF0000", "006F00", "0099FF", "FF66CC", "669966", "7C7CB4", "FF9933", "9900FF", "99FFCC", "CCCCFF", "669900");
                $strXML = "<graph xaxisname='Tahun' yaxisname='Kos Projek' formatNumberScale='0' numberPrefix='RM' decimalPrecision='2' showvalues='0' numDivLines='4'>";
                
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
                    
                    $strQuery1 = "select department_id, department_desc from department where layer=1";			
                }
                else
                {
                    $strQuery1 = "select department_id, department_desc from department where department_id='".$dept."' or parent_id='".$dept."'";
                }					
                $result1 = mysql_query($strQuery1) or die(mysql_error());
                
                if ($result1){
                    while($ors1 = mysql_fetch_array($result1)) { 					
                        $strQuery2="select sum(p.project_cost) as kos from project p inner join department d on ".
                                "d.department_id=p.department_id where year(date_start)=year(current_date) and p.project_cost > 0.00 ".
                                "and (d.department_id='".$ors1['department_id']."' or d.parent_id='".$ors1['department_id']."')";
                        //echo $strQuery2;
                        $result2 = mysql_query($strQuery2) or die(mysql_error());
                        if ($result2){
                            while($ors2 = mysql_fetch_array($result2)){
                                $strXML .="<dataset seriesname='".$ors1['department_desc']."' color='".$color[++$countColor]."' >";   
                                $strXML .= "<set value='".$ors2['kos']."' />";
                                $strXML .="</dataset>";
                            }						
                        } 										
                    }
                }
                $strXML .= "</graph>";
                echo renderChartHTML("MyFCPHPClassCharts/FusionCharts/FCF_MSColumn3D.swf", "", $strXML, "KosJab", 900, 500);
    ?>
    </div>
    </td></tr>
    <tr><td width="100%">
    <div align="center">
    <div><br><b>KOS KESELURUHAN PROJEK MENGIKUT BAHAGIAN</b></div>
    <?php	
                
                $dept = $_SESSION['user_dept'];
                $countColor=0;
                $color=array("1941A5", "AFD8F8", "F6BD0F", "8BBA00", "A66EDD", "F984A1", "CCCC00", "999999", "0099CC", "FF0000", "006F00", "0099FF", "FF66CC", "669966", "7C7CB4", "FF9933", "9900FF", "99FFCC", "CCCCFF", "669900");
                $strXML = "<graph xaxisname='Tahun' yaxisname='Kos Projek' formatNumberScale='0' numberPrefix='RM' decimalPrecision='2' showvalues='0' numDivLines='4'>";
                
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
                    
                    $strQuery1 = "select department_id, department_desc from department where layer='1' ";			
                }
                else
                {
                    $strQuery1 = "select department_id from department where department_id='".$dept."' or parent_id='".$dept."'";
                }					
                $result1 = mysql_query($strQuery1) or die(mysql_error());  
                if ($result1){
                    while($ors1 = mysql_fetch_array($result1)) {  
                         $strQuery2="select sum(p.project_cost) as kos, department_desc from project p inner join department d on ".
                                "d.department_id=p.department_id where year(date_start)=year(current_date) and p.project_cost > 0.00 ".
                                "and d.parent_id='".$ors1['department_id']."' group by d.department_id";
                         //cecho $strQuery2;
                         $result2 = mysql_query($strQuery2) or die(mysql_error());
                         if ($result2){
                            while($ors2 = mysql_fetch_array($result2)){
                                $strXML .="<dataset seriesname='".$ors2['department_desc']."' color='".$color[++$countColor]."' >";   
                                $strXML .= "<set value='".$ors2['kos']."' />";
                                $strXML .="</dataset>";
                            }						
                        } 								
                    }
                }
                $strXML .= "</graph>";
                echo renderChartHTML("MyFCPHPClassCharts/FusionCharts/FCF_MSColumn3D.swf", "", $strXML, "KosJab", 900, 500);
    ?>
    </div></td>
</tr>
</table>