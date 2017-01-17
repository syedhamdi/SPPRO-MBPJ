<style type="text/css" title="currentStyle">

			@import "CSS/demo_page.css";
			@import "CSS/jquery.dataTables_themeroller.css";
			@import "CSS/jquery-ui-1.8.4.custom.css";
</style>
<script language="javascript" type="text/javascript" src="js/jquery.dataTables.js"></script>
<script language="javascript">

$(document).ready(function() {
		$('#example').DataTable( {
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		} );
	} );

function check_all(){
	for (i = 0; i < document.all['chk_del[]'].length; i++)
		if(document.all['chk_all'].checked==true)
			document.all['chk_del[]'][i].checked = true ;
		else	
			document.all['chk_del[]'][i].checked = false ;
}

function effect2(i,fld,clr){
	if(i=='1'){
		fld.style.backgroundColor='#FBF995';
	}else{
		fld.style.backgroundColor='';
	}
}

function del(frm){
	var chk=0;
	
	for (i = 0; i < document.getElementsByName('chk_del[]').length; i++){
		if(document.getElementsByName('chk_del[]')[i].checked==true){
			chk=1;	
			//alert(document.getElementsByName('chk_del[]')[i].checked);	
		}
	}
	if(chk==1){
	   var retVal = confirm("Anda pasti");
	   if( retVal == true ){
			frm.action='admin/del.php?m=<?=urlencode($_GET['m'])?>&sm=<?=urlencode($_GET['sm'])?>';
			frm.submit();
	   }else{
		 	document.location.href="main.php?m=<?=urlencode($_GET['m'])?>&sm=<?=urlencode($_GET['sm'])?>";
	   }

		
	}else{
		alert('Sila pilih rekod!');
	}	
}

</script>

