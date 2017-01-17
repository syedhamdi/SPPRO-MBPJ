<?
							
							//shahrul edited 25/3/201
							 $dateMax = date("Y", strtotime($rowPhase['date_end']));
							 $dateMin = date("Y", strtotime($rowPhase['date_start']));
							          
							  					
							 echo "<td align='center'>".date("d/m/Y", strtotime($rowPhase['date_start']))."</td>";
							 echo "<td align='center'>".date("d/m/Y", strtotime($rowPhase['date_end']))."<br><br><strong>(Lanjutan&nbsp;Masa)</strong><br><br>";
										 if ($rowPhase['project_id']!="") {
											 $sqlEot = "SELECT date_eot FROM eot ".
														"WHERE project_id=".$rowPhase['project_id']." order by date_add desc";							
											 $eot = mysql_query($sqlEot);
											 $cnt=1;
											 while ($rowEot = mysql_fetch_array($eot)) {
														echo $cnt.".&nbsp;".date("d/m/Y", strtotime($rowEot['date_eot']))."&nbsp;<br>";
														$cnt++;
													}
											 if (mysql_num_rows($eot)==0)	
											 {
												 echo "<div align='center'>Tiada</div>";
											 }
											 echo "</td>";							
										  }
							  		  
							  //find date(Y) end max			  
							  if ($rowPhase['project_id']!="") {
								$dateMax_eot = process_sql("select max(date_eot) as date_eot from eot where project_id = ".$rowPhase['project_id']." ","date_eot");		
									if($dateMax_eot == ''){
										$dateMax = $dateMax;
										$tamat = $rowPhase['date_end'];

									}else{
										$dateMax = date("Y", strtotime($dateMax_eot));
										$tamat = $dateMax_eot;
									}
							  }
							 
							  //find max year
							 if($dateMax > $date_max){
								$date_max = $dateMax;	 
							 }else{
								$date_max = $date_max; 
							 }
							 
							 //find min year
							 if($dateMin < $date_min){
								$date_min = $dateMin;	 
							 }else{
								$date_min = $date_min; 
							 }
							 
							 $totalYear = $date_max - $date_min;
							 $totalYear = $totalYear;
							 
							 //find duration project
							 $mula = $rowPhase['date_start'];
							 $totalstartY = 0;
							// $totalY = 0;	
							
							 $durPro = (callDiffDate2(first_date($mula),first_date($tamat),"bulan"));
							 if($durPro == 0){
								$durPro = 1;
							 }else{
								$durPro = $durPro;	
							 }
							
							 $startM = date("m", strtotime($mula));
							 							 
							 $startY = date("Y", strtotime($mula));
							 $endY = date("Y", strtotime($tamat));
							 //echo $durPro;
							// echo $rowPhase['project_reference'].">>".$durPro."<br>";
							 //echo $durPro;
							 if ($rowPhase['project_cost'] != 0.00000){								
								$costM = ($rowPhase['project_cost']/$durPro);
								//echo $costM."xx";																																																																																											
								//if(($startY==$endY)){
//									$totalstartYx = 0;
//									for($i=1;$i<=$durPro;$i++){	
//										$totalstartYx = $totalstartYx + $costM;									
//									}
//									//echo $totalstartYx;									
//									insertTempDatabase($totalstartYx,$startY,$rowPhase['project_id']);
//									
//								}else{	
									for($i=1;$i<=$durPro;$i++){	
										if($startM <= 12){
											//echo $i.">>".$startM."/";
											$totalstartY2 = $totalstartY2 + $costM;	
											//echo $totalstartY2.">>";
											//echo $startM ;
											
											$sql = "select * from cost_peryear where cp_project_id = ".$rowPhase['project_id']." and year =".$startY."";
											$signData = process_sql($sql,"cost");
											
											if($signData == ""){
												insertTempDatabase($totalstartY2,$startY,$rowPhase['project_id']);
												//echo $totalstartY2."insert <br> ";
											}else{
												updateTempDatabase($totalstartY2,$startY,$rowPhase['project_id']);
												//echo $totalstartY2."update <br>";
											}
											
											$startM++;
											
										}else{
											
											$startM = 1;
											$totalstartY2 = 0; 											
											$startY++;
											$i--;
											
										}
									}$totalstartY2 = 0;
								// }
								 //echo $totalstartY2;
								 //echo $starttY;	
								 //echo $totalstartY;
							 }
							 
							 //total cost
							 $total_cost=$total_cost+$rowPhase['project_cost'];	
							 $payment = process_sql("select sum(amount) as amount from data_payment where project_id = ".$rowPhase['project_id']."","amount");
							 //$sqlPayment = "select * from data_payment = ".$rowPhase['project_id'];
							 $totalPayment =$totalPayment+$payment;	
							 //shahrul end


?>