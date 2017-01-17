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
			frm.action='projekdirancang/del.php?m=<?=$_GET['m']?>&sm=<?=$_GET['sm']?>';
			frm.submit();
	   }else{
		 	document.location.href="main.php?m=<?=$_GET['m']?>&sm=<?=$_GET['sm']?>";
	   }

		
	}else{
		alert('Sila pilih rekod!');
	}	
}

</script>

<?php

		if($_GET['fd']=='1'){
			
			$sql_ori="select p.project_id 'Projek ID',DATE_FORMAT(project_date,'%d-%m-%Y') 'Tarikh',project_name 'Nama Projek',FORMAT(project_costA,2) 'Kos Dirancang (RM)',DATE_FORMAT(date_start,'%d-%m-%Y') 'Tarikh Mula',DATE_FORMAT(date_end,'%d-%m-%Y')'Tarikh Siap',project_duration 'Tempoh Masa',project_category_desc 'Kategori',project_type_desc 'Jenis Projek',department_desc 'Jabatan/Bahagian', p.seq 'seq', p.seq_year 'seq1',p.seq_category 'seq2',kadar_harga 'Kadar', project_cost_month 'bln', project_cost_year 'thn' from project_dirancang p ".
				"left join project_category on p.project_category_id = project_category.project_category_id ".
				"left join contractor on p.contractor_id = contractor.contractor_id ".
				"inner join department on p.department_id = department.department_id ".
				"inner join project_type on p.project_type_id = project_type.project_type_id where p_award = 0 and statusPDirancang = 1 ";
			
			$sql_cont = "order by p.project_id";
			$sql=$sql_ori.$sql_cont;
				// athirah start
				//include "search.php";
				// athirah end
							
			$sql2=$sql;	 
			$label='Senarai Projek Dirancang';	
		}
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
		 
		</div>
		
        <div id="list" style="border:1px solid black;width:100%;height:430px;overflow:auto;overflow-y:auto;overflow-x:auto;">
		<form name="theForm" method="post"> 
		<table id="example" class="display" border="1" bordercolor="#FFFFFF" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid" >
		<thead>
				<tr class="Color-header">
				<th width="5%" align="center">Import</th>			
				<?php
				$i=0;
				while ($i < mysql_num_fields($result)) {						
					$meta = mysql_fetch_field($result, $i);
					if($meta->primary_key==0){
						if($meta->name== "seq" || $meta->name== "seq1" || $meta->name== "seq2" || $meta->name == "contractor_id" || $meta->name == "user_id" || $meta->name == "Kadar" || $meta->name == "bln" || $meta->name == "thn" || $meta->name == "kwsnId" || $meta->name == "KelasNew"){
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
								<input style="cursor:pointer;" type="button" value="Import" onclick="pro_import(<?=$row[0]?>)" />
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