<?php
		if(urlDecrypt($_GET['sm'])=='1'){
			$sql="select department_id ,department_desc 'Jabatan/Bahagian/Unit',layer 'Peringkat' from department order by seq_no";
			$sql2="select department_id ,department_desc 'Jabatan/Bahagian/Unit',layer 'Peringkat' from department ";
			$label='Jabatan/Bahagian/Unit';
		}
		elseif(urlDecrypt($_GET['sm'])=='2'){
			$sql="select user_group_id, user_group_desc 'Jawatan' from user_group order by seq";
			$sql2="select user_group_id, user_group_desc 'Jawatan' from user_group order by seq";
			$label='Kumpulan Pengguna';	
		}
		elseif(urlDecrypt($_GET['sm'])=='3'){
			$sql="select jawatan_id, jawatan_desc 'Jawatan' from jawatan order by jawatan_desc";
			$sql2="select jawatan_id, jawatan_desc 'Jawatan' from jawatan order by jawatan_desc";			
			$label='Jawatan';	
		}
		elseif(urlDecrypt($_GET['sm'])=='4'){
			$sql="select gred_id,gred_desc 'Gred' from gred order by gred_desc";
			$sql2="select gred_id,gred_desc 'Gred' from gred order by gred_desc";	
			$label='Gred';	
		}
		elseif(urlDecrypt($_GET['sm'])=='5'){
			$sql2="select user_id,user_login 'Id Pengguna',user_name 'Nama',user_group_desc 'Kumpulan Pengguna',department_desc 'Jabatan',user_email 'Email',user_noTel 'No. Tel',jawatan_desc 'jawatan'".
				 "from user u ".
				 "inner join user_group on u.user_group_id = user_group.user_group_id ".
				 "inner join jawatan on u.user_jawatan_id = jawatan.jawatan_id ".
				 "inner join department on u.department_id = department.department_id ".
				 "inner join department on u.bahagian_id = department.department_id ".
				 "order by user_login";
				 
			$sql="select user_id,user_login 'Id Pengguna',user_name 'Nama',jawatan_desc 'Jawatan',department_desc 'Jabatan/Bahagian',gred_desc 'Gred',user_email 'Email',user_noTel 'No. Tel',user_nobimbit 'No. Tel Bimbit',user_group_desc 'Kumpulan Pengguna'".
				 "from user u ".
				 "inner join user_group on u.user_group_id = user_group.user_group_id ".
				 "inner join jawatan on u.user_jawatan_id = jawatan.jawatan_id ".
				 "left join gred on u.gred_id = gred.gred_id ".
				 "inner join department on u.department_id = department.department_id ".
				"where user_admin = 0 and ahli_majlis = 0 ".
				  "order by user_login";
				 //echo $sql;
				 
			$label='Akaun Pengguna';	
		}
		elseif(urlDecrypt($_GET['sm'])=='6'){
			$sql="SELECT contractor_id, contractor_name 'Nama Perunding', contractor_regno 'No. Pendaftaran', contractor_address 'Alamat', contractor_email 'Email', contractor_phone 'No. Telefon', contractor_phonepejabat 'No. Telefon Pejabat', contractor_fax 'No. Fax', desc_yt 'Bumiputra', contractor_status_desc  'Senarai Hitam' ".
				"FROM contractor c ".
				"INNER JOIN contractor_status cs ON c.contractor_status_id = cs.contractor_status_id ".
				"INNER JOIN bumiputra_status bs ON c.bumiputra = bs.id ".
				"WHERE perunding = 1 ".
				"order by contractor_name";
			//echo $sql;
			$sql2=$sql;	 
			$label='Perunding';		
		}
		elseif(urlDecrypt($_GET['sm'])=='7'){
			$sql="SELECT contractor_id, contractor_name 'Nama Perunding', contractor_regno 'No. Pendaftaran', contractor_address 'Alamat', contractor_email 'Email', contractor_phone 'No. Telefon', contractor_phonepejabat 'No. Telefon Pejabat', contractor_fax 'No. Fax', desc_yt 'Bumiputra',c.contractor_class_id 'Kelas',contractor_class_idNew 'KelasNew',no_pkk 'No. SPKK',no_kkm 'No. KKM' , contractor_status_desc  'Senarai Hitam' ".
				"FROM contractor c ".
				"left JOIN contractor_class cc ON c.contractor_class_id = cc.contractor_class_id ".
				"INNER JOIN contractor_status cs ON c.contractor_status_id = cs.contractor_status_id ".
				"INNER JOIN bumiputra_status bs ON c.bumiputra = bs.id ".
				"WHERE perunding = 0 ".
				"order by contractor_name";
			//echo $sql;
			//exit();
			$sql2="select * from owner ". 
				"inner join contractor_owner on owner.owner_id = contractor_owner.owner_id";
					 
			$label='Kontraktor';		
		}
		elseif(urlDecrypt($_GET['sm'])=='8'){
			$sql="select project_type_id,project_type_desc 'Jenis',project_type_short 'Nama Singkatan' ".
					"from project_type order by project_type_perunding ";
			$sql2=$sql;	 
			$label='Jenis Projek';		
		}
		elseif(urlDecrypt($_GET['sm'])=='9'){
			$sql="select project_category_id,project_category_desc 'Kategori',project_category_short 'Nama Singkatan' ".
				 "from project_category order by project_category_desc";
			$sql2=$sql;	 
			$label='Kategori Projek';		
		}
		elseif(urlDecrypt($_GET['sm'])=='10'){
			
			$sql_ori="select p.project_id 'project_id',project_reference 'No. Kontrak',project_name 'Nama Projek',FORMAT(project_cost,2) 'Kos (RM)',DATE_FORMAT(date_start,'%d-%m-%Y') 'Tarikh Mula',DATE_FORMAT(date_end,'%d-%m-%Y')'Tarikh Siap',project_duration 'Tempoh Masa',project_category_desc 'Kategori',contractor_name 'Kontraktor',project_type_desc 'Jenis Projek',department_desc 'Jabatan/Bahagian', p.seq 'seq', p.seq_year 'seq1',p.seq_category 'seq2',kadar_harga 'Kadar', project_cost_month 'bln', project_cost_year 'thn' from project p ".
				"left join project_category on p.project_category_id = project_category.project_category_id ".
				"left join contractor on p.contractor_id = contractor.contractor_id ".
				"inner join department on p.department_id = department.department_id ".
				"inner join project_type on p.project_type_id = project_type.project_type_id";
			
			$sql_cont = " order by seq_year,seq_category,seq";
			$sql=$sql_ori.$sql_cont;
				// athirah start
				//include "search.php";
				// athirah end
							
			$sql2=$sql;	 
			$label='Senarai Projek';	
		}
		elseif(urlDecrypt($_GET['sm'])=='12'){
			$sql="select kepala_anak_id, kod 'Kod Bidang', kepala_anak_desc 'Bidang' from kepala_pecahan kp ".
				"inner join kepala_sub ks on ks.kepala_sub_id = kp.kepala_sub_id ".
				"inner join kepala k on k.kepala_id = ks.kepala_id ".
				"where k.perunding = 1 ";
				//echo $sql;
			$sql2=$sql;	 
			$label='Bidang Perunding';		
		}
		// athirah 21-3-2013 start
		elseif(urlDecrypt($_GET['sm'])=='13'){
			$sql="select kwsn_id 'kwsnId', k.kwsn_desc 'Parlimen/Adun/Majlis', 'Ahli', kp.nama_peringkat 'Peringkat' from kawasan k ".
				"inner join kwsn_peringkat kp on k.layer=kp.kp_ID order by seq_no";
			$sql2=$sql;
			$label='Parlimen/Adun/Majlis';
		}
		// athirah 17102012 start
		//shahrul 20-6-13 start
		elseif(urlDecrypt($_GET['sm'])=='14'){
			$sql="select contractor_class_id , class_desc 'Gred', Had 'had', kategori_kerja 'Kategori Kontraktor',DATE_FORMAT(CSdateS,'%d-%m-%Y')  'Tarikh Mula',DATE_FORMAT(CSdateE,'%d-%m-%Y') 'Tarikh Tamat' from contractor_class ".
				"order by seq_no";
			$sql2=$sql;
			$label='Gred Pendaftaran Kontraktor';
		}
		elseif(urlDecrypt($_GET['sm'])=='15'){
			$sql2="select user_id,user_login 'Id Pengguna',user_name 'Nama',user_group_desc 'Kumpulan Pengguna',department_desc 'Jabatan',user_email 'Email',user_noTel 'No. Tel',jawatan_desc 'jawatan'".
				 "from user u ".
				 "inner join user_group on u.user_group_id = user_group.user_group_id ".
				 "inner join jawatan on u.user_jawatan_id = jawatan.jawatan_id ".
				 "inner join department on u.department_id = department.department_id ".
				 "inner join department on u.bahagian_id = department.department_id ".
				 "order by user_login";
				 
			$sql="select user_id,user_login 'Id Pengguna',user_name 'Nama',user_email 'Email',user_noTel 'No. Tel',user_nobimbit 'No. Tel Bimbit',kwsn_desc 'Parlimen/Adum/Majlis' ".
				 "from user u ".
				 "inner join ahli a on u.ahli_majlis = a.ahli_id ".
				 "inner join kawasan k on a.kawasan_id = k.kwsn_id ".
				 "where user_admin = 0 and ahli_majlis <> 0 ".
				 "order by user_login";
				 //echo $sql;
				 
			$label='Akaun Ahli Majlis';	
		}
		//shahrul end
$_SESSION['sql']=$sql;
$_SESSION['sql2']=$sql2;
$_SESSION['label']=$label;

//echo $sql;
?>
	<div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px">
	<?php echo $label?>
	</div>
	<div >

		<?php						
			$result = mysql_query($sql);							
		?>	
		
		<div style="font-size:10px; font-weight:bold; padding-bottom:5px">
		<?php
			$num_rows = mysql_num_rows($result);
			echo 'Jumlah rekod : '.$num_rows;
		 ?>
		  <div style="position:absolute; right:0px; padding-right:5px; color: #0000FF;">
		  <a style="font-size:10px; font-weight:bold; color:#0000FF" title="Padam Rekod" href="javascript:del(document.theForm);"><img src="./images/delete_icon.gif" style="vertical-align:middle;" border="0" /> Padam rekod</a> &nbsp;&nbsp;&nbsp;
		  <a style="font-size:10px; font-weight:bold; color:#0000FF" title="Tambah Rekod" href="main.php?m=<?=urlencode($_GET['m'])?>&sm=<?=urlencode($_GET['sm'])?>&md=1"><img src="./images/addIcon.gif" style="vertical-align:middle;" border="0" /> Tambah rekod</a>
		  </div>
		 
		</div>
		
        <div id="list" style="border:1px solid black;width:100%;height:430px;overflow:auto;overflow-y:auto;overflow-x:auto;">
		<form name="theForm" method="post"> 
		<table id="example" class="display" border="1" bordercolor="#FFFFFF" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid" >
		<thead>
				<tr class="Color-header">
				<th width="5%"><input type="checkbox" name="chk_all" onclick="check_all()" title="Klik untuk pilih semua rekod" style="cursor:hand" /></th>
				<th width="3%" align="center">Bil.</th>				
				<?php
				$i=0;
				while ($i < mysql_num_fields($result)) {						
					$meta = mysql_fetch_field($result, $i);
					if($meta->primary_key==0){
						if($meta->name== "seq" || $meta->name== "seq1" || $meta->name== "seq2" || $meta->name == "project_id" || $meta->name == "contractor_id" || $meta->name == "user_id" || $meta->name == "Kadar" || $meta->name == "bln" || $meta->name == "thn" || $meta->name == "kwsnId" || $meta->name == "KelasNew"){
							$display_seq = "style='display:none'";
						}
						else{
							$display_seq = "";
						}
						?><th <?=$display_seq?>><?php echo $meta->name?></th><?php	
					}
					
				$i++;		  								
				}
				?>
				</tr>
          </thead>
          <tbody>			
				<?php					
				$j=0;
				$k_=0;
				$l_=0;
				$m_=0;
				$temp=0;
				$temp2=0;
				if($num_rows>0){
					while($row = mysql_fetch_array($result))			
					{
						  if(($j % 2)==1){
							$class='color-row';
							$color='#fafafa';
						  }else{
							$class='color-row2';
							$color='#E9E9E9';
						  }
						  ?>
							<tr height="20" onmouseover="effect2('1',this)" onmouseout="effect2('2',this)">
                                <td>
								<input type="checkbox" name="chk_del[]"  style="cursor:hand" value="<?=$row[0]?>"/><a href="#" title="Kemaskini Rekod"  ><img src="./images/editIcon.gif" id="idupdate" border="0" onclick="adminupdate(<?=$row[0]?>)"/></a>
								</td>
								<td >
								<?php
								
								if($label=='Jabatan/Bahagian/Unit'){
									if($row['Peringkat']==2){
											$sql_parent = "select parent_id from department where department_id=".$row['department_id'];
											$parRes = mysql_query($sql_parent);
											$row_par = mysql_fetch_array($parRes);
											$par = $row_par[0];
											if ($temp!=$par) {
												$l_=1;
											} else {
												$l_++;
											}
											echo '&nbsp;&nbsp;&nbsp;&nbsp;';
											echo ($k_).'.'.($l_);
											$temp = $par;
									}else{
										echo $k_+1;
										$k_++;
									}
								}     
								// athirah 17102012 start
								else if($label=='Parlimen/Adun/Majlis'){
									if($row['Peringkat']=='ADUN'){
										
											$sql_parent = "select parent_id from kawasan where kwsn_id=".$row['kwsnId'];
											$parRes = mysql_query($sql_parent);
											$row_par = mysql_fetch_array($parRes);
											$par = $row_par[0];
											if ($temp!=$par) {
												$l_=1;
												
											} else {
												$l_++;
											}
											echo '&nbsp;&nbsp;&nbsp;&nbsp;';
											echo ($k_).'.'.($l_);
											$temp = $par;
									}
									
									else if($row['Peringkat']=='MAJLIS'){
										
											$sql_parent = "select parent_id from kawasan where kwsn_id=".$row['kwsnId'];
											$parRes = mysql_query($sql_parent);
											$row_par = mysql_fetch_array($parRes);
											$par2 = $row_par[0];
											if ($temp2!=$par2) {
												$m_=1;
											} else {
												$m_++;
												
											}
											echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
											echo ($k_).'.'.($l_).'.'.($m_);
											$temp2 = $par2;
											
											
									}
									
									else{
										echo $k_+1;
										$k_++;
									}
								}
								
								else{
									echo $j+1	;							
								}                                                       
								?>
                                
								
                                </td>
								<?php
								$k=0;
								while ($k < mysql_num_fields($result)) {						
									$meta = mysql_fetch_field($result, $k);
									if($meta->primary_key==0){
										
										if($meta->name== "seq" || $meta->name== "seq1" || $meta->name== "seq2" || $meta->name == "project_id" || $meta->name == "contractor_id" || $meta->name == "user_id" || $meta->name == "Kadar" || $meta->name == "bln" || $meta->name == "thn" || $meta->name == "kwsnId" || $meta->name == "KelasNew"){
											$display_seq2 = "style='display:none'";
										}
										else{
											$display_seq2 = "";
										}
										
										if($meta->name=='Warna'){											
											?><td <?=$display_seq2?> bgcolor="<?php echo $row[$meta->name]?>"></td><?php	
										}else{
											?><td <?=$display_seq2?>>									
											<?
											
											if($meta->name=='Kategori Kontraktor'){
												if($row['Kategori Kontraktor']==1){
													$row['Kategori Kontraktor'] = 'Kontraktor Kerja';
												}
												if($row['Kategori Kontraktor']==2){
													$row['Kategori Kontraktor'] =  'Kontraktor Elektrik';
												}
											}
											if($meta->name=='Jabatan/Bahagian/Unit'){
												if($row['Peringkat']==2){
													echo '&nbsp;&nbsp;&nbsp;&nbsp;';
												}
											}
											if($meta->name=='Tarikh Tamat'){
												if($row['Tarikh Tamat']=='01-01-2999'){
													$row['Tarikh Tamat'] = "-";
												}
											}
											if($meta->name=='Parlimen/Adun/Majlis'){
												if($row['Peringkat']=='ADUN'){
													echo '&nbsp;&nbsp;&nbsp;&nbsp;';
												}
												if($row['Peringkat']=='MAJLIS'){
													echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
												}
											}
											if($meta->name=='Kelas'){
												$kelas = '';
												$kelasNew = '';
												if(($row['Kelas'] <> '') && ($row['Kelas'] <> '0')){
													//$kelas = process_sql("select class_desc from contractor_class where contractor_class_id = ".$row['Kelas'],"class_desc");
													$kelas = "PKK&nbsp;:&nbsp;".kelas_desc($row['Kelas'])."<br>";
												}//$kelasNew = process_sql("select class_desc from contractor_class where contractor_class_id = ".$row['KelasNew'],"class_desc");	
												if(($row['KelasNew'] <> '') && ($row['KelasNew'] <> '0')){
													//$kelasNew = process_sql("select class_desc from contractor_class where contractor_class_id = ".$row['KelasNew'],"class_desc");
													//$kelasCat = process_sql("select contractor_class_id from contractor_class where contractor_class_id = ".$row['KelasNew'],"kategori_kerja");
													$kelasNew = "SPKK&nbsp;:&nbsp;".kelas_desc($row['KelasNew']);
												}//$k
												$row['Kelas'] = $kelas.$kelasNew;																									 
											}
											if($meta->name=='Kos (RM)'){
												if ($row['thn'] != 0.0000){
													$kostahun = number_format($row['thn'],2)."&nbsp;/&nbsp;Tahun<br>";
												}
												else{
													$kostahun = "";
												}
												
												if ($row['bln'] != 0.0000){
													$kosbulan = number_format($row['bln'],2)."&nbsp;/&nbsp;Bulan<br>";
												}
												else{
													$kosbulan = "";
												}
												
												if ($row['Kadar'] == 1){
													$kadar = "Kadar&nbsp;Harga<br>";
												}
												else{
													$kadar = "";
												}
			
												if ($row['Kos (RM)'] != 0.0000){
													$kos = $row['Kos (RM)']."<br>";
													
												}
												else{
													$kos = "";
												}
												
												$row['Kos (RM)'] = $kos.$kadar.$kostahun.$kosbulan ;
												
											}
											if($k==1){
												?><a  class="text_link" title="Kemaskini Rekod" onclick="adminupdate(<?=$row[0]?>)" style="cursor:pointer"><?
											}																						
											
											if($row[$meta->name]==''){
												$row[$meta->name]='-';
											}
											
											if($meta->name=='Ahli'){
												$no = 1;
												$sqlAhli = "select * from ahli where kawasan_id =".$row[0];
												$resultAhli = mysql_query($sqlAhli);
												while($rowAhli = mysql_fetch_array($resultAhli)){
													if($rowAhli['dateE']=="2999-01-01"){
														$dateEnd = "-";							
													}else{
														$dateEnd = date("d-m-Y", strtotime($rowAhli['dateE']));
													}
													
													echo $no.")&nbsp;<a class='text_link' style='cursor:pointer' title='Kemaskini Rekod' onclick='updateahli(".$rowAhli["ahli_id"].")'>".$rowAhli["nama_ahli"]."</a>&nbsp;&nbsp;&nbsp;&nbsp;(".date("d-m-Y", strtotime($rowAhli['dateS']))."&nbsp;hingga ".$dateEnd.")<br>";
												$no++;
												}
											}else{											
												echo "<span id='update".$row[0]."_".$k."'>".$row[$meta->name]."</span>";
											}
											if($k==1){
												?></a><?
											}?>																																	
											</td>
											<?php											
										}	
									}
								$k++;
								}
								?>
                              
							</tr>		  				  
						  <?php				  
					$j++;	  
					}						
					?>						<?php
				}else{
					?><tr><td colspan="20" align="center" style="font-size:10px; color: #333333; color:#FF0000">-- Tiada Rekod --</td></tr><?php						
				}	
		?>
        </tbody>
		</table>
		</form>
		</div>	
	</div>
</div>	
<script language="javascript">
	document.getElementById("list").style.height = xDocSize("h")-215;
</script>
