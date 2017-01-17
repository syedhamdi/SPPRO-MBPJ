<div>  
		<?php
        include('../MyFCPHPClassCharts/Class/FusionCharts.php');
        include('../MyFCPHPClassCharts/Class/DBConn.php');
        ?>      
        <?php
		$group = $_SESSION['user_group_id'];		
		?>       
        </div>
        <div>
        <table bordercolor="#000000">
        <tr>
        <td>
        <?php
			if($jabatan!=""){
				$jabatanP = process_sql("select parent_id from department where department_id =".$jabatan,"parent_id");	
				if($jabatanP==0){
					$arrayP = "";
					$sqlP = "select * from department where parent_id = ".$jabatan;
					$resultP = mysql_query($sqlP);
					while($rowP = mysql_fetch_array($resultP)){
						$arrayP = ($arrayP=="")?$rowP["department_id"]:$arrayP.",".$rowP["department_id"];
					}	
				}			
			}
			
			$where="where YEAR(date_start) < (YEAR(current_date)+1) ";
			if($tahun!="")
			{
				$where = "where YEAR(date_start)='".$tahun."' ";
			}
			if($jabatan!="")
			{
				if($jabatanP==0){
					$where = "where department_id in (".$arrayP.") and YEAR(date_start) < (YEAR(current_date)+1) ";
				}else{
					$where = "where department_id='".$jabatan."' and YEAR(date_start) < (YEAR(current_date)+1) ";
				}
			}
			if($tahun!="" && $jabatan!="")
			{
				if($jabatanP==0){
					$where = "where YEAR(date_start)='".$tahun."' and department_id in (".$arrayP.") ";
				}else{
					$where = "where YEAR(date_start)='".$tahun."' and department_id='".$jabatan."' ";
				}
			}
		?></td>
        <td></td>
        </tr>
        <tr>
        <td width="50%" align="center" style="font-size:12px; font-weight:bold">BILANGAN PROJEK <?php 
		
		if($tahun!="")
		{			
			echo "PADA TAHUN ".$tahun;
		}
		else
		{
			echo "MENGIKUT TAHUN";
		}
		?>
        <?php			
			$countColor=0;
			$color=array("1941A5", "AFD8F8", "F6BD0F", "8BBA00", "A66EDD", "F984A1", "CCCC00", "999999", "0099CC", "FF0000", "006F00", "0099FF", "FF66CC", "669966", "7C7CB4", "FF9933", "9900FF", "99FFCC", "CCCCFF", "669900");
			$strXML = "<graph xaxisname='Tahun' yaxisname='Bilangan Projek' hovercapbg='DEDEBE' hovercapborder='889E6D' rotateNames='0' yAxisMaxValue='50' numdivlines='4' divLineColor='CCCCCC' divLineAlpha='80' decimalPrecision='0' AlternateHGridAlpha='30' AlternateHGridColor='CCCCCC' baseFontSize='11'>";
			
			$strQuery = "select count(*) as cnt, YEAR(date_start) as yr FROM project ".$where."GROUP BY YEAR(date_start) desc";		
			$result = mysql_query($strQuery) or die(mysql_error());
			if ($result) {
				while($ors = mysql_fetch_array($result)) {     
					$strXML .= "<set name='".$ors['yr']."' value='".$ors['cnt']."' color='".$color[++$countColor]."' />";
				}
			}
			$strXML .= "</graph>";
			echo renderChartHTML("MyFCPHPClassCharts/FusionCharts/FCF_Column3D.swf", "", $strXML, "AnalisaProjek", 500, 350);
		  ?>
          </td>          
          <td width="50%" align="center" style="font-size:12px; font-weight:bold">BILANGAN PROJEK MENGIKUT JENIS 
		  <?php 
		  	if($tahun!="")
			{
				
				echo "PADA TAHUN ".$tahun;
			}
			else
			{
				
			}		  
		  ?>
          <?php	
			$countColor=0;
			$color=array("999999", "0099CC", "006F00", "7C7CB4", "FF9933", "9900FF", "99FFCC", "CCCCFF", "669900");
			$strXML = "<graph xaxisname='Tahun' yaxisname='Bilangan Projek' hovercapbg='DEDEBE' hovercapborder='889E6D' rotateNames='0' yAxisMaxValue='50' numdivlines='4' divLineColor='CCCCCC' decimalPrecision='0' AlternateHGridAlpha='30' AlternateHGridColor='CCCCCC' baseFontSize='11'>";
			
			$strQuery = "select YEAR(date_start) as yr FROM project ".$where."GROUP BY YEAR(date_start) < YEAR(current_date)";			
			$strXML .="<categories>";
			$result = mysql_query($strQuery) or die(mysql_error());
			if ($result) {
				while($ors = mysql_fetch_array($result)) {     
					$strXML .= "<category name='".$ors['yr']."' />";
				}
				$strXML .="</categories>";
			}
			$sqlDataset = "select project_type_id as pid, project_type_desc as des from project_type where project_type_perunding='0' order by project_type_id";
			$dataset = mysql_query($sqlDataset) or die(mysql_error());
			if($dataset)
			{				
				while($orsDataset=mysql_fetch_array($dataset)){
					
					$strSet = "select YEAR(date_start) as selectYear FROM project ".$where."GROUP BY YEAR(date_start) DESC";
					//echo $strSet;
					$set = mysql_query($strSet) or die(mysql_error());
					$strXML .= "<dataset seriesname='".$orsDataset['des']."' color='".$color[++$countColor]."'>";	
					if($set)
					{
						while($orsSet=mysql_fetch_array($set))
						{
							if($jabatan=="")
							{
								$sql="select COUNT(*) as cnt, YEAR(date_start), PT.project_type_id FROM project_type PT ".
									"INNER JOIN project P ON P.project_type_id=PT.project_type_id ".
									"WHERE PT.project_type_id='".$orsDataset['pid']."' and YEAR(date_start)='".$orsSet['selectYear']."' ".
									"and PT.project_type_perunding='0' ";
							}
							else
							{
								$sql="select COUNT(*) as cnt, YEAR(date_start), PT.project_type_id FROM project_type PT ".
									"INNER JOIN project P ON P.project_type_id=PT.project_type_id ".
									"WHERE PT.project_type_id='".$orsDataset['pid']."' and YEAR(date_start)='".$orsSet['selectYear']."' ".
									"and PT.project_type_perunding='0' and P.department_id='".$jabatan."' ";

							}
							//echo $sql;
							$data = mysql_query($sql) or die(mysql_error());
							if($data)
							{
								while($value=mysql_fetch_array($data))
								{
									if($value['cnt']==0)
									{
										$strXML .=	"<set value='' />";
									}
									else
									{
										$strXML .=	"<set value='".$value['cnt']."' />";
									}
								}
							}
							if (mysql_num_rows($data)==0)
							{
								$strXML .=	"<set value='' />";	
							}
						}
					}
					$strXML .="</dataset>";
				}
			}
			$strXML .= "</graph>";
			echo renderChartHTML("MyFCPHPClassCharts/FusionCharts/FCF_MSColumn3D.swf", "", $strXML, "AnalisaProjek", 500, 350);
		  ?>          
          </td>
          </tr>
          <tr>
          <td width="50%" align="center" style="font-size:12px; font-weight:bold">BILANGAN PROJEK MENGIKUT KATEGORI 
		  <?php 
		  	if($tahun!="")
			{
				
				echo "PADA TAHUN ".$tahun;
			}
			else
			{
				
			}
		  ?>
          <?php	
			$countColor=0;
			$color=array("FF9933", "9900FF", "99FFCC", "CCCCFF", "669900");
			$strXML = "<graph xaxisname='Tahun' yaxisname='Bilangan Projek' hovercapbg='DEDEBE' hovercapborder='889E6D' rotateNames='0' yAxisMaxValue='50' numdivlines='4' divLineColor='CCCCCC' decimalPrecision='0' AlternateHGridAlpha='30' AlternateHGridColor='CCCCCC' baseFontSize='11'>";

			$strQuery = "select YEAR(date_start) as yr FROM project ".$where."GROUP BY YEAR(date_start) < YEAR(current_date)";
			$strXML .="<categories>";
			$result = mysql_query($strQuery) or die(mysql_error());
			if ($result) {
				while($ors = mysql_fetch_array($result)) {     
					$strXML .= "<category name='".$ors['yr']."' />";
				}
				$strXML .="</categories>";
			}
			$sqlDataset = "select project_category_id as pid, project_category_desc as des from project_category order by project_category_id";
			$dataset = mysql_query($sqlDataset) or die(mysql_error());
			if($dataset)
			{				
				while($orsDataset=mysql_fetch_array($dataset)){
					
					$strSet = "select YEAR(date_start) as selectYear FROM project ".$where."GROUP BY YEAR(date_start) DESC";
					$set = mysql_query($strSet) or die(mysql_error());
					$strXML .= "<dataset seriesname='".$orsDataset['des']."' color='".$color[++$countColor]."'>";	
					if($set)
					{
						while($orsSet=mysql_fetch_array($set))
						{
							if($jabatan=="")
							{
								$sql="select COUNT(*) as cnt, YEAR(P.date_start), PC.project_category_id FROM project_category PC ".
									"INNER JOIN project P ON PC.project_category_id=P.project_category_id ".
									"WHERE PC.project_category_id='".$orsDataset['pid']."' and YEAR(P.date_start)='".$orsSet['selectYear']."' ";
							}
							else
							{
								$sql="select COUNT(*) as cnt, YEAR(P.date_start), PC.project_category_id FROM project_category PC ".
									"INNER JOIN project P ON PC.project_category_id=P.project_category_id ".
									"WHERE PC.project_category_id='".$orsDataset['pid']."' and YEAR(P.date_start)='".$orsSet['selectYear']."' and P.department_id='".$jabatan."' ";
							}
							$data = mysql_query($sql) or die(mysql_error());
							if($data)
							{
								while($value=mysql_fetch_array($data))
								{
									if($value['cnt']==0)
									{
										$strXML .=	"<set value='' />";
									}
									else
									{
										$strXML .=	"<set value='".$value['cnt']."' />";
									}
								}
							}
							if (mysql_num_rows($data)==0)
							{
								$strXML .=	"<set value='' />";	
							}
						}
					}
					$strXML .="</dataset>";
				}
			}
			$strXML .= "</graph>";
			echo renderChartHTML("MyFCPHPClassCharts/FusionCharts/FCF_MSColumn3D.swf", "", $strXML, "AnalisaProjek", 500, 350);
		  ?>  
          </td>
          <td width="50%" align="center" style="font-size:12px; font-weight:bold">STATUS PENCAPAIAN 
		  <?php 
		  	if($tahun!="")
			{
				
				echo "PROJEK PADA TAHUN ".$tahun;
			}
			else
			{
				echo "KESELURUHAN PROJEK";
			}
		  ?>
		  <?php
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
				
				$strXML = "<graph showNames='0' decimalPrecision='1' numberSuffix='%25' baseFontSize='11'>";
				
				if($where=="")
				{
					$strQuery = "select project_id as pid, date_end as dateEnd from project where date_end > current_date";
				}
				else
				{
				
					$strQuery = "select project_id as pid, date_end as dateEnd from project ".$where." and date_end > current_date";
				}
						  
				$result = mysql_query($strQuery) or die(mysql_error());
				if ($result) 
				{
					$setArrayOver = array();
					while($ors = mysql_fetch_array($result))
					{
						$setArrayLess[$Control++]=$ors['pid'];
						$sqlDatasetOne = "select project_id, kemajuan_kewangan, kemajuan_fizikal, tahun, date_data from data_project ".
									"where project_id=".$ors['pid']." order by seq desc, tahun desc limit 1";
						$dataSetOne = mysql_query($sqlDatasetOne) or die(mysql_error());
						if($dataSetOne)
						{
							while($setDataOne = mysql_fetch_array($dataSetOne))
							{	
								if($setDataOne['kemajuan_fizikal']==100)
								{
									++$CountAwal;
								}
								if($setDataOne['kemajuan_fizikal']!=100)
								{
									++$CountBerjalan;
								}
							}
							if(mysql_num_rows($dataSetOne)==0)
							{
								++$CountBerjalan;
							}
						}
					}
				}
				
				if($where=="")
				{
					$strQuery = "select project_id as pid, date_end as dateEnd from project where date_end < current_date";
				}
				else
				{
				
					$strQuery = "select project_id as pid, date_end as dateEnd from project ".$where." and date_end < current_date";
				}
						  
				$result = mysql_query($strQuery) or die(mysql_error());
				if ($result) 
				{
					$setArrayLess = array();
					while($ors = mysql_fetch_array($result))
					{
						$setArrayLess[$Control1++]=$ors['pid'];
						$sqlDatasetOne = "select project_id, kemajuan_kewangan, kemajuan_fizikal, tahun, date_data from data_project ".
									"where project_id=".$ors['pid']." order by seq desc, tahun desc limit 1";
						$dataSetOne = mysql_query($sqlDatasetOne) or die(mysql_error());
						if($dataSetOne)
						{
							while($setDataOne = mysql_fetch_array($dataSetOne))
							{	
								if($setDataOne['kemajuan_fizikal']==100 && $setDataOne['date_data'] > $ors['dateEnd'])
								{
									++$CountLewat;
								}
								if($setDataOne['kemajuan_fizikal']==100 && $setDataOne['date_data'] < $ors['dateEnd'])
								{
									++$CountAwal;
								}
								if($setDataOne['kemajuan_fizikal']==100 && $setDataOne['date_data'] = $ors['dateEnd'])
								{
									++$CountTepat;
								}
								if($setDataOne['kemajuan_fizikal']!=100)
								{
									++$CountTerbengkalai;
								}
							}	
							if(mysql_num_rows($dataSetOne)==0)
							{
								++$CountTerbengkalai;
							}			
						}						
					}
				}	
				if($where=="")
				{
					$strQuery = "select project_id as pid, date_end as dateEnd from project where date_end = current_date";
				}
				else
				{
					$strQuery = "select project_id as pid, date_end as dateEnd from project ".$where." and date_end = current_date";
				}
				
				$result = mysql_query($strQuery) or die(mysql_error());
				if ($result) 
				{
					$setArrayEqual = array();
					while($ors = mysql_fetch_array($result))
					{
						
						$setArrayEqual[$Control2++]=$ors['pid'];
						$sqlDatasetOne = "select project_id, kemajuan_kewangan, kemajuan_fizikal, tahun, date_data from data_project ".
									"where project_id=".$ors['pid']." order by seq desc, tahun desc limit 1";
						$dataSetOne = mysql_query($sqlDatasetOne) or die(mysql_error());
						if($dataSetOne)
						{
							while($setDataOne = mysql_fetch_array($dataSetOne))
							{	
								if($setDataOne['kemajuan_fizikal']==100)
								{
									++$CountTepat;
								}
							}				
						}	
					}
				}					
				$numProjek=$Control+$Control1+$Control2;
				if($CountAwal!=0)
				{
					$percentAwal=($CountAwal/$numProjek*100);
					$strXML .= "<set name='Siap Awal' value='".$percentAwal."' color='53fc00' />";
				}
				if($CountTepat!=0)
				{
					$percentTepat=($CountTepat/$numProjek*100);
					$strXML .= "<set name='Siap Mengikut Jadual' value='".$percentTepat."' color='052efc' />";
				}
				if($CountLewat!=0)
				{
					$percentLewat=($CountLewat/$numProjek*100);
					$strXML .= "<set name='Siap Lewat' value='".$percentLewat."' color='fc051c' />";
				}
				if($CountBerjalan!=0)
				{
					$percentBerjalan=($CountBerjalan/$numProjek*100);
					$strXML .= "<set name='Sedang Dijalankan' value='".$percentBerjalan."' color='fc9005' />";
				}
				if($CountTerbengkalai!=0)
				{
					$percentTerbengkalai=($CountTerbengkalai/$numProjek*100);
					$strXML .= "<set name='Belum Siap' value='".$percentTerbengkalai."' color='ffff00' />";
				}
					
				$strXML .= "</graph>";
				echo renderChartHTML("MyFCPHPClassCharts/FusionCharts/FCF_Pie3D.swf", "", $strXML, "AnalisaProjek", 450, 350);
			?>
          </td>        
          </tr>
          <tr>
          <td></td>
          <td align="center">
          <table width="80%" style=" border-bottom:gray 1px solid; border-left: #999999 1px solid; border-right: gray 1px solid; border-top: #999999 1px solid;">
                <tr>
                    <td height="34" colspan="2" background="images/GradientBlue.JPG" class="Color-header1">&nbsp;&nbsp;&nbsp;Status Projek</td>
                    <td height="34" background="images/GradientBlue.JPG" class="Color-header1" align="center">Bilangan Projek</td>
                </tr>
                <tr>
                    <td height="20">&nbsp;&nbsp;&nbsp;&nbsp;Siap Awal</td>
                    <td height="20"><img src="images/status-awal.jpg"></td>
                    <td height="20" align="center"><?=$CountAwal?></td>
                </tr>
                <tr>
                    <td height="20">&nbsp;&nbsp;&nbsp;&nbsp;Siap Mengikut Jadual</td>
                    <td height="20"><img src="images/status-menepati.jpg"></td>
                    <td height="20" align="center"><?=$CountTepat?></td>
                </tr>
                <tr>
                    <td height="20">&nbsp;&nbsp;&nbsp;&nbsp;Siap Lewat</td>
                    <td height="20"><img src="images/status-lewat.jpg"></td>
                    <td height="20" align="center"><?=$CountLewat?></td>
                </tr>
                <tr>
                    <td height="20">&nbsp;&nbsp;&nbsp;&nbsp;Sedang Dijalankan</td>
                    <td height="20"><img src="images/status-sedang.jpg"></td>
                    <td height="20" align="center"><?=$CountBerjalan?></td>
                </tr>
                <tr>
                    <td height="20">&nbsp;&nbsp;&nbsp;&nbsp;Belum Siap</td>
                    <td height="20"><img src="images/status-terbengkalai.jpg"></td>
                    <td height="20" align="center"><?=$CountTerbengkalai?></td>
                </tr>
                 <tr>
                    <td height="34" colspan="2" background="images/GradientBlue.JPG" class="Color-header1">&nbsp;&nbsp;&nbsp;&nbsp;Jumlah Keseluruhan</td>
                    <td height="34" background="images/GradientBlue.JPG" class="Color-header1" align="center"><?=$numProjek?></td>
                </tr>
            </table></td>
          </tr>
          </table>
        </div>
</div>