<? include 'connection.php';?>
<? include 'serversidescript.php';?>
<? session_start() ?>

<?php

$func = $_GET["func"];

if ($func!="") {
	eval($func());
}

function kwsnAhli(){
	$idAhli = $_GET['value'];
	$kwsnAhli = process_sql("select kwsn_desc from kawasan k inner join ahli a on a.kawasan_id = k.kwsn_id where ahli_id = ".$idAhli,"kwsn_desc");
	$layerAhli = process_sql("select layer from kawasan k inner join ahli a on a.kawasan_id = k.kwsn_id where ahli_id = ".$idAhli,"layer");
	if($layerAhli==1){
		$layer = "PARLIMEN";
	}else if($layerAhli==2){
		$layer = "ADUN";	
	}else if($layerAhli==3){
		$layer = "MAJLIS";	
	}
	
	if($idAhli=="0"){
		echo "&nbsp;-";
	}else{
		echo "&nbsp;<b>".$layer."&nbsp;:&nbsp;".$kwsnAhli."</b>";
	}
			
}
function tempohAhli(){
	$idAhli = $_GET['value'];
	$dateS = process_sql("select dateS from kawasan k inner join ahli a on a.kawasan_id = k.kwsn_id where ahli_id = ".$idAhli,"dateS");	
	$dateE = process_sql("select dateE from kawasan k inner join ahli a on a.kawasan_id = k.kwsn_id where ahli_id = ".$idAhli,"dateE");	
	if($dateE == '2999-01-01'){
		$dateE = "Sekarang";	
	}else{
		$dateE = date("d/m/Y",strtotime($dateE));
	}
	if($idAhli=="0"){
		echo "&nbsp;-";
	}else{
		echo "&nbsp;<b>".date("d/m/Y",strtotime($dateS))."&nbsp;hingga&nbsp;".$dateE."</b>";
	}	
}

function kos_ajax(){
		
	?>
	<input name="kos" type="text" disabled="disabled" id="kos" size="40" value="0.00" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
	<?

}

function kos_ajax2(){
		
	?>
	<input accept="check" name="kos" type="text" id="kos" size="40" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
	<?

}

function title(){
	
	?>
	<select accept="check" name="kategori" id="kategori" onchange="classcondition(this)">
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sql='select * from project_category';
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result))
                        {
                    ?>
                    <option value="<?=$row['project_category_id'] ?>">
                      <?=$row['project_category_desc']?>
                    </option>
                    <? 
                    }	
                        ?>
</select>
	<?
}

function title2(){
	

}

function bidanghide(){
	

}

function getUser() {
	$deptId = $_GET["deptId"];
	$sql = "SELECT * from department WHERE parent_id = '".$deptId."'";
	$result = mysql_query($sql);
	$x = mysql_num_rows($result);

	if($x!=0) {
		$deptId = $_GET["deptId"];
		$sql="SELECT * FROM department WHERE parent_id = '".$deptId."'";
		$result = mysql_query($sql);
		$x = mysql_num_rows($result); 
		if($x!=0) {
			?>
<style type="text/css">
.bold {
	font-weight: bold;
}
</style>

<select name="bahagian" id="bahagian" >
            <option>---Sila Pilih---</option>
            <?
           	 	while($row = mysql_fetch_array($result))
            	{
            ?>
            		<option value=<?=$row['department_id'] ?>>
            		<?=$row['department_desc']?>
            		</option>
            <? 
            	}
            ?>
</select>
            <?
		}
}

}

function masukdata(){
	
	$colno = $_GET['colno'];
	$pid = $_GET['projek_id'];
	$dpid = $_GET['dpid'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$seqThn = $_GET['seqThn'];
	
	
	if ($dpid==0) {
		//check for data (if none, create new data)
		$sql = "select * from data_project where project_id=".$pid." and seq=".$colno." and tahun =".$tahun;
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$dpid = $row['data_project_id'];
		}
		if ($dpid==0) {
			$date = getDataDate($pid,$colno);
			$year_date = date("Y", strtotime($date));
			$sql = "insert into data_project (data_project_id,project_id,project_reference,kemajuan_kewangan,kemajuan_kewangan_bln,kemajuan_kewangan_thn,kemajuan_fizikal,seq,tahun,date_data,seqThn) values(".$dpid.",".$pid.",".$pid.",0,0,0,0,".$colno.",".$tahun.",'".$date."','".$seqThn."')";
			mysql_query($sql);
			$sql = "select * from data_project where project_id=".$pid." and seq=".$colno;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)) {
				$dpid = $row['data_project_id'];
			}
		}
	}
	
	$sqlUpdate = "update data_project set seqThn = '".$seqThn."' where data_project_id = ".$dpid ;
	$result = mysql_query($sqlUpdate);
	
	$date = getDataDate($pid,$colno);
	
	$sql = "select * from data_project where data_project_id=".$dpid;
	$res = mysql_query($sql);
	$cnt = mysql_num_rows($res);
	if ($cnt!=0) {
		while($row = mysql_fetch_array($res)) {
			$fizikal = $row['kemajuan_fizikal'];
			$catatan = $row['catatan'];
			if($row['kemajuan_dirancang'] == ''){
				$fizikalDirancang = 0;
			}else{
				$fizikalDirancang = $row['kemajuan_dirancang'];	
			}
		}
	} else {
		$fizikal = "";
		$catatan = "";
		$fizikalDirancang = "";
	}
	
	$category = process_sql("select * from project where project_id = ".$pid,"project_category_id");
	if(($category==1)|| ($category==0)){$kemajuan = "Kemajuan Fizikal (Sebenar)";}
	if($category==2){$kemajuan = "Kemajuan Bekalan";}
	if($category==3){$kemajuan = "Prestasi Kontraktor";}
	?>
	<table border="0" cellpadding="2" cellspacing="0" style="padding:0px; width:115%; border:#999999 1px solid">
           <tr>
          	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
          	<td width="5%">&nbsp;</td>
            <td width="45%">
            	<div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px">
            		Kemasukan Data </br><?="Bulan ".$bulan." (".$tahun.")"?>
            	</div>
            </td>
            <td width="45%">&nbsp;</td>
            <td width="5%">&nbsp;</td>
          </tr>
          <?
		  	$DirancangTR = "";
          	$TextFizikal = "text";
			$fizikalPerkhidmatan = "";
			if($category==3){
				$DirancangTR = "none";
				$TextFizikal = "hidden";
				$fizikalPerkhidmatan =$fizikal;
			} 
		  ?>
          <tr style="display:<?=$DirancangTR?>;">
            <td>&nbsp;</td>
            <td>Kemajuan Fizikal (Dirancang)</td>
            <td><input type="text" name="fizikalDirancang" id="fizikalDirancang" value="<?=$fizikalDirancang?>" style="width:40px; text-align:center;" onkeyup="checknumberpercent(this)"/><b>&nbsp;%</b></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
          	<td>&nbsp;</td>
            <td><?=$kemajuan?></td>
            <td><span id="prsKon"><input type="<?=$TextFizikal?>" name="fizikal" id="fizikal" value="<?=$fizikal?>" style="width:40px; text-align:center;" onkeyup="checknumberpercent(this)"><b><?=$fizikalPerkhidmatan?>&nbsp;%</b></span></td>
            <td>
            	<input type="hidden" name="columnnum" id="columnnum" value="<?=$colno?>" />
              	<input type="hidden" name="project_id" id="project_id" value="<?=$pid ?>" />
            	<input type="hidden" name="date_data" id="date_data" value="<?=$date?>" />
                <input type="hidden" name="year_data" id="year_data" value="<?=date("Y", strtotime($date));?>" />
                <input type="hidden" name="tahun" id="tahun" value="<?=$tahun?>" />
            </td>
          </tr>
          <tr id="kesuluruhan_tr" style="display:<?=get_showAmount($pid,"project_cost")?>" height="25">
          	<td>&nbsp;</td>
            <td>Kemajuan Kewangan Kesuluruhan</td>
            <td style="padding:3px;" valign="middle">
            	<div id="kemajuan_kewangan_1">
					<?=getTotalPerc($pid,$dpid,1,$seqThn)?>&nbsp;%
                </div>
            </td>
            <td>&nbsp;</td>
          </tr>
           <tr id="bulan_tr" style="display:<?=get_showAmount($pid,"project_cost_month")?>" height="25">
          	<td>&nbsp;</td>
            <td>Kemajuan Kewangan Bulanan</td>
            <td style="padding:3px;" valign="middle">
            	<div id="kemajuan_kewangan_2">
					<?=getTotalPerc($pid,$dpid,2,$seqThn)?>&nbsp;%
                </div>
            </td>
            <td>&nbsp;</td>
          </tr>
           <tr id="tahun_tr" style="display:<?=get_showAmount($pid,"project_cost_year")?>" height="25">
          	<td>&nbsp;</td>
            <td>Kemajuan Kewangan Tahunan</td>
            <td style="padding:3px;" valign="middle">
            	<div id="kemajuan_kewangan_3">
					<?=getTotalPerc($pid,$dpid,3,$seqThn)?>&nbsp;%
                </div>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr style="display:<?=get_showAmount($pid,"project_cost")?>">
          	<td>&nbsp;</td>
            <td>Jumlah Pembayaran Keseluruhan</td>
            <td style="padding:3px;">
            	<span id="pay_cost_1" style="border:0px #666666 solid;">
            		<?
                    	echo "RM ".number_format(getTotalPayment($pid,$dpid,1,$seqThn),2)." / RM ".number_format(getCost($pid,$dpid,1),2);
					?>
                </span>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr style="display:<?=get_showAmount($pid,"project_cost_month")?>">
          	<td>&nbsp;</td>
            <td>Jumlah Pembayaran Bulanan</td>
            <td style="padding:3px;">
            	<span id="pay_cost_2" style="border:0px #666666 solid;">
            		<?
                    	echo "RM ".number_format(getTotalPayment($pid,$dpid,2,$seqThn),2)." / RM ".number_format(getCost($pid,$dpid,2),2);
					?>
                </span>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr style="display:<?=get_showAmount($pid,"project_cost_year")?>">
          	<td>&nbsp;</td>
            <td>Jumlah Pembayaran Tahunan</td>
            <td style="padding:3px;">
            	<span id="pay_cost_3" style="border:0px #666666 solid;">
            		<?
                    	echo "RM ".number_format(getTotalPayment($pid,$dpid,3,$seqThn),2)." / RM ".number_format(getCost($pid,$dpid,3),2);
					?>
                </span>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
          	<td>&nbsp;</td>
           <td colspan="2">
           
                <table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #999999 solid;">
                <tr><td align='center' class='color-header' width='5%'>No</td><td align='center' class='color-header' width='20%'>Tarikh</td><td align='center' class='color-header' width='24%'  >Jumlah (RM)</td><td align='center' class='color-header' width='20%' style='font-size:10px;'>No. Invois</td><td align='center' class='color-header' width='35%'>Nama Pegawai</td><td align='center' class='color-header' width='40%' style='font-size:10px;'>Jenis Bayaran</td><td align='center' class='color-header' width='5%' style='font-size:10px;'>Padam</td></tr>
                </td></tr></table>
                    <div id="kewanganDet" style="border:0px red solid; width:100%; height:60px; overflow-y:scroll; overflow-x:hidden;">
                        <?
                            $sql = "select * from data_payment where data_project_id=".$dpid." order by date_pay desc";
                            $res = mysql_query($sql);
                            $cnt = mysql_num_rows($res);
                            $noCnt=0;
							echo "<div style='border:1px #999999 solid; height:100%; border-bottom:0px; border-top:0px;'>";
								echo "<table width='100%' border='0' cellpadding='5' cellspacing='0' style='padding:2px; border:#999999 0px solid;'>";
								if ($cnt!=0) {
									while($row = mysql_fetch_array($res)) {
										$noCnt++;
										if($noCnt%2==0) {
											$col="#CCCCCC";
										} else {
											$col="";
										}
										$data_payment_id = $row['data_payment_id'];
										$amount = $row['amount'];
										$date_pay = $row['date_pay'];
										$user_id = $row['user_id'];
										$jenis_bayaran = $row['jenis_bayaran'];
										$invois = $row['invois'];
										if($jenis_bayaran==1){
											$jenis_Byr = "Kesuluruhan";
										}
										if($jenis_bayaran==2){
											$jenis_Byr = "Bulanan";
										}
										if($jenis_bayaran==3){
											$jenis_Byr = "Tahunan";
										}
										$user_name = process_sql("select user_name from user where user_id=".$user_id,"user_name");
										echo "<tr style='background-color:".$col.";'><td align='center' width='4%'>".$noCnt."</td><td align='center' width='12%'>".date("d/m/Y",strtotime($date_pay))."</td><td align='center' width='14%'>".number_format($amount,2)."</td><td width='12%'>&nbsp;&nbsp;&nbsp;".$invois."</td><td width='19%'>".substr($user_name,0,15)."</td></td><td width='9%' style='font-size: 8px;'>".$jenis_Byr."</td><td align='center' width='7%'><img src='images/x.png' width='10' style='cursor:pointer;' border='0' onclick='deleteAmount(".$pid.",".$dpid.",".$data_payment_id.",".$jenis_bayaran.",".$seqThn.")'></td></tr>";
									}
								} else {
									echo "<tr><td align='center' colspan='4'>Tiada rekod.</td></tr>";
								}
								echo "</table>";
							echo "</div>";
                        ?>
                    </div>
                <div style="border:0px blue solid; height:10px; width:96%;">
                <?
					$sql = "select department_id from project where project_id=".$pid;
					$dept_id = process_sql($sql,"department_id");
					$data = $pid."^".$dept_id;
					
				?>
                    <?
                        $noCnt++;
                        echo "<table width='100%' border='0' bordercolor='#FFFFFF' bordercolorlight='#CCCCCC' cellpadding='0' cellspacing='0' style='padding:2px; width:100%; border:#999999 0px solid;'><tr>";
                        echo "<td align='center' width='8%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'>&nbsp;</td>";
						echo "<td align='center' width='10%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'><input type='text' name='date_pay' id='date_pay' readonly='readonly' style='cursor:pointer; width:100%; height:18px; text-align:center;' /></td>";
						echo "<td align='center' width='10%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'><input type='text' name='amount' id='cost' style='width:100%; height:18px; text-align:center;' onkeyup='numberkosfloat(this)' /></td>";
                        echo "<td align='left' width='10%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'><input type='text' name='invois' id='invois' style='width:30%; height:18px; text-align:left;' /></td>";
                        echo "<td align='center' width='24%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'>&nbsp;</td>";
						echo "<td align='right' width='52%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'>&nbsp;</td></tr>";
						echo "<tr>";
						echo "<td  width='4%'>&nbsp;</td>";
						echo "<td  width='20%'>Jenis Bayaran</td>";
						echo "<td  width='24%'><span style='display:".get_showAmount($pid,"kadar")."'><input type='radio' name='jenis_Bayaran' id='jenis_Bayaran' value='0' />&nbsp;Kadar Harga<br></span><span style='display:".get_showAmount($pid,"project_cost")."'><input type='radio' name='jenis_Bayaran' id='jenis_Bayaran' value='1' />&nbsp;Kesuluruhan<br></span><span style='display:".get_showAmount($pid,"project_cost_month")."'><input type='radio' name='jenis_Bayaran' id='jenis_Bayaran' value='2' />&nbsp;Bulanan<br></span><span style='display:".get_showAmount($pid,"project_cost_year")."'><input type='radio' name='jenis_Bayaran' id='jenis_Bayaran' value='3' />&nbsp;Tahunan</span></td></td>";
						echo "<td  width='52%'>&nbsp;</td>";
						echo "</tr>";
						echo "<tr>";
                        echo "<td align='center' width='4%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'>&nbsp;</td>";
						echo "<td align='center' width='20%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'>&nbsp;</td>";
                        echo "<td align='center' width='24%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'>&nbsp;</td>";
						echo "<td align='center' width='24%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'>&nbsp;</td>";
						
						//$POverall = check_type(get_showAmount($pid,"project_cost"));
						//$PMonth = check_type(get_showAmount($pid,"project_cost_month"));
						//$PYear = check_type(get_showAmount($pid,"project_cost_year"));
												
                        echo "<td align='right' width='52%' class='color-header' style='border-left:0px;border-right:0px;border-top:0px;'>&nbsp;<input type='button' class='button' onclick='addAmount(".$pid.",".$dpid.",".$seqThn.")' value='Tambah' /></td></tr></table>";                    
					?>
                </div>
           </td>
           <td>&nbsp;</td>
          </tr>
          <tr>
          	<td>&nbsp;</td>
            <td>Catatan</td>
            <td><textarea name="catatan" id="catatan" cols="36" rows="5"><?=$catatan?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
          	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr style="background-color:#666666">
            <td colspan="3" align="right">
            	<?
					$sql = "select department_id from project where project_id=".$pid;
					$dept_id = process_sql($sql,"department_id");
					$data = $pid."^".$dept_id;
				?>
            	<input type="button" name="button" id="button" value="Simpan" onclick="insertdata()">
                <input type="button" name="button2" id="button2" value="Batal" onClick="tutup(),loadFindProj('<?=$data?>','projectData')"/>
			</td>
            <td></td>
          </tr>
</table>
	<?
}

function insertdata(){
	
	$fizikal = $_GET["fizikal"];
	if ($fizikal=="") {
		$fizikal=0;
	}
	$fizikalDirancang = $_GET["fizikalDirancang"];
	if ($fizikalDirancang=="") {
		$fizikalDirancang=0;
	}
	//$kewangan = $_GET["kewangan"];
	//$bayaran = $_GET["bayaran"];
	$catatan = $_GET["catatan"];
	$project_id = $_GET["project_id"];
	$colno = $_GET["columnnum"];
	$date_data = $_GET["date_data"];
	$year_data = $_GET["year_data"];
	
	$sqlnum = "select * from data_project ".
			"where project_id = ".$project_id." and seq = ".$colno;
	$resultnum = mysql_query($sqlnum);
	$num_row = mysql_num_rows($resultnum);
	
	if ($num_row == "0"){		
		$sql="insert into data_project(project_id,project_reference,kemajuan_fizikal,seq,tahun,catatan,date_data,kemajuan_dirancang) values('".$project_id."','".$project_id."',".$fizikal.",".$colno.",".$year_data.",'".$catatan."','".$date_data."','".$fizikalDirancang."')";
		mysql_query($sql);	
		
		}
	if ($num_row != "0"){		
		$sql="update data_project set kemajuan_fizikal='".$fizikal."',kemajuan_dirancang='".$fizikalDirancang."',catatan='".$catatan."',date_data='".$date_data."',tahun=".$year_data." ".
			 "where project_id=".$project_id." and seq=".$colno." ";	
		mysql_query($sql);	
	}
	$sql="select * from project where project_id=".$project_id;
	$rs = mysql_query($sql);
	
	echo $project_id."^".$rs['department_id'];
}

function getReferen() {
	
	$jenisId = $_GET["jenisId"];
	$mula = date("Y") ;
	$perunding = $_GET["perunding"];

	if($perunding==0){

		$sql = "SELECT project_type_short from project_type WHERE project_type_id = '".$jenisId."'";
		$result = mysql_query($sql);
		$rows = mysql_fetch_array($result);
	
		$sqlrow = "SELECT * from project WHERE project_type_id = '".$jenisId."' and year = '".$mula."' and perunding = '0' ";
		$resultrow = mysql_query($sqlrow);
		$num_rows = mysql_num_rows($resultrow);
		//echo $sqlrow;
		$no = $num_rows + 1;
		//exit();
		
		?><input type="text" readonly="readonly" id="referen" name="referen" value="<? echo $rows['project_type_short']?> <? echo $no?>/<? echo $mula;?>">

	<?
	}
	if($perunding==1){
	
		$sqlrow = "SELECT * from project WHERE project_type_id = '".$jenisId."' and year = '".$mula."' and perunding = 1 ";
		$resultrow = mysql_query($sqlrow);
		$num_rows = mysql_num_rows($resultrow);
		
		$no = $num_rows + 1;
		//exit();
		
		?><input type="text" readonly="readonly" id="referen" name="referen" value="<? echo "P"?> <? echo $no?>/<? echo $mula;?>">
		
		
<?
	}
}

function datediffhari() {
	
	$mula = $_GET["mula"];
	$tamat = $_GET["tamat"];
	
	$date_mula = $mula;              // returns Saturday, January 30 10 02:06:34
	$timestamp_mula = strtotime($date_mula);
	$new_mula = date('Y-m-d', $timestamp_mula);   
	
	$date_tamat = $tamat;              // returns Saturday, January 30 10 02:06:34
	$timestamp_tamat = strtotime($date_tamat);
	$new_tamat = date('Y-m-d', $timestamp_tamat);   

	$diff = abs(strtotime($new_mula) - strtotime($date_tamat));

	//$years = floor($diff / (365*60*60*24));
	//$weeks = floor($diff / (60 * 60 * 24 * 7));
	//$months = floor(($diff) / (30*60*60*24));
	$days = floor(($diff)/ (60*60*24));

	if ($days != 0){
		
		$dispdays = $days.' Hari ';
				
		}
		else{
			
			$dispdays = 'Tiada';
			}
			
			
		?><input  type="text" name="jangkamasa" id="jangkamasa" size="10" value="<? echo $dispdays?>" readonly="readonly"/>
		<?
}



function datediffminggu() {
	
	$mula = $_GET["mula"];
	$tamat = $_GET["tamat"];
	
	$date_mula = $mula;              // returns Saturday, January 30 10 02:06:34
	$timestamp_mula = strtotime($date_mula);
	$new_mula = date('Y-m-d', $timestamp_mula);   
	
	$date_tamat = $tamat;              // returns Saturday, January 30 10 02:06:34
	$timestamp_tamat = strtotime($date_tamat);
	$new_tamat = date('Y-m-d', $timestamp_tamat);   

	$diff = abs(strtotime($new_mula) - strtotime($date_tamat));

	$years = floor($diff / (365*60*60*24));
	$weeks = floor($diff / (60 * 60 * 24 * 7));
	$months = floor(($diff) / (30*60*60*24));
	$days = floor(($diff)/ (60*60*24));
	
	if ($weeks != 0){
		
		$dispweeks = $weeks.' Minggu ';
				
		}
		else{
			
			$dispweeks = 'Tiada';
			}
			
			
		?><input type="text" name="jangkamasa" id="jangkamasa" size="10" value="<? echo $dispweeks?>" readonly="readonly"/>
		<?
}

function datediffbulan() {
	
	$mula = $_GET["mula"];
	$tamat = $_GET["tamat"];
	
	$date_mula = $mula;              // returns Saturday, January 30 10 02:06:34
	$timestamp_mula = strtotime($date_mula);
	$new_mula = date('Y-m-d', $timestamp_mula);   
	
	$date_tamat = $tamat;              // returns Saturday, January 30 10 02:06:34
	$timestamp_tamat = strtotime($date_tamat);
	$new_tamat = date('Y-m-d', $timestamp_tamat);   

	$diff = abs(strtotime($new_mula) - strtotime($date_tamat));

	$years = floor($diff / (365*60*60*24));
	$weeks = floor($diff / (60 * 60 * 24 * 7));
	$months = floor(($diff) / (30*60*60*24));
	$days = floor(($diff)/ (60*60*24));
	
	//if ($years != 0){
//		
//		$dispyears = $years.' tahun ';
//				
//		}
//		else{
//			
//			$dispyears = '';
//			}
	if ($months != 0){
		
		$dispmonths = $months.' Bulan ';
				
		}
		else{
			
			$dispmonths = 'Tiada';
			}
			
		?><input type="text" name="jangkamasa" id="jangkamasa" size="10" value="<? echo $dispmonths?>" readonly="readonly"/>
		<?
}

function datedifftahun() {
	
	$mula = $_GET["mula"];
	$tamat = $_GET["tamat"];
	
	$date_mula = $mula;              // returns Saturday, January 30 10 02:06:34
	$timestamp_mula = strtotime($date_mula);
	$new_mula = date('Y-m-d', $timestamp_mula);   
	
	$date_tamat = $tamat;              // returns Saturday, January 30 10 02:06:34
	$timestamp_tamat = strtotime($date_tamat);
	$new_tamat = date('Y-m-d', $timestamp_tamat);   

	$diff = abs(strtotime($new_mula) - strtotime($date_tamat));

	$years = round($diff / (365*60*60*24));
	$weeks = floor($diff / (60 * 60 * 24 * 7));
	$months = floor(($diff) / (30*60*60*24));
	$days = floor(($diff)/ (60*60*24));
	
	if ($years != 0){
		
		$dispyears = $years.' Tahun ';
				
		}
		else{
			
			$dispyears = 'Tiada';
			}
			
		?><input type="text" name="jangkamasa" id="jangkamasa" size="10" value="<? echo $dispyears?>" readonly="readonly"/>
		<?
}
function convertdate(){
	
	$mula = $_GET["mula"];
	$tamat = $_GET["tamat"];
	
	$date_tamat = $tamat;              // returns Saturday, January 30 10 02:06:34
	$timestamp_tamat = strtotime($date_tamat);
	$new_tamat = date('Y-m-d', $timestamp_tamat); 
	
	$date_mula = $mula;              // returns Saturday, January 30 10 02:06:34
	$timestamp_mula = strtotime($date_mula);
	$new_mula = date('Y-m-d', $timestamp_mula);   
	 
	?><input type="hidden" name="datetamat" id="datetamat" value="<? echo $new_mula?>"/>
	<input type="hidden" name="datemula" id="datemula" value="<? echo $new_tamat?>"/>
	<? 
	
	}
	
function validatepassword() {
	
	?>
		<form action="" method="post" >
		  <table width="100%" height="187" border="0" style="background-color:#FFF; z-index:99999999; color: #000; font-size: 18px;">
				<tr>
				<td height="35" colspan="4" align="center" background="images/blue-bar.png" class="Color-header"><b>Tukar Katalaluan</b></td>
				</tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td width="190"><b>&nbsp;</b>&nbsp;Katalaluan Semasa</td>
				<td width="5"><strong>:</strong></td>
				<td width="196"><input name="password1" type="password" id="name" value="" size="30" onchange="validate_password()" /></td>
				<td width="33"><label for="textfield"><div id=validate></div></label></td>
			</tr>
			  <tr>
				<td><b>&nbsp;</b>&nbsp;Katalaluan Baru</td>
				<td><strong>:</strong></td>
				<td><input type="password" name="password2" id="password2" value="" size="30" onBlur="checkPwd(this)" disabled="disabled" /></td>
				<td><span id="respass1"></span></td>
			</tr>
			  <tr>
				<td><b>&nbsp;&nbsp;</b>Ulangi Katalaluan Baru</td>
				<td><strong>:</strong></td>
				<td><input type="password" name="password3" id="password3" value="" size="30" disabled="disabled" onKeyUp="validate_samepassword(this)" /></td>
				<td><span id="respass2"></span></td>
			</tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			  <tr bgcolor="#999999" align="right">
				<td colspan="4"><input type="submit" name="button" id="button" value="Submit" style="cursor:pointer;" onClick="updatepassword()" disabled class="button_style" />
				<input type="submit" name="button" id="button" value="Batal" style="cursor:pointer" onClick="tutup()" class="button_style"/></td>
			</tr>
		  </table> 
	
		</form>
	<?
}

function updateahli() {
	
	$id = $_GET["idupdate"];
 
	$sql = "SELECT * from ahli WHERE ahli_id = ".$id."";
	$result = mysql_query($sql);
	$rows = mysql_fetch_array($result);
	//exit();
?>

<form action="" method="post">
  <table width="100%" height="100%" border="0" style="background-color:#FFF; z-index:99999999; color: #000; font-size: 18px;">
    <tr>
    <td height="35" colspan="3" align="center" background="images/blue-bar.png" class="Color-header"><b>Kemaskini Ahli Parlimen/Adun/Majlis</b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="903">&nbsp;</td>
    </tr>
  <tr>
    <td width="311"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b>Nama Ahli</td>
    <td width="5"><strong>:</strong></td>
    <td><input name="name" type="text" id="namaAhli" value="<?=$rows['nama_ahli']?>" size="40" />      <label for="textfield"></label></td>
    </tr>
  <tr>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Efektif</td>
    <td width="5"><strong>:</strong></td>
    <?
    	if($rows['dateE']=="2999-01-01"){
			$dateTamat = "-";
		}else{
			$dateTamat = date("d-m-Y", strtotime($rows['dateE']));
		}
	?>
	<td><input accept="check" name="datemula" readonly="readonly" type="text" id="mula" onClick="javascript:NewCssCal('mula')" size="20" value="<?=date("d-m-Y", strtotime($rows['dateS']))?>" />&nbsp;&nbsp;&nbsp;hingga&nbsp;&nbsp;&nbsp;<input accept="check" name="datetamat" type="text" id="tamat" onClick="javascript:NewCssCal('tamat')" size="20"  value="<?=$dateTamat?>"/>
	</td>
  </tr>
  <tr>
	<td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td>&nbsp;</td>
	<td><br><font color="#FF0000">* Isikan (-) untuk set tarikh efektif sampai bila-bila </font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr bgcolor="#999999" align="right">
    <td colspan="3"><input type="submit" name="button" id="button" value="Submit" onclick="updateDataAhli(<?=$id?>)" class="button_style" />
	  <input type="button" name="button2" id="button2" value="Batal" onClick="tutup()" class="button_style"/></td>
    </tr>
</table> 

</form>


<?
}

function updateDataAhli(){
	
	$id = $_GET["idupdate"];
	$namaAhli = $_GET["namaAhli"]; 
	$dateMula = $_GET["dateMula"];
	$dateTamat = $_GET["dateTamat"];
	
	if($dateTamat=="-"){
		$dTamat = "2999-01-01";
	}else{
		$dTamat = date("Y-m-d", strtotime($dateTamat));
	}
	
	$sql = "update ahli set nama_ahli = '".$namaAhli."',dateS = '".date("Y-m-d", strtotime($dateMula))."',dateE = '".$dTamat."' ". 
	"where ahli_id = ".$id."";
	//echo $sql;
	$result = mysql_query($sql);
	
}	
function updateuser() {
 
	$sql = "SELECT * from user WHERE user_id = ".$_SESSION['id']."";
	$result = mysql_query($sql);
	$rows = mysql_fetch_array($result);
	//exit();
?>

<form action="" method="post">
  <table width="100%" height="100%" border="0" style="background-color:#FFF; z-index:99999999; color: #000; font-size: 18px;">
    <tr>
    <td height="35" colspan="3" align="center" background="images/blue-bar.png" class="Color-header"><b>Kemaskini Profil</b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="903">&nbsp;</td>
    </tr>
  <tr>
    <td width="311"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b>Nama</td>
    <td width="5"><strong>:</strong></td>
    <td><input name="name" type="text" id="name" value="<?=$rows['user_name']?>" size="40" />      <label for="textfield"></label></td>
    </tr>
  <tr>
    <td><b>&nbsp;&nbsp;&nbsp;&nbsp;</b>Email</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="email" id="email" value="<?=$rows['user_email']?>" size="40" onblur="verifyEmail()" /></td>
    </tr>
  <tr>
    <td><b>&nbsp;&nbsp;&nbsp;&nbsp;</b>No. Tel</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="notel" id="notel" value="<?=$rows['user_notel']?>" size="40" /></td>
    </tr>
  <tr>
    <td><b>&nbsp;&nbsp;&nbsp;&nbsp;</b>No. Hp</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="nobimbit" id="nobimbit" value="<?=$rows['user_nobimbit']?>" size="40" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr bgcolor="#999999" align="right">
    <td colspan="3"><input type="submit" name="button" id="button" value="Submit" onclick="jsupdateuser()" class="button_style" />
	  <input type="button" name="button2" id="button2" value="Batal" onClick="tutup()" class="button_style"/></td>
    </tr>
</table> 

</form>


<?
}
function jsupdate(){
	
	$name = $_GET["name"];
	$email = $_GET["email"];
	$notel = $_GET["notel"];
	$nobimbit = $_GET["nobimbit"];
	
	$sql = "update user set user_name = '".$_GET['name']."',user_email = '".$_GET['email']."',user_notel = '".$_GET['notel']."',user_nobimbit = '".$_GET['nobimbit']."' ". 
	"where user_id = ".$_SESSION['id']."";
	$result = mysql_query($sql);
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	}
		
	
function validate1(){
	
	$password1 = $_GET["password1"];
	
	$sql = "SELECT user_password from user WHERE user_id = ".$_SESSION['id']."";
	$result = mysql_query($sql);
	$rows = mysql_fetch_array($result);
	
	if ($password1 == $rows['user_password']){
		?><img src="images/right.png" width="25" height="25" />|~|1<?
	}
	if ($password1 != $rows['user_password']){
		
		?><img src="images/x.png" width="25" height="25" />|~|2<?
	}
}

function validate(){
	
	$password1 = $_GET["password1"];
	
	$sql = "SELECT user_password from user WHERE user_id = ".$_SESSION['id']."";
	$result = mysql_query($sql);
	$rows = mysql_fetch_array($result);
	
	if ($password1 == $rows['user_password']){
		$x=1;
		echo $x;
	}
	if ($password1 != $rows['user_password']){
		
		$x=2;
		echo $x;
	}
}

function updatepassword(){
	
	$password2 = $_GET["password2"];
	
	$sql = "update user set user_password = '".$_GET['password2']."' ".
	"where user_id = ".$_SESSION['id']."";
	$result = mysql_query($sql);
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	}

function sub_kepala(){
	
				$value = $_GET["value"];
				
				$perunding = $_GET["perunding"];
				
				if ($perunding == 1){
				
				$x = "Bidang";
				
				}
				if ($perunding == 0){
				
				$x = "Kepala";
				
				}

				$sqlsub = "Select * from kepala_sub where kepala_id =".$value."";
				$resultsub = mysql_query($sqlsub);
				//echo $sqlsub;
				?>
				<select accept="check" name="sub_bidang" id="sub_bidang" onchange="kod_bidang_2()">
				<option value="0">---Sila Pilih---</option>
				<? while($rowsub = mysql_fetch_array($resultsub)){?>
				<option value="<?=$rowsub['kepala_sub_id']?>|<?=$rowsub['kepala_sub_kod']?>"> <?=$rowsub['kepala_sub_kod']?> - <?=$rowsub['kepala_sub_desc']?></option>
				<?
				}
				
				?>
				
				</select>&nbsp;&nbsp;&nbsp;<a href="#" onclick="tambah_subbidang(<?= $value?>)" style="color:#00F ; text-decoration:underline" >Tambah Sub <?=$x?></a>
				<?
}
//athirah 21-03-2013 start 


function list_adun(){
	
	$value = $_GET["value"];
	
	if($value != 0){			
	$sqladun = "Select * from kawasan where layer=2 and parent_id =".$value."";
	$resultadun = mysql_query($sqladun);
	//echo $sqladun;
	?>
    <select name="adun" id="adun" onchange="list_majlis(this.value)">
		<option value="0">---Sila Pilih---</option>
		<? while($rowadun = mysql_fetch_array($resultadun)){?>
		<option value="<?=$rowadun['kwsn_id']?>"><?=$rowadun['kwsn_desc']?></option>
		<? } ?>
	</select>
	<?
	}else{
		
	}
}

function list_adun2(){
	$value = $_GET["value"];
	
	if($value != "NULL"){			
	$sqladun = "Select * from kawasan where layer=2 and parent_id =".$value."";
	$resultadun = mysql_query($sqladun);
	//echo $sqladun;
	?><select name="adun2" id="adun2" onchange="list_majlis2(this.value)">
				<option value="NULL">---Sila Pilih---</option>
				<? while($rowadun = mysql_fetch_array($resultadun)){?>
				<option value="<?=$rowadun['kwsn_id']?>"><?=$rowadun['kwsn_desc']?></option>
				<?
				}
				?>
				</select>
				<?
	}else{
		
	}
}

function list_majlis(){
	$value = $_GET["value"];
	if($value != 0){			
	$sqlmajlis = "Select * from kawasan where layer=3 and parent_id =".$value." order by kwsn_desc";
	$resultmajlis = mysql_query($sqlmajlis);
	//echo $sqlmajlis;
	?>
	<select name="majlis" id="majlis">
		<option value="NULL">---Sila Pilih---</option>
		<? while($rowmajlis = mysql_fetch_array($resultmajlis)){?>
		<option value="<?=$rowmajlis['kwsn_id']?>"><?=$rowmajlis['kwsn_desc']?></option>
		<? } ?>
	</select>
	<?
	}else{
		
	}
}
function list_majlis2(){
	$value = $_GET["value"];
	
	if($value != "NULL"){			
	$sqlmajlis = "Select * from kawasan where layer=3 and parent_id =".$value."";
	$resultmajlis = mysql_query($sqlmajlis);
	//echo $sqlmajlis;
	?>
				<select name="majlis" id="majlis">
					<option value="NULL">---Sila Pilih---</option>
					<? while($rowmajlis = mysql_fetch_array($resultmajlis)){?>
					<option value="<?=$rowmajlis['kwsn_id']?>"><?=$rowmajlis['kwsn_desc']?></option>
					<?
					}
					?>
				</select>
	<?
	}else{
		
	}
}
//athirah 21-03-2013 end
function sub_kepalaajax(){
	
				$value = $_GET["value"];
				
				$perunding = $_GET["perunding"];
				
				if ($perunding == 1){
				
				$x = "Bidang";
				
				}
				if ($perunding == 0){
				
				$x = "Kepala";
				
				}

				$sqlsub = "Select * from kepala_sub where kepala_id =".$value."";
				$resultsub = mysql_query($sqlsub);
				//echo $sqlsub;
				?>
				<select name="sub_bidang" id="sub_bidang" onchange="kod_bidang_2()">
				<option>---Sila Pilih---</option>
				<? while($rowsub = mysql_fetch_array($resultsub)){?>
				<option value="<?=$rowsub['kepala_sub_id']?>|<?=$rowsub['kepala_sub_kod']?>"> <?=$rowsub['kepala_sub_kod']?> - <?=$rowsub['kepala_sub_desc']?></option>
				<?
				}
				
				?>
				
				</select>
				<?
}


function display_bidang(){
	
			$perunding = $_GET["perunding"];
		
			$sqlsub = "Select * from kepala where perunding =".$perunding."";
			$resultsub = mysql_query($sqlsub);
			//echo $sqlsub;
			?>
			<select name="bidang_select" id="bidang_select" onchange="subbidang(this.value)">
			<option>---Sila Pilih---</option>
			<? while($rowsub = mysql_fetch_array($resultsub)){?>
			<option value="<?=$rowsub['kepala_id']?>|<?=$rowsub['kepala_kod']?>"> <?=$rowsub['kepala_kod']?> - <?=$rowsub['kepala_desc']?></option>
			<?
				}
					
			?>
			
			</select>&nbsp;&nbsp;&nbsp;<a href="#" onclick="tambah_bidang()" style=" color:#00F ; text-decoration:underline">Tambah Bidang</a>
			<?
}

function tambah_bidang(){
	
							$perunding = $_GET["perunding"];
							
							if ($perunding == 1){
							
							$x = "Bidang";
							
							}
							if ($perunding == 0){
							
							$x = "Kepala";
							
							}
	?>
                			<input name="perunding" type="hidden" id="perunding" value="<?= $perunding?>" size="40" />
							<table  width="100%" height="100%" border="0" >
                              <tr>
                                <td height="35" colspan="3" align="center" background="images/blue-bar.png" class="Color-header"><strong>Tambah <?=$x?></strong></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="64%" colspan="2">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="25%"><b>&nbsp;&nbsp;Kod</b></td>
                                <td colspan="2"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="kod" type="text" id="kod" onkeyup="checknumber(this),limitText(this,2,2)" size="40"   /></td>
                              </tr>
                              <tr>
                                <td><b>&nbsp;&nbsp;Bidang</b></td>
                                <td colspan="2"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="bidang" type="text" id="bidang" size="40" onkeyup="capitalize(this)"/> </td>
                              </tr>
                              <tr>
                                <td height="36" colspan="3">&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="3" align="right"><input type="submit" name="button4" id="button4" value="Simpan" onclick="save_bidang(),tutup()"/>
                                <input type="button" name="button3" id="button3" value="Batal" onclick="tutup()"/></td>
                              </tr>
                            </table>
                         
	<?
}

function tambah_subbidang(){
		
						$kepala = $_GET["kepala"];	
						
						$perunding = $_GET["perunding"];
							
							if ($perunding == 1){
							
							$x = "Bidang";
							
							}
							if ($perunding == 0){
							
							$x = "Kepala";
							
							}			
	?>	
    					<input name="kepala" type="hidden" id="kepala" value="<?= $kepala?>" size="40" />
							<table  width="100%" height="100%" border="0" >
                              <tr>
                                <td height="35" colspan="3" align="center" background="images/blue-bar.png" class="Color-header"><strong>Tambah Sub <?=$x?></strong></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="64%" colspan="2">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="25%"><b>&nbsp;&nbsp;Kod</b></td>
                                <td colspan="2"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="kod" type="text" id="kod" size="40" onkeyup="checknumber(this),limitText(this,2,2)"/></td>
                              </tr>
                              <tr>
                                <td><b>&nbsp;&nbsp;Sub Bidang</b></td>
                                <td colspan="2"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="bidang" type="text" id="bidang" size="40" onkeyup="capitalize(this)"/> </td>
                              </tr>
                              <tr>
                                <td height="36" colspan="3">&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="3" align="right"><input type="submit" name="button4" id="button4" value="Simpan" onclick="save_subbidang(),tutup()"/>
                                <input type="button" name="button3" id="button3" value="Batal" onclick="tutup()"/></td>
                              </tr>
                            </table>
                         
	<?
}

function save_bidang(){

		$sql="insert into kepala(kepala_kod,kepala_desc,perunding) values('".replace($_GET['kod'])."','".replace($_GET['bidang'])."',".replace($_GET['perunding']).")";		
		mysql_query($sql);
		
}

function save_subbidang(){

		$sql="insert into kepala_sub(kepala_id,kepala_sub_kod,kepala_sub_desc) values('".replace($_GET['kepala'])."','".replace($_GET['kod'])."','".replace($_GET['bidang'])."')";		
		mysql_query($sql);
		//echo $sql;
		
}

function bidangshow(){
		
		$perunding = $_GET['perunding'];
		
		if($perunding==0){
				$sql = "select * from contractor_class order by seq_no ";
				$result = mysql_query($sql);				
				
				?>
				<select accept="check" name="bidangprojek" id="bidangprojek" onchange="get_contractor1()">
    						      <option value="0">---Sila Pilih---</option>
    			</select>
				<?
			}
			
		if($perunding==1){	
		?>
		<div style="border:1px solid black;width:50%;height:210px;overflow:scroll;overflow-y:scroll;overflow-x:hidden;">
                                 		<table width="100%" border="0">
                                  			
                                               
                                    <?	$sql = "select * from kepala k ".
												"inner join kepala_sub ks on ks.kepala_id = k.kepala_id ".
												"inner join kepala_pecahan kp on kp.kepala_sub_id = ks.kepala_sub_id ".
												"where k.perunding = 1 ";
										$result = mysql_query($sql);
										
										
										
										while($row = mysql_fetch_array($result)){
													?>
                                                <tr> 
                                                	<td>
                                                	<input onclick="bidang_perunding()" type="checkbox" id="bidang_perunding[]" name="bidang_perunding[]" value="<?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?>"><?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?> - <?=$row['kepala_anak_desc']?></br>
                                                	</td>
                                                    <td>
                                                    </td>
                                                </tr>	
											<? 
											
											} 
											
											?>
                                           
										</table>				
                                  		</div>
                                        <?
			}
}

function bidangshow2(){
		
		$katkerja = $_GET['katkerja'];
		
				$sql = "select * from contractor_class where kategori_kerja = ".$katkerja." order by seq_no ";
				$result = mysql_query($sql);
				?><select accept="check" name="bidangprojek" id="bidangprojek" onchange="get_contractor1()">
    						      <option value="0">---Sila Pilih---</option><?
				while($row = mysql_fetch_array($result))
						{
					?>
						<option value="<?=$row['contractor_class_id']?>">
						<?=$row['class_desc']?>&nbsp;|&nbsp;<?=$row['had']?>
						</option>
					<? 
						}	
					?>
				
    			</select>
				<?
}
			
function jenis(){
	
		$perunding = $_GET['perunding'];
	
	?>			<select accept="check" name="jenis_projek" id="jenis_projek">
					<option value="0">---Sila Pilih---</option>
					<?
					$sql='select * from project_type where project_type_perunding ='.$perunding;
					$result = mysql_query($sql);
						while($row = mysql_fetch_array($result))
						{
					?>
						<option value="<?=$row['project_type_id'] ?>">
						<?=$row['project_type_desc']?>
						</option>
					<? 
						}	
					?>
				</select>
	
	<?
	}


function kontraktor_bidang(){
	
		$p_type = $_GET['p_type'];
		$classid = $_GET['bidangid'];
		$perunding = $_GET['perunding'];
		$kategori = $_GET['kategori'];
		
		if($p_type==0){
			$check = "";
		}
		else{
			$check = "check";
		}
		if($perunding == 0){
				if($kategori == 1){
					
					if($classid > 10){
						$konClass = "contractor_class_idNew";	
					}else{
						$konClass = "contractor_class_id";	
					}
					$sql = "select * from contractor c ".
							"inner join contractor_class cc on c.".$konClass." = cc.contractor_class_id ".
							"where perunding =".$perunding." and c.".$konClass." = ".$classid." and c.no_pkk <> ''".
							"order by contractor_name" ;
					//echo $sql.$classid;
					$result = mysql_query($sql);
		
					}
				if($kategori == 2 || $kategori == 3){
					
					$sql = "select * from contractor c ".
							//"inner join contractor_class cc on c.contractor_class_id = cc.contractor_class_id ".
							"where perunding =".$perunding." and c.contractor_class_id = ".$classid." and c.no_kkm <> ''".
							"order by contractor_name";
					//echo $sql."2";
					$result = mysql_query($sql);
					
					}
			}
		if($perunding == 1){
			
				$sql = "select * from contractor c ".
						"inner join bidang_perunding bp on c.contractor_id = bp.contractor_id ".
						"where perunding =".$perunding." and bp.bidang_id = ".$classid." ".
						"order by contractor_name";
				//echo $sql."3";
				$result = mysql_query($sql);			
			}
						
			?>
			<select accept="<?=$check?>" style="alignment-adjust:central" id="kontraktor" name="kontraktor" />
                <option value="0">---Sila Pilih---</option>
                <? 
                while ($row = mysql_fetch_array($result)){
                ?><option value="<?=$row['contractor_id']?>"><?=$row['contractor_name']?></option><?
                
				}
			?>
			</select>
			<?	
			
}

function kontraktor_bidang2(){
		
		$p_type = $_GET['p_type'];
		$classid = $_GET['bidangid'];
		$perunding = $_GET['perunding'];
		$kategori = $_GET['kategori'];
		
		if($p_type==0){
			$check = "";	
		}else{
			$check = "check";
		}
					
		$sql = "select * from contractor c ".
				"where perunding =".$perunding." and c.no_kkm <> '' ". 
				"order by contractor_name";
		//echo $sql."1";
		$result = mysql_query($sql);
		
						
			?>
			<select accept="<?=$check?>" style="alignment-adjust:central" id="kontraktor" name="kontraktor" />
                <option value="0">---Sila Pilih---</option>
                <? 
                while ($row = mysql_fetch_array($result)){
                ?><option value="<?=$row['contractor_id']?>"><?=$row['contractor_name']?></option><?
                
				}
			?>
			</select>
			<?	
			
}
//update admin
	
function adminupdate(){
//shah 20/6/13 start
if ($_SESSION['label'] == "Gred Pendaftaran Kontraktor" ){

		$idupdate = $_GET["idupdate"];
		
		$sql='select * from contractor_class where contractor_class_id ='.$idupdate;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
		<table width="100%" height="100%" border="0">
			<tr>
			<td height="35" colspan="5" background="images/blue-bar.png" align="center" class="Color-header"><strong>Kemaskini Gred Pendaftaran Kontraktor</strong></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td width="74%" colspan="4">&nbsp;</td>
			</tr>
			<tr>
			<td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;Nama Gred</td>
			<td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input accept="check" name="gred" type="text" id="gred" size="40" value="<?=$row['class_desc']?>" />
			</td>
			</tr>
			<tr>
			<td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;Had</td>
			<td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input accept="check" name="had" type="text" id="gred" size="40" value="<?=$row['had']?>"/>
			</td>
			</tr>
            <tr>
			<td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;Kategori Kontraktor</td>
			<td colspan="4">&nbsp;&nbsp;:&nbsp;&nbsp;
            					
                                <?
									$kategori = $row['kategori_kerja'];
									if($kategori==1){
										$kerja = "checked";
										$elektrik = "";
									}else{
										$kerja = "";
										$elektrik = "checked";	
									}
									
									$dateT = $row['CSdateE'];
									if($dateT == '2999-01-01') {
										$dateT = '-';
									}
									else {
										$dateT = date("d-m-Y", strtotime($dateT));
									}
								?>
                                  <label>
                                    <input accept="check" type="radio" name="RadioGroup1" <?=$kerja?> value="1" id="RadioGroup1_0" />
                                    Kerja</label>
                                  <label>
                                    <input accept="check" type="radio" name="RadioGroup1" <?=$elektrik?> value="2" id="RadioGroup1_1" />
                                    Elektrik</label>
			</td>
			</tr>
            <tr>
			<td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;  Tarikh Efektif</td>
			<td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input accept="check" name="datemula" readonly="readonly" type="text" id="mula" onClick="javascript:NewCssCal('mula')" size="20" value="<?=date("d-m-Y", strtotime($row['CSdateS']))?>" />&nbsp;&nbsp;&nbsp;hingga&nbsp;&nbsp;&nbsp;<input accept="check" name="datetamat" type="text" id="tamat" onClick="javascript:NewCssCal('tamat')" size="20"  value="<?=$dateT?>"/>
			</td>
			</tr>
            <tr>
			<td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td colspan="4"><br><font color="#FF0000">* Isikan (-) untuk set tarikh efektif sampai bila-bila </font>
			</td>
			</tr>
			<tr>
			<td height="36" colspan="5">&nbsp;</td>
			</tr>
			<tr bgcolor="#999999">
			<td colspan="5" align="right"><input type="submit" name="button" id="button" value="Simpan" onclick="updategredC()" class="button_style"/>        
			<input type="button" name="button2" id="button2" value="Batal" class="button_style" onClick="tutup()"/>        
			</td>
			</tr>
		</table><?
		}

//shah end/	
if ($_SESSION['label'] == "Jabatan/Bahagian/Unit" ){

		$idupdate = $_GET["idupdate"];
		
		$sql='select * from department where layer=1 order by department_id';
		$result = mysql_query($sql);
		?>
		<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
		<table width="100%" height="100%" border="0">
			<tr>
			<td height="35" colspan="5" background="images/blue-bar.png" align="center" class="Color-header"><strong>Kemaskini Jabatan/Bahagian/Unit</strong></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td width="74%" colspan="4">&nbsp;</td>
			</tr>
			<tr>
			<td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;Peringkat</td>
			<td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><select name="peringkat" id="peringkat" onchange="hidejabatan()">
			<option value="1">Jabatan/Unit</option>
			<option value="2">Bahagian</option>
			</select></td>
			</tr>
			<tr id="jabatan" style="display:none">
			<td >&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
			<td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><select name="bahagian" id="bahagian" >
				<option>---Sila Pilih---</option> 
			<?
			while($row = mysql_fetch_array($result))
			{
			?> 
				<option value="<?=$row['department_id'] ?>"><?=$row['department_desc']?></option> 
		
			<? } ?>							
			</select>
            </td>
			</tr>	<?
			$sql="select * from department where department_id = '".$idupdate."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
			?>
                <tr>	
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
                <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input type="text" name="nama" id="nama" size="40" value="<?=$row['department_desc']?>" /></td>
			<? }?>
			</tr>
			<tr>
			<td height="36" colspan="5">&nbsp;</td>
			</tr>
			<tr bgcolor="#999999">
			<td colspan="5" align="right"><input type="submit" name="button" id="button" value="Simpan" onclick="updatedept()" class="button_style"/>        
			<input type="button" name="button2" id="button2" value="Batal" class="button_style" onClick="tutup()"/>        
			</td>
			</tr>
		</table><?
		}
		
if ($_SESSION['label'] == "Kumpulan Pengguna" ){
		
	$idupdate = $_GET["idupdate"];
		
	$sql='select * from user_group where user_group_id = '.$idupdate.'';
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	?>
	<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
	<table  width="100%" height="100%" border="0" >
	<tr>
		<td height="35" colspan="3" align="center" background="images/blue-bar.png" class="Color-header"><strong>Kemaskini Kumpulan Pengguna</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="64%" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="25%">&nbsp;&nbsp;Kumpulan&nbsp;Pengguna</td>
		<td colspan="2"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="kumpengguna" type="text" id="kumpengguna" size="40" value="<?=$row['user_group_desc']?>" /></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Turutan</td>
		<td colspan="2"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="turutan" type="text" id="turutan" size="40" value="<?=$row['seq']?>" /></td>
	</tr>
	<?
    if($row['user_group_layer']=='3'){
		$semua = 'checked';
		$jabatan = '';
		$bahagian = '';
		$adun = '';
    }
    if($row['user_group_layer']=='1'){
		$jabatan = 'checked';
		$semua = '';
		$bahagian = '';
		$adun = '';
    }
    if($row['user_group_layer']=='2'){
		$bahagian = 'checked';
		$jabatan = '';
		$semua = '';
		$adun = '';
    }
    if($row['user_group_layer']=='4'){
		$bahagian = '';
		$jabatan = '';
		$semua = '';
		$adun = 'checked';
    }
    ?>
	<tr>
		<td valign="top">&nbsp;&nbsp;Level</td>
		<td colspan="2"><b>&nbsp;&nbsp;:</b>
		<label>
        <input type="radio" <?=$semua?> name="RadioGroup" value="3" id="RadioGroup_0" />
        Semua</label>
        <label>
        <input type="radio" <?=$jabatan?> name="RadioGroup" value="1" id="RadioGroup_1" />
        Jabatan</label>
        <label>
        <input type="radio" <?=$bahagian?> name="RadioGroup" value="2" id="RadioGroup_2" />
        Bahagian</label>
        <input type="radio" <?=$adun?> name="RadioGroup" value="4" id="RadioGroup_3" />
        Parlimen/Adun/Majlis</label>
        </td>
	</tr>
	<tr>
		<td valign="top">&nbsp;&nbsp;Modul</td>
		<td colspan="2"><b>&nbsp;&nbsp;:</b>
		<?
			function checkModule($module,$idupdate) {
				$sql = "select * from user_group_module where user_group_id =".$idupdate." and module_id=".$module;
				$resultugm = mysql_query($sql);
				$cntKod=0;
				$cntKod = mysql_num_rows($resultugm);
        		if ($cntKod!=0) {
        			return "checked";
				} else {
					return "";
				}
        	}
        
			$sql = "Select * from module";
			$result = mysql_query($sql);
			$cnt=0;
			while($row = mysql_fetch_array($result)){
        		$module = $row['id'];
        		$checkModule = checkModule($module,$idupdate);
        
        		$cnt++;
        	if ($cnt==1) { $space = ""; }
        	else { $space = "&nbsp;&nbsp;&nbsp;&nbsp;"; }
        	?>	
			<?=$space?><input type="checkbox" name="checkbox_module[]" <?=$checkModule?> value="<?=$row['id']?>" id="checkbox_module[]" />
            <?=$row['det']?>
            </label>
            </br>
            
        	<? }?>
        </p>
		</td>
	</tr>
	<tr>
		<td height="36" colspan="3">&nbsp;</td>
	</tr>
	<tr bgcolor="#999999">
		<td colspan="3" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" onclick="updateusergroup()"/>
		<input type="button" name="button3" id="button3" value="Batal" class="button_style" onclick="tutup()"/></td>
	</tr>
	</table>
<?
}		
if ($_SESSION['label'] == "Jawatan" ){

	$idupdate = $_GET["idupdate"];
	
	$sql='select * from jawatan where jawatan_id = '.$idupdate.'';
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	?>	<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
	<table width="100%" height="100%" border="0">
	<tr>
		<td height="35" colspan="6" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Jawatan</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td width="25%"><b>&nbsp;</b>&nbsp;&nbsp;&nbsp;Jawatan&nbsp;&nbsp;</td>
		<td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="jawatan" type="text" id="jawatan" value="<?=$row['jawatan_desc']?>" onclick="capitalize(this)" size="40" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td height="32" colspan="6">&nbsp;</td>
    </tr>
    <tr bgcolor="#999999">
		<td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" onclick="updatejawatan()"/>
		<input type="button" name="button5" id="button5" value="Batal" class="button_style" onclick="tutup()"/></td>
	</tr>
	</table>
<?
}	
if($_SESSION['label'] == "Gred" ){

	$idupdate = $_GET["idupdate"];

	$sql = "Select * from gred where gred_id = ".$idupdate;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	?>
	<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
    <table width="100%" height="100%" border="0">
    <tr>
		<td height="35" colspan="6" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Gred</strong></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td width="25%"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b>Gred</td>
        <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="gred" type="text" id="gred" value="<?=$row['gred_desc']?>" size="40" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
		<td height="32" colspan="6">&nbsp;</td>
	</tr>
	<tr bgcolor="#999999">
		<td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" onclick="updategred()"/>
		<input type="button" name="button5" id="button5" value="Batal" class="button_style" onclick="tutup()"/></td>
	</tr>
	</table>
<?	
}
if ($_SESSION['label'] == "Akaun Ahli Majlis" ){

	$idupdate = $_GET["idupdate"];
	
	$sqlu='select * from user where user_id = '.$idupdate.'';
	$resultu = mysql_query($sqlu);
	$rowu = mysql_fetch_array($resultu);
	
	?>
	<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
	<table width="100%" height="100%" border="0">
	<tr>
		<td height="35" colspan="5" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Akaun Pengguna</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="68%" colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td width="32%" class="bold" height="17px">&nbsp;&nbsp;&nbsp;&nbsp;ID Pengguna&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;<?=$rowu['user_login']?></b></td>
    </tr>
    <tr>
        <td height="17px">&nbsp;&nbsp;&nbsp;&nbsp;Nama&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;<?=$rowu['user_name']?></b></td>
    </tr>
    <tr>
        <td height="17px">&nbsp;&nbsp;&nbsp;&nbsp;Parlimen/Adun/Majlis&nbsp;&nbsp;</td>
        <?
        	$layerAhli = process_sql("select layer from kawasan k inner join ahli a on a.kawasan_id = k.kwsn_id where ahli_id = ".$rowu['ahli_majlis'],"layer");
			if($layerAhli==1){
				$layer = "PARLIMEN";
			}else if($layerAhli==2){
				$layer = "ADUN";	
			}else if($layerAhli==3){
				$layer = "MAJLIS";	
			}

		?>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;<?=$layer?>&nbsp;-&nbsp;<?=process_sql("select kwsn_desc from kawasan k inner join ahli a on k.kwsn_id = a.kawasan_id where ahli_id =".$rowu['ahli_majlis'],"kwsn_desc")?></b></td>
    </tr>
    <tr>
        <td height="17px">&nbsp;&nbsp;&nbsp;&nbsp;Tempoh Khidmat&nbsp;&nbsp;</td>
        <?
        	$dateS = process_sql("select dateS from kawasan k inner join ahli a on k.kwsn_id = a.kawasan_id where ahli_id =".$rowu['ahli_majlis'],"dateS");
			$dateE = process_sql("select dateE from kawasan k inner join ahli a on k.kwsn_id = a.kawasan_id where ahli_id =".$rowu['ahli_majlis'],"dateE");
			if($dateE=="2999-01-01"){
				$dateE = "Sekarang";
			}else{
				$dateE = date("d/m/y",strtotime($dateE));
			}
		?>
        <td colspan="4"><b><b>&nbsp;&nbsp;:&nbsp;&nbsp;<?=date("d/m/y",strtotime($dateS))?>&nbsp;hingga&nbsp;<?=$dateE?></b></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="email" type="text" id="email" size="40" value="<?=$rowu['user_email']?>" /></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Tel&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="notel" type="text" id="notel" size="40" value="<?=$rowu['user_notel']?>" /></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Tel Bimbit&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="notelbimbit" type="text" id="notelbimbit" size="40" value="<?=$rowu['user_nobimbit']?>" /></td>
    </tr>
    <tr>
        <td colspan="5" align="right">&nbsp;</td>
    </tr>
    <tr bgcolor="#999999">
		<td colspan="5" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" onclick="updateuserAdun()"/>
		<input type="button" name="button6" id="button6" value="Batal" class="button_style" onclick="tutup()"/></td>
	</tr>
	</table>
<? }
		
if ($_SESSION['label'] == "Akaun Pengguna" ){

	$idupdate = $_GET["idupdate"];

	$sqlu='select * from user where user_id = '.$idupdate.'';
	$resultu = mysql_query($sqlu);
	$rowu = mysql_fetch_array($resultu);
	
	?>
	<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
	<table width="100%" height="100%" border="0">
	<tr>
		<td height="35" colspan="5" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Akaun Pengguna</strong></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td width="68%" colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td width="32%" class="bold">&nbsp;&nbsp;&nbsp;&nbsp;ID Pengguna&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;<?=$rowu['user_login']?></b></td>
	</tr>
	<tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;Nama&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="nama" type="text" id="nama" size="40" value="<?=$rowu['user_name']?>" /></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;Jawatan&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><select name="jawatan" id="jawatan" >
		<option>---Sila Pilih---</option>
		<?
		$sql='select * from jawatan order by seq';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			if ($row['jawatan_id'] == $rowu['user_jawatan_id']){
				?>
				<option value="<?=$row['jawatan_id'] ?>" selected="selected"><?=$row['jawatan_desc']?></option> 
				<?						
			}
			else{?> 
				<option value="<?=$row['jawatan_id'] ?>"><?=$row['jawatan_desc']?></option> 
			<? 
			}
		}	
		?>
		</select>
		</td>
    </tr>
    <tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;Gred&nbsp;&nbsp;</td>
		<td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><select name="gred" id="gred" >
		<option value "0">---Sila Pilih---</option>
		<?			
		$sqlg='select * from gred order by gred_desc';
		$resultg = mysql_query($sqlg);
		while($rowg = mysql_fetch_array($resultg))
		{										
			if ($rowg['gred_id'] == $rowu['gred_id']){
				?>
	 			<option value="<?=$rowg['gred_id'] ?>" selected="selected"><?=$rowg['gred_desc']?></option>
				<?
			}		
			else {?>
	 			<option value="<?=$rowg['gred_id'] ?>"><?=$rowg['gred_desc']?></option>
				<? 
            }
		}	
		?>
		</select>
        </td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="email" type="text" id="email" size="40" value="<?=$rowu['user_email']?>" /></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Tel&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="notel" type="text" id="notel" size="40" value="<?=$rowu['user_notel']?>" /></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Tel Bimbit&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="notelbimbit" type="text" id="notelbimbit" size="40" value="<?=$rowu['user_nobimbit']?>" /></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;Kumpulan Pengguna&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><select name="kumpengguna" id="kumpengguna" >
        <option>---Sila Pilih---</option>
        <?
        $sql='select * from user_group order by seq';
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result))
        {
			if($row['user_group_id']==$rowu['user_group_id']){
				?>
                <option value="<?=$row['user_group_id'] ?>" selected="selected"><?=$row['user_group_desc']?></option> 
                <?
            }
            else{?> 
                <option value="<?=$row['user_group_id'] ?>"><?=$row['user_group_desc']?></option> 
                <? 
                }
		}	
		?>
		</select>
        </td>
    </tr>
    <tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;Jabatan&nbsp;&nbsp;</td>
		<td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><select name="jabatan" id="jabatan">
		<?
		$sql='select * from department where parent_id=0';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{	
			if($row['department_id']==$rowu['department_id']){
			?>
			<option value="<?=$row['department_id'] ?>" selected="selected"><?=$row['department_desc']?></option> 
			<?
			}else{
			?>
			<option value="<?=$row['department_id'] ?>"><?=$row['department_desc']?></option> 
			<?
			}
				$sql2="select * from department where parent_id=".$row['department_id'];
				$result2 = mysql_query($sql2);
				while($row2 = mysql_fetch_array($result2))
				{	
					if($row2['department_id']==$rowu['department_id']){
						?>
						<option value="<?=$row2['department_id'] ?>" selected="selected"><?=$row2['department_desc']?></option> 
						<?
					}
					else{
						?>
						<option value="<?=$row2['department_id'] ?>"> --- <?=$row2['department_desc']?></option> 
						<?
					}
				}
		
		}
		?>
		</select>
		</td>	 	
	</tr>
	<tr id="txtHintTR" style="display:none;">
        <td>&nbsp;&nbsp;&nbsp;&nbsp;Bahagian&nbsp;&nbsp;</td>
        <td colspan="4"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><span id="txtHint"></span><input type="hidden" name="bahagian" id="bahagian" /></td>
    </tr>
    <tr>
		<td colspan="5" align="right">&nbsp;</td>
	</tr>
	<tr bgcolor="#999999">
		<td colspan="5" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" onclick="updateuseradmin()"/>
		<input type="button" name="button6" id="button6" value="Batal" class="button_style" onclick="tutup()"/></td>
	</tr>
	</table>

<? }

if ($_SESSION['label'] == "Perunding" ){

	$idupdate = $_GET["idupdate"];

	$sql = "Select * from contractor where contractor_id = ".$idupdate;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	?>
	<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
	<table  width="100%" height="100%" border="0">
	<tr>
		<td height="35" colspan="6" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Maklumat Perunding</strong></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td width="28%"><label for="textfield5">&nbsp;&nbsp;&nbsp;&nbsp;Nama Perunding</label></td>
        <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="nama_kontraktor" type="text" id="nama_kontraktor" size="40" value="<?=$row['contractor_name']?>" onblur="capitalize(this)" /></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Pendaftaran</td>
        <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="no_pendaftaran" type="text" id="no_pendaftaran" size="40" value="<?=$row['contractor_regno']?>" /></td>
    </tr>
    <tr>
        <td><label for="textarea2">&nbsp;&nbsp;&nbsp;&nbsp;Alamat</label></td>
        <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><textarea name="alamat" id="alamat" cols="45" rows="5"><?=$row['contractor_address']?></textarea></td>
	</tr>
	<tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;Email</td>
        <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="email" type="text" id="email" size="40" value="<?=$row['contractor_email']?>" /></td>
	</tr>
	<tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon</td>
        <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="telefon" type="text" id="telefon" size="40" value="<?=$row['contractor_phone']?>" /></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon Pejabat</td>
		<td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="telefonpejabat" type="text" id="telefonpejabat" size="40" value="<?=$row['contractor_phonepejabat']?>" /></td>
	</tr>
	<tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Fax</td>
        <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="fax" type="fax" id="telefon4" size="40" value="<?=$row['contractor_fax']?>" /></td>
    </tr>
    <tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;Bumiputra</td>
		<td colspan="5">
		<? if($row["bumiputra"]==1){
				$x = "checked";
				$y = "";
        	}
        	if($row["bumiputra"]==0){
				$x = "";
				$y = "checked";
			}
        ?>
        <b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input type="radio" name="radio_bumiputra" id="radio_bumiputra" <?=$x?> value="1" />
        <label for="Ya2">Ya</label>
        <input type="radio" name="radio_bumiputra" id="radio_bumiputra" <?=$y?> value="0" />
        <label for="Tidak2">Tidak</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;No. KKM</td>
        <td colspan="5"> <b>&nbsp;&nbsp;:&nbsp;&nbsp;<input name="no_kkm" type="text" id="no_kkm" size="40" value="<?=$row['no_kkm']?>" /></b></td>
	</tr>
	<tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;Senarai Hitam</td>
        <td colspan="5">
		<?	if($row["contractor_status_id"]==1){
				$i = "checked";
				$j = "";
			}
			if($row["contractor_status_id"]==0){
				$i = "";
				$j = "checked";
			}
        ?>
        <b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input type="radio" name="radio_BList" id="radio_BList" <?=$i?> value="1" />
        <label for="Ya">Ya</label>
        <input type="radio" name="radio_BList" id="radio_BList" <?=$j?> value="0" />
        <label for="Tidak">Tidak</label>
        </td>  
    </tr>
    <tr>
		<td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;Bidang</td>
		<td colspan="5">
            <div style="border:1px solid black;width:300px;height:210px;overflow:scroll;overflow-y:scroll;overflow-x:hidden;">
            <table border="0" width="100%">
        
            <?	
            function checkDataKod($kod,$idupdate) 
            {
                $sql = "select * from bidang_perunding where contractor_id =".$idupdate." and bidang_id=".$kod;
                $resultbp = mysql_query($sql);
                $cntKod=0;
                $cntKod = mysql_num_rows($resultbp);
                if ($cntKod!=0) {
                    return "checked";
                } else {
                    return "";
                }
            }
            $sqlbidang = "select * from kepala k ".
            "inner join kepala_sub ks on ks.kepala_id = k.kepala_id ".
            "inner join kepala_pecahan kp on kp.kepala_sub_id = ks.kepala_sub_id ".
            "where k.perunding = 1";
            $resultbidang = mysql_query($sqlbidang);
        
            while($rowbidang = mysql_fetch_array($resultbidang)){
            $kod = $rowbidang['kod'];
            $checkDataKod = checkDataKod($kod,$idupdate);
            ?>
            <tr> 
                <td>
                <input type="checkbox" id="bidang[]" name="bidang[]" <?=$checkDataKod?> value="<?=$rowbidang['kod']?>"><?=$rowbidang['kod']?> - <?=$rowbidang['kepala_anak_desc']?></br>
                </td>
            </tr>	
            <?	 
            }
            ?>                                           
            </table>	
            </div>
		</td>
    </tr>
    <tr>
        <td valign="top">&nbsp;</td>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
    <td colspan="6" valign="top">
    <?
    $sqlpemilik = "select * from owner where contractor_id =".$idupdate;
    $resultpemilik = mysql_query($sqlpemilik);
    $i = 0;
    while($rowpemilik = mysql_fetch_array($resultpemilik)){
    $i++;
		?>	<div id="parentshow">
		<div id="show<?=$i?>">
    	<input type="button" name="button7" id="button7" value="Batal Pemilik" onclick="removepemilik(<?=$i?>)" />
        <table border="0" style="padding:2px; width:100%; border:#999999 1px solid">
        <tr>
	        <td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Maklumat Pemilik <?=$i;?></strong></td>
    	    <td width="62%">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Pemilik</td>
            <td><input name="pemilik<?=$i?>" type="text" id="pemilik<?=$i?>" size="40" value="<?=$rowpemilik['owner_name']?>" />
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Kad Pengenalan</td>
            <td><input name="no_ic<?=$i?>" type="text" id="kad penggenalan5" size="40" value="<?=$rowpemilik['no_ic']?>" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
		</tr>
		<tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Alamat</td>
            <td><textarea name="alamat<?=$i?>" id="alamat1" cols="45" rows="5"><?=$rowpemilik['address']?></textarea> </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon 1</td>
            <td><input name="telefon<?=$i?>" type="text" id="no tel"value="<?=$rowpemilik['no_tel']?>"  size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon 2</td>
            <td><input name="telefon2<?=$i?>" type="text" id="no tel2" size="40" value="<?=$rowpemilik['no_tel2']?>" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
		</tr>
        </table>
        </div>
        </div>
		<?
        }
        ?>
        <input type="hidden" name="counter" id="counter" value='<?=$i?>'/>
        <!--input type="text" name="counter_pemilik" id="counter_pemilik" value="< ?=$i?>"/-->
        
        <div id="dynamicInput"></div>
        <span>
        <input type="button" value="Tambah Pemilik" onClick="addInput('dynamicInput');">
        </span></p>                              
        </td>
	</tr>
	<tr>
        <td></td>
        <td width="492"></td>
        <td width="111"></td>
        <td width="103"></td>
        <td width="8"></td>
        <td width="104"></td>
	</tr>
	<tr>
        <td></td>
        <td colspan="5"></td>
	</tr>
	<tr bgcolor="#999999">
		<td colspan="6" align="right"><input type="submit" name="button9" id="button10" value="Simpan" class="button_style" onclick="updateperunding()" />                                    						
		<input type="button" name="button8" id="button12" value="Batal" class="button_style" onclick="tutup()" /></td>
	</tr>
	</table>
<?
}

	if ($_SESSION['label'] == "Kontraktor" ){
		
		$idupdate = $_GET["idupdate"];
		
		$sql = "Select * from contractor where contractor_id = ".$idupdate;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		?>
        <input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
		<table  width="130%" height="100%" border="0">
    						<tr>
      							<td height="36" colspan="6" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Maklumat Kontraktor</strong></td>
   							</tr>
    						<tr>
    						  <td>&nbsp;</td>
    						  <td colspan="5">&nbsp;</td>
  						   	</tr>
    						<tr>
      							<td width="975"><label for="textfield5">&nbsp;&nbsp;&nbsp;&nbsp;Nama Perunding</label></td>
      							<td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="nama_kontraktor" type="text" id="nama_kontraktor" size="40" value="<?=$row['contractor_name']?>" onblur="capitalize(this)" /></td>
   							</tr>
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;No. Pendaftaran</td>
      							<td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="no_pendaftaran" type="text" id="no_pendaftaran" size="40" value="<?=$row['contractor_regno']?>" /></td>
   							</tr>
    						<tr>
      							<td valign="top"><label for="textarea2">&nbsp;&nbsp;&nbsp;&nbsp;Alamat</label></td>
      							<td colspan="5" valign="top"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><textarea name="alamat" id="alamat" cols="45" rows="5"><?=$row['contractor_address']?></textarea></td>
   							</tr>
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;Email</td>
      							<td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="email" type="text" id="email" size="40" value="<?=$row['contractor_email']?>" onblur="verifyEmail()" /></td>
   							</tr>
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon</td>
      							<td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="telefon" type="text" id="telefon" size="40" value="<?=$row['contractor_phone']?>" /></td>
   							</tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon Pejabat</td>
    						  <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="telefonpejabat" type="text" id="telefonpejabat" size="40" value="<?=$row['contractor_phonepejabat']?>" /></td>
  						  	</tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Fax</td>
    						  <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="fax" type="fax" id="telefon4" size="40" value="<?=$row['contractor_fax']?>" /></td>
  						  	</tr>
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;Bumiputra</td>
                                 <td colspan="5">
                              		<? if($row["bumiputra"]==1){
											$x = "checked";
											$y = "";
										}
										if($row["bumiputra"]==0){
											$x = "";
											$y = "checked";
										}
										?>
                                     <b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input type="radio" name="radio_bumiputra" id="radio_bumiputra" <?=$x?> value="1" />
                                     <label for="Ya2">Ya</label>
                                     <input type="radio" name="radio_bumiputra" id="radio_bumiputra" <?=$y?> value="0" />
                                     <label for="Tidak2">Tidak</label>
                              </td>
          </tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;Perakuan&nbsp;Pendaftaran&nbsp;Kontraktor&nbsp;(PPK)</td>
    						  <td colspan="5">
							  		<? if($row["cidb"]==1){
											$x = "checked";
											$y = "";
										}
										if($row["cidb"]==0){
											$x = "";
											$y = "checked";
										}
									?>
                                <b>&nbsp;&nbsp;:&nbsp;</b>
                                <input type="radio" name="radio_cidb" id="radio_cidb" <?=$x?> value="1" />
                                <label for="Ya">Ya</label>
                                <input type="radio" name="radio_cidb" id="radio_cidb" <?=$y?> value="0" />
                              <label for="Tidak">Tidak</label></td>
  						  </tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;Sijil&nbsp;Perolehan&nbsp;Kerja&nbsp;Kerajaan&nbsp;(SPKK)</td>
    						  <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b>    						 
                              <input name="no_pkk" type="text" id="no_pkk" size="40" value="<?=$row['no_pkk']?>" /></td>
  						  </tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;Kelas (PKK)</td>
    						  <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b>
							<select name="kelas" id="kelas" >
	    						<option>---Sila Pilih---</option>
    						    <?
									
								$sqlclass="select * from contractor_class where CSdateE < '2012-10-15' order by seq_no";
								$resultclass = mysql_query($sqlclass);
					  				while($rowclass = mysql_fetch_array($resultclass))
									{
									if($rowclass['contractor_class_id']==$row['contractor_class_id']){
										?>
    						    <option value="<?=$rowclass['contractor_class_id'] ?>" selected="selected">
    						      <?=$rowclass['class_desc']?>
   						        </option>
    						    <?
										}
									else{?>
    						    <option value="<?=$rowclass['contractor_class_id'] ?>">
    						      <?= $rowclass['class_desc']?>
   						        </option>
    						    <? 
										}
									}	
									?>
  						    </select></td>
  						  </tr>
                          <tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;Gred (SPKK)</td>
    						  <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b>
							<select name="kelasNew" id="kelasNew" >
	    						<option>---Sila Pilih---</option>
    						    <?
									
								$sqlclassNew="select * from contractor_class where CSdateE > '2012-10-14' order by seq_no";
								$resultclassNew = mysql_query($sqlclassNew);
					  				while($rowclassNew = mysql_fetch_array($resultclassNew))
									{
									if($rowclassNew['kategori_kerja'] == 1){
										$kategori = "(Kerja)";	
									}else{
										$kategori = "Elektrik";	
									}
									if($rowclassNew['contractor_class_id']==$row['contractor_class_idNew']){
										?>
    						    		<option value="<?=$rowclassNew['contractor_class_id'] ?>" selected="selected">
    						      		<?=$rowclassNew['class_desc']?> - <?=$kategori?>
   						        		</option>
    						    		<?
										}
									else{?>
    						    		<option value="<?=$rowclassNew['contractor_class_id'] ?>">
    						      		<?= $rowclassNew['class_desc']?> - <?=$kategori?>
   						        		</option>
    						    		<? 
										}
									}	
									?>
  						    </select></td>
  						  </tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Rujukan Pendaftaran<br />
   						      &nbsp;&nbsp;&nbsp;&nbsp;Kementerian Kewangan Malaysia (KKM)</td>
    						  <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="no_kkm" type="fax" id="telefon6" size="40" value="<?=$row['no_kkm']?>" /></td>
  						  </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Berdaftar dengan unit Perancangan Ekonomi<br />
                                  &nbsp;&nbsp;&nbsp;&nbsp;Negeri Selangor (UPEN)</td>
                                  <td colspan="5"><? if($row["bumiputra"]==1){
											$x = "checked";
											$y = "";
										}
										if($row["bumiputra"]==0){
											$x = "";
											$y = "checked";
										}
										?>
                                    <b>&nbsp;&nbsp;:&nbsp;</b>
                                    <input type="radio" name="radio_upen" id="radio_upen" <?=$x?> value="1" />
                                    <label for="Ya">Ya</label>
                                    <input type="radio" name="radio_upen" id="radio_upen" <?=$y?> value="0" />
                                  <label for="Tidak">Tidak</label></td>
                                </tr>
                                <tr style="display:none;">
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Bon Perlaksanaan</td>
                                  <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;RM&nbsp;</b>
                                    <input name="bon_perlaksanaan" type="fax" id="telefon2" size="40" value="<?=number_format($row['bon_perlaksanaan'],2)?>" /></td>
                                </tr>
                                <tr style="display:none;">
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Kaedah </td>
                                  <td colspan="5"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b>
							<select name="kaedah" id="kaedah" >
        						<option>---Sila Pilih---</option>
                                    <?
								$sqlkaedah='select * from kaedah_bon';
								$resultkaedah = mysql_query($sqlkaedah);
					  			while($rowkaedah = mysql_fetch_array($resultkaedah))
								{
										if ($rowkaedah['kaedah_id'] == $row['kaedah'])
										{
											?>
                                    <option value="<?=$rowkaedah['kaedah_id'] ?>" selected="selected"> <?=$rowkaedah['kaedah_desc']?>
                                    </option>
                                    <?						
										}
										else
										{
										?>
                                    <option value="<?=$rowkaedah['kaedah_id'] ?>"><?=$rowkaedah['kaedah_desc']?>
                                    </option>
                                    <? 
										}
								}			
									?>
                                  </select></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Senarai Hitam</td>
                                  <td colspan="5">
                                  <?	if($row["contractor_status_id"]==1){
											$i = "checked";
											$j = "";
										}
										if($row["contractor_status_id"]==0){
											$i = "";
											$j = "checked";
										}
										?>
                                    <b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input type="radio" name="radio_BList" id="radio_BList" <?=$i?> value="1" />
                                    <label for="Ya">Ya</label>
                                    <input type="radio" name="radio_BList" id="radio_BList" <?=$j?> value="0" />
                                    <label for="Tidak">Tidak</label>
                                  </td>  
                                </tr>
                                <tr style="display:none;">
                                  <td colspan="6" valign="top"><div style="border:1px solid black;width:100%;">&nbsp;&nbsp;&nbsp;&nbsp;Insuran <br><br><br>
                                 <? $sqlinsuran = "Select * from insuran where contractor_id =".$idupdate;
								 	$resultinsuran = mysql_query($sqlinsuran);
									$j = 0;
									while($rowinsuran = mysql_fetch_array($resultinsuran))
									{
									$j++;	
								 ?>
                                	<div id="insuranshow<?=$j?>">
                                  <table width="100%" border="0" align="center">
                                  <tr>
                                  	<td width="6%" align="right"><?=$j ?>&nbsp;</td>
                                    <td width="34%"><input type="text" name="insuran<?=$j?>" id="insuran<?=$j?>" size="40" value="<?=$rowinsuran['insuran_name']?>" /></td>
                                    <td width="43%">&nbsp;RM
                                      <label for="textfield4"></label>
                                      <input type="text" name="nilai<?=$j?>" id="nilai<?=$j?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" value="<?=number_format($rowinsuran['nilai'],2)?>"/>
                                      <input type="button" name="button7" id="button7" value="Batal" onclick="removeinsuran(<?=$j?>)" /></td>
                                    </tr>
                                  </table>
                               	  	</div>
                                   
						        	<?
									}
									?>
                                  	<div id="tambah_insuran">
                               	    </div>
                                  <input type="button" name="Tambah" id="Tambah" value="Tambah Insuran" onclick="addinsuran('tambah_insuran')" />
                                  <input type="hidden" name="counter2" id="counter2" value="<?=$j?>" />                                  
                                  </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="6" valign="top"><div style="border:1px solid black;width:100%;"> 
                                    
                               	<?
                               		$sqlpemilik = "select * from owner where contractor_id =".$idupdate;
									$resultpemilik = mysql_query($sqlpemilik);
									$i = 0;
									while($rowpemilik = mysql_fetch_array($resultpemilik)){
										$i++;
								?>	
                                	<div id="show<?=$i?>">
                                     <input type="button" name="button7" id="button7" value="Batal Pemilik" onclick="removepemilik(<?=$i?>)" />
									<table border="0" style="padding:2px; width:100%; border:#999999 1px solid">
										<tr>
										  <td width="25%"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Maklumat Pemilik <?=$i;?></strong></td>
										  <td width="62%">&nbsp;</td>
									    </tr>
										<tr>
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;Pemilik</td>
										  <td>	<input name="pemilik<?=$i?>" type="text" id="pemilik<?=$i?>" size="40" value="<?=$rowpemilik['owner_name']?>" />
                                          		<input name="pemilik<?=$i?>" type="hidden" id="pemilik<?=$i?>" size="40" value="<?=$i?>" /> 
										  </td>
									    </tr>
										<tr>
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;Kad Pengenalan</td>
										  <td><input name="no_ic<?=$i?>" type="text" id="kad penggenalan5" size="40" value="<?=$rowpemilik['no_ic']?>" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
									    </tr>
										<tr>
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;Alamat</td>
										  <td><textarea name="alamat<?=$i?>" id="alamat1" cols="45" rows="5"><?=$rowpemilik['address']?></textarea> </td>
									    </tr>
										<tr>
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon 1</td>
										  <td><input name="telefon<?=$i?>" type="text" id="no tel"value="<?=$rowpemilik['no_tel']?>"  size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
									    </tr>
										<tr>
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon 2</td>
										  <td><input name="telefon2<?=$i?>" type="text" id="no tel2" size="40" value="<?=$rowpemilik['no_tel2']?>" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
									    </tr>
										<tr>
										  <td>&nbsp;</td>
										  <td>&nbsp;</td>
									  </tr>
									  </table>
                                    </div>
                                    
                                      
								<?
									}
							   	?>
                              <input type="hidden" name="counter" id="counter" value='<?=$i?>'/>
                                	<!--input type="text" name="counter_pemilik" id="counter_pemilik" value="< ?=$i?>"/-->
	
                              <div id="dynamicInput"></div>
                              <span>
                              <input type="button" value="Tambah Pemilik" onClick="addInput('dynamicInput');">
                              </span></p>                              
                              		</div>
                                  </td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td width="120"></td>
                                  <td width="158"></td>
                                  <td width="148"></td>
                                  <td width="24"></td>
                                  <td width="152"></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td colspan="5"></td>
                                </tr>
                                <tr bgcolor="#999999">
                                  <td colspan="6" align="right"><input type="submit" name="button9" id="button10" value="Simpan" class="button_style" onclick="updatekontraktor()" />                                    						
   								  <input type="button" name="button8" id="button12" value="Batal" class="button_style" onclick="tutup()" /></td>
                                </tr>
</table>
							  <?
	
		}
		
	
	if ($_SESSION['label'] == "Jenis Projek" ){
	
							$idupdate = $_GET["idupdate"];
							
							$sql = "Select * from project_type where project_type_id =".$idupdate;
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result);
							
							
														
		?>
			 				<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
            <table width="100%" height="100%" border="0">
                              <tr>
                                <td height="35" colspan="2" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Jenis Projek</strong></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;Jenis Projek</td>
                                <td width=""><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="jenis" type="text" id="jenis" size="40" value="<?=$row['project_type_desc']?>"/></td>
                              </tr>
                              <tr>
                                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Singkatan</td>
                                <td><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="short" type="text" id="short" size="40" value="<?=$row['project_type_short']?>" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="2" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" onclick="updatetype()"/>
                                  <input type="button" name="button4" id="button5" value="Batal" class="button_style" onclick="tutup()" />
                               	</td>
                              </tr>
</table>
		<?
	
		}
	
	if ($_SESSION['label'] == "Kategori Projek" ){
		
						$idupdate = $_GET["idupdate"];	
		
						$sql = "Select * from project_category where project_category_id =".$idupdate;
						$result = mysql_query($sql);
						$row = mysql_fetch_array($result);
		
		
		?>
		 					<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
                            <table width="100%" height="100%" border="0"  >
                              <tr>
                                <td height="35" colspan="2" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Kategori Projek</strong></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="25%"><strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Jenis Projek</td>
                                <td width=""><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b><input name="kategori" type="text" id="kategori" size="40" value="<?=$row['project_category_desc']?>" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Singkatan</td>
                                <td><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b>
                                  <input name="short" type="text" id="short" size="40" value="<?=$row['project_category_short']?>" /></td>
                              </tr>
                              <tr>
                                <td height="29">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="2" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" onclick="updatecategory()"/>
                                  <input type="button" name="button4" id="button5" value="Batal" class="button_style" onclick="tutup()" /></td>
                              </tr>
                            </table>
                       		
		<?
		}
	
	if ($_SESSION['label'] == "Bidang Perundingxx" )
	{
		$idupdate = $_GET["idupdate"];
		$sql="select * from kepala_pecahan kp ".
			"inner join kepala_sub ks on ks.kepala_sub_id = kp.kepala_sub_id ".
			"inner join kepala k on k.kepala_id = ks.kepala_id ".
			"where k.perunding = 1 and kepala_anak_id = ".$idupdate;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
	?>
		<table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid; color: #000;">
							  <tr>
							    <td height="35" colspan="3" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Bidang Perunding
						            <label for="textfield6"></label>
                                  <input type="hidden" name="idupdate" id="idupdate" value="<?=$idupdate?>" />
							      <input type="hidden" name="perunding" id="perunding" value="0" />
							      <input name="kod_1" id="kod_1" value="<?=$row['kepala_kod']?>" type="hidden" />
							      <input name="kod_2" id="kod_2" value="<?=$row['kepala_sub_kod']?>" type="hidden" />
							    </strong></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td colspan="2">&nbsp;</td>
	      </tr>
							  <tr>
							    <td width="26%">Kepala</td>
							    <td colspan="2"><div id="bidangdata">
							      <label for="Bidang"></label>
							      <?
                          $sqlsubbidang = "Select * from kepala where perunding = 1";
						  $resultsubbidang = mysql_query($sqlsubbidang);						  
						  ?>
							      <select name="bidangselect" id="bidangselect" onchange="subbidangajax(this.value)">
							        <option>---Sila Pilih---</option>
							        <? while( $rowsubbidang = mysql_fetch_array($resultsubbidang)){
											if($row['kepala_id']==$rowsubbidang['kepala_id']){?>
												<option value="<?=$rowsubbidang['kepala_id']?>|<?=$rowsubbidang['kepala_kod']?>" selected ><?=$rowsubbidang['kepala_kod']?> - <?=$rowsubbidang['kepala_desc']?>
						           				</option>
									<?		}	
											else{
												?>
                                                <option value="<?=$rowsubbidang['kepala_id']?>|<?=$rowsubbidang['kepala_kod']?>"><?=$rowsubbidang['kepala_kod']?> - <?=$rowsubbidang['kepala_desc']?>
                                                </option>
                                                <? 
											}
									}?>
						          </select>
							    </div></td>
						      </tr>
							  <tr>
							    <td>Sub Kepala</td>
							    <td colspan="2">
                                <div id="sub_kepala"><label for="Bidang"></label>
							      <?
                          $sqlkepalasub = "Select * from kepala_sub where kepala_id =".$row['kepala_id'];
						  $resultkepalasub = mysql_query($sqlkepalasub);						  
						  ?>
							      <select name="sub_bidang" id="sub_bidang">
							        <option>---Sila Pilih---</option>
							        <? while( $rowkepalasub = mysql_fetch_array($resultkepalasub)){
											if($row['kepala_sub_id']==$rowkepalasub['kepala_sub_id']){
												?>
                                                <option value="<?=$rowkepalasub['kepala_sub_id']?>" selected ><?=$rowkepalasub['kepala_sub_kod']?> - <?=$rowkepalasub['kepala_sub_desc']?>
						            			</option>
												<?		
											}
											else{
												?>
							        			<option value="<?=$rowkepalasub['kepala_sub_id']?>"><?=$rowkepalasub['kepala_sub_kod']?> - <?=$rowkepalasub['kepala_sub_desc']?>
						            			</option>
							        	<? } 
										}?>
						          </select></div></td>
						      </tr>
							  <tr>
							    <td>Pecahan Sub Kepala <strong>:</strong></td>
							    <td><span id="pecahan_bidang2">Kod</span></td>
							    <td><label for="textfield6"></label>
							      <input type="text" name="kod" id="kod" size="40" value="<?=$row['kepala_anak_kod']?>" onkeyup="checknumber(this),limitText(this,2,2)"/></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>Nama Sub Kepala</td>
							    <td><input type="text" name="nama" id="nama" size="40" value="<?=$row['kepala_anak_desc']?>" onblur="first_uppercase(this)"/></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td width="19%">&nbsp;</td>
							    <td width="55%">&nbsp;</td>
						      </tr>
							  <tr bgcolor="#999999">
							    <td colspan="3" align="right"><input type="submit" name="button17" id="button20" value="Simpan" class="button_style" onclick="update_bidang()"/>
							      <input type="button" name="button17" id="button22" value="Batal" class="button_style" onclick="tutup()" /></td>
						      </tr>
</table>
	
		<?
		
	}
		if ($_SESSION['label'] == "Senarai Projek" ){
		
			$idupdate = $_GET["idupdate"];
				
			$sqlp = "select * from project where project_id = ".$idupdate;
			$resultp = mysql_query($sqlp);
			$rowp = mysql_fetch_array($resultp);
		
		?>
        <input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
		 <table width="200" border="0" cellpadding="2" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid">
                <tr>
                   <td height="35" colspan="7" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Projek Baru</strong></td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="7"><input name="year" value="<?=date("Y")?>" type="hidden" />
                  <input name="referen" value="0" type="hidden" />
                  <input name="bahagian" value="0" type="hidden" /></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Pendaftaran Projek </td>
                  <td colspan="3"><input type="text" name="tarikh" id="tarikh" value="<?=date("d-M-Y", strtotime($rowp['project_date'])) ?>" readonly="readonly"/></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Masuk Mesyuarat Tender/Sebutharga  </td>
                  <td colspan="3"><input style="cursor:pointer;" type="text" name="tarikhTS" id="tarikhTS" value="<?=date("d-M-Y", strtotime($rowp['tarikhMasukTS'])) ?>" readonly="readonly" onClick="javascript:NewCssCal('tarikhTS')" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;No Kontrak</td>
                  <td colspan="3"><input accept="check" type="text" name="no_kontrak" id="no_kontrak" value="<?=$rowp['seq_category']?>" size="5" onblur="capitalize(this)" />
                    <strong>&nbsp;* SH 
                    <input accept="check" type="text" name="no_kontrak2" id="no_kontrak2" value="<?=$rowp['seq']?>" size="5" />
                    * 10 
                    <input accept="check" type="text" name="no_kontrak3" id="no_kontrak3"  value="<?=$rowp['seq_year']?>" size="5"/>
                  * 2012</strong></td>
                  <td></td>
                </tr>
                	<?	//kontraktor
						$katKerja = process_sql("select kategori_kerja from contractor_class where contractor_class_id = ".$rowp['project_category_id'],"kategori_kerja");
                    	if ($rowp['perunding']==0){
							$x = "checked";
							$y = "";
							$label = "&nbsp;&nbsp;&nbsp;&nbsp;Kelas";
							$sqlquery = 'select * from contractor_class where kategori_kerja = '.$katKerja;
							$sqlidcom = 'bidang';
							$sqlid = 'contractor_class_id';
							$sqlname = 'class_desc';
							$display_kategori = '';
							$had = 'had';
							
						}
						//perunding
						if ($rowp['perunding']==1){
							$x = "";
							$y = "checked";
							$label = "&nbsp;&nbsp;&nbsp;&nbsp;Bidang";
							$sqlquery = 'select * from kepala_pecahan';
							$sqlidcom = 'bidang';
							$sqlid = 'kod';
							$sqlname = 'kepala_anak_desc';
							$display_kategori = 'none';
						
						}

					?>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Projek Untuk</td>
                  <td colspan="3"><input disabled="disabled" name="perunding" type="radio" <?=$x?> id="perunding" onclick="bidangshow(this),jenis(this)" value="0" />
                  <label for="Kontraktor">Kontraktor</label>
                    <input disabled="disabled" type="radio" <?=$y?> name="perunding" id="perunding" onclick="bidangshow(this),jenis(this)"  value="1"/>
                  <label for="Perunding">Perunding</label>
                  </td>
                  <td width="7%"></td>
                </tr>
                <tr style="display:<?=$display_kategori?>" >
                  <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;Kategori</td>
                  <td colspan="3">
                  	<select id="kategori" onchange="classcondition2(this)" disabled="disabled">
                    	<option value="0">---Sila Pilih---</option>
				  	<?
						
                    	$sqlkategori = "select * from project_category";
						$resultkategori = mysql_query($sqlkategori);
						while($rowkategori = mysql_fetch_array($resultkategori)){
							if($rowkategori['project_category_id']==$rowp['project_category_id']){
							?>
								<option selected="selected" value="<?=$rowkategori['project_category_id']?>"><?=$rowkategori['project_category_desc']?></option>
							<?	
							}
							else{
							?>
								<option value="<?=$rowkategori['project_category_id']?>"><?=$rowkategori['project_category_desc']?></option>
							<?		
							}
						}	
					?>
                   	</select>
                  </td>
                  <td></td>
                </tr>
                <?
                	if($rowp['project_category_id'] == 2 || $rowp['project_category_id'] == 3){
						$displaykerja = "none";
					}
				?>
                <tr id="hide" style="display:<?=$displaykerja?>">
                  <td colspan="3" ><span id="label_bidang"><?=$label?></span></td>
                  <td colspan="3"><div id="bidang">
                  
                  <?
				  	
                  	if ($rowp['perunding'] == 0){
				  ?>
                  <select id="bidangprojek">
                    	<option value="0">---Sila Pilih---</option>
				  	<?
                    	$sqlbidang = $sqlquery;
						$resultbidang = mysql_query($sqlbidang);
						while($rowbidang = mysql_fetch_array($resultbidang)){
						if ($rowp['perunding']==1){
									$test = $rowbidang[$sqlid].' - ';
								}
								else{
									$test = '';
								}
							if($rowbidang[$sqlid] == $rowp[$sqlidcom]){
							?>
								<option selected="selected" value="<?=$rowbidang[$sqlid]?>"><?=$test?><?=$rowbidang[$sqlname]?>&nbsp;|&nbsp <?=$rowbidang[$had]?></option>
							<?	
							}
							else{
							?>
								<option value="<?=$rowbidang[$sqlid]?>"><?=$test?><?=$rowbidang[$sqlname]?>&nbsp;|&nbsp <?=$rowbidang[$had]?></option>
							<?	
							}
						}	
					?>
                   	</select>
                 <?
					}
					
					if ($rowp['perunding']==1){
						
						?>
					<div style="border:1px solid black;width:50%;height:210px;overflow:scroll;overflow-y:scroll;overflow-x:hidden;">
                                 		<table width="100%" border="0">
                                  	<?		
											function checked($idupdate,$kod){
		
												$sql2 = "select * from bidang_projek where projek = ".$idupdate." and bidang = ".$kod;
												$result2 = mysql_query($sql2);
												$row2 = mysql_num_rows($result2);
												
												if($row2 == 1){
													return "checked";	
												}
												else{
													return "";
												}								
											}
                                            
                                               
                                    	$sql = "select * from kepala k ".
												"inner join kepala_sub ks on ks.kepala_id = k.kepala_id ".
												"inner join kepala_pecahan kp on kp.kepala_sub_id = ks.kepala_sub_id ".
												"where k.perunding = 1 ";
										$result = mysql_query($sql);
										while($row = mysql_fetch_array($result)){
		
												$kod = $row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod'];
                                                $checked = checked($idupdate,$kod);
													?>
                                                <tr> 
                                                	<td>
                                                	<input type="checkbox" <?=$checked?> id="bidang[]" name="bidang[]" value="<?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?>"><?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?> - <?=$row['kepala_anak_desc']?></br>

                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>	
											<? 
											
											} 
											
											?>
                                           
										</table>				
                                  		</div>	
					<?
                    }
				 	?></div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Jenis</td>
                  <td colspan="3"><div id="jenisAjax">
				  		<select id="jenis">
					<?
                    	$sqljenis = "select * from project_type where project_type_perunding = " .$rowp['perunding'];
						$resultjenis = mysql_query($sqljenis);
						while ($rowjenis = mysql_fetch_array($resultjenis)){
							if($rowjenis['project_type_id']==$rowp['project_type_id']){
							?>
								<option selected="selected" value="<?=$rowjenis["project_type_id"]?>"><?=$rowjenis["project_type_desc"]?></option>
							<?
							}
							else{
							?>
								<option value="<?=$rowjenis["project_type_id"]?>"><?=$rowjenis["project_type_desc"]?></option>
							<?	
							}			
						}
                    ?>
                    </div>
                    </select></td>
                  <td></td>
                </tr>               
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kontraktor</td>
                  <td colspan="3">
                   <select name="kontraktor" id="kontraktor">
                     <option value="0">---Sila Pilih---</option>
                  <?
                  	$sqldept = 'Select * from contractor order by contractor_name';
					$resultdept = mysql_query($sqldept);
					while($rowdept = mysql_fetch_array($resultdept)){
						if($rowdept['contractor_id'] == $rowp['contractor_id']){
						?>
							 <option selected="selected" value="<?=$rowdept['contractor_id']?>"><?=$rowdept['contractor_name']?></option>
						<?
						}
						else{
						?>
							 <option value="<?=$rowdept['contractor_id']?>"><?=$rowdept['contractor_name']?></option>
						<?
						}
					}
                  ?>
                   </select>
                    
                    
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
                  <td colspan="3"><select accept="check" name="jabatan" id="jabatan" >
                    <option value="0">---Sila Pilih--</option>
                    <?
									$sqldept='select * from department where parent_id=0';
									$resultdept = mysql_query($sqldept);
					  				while($rowdept = mysql_fetch_array($resultdept))
									{	
										if($rowdept['department_id'] == $rowp['department_id']){
											?>
												<option selected="selected" value="<?=$rowdept['department_id'] ?>"><?=$rowdept['department_desc']?></option>
											<?
										}
										else{
											?>
												<option value="<?=$rowdept['department_id'] ?>"><?=$rowdept['department_desc']?></option>
											<?
										}
										$sql2="select * from department where parent_id=".$rowdept['department_id'];
										$result2 = mysql_query($sql2);
										while($row2 = mysql_fetch_array($result2))
										{
											if($row2['department_id'] == $rowp['department_id']){
											?>
                                            	<option selected="selected" value="<?=$row2['department_id'] ?>"> --- <?=$row2['department_desc']?></option>
                                            <?
											}
											else{
											?>
                                            	<option value="<?=$row2['department_id'] ?>"> --- <?=$row2['department_desc']?></option>
                                            <?	
											}
										}
									}
									
									?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Nama Projek</td>
                  <td colspan="3"><label for="nama projek2"></label>
                    <textarea accept="check" name="nama_projek" id="nama projek" cols="45" rows="5"><?=$rowp['project_name']?></textarea></td>
                  <td></td>
                </tr>
                <?
                	if($rowp["kwsn_id_m"]==""){
						$adunTr = "none";
					}else{
						$adunTr = "";	
					}
					
					if($rowp["kwsn_id_a"]==""){
						$majlisTr = "none";
					}else{
						$majlisTr = "";	
					}
					
					if($rowp["semuazon"]==1){
						$parlimen = "disabled";
						$majlis = "disabled";
						$adun = "disabled";
						$checksemuazon = "checked";
					}else{
						$parlimen = "";
						$majlis = "";
						$adun = "";
						$checksemuazon = "";	
					}
				?>
           <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kawasan</td>
                  <td colspan="3">
                      <table width="100%">
                            <tr>
                                <td width="10%">Parlimen</td>
                                <td width="1%"> : </td>
                                <td>
                                
                                  <?
                                  $sql = "Select * from kawasan where layer = 1";
                                  $result = mysql_query($sql);						  
                                  ?>
                                  <select name="parlimen" id="parlimen" <?=$parlimen?> onchange="list_adun(this.value)">
                                    <option value="0">---TIADA---</option>
                                    <? while( $row = mysql_fetch_array($result)){
											if($row['kwsn_id']==$rowp['kwsn_id_p'])
                                            	$selected='selected="selected"';
                                            else
                                                $selected='';?>
                                    <option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
                                    <? }?>
                                  </select>
                                   &nbsp;&nbsp;<input type="checkbox" name="semuazon" id="semuazon" value="1" <?=$checksemuazon?>  onclick="zonSemua()" /> Semua Zon
                                 </td>
                            </tr>
                         </table>
                  </td>
                  <td></td>
                </tr>
                <tr id="adunTr" style="display:<?=$adunTr?>">
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">
                      <table width="100%">
                                <tr>
                                    <td width="10%">Adun</td>
                                    <td width="1%"> : </td>
                                    <td>
                                      <div id="adunAjax">
									  <?
                                      $sql_adun = "Select * from kawasan where layer = 2 and parent_id=".$rowp['kwsn_id_p'];
                                      $result = mysql_query($sql_adun);
									  $row_number=mysql_num_rows($result);
									  if($row_number!=0)
									  {						  
										  ?>
										  <select name="adun" id="adun" <?=$adun?> onchange="list_majlis(this.value)">
										  <option value="NULL">---Sila Pilih---</option>
											<? while( $row = mysql_fetch_array($result)){
													if($row['kwsn_id']==$rowp['kwsn_id_a'])
														$selected='selected="selected"';
													else
														$selected='';
											?>
											<option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
											<? }?>
										 </select></div>
                                      <? 
                                      }
                                      else {}
									  ?>
                                     </td>
                            </tr>
                         </table>
                  <td></td>
                </tr>
           <tr id="majlisTr" style="display:<?=$majlisTr?>">
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">
                      <table width="100%">
                                <tr>
                                    <td width="10%">Majlis</td>
                                    <td width="1%"> : </td>
                                    <td>
                                      <div id="majlisAjax">
									  <?
                                      $sql_adun = "Select * from kawasan where layer = 3 and parent_id=".$rowp['kwsn_id_a'];
                                      $result = mysql_query($sql_adun);						  
                                      ?>
                                      <select name="majlis" id="majlis" <?=$majlis?>>
                                      <option value="NULL">---Sila Pilih---</option>
                                        <? while( $row = mysql_fetch_array($result)){
                                                if($row['kwsn_id']==$rowp['kwsn_id_m'])
                                                    $selected='selected="selected"';
                                                else
                                                    $selected='';
                                        ?>
                                        <option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
                                        <? }?>
                                     </select></div></td>
                            </tr>
                         </table>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Mula</td>
                  <td width="29%"><input accept="check" type="text" name="datemula" id="mula" readonly="readonly" value="<?=date("d-m-Y", strtotime($rowp['date_start']))?>" onClick="javascript:NewCssCal('mula')" style="cursor:pointer"/>
                    &nbsp;</td>
                  <td width="7%" align="right">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh&nbsp;Siap</td>
                  <td width="28%"><input accept="check" type="text" name="datetamat" id="tamat"  readonly="readonly" value="<?=date("d-m-Y", strtotime($rowp['date_end']))?>" onClick="javascript:NewCssCal('tamat')" style="cursor:pointer" />
                    &nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tempoh Siap</td>
                  <td colspan="3">
                 <?
                  	if (strpos($rowp['project_duration'],'Hari') == true) {
						$hari = "checked";
						$minggu = "";
						$bulan = "";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Minggu') == true) {
						$hari = "";
						$minggu = "checked";
						$bulan = "";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Bulan') == true) {
						$hari = "";
						$minggu = "";
						$bulan = "checked";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Tahun') == true) {
						$hari = "";
						$minggu = "";
						$bulan = "";
						$tahun = "checked";
					}
				  ?>
                  <input accept="check" type="radio" <?=$hari?>  name="radio1" id="radio" value="radio" onclick="datediffhari()" />
                  <label for="hari">Hari</label>
                  <input accept="check" type="radio" <?=$minggu?> name="radio1" id="radio2" value="radio2" onclick="datediffminggu()"/>
                  <label accept="check" for="minggu">Minggu</label>
                  <input accept="check" type="radio" <?=$bulan?> name="radio1" id="radio3" value="radio3" onclick="datediffbulan()"/>
                  <label for="bulan">Bulan</label>
                  <input accept="check" type="radio" <?=$tahun?> name="radio1" id="radio4" value="radio4" onclick="datedifftahun()"/>
                  <label for="tahun">Tahun</label>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td><span id="txtdatediff">
                    <input type="text" readonly="readonly" name="jangkamasa" id="jangkamasa" value="<?=$rowp['project_duration']?>" size="10"  />
                  </span></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No.&nbsp;Peruntukan</td>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td colspan="3"><input name="no_peruntukan" type="text" id="no_peruntukan" value="<?=$rowp['no_peruntukan']?>" size="40" /></td>
                  <td></td>
                </tr>
                <?
                	if($rowp['kadar_harga'] == 1){
						$checked = "checked";
						$disable = "disabled";
					}
					else{
						$checked = "";
						$disable = "";
					}
				?>
                <?
                	if($rowp['kesemua_bon'] == 1)
						$checkedbon = "checked";
					else
						$checkedbon = "";
				?>
                <?
                	if($rowp['kesemua_insuran'] == 1)
						$checkedins = "checked";
					else
						$checkedins = "";
				
				$KonPerTahun = "none";
				$KonPerSebenar = "none";	
				$KonAnggaran = "none";	
				$KonPerBulan = "none";
				if($rowp['project_category_id']==1){
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
				}elseif($rowp['project_category_id']==2){
					$KonPerTahun = "";
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
					$KonPerBulan = "";
				}elseif($rowp['project_category_id']==0){
					$KonPerTahun = "";
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
					$KonPerBulan = "";
				}elseif($rowp['project_category_id']==3){
					$KonPerBulan = "";
				}
				
				?>
                <tr id="KonPerSebenar" style="display:<?=$KonPerSebenar?>">
                  <td width="18%"><label for="kos">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Sebenar</label></td>
                  <td colspan="2" align="right">RM</td>
                  <td colspan="3"><span id="kosdisplay"><input <?=$disable?> name="kos" type="text" id="kos" size="40" value="<?=number_format($rowp['project_cost'],2)?>" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></span> <input <?=$checked ?> type="checkbox" value="1" name="checkbox_kos" id="checkbox_kos" onclick="kadar_harga()" />
                  Kadar Harga</td>
                  <td></td>
                </tr>
                 <tr style="display:<?=$KonAnggaran?>">
                  <td width="18%">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Anggaran</td>
                  <td colspan="2" align="right">RM</td>
                  <td colspan="3"><input name="kosA" type="text" id="kosA" size="40" value="<?=number_format($rowp['project_costA'],2)?>" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></span> </td>
                  <td></td>
                </tr>
                <tr style="display:<?=$KonPerBulan?>">
                  <td colspan="2"><label for="kos2">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Per&nbsp;Bulan</label></td>
                  <td width="3%" align="right">RM</td>
                  <td colspan="3">
                    <input name="kos2" type="text" id="kos2" size="40" value="<?=number_format($rowp['project_cost_month'],2)?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                  * Jika ada</td>
                  <td></td>
                </tr>
                <tr style="display:<?=$KonPerTahun?>">
                  <td colspan="2"><label for="kos3">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Per&nbsp;Tahun</label></td>
                  <td align="right">RM</td>
                  <td colspan="3">
                    <input name="kos3" type="text" id="kos3" size="40" value="<?=number_format($rowp['project_cost_year'],2)?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                    * Jika ada</td>
                  <td></td>
                </tr>
                <tr>
                   <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Bon Perlaksanaan</td>
                   <td align="right">RM</td>
                   <td colspan="3">
                   <input name="bon_perlaksanaan2" type="text" id="telefon2" size="40" value="<?=number_format($rowp['bon_perlaksanaan2'],2)?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                   <input <?=$checkedbon ?> type="checkbox" name="kesemua_bon" id="kesemua_bon" />
                  Kesemua</td>
                   </tr>
                
                <tr>
                    <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kaedah </td>
					<td colspan="3"><select name="kaedah" id="kaedah" >
        						<option>---Sila Pilih---</option>
                                    <?
								$sqlkaedah='select * from kaedah_bon';
								$resultkaedah = mysql_query($sqlkaedah);
					  			while($rowkaedah = mysql_fetch_array($resultkaedah))
								{
										if ($rowkaedah['kaedah_id'] == $rowp['kaedah'])
										{
											?>
                                    <option value="<?=$rowkaedah['kaedah_id'] ?>" selected="selected"> <?=$rowkaedah['kaedah_desc']?>
                                    </option>
                                    <?						
										}
										else
										{
										?>
                                    <option value="<?=$rowkaedah['kaedah_id'] ?>"><?=$rowkaedah['kaedah_desc']?>
                                    </option>
                                    <? 
										}
								}			
									?>
                                  </select></td>
                                  <td></td>
                                </tr>
                                
                              
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                
                 <tr>
                                  <td colspan="6" valign="top"><div style="border:1px solid black;width:100%;">&nbsp;&nbsp;&nbsp;&nbsp;Insuran <br><br><br>
                                 <? $sqlinsuran = "Select * from insuran where project_id =".$idupdate;
								 	$resultinsuran = mysql_query($sqlinsuran);
									$j = 0;
									while($rowinsuran = mysql_fetch_array($resultinsuran))
									{
									$j++;	
								 ?>
                                	<div id="insuranshow<?=$j?>">
                                  <table width="100%" border="0" align="center">
                                  <tr>
                                  	<td width="6%" align="right"><?=$j ?>&nbsp;</td>
                                    <td width="34%"><input type="text" name="insuran<?=$j?>" id="insuran<?=$j?>" size="40" value="<?=$rowinsuran['insuran_name']?>" /></td>
                                    <td width="43%">&nbsp;RM
                                      <label for="textfield4"></label>
                                      <input type="text" name="nilai<?=$j?>" id="nilai<?=$j?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" value="<?=number_format($rowinsuran['nilai'],2)?>"/>
                                      <input type="button" name="button7" id="button7" value="Batal" onclick="removeinsuran(<?=$j?>)" /></td>
                                    </tr>
                                  </table>
                               	  	</div>
                                    
						        	<?
									}
									?>
                                  	<div id="tambah_insuran">
                               	    </div>      
                                  <input <?=$checkedins ?> type="checkbox" name="kesemua_insuran" id="kesemua_insuran" />Kesemua
                                  <input type="button" name="Tambah" id="Tambah" value="Tambah Insuran" onclick="addinsuran('tambah_insuran')" />
                                  <input type="hidden" name="counter2" id="counter2" value="<?=$j?>" />  
                                  </div>
                                  </td>
                                </tr>
                     
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Pegawai Projek</td>
                  <td><select accept="check" name="p_projek" id="p_projek" onchange="email2(this), jawatan2(this)" >
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sql='select * from user order by user_name';
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result))
                        {
						if($rowp['pegawai_projek']==$row['user_id']){
                    		?>
                    		<option selected="selected" value="<?=$row['user_id'] ?>"><?=$row['user_name']?></option>
                    		<?
						}else{
							?>
							<option value="<?=$row['user_id'] ?>"><?=$row['user_name']?></option>
							<?	
						}
                    }	
                        ?>
                  </select></td>
                  <td align="right">Jawatan</td>
                  <td><div id="jawatanAjax">
                    <input type="text" accept="check" name="jawatan_pprojek" id="jawatan_pprojek" value="<?=$rowp['jawatan_pprojek']?>" size="40" readonly="readonly" />
                  </div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Email Pegawai Projek</td>
                  <td><label for="textfield7"></label>
                    <div id="emailAjax">
                      <input type="text" accept="check" name="email" id="email" size="40" value="<?=$rowp['email_pegawai']?>" readonly="readonly"/>
                  </div></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Penolong Pegawai Projek</td>
                  <td><input name="pen_projek" type="text" id="pen_projek" value="<?=$rowp['pen_pegawai_projek']?>" size="40" />
                    <!--<input name="bulan" id="bulan" type="hidden" onmouseover="" size="40" />
                  					<input name="tahun" id="tahun" type="hidden" onmouseover="" size="40" />--></td>
                  <td align="right">Jawatan</td>
                  <td><select name="jawatan_penprojek" id="jawatan_penprojek">
                     <option value="0">---Sila Pilih---</option>
                    <?
                    $sqljwtn2='select * from jawatan order by jawatan_desc';
                    $resultjwtn2 = mysql_query($sqljwtn2);
                    while($rowjwtn2 = mysql_fetch_array($resultjwtn2))
                    {
						if($rowjwtn2['jawatan_id'] == $rowp['jawatan_penprojek']){
						?>
							<option selected="selected" value="<?=$rowjwtn2['jawatan_id'] ?>"><?=$rowjwtn2['jawatan_desc']?></option>
						<? 
						}
						else{
						?>
							<option value="<?=$rowjwtn2['jawatan_id'] ?>"><?=$rowjwtn2['jawatan_desc']?></option>
						<?	
						}
					}	
                        ?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;PTBK/PTB/Juruteknik</td>
                  <td><input name="ptbk" type="text" id="ptbk" value="<?=$rowp['ptbk']?>" size="40"/></td>
                  <td align="right">Jawatan</td>
                  <td><select name="jawatan_ptbk" id="jawatan_ptbk">
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sqljwtn3='select * from jawatan order by jawatan_desc';
                    $resultjwtn3 = mysql_query($sqljwtn3);
                    while($rowjwtn3 = mysql_fetch_array($resultjwtn3))
                    {
						if($rowjwtn3['jawatan_id'] == $rowp['jawatan_ptbk']){
						?>
							<option selected="selected" value="<?=$rowjwtn3['jawatan_id'] ?>"><?=$rowjwtn3['jawatan_desc']?></option>
						<? 
						}
						else{
						?>
							<option value="<?=$rowjwtn3['jawatan_id'] ?>"><?=$rowjwtn3['jawatan_desc']?></option>
						<?	
						}
					}	
                        ?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                	<?
                    	$sqluser = "select * from user where user_id = " .$rowp["user_insert"];
						$resultuser = mysql_query($sqluser);
						$rowuser = mysql_fetch_array($resultuser);
						
						$sqluseru = "select * from user where user_id = " .$rowp["user_update"];
						$resultuseru = mysql_query($sqluseru);
						$rowuseru = mysql_fetch_array($resultuseru);
						
						if($rowuser["user_name"]==""){
							$daftar = "";	
						}else{
							$daftar = "Didaftarkan oleh " .$rowuser['user_name']. " pada " .date('d-M-Y H:i:s', strtotime($rowp['time_insert']))."<br>";
						}
						
						if($rowuseru["user_name"]==""){
							$kemaskini = "";	
						}else{
							$kemaskini = "Kemaskini terakhir oleh " .$rowuseru['user_name']. " pada " .date('d-M-Y H:i:s', strtotime($rowp['time_update']));	
						}
						
					?>
           <tr>
                       <td colspan="7" bgcolor="#F3F781" align="center">&nbsp;<?=$daftar ?><?=$kemaskini?></td>
           </tr>
                	
                <tr >
                  <td colspan="7" align="center"><div id="txtconvertdate"></div></td>
                </tr>
                <tr bgcolor="#999999" align="right">
                  <td colspan="7"><input type="submit" name="hantar" id="hantar" value="Simpan" onclick="update_project()" class="button_style" />
                  <input type="button" name="batal" id="batal" value="Batal" onclick="tutup()" class="button_style"/></td>
                </tr>
</table>	
			
	<?		
	}
	
	if ($_SESSION['label'] == "Bidang Perunding" )
	{
		$idupdate = $_GET["idupdate"];
		$sql="select * from kepala_pecahan kp ".
			"inner join kepala_sub ks on ks.kepala_sub_id = kp.kepala_sub_id ".
			"inner join kepala k on k.kepala_id = ks.kepala_id ".
			"where k.perunding = 1 and kepala_anak_id = ".$idupdate;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
	?>
		<table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid; color: #000;">
							  <tr>
							    <td height="35" colspan="3" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Bidang Perunding
						            <label for="textfield6"></label>
                                  <input type="hidden" name="idupdate" id="idupdate" value="<?=$idupdate?>" />
							      <input type="hidden" name="perunding" id="perunding" value="0" />
							      <input name="kod_1" id="kod_1" value="<?=$row['kepala_kod']?>" type="hidden" />
							      <input name="kod_2" id="kod_2" value="<?=$row['kepala_sub_kod']?>" type="hidden" />
							    </strong></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td colspan="2">&nbsp;</td>
	      </tr>
							  <tr>
							    <td width="26%">Kepala</td>
							    <td colspan="2"><div id="bidangdata">
							      <label for="Bidang"></label>
							      <?
                          $sqlsubbidang = "Select * from kepala where perunding = 1";
						  $resultsubbidang = mysql_query($sqlsubbidang);						  
						  ?>
							      <select name="bidangselect" id="bidangselect" onchange="subbidangajax(this.value)">
							        <option>---Sila Pilih---</option>
							        <? while( $rowsubbidang = mysql_fetch_array($resultsubbidang)){
											if($row['kepala_id']==$rowsubbidang['kepala_id']){?>
												<option value="<?=$rowsubbidang['kepala_id']?>|<?=$rowsubbidang['kepala_kod']?>" selected ><?=$rowsubbidang['kepala_kod']?> - <?=$rowsubbidang['kepala_desc']?>
						           				</option>
									<?		}	
											else{
												?>
                                                <option value="<?=$rowsubbidang['kepala_id']?>|<?=$rowsubbidang['kepala_kod']?>"><?=$rowsubbidang['kepala_kod']?> - <?=$rowsubbidang['kepala_desc']?>
                                                </option>
                                                <? 
											}
									}?>
						          </select>
							    </div></td>
						      </tr>
							  <tr>
							    <td>Sub Kepala</td>
							    <td colspan="2">
                                <div id="sub_kepala"><label for="Bidang"></label>
							      <?
                          $sqlkepalasub = "Select * from kepala_sub where kepala_id =".$row['kepala_id'];
						  $resultkepalasub = mysql_query($sqlkepalasub);						  
						  ?>
							      <select name="sub_bidang" id="sub_bidang">
							        <option>---Sila Pilih---</option>
							        <? while( $rowkepalasub = mysql_fetch_array($resultkepalasub)){
											if($row['kepala_sub_id']==$rowkepalasub['kepala_sub_id']){
												?>
                                                <option value="<?=$rowkepalasub['kepala_sub_id']?>" selected ><?=$rowkepalasub['kepala_sub_kod']?> - <?=$rowkepalasub['kepala_sub_desc']?>
						            			</option>
												<?		
											}
											else{
												?>
							        			<option value="<?=$rowkepalasub['kepala_sub_id']?>"><?=$rowkepalasub['kepala_sub_kod']?> - <?=$rowkepalasub['kepala_sub_desc']?>
						            			</option>
							        	<? } 
										}?>
						          </select></div></td>
						      </tr>
							  <tr>
							    <td>Pecahan Sub Kepala <strong>:</strong></td>
							    <td><span id="pecahan_bidang2">Kod</span></td>
							    <td><label for="textfield6"></label>
							      <input type="text" name="kod" id="kod" size="40" value="<?=$row['kepala_anak_kod']?>" onkeyup="checknumber(this),limitText(this,2,2)"/></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>Nama Sub Kepala</td>
							    <td><input type="text" name="nama" id="nama" size="40" value="<?=$row['kepala_anak_desc']?>" onblur="first_uppercase(this)"/></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td width="19%">&nbsp;</td>
							    <td width="55%">&nbsp;</td>
						      </tr>
							  <tr bgcolor="#999999">
							    <td colspan="3" align="right"><input type="submit" name="button17" id="button20" value="Simpan" class="button_style" onclick="update_bidang()"/>
							      <input type="button" name="button17" id="button22" value="Batal" class="button_style" onclick="tutup()" /></td>
						      </tr>
</table>


		<?
	}

//athirah 25-03-2013 start	
	if ($_SESSION['label'] == "Parlimen/Adun/Majlis" ){

		$idupdate = $_GET["idupdate"];
		
		$sql='select * from kawasan where layer=1 order by kwsn_id';
		$result = mysql_query($sql);
		
		$sql2="select * from kawasan where kwsn_id = '".$idupdate."'";
		$result2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($result2);
		
		//$sql_layer2="select * from kawasan where kwsn_id = '".$idupdate."'";
		//$result_layer2 = mysql_query($sql_layer2);
		//$row_layer2 = mysql_fetch_array($result_layer2);
		
		$sql_layer3="select *, k2.parent_id 'parentid', k2.parent_id 'parentid2' from kawasan k ".
					"inner join kawasan k2 on k.kwsn_id=k2.parent_id ".
					"inner join kawasan k3 on k2.kwsn_id=k3.parent_id ".
					"where k3.kwsn_id = '".$idupdate."'";

		$result_layer3 = mysql_query($sql_layer3);
		$row_layer3 = mysql_fetch_array($result_layer3);
			
		if($row2['layer']==1)
			$disp_parlimen='none';
		else
			$disp_parlimen='inline';
		
		if($row2['layer']==3)
			$disp_adun='inline';
		else
			$disp_adun='none';
		?>
		<input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
		<table width="100%" height="100%" border="0">
			<tr>
			<td height="35" colspan="5" background="images/blue-bar.png" align="center" class="Color-header"><strong>Kemaskini Parlimen/Adun/Majlis</strong></td>
			</tr>
			<tr>
                <td>&nbsp;</td>
                <td width="74%" colspan="4">&nbsp;</td>
			</tr>
			<tr>
                <td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;Peringkat</td>
                <td width="2%"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b></td>
                <td colspan="3">
					<?
                    $sql_peringkat = "Select * from kwsn_peringkat";
                    $result3 = mysql_query($sql_peringkat);	
                    ?>
                	<select name="layer" id="layer" onchange="hide_kwsn()">
                   	<? while( $row3 = mysql_fetch_array($result3)){
							if($row3['kp_ID']==$row2['layer'])
								$selected='selected="selected"';
							else
								$selected='';
					?>
                    	<option value="<?=$row3['kp_ID']?>" <?=$selected?> ><?=$row3['nama_peringkat']?></option>
                    <? }?>
                    </select></td>
            </tr>
			<tr id="parlimen" style="display:<?=$disp_parlimen?>">
                        <td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;Parlimen</td>
                        <td width="2%"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b></td>
                        <td colspan="3"><label for="parlimen2"></label>
                          <?
                          $sql = "Select * from kawasan where layer = 1";
						  $result = mysql_query($sql);		  
						  ?>
                          <select name="parlimen2" id="parlimen2" onchange="list_adun2(this.value)">
                            <? while( $row = mysql_fetch_array($result)){
									if($row2['layer']==2)	
										if($row['kwsn_id']==$row2['parent_id'])
											$selected='selected="selected"';
										else
											$selected='';
									else
										if($row['kwsn_id']==$row_layer3['parentid'])
											$selected='selected="selected"';
										else
											$selected='';
							
							?>
                            <option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
                            <? }?>
                        </select></td>
            </tr>
            <tr id="adun" style="display:<?=$disp_adun?>">
                        <td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;Adun</td>
                        <td width="2%"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b></td>
                        <td colspan="3"><div id="adunAjaxEdit">
                       <?
                        $sql_adun = "Select * from kawasan where layer = 2 and parent_id=".$row_layer3['parentid2'];
						//echo $sql_adun;
						$result = mysql_query($sql_adun);							  
						?>
						<select name="adun2" id="adun2">
						<? while( $row = mysql_fetch_array($result)){
								if($row['kwsn_id']==$row2['parent_id'])
									$selected='selected="selected"';
								else
									$selected='';
						?>
							<option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
							<? }?>
						</select></div></td>

            </tr>
			<tr>	
			<td>&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
            <td width="2%"><b>&nbsp;&nbsp;:&nbsp;&nbsp;</b></td>
			<td colspan="2"><input type="text" name="desc" id="desc" size="40" value="<?=$row2['kwsn_desc']?>" /></td>
            </tr>
            
			<tr bgcolor="#999999">
			<td colspan="5" align="right"><input type="submit" name="button" id="button" value="Simpan" onclick="update_kwsn()" class="button_style"/>        
			<input type="button" name="button2" id="button2" value="Batal" class="button_style" onClick="tutup()"/>        
			</td>
			</tr>
		</table><?
		}
		
}

function pro_dirancang(){
		
		$idupdate = $_GET["idupdate"];
				
			$sqlp = "select * from project_dirancang where project_id = ".$idupdate;
			$resultp = mysql_query($sqlp);
			$rowp = mysql_fetch_array($resultp);
			
		?>
        <input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
		 <table width="200" border="0" cellpadding="2" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid">
                <tr>
                   <td height="35" colspan="7" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Kemaskini Projek Dirancang</strong></td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="7"><input name="year" value="<?=date("Y")?>" type="hidden" />
                  <input name="referen" value="0" type="hidden" />
                  <input name="bahagian" value="0" type="hidden" /></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Pendaftaran Projek </td>
                  <td colspan="3"><input type="text" name="tarikh" id="tarikh" value="<?=date("d-M-Y", strtotime($rowp['project_date'])) ?>" readonly="readonly"/></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp; Anggaran Tarikh Masuk Mesyuarat Tender/Sebutharga  </td>
                  <td colspan="3"><input style="cursor:pointer;" type="text" name="tarikhDirancang" id="tarikhDirancang" value="<?=date("d-M-Y", strtotime($rowp['tarikhDirancangTS'])) ?>" readonly="readonly" onClick="javascript:NewCssCal('tarikhDirancang')"/></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp; Status Dokumen</td>
                  <td colspan="3">
                  					<?	$statDoc = $rowp['statDoc'];
										function checkSelected($obj,$statDoc){											
											if($statDoc == $obj){
												return "selected";
											}else{
												return "";
											}	
										}         	
									?>
                  					<select id="statDoc" name="statDoc">
                  						<option value="0" <?=checkSelected("0",$statDoc)?>>---Sila Pilih---</option>
                                        <option value="1" <?=checkSelected("1",$statDoc)?>>Penyediaan dokumen</option>
                                        <option value="2" <?=checkSelected("2",$statDoc)?>>Pelawaan</option>
                                        <option value="3" <?=checkSelected("3",$statDoc)?>>Penilaian</option>
                                        <option value="4" <?=checkSelected("4",$statDoc)?>>Pelantikan</option>
                                        <option value="5" <?=checkSelected("5",$statDoc)?>>Sedang Dijalankan</option>
                  					</select>
                  </td>
                  <td></td>
                </tr>
                	<?	//kontraktor
						$katKerja = process_sql("select kategori_kerja from contractor_class where contractor_class_id = ".$rowp['project_category_id'],"kategori_kerja");
                    	if ($rowp['perunding']==0){
							$x = "checked";
							$y = "";
							$label = "&nbsp;&nbsp;&nbsp;&nbsp;Kelas";
							$sqlquery = 'select * from contractor_class where kategori_kerja = '.$katKerja;
							$sqlidcom = 'bidang';
							$sqlid = 'contractor_class_id';
							$sqlname = 'class_desc';
							$display_kategori = '';
							$had = 'had';
							
						}
						//perunding
						if ($rowp['perunding']==1){
							$x = "";
							$y = "checked";
							$label = "&nbsp;&nbsp;&nbsp;&nbsp;Bidang";
							$sqlquery = 'select * from kepala_pecahan';
							$sqlidcom = 'bidang';
							$sqlid = 'kod';
							$sqlname = 'kepala_anak_desc';
							$display_kategori = 'none';
						
						}

					?>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Projek Untuk</td>
                  <td colspan="3"><input disabled="disabled" name="perunding" type="radio" <?=$x?> id="perunding" onclick="bidangshow(this),jenis(this)" value="0" />
                  <label for="Kontraktor">Kontraktor</label>
                    <input disabled="disabled" type="radio" <?=$y?> name="perunding" id="perunding" onclick="bidangshow(this),jenis(this)"  value="1"/>
                  <label for="Perunding">Perunding</label>
                  </td>
                  <td width="7%"></td>
                </tr>
                <tr style="display:<?=$display_kategori?>" >
                  <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;Kategori</td>
                  <td colspan="3">
                  	<select id="kategori" onchange="classcondition2(this)" disabled="disabled">
                    	<option value="0">---Sila Pilih---</option>
				  	<?
						
                    	$sqlkategori = "select * from project_category";
						$resultkategori = mysql_query($sqlkategori);
						while($rowkategori = mysql_fetch_array($resultkategori)){
							if($rowkategori['project_category_id']==$rowp['project_category_id']){
							?>
								<option selected="selected" value="<?=$rowkategori['project_category_id']?>"><?=$rowkategori['project_category_desc']?></option>
							<?	
							}
							else{
							?>
								<option value="<?=$rowkategori['project_category_id']?>"><?=$rowkategori['project_category_desc']?></option>
							<?		
							}
						}	
					?>
                   	</select>
                  </td>
                  <td></td>
                </tr>
                <?
                	if($rowp['project_category_id'] == 2 || $rowp['project_category_id'] == 3){
						$displaykerja = "none";
					}
				?>
                <tr id="hide" style="display:<?=$displaykerja?>">
                  <td colspan="3" ><span id="label_bidang"><?=$label?></span></td>
                  <td colspan="3"><div id="bidang">
                  
                  <?
				  	
                  	if ($rowp['perunding'] == 0){
				  ?>
                  <select id="bidangprojek">
                    	<option value="0">---Sila Pilih---</option>
				  	<?
                    	$sqlbidang = $sqlquery;
						$resultbidang = mysql_query($sqlbidang);
						while($rowbidang = mysql_fetch_array($resultbidang)){
						if ($rowp['perunding']==1){
									$test = $rowbidang[$sqlid].' - ';
								}
								else{
									$test = '';
								}
							if($rowbidang[$sqlid] == $rowp[$sqlidcom]){
							?>
								<option selected="selected" value="<?=$rowbidang[$sqlid]?>"><?=$test?><?=$rowbidang[$sqlname]?>&nbsp;|&nbsp <?=$rowbidang[$had]?></option>
							<?	
							}
							else{
							?>
								<option value="<?=$rowbidang[$sqlid]?>"><?=$test?><?=$rowbidang[$sqlname]?>&nbsp;|&nbsp <?=$rowbidang[$had]?></option>
							<?	
							}
						}	
					?>
                   	</select>
                 <?
					}
					
					if ($rowp['perunding']==1){
						
						?>
					<div style="border:1px solid black;width:50%;height:210px;overflow:scroll;overflow-y:scroll;overflow-x:hidden;">
                                 		<table width="100%" border="0">
                                  	<?		
											function checked($idupdate,$kod){
		
												$sql2 = "select * from bidang_projek where projek = ".$idupdate." and bidang = ".$kod;
												$result2 = mysql_query($sql2);
												$row2 = mysql_num_rows($result2);
												
												if($row2 == 1){
													return "checked";	
												}
												else{
													return "";
												}								
											}
                                            
                                               
                                    	$sql = "select * from kepala k ".
												"inner join kepala_sub ks on ks.kepala_id = k.kepala_id ".
												"inner join kepala_pecahan kp on kp.kepala_sub_id = ks.kepala_sub_id ".
												"where k.perunding = 1 ";
										$result = mysql_query($sql);
										while($row = mysql_fetch_array($result)){
		
												$kod = $row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod'];
                                                $checked = checked($idupdate,$kod);
													?>
                                                <tr> 
                                                	<td>
                                                	<input type="checkbox" <?=$checked?> id="bidang[]" name="bidang[]" value="<?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?>"><?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?> - <?=$row['kepala_anak_desc']?></br>

                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>	

											<? 
											
											} 
											
											?>
                                           
										</table>				
                                  		</div>	
					<?
                    }
				 	?></div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Jenis</td>
                  <td colspan="3"><div id="jenisAjax">
				  		<select id="jenis">
					<?
                    	$sqljenis = "select * from project_type where project_type_perunding = " .$rowp['perunding'];
						$resultjenis = mysql_query($sqljenis);
						while ($rowjenis = mysql_fetch_array($resultjenis)){
							if($rowjenis['project_type_id']==$rowp['project_type_id']){
							?>
								<option selected="selected" value="<?=$rowjenis["project_type_id"]?>"><?=$rowjenis["project_type_desc"]?></option>
							<?
							}
							else{
							?>
								<option value="<?=$rowjenis["project_type_id"]?>"><?=$rowjenis["project_type_desc"]?></option>
							<?	
							}			
						}
                    ?>
                    </div>
                    </select></td>
                  <td></td>
                </tr>               
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
                  <td colspan="3"><select accept="check" name="jabatan" id="jabatan" >
                    <option value="0">---Sila Pilih--</option>
                    <?
									$sqldept='select * from department where parent_id=0';
									$resultdept = mysql_query($sqldept);
					  				while($rowdept = mysql_fetch_array($resultdept))
									{	
										if($rowdept['department_id'] == $rowp['department_id']){
											?>
												<option selected="selected" value="<?=$rowdept['department_id'] ?>"><?=$rowdept['department_desc']?></option>
											<?
										}
										else{
											?>
												<option value="<?=$rowdept['department_id'] ?>"><?=$rowdept['department_desc']?></option>
											<?
										}
										$sql2="select * from department where parent_id=".$rowdept['department_id'];
										$result2 = mysql_query($sql2);
										while($row2 = mysql_fetch_array($result2))
										{
											if($row2['department_id'] == $rowp['department_id']){
											?>
                                            	<option selected="selected" value="<?=$row2['department_id'] ?>"> --- <?=$row2['department_desc']?></option>
                                            <?
											}
											else{
											?>
                                            	<option value="<?=$row2['department_id'] ?>"> --- <?=$row2['department_desc']?></option>
                                            <?	
											}
										}
									}
									
									?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Nama Projek</td>
                  <td colspan="3"><label for="nama projek2"></label>
                    <textarea accept="check" name="nama_projek" id="nama projek" cols="45" rows="5"><?=$rowp['project_name']?></textarea></td>
                  <td></td>
                </tr>
                <?
                	if($rowp["kwsn_id_m"]==""){
						$adunTr = "none";
					}else{
						$adunTr = "";	
					}
					
					if($rowp["kwsn_id_a"]==""){
						$majlisTr = "none";
					}else{
						$majlisTr = "";	
					}
					
					if($rowp["semuazon"]==1){
						$parlimen = "disabled";
						$majlis = "disabled";
						$adun = "disabled";
						$checksemuazon = "checked";
					}else{
						$parlimen = "";
						$majlis = "";
						$adun = "";
						$checksemuazon = "";	
					}
				?>
           <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kawasan</td>
                  <td colspan="3">
                      <table width="100%">
                            <tr>
                                <td width="10%">Parlimen</td>
                                <td width="1%"> : </td>
                                <td>
                                
                                  <?
                                  $sql = "Select * from kawasan where layer = 1";
                                  $result = mysql_query($sql);						  
                                  ?>
                                  <select name="parlimen" id="parlimen" <?=$parlimen?> onchange="list_adun(this.value)">
                                    <option value="0">---TIADA---</option>
                                    <? while( $row = mysql_fetch_array($result)){
											if($row['kwsn_id']==$rowp['kwsn_id_p'])
                                            	$selected='selected="selected"';
                                            else
                                                $selected='';?>
                                    <option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
                                    <? }?>
                                  </select>
                                   &nbsp;&nbsp;<input type="checkbox" name="semuazon" id="semuazon" value="1" <?=$checksemuazon?>  onclick="zonSemua()" /> Semua Zon
                                 </td>
                            </tr>
                         </table>
                  </td>
                  <td></td>
                </tr>
                <tr id="adunTr" style="display:<?=$adunTr?>">
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">
                      <table width="100%">
                                <tr>
                                    <td width="10%">Adun</td>
                                    <td width="1%"> : </td>
                                    <td>
                                      <div id="adunAjax">
									  <?
                                      $sql_adun = "Select * from kawasan where layer = 2 and parent_id=".$rowp['kwsn_id_p'];
                                      $result = mysql_query($sql_adun);
									  $row_number=mysql_num_rows($result);
									  if($row_number!=0)
									  {						  
										  ?>
										  <select name="adun" id="adun" <?=$adun?> onchange="list_majlis(this.value)">
										  <option value="NULL">---Sila Pilih---</option>
											<? while( $row = mysql_fetch_array($result)){
													if($row['kwsn_id']==$rowp['kwsn_id_a'])
														$selected='selected="selected"';
													else
														$selected='';
											?>
											<option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
											<? }?>
										 </select></div>
                                      <? 
                                      }
                                      else {}
									  ?>
                                     </td>
                            </tr>
                         </table>
                  <td></td>
                </tr>
           <tr id="majlisTr" style="display:<?=$majlisTr?>">
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">
                      <table width="100%">
                                <tr>
                                    <td width="10%">Majlis</td>
                                    <td width="1%"> : </td>
                                    <td>
                                      <div id="majlisAjax">
									  <?
                                      $sql_adun = "Select * from kawasan where layer = 3 and parent_id=".$rowp['kwsn_id_a'];
                                      $result = mysql_query($sql_adun);						  
                                      ?>
                                      <select name="majlis" id="majlis" <?=$majlis?>>
                                      <option value="NULL">---Sila Pilih---</option>
                                        <? while( $row = mysql_fetch_array($result)){
                                                if($row['kwsn_id']==$rowp['kwsn_id_m'])
                                                    $selected='selected="selected"';
                                                else
                                                    $selected='';
                                        ?>
                                        <option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
                                        <? }?>
                                     </select></div></td>
                            </tr>
                         </table>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Mula</td>
                  <td width="29%"><input accept="check" type="text" name="datemula" id="mula" readonly="readonly" value="<?=date("d-m-Y", strtotime($rowp['date_start']))?>" onClick="javascript:NewCssCal('mula')" style="cursor:pointer"/>
                    &nbsp;</td>
                  <td width="7%" align="right">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh&nbsp;Siap</td>
                  <td width="28%"><input accept="check" type="text" name="datetamat" id="tamat"  readonly="readonly" value="<?=date("d-m-Y", strtotime($rowp['date_end']))?>" onClick="javascript:NewCssCal('tamat')" style="cursor:pointer" />
                    &nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tempoh Siap</td>
                  <td colspan="3">
                 <?
                  	if (strpos($rowp['project_duration'],'Hari') == true) {
						$hari = "checked";
						$minggu = "";
						$bulan = "";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Minggu') == true) {
						$hari = "";
						$minggu = "checked";
						$bulan = "";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Bulan') == true) {
						$hari = "";
						$minggu = "";
						$bulan = "checked";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Tahun') == true) {
						$hari = "";
						$minggu = "";
						$bulan = "";
						$tahun = "checked";
					}
				  ?>
                  <input accept="check" type="radio" <?=$hari?>  name="radio1" id="radio" value="radio" onclick="datediffhari()" />
                  <label for="hari">Hari</label>
                  <input accept="check" type="radio" <?=$minggu?> name="radio1" id="radio2" value="radio2" onclick="datediffminggu()"/>
                  <label accept="check" for="minggu">Minggu</label>
                  <input accept="check" type="radio" <?=$bulan?> name="radio1" id="radio3" value="radio3" onclick="datediffbulan()"/>
                  <label for="bulan">Bulan</label>
                  <input accept="check" type="radio" <?=$tahun?> name="radio1" id="radio4" value="radio4" onclick="datedifftahun()"/>
                  <label for="tahun">Tahun</label>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td><span id="txtdatediff">
                    <input type="text" readonly="readonly" name="jangkamasa" id="jangkamasa" value="<?=$rowp['project_duration']?>" size="10"  />
                  </span></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No.&nbsp;Peruntukan</td>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td colspan="3"><input name="no_peruntukan" type="text" id="no_peruntukan" value="<?=$rowp['no_peruntukan']?>" size="40" /></td>
                  <td></td>
                </tr>
                <?
                	if($rowp['kadar_harga'] == 1){
						$checked = "checked";
						$disable = "disabled";
					}
					else{
						$checked = "";
						$disable = "";
					}
				?>
                <?
                	if($rowp['kesemua_bon'] == 1)
						$checkedbon = "checked";
					else
						$checkedbon = "";
				?>
                <?
                	if($rowp['kesemua_insuran'] == 1)
						$checkedins = "checked";
					else
						$checkedins = "";
				
				$KonPerTahun = "none";
				$KonPerSebenar = "none";	
				$KonAnggaran = "none";	
				$KonPerBulan = "none";
				if($rowp['project_category_id']==1){
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
				}elseif($rowp['project_category_id']==2){
					$KonPerTahun = "";
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
					$KonPerBulan = "";
				}elseif($rowp['project_category_id']==0){
					$KonPerTahun = "";
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
					$KonPerBulan = "";
				}elseif($rowp['project_category_id']==3){
					$KonPerBulan = "";
				}
				
				?>
                <tr id="KonPerSebenar" style="display:none;">
                  <td width="18%"><label for="kos">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Sebenar</label></td>
                  <td colspan="2" align="right">RM</td>
                  <td colspan="3"><span id="kosdisplay"><input <?=$disable?> name="kos" type="text" id="kos" size="40" value="<?=number_format($rowp['project_cost'],2)?>" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></span> <input <?=$checked ?> type="checkbox" value="1" name="checkbox_kos" id="checkbox_kos" onclick="kadar_harga()" />
                  Kadar Harga</td>
                  <td></td>
                </tr>
                 <tr style="display:<?=$KonAnggaran?>">
                  <td width="18%"><label for="kos">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Anggaran</label></td>
                  <td colspan="2" align="right">RM</td>
                  <td colspan="3"><input name="kosA" type="text" id="kosA" size="40" value="<?=number_format($rowp['project_costA'],2)?>" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></span> </td>
                  <td></td>
                </tr>
                <tr style="display:<?=$KonPerBulan?>">
                  <td colspan="2"><label for="kos2">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Per&nbsp;Bulan</label></td>
                  <td width="3%" align="right">RM</td>
                  <td colspan="3">
                    <input name="kos2" type="text" id="kos2" size="40" value="<?=number_format($rowp['project_cost_month'],2)?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                  * Jika ada</td>
                  <td></td>
                </tr>
                <tr style="display:<?=$KonPerTahun?>">
                  <td colspan="2"><label for="kos3">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Per&nbsp;Tahun</label></td>
                  <td align="right">RM</td>
                  <td colspan="3">
                    <input name="kos3" type="text" id="kos3" size="40" value="<?=number_format($rowp['project_cost_year'],2)?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                    * Jika ada</td>
                  <td></td>
                </tr>                  
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Pegawai Projek</td>
                  <td><select accept="check" name="p_projek" id="p_projek" onchange="email2(this), jawatan2(this)" >
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sql='select * from user order by user_name';
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result))
                        {
						if($rowp['pegawai_projek']==$row['user_id']){
                    		?>
                    		<option selected="selected" value="<?=$row['user_id'] ?>"><?=$row['user_name']?></option>
                    		<?
						}else{
							?>
							<option value="<?=$row['user_id'] ?>"><?=$row['user_name']?></option>
							<?	
						}
                    }	
                        ?>
                  </select></td>
                  <td align="right">Jawatan</td>
                  <td><div id="jawatanAjax">
                    <input type="text" accept="check" name="jawatan_pprojek" id="jawatan_pprojek" value="<?=$rowp['jawatan_pprojek']?>" size="40" readonly="readonly" />
                  </div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Email Pegawai Projek</td>
                  <td><label for="textfield7"></label>
                    <div id="emailAjax">
                      <input type="text" accept="check" name="email" id="email" size="40" value="<?=$rowp['email_pegawai']?>" readonly="readonly"/>
                  </div></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Penolong Pegawai Projek</td>
                  <td><input name="pen_projek" type="text" id="pen_projek" value="<?=$rowp['pen_pegawai_projek']?>" size="40" />
                    <!--<input name="bulan" id="bulan" type="hidden" onmouseover="" size="40" />
                  					<input name="tahun" id="tahun" type="hidden" onmouseover="" size="40" />--></td>
                  <td align="right">Jawatan</td>
                  <td><select name="jawatan_penprojek" id="jawatan_penprojek">
                     <option value="0">---Sila Pilih---</option>
                    <?
                    $sqljwtn2='select * from jawatan order by jawatan_desc';
                    $resultjwtn2 = mysql_query($sqljwtn2);
                    while($rowjwtn2 = mysql_fetch_array($resultjwtn2))
                    {
						if($rowjwtn2['jawatan_id'] == $rowp['jawatan_penprojek']){
						?>
							<option selected="selected" value="<?=$rowjwtn2['jawatan_id'] ?>"><?=$rowjwtn2['jawatan_desc']?></option>
						<? 
						}
						else{
						?>
							<option value="<?=$rowjwtn2['jawatan_id'] ?>"><?=$rowjwtn2['jawatan_desc']?></option>
						<?	
						}
					}	
                        ?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;PTBK/PTB/Juruteknik</td>
                  <td><input name="ptbk" type="text" id="ptbk" value="<?=$rowp['ptbk']?>" size="40"/></td>
                  <td align="right">Jawatan</td>
                  <td><select name="jawatan_ptbk" id="jawatan_ptbk">
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sqljwtn3='select * from jawatan order by jawatan_desc';
                    $resultjwtn3 = mysql_query($sqljwtn3);
                    while($rowjwtn3 = mysql_fetch_array($resultjwtn3))
                    {
						if($rowjwtn3['jawatan_id'] == $rowp['jawatan_ptbk']){
						?>
							<option selected="selected" value="<?=$rowjwtn3['jawatan_id'] ?>"><?=$rowjwtn3['jawatan_desc']?></option>
						<? 
						}
						else{
						?>
							<option value="<?=$rowjwtn3['jawatan_id'] ?>"><?=$rowjwtn3['jawatan_desc']?></option>
						<?	
						}
					}	
                        ?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                   <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Catatan</td>
                  <td colspan="3">
                    <textarea accept="check" name="catatan" id="catatan" cols="45" rows="5"><?=$rowp['catatan']?></textarea></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                	<?
                    	$sqluser = "select * from user where user_id = " .$rowp["user_insert"];
						$resultuser = mysql_query($sqluser);
						$rowuser = mysql_fetch_array($resultuser);
						
						$sqluseru = "select * from user where user_id = " .$rowp["user_update"];
						$resultuseru = mysql_query($sqluseru);
						$rowuseru = mysql_fetch_array($resultuseru);
						
						if($rowuser["user_name"]==""){
							$daftar = "";	
						}else{
							$daftar = "Didaftarkan oleh " .$rowuser['user_name']. " pada " .date('d-M-Y H:i:s', strtotime($rowp['time_insert']))."<br>";
						}
						
						if($rowuseru["user_name"]==""){
							$kemaskini = "";	
						}else{
							$kemaskini = "Kemaskini terakhir oleh " .$rowuseru['user_name']. " pada " .date('d-M-Y H:i:s', strtotime($rowp['time_update']));	
						}
						
					?>
           <tr>
                       <td colspan="7" bgcolor="#F3F781" align="center">&nbsp;<?=$daftar ?><?=$kemaskini?></td>
           </tr>
                	
                <tr >
                  <td colspan="7" align="center"><div id="txtconvertdate"></div></td>
                </tr>
                <tr bgcolor="#999999" align="right">
                  <td colspan="7"><input type="submit" name="hantar" id="hantar" value="Simpan" onclick="update_project_dirancang()" class="button_style" />
                  <input type="button" name="batal" id="batal" value="Batal" onclick="tutup()" class="button_style"/></td>
                </tr>
		</table>	
			
	<?		
	}
	
function pro_Import(){

			$idupdate = $_GET["idupdate"];
				
			$sqlp = "select * from project_dirancang where project_id = ".$idupdate;
			$resultp = mysql_query($sqlp);
			$rowp = mysql_fetch_array($resultp);
		
		?>
        <input name="idupdate" id="idupdate" value="<?=$idupdate?>" type="hidden" />
		 <table width="200" border="0" cellpadding="2" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid">
                <tr>
                   <td height="35" colspan="7" align="center" background="images/blue-bar.png" class="Color-Header"><strong>Daftar Projek Daripada Projek Dirancang</strong></td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="7"><input name="year" value="<?=date("Y")?>" type="hidden" />
                  <input name="referen" value="0" type="hidden" />
                  <input name="bahagian" value="0" type="hidden" /></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Pendaftaran Projek </td>
                  <td colspan="3"><input type="text" name="tarikh" id="tarikh" value="<?=date("d-M-Y", strtotime($rowp['project_date'])) ?>" readonly="readonly"/></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Masuk Mesyuarat Tender/Sebutharga  </td>
                  <td colspan="3"><input style="cursor:pointer;" type="text" name="tarikhTS" id="tarikhTS" value="" readonly="readonly" onClick="javascript:NewCssCal('tarikhTS')" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Lantikan Projek  </td>
                  <td colspan="3"><input style="cursor:pointer;" type="text" name="tarikhLantikan" id="tarikhLantikan" value="" readonly="readonly" onClick="javascript:NewCssCal('tarikhLantikan')" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;No Kontrak</td>
                  <td colspan="3"><input accept="check" type="text" name="no_kontrak" id="no_kontrak" value="<?=$rowp['seq_category']?>" size="5" onblur="capitalize(this)" />
                    <strong>&nbsp;* SH 
                    <input accept="check" type="text" name="no_kontrak2" id="no_kontrak2" value="<?=$rowp['seq']?>" size="5" />
                    * 10 
                    <input accept="check" type="text" name="no_kontrak3" id="no_kontrak3"  value="<?=$rowp['seq_year']?>" size="5"/>
                  * 2012</strong></td>
                  <td></td>
                </tr>
                	<?	//kontraktor
						$katKerja = process_sql("select kategori_kerja from contractor_class where contractor_class_id = ".$rowp['project_category_id'],"kategori_kerja");
                    	if ($rowp['perunding']==0){
							$x = "checked";
							$y = "";
							$label = "&nbsp;&nbsp;&nbsp;&nbsp;Kelas";
							$sqlquery = 'select * from contractor_class where kategori_kerja = '.$katKerja;
							$sqlidcom = 'bidang';
							$sqlid = 'contractor_class_id';
							$sqlname = 'class_desc';
							$display_kategori = '';
							$had = 'had';
							
						}
						//perunding
						if ($rowp['perunding']==1){
							$x = "";
							$y = "checked";
							$label = "&nbsp;&nbsp;&nbsp;&nbsp;Bidang";
							$sqlquery = 'select * from kepala_pecahan';
							$sqlidcom = 'bidang';
							$sqlid = 'kod';
							$sqlname = 'kepala_anak_desc';
							$display_kategori = 'none';
						
						}

					?>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Projek Untuk</td>
                  <td colspan="3"><input disabled="disabled" name="perunding" type="radio" <?=$x?> id="perunding" onclick="bidangshow(this),jenis(this)" value="0" />
                  <label for="Kontraktor">Kontraktor</label>
                    <input disabled="disabled" type="radio" <?=$y?> name="perunding" id="perunding" onclick="bidangshow(this),jenis(this)"  value="1"/>
                  <label for="Perunding">Perunding</label>
                  </td>
                  <td width="7%"></td>
                </tr>
                <tr style="display:<?=$display_kategori?>" >
                  <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;Kategori</td>
                  <td colspan="3">
                  	<select id="kategori" onchange="classcondition2(this)" disabled="disabled">
                    	<option value="0">---Sila Pilih---</option>
				  	<?
						
                    	$sqlkategori = "select * from project_category";
						$resultkategori = mysql_query($sqlkategori);
						while($rowkategori = mysql_fetch_array($resultkategori)){
							if($rowkategori['project_category_id']==$rowp['project_category_id']){
							?>
								<option selected="selected" value="<?=$rowkategori['project_category_id']?>"><?=$rowkategori['project_category_desc']?></option>
							<?	
							}
							else{
							?>
								<option value="<?=$rowkategori['project_category_id']?>"><?=$rowkategori['project_category_desc']?></option>
							<?		
							}
						}	
					?>
                   	</select>
                  </td>
                  <td></td>
                </tr>
                <?
                	if($rowp['project_category_id'] == 2 || $rowp['project_category_id'] == 3){
						$displaykerja = "none";
					}
				?>
                <tr id="hide" style="display:<?=$displaykerja?>">
                  <td colspan="3" ><span id="label_bidang"><?=$label?></span></td>
                  <td colspan="3"><div id="bidang">
                  
                  <?
				  	
                  	if ($rowp['perunding'] == 0){
				  ?>
                  <select id="bidangprojek">
                    	<option value="0">---Sila Pilih---</option>
				  	<?
                    	$sqlbidang = $sqlquery;
						$resultbidang = mysql_query($sqlbidang);
						while($rowbidang = mysql_fetch_array($resultbidang)){
						if ($rowp['perunding']==1){
									$test = $rowbidang[$sqlid].' - ';
								}
								else{
									$test = '';
								}
							if($rowbidang[$sqlid] == $rowp[$sqlidcom]){
							?>
								<option selected="selected" value="<?=$rowbidang[$sqlid]?>"><?=$test?><?=$rowbidang[$sqlname]?>&nbsp;|&nbsp <?=$rowbidang[$had]?></option>
							<?	
							}
							else{
							?>
								<option value="<?=$rowbidang[$sqlid]?>"><?=$test?><?=$rowbidang[$sqlname]?>&nbsp;|&nbsp <?=$rowbidang[$had]?></option>
							<?	
							}
						}	
					?>
                   	</select>
                 <?
					}
					
					if ($rowp['perunding']==1){
						
						?>
					<div style="border:1px solid black;width:50%;height:210px;overflow:scroll;overflow-y:scroll;overflow-x:hidden;">
                                 		<table width="100%" border="0">
                                  	<?		
											function checked($idupdate,$kod){
		
												$sql2 = "select * from bidang_projek where projek = ".$idupdate." and bidang = ".$kod;
												$result2 = mysql_query($sql2);
												$row2 = mysql_num_rows($result2);
												
												if($row2 == 1){
													return "checked";	
												}
												else{
													return "";
												}								
											}
                                            
                                               
                                    	$sql = "select * from kepala k ".
												"inner join kepala_sub ks on ks.kepala_id = k.kepala_id ".
												"inner join kepala_pecahan kp on kp.kepala_sub_id = ks.kepala_sub_id ".
												"where k.perunding = 1 ";
										$result = mysql_query($sql);
										while($row = mysql_fetch_array($result)){
		
												$kod = $row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod'];
                                                $checked = checked($idupdate,$kod);
													?>
                                                <tr> 
                                                	<td>
                                                	<input type="checkbox" <?=$checked?> id="bidang[]" name="bidang[]" value="<?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?>"><?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?> - <?=$row['kepala_anak_desc']?></br>

                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>	
											<? 
											
											} 

											
											?>
                                           
										</table>				
                                  		</div>	
					<?
                    }
				 	?></div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Jenis</td>
                  <td colspan="3"><div id="jenisAjax">
				  		<select id="jenis">
					<?
                    	$sqljenis = "select * from project_type where project_type_perunding = " .$rowp['perunding'];
						$resultjenis = mysql_query($sqljenis);
						while ($rowjenis = mysql_fetch_array($resultjenis)){
							if($rowjenis['project_type_id']==$rowp['project_type_id']){
							?>
								<option selected="selected" value="<?=$rowjenis["project_type_id"]?>"><?=$rowjenis["project_type_desc"]?></option>
							<?
							}
							else{
							?>
								<option value="<?=$rowjenis["project_type_id"]?>"><?=$rowjenis["project_type_desc"]?></option>
							<?	
							}			
						}
                    ?>
                    </div>
                    </select></td>
                  <td></td>
                </tr>               
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kontraktor</td>
                  <td colspan="3">
                   <select name="kontraktor" id="kontraktor">
                     <option value="0">---Sila Pilih---</option>
                  <?
                  	$sqldept = 'Select * from contractor order by contractor_name';
					$resultdept = mysql_query($sqldept);
					while($rowdept = mysql_fetch_array($resultdept)){
						if($rowdept['contractor_id'] == $rowp['contractor_id']){
						?>
							 <option selected="selected" value="<?=$rowdept['contractor_id']?>"><?=$rowdept['contractor_name']?></option>
						<?
						}
						else{
						?>
							 <option value="<?=$rowdept['contractor_id']?>"><?=$rowdept['contractor_name']?></option>
						<?
						}
					}
                  ?>
                   </select>            
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
                  <td colspan="3"><select accept="check" name="jabatan" id="jabatan" >
                    <option value="0">---Sila Pilih--</option>
                    <?
									$sqldept='select * from department where parent_id=0';
									$resultdept = mysql_query($sqldept);
					  				while($rowdept = mysql_fetch_array($resultdept))
									{	
										if($rowdept['department_id'] == $rowp['department_id']){
											?>
												<option selected="selected" value="<?=$rowdept['department_id'] ?>"><?=$rowdept['department_desc']?></option>
											<?
										}
										else{
											?>
												<option value="<?=$rowdept['department_id'] ?>"><?=$rowdept['department_desc']?></option>
											<?
										}
										$sql2="select * from department where parent_id=".$rowdept['department_id'];
										$result2 = mysql_query($sql2);
										while($row2 = mysql_fetch_array($result2))
										{
											if($row2['department_id'] == $rowp['department_id']){
											?>
                                            	<option selected="selected" value="<?=$row2['department_id'] ?>"> --- <?=$row2['department_desc']?></option>
                                            <?
											}
											else{
											?>
                                            	<option value="<?=$row2['department_id'] ?>"> --- <?=$row2['department_desc']?></option>
                                            <?	
											}
										}
									}
									
									?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Nama Projek</td>
                  <td colspan="3"><label for="nama projek2"></label>
                    <textarea accept="check" name="nama_projek" id="nama projek" cols="45" rows="5"><?=$rowp['project_name']?></textarea></td>
                  <td></td>
                </tr>
                <?
                	if($rowp["kwsn_id_m"]==""){
						$adunTr = "none";
					}else{
						$adunTr = "";	
					}
					
					if($rowp["kwsn_id_a"]==""){
						$majlisTr = "none";
					}else{
						$majlisTr = "";	
					}
					
					if($rowp["semuazon"]==1){
						$parlimen = "disabled";
						$majlis = "disabled";
						$adun = "disabled";
						$checksemuazon = "checked";
					}else{
						$parlimen = "";
						$majlis = "";
						$adun = "";
						$checksemuazon = "";	
					}
				?>
           <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kawasan</td>
                  <td colspan="3">
                      <table width="100%">
                            <tr>
                                <td width="10%">Parlimen</td>
                                <td width="1%"> : </td>
                                <td>
                                
                                  <?
                                  $sql = "Select * from kawasan where layer = 1";
                                  $result = mysql_query($sql);						  
                                  ?>
                                  <select name="parlimen" id="parlimen" <?=$parlimen?> onchange="list_adun(this.value)">
                                    <option value="0">---TIADA---</option>
                                    <? while( $row = mysql_fetch_array($result)){
											if($row['kwsn_id']==$rowp['kwsn_id_p'])
                                            	$selected='selected="selected"';
                                            else
                                                $selected='';?>
                                    <option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
                                    <? }?>
                                  </select>
                                   &nbsp;&nbsp;<input type="checkbox" name="semuazon" id="semuazon" value="1" <?=$checksemuazon?>  onclick="zonSemua()" /> Semua Zon
                                 </td>
                            </tr>
                         </table>
                  </td>
                  <td></td>
                </tr>
                <tr id="adunTr" style="display:<?=$adunTr?>">
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">
                      <table width="100%">
                                <tr>
                                    <td width="10%">Adun</td>
                                    <td width="1%"> : </td>
                                    <td>
                                      <div id="adunAjax">
									  <?
                                      $sql_adun = "Select * from kawasan where layer = 2 and parent_id=".$rowp['kwsn_id_p'];
                                      $result = mysql_query($sql_adun);
									  $row_number=mysql_num_rows($result);
									  if($row_number!=0)
									  {						  
										  ?>
										  <select name="adun" id="adun" <?=$adun?> onchange="list_majlis(this.value)">
										  <option value="NULL">---Sila Pilih---</option>
											<? while( $row = mysql_fetch_array($result)){
													if($row['kwsn_id']==$rowp['kwsn_id_a'])
														$selected='selected="selected"';
													else
														$selected='';
											?>
											<option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
											<? }?>
										 </select></div>
                                      <? 
                                      }
                                      else {}
									  ?>
                                     </td>
                            </tr>
                         </table>
                  <td></td>
                </tr>
           <tr id="majlisTr" style="display:<?=$majlisTr?>">
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">
                      <table width="100%">
                                <tr>
                                    <td width="10%">Majlis</td>
                                    <td width="1%"> : </td>
                                    <td>
                                      <div id="majlisAjax">
									  <?
                                      $sql_adun = "Select * from kawasan where layer = 3 and parent_id=".$rowp['kwsn_id_a'];
                                      $result = mysql_query($sql_adun);						  
                                      ?>
                                      <select name="majlis" id="majlis" <?=$majlis?>>
                                      <option value="NULL">---Sila Pilih---</option>
                                        <? while( $row = mysql_fetch_array($result)){
                                                if($row['kwsn_id']==$rowp['kwsn_id_m'])
                                                    $selected='selected="selected"';
                                                else
                                                    $selected='';
                                        ?>
                                        <option value="<?=$row['kwsn_id']?>" <?=$selected?> ><?=$row['kwsn_desc']?></option>
                                        <? }?>
                                     </select></div></td>
                            </tr>
                         </table>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Mula</td>
                  <td width="29%"><input accept="check" type="text" name="datemula" id="mula" readonly="readonly" value="<?=date("d-m-Y", strtotime($rowp['date_start']))?>" onClick="javascript:NewCssCal('mula')" style="cursor:pointer"/>
                    &nbsp;</td>
                  <td width="7%" align="right">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh&nbsp;Siap</td>
                  <td width="28%"><input accept="check" type="text" name="datetamat" id="tamat"  readonly="readonly" value="<?=date("d-m-Y", strtotime($rowp['date_end']))?>" onClick="javascript:NewCssCal('tamat')" style="cursor:pointer" />
                    &nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tempoh Siap</td>
                  <td colspan="3">
                 <?
                  	if (strpos($rowp['project_duration'],'Hari') == true) {
						$hari = "checked";
						$minggu = "";
						$bulan = "";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Minggu') == true) {
						$hari = "";
						$minggu = "checked";
						$bulan = "";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Bulan') == true) {
						$hari = "";
						$minggu = "";
						$bulan = "checked";
						$tahun = "";
					}elseif(strpos($rowp['project_duration'],'Tahun') == true) {
						$hari = "";
						$minggu = "";
						$bulan = "";
						$tahun = "checked";
					}
				  ?>
                  <input accept="check" type="radio" <?=$hari?>  name="radio1" id="radio" value="radio" onclick="datediffhari()" />
                  <label for="hari">Hari</label>
                  <input accept="check" type="radio" <?=$minggu?> name="radio1" id="radio2" value="radio2" onclick="datediffminggu()"/>
                  <label accept="check" for="minggu">Minggu</label>
                  <input accept="check" type="radio" <?=$bulan?> name="radio1" id="radio3" value="radio3" onclick="datediffbulan()"/>
                  <label for="bulan">Bulan</label>
                  <input accept="check" type="radio" <?=$tahun?> name="radio1" id="radio4" value="radio4" onclick="datedifftahun()"/>
                  <label for="tahun">Tahun</label>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td><span id="txtdatediff">
                    <input type="text" readonly="readonly" name="jangkamasa" id="jangkamasa" value="<?=$rowp['project_duration']?>" size="10"  />
                  </span></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No.&nbsp;Peruntukan</td>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td colspan="3"><input name="no_peruntukan" type="text" id="no_peruntukan" value="<?=$rowp['no_peruntukan']?>" size="40" /><font color="#FF0000">&nbsp;&nbsp;*&nbsp;30-01-04-00-95201</font></td>
                  <td></td>
                </tr>
                <?
                	if($rowp['kadar_harga'] == 1){
						$checked = "checked";
						$disable = "disabled";
					}
					else{
						$checked = "";
						$disable = "";
					}
				?>
                <?
                	if($rowp['kesemua_bon'] == 1)
						$checkedbon = "checked";
					else
						$checkedbon = "";
				?>
                <?
                	if($rowp['kesemua_insuran'] == 1)
						$checkedins = "checked";
					else
						$checkedins = "";
				
				$KonPerTahun = "none";
				$KonPerSebenar = "none";	
				$KonAnggaran = "none";	
				$KonPerBulan = "none";
				if($rowp['project_category_id']==1){
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
				}elseif($rowp['project_category_id']==2){
					$KonPerTahun = "";
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
					$KonPerBulan = "";
				}elseif($rowp['project_category_id']==0){
					$KonPerTahun = "";
					$KonPerSebenar = "";	
					$KonAnggaran = "";	
					$KonPerBulan = "";
				}elseif($rowp['project_category_id']==3){
					$KonPerBulan = "";
				}
				
				?>
                <tr id="KonPerSebenar" style="display:<?=$KonPerSebenar?>">
                  <td width="18%"><label for="kos">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Sebenar</label></td>
                  <td colspan="2" align="right">RM</td>
                  <td colspan="3"><span id="kosdisplay"><input <?=$disable?> name="kos" type="text" id="kos" size="40" value="<?=number_format($rowp['project_cost'],2)?>" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></span> <input <?=$checked ?> type="checkbox" value="1" name="checkbox_kos" id="checkbox_kos" onclick="kadar_harga()" />
                  Kadar Harga</td>
                  <td></td>
                </tr>
                 <tr style="display:<?=$KonAnggaran?>">
                  <td width="18%">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Anggaran</td>
                  <td colspan="2" align="right">RM</td>
                  <td colspan="3"><input name="kosA" type="text" id="kosA" size="40" value="<?=number_format($rowp['project_costA'],2)?>" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></span> </td>
                  <td></td>
                </tr>
                <tr style="display:<?=$KonPerBulan?>">
                  <td colspan="2"><label for="kos2">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Per&nbsp;Bulan</label></td>
                  <td width="3%" align="right">RM</td>
                  <td colspan="3">
                    <input name="kos2" type="text" id="kos2" size="40" value="<?=number_format($rowp['project_cost_month'],2)?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                  * Jika ada</td>
                  <td></td>
                </tr>
                <tr style="display:<?=$KonPerTahun?>">
                  <td colspan="2"><label for="kos3">&nbsp;&nbsp;&nbsp;&nbsp;Harga&nbsp;Kontrak&nbsp;Per&nbsp;Tahun</label></td>
                  <td align="right">RM</td>
                  <td colspan="3">
                    <input name="kos3" type="text" id="kos3" size="40" value="<?=number_format($rowp['project_cost_year'],2)?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                    * Jika ada</td>
                  <td></td>
                </tr>
                <tr>
                   <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Bon Perlaksanaan</td>
                   <td align="right">RM</td>
                   <td colspan="3">
                   <input name="bon_perlaksanaan2" type="text" id="telefon2" size="40" value="<?=number_format($rowp['bon_perlaksanaan2'],2)?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                   <input <?=$checkedbon ?> type="checkbox" name="kesemua_bon" id="kesemua_bon" />
                  Kesemua</td>
                   </tr>
                
                <tr>
                    <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kaedah </td>
					<td colspan="3"><select name="kaedah" id="kaedah" >
        						<option>---Sila Pilih---</option>
                                    <?
								$sqlkaedah='select * from kaedah_bon';
								$resultkaedah = mysql_query($sqlkaedah);
					  			while($rowkaedah = mysql_fetch_array($resultkaedah))
								{
										if ($rowkaedah['kaedah_id'] == $rowp['kaedah'])
										{
											?>
                                    <option value="<?=$rowkaedah['kaedah_id'] ?>" selected="selected"> <?=$rowkaedah['kaedah_desc']?>
                                    </option>
                                    <?						
										}
										else
										{
										?>
                                    <option value="<?=$rowkaedah['kaedah_id'] ?>"><?=$rowkaedah['kaedah_desc']?>
                                    </option>
                                    <? 
										}
								}			
									?>
                                  </select></td>
                                  <td></td>
                                </tr>
                                
                              
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                
                 <tr>
                                  <td colspan="6" valign="top"><div style="border:1px solid black;width:100%;">&nbsp;&nbsp;&nbsp;&nbsp;Insuran <br><br><br>
                                 <? $sqlinsuran = "Select * from insuran where project_id =".$idupdate;
								 	$resultinsuran = mysql_query($sqlinsuran);
									$j = 0;
									while($rowinsuran = mysql_fetch_array($resultinsuran))
									{
									$j++;	
								 ?>
                                	<div id="insuranshow<?=$j?>">
                                  <table width="100%" border="0" align="center">
                                  <tr>
                                  	<td width="6%" align="right"><?=$j ?>&nbsp;</td>
                                    <td width="34%"><input type="text" name="insuran<?=$j?>" id="insuran<?=$j?>" size="40" value="<?=$rowinsuran['insuran_name']?>" /></td>
                                    <td width="43%">&nbsp;RM
                                      <label for="textfield4"></label>
                                      <input type="text" name="nilai<?=$j?>" id="nilai<?=$j?>" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" value="<?=number_format($rowinsuran['nilai'],2)?>"/>
                                      <input type="button" name="button7" id="button7" value="Batal" onclick="removeinsuran(<?=$j?>)" /></td>
                                    </tr>
                                  </table>
                               	  	</div>
                                    
						        	<?
									}
									?>
                                  	<div id="tambah_insuran">
                               	    </div>      
                                  <input <?=$checkedins ?> type="checkbox" name="kesemua_insuran" id="kesemua_insuran" />Kesemua
                                  <input type="button" name="Tambah" id="Tambah" value="Tambah Insuran" onclick="addinsuran('tambah_insuran')" />
                                  <input type="hidden" name="counter2" id="counter2" value="<?=$j?>" />  
                                  </div>
                                  </td>
                                </tr>
                     
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Pegawai Projek</td>
                  <td><select accept="check" name="p_projek" id="p_projek" onchange="email2(this), jawatan2(this)" >
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sql='select * from user order by user_name';
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result))
                        {
						if($rowp['pegawai_projek']==$row['user_id']){
                    		?>
                    		<option selected="selected" value="<?=$row['user_id'] ?>"><?=$row['user_name']?></option>
                    		<?
						}else{
							?>
							<option value="<?=$row['user_id'] ?>"><?=$row['user_name']?></option>
							<?	
						}
                    }	
                        ?>
                  </select></td>
                  <td align="right">Jawatan</td>
                  <td><div id="jawatanAjax">
                    <input type="text" accept="check" name="jawatan_pprojek" id="jawatan_pprojek" value="<?=$rowp['jawatan_pprojek']?>" size="40" readonly="readonly" />
                  </div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Email Pegawai Projek</td>
                  <td><label for="textfield7"></label>
                    <div id="emailAjax">
                      <input type="text" accept="check" name="email" id="email" size="40" value="<?=$rowp['email_pegawai']?>" readonly="readonly"/>
                  </div></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Penolong Pegawai Projek</td>
                  <td><input name="pen_projek" type="text" id="pen_projek" value="<?=$rowp['pen_pegawai_projek']?>" size="40" />
                    <!--<input name="bulan" id="bulan" type="hidden" onmouseover="" size="40" />
                  					<input name="tahun" id="tahun" type="hidden" onmouseover="" size="40" />--></td>
                  <td align="right">Jawatan</td>
                  <td><select name="jawatan_penprojek" id="jawatan_penprojek">
                     <option value="0">---Sila Pilih---</option>
                    <?
                    $sqljwtn2='select * from jawatan order by jawatan_desc';
                    $resultjwtn2 = mysql_query($sqljwtn2);
                    while($rowjwtn2 = mysql_fetch_array($resultjwtn2))
                    {
						if($rowjwtn2['jawatan_id'] == $rowp['jawatan_penprojek']){
						?>
							<option selected="selected" value="<?=$rowjwtn2['jawatan_id'] ?>"><?=$rowjwtn2['jawatan_desc']?></option>
						<? 
						}
						else{
						?>
							<option value="<?=$rowjwtn2['jawatan_id'] ?>"><?=$rowjwtn2['jawatan_desc']?></option>
						<?	
						}
					}	
                        ?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;PTBK/PTB/Juruteknik</td>
                  <td><input name="ptbk" type="text" id="ptbk" value="<?=$rowp['ptbk']?>" size="40"/></td>
                  <td align="right">Jawatan</td>
                  <td><select name="jawatan_ptbk" id="jawatan_ptbk">
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sqljwtn3='select * from jawatan order by jawatan_desc';
                    $resultjwtn3 = mysql_query($sqljwtn3);
                    while($rowjwtn3 = mysql_fetch_array($resultjwtn3))
                    {
						if($rowjwtn3['jawatan_id'] == $rowp['jawatan_ptbk']){
						?>
							<option selected="selected" value="<?=$rowjwtn3['jawatan_id'] ?>"><?=$rowjwtn3['jawatan_desc']?></option>
						<? 
						}
						else{
						?>
							<option value="<?=$rowjwtn3['jawatan_id'] ?>"><?=$rowjwtn3['jawatan_desc']?></option>
						<?	
						}
					}	
                        ?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                	<?
                    	$sqluser = "select * from user where user_id = " .$rowp["user_insert"];
						$resultuser = mysql_query($sqluser);
						$rowuser = mysql_fetch_array($resultuser);
						
						$sqluseru = "select * from user where user_id = " .$rowp["user_update"];
						$resultuseru = mysql_query($sqluseru);
						$rowuseru = mysql_fetch_array($resultuseru);
						
						if($rowuser["user_name"]==""){
							$daftar = "";	
						}else{
							$daftar = "Didaftarkan oleh " .$rowuser['user_name']. " pada " .date('d-M-Y H:i:s', strtotime($rowp['time_insert']))."<br>";
						}
						
						if($rowuseru["user_name"]==""){
							$kemaskini = "";	
						}else{
							$kemaskini = "Kemaskini terakhir oleh " .$rowuseru['user_name']. " pada " .date('d-M-Y H:i:s', strtotime($rowp['time_update']));	
						}
						
					?>
           <tr>
                       <td colspan="7" bgcolor="#F3F781" align="center">&nbsp;<?=$daftar ?><?=$kemaskini?></td>
           </tr>
                	
                <tr >
                  <td colspan="7" align="center"><div id="txtconvertdate"></div></td>
                </tr>
                <tr bgcolor="#999999" align="right">
                  <td colspan="7"><input type="submit" name="hantar" id="hantar" value="Simpan" onclick="insert_ImportProject()" class="button_style" />
                  <input type="button" name="batal" id="batal" value="Batal" onclick="tutup()" class="button_style"/></td>
                </tr>
</table>	
			
	<?		
	}
	
//athirah 25-03-2013 start
function update_kwsn(){
	
	$layer = $_GET["layer"];
	$desc = replace($_GET["desc"]);
	$idupdate = $_GET["idupdate"];
	$parlimen2 = $_GET["parlimen2"];
	$adun2 = $_GET["adun2"];

//original info
	$sqlKwsn = "select * FROM kawasan where kwsn_id = ".$idupdate."";
	$kwsn = mysql_query($sqlKwsn);
	$kawasan = mysql_fetch_array($kwsn);
	$parent2=$kawasan['parent_id'];
	
	//reset seq_no start
	if($layer==1) { 
		$parent=0;
		$sqlSeq = "select seq_no FROM kawasan where kwsn_id = ".$idupdate."";
		$seq = mysql_query($sqlSeq);
		$seq_no = mysql_fetch_row($seq);
		$seq_number = $seq_no[0];
	}	
	if($layer==2) {
			$parent = $parlimen2;
			if ($parent==$parent2) {  //keep the same seqno
				$seq_number = $kawasan['seq_no'];
			}
			else {  //reset seq_no
				$sqlSeq = "select MAX(seq_no) FROM kawasan where parent_id = " .$parent;
				$seq = mysql_query($sqlSeq);
				$seq_no = mysql_fetch_row($seq);
				if(isset($seq_no[0]))
					$seq_number = number_format($seq_no['0'],3)+(0.1);
				else
				{
					$sqlSeq = "select seq_no FROM kawasan where kwsn_id = " .$parent;
					$seq = mysql_query($sqlSeq);
					$seq_no = mysql_fetch_row($seq);
					$seq_number = number_format($seq_no['0'],3)+(0.1);
				}
			}
	}
		
	if($layer==3) {
		$parent = $adun2;
		if ($parent==$kawasan['parent_id']) {  //keep the same seqno
			$seq_number=$kawasan['seq_no'];
		}
		else {  //reset seqno
			$sqlSeq = "select MAX(seq_no) FROM kawasan where parent_id = " .$parent;
			$seq = mysql_query($sqlSeq);
			$seq_no = mysql_fetch_row($seq);
			if(isset($seq_no[0]))
				$seq_number = number_format($seq_no['0'],3)+(0.001);
			else
			{
				$sqlSeq = "select seq_no FROM kawasan where kwsn_id = " .$parent;
				$seq = mysql_query($sqlSeq);
				$seq_no = mysql_fetch_row($seq);
				$seq_number = number_format($seq_no['0'],3)+(0.001);
			}
		}
	}
	//reset seq_no end
	
	$sql = "update kawasan set kwsn_desc = '".$desc."',layer = '".$layer."',parent_id = '".$parent."',seq_no = '".$seq_number."' ". 
	"where kwsn_id = ".$idupdate."";
	//echo $sql;
	$result = mysql_query($sql);
	
}

//athirah 25-03-2013 end
	
function updatedept(){
	
	$bahagian = 0;
	
	$peringkat = $_GET["peringkat"];
	$bahagian = $_GET["bahagian"];
	$nama = replace($_GET["nama"]);
	$idupdate = $_GET["idupdate"];
	
	$sql = "update department set layer = '".$peringkat."',parent_id = '".$bahagian."',department_desc = '".$nama."' ". 
	"where department_id = ".$idupdate."";
	echo $bahagian;
	//exit();
	$result = mysql_query($sql);
	echo $nama."|".$peringkat;
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
}
function updategredC(){

	$radio_kategori = $_GET["radio_kategori"];
	$gred = replace($_GET["gred"]);
	$had = replace($_GET["had"]);
	$dateS = replace($_GET["dateS"]);
	$dateE = $_GET["dateE"];
	
	if($dateE == "-"){
		$dateEstring = "2999-01-01";	
	}else{
		$dateEstring = date("Y-m-d", strtotime($dateE));
	}
	$idupdate = $_GET["idupdate"];
	
	$sql = "update contractor_class set class_desc = '".$gred."',had = '".$had."',kategori_kerja = '".$radio_kategori."',CSdateS = '".date("Y-m-d", strtotime($dateS))."',CSdateE = '".$dateEstring."' ". 
	"where contractor_class_id = ".$idupdate."";
	
	$result = mysql_query($sql);
	if($radio_kategori == 1){
		$radio_kategori = "Kontraktor Kerja";	
	}else{
		$radio_kategori = "Kontraktor Elektrik";	
	}
	
	echo $gred."|".$had."|".$radio_kategori."|".$dateS."|".$dateE;
	//echo $sql;
	//echo $dateEstring;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
}


	
function updateusergroup(){
	
	$kumpengguna = replace($_GET["kumpengguna"]);
	$turutan = $_GET["turutan"];
	$idupdate = $_GET["idupdate"];
	$level = $_GET["level"];
	
	$sql = "update user_group set user_group_desc = '".$kumpengguna."',user_group_layer = '".$level."',seq = '".$turutan."' ". 
	"where user_group_id = ".$idupdate."";
	//echo $sql;
	//exit();
	$result = mysql_query($sql);
	echo $kumpengguna."|".$turutan;
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
}
	
function updatejawatan(){
	
	$jawatan = replace($_GET["jawatan"]);
	
	$idupdate = $_GET["idupdate"];
	
	$sql = "update jawatan set jawatan_desc = '".$jawatan."' ". 
	"where jawatan_id = ".$idupdate."";
	//echo $sql;
	//exit();
	$result = mysql_query($sql);
	echo $jawatan;
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
}
	
function updateuseradmin(){
	
	$nama = replace($_GET["nama"]);
	$jawatan = $_GET["jawatan"];
	$gred = $_GET["gred"];
	$email = replace($_GET["email"]);
	$notel = replace($_GET["notel"]);
	$notelbimbit = replace($_GET["notelbimbit"]);
	$kumpengguna = $_GET["kumpengguna"];
	$jabatan = $_GET["jabatan"];
	$idupdate = $_GET["idupdate"];
	
	$sql = "update user set user_name = '".$nama."',user_email = '".$email."',user_notel = '".$notel."',user_nobimbit = '".$notelbimbit."',gred_id = '".$gred."',user_jawatan_id = '".$jawatan."',user_group_id = '".$kumpengguna."',department_id = '".$jabatan."' ". 
	"where user_id = ".$idupdate."";
	//echo $sql;
	//exit();
	$result = mysql_query($sql);
	$usergroupsql = "user_group";
	$usergroupid = "user_group_id";
	$usergroupdesc = "user_group_desc";
	
	$jabatansql = "department";
	$jabatanid = "department_id";
	$jabatandesc = "department_desc";
	
	$gredsql = "gred";
	$gredid = "gred_id";
	$greddesc = "gred_desc";
	
	$jawatansql = "jawatan";
	$jawatanid = "jawatan_id";
	$jawatandesc = "jawatan_desc";
	
	echo $nama."|".desc($jawatan,$jawatansql,$jawatanid,$jawatandesc)."|".desc($jabatan,$jabatansql,$jabatanid,$jabatandesc)."|".desc($gred,$gredsql,$gredid,$greddesc)."|".$email."|".$notel."|".$notelbimbit."|".desc($kumpengguna,$usergroupsql,$usergroupid,$usergroupdesc);
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
}

function updateuserAdun(){
	
	$email = replace($_GET["email"]);
	$notel = replace($_GET["notel"]);
	$notelbimbit = replace($_GET["notelbimbit"]);
	$idupdate = $_GET["idupdate"];
	
	$sql = "update user set user_email = '".$email."',user_notel = '".$notel."',user_nobimbit = '".$notelbimbit."' ". 
	"where user_id = ".$idupdate."";
	//echo $sql;
	//exit();
	$result = mysql_query($sql);
	$usergroupsql = "user_group";
	$usergroupid = "user_group_id";
	$usergroupdesc = "user_group_desc";
	
	$jabatansql = "department";
	$jabatanid = "department_id";
	$jabatandesc = "department_desc";
	
	$gredsql = "gred";
	$gredid = "gred_id";
	$greddesc = "gred_desc";
	
	$jawatansql = "jawatan";
	$jawatanid = "jawatan_id";
	$jawatandesc = "jawatan_desc";
	
	echo $email."|".$notel."|".$notelbimbit;
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
}

function desc($idref,$sql,$id,$desc) {
	if ($idref!="") {
		$sql = "select * from ".$sql." where ".$id."=".$idref;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		return $row[$desc];
	}
}

function userGroup($kumpengguna) {
	$sql = "select * from user_group order by seq";
	$result = mysql_query($sql);
	echo "<select name='kumpengguna'>";
	while($row = mysql_fetch_array($result)) {
		if ($kumpengguna!="") {
			if ($kumpengguna==$row['user_group_id']) {
				echo "<option value='".$row['user_group_id']."' selected>".$row['user_group_desc']."</option>";
			} else {
				echo "<option value='".$row['user_group_id']."'>".$row['user_group_desc']."</option>";
			}
		} else {
			echo "<option value='".$row['user_group_id']."'>".$row['user_group_desc']."</option>";
		}
	}
	echo "</select>";
}

function updatetype(){
	
	$jenis = replace($_GET["jenis"]);
	$short = replace($_GET["short"]);
	
	$idupdate = $_GET["idupdate"];
	
	$sql = "update project_type set project_type_desc = '".$jenis."',project_type_short = '".$short."' ". 
	"where project_type_id = ".$idupdate."";
	$result = mysql_query($sql);
	echo $jenis."|".$short;
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
	}
	
function updatecategory(){
	
	$kategori = replace($_GET["kategori"]);
	
	$idupdate = $_GET["idupdate"];
	$short = replace($_GET["short"]);
	
	$sql = "update project_category set project_category_desc = '".$kategori."',project_category_short = '".$short."' ". 
	"where project_category_id = ".$idupdate."";
	$result = mysql_query($sql);
	echo $kategori."|".$short;
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
	}
	
function updategred(){
	
	$gred = replace($_GET["gred"]);
	
	$idupdate = $_GET["idupdate"];	
	$sql = "update gred set gred_desc = '".$gred."' ". 
	"where gred_id = ".$idupdate."";
	$result = mysql_query($sql);
	echo $gred;
	//echo $sql;
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
	}

function updateperunding(){
	
	$idupdate = $_GET["idupdate"];
	$no_pendaftaran = replace($_GET["no_pendaftaran"]);
	$kontraktor = replace($_GET["kontraktor"]);
	$alamat = replace($_GET["alamat"]);
	$email = replace($_GET["email"]);
	$telefon = replace($_GET["telefon"]);
	$telefon2 = replace($_GET["telefon2"]);
	$fax = replace($_GET["fax"]);
	$radio_bumiputra = $_GET["radio_bumiputra"];
	$radio_BList = $_GET["radio_BList"];
	$no_kkm = replace($_GET["no_kkm"]);
		
	$sql = "update contractor set contractor_name = '".$kontraktor."',contractor_regno = '".$no_pendaftaran."',contractor_address = '".$alamat."',contractor_email = '".$email."',contractor_phone = '".$telefon."',contractor_phonepejabat = '".$telefon2."',contractor_fax = '".$fax."',bumiputra = '".$radio_bumiputra."',contractor_status_id = '".$radio_BList."',no_kkm = '".$no_kkm."' ". 
	"where contractor_id = ".$idupdate."";
	$result = mysql_query($sql);
	echo $kontraktor."|".$no_pendaftaran."|".$alamat."|".$email."|".$telefon."|".$telefon2."|".$fax."|".ya_tidak($radio_bumiputra)."|".ya_tidak($radio_BList);
	
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
}

function updatekontraktor(){
	
	$idupdate = $_GET["idupdate"];
	$no_pendaftaran = $_GET["no_pendaftaran"];
	$kontraktor = $_GET["kontraktor"];
	$alamat = $_GET["alamat"];
	$email = $_GET["email"];
	$telefon = $_GET["telefon"];
	$telefon2 = $_GET["telefon2"];
	$fax = $_GET["fax"];
	$radio_bumiputra = $_GET["radio_bumiputra"];
	$radio_cidb = $_GET["radio_cidb"];
	$no_pkk = $_GET["no_pkk"];
	$kelas = $_GET["kelas"];
	$kelasNew = $_GET["kelasNew"];
	$no_kkm = $_GET["no_kkm"];
	$radio_upen = $_GET["radio_upen"];
	$bon_perlaksanaan = $_GET["bon_perlaksanaan"];
	$kaedah = $_GET["kaedah"];
	$radio_BList = $_GET["radio_BList"];
		
	$sql = "update contractor set contractor_name = '".$kontraktor."',contractor_regno = '".$no_pendaftaran."',contractor_address = '".$alamat."',contractor_email = '".$email."',contractor_phone = '".$telefon."',contractor_phonepejabat = '".$telefon2."',contractor_fax = '".$fax."',bumiputra = '".$radio_bumiputra."',contractor_status_id = '".$radio_BList."',cidb = '".$radio_cidb."',no_pkk = '".$no_pkk."',contractor_class_id = '".$kelas."',contractor_class_idNew = '".$kelasNew."',no_kkm = '".$no_kkm."',upen = '".$radio_upen."',bon_perlaksanaan = '".$bon_perlaksanaan."',kaedah = '".$kaedah."' ". 
	"where contractor_id = ".$idupdate."";
	$result = mysql_query($sql);
	
	$kelasDesc = '';
	$kelasNewDesc = '';
	if(($kelas<>'0') && ($kelas<>'')){
		$kelasDesc = 'PKK&nbsp;:&nbsp;'.kelas_desc($kelas).'<br>';
	}
	if(($kelasNew<>'0') && ($kelasNew<>'')){
		$kelasNewDesc = 'SPKK&nbsp;:&nbsp;'.kelas_desc($kelasNew);
	}
	echo $kontraktor."|".$no_pendaftaran."|".$alamat."|".$email."|".$telefon."|".$telefon2."|".$fax."|".ya_tidak($radio_bumiputra)."|".$kelasDesc.$kelasNewDesc."|".$no_pkk."|".$no_kkm."|".ya_tidak($radio_BList);
	
	//$num_rows = mysql_fetch_array($resultrow);
	//exit();
	
}

function update_bidang(){
	
	$kod_bidang = $_GET["kod_bidang"];
	$kod = $_GET["kod"];
	$sub_bidang = $_GET["sub_bidang"];
	$nama1 = $_GET["nama"];
	$nama = replace($nama1);
	$idupdate = $_GET["idupdate"];
	
	$sub_bidang1 = explode("|",$sub_bidang);
	$sub_bidang2 = $sub_bidang1[0];
	
	$sql = "update kepala_pecahan set kepala_sub_id = '".$sub_bidang2."',kepala_anak_kod = '".$kod."',kepala_anak_desc = '".$nama."',kod = '".$kod_bidang."' ". 
	"where kepala_anak_id = ".$idupdate."";
	//echo $sql;
	//exit();
	$result = mysql_query($sql);
	echo $kod_bidang."|".$nama;
}

function update_project(){
	
	$idupdate = $_GET["idupdate"];
	//$radio_perunding = $_GET["radio_perunding"];
	
	//no kontrak
	$awal = replace($_GET["awal"]); 
	$tengah = replace($_GET["tengah"]); 
	$akhir = replace($_GET["akhir"]); 
	
	$kategori = $_GET["kategori"];
	$bidangprojek = $_GET["bidangprojek"];
	$jenis = $_GET["jenis"];
	$kontraktor = $_GET["kontraktor"];
	$jabatan = $_GET["jabatan"];

	$nama_projek = replace($_GET["nama_projek"]);
	$tarikhTS = date("Y-m-d", strtotime( $_GET["tarikhTS"]));
	$datemula = date("Y-m-d", strtotime( $_GET["datemula"]));
	$datetamat = date("Y-m-d", strtotime( $_GET["datetamat"]));
	$jangkamasa = $_GET["jangkamasa"];
	$no_peruntukan = replace($_GET["no_peruntukan"]);
	$kosdisplay = $_GET["kos"];
	$kos = str_replace(",","",$_GET['kos']);
	$kosA = str_replace(",","",$_GET['kosA']);
	$kos2 = str_replace(",","",$_GET['kos2']);	
	$kos3 = str_replace(",","",$_GET['kos3']);
	$kadar_harga = $_GET["kadar_harga"];		
	$p_projek = replace($_GET["p_projek"]);
	$jawatan_pprojek = $_GET["jawatan_pprojek"];
	$email = replace($_GET["email"]);
	$bon_perlaksanaan2 = str_replace(",","",$_GET['bon_perlaksanaan2']);
	$kaedah = $_GET["kaedah"];
	$kesemua_bon = $_GET["kesemua_bon"];
	$kesemua_insuran = $_GET["kesemua_insuran"];
	
	$pen_projek = replace($_GET["pen_projek"]);	
	$jawatan_penprojek = $_GET["jawatan_penprojek"];
	$ptbk = replace($_GET["ptbk"]);
	$jawatan_ptbk = $_GET["jawatan_ptbk"];
	$semuazon = $_GET["semuazon"];
	
	if(isset($_GET["parlimen"])){
		$parlimen = $_GET["parlimen"];		
	}else{
		$parlimen = "";
	}
	
	if(isset($_GET["adun"])){
		$adun = $_GET["adun"];		
	}else{
		$adun = "";
	}
	
	if(isset($_GET["majlis"])){
		$majlis = $_GET["majlis"];		
	}else{
		$majlis = "";
	}
			
	
	$sql = "update project set tarikhMasukTS = '".$tarikhTS."',project_reference = '".$awal.'&nbsp;'.$tengah.'/'.$akhir."', seq_category = '".$awal."',seq = '".$tengah."',seq_year = '".$akhir."',project_category_id = '".$kategori."',bidang = '".$bidangprojek."',project_type_id = '".$jenis."',contractor_id = '".$kontraktor."',department_id = '".$jabatan."',project_name = '".$nama_projek."',kwsn_id_p = '".$parlimen."',kwsn_id_a = '".$adun."',kwsn_id_m = '".$majlis."',date_start = '".$datemula."',date_end = '".$datetamat."',project_duration = '".$jangkamasa."',no_peruntukan = '".$no_peruntukan."',project_cost = '".$kos."',project_costA = '".$kosA."',project_cost_month = '".$kos2."',project_cost_year = '".$kos3."',kadar_harga = '".$kadar_harga."',bon_perlaksanaan2 = '".$bon_perlaksanaan2."',kaedah = '".$kaedah."',kesemua_bon = '".$kesemua_bon."',kesemua_insuran = '".$kesemua_insuran."',pegawai_projek = '".$p_projek."',jawatan_pprojek = '".$jawatan_pprojek."',email_pegawai = '".$email."',pen_pegawai_projek = '".$pen_projek."',jawatan_penprojek = '".$jawatan_penprojek."',ptbk = '".$ptbk."',jawatan_ptbk = '".$jawatan_ptbk."',semuazon = '".$semuazon."',user_update = '".$_SESSION["id"]."',time_update = now() ". 
	"where project_id = ".$idupdate."";

	$result = mysql_query($sql);
	
	
	$sql2 = "select * from project p ".
			"left join project_category on p.project_category_id = project_category.project_category_id ".
			"inner join contractor on p.contractor_id = contractor.contractor_id ".
			"inner join department on p.department_id = department.department_id ".
			"inner join project_type on p.project_type_id = project_type.project_type_id ".
			"where project_id = ".$idupdate;	
					
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2);
	
		if ($row2['project_cost_year'] != 0.0000){
			$kostahun = number_format($row2['project_cost_year'],2)."&nbsp;/&nbsp;Tahun<br>";
		}
		else{
			$kostahun = "";
		}
		
		if ($row2['project_cost_month'] != 0.0000){
			$kosbulan = number_format($row2['project_cost_month'],2)."&nbsp;/&nbsp;Bulan<br>";
		}
		else{
			$kosbulan = "";
		}
		
		if ($row2['kadar_harga'] == 1){
			$kadar = "Kadar&nbsp;Harga<br>";
		}
		else{
			$kadar = "";
		}
		
		if ($row2['project_cost'] != 0.0000){
			$kos = number_format($row2['project_cost'],2);
			
		}
		else{
			$kos = "";
		}
	
	echo $awal.'&nbsp;'.$tengah.'/'.$akhir."|".date("d-m-Y", strtotime($row2['project_date']))."|".$row2['project_name']."|".$kos.$kadar.$kostahun.$kosbulan."|".date("d-m-Y", strtotime($row2['date_start']))."|".date("d-m-Y", strtotime($row2['date_end']))."|".$row2['project_duration']."|".$row2['project_category_desc']."|".$row2['contractor_name']."|".$row2['project_type_desc']."|".$row2['department_desc'];
}

function insert_ImportProject(){
	
	$id = $_GET["idupdate"];
	
	$tarikhTS = date("Y-m-d", strtotime( $_GET["tarikhTS"]));
	$tarikhDaftar = date("Y-m-d", strtotime( $_GET["tarikhPenPro"]));
	$tarikhLantikan  = date("Y-m-d", strtotime( $_GET["tarikhLantikan"]));
	
	$awal = replace($_GET["awal"]); 
	$tengah = replace($_GET["tengah"]); 
	$akhir = replace($_GET["akhir"]); 
	
	$kategori = $_GET["kategori"];
	$bidangprojek = $_GET["bidangprojek"];
	$jenis = $_GET["jenis"];
	$kontraktor = $_GET["kontraktor"];
	$jabatan = $_GET["jabatan"];

	$nama_projek = replace($_GET["nama_projek"]);
	$datemula = date("Y-m-d", strtotime( $_GET["datemula"]));
	$datetamat = date("Y-m-d", strtotime( $_GET["datetamat"]));
	$jangkamasa = $_GET["jangkamasa"];
	$no_peruntukan = replace($_GET["no_peruntukan"]);
	$kosdisplay = $_GET["kos"];
	$kos = str_replace(",","",$_GET['kos']);
	$kosA = str_replace(",","",$_GET['kosA']);
	$kos2 = str_replace(",","",$_GET['kos2']);	
	$kos3 = str_replace(",","",$_GET['kos3']);
	$kadar_harga = $_GET["kadar_harga"];		
	$p_projek = replace($_GET["p_projek"]);
	$jawatan_pprojek = $_GET["jawatan_pprojek"];
	$email = replace($_GET["email"]);
	$bon_perlaksanaan2 = str_replace(",","",$_GET['bon_perlaksanaan2']);
	$kaedah = $_GET["kaedah"];
	$kesemua_bon = $_GET["kesemua_bon"];
	$kesemua_insuran = $_GET["kesemua_insuran"];
	
	$pen_projek = replace($_GET["pen_projek"]);	
	$jawatan_penprojek = $_GET["jawatan_penprojek"];
	$ptbk = replace($_GET["ptbk"]);
	$jawatan_ptbk = $_GET["jawatan_ptbk"];
	$semuazon = $_GET["semuazon"];
	
	if(isset($_GET["parlimen"])){
		$parlimen = $_GET["parlimen"];		
	}else{
		$parlimen = "";
	}
	
	if(isset($_GET["adun"])){
		$adun = $_GET["adun"];		
	}else{
		$adun = "";
	}
	
	if(isset($_GET["majlis"])){
		$majlis = $_GET["majlis"];		
	}else{
		$majlis = "";
	}
			
	
	//$sql = "update project set project_reference = '".$awal.'&nbsp;'.$tengah.'/'.$akhir."', seq_category = '".$awal."',seq = '".$tengah."',seq_year = '".$akhir."',project_category_id = '".$kategori."',bidang = '".$bidangprojek."',project_type_id = '".$jenis."',contractor_id = '".$kontraktor."',department_id = '".$jabatan."',project_name = '".$nama_projek."',kwsn_id_p = '".$parlimen."',kwsn_id_a = '".$adun."',kwsn_id_m = '".$majlis."',date_start = '".$datemula."',date_end = '".$datetamat."',project_duration = '".$jangkamasa."',no_peruntukan = '".$no_peruntukan."',project_cost = '".$kos."',project_costA = '".$kosA."',project_cost_month = '".$kos2."',project_cost_year = '".$kos3."',kadar_harga = '".$kadar_harga."',bon_perlaksanaan2 = '".$bon_perlaksanaan2."',kaedah = '".$kaedah."',kesemua_bon = '".$kesemua_bon."',kesemua_insuran = '".$kesemua_insuran."',pegawai_projek = '".$p_projek."',jawatan_pprojek = '".$jawatan_pprojek."',email_pegawai = '".$email."',pen_pegawai_projek = '".$pen_projek."',jawatan_penprojek = '".$jawatan_penprojek."',ptbk = '".$ptbk."',jawatan_ptbk = '".$jawatan_ptbk."',semuazon = '".$semuazon."',user_update = '".$_SESSION["id"]."',time_update = now() ". 
	//"where project_id = ".$idupdate."";
	
	$sql = "insert into project (dr_Pro_Dirancang,year,eot,project_date,project_reference,seq_category,seq,seq_year,project_category_id,bidang,project_type_id,contractor_id,department_id,project_name,kwsn_id_p,kwsn_id_a,kwsn_id_m,date_start,date_end,project_duration,no_peruntukan,project_cost,project_costA,project_cost_month,project_cost_year,kadar_harga,bon_perlaksanaan2,kaedah,kesemua_bon,kesemua_insuran,pegawai_projek,jawatan_pprojek,email_pegawai,pen_pegawai_projek,jawatan_penprojek,ptbk,jawatan_ptbk,semuazon,user_insert,time_insert,tarikhMasukTS,tarikhLantikanP) values (".$id.",'".date("Y", strtotime( $_GET["datemula"]))."','".$datetamat."','".$tarikhDaftar."','".$awal.'&nbsp;'.$tengah.'/'.$akhir."','".$awal."','".$tengah."','".$akhir."','".$kategori."','".$bidangprojek."','".$jenis."','".$kontraktor."','".$jabatan."','".$nama_projek."','".$parlimen."','".$adun."','".$majlis."','".$datemula."','".$datetamat."','".$jangkamasa."','".$no_peruntukan."','".$kos."','".$kosA."','".$kos2."','".$kos3."','".$kadar_harga."', ".
			"'".$bon_perlaksanaan2."','".$kaedah."','".$kesemua_bon."','".$kesemua_insuran."','".$p_projek."','".$jawatan_pprojek."','".$email."', ".
			"'".$pen_projek."','".$jawatan_penprojek."','".$ptbk."','".$jawatan_ptbk."','".$semuazon."','".$_SESSION["id"]."',now(),'".$tarikhTS."','".$tarikhLantikan."')";
	$result = mysql_query($sql);
	
	$sqlUpdate = "update project_dirancang set p_award = 1 where project_id = '".$id."' ";	
	$resultUpdate = mysql_query($sqlUpdate);
	
	$idproject = process_sql("select max(project_id) as idProject from project","idProject");
}

function update_project_dirancang(){
	
	$idupdate = $_GET["idupdate"];
	//$radio_perunding = $_GET["radio_perunding"];
	
	//no kontrak
	$kategori = $_GET["kategori"];
	$bidangprojek = $_GET["bidangprojek"];
	$jenis = $_GET["jenis"];
	$jabatan = $_GET["jabatan"];

	$nama_projek = replace($_GET["nama_projek"]);
	$catatan = replace($_GET["catatan"]);
	$statDoc = $_GET["statDoc"];
	$tarikhTS = date("Y-m-d", strtotime( $_GET["tarikhTS"]));
	$datemula = date("Y-m-d", strtotime( $_GET["datemula"]));
	$datetamat = date("Y-m-d", strtotime( $_GET["datetamat"]));
	$jangkamasa = $_GET["jangkamasa"];
	$no_peruntukan = replace($_GET["no_peruntukan"]);
	$kosdisplay = $_GET["kos"];
	$kos = str_replace(",","",$_GET['kos']);
	$kosA = str_replace(",","",$_GET['kosA']);
	$kos2 = str_replace(",","",$_GET['kos2']);	
	$kos3 = str_replace(",","",$_GET['kos3']);
	$kadar_harga = $_GET["kadar_harga"];		
	$p_projek = replace($_GET["p_projek"]);
	$jawatan_pprojek = $_GET["jawatan_pprojek"];
	$email = replace($_GET["email"]);
	
	$pen_projek = replace($_GET["pen_projek"]);	
	$jawatan_penprojek = $_GET["jawatan_penprojek"];
	$ptbk = replace($_GET["ptbk"]);
	$jawatan_ptbk = $_GET["jawatan_ptbk"];
	$semuazon = $_GET["semuazon"];
	
	if(isset($_GET["parlimen"])){
		$parlimen = $_GET["parlimen"];		
	}else{
		$parlimen = "";
	}
	
	if(isset($_GET["adun"])){
		$adun = $_GET["adun"];		
	}else{
		$adun = "";
	}
	
	if(isset($_GET["majlis"])){
		$majlis = $_GET["majlis"];		
	}else{
		$majlis = "";
	}
			
	
	$sql = "update project_dirancang set tarikhDirancangTS = '".$tarikhTS."',project_category_id = '".$kategori."',bidang = '".$bidangprojek."',project_type_id = '".$jenis."',department_id = '".$jabatan."',project_name = '".$nama_projek."',kwsn_id_p = '".$parlimen."',kwsn_id_a = '".$adun."',kwsn_id_m = '".$majlis."',date_start = '".$datemula."',date_end = '".$datetamat."',project_duration = '".$jangkamasa."',no_peruntukan = '".$no_peruntukan."',project_cost = '".$kos."',project_costA = '".$kosA."',project_cost_month = '".$kos2."',project_cost_year = '".$kos3."',kadar_harga = '".$kadar_harga."',pegawai_projek = '".$p_projek."',jawatan_pprojek = '".$jawatan_pprojek."',email_pegawai = '".$email."',pen_pegawai_projek = '".$pen_projek."',jawatan_penprojek = '".$jawatan_penprojek."',ptbk = '".$ptbk."',jawatan_ptbk = '".$jawatan_ptbk."',semuazon = '".$semuazon."',user_update = '".$_SESSION["id"]."',catatan = '".$catatan."',statDoc = '".$statDoc."',time_update = now() ". 
	"where project_id = ".$idupdate."";

	$result = mysql_query($sql);
	
	
	$sql2 = "select * from project_dirancang p ".
			"left join project_category on p.project_category_id = project_category.project_category_id ".
			"inner join department on p.department_id = department.department_id ".
			"inner join project_type on p.project_type_id = project_type.project_type_id ".
			"where project_id = ".$idupdate;	
					
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2);
	
		if ($row2['project_cost_year'] != 0.0000){
			$kostahun = number_format($row2['project_cost_year'],2)."&nbsp;/&nbsp;Tahun<br>";
		}
		else{
			$kostahun = "";
		}
		
		if ($row2['project_cost_month'] != 0.0000){
			$kosbulan = number_format($row2['project_cost_month'],2)."&nbsp;/&nbsp;Bulan<br>";
		}
		else{
			$kosbulan = "";
		}
		
		if ($row2['kadar_harga'] == 1){
			$kadar = "Kadar&nbsp;Harga<br>";
		}
		else{
			$kadar = "";
		}
		
		if ($row2['project_cost'] != 0.0000){
			$kos = number_format($row2['project_cost'],2);
			
		}
		else{
			$kos = "";
		}
	
	echo date("d-m-Y", strtotime($row2['project_date']))."|".$row2['project_name']."|".$kosA.$kadar.$kostahun.$kosbulan."|".date("d-m-Y", strtotime($row2['date_start']))."|".date("d-m-Y", strtotime($row2['date_end']))."|".$row2['project_duration']."|".$row2['project_category_desc']."|".$row2['project_type_desc']."|".$row2['department_desc'];
	//echo date("d-m-Y", strtotime($row2['project_date']))."|".$row2['project_name']."|".$kosA.$kadar.$kostahun.$kosbulan."|".date("d-m-Y", strtotime($row2['date_start']))."|".date("d-m-Y", strtotime($row2['date_end']))."|".$row2['project_duration']."|".$row2['project_category_desc']."|".$row2['project_type_desc']."|".$row2['department_desc'];

}

function delete_pemilikkontraktor(){
	
	$idupdate = $_GET["idupdate"];
		
	$sql = "delete from owner where contractor_id = ".$idupdate."";
	//echo $sql;
	mysql_query($sql);
	
}

function delete_insurankontraktor(){
	
	$idupdate = $_GET["idupdate"];
		
	$sql = "delete from insuran where contractor_id = ".$idupdate."";
	//echo $sql;
	mysql_query($sql);
	
}

function insert_insurankontraktor(){
	
	$idupdate = $_GET["idupdate"];
	$insuran = replace($_GET["insuran"]);
	$nilai = replace($_GET["nilai"]);
	
	$sql = "insert into insuran (contractor_id,insuran_name,nilai) values ('".$idupdate."','".$insuran."','".$nilai."') ";
	//echo $sql;
	$result = mysql_query($sql);
	
}

function delete_usergroupmodule(){
	
	$idupdate = $_GET["idupdate"];
	//$idcheck = $_GET["idcheck"];
		
	$sql = "delete from user_group_module where user_group_id = ".$idupdate."";
	//echo $sql;
	mysql_query($sql);
	
}

function insert_usergroupmodule(){
	
	$idupdate = $_GET["idupdate"];
	$id_check = $_GET["id_check"];
	
	$sqlresetid = "alter table user_group_module auto_increment = 1";
	mysql_query($sqlresetid);
		
	$sql = "insert into user_group_module(user_group_id,module_id) values ('".$idupdate."','".$id_check."') ";
	//echo $sql;
	mysql_query($sql);
	
}

function delete_bidangp(){
	
	$idupdate = $_GET["idupdate"];
	
	$sql = "delete from bidang_perunding where contractor_id = ".$idupdate."";
	//echo $sql;
	mysql_query($sql);
	
}

function insert_bidangp(){
	
	$idupdate = $_GET["idupdate"];
	$id_check = $_GET["id_check"];
	
	//$sqlresetid = "alter table user_group_module auto_increment = 1";
	//mysql_query($sqlresetid);
		
	$sql = "insert into bidang_perunding(contractor_id,bidang_id) values ('".$idupdate."','".$id_check."') ";
	//echo $sql;
	mysql_query($sql);
	
}

function insert_pemilikkontraktor(){
	
	$idupdate = $_GET["idupdate"];
	$pemilik = replace($_GET["pemilik"]);
	$no_ic = replace($_GET["no_ic"]);
	$alamat = replace($_GET["alamat"]);
	$telefon = replace($_GET["telefon"]);
	$telefon2 = replace($_GET["telefon2"]);
		
	$sql = "insert into owner (contractor_id,owner_name,no_ic,address,no_tel,no_tel2) values ('".$idupdate."','".$pemilik."','".$no_ic."','".$alamat."','".$telefon."','".$telefon2."') ";
	echo $sql;
	$result = mysql_query($sql);
}

function delete_insuranprojek(){
	
	$idupdate = $_GET["idupdate"];
		
	$sql = "delete from insuran where project_id = ".$idupdate."";
	//echo $sql;
	mysql_query($sql);
}

function insert_insuranprojek(){
	
	$idupdate = $_GET["idupdate"];
	$insuran = replace($_GET["insuran"]);
	$nilai = replace(str_replace(",","",$_GET['nilai']));
	
	$sql = "insert into insuran (project_id,insuran_name,nilai) values ('".$idupdate."','".$insuran."','".$nilai."') ";
	//echo $sql;
	$result = mysql_query($sql);
	
}

function type_short(){
	
	$data = $_GET["data"];
	
	if ($data == 0){
		
		?>
        <select id="no_kontrak" name="no_kontrak">
    		<? 
				$sql = "select project_type_short from project_type where project_type_perunding =".$data;
				$sqlresult = mysql_query($sql);
				while($row = mysql_fetch_array($sqlresult)){
					?><option value="<?=$row["project_type_short"]?>"><?=$row["project_type_short"]?></option><?
				}
			?>  
    	</select>
		<? 
		
	}
		
	if($data == 1){
		
		?>
        <select id="no_kontrak" name="no_kontrak">
			<option value="P">P</option>
    	</select>
		<?
	
	}	
}

function bidang_perunding(){
	
			$p_type = $_GET["p_type"];
			if($p_type==0){$check = "";}else{$check = "check";}
				$sql = "select * from contractor c ".
						"where perunding = 1 ".
						"order by contractor_name";
				//echo $sql."3";
				$result = mysql_query($sql);			
			
						
			?>
			<select accept="<?=$check?>" style="alignment-adjust:central" id="kontraktor" name="kontraktor" />
                <option value="0">---Sila Pilih---</option>
                <? 
                while ($row = mysql_fetch_array($result)){
                ?><option value="<?=$row['contractor_id']?>"><?=$row['contractor_name']?></option><?
                
				}
			?>
			</select>
			<?	
}

function delete_bidangp2(){
	
	$idupdate = $_GET["idupdate"];
	
	$sql = "delete from bidang_projek where projek = " .$idupdate;
	$result = mysql_query($sql);		
}

function insert_bidangp2(){
	
	$idupdate = $_GET["idupdate"];
	$id_check = $_GET["id_check"];
	
	$sql = "insert into bidang_projek(bidang,projek) values ('".$id_check."','".$idupdate."') ";
	$result = mysql_query($sql);

}

function check_kontrak(){
	
	$kontrak1 = $_GET["kontrak1"];
	$kontrak2 = $_GET["kontrak2"];
	$kontrak3 = $_GET["kontrak3"];
	
	
	if($kontrak1!="" && $kontrak2!="" && $kontrak3!=""){
		
		$sql = "select * from project where seq_category = '" .$_GET["kontrak1"]. "' and seq = " .$_GET["kontrak2"]." and seq_year = " .$_GET["kontrak3"];
		$result = mysql_query($sql);
		$row = mysql_num_rows($result);		
		
		echo $row;
		
	}else{
		
		echo "";	
	}	
}

function update_projek(){
	
	$pen_pegawai_pro = $_GET['pen_pegawai_pro'];
	$juruteknik = $_GET['juruteknik'];
	$no_peruntukan = $_GET['no_peruntukan'];
	$idPro = $_GET['idPro'];	
	$per_badget=$_GET['per_badget'];
	$sql = "update project set pen_pegawai_projek = '".$pen_pegawai_pro."', ptbk = '".$juruteknik."',no_peruntukan = '".$no_peruntukan."', per_badget = '".$per_badget."' where project_id = ".$idPro;
	mysql_query($sql);
}

function plot_Input(){
	$id = $_GET['pid'];
	$type__input = $_GET['type__input'];
	
	if($type__input == 1){
		$pen_pp = process_sql("select * from project where project_id = ".$id,"pen_pegawai_projek");
		echo "<input name='pen_pegawai_pro' id='pen_pegawai_pro' type='text' value='".$pen_pp."' size='40' onblur='update_projek(".$id.")'/>";	
	}
	if($type__input == 2){
		$ptbk = process_sql("select * from project where project_id = ".$id,"ptbk");
		echo "<input name='juruteknik' id='juruteknik' type='text' value='".$ptbk."' size='40' onblur='update_projek(".$id.")'/>";	
	}
	if($type__input == 3){
		$no_peruntukan = process_sql("select * from project where project_id = ".$id,"no_peruntukan");
		echo "<input name='no_peruntukan' id='no_peruntukan' type='text' value='".$no_peruntukan."' size='40' onblur='update_projek(".$id.")'/>";	
	}
	if($type__input == 4){
		$per_badget = process_sql("select * from project where project_id = ".$id,"per_badget");
		echo '<select id="perBadget" name="perBadget" onchange="update_projek('.$id.')">';
		echo '<option value="">--Please Select--</option>';
		for($i = date('Y');$i>=2010;$i--){
			if($per_badget==$i){
				echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			}else{
				echo '<option value="'.$i.'">'.$i.'</option>';			
			}
		}
		echo '</select>';
		//echo "<input name='no_peruntukan' id='no_peruntukan' type='text' value='".$per_badget."' size='40' onblur='update_projek(".$id.")'/>";	
	}
}

function checkKon_Pe(){
	$val = $_GET['value'];
	$type = $_GET['type'];
	
	if($type=="perunding"){
		$check = process_sql("select contractor_regno from contractor where perunding = 1 and contractor_regno = '".$val."'","contractor_regno");	
	}
	elseif($type=="kontraktor"){
		$check = process_sql("select contractor_regno from contractor where perunding = 0 and contractor_regno = '".$val."'","contractor_regno");		
	}
	
	if($check <> ""){
		echo "1";	
	}else{
		echo "0";	
	}	
}

function calPrestasiKon(){
	//$for = $_GET['for'];
	$dpid = $_GET['dpid'];
	$type = $_GET['type'];
	$pid = $_GET['pid'];
	
	$sql = "select * from data_project where data_project_id = ".$dpid;
	$sqlresult = mysql_query($sql);
	while($row = mysql_fetch_array($sqlresult)){
		$seq = $row["seq"];
		$tahun = $row["tahun"];
	}
	
	if($seq<>1){
		$seq2 = $seq-1;
		$prestasiPrev = process_sql("select kemajuan_fizikal from data_project where project_id= ".$pid." and seq =".$seq2,"kemajuan_fizikal");	
	}else{
		$prestasiPrev = 100;	
	}
	$prestariCur = process_sql("select kemajuan_kewangan_bln from data_project where project_id= ".$pid." and seq =".$seq,"kemajuan_kewangan_bln");
	$prestariDeduct = 100 - $prestariCur;
	
	if ($prestariDeduct==0){
		$prestasi = 100;
	}else{
		$prestasi = $prestasiPrev - $prestariDeduct;
		if($prestasi<0){
			$prestasi = 0;	
		}
	}
	$sqls = "update data_project set kemajuan_fizikal = ".$prestasi." where data_project_id = ".$dpid;
	$result = mysql_query($sqls);

	echo "<input type='hidden' name='fizikal' id='fizikal' value='".$prestasi."' style='width:40px; text-align:center;' onkeyup='checknumberpercent(this)'><b>".$prestasi."&nbsp;%</b>";
}

function aktif_batal(){
	$id = $_GET['idupdate'];
	$sql = "select * from project_dirancang where project_id =".$id;
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$proName = $row['project_name'];
		$statProject = $row['statusPDirancang'];
		$statProject2 = ($row['statusPDirancang']==1)?"Aktif":"Batal";	
	}
	?>
		<table width='100%' border='1' bordercolor='#FFFFFF' bordercolorlight='#CCCCCC' cellpadding='5' cellspacing='0'>
        	<tr height="150px">
            	<td colspan="2" align="center" background="images/blue-bar.png" class="Color-Header">Kemaskini Status Projek Dirancang</td>
            </tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>

            <tr>
            	<td><b>Projek Id</b></td>
                <td><?=$id?></td>
            </tr>
            <tr>
            	<td valign="top"><b>Nama Projek</b></td>
                <td><div style="width:350px; height:100px; border:0 red solid; overflow-y:auto;"><?=$proName?></div></td>
            </tr>
            <tr>
            	<td><b>Status Projek</b></td>
                <td><b><?=$statProject2?></b></td>
            </tr>
            <tr>
            	<td><b>Kemaskini Status</b></td>
                <td><input type="radio" value="1" <?=radio_checked($statProject,1)?> name="stat"/>&nbsp;Aktif&nbsp;&nbsp;&nbsp;<input type="radio" value="0" <?=radio_checked($statProject,0)?> name="stat"/>&nbsp;Batal</td>
            </tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="2" align="Right"><input type="button" value="Update" onclick="updateStatPD(<?=$id?>)"/>&nbsp;<input type="button" value="Cancel" onclick="tutup()"/></td>
            </tr>
        </table>
	<?		
}

function updateStatPD(){
	$id = $_GET['idupdate'];
	$statval = $_GET['StatPD'];
	$sql = "update project_dirancang set statusPDirancang = ".$statval." where project_id = ".$id;
	mysql_query($sql);	 
	
	$val = ($statval==1)?"Aktif":"Batal";
	echo $val."|".$id;
}

function deleteImage(){
	$idImage = $_GET['idImage'];
	process_sql2("delete from project_image where pi_id =".$idImage);
}
function viewImej(){
	$projectId = $_GET['projectId'];
?>
	<table border="1" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:5px; width:100%; border:#999999 1px solid;">
    	<tr class="color-header1" height="40px">
            <td align="center">No.</td>
            <td align="center">Imej</td>
            <td align="center">Tajuk</td>
            <td align="center">Date</td>
        </tr>
        <?	$i = 0;
        $sql = "Select * from project_image where project_id = ".$projectId;
    
        $result = mysql_query($sql);
		$rowNum = mysql_num_rows($result);
		if($rowNum<>0){
			while($row = mysql_fetch_array($result)){
			$i++
			?>	
            	<tr>
                	<td width="8%" align="center"><b><?=$i?></b></td>
                    <td width="20%" align="center"><img src="kemasukandata/attachment/<?=$projectId?>/<?=$row['attachID']?>.<?=$row['extAttach']?>" height="42" width="42" onmouseover="zoomImg(<?=$row['pi_id']?>)" onmouseout="zoomImg2(<?=$row['pi_id']?>)"/>
                    </td>
                    <div id='img_<?=$row['pi_id']?>' style='border:3px solid #FF8000;background-color:#ffffff; display:none; position:absolute; height:300px; width:350px; float:left; left:300; text-align:center;'><img src="kemasukandata/attachment/<?=$projectId?>/<?=$row['attachID']?>.<?=$row['extAttach']?>" height="300" width="350"/></div>
                    <td><?=$row['tajuk']?></td>
                    <td width="20%" align="center"><?=date("d-m-Y",strtotime($row['date']))?></td>
                </tr>
			<?	
			}
		}else{
			?>
            	<tr>
                	<td colspan="4" align="center">Tiada Rekod</td>
                </tr>
			<?
		}
    ?>
    </table>
<?
}
//shahrul end
function includediv(){
	
         	$strXML = "<graph caption='Statistik Bilangan Projek' subCaption='Mengikut Tahun' showNames='1' decimalPrecision='0'>";

			$strQuery = "select count(*) as cnt, YEAR(date_start) as yr FROM project GROUP BY YEAR(date_start)";
	
			$result = mysql_query($strQuery) or die(mysql_error());
			if ($result) {
				while($ors = mysql_fetch_array($result)) {     
					$strXML .= "<set name='" . $ors['yr'] . "' value='" . $ors['cnt'] . "' />";
				}
			}
		//mysql_close($link);
			$strXML .= "</graph>";
			echo renderChartHTML("MyFCPHPClassCharts/FusionCharts/FCF_Pie2D.swf", "", $strXML, "AnalisaProjek", 400, 450);
			

	
	}

function getReport34() {
	$jenisKontraktor = $_GET["jenisKontraktor"];	
	if($jenisKontraktor!="")
	{
		$sql = "SELECT * from contractor WHERE perunding = '".$jenisKontraktor."' order by contractor_name";
		$result = mysql_query($sql);
		$x = mysql_num_rows($result);
	?>
	<select name="selKontraktor">
		<option value="">--Semua--</option>
		<?php 
		while($rowStatus = mysql_fetch_array($result)){
			?>			
			<option value="<?php echo $rowStatus[0]?>"><?php echo $rowStatus[9]?></option>
		   <?php
		}	
		?>
</select>
		<?php }
		}
function getReport() {
		$jenisKontraktor = $_GET["jenisKontraktor"];
		if($jenisKontraktor<>''){
			?>
			<input style="color:#999999" type="text" autocomplete="off" name="selKontraktor" id="selKontraktor" value2="" value="Masukkan nama Kontraktor / Perunding jika ada" size="50" onkeyup="selectKon_Pen(this)" onfocus="javascript:document.getElementById(this.id).value=''" onclick="javascript:document.getElementById(this.id).style.color='black'"><br>
			<span id="laporan2" style="overflow-Y:scroll; padding:5; max-height:200px; height:200px; display:none; width:275px; position:absolute; z-index:9999999999999;background-color:#FFFFFF; border:solid #000 thin; left:120px;" onclick="closespan()">
	
			</span>
			<?
		}
}

function getReport2() {
	$jenisKontraktor = $_GET["jenisKontraktor"];
	$selKontraktor = $_GET["selKontraktor"];	
	if($jenisKontraktor!="")
	{
		$sql = "SELECT * from contractor WHERE perunding = '".$jenisKontraktor."' and contractor_name like '".$selKontraktor."%' order by contractor_name";
		$result = mysql_query($sql);
		$x = mysql_num_rows($result);
		
		if($x <> 0){		
			while($rowStatus = mysql_fetch_array($result)){
				?><input type="hidden" id="nameVal_<?=$rowStatus[0]?>" name="nameVal_<?=$rowStatus[0]?>" value="<?=$rowStatus[9]?>"/><a onclick="setvalueKonPe('<?=$rowStatus[0]?>')" style='cursor:pointer'><font color='#000000'><?=$rowStatus[9]?></font></a><br><?
			}
		}else{
			?><input type="hidden" id="nameVal_0" name="nameVal_0" value="TIADA REKOD"/><a onclick="setvalueKonPe('0')" style='cursor:pointer'><font color='#000000'>TIADA REKOD</font></a><br><?
		}
	}
}			
function getCriteria() {
		$criteria = $_GET["criteria"];
		if($criteria<>''){
			if($criteria == 0){
				?>
				<input style="color:#999999" type="text" autocomplete="off" name="criteria2" id="criteria2" value2="" value="Masukkan nama Syarikat" size="50" onkeyup="findCriteria(this,<?=$criteria?>)" onfocus="javascript:document.getElementById(this.id).value=''" onclick="javascript:document.getElementById(this.id).style.color='black'"><br>
				<span id="laporan2" style="overflow-Y:scroll; padding:5; max-height:200px; height:200px; display:none; width:275px; position:absolute; z-index:9999999999999;background-color:#FFFFFF; border:solid #000 thin; left:120px;" onclick="closespan()">		
				</span>
				<?
			}
			elseif($criteria == 1){
				?>
				<input style="color:#999999" type="text" autocomplete="off" name="criteria2" id="criteria2" value2="" value="No. Pendaftaran Syarikat" size="50" onkeyup="findCriteria(this,<?=$criteria?>)" onfocus="javascript:document.getElementById(this.id).value=''" onclick="javascript:document.getElementById(this.id).style.color='black'"><br>
				<span id="laporan2" style="overflow-Y:scroll; padding:5; max-height:200px; height:200px; display:none; width:275px; position:absolute; z-index:9999999999999;background-color:#FFFFFF; border:solid #000 thin; left:120px;" onclick="closespan()">		
				</span>
				<?
			}
			elseif($criteria == 2){
				?>
				<input style="color:#999999" type="text" autocomplete="off" name="criteria2" id="criteria2" value2="" value="Masukkan nama Pemilik Syarikat" size="50" onkeyup="findCriteria(this,<?=$criteria?>)" onfocus="javascript:document.getElementById(this.id).value=''" onclick="javascript:document.getElementById(this.id).style.color='black'"><br>
				<span id="laporan2" style="overflow-Y:scroll; padding:5; max-height:200px; height:200px; display:none; width:275px; position:absolute; z-index:9999999999999;background-color:#FFFFFF; border:solid #000 thin; left:120px;" onclick="closespan()">		
				</span>
				<?
			}
			elseif($criteria == 3){
				?>
				<input style="color:#999999" type="text" autocomplete="off" name="criteria2" id="criteria2" value2="" value="Masukkan No. Kad Pengenalan Pemilik Syarikat" size="50" onkeyup="findCriteria(this,<?=$criteria?>)" onfocus="javascript:document.getElementById(this.id).value=''" onclick="javascript:document.getElementById(this.id).style.color='black'"><br>
				<span id="laporan2" style="overflow-Y:scroll; padding:5; max-height:200px; height:200px; display:none; width:275px; position:absolute; z-index:9999999999999;background-color:#FFFFFF; border:solid #000 thin; left:120px;" onclick="closespan()">		
				</span>
				<?
			}
		}
}

function getCriteria2() {
	$criteria = $_GET["criteria"];
	$criteria2 = $_GET["criteria2"];	
	if($criteria!="")
	{
		if($criteria == 0){
			$sql = "SELECT * from contractor WHERE contractor_name like '".$criteria2."%' order by contractor_name";
			$result = mysql_query($sql);
			$x = mysql_num_rows($result);
			if($x <> 0){		
				while($rowStatus = mysql_fetch_array($result)){
					?><input type="hidden" id="nameVal_<?=$rowStatus[0]?>" name="nameVal_<?=$rowStatus[0]?>" value="<?=$rowStatus[9]?>"/><a onclick="setvalueCriteria('<?=$rowStatus[0]?>')" style='cursor:pointer'><font color='#000000'><?=$rowStatus[9]?></font></a><br><?
				}
			}else{
				?><input type="hidden" id="nameVal_0" name="nameVal_0" value="TIADA REKOD"/><a onclick="setvalueCriteria('0')" style='cursor:pointer'><font color='#000000'>TIADA REKOD</font></a><br><?
			}		
		}elseif($criteria == 1){
			$sql = "SELECT * from contractor WHERE contractor_regno like '".$criteria2."%' order by contractor_regno";
			$result = mysql_query($sql);
			$x = mysql_num_rows($result);
			if($x <> 0){		
				while($rowStatus = mysql_fetch_array($result)){
					?><input type="hidden" id="nameVal_<?=$rowStatus[0]?>" name="nameVal_<?=$rowStatus[0]?>" value="<?=$rowStatus[1]?>"/><a onclick="setvalueCriteria('<?=$rowStatus[0]?>')" style='cursor:pointer'><font color='#000000'><?=$rowStatus[1]?></font></a><br><?
				}
			}else{
				?><input type="hidden" id="nameVal_0" name="nameVal_0" value="TIADA REKOD"/><a onclick="setvalueCriteria('0')" style='cursor:pointer'><font color='#000000'>TIADA REKOD</font></a><br><?
			}		
		}elseif($criteria == 2){
			$sql = "SELECT distinct(owner_name) from owner WHERE owner_name like '".$criteria2."%' order by owner_name";
			$result = mysql_query($sql);
			$x = mysql_num_rows($result);
			if($x <> 0){		
				while($rowStatus = mysql_fetch_array($result)){
					?><input type="hidden" id="nameVal_<?=$rowStatus[0]?>" name="nameVal_<?=$rowStatus[0]?>" value="<?=$rowStatus[0]?>"/><a onclick="setvalueCriteria('<?=$rowStatus[0]?>')" style='cursor:pointer'><font color='#000000'><?=$rowStatus[0]?></font></a><br><?
				}
			}else{
				?><input type="hidden" id="nameVal_0" name="nameVal_0" value="TIADA REKOD"/><a onclick="setvalueCriteria('0')" style='cursor:pointer'><font color='#000000'>TIADA REKOD</font></a><br><?
			}		
		}elseif($criteria == 3){
			$sql = "SELECT distinct(no_ic) from owner WHERE no_ic like '".$criteria2."%' order by no_ic";
			$result = mysql_query($sql);
			$x = mysql_num_rows($result);	
			if($x <> 0){		
				while($rowStatus = mysql_fetch_array($result)){
					?><input type="hidden" id="nameVal_<?=$rowStatus[0]?>" name="nameVal_<?=$rowStatus[0]?>" value="<?=$rowStatus[0]?>"/><a onclick="setvalueCriteria('<?=$rowStatus[0]?>')" style='cursor:pointer'><font color='#000000'><?=$rowStatus[0]?></font></a><br><?
				}
			}else{
				?><input type="hidden" id="nameVal_0" name="nameVal_0" value="TIADA REKOD"/><a onclick="setvalueCriteria('0')" style='cursor:pointer'><font color='#000000'>TIADA REKOD</font></a><br><?
			}	
		}
	}
}	
//Nurul Punye
function getData(){
	$namaProjek = $_GET["namaProjek"];	
	$jenisKontraktor = $_GET["jenisKontraktor"];
	if($jenisKontraktor!="")
	{
		$selKontraktor = $_GET["selKontraktor"];
	}
	$selBumi = $_GET['selBumi'];
	$jabatan = $_GET['selJabatan'];
	$kategori = $_GET['selKategori'];
	$jenis = $_GET['selJenis'];
	$dari = $_GET['dari'];
	$ke = $_GET['ke'];	
	$from = $_GET['from'];
	$to = $_GET['to'];	
	$selStatus = $_GET['selStatus'];
	$kawasan = $_GET['kawasan'];
	$no_peruntukan = $_GET['no_peruntukan'];
	include '../Report/ProjectReport.php';
}

function getDataDirancang(){
	$namaProjek = $_GET["namaProjek"];	
	$jabatan = $_GET['selJabatan'];
	$kategori = $_GET['selKategori'];
	$jenis = $_GET['selJenis'];
	$dari = $_GET['dari'];
	$ke = $_GET['ke'];	
	$from = $_GET['from'];
	$to = $_GET['to'];	
	$kawasan = $_GET['kawasan'];
	$no_peruntukan = $_GET['no_peruntukan'];
	$selStatusD = $_GET['selStatusD'];
	include '../Report/ProjectReportDirancang.php';
}

function getDataRingkasan(){	
	include '../Report/ProjectReportRingkasan.php';
}

function getRingkasan(){	
	include '../Report/projekRingkasan.php';
}

function getDataKwsn(){
	$from = $_GET['from'];
	$to = $_GET['to'];	
	$kawasan = $_GET['kawasan'];
	$proDirancang = $_GET['proDirancang'];
	include '../Report/ProjectReportKwsn.php';
}

function getKontraktor(){
	$criteria = $_GET['criteria'];
	if($criteria!="")
	{
		$criteria2 = $_GET["criteria2"];
	}
	$bumi = $_GET['selBumi'];
	$jabatan = $_GET['selJabatan'];	
	$status = $_GET['selSenarai'];	
	include '../Report/ResultKontraktor.php';
}

function getWang(){
	$jenisKontraktor = $_GET['jenisKontraktor'];
	if($jenisKontraktor!="")
	{
		$selKontraktor = $_GET["selKontraktor"];
	}
	$dari = $_GET['from'];
	$ke = $_GET['to'];	
	$jabatan = $_GET['selJabatan'];	
	$jenis = $_GET['selJenis'];
	include '../Report/ResultKewangan.php';	  
}

function getAnalisis()
{
	$jabatan = $_GET['selJabatan'];	
	$tahun = $_GET['selTahun'];	
	include '../Report/GrafAnalisis.php';
}

//syed 27062012 start

function projectList() {
	$jab = $_GET["jab"];
	
	$sql="select * from project where department_id = '".$jab."' order by project_id";
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	
	if ($cnt!=0) {
		?>&nbsp;<select name="referen" id="referen" onchange="updateName()"><?
		//if ($cnt>1) {
			?><option value="0">--Sila Pilih--</option><?
		//}
	
		while($row = mysql_fetch_array($result)) {
			if ($_SESSION['selRef']!="") { $currPost = $_SESSION["selRef"]; } else { $currPost = ""; }
			if ($row['project_id']==$currPost) { $sel="selected"; } else { $sel=""; }
		?>
			<option value=<?=$row['project_id']?> <?=$sel?>><?=$row['project_reference']?></option>
		<?
		}
		?>
		</select>
		<select name="project_name" id="project_name" onchange="updateRef()" style="width:70%;">
		<? 
			$sql="select * from project where department_id = '".$jab."' order by project_id";
			$result = mysql_query($sql);
			//if ($cnt>1) {
				?><option value="0">--Sila Pilih--</option><?
			//}
		while($row = mysql_fetch_array($result)) {
			if ($_SESSION['selRef']!="") { $currPost = $_SESSION["selRef"]; } else { $currPost = ""; }
			if ($row['project_id']==$currPost) { $sel="selected"; } else { $sel=""; }
		?>
			<option value=<?=$row['project_id']?> <?=$sel?>><?=$row['project_name']?></option>
		<?
		}
		?>
		</select>
	<?
	} else {
		echo "&nbsp;Jabatan/Bahagian tiada Projek.";
	}
}

function projectData() {
	$pid = $_GET["pid"];
	$dept = $_GET["dept"];
	$_SESSION['selRef']=$pid;
	$_SESSION['selDept']=$dept;
	
	include '../kemasukandata/progress_result.php';
}

function uploadImage() {
	$pid = $_GET["pid"];
	$dept = $_GET["dept"];
	$_SESSION['selRef']=$pid;
	$_SESSION['selDept']=$dept;
	
	include '../kemasukandata/upload.php';
}

function addDataPayment() {
	$pid = $_GET["pid"];
	$dpid = $_GET["dpid"];
	$date_pay = $_GET["date_pay"];
	$amount = $_GET["amount"];
	$invois = $_GET["invois"];
	$type = $_GET["type"];
	$seqThn = $_GET["seqThn"];
	$prjCat = process_sql("select project_category_id from project where project_id =".$pid,"project_category_id");
	
	$date_payArr = explode("/",$date_pay);
	$date_pay = $date_payArr[2]."-".$date_payArr[1]."-".$date_payArr[0];
	
	if($type==1){
		$typePay = 1;
		
		$sqlChk = "select sum(amount) as tot from data_payment where project_id=" .$pid." and jenis_bayaran = ".$typePay;
		$totPay = process_sql($sqlChk,"tot");
		$totPay = $totPay+$amount;
	
		$getCost = getCost($pid,$dpid,$typePay,$seqThn);
	}
	if($type==2){
		$typePay = 2;
		
		$sqlChk = "select sum(amount) as tot from data_payment where project_id=" .$pid." and jenis_bayaran = ".$typePay." and data_project_id = ".$dpid;
		$totPay = process_sql($sqlChk,"tot");
		$totPay = $totPay+$amount;
	
		$getCost = getCost($pid,$dpid,$typePay);
	}
	if($type==3){
		$typePay = 3;
		
		$sqlChk = "select sum(amount) as tot from data_payment where project_id=" .$pid." and jenis_bayaran = ".$typePay." and seq_Thn = ".$seqThn;
		$totPay = process_sql($sqlChk,"tot");
		$totPay = $totPay+$amount;
	
		$getCost = getCost($pid,$dpid,$typePay);
		
	}
	
	//if($type==2){		
	//		$sqlIns = "insert into data_payment(data_project_id,project_id,date_pay,date_add,amount,user_id,jenis_bayaran,seq_Thn) values(".$dpid.",".$pid.",'".$date_pay."',now(),".$amount.",".$_SESSION['id'].",".$typePay.",".$seqThn.")";
	//		$resIns = mysql_query($sqlIns);
			
	//		calcPaymentPercentage($pid,$typePay,$dpid);
	//		echo $pid."^".$dpid."^1^".$typePay."^".$seqThn."^".$prjCat ;
	//}else{
		if ($totPay<=$getCost) {
			$sqlIns = "insert into data_payment(data_project_id,project_id,date_pay,date_add,amount,user_id,jenis_bayaran,seq_Thn,invois) values(".$dpid.",".$pid.",'".$date_pay."',now(),".$amount.",".$_SESSION['id'].",".$typePay.",".$seqThn.",'".$invois."')";
			$resIns = mysql_query($sqlIns);
			//echo $sqlIns;
			calcPaymentPercentage($pid,$typePay,$dpid);
			echo $pid."^".$dpid."^1^".$typePay."^".$seqThn."^".$prjCat ;
		} else {
			echo $pid."^".$dpid."^2^".$typePay."^".$seqThn."^".$prjCat ;
		}
	//}

}

function deleteDataPayment() {
	$pid = $_GET["pid"];
	$dpid = $_GET["dpid"];
	$dpayid = $_GET["dpayid"];
	$typePay = $_GET["type"];
	$seqThn = $_GET["seqThn"];
	
	$sqlIns = "delete from data_payment where data_project_id=".$dpid." and project_id=".$pid." and data_payment_id=".$dpayid;
	$resIns = mysql_query($sqlIns);
	
	calcPaymentPercentage($pid,$typePay,$dpid);
			
	echo  $pid."^".$dpid."^1^".$typePay."^1^".$seqThn;
}

function loadDataPayment() {
	$seqThn = $_GET["seqThn"];
	$dpid = $_GET["dpid"];
	$sql = "select * from data_payment where data_project_id=".$dpid." order by date_pay desc";
	$res = mysql_query($sql);
	$cnt = mysql_num_rows($res);
	$noCnt=0;
	echo "<div style='border:1px #999999 solid; height:100%; border-bottom:0px; border-top:0px;'>";
		echo "<table width='100%' border='0' cellpadding='5' cellspacing='0' style='padding:2px; width:100%; border:#999999 0px solid;'>";
		if ($cnt!=0) {
			while($row = mysql_fetch_array($res)) {
				$noCnt++;
				if($noCnt%2==0) {
					$col="#CCCCCC";
				} else {
					$col="";
				}
				
									
				$data_payment_id = $row['data_payment_id'];
				$pid = $row['project_id'];
				$amount = $row['amount'];
				$date_pay = $row['date_pay'];
				$user_id = $row['user_id'];
				$invois = $row['invois'];
				$user_name = process_sql("select user_name from user where user_id=".$user_id,"user_name");
				$jenis_bayaran = $row['jenis_bayaran'];
										
				if($jenis_bayaran==1){
					$jenis_Byr = "Kesuluruhan";
				}
				if($jenis_bayaran==2){
					$jenis_Byr = "Bulanan";
				}
				if($jenis_bayaran==3){
					$jenis_Byr = "Tahunan";
				}
				$user_name = process_sql("select user_name from user where user_id=".$user_id,"user_name");
				echo "<tr style='background-color:".$col.";'><td align='center' width='4%'>".$noCnt."</td><td align='center' width='12%'>".date("d/m/Y",strtotime($date_pay))."</td><td align='center' width='14%'>".number_format($amount,2)."</td><td width='12%'>&nbsp;&nbsp;&nbsp;".$invois."</td><td width='19%'>&nbsp;&nbsp;&nbsp;".substr($user_name,0,15)."</td><td width='9%' style='font-size: 8px;'>".$jenis_Byr."</td><td align='center' width='7%'><img src='images/x.png' width='10' style='cursor:pointer;' border='0' onclick='deleteAmount(".$pid.",".$dpid.",".$data_payment_id.",".$jenis_bayaran.",".$seqThn.")'></td></tr>";
			}
		} else {
			echo "<tr><td align='center' colspan='4'>Tiada rekod.</td></tr>";
		}
		echo "</table>";
	echo "</div>";
}

function reloadPerc() {
	$pid = $_GET["pid"];
	$dpid = $_GET["dpid"];
	$sql = "select kemajuan_kewangan from data_project where project_id=".$pid." and data_project_id=".$dpid;
	echo number_format(process_sql($sql,"kemajuan_kewangan"),2);
}

function reloadTotalPerc() {
	
	$pid = $_GET["pid"];
	$type = $_GET["type"];
	$dpid = $_GET["dpid"];
	$seqThn = $_GET["seqThn"];
	
	//echo $pid.">>".$type.">>".$dpid.">>".$seqThn;
	if ($type == 1){
		$sql = "select sum(kemajuan_kewangan) as kemajuan_kewangan from data_project where project_id=".$pid;
		echo number_format(process_sql($sql,"kemajuan_kewangan"),2)." %";
	}
	if ($type == 2){
		$sql = "select kemajuan_kewangan_bln as kemajuan_kewangan from data_project where data_project_id=".$dpid;
		echo number_format(process_sql($sql,"kemajuan_kewangan"),2)." %";
	}
	if ($type == 3){
		$sql = "select sum(kemajuan_kewangan_thn) as kemajuan_kewangan from data_project where project_id=".$pid." and seqThn = ".$seqThn;
		echo number_format(process_sql($sql,"kemajuan_kewangan"),2)." %";
	}
	
}

function getPerc($pid,$dpid) {
	$sql = "select kemajuan_kewangan from data_project where project_id=".$pid." and data_project_id=".$dpid;
	$perc = process_sql($sql,"kemajuan_kewangan");
	return number_format($perc,2);
}

function getTotalPerc($pid,$dpid,$typePay,$seqThn) {
	
	if($typePay == 1){
		$kemajuan_kewangan = "kemajuan_kewangan";	
		$sql = "select sum(".$kemajuan_kewangan.") as ".$kemajuan_kewangan." from data_project where project_id=".$pid;
	}
	if($typePay == 2){
		$kemajuan_kewangan = "kemajuan_kewangan_bln";
		$sql = "select ".$kemajuan_kewangan." from data_project where data_project_id=".$dpid;	
	}
	if($typePay == 3){
		$kemajuan_kewangan = "kemajuan_kewangan_thn";
		$sql = "select sum(".$kemajuan_kewangan.") as ".$kemajuan_kewangan." from data_project where project_id=".$pid." and seqThn = ".$seqThn;
	}
	//echo $sql;
	$perc = process_sql($sql,$kemajuan_kewangan);
	return number_format($perc,2);
}

function reloadPayCost() {
	$pid = $_GET["pid"];
	$dpid = $_GET["dpid"];
	$type = $_GET["type"];
	$seqThn = $_GET["seqThn"];
	echo "RM ".number_format(getTotalPayment($pid,$dpid,$type,$seqThn),2)." / RM ".number_format(getCost($pid,$dpid,$type),2);
}

function calcPaymentPercentage($pid,$typePay,$dpid) {
	$pid = $_GET["pid"];
	$dpid = $_GET["dpid"];
	$totPayment = 0;
	$cost = 0;
	$perc = 0;
	
	//total cost
	$totPayment = getPayment($pid,$dpid,$typePay);
	
	//latest cost
	$cost = getCost($pid,$dpid,$typePay);
		
	//calculate percentage
	if ((intval($cost)!=0)&&(intval($totPayment)!=0)) {
		$perc=($totPayment/$cost)*100;
	}
	//keseluruhan
	if($typePay == 1){
		$kemajuan_kewangan = "kemajuan_kewangan";			
	}
	//bulanan
	if($typePay == 2){
		$kemajuan_kewangan = "kemajuan_kewangan_bln";			
	}
	//tahunan
	if($typePay == 3){
		$kemajuan_kewangan = "kemajuan_kewangan_thn";			
	}
	
	if ((intval($perc)<=100)&&(intval($perc)>=0)) {
		$perc = number_format($perc,2);
		$sqlUpd = "update data_project set ".$kemajuan_kewangan." = ".$perc." where project_id=".$pid." and data_project_id=".$dpid;
		process_sql2($sqlUpd);
		return $perc;
	} elseif (intval($perc)>100) {
		$sqlUpd = "update data_project set ".$kemajuan_kewangan." =".$perc." where project_id=".$pid." and data_project_id=".$dpid;
		process_sql2($sqlUpd);
		return $perc;
	} else {
		$sqlUpd = "update data_project set ".$kemajuan_kewangan." =".$perc." where project_id=".$pid." and data_project_id=".$dpid;
		process_sql2($sqlUpd);
		return 0;
	}
}

function getPayment($pid,$dpid,$typePay) {
	$sql="select sum(amount) as amount from data_payment where project_id=".$pid." and data_project_id=".$dpid." and jenis_bayaran=".$typePay;
	return process_sql($sql,"amount");
}

function getTotalPayment($pid,$dpid,$type,$seqThn) {
	if($type == 1){
		$sql="select sum(amount) as amount from data_payment where project_id=".$pid." and jenis_bayaran=".$type;;
		return process_sql($sql,"amount");		
	}
	if($type == 2){
		$sql="select sum(amount) as amount from data_payment where project_id=".$pid." and data_project_id=".$dpid." and jenis_bayaran=".$type;
		return process_sql($sql,"amount");		
	}
	if($type == 3){
		$sql="select sum(amount) as amount from data_payment where project_id=".$pid." and seq_thn=".$seqThn." and jenis_bayaran=".$type;
		return process_sql($sql,"amount");		
	}
}

function getCost($pid,$dpid,$typePay) {
	$cost=0;
	$sql="select cost from eoc where project_id=".$pid." and eoc_id=(select max(eoc_id) from eoc)";
	$cost = process_sql($sql,"cost");
	if (intval($cost)==0) {
		$cost = getOriginalCost($pid,$dpid,$typePay);
	}
	return intval($cost);
}

function getOriginalCost($pid,$dpid,$typePay) {
	//1 = keseluruhan
	//2 = bulan
	//3 = tahun
	
	if($typePay == 1){
		$sql="select project_cost from project where project_id=".$pid;
		return process_sql($sql,"project_cost");
	}
	if($typePay == 2){
		$sql="select project_cost_month from project where project_id=".$pid;
		return process_sql($sql,"project_cost_month");
	}
	if($typePay == 3){
		$sql="select project_cost_year from project where project_id=".$pid;
		return process_sql($sql,"project_cost_year");
	}
}

function getLatestCost($pid) {
	$sql="select cost from eoc where project_id=".$pid." order by date_add desc limit 1";
	return process_sql($sql,"cost");
}

function checkFizikal() {
	$pid = $_GET["pid"];
	$fizikal = $_GET["fizikal"];
	$fizikalDirancang = $_GET["fizikalDirancang"];
	$col = $_GET["columnnum"];
	$preKF=0;
	$postKF=0;
	
	$category = process_sql("select * from project where project_id = ".$pid,"project_category_id");
	
	$sql = "select kemajuan_fizikal from data_project where project_id=".$pid." and seq<".$col." and kemajuan_fizikal<>'' order by kemajuan_fizikal desc limit 1";
	$preKF = process_sql($sql,"kemajuan_fizikal");
	
	$sql2 = "select kemajuan_fizikal from data_project where project_id=".$pid." and seq>".$col." and kemajuan_fizikal<>'' order by kemajuan_fizikal asc limit 1";
	$postKF = process_sql($sql2,"kemajuan_fizikal");
	
	//$sqlDirancg = "select kemajuan_dirancang from data_project where project_id=".$pid." and seq<".$col." and kemajuan_dirancang<>'' order by kemajuan_dirancang desc limit 1";
	//$preKFDirancg = process_sql($sql,"kemajuan_dirancang");
	
	//$sql2Dirancg = "select kemajuan_dirancang from data_project where project_id=".$pid." and seq>".$col." and kemajuan_dirancang<>'' order by kemajuan_dirancang asc limit 1";
	//$postKFDirancg = process_sql($sql2,"kemajuan_dirancang");
	
	if(($category==0) || ($category==1)){	
		if ($fizikal!=0) {
			if (($fizikal>$preKF)&&($fizikal<$postKF)) {
				//ok
				echo "1^".$preKF;
			} elseif ($fizikal<$preKF) {
				//smaller
				echo "2^".$preKF;
			} elseif ($fizikal==$preKF) {
				//equals to
				echo "3^".$preKF;
			} elseif ($fizikal==$postKF) {
				//equals to
				echo "4^".$postKF;
			} elseif ($fizikal>$postKF) {
				if ($postKF!=0) {
					//bigger
					echo "5^".$postKF;
				} else {
					echo "1^".$postKF;
				}
			}
			
		} else {
			echo "6^".$preKF;
		}
	}else{
		echo "1^".$preKF;	
	}
	
}

function addEot() {
	$pid = $_GET["pid"];
	$date_eot = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$_GET["date_eot"]);
	$date_now = date('Y-m-d',strtotime('now'));
	if (($pid!="")&&($date_eot!="")) {
		$sql = "insert into eot(project_id,date_eot,date_add,user_id) values(".$pid.",'".$date_eot."','".$date_now."',".$_SESSION['id'].")";
		process_sql2($sql);
	}
	echo $pid;
}

function reloadEot() {
	$pid = $_GET["pid"];
	echo "<table width='100%' border='0' cellpadding='5' cellspacing='0'>";
		$sqlEOT = "select * from eot where project_id=".$pid." order by date_eot";
		$resEOT = mysql_query($sqlEOT);
		$eotCnt=0;
		while($rowEOT = mysql_fetch_array($resEOT)) {
			$eotCnt++;
			if ($eotCnt%2==0) {
				$col="lightgray";
			} else {
				$col="";
			}
			$date_eot = $rowEOT['date_eot'];
			?>
				<tr style='background-color:<?=$col?>;'><td width='30%'>Lanjutan Masa <?=$eotCnt?></td><td width='50%'><?=date("d/m/Y",strtotime($rowEOT['date_eot']))?></td><td width='20%' align="center"><img src='images/x.png' width='10' style='cursor:pointer;' border='0' onclick="deleteEot(<?=$pid?>,'<?=$rowEOT['date_eot']?>')"></td></tr>
			<?
		}
	echo "</table>";
	$sqldate_eot = "select max(date_eot) from eot where project_id =".$pid;
	$resultdate_eot = mysql_query($sqldate_eot);
	$rowdate_eot = mysql_fetch_array($resultdate_eot);	
	
	$sqldate_eot2 = "update project set eot = '".$rowdate_eot[0]."' where project_id =".$pid;
	mysql_query($sqldate_eot2);
}

function deleteEot() {
	$pid = $_GET["pid"];
	$date_eot = $_GET["date_eot"];
	$sqlDel = "delete from eot where project_id=".$pid." and date_eot='".$date_eot."'";
	process_sql2($sqlDel);
	echo $pid;
}

function addEoc() {
	$pid = $_GET["pid"];
	$amount_eoc = str_replace(',','',$_GET["amount_eoc"]);
	$date_eoc = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$_GET["date_eoc"]);
	$date_now = date('Y-m-d',strtotime('now'));
	
	if (($pid!="")&&($amount_eoc!="")&&($date_eoc!="")) {
		$sql = "select * from eoc where project_id=".$pid;
		$res = mysql_query($sql);
		$small = 0;
		//while($row = mysql_fetch_array($res)) {
			//if ($amount_eoc<$row['cost']) {
			//	$small=1;
			//}
		//}
		$cost = process_sql("select project_cost from project where project_id=".$pid,"project_cost");
		
		//if (($small==0)&&($amount_eoc>$cost)) {
//			$sql = "insert into eoc(project_id,cost,date_eoc,date_add,user_id) values(".$pid.",".$amount_eoc.",'".$date_eoc."','".$date_now."',".$_SESSION['id'].")";
//			process_sql2($sql);
//		}
		//shahrul 18-12-12 ---
		if (($small==0)) {
			$sql = "insert into eoc(project_id,cost,date_eoc,date_add,user_id) values(".$pid.",".$amount_eoc.",'".$date_eoc."','".$date_now."',".$_SESSION['id'].")";
			process_sql2($sql);
		}
		//--- shahrul
	}
	
	//if ($amount_eoc<$cost) {
//		echo $pid."^3";
//	} else {
//		if ($small==0) {
			echo $pid."^1";
//		} elseif ($small==1) {
//			echo $pid."^2";
//		} else {
//			echo $pid."^4";
//		}
//	}
	//shahrul 18-12-12 ---
	//echo $pid."^4";
	//--- shahrul
}

function reloadEoc() {
	$pid = $_GET["pid"];
	if (isset($_GET["status"])) {
		$status = $_GET["status"];
		if ($status==1) {
			$status="";
		} elseif ($status==2) {
			$status="Kos lanjutan tidak boleh kurang daripada kos lanjutan sebelum ini.";
		} elseif ($status==3) {
			$status="Kos lanjutan tidak boleh kurang daripada kos sebenar.";
		} else {
			$status="Error.";
		}
	}
	echo "<table width='100%' border='0' cellpadding='5' cellspacing='0'>";
	//echo "<tr><td colspan='4' align='center' style='background-color:red;'>".$pid."</td></tr>";
		$sqlEOC = "select * from eoc where project_id=".$pid." order by date_eoc";
		$resEOC = mysql_query($sqlEOC);
		$eocCnt=0;
		while($rowEOC = mysql_fetch_array($resEOC)) {
			$eocCnt++;
			if ($eocCnt%2==0) {
				$col="lightgray";
			} else {
				$col="";
			}
			$amount_eoc = $rowEOC['cost'];
			$date_eoc = $rowEOC['date_eoc'];
			?>
				<tr style='background-color:<?=$col?>;'>
                	<td width='25%'>Lanjutan Kos <?=$eocCnt?></td>
                    <td width='26%' align="center"><?=number_format($amount_eoc,2)?>
                    <td width='26%' align="center"><?=date("d/m/Y",strtotime($rowEOC['date_eoc']))?></td>
                    <td width='23%' align="center"><img src='images/x.png' width='10' style='cursor:pointer;' border='0' onclick="deleteEoc(<?=$pid?>,<?=$amount_eoc?>,'<?=$date_eoc?>')"></td>
				</tr>
			<?
		}
		if ((isset($status))&&($status!="")) {
			echo "<tr><td colspan='4' align='center' style='background-color:#FFFF8A;'>".$status."</td></tr>";
		}
	echo "</table>";
}

function deleteEoc() {
	$pid = $_GET["pid"];
	$amount_eoc = $_GET["amount_eoc"];
	$date_eoc = $_GET["date_eoc"];	
	$sqlDel = "delete from eoc where project_id=".$pid." and cost=".$amount_eoc." and date_eoc='".$date_eoc."'";
	process_sql2($sqlDel);	
	echo $pid;
}

function ContractorPerformance() {
	$pid = $_GET["pid"];
	$conid = $_GET["conid"];
	$scaleid = $_GET["scaleid"];
		
	$del = "delete from contractor_performance where project_id=".$pid;
	process_sql2($del);
	$ins = "insert into contractor_performance (project_id,contractor_id,scale_id) values(".$pid.",".$conid.",".$scaleid.")";
	process_sql2($ins);
}

function ContractorPerformanceRemove() {
	$pid = $_GET["pid"];
	$conid = $_GET["conid"];
	$scaleid = $_GET["scaleid"];
	$del = "delete from contractor_performance where project_id=".$pid;
	process_sql2($del);	
}

//syed 27062012 end

//athirah start
function emailAjax() {
	$userId = $_GET["userId"];
	
	if($userId==0){
		$email = "Tiada";	
	}else{
		$sql = "select * from user where user_id=".$userId;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$email = $row['user_email'];	
	}
	?>
    
	<input type="text" accept="check" name="email" id="email" size="40" value=<?=$email?> readonly="readonly" />
    
   <?php
}
function jawatanAjax() {
	$userId = $_GET["userId"];	
	
	if($userId==0){
		$jawatan = "Tiada";	
	}else{
		$sql = 	"select * from user u ".
			"inner join jawatan j on j.jawatan_id = u.user_jawatan_id ".
			"where u.user_id = " .$userId;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$jawatan = $row['jawatan_desc'];	
	}
	?>
    
	<input type="text" accept="check" name="jawatan_pprojek" id="jawatan_pprojek" size="40" value=<?=$jawatan?> readonly="readonly" />
    
   <?php
}
//athirah end 
?>