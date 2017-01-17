<?php

function urlEncrypt($string){
	$key = base64_encode('aufa123');
	$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	return urlencode($encrypted);
}

function urlDecrypt($string){
	$key = base64_encode('aufa123');
	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	return $decrypted;
}

function number_only($x){
	
	$y = preg_replace('/,/','',$x);	
	return $y;
	
}
function process_sql($sqls,$output){
	//echo $sqls."<br>";
	$result = mysql_query($sqls);								
	if($rows = mysql_fetch_array($result)){
		return $rows[$output];
	}							
}

function process_sql2($sqls){
	$result = mysql_query($sqls);
}
?>

<?php
function display($dept1,$sql1){
	
		$dept = $dept1;
    	$sql= $sql1;
		$result = mysql_query($sql1);
		
		//echo $sql;
		//echo $dept;
		?>
		
        
		<select name="no_kontrak" id="no_kontrak">
      <option value="0">--Sila Pilih--</option>
      <?php
	  	$_POST['no_kontrak']="";
		while($row = mysql_fetch_array($result))
   		{
			if ($_POST['no_kontrak']!="") {
				if ($_POST['no_kontrak']==$row['project_reference']) {
				?>
				<option value=<?=$row['project_reference']?> selected><?=$row['project_reference']?></option>
				php
				} else {
				?>
				<option value=<?=$row['project_reference']?>><?=$row['project_reference']?></option>
				<?php	
				}
			} else {
			?>
			<option value=<?=$row['project_reference']?>><?=$row['project_reference']?></option>
			<?php
			}
		
		}	
 			?>
    </select>
    <?php
}


function convertmonth($bulan) {
	
	if($bulan==1){
		$bulan = "Januari";
		}
	if($bulan==2){
		$bulan = "Februari";
		}
	if($bulan==3){
		$bulan = "Mac";
		}
	if($bulan==4){
		$bulan = "April";
		}
	if($bulan==5){
		$bulan = "Mei";
		}
	if($bulan==6){
		$bulan = "Jun";
		}
	if($bulan==7){
		$bulan = "Julai";
		}
	if($bulan==8){
		$bulan = "Ogos";
		}
	if($bulan==9){
		$bulan = "September";
		}
	if($bulan==10){
		$bulan = "Oktobor";
		}
	if($bulan==11){
		$bulan = "November";
		}
	if($bulan==12){
		$bulan = "Disember";
		}
	
	return $bulan;
	}


function convertmonth2($bulan) {
	
	if($bulan=="JAN"){
		$bulan = "01";
		}
	if($bulan=="FEB"){
		$bulan = "02";
		}
	if($bulan=="MAR"){
		$bulan = "03";
		}
	if($bulan=="APR"){
		$bulan = "04";
		}
	if($bulan=="MAY"){
		$bulan = "05";
		}
	if($bulan=="JUN"){
		$bulan = "06";
		}
	if($bulan=="JUL"){
		$bulan = "07";
		}
	if($bulan=="AUG"){
		$bulan = "08";
		}
	if($bulan=="SEP"){
		$bulan = "09";
		}
	if($bulan=="OCT"){
		$bulan = "10";
		}
	if($bulan=="NOV"){
		$bulan = "11";
		}
	if($bulan=="DEC"){
		$bulan = "12";
		}
	
	return $bulan;
	}
	
function replace($acute){
	
	$acute = str_replace("'","&apos;",$acute);
	$acute = str_replace("plustambah","+",$acute);
	$acute = str_replace("simboldan","&amp;",$acute);
	$acute = str_replace("simbolapos","&#039;",$acute);
	$acute = str_replace("dblquote","&quot;",$acute);
	return $acute;
	
}

function callDiffDate($mula,$tamat,$jenis) {
	
	//$mula = $_GET["mula"];
	//$tamat = $_GET["tamat"];
	
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
	
	if($jenis=="tahun"){
		return $years;		
	}
	if($jenis=="minggu"){
		return $weeks;		
	}
	if($jenis=="bulan"){
		return $months;		
	}
	if($jenis=="hari"){
		return $days;		
	}
}

function callDiffDate2($mula,$tamat,$jenis) {
	
	//$mula = $_GET["mula"];
	//$tamat = $_GET["tamat"];
	
	$date_mula = $mula;              // returns Saturday, January 30 10 02:06:34
	$timestamp_mula = strtotime($date_mula);
	$new_mula = date('Y-m-d', $timestamp_mula);   
	
	$date_tamat = $tamat;              // returns Saturday, January 30 10 02:06:34
	$timestamp_tamat = strtotime($date_tamat);
	$new_tamat = date('Y-m-d', $timestamp_tamat);   

	$diff = abs(strtotime($new_mula) - strtotime($date_tamat));

	$years = floor($diff / (365*60*60*24));
	$weeks = floor($diff / (60 * 60 * 24 * 7));
	$months = round(($diff) / (30*60*60*24));
	$days = floor(($diff)/ (60*60*24));
	
	if($jenis=="tahun"){
		return $years;		
	}
	if($jenis=="minggu"){
		return $weeks;		
	}
	if($jenis=="bulan"){
		return $months;		
	}
	if($jenis=="hari"){
		return $days;		
	}
}


function check($check){
	
	if($check == "0"){
	$check = "kadar Harga";
	return $check;  //becomes Hello-My-Friend
	}
	if($check != ""){
	return $check;  //becomes Hello-My-Friend
	}

}

function kelas_desc($x)
{
	
	if($x == "1")
	{
	 	$x = "A";	
	}	
	if($x == "2")
	{
		$x = "B";	
	}
	if($x == "3")
	{
		$x = "C";	
	}
	if($x == "4")
	{
		$x = "D";	
	}
	if($x == "5")
	{
		$x = "E";	
	}
	if($x == "6")
	{
		$x = "F";	
	}
	if($x == "7")
	{
		$x = "I";	
	}
	if($x == "8")
	{
		$x = "II";	
	}
	if($x == "9")
	{
		$x = "III";	
	}
	if($x == "10")
	{
		$x = "IV";	
	}
	if($x == "11")
	{
		$x = "G1&nbsp;(Kerja)";	
	}
	if($x == "12")
	{
		$x = "G2&nbsp;(Kerja)";	
	}
	if($x == "13")
	{
		$x = "G3&nbsp;(Kerja)";	
	}
	if($x == "14")
	{
		$x = "G4&nbsp;(Kerja)";	
	}
	if($x == "15")
	{
		$x = "G5&nbsp;(Kerja)";	
	}
	if($x == "16")
	{
		$x = "G6&nbsp;(Kerja)";	
	}
	if($x == "17")
	{
		$x = "G7&nbsp;(Kerja)";	
	}
	if($x == "18")
	{
		$x = "G1&nbsp;(Elektrik)";	
	}
	if($x == "19")
	{
		$x = "G2&nbsp;(Elektrik)";	
	}
	if($x == "20")
	{
		$x = "G3&nbsp;(Elektrik)";	
	}
	if($x == "21")
	{
		$x = "G4&nbsp;(Elektrik)";	
	}
	if($x == "22")
	{
		$x = "G5&nbsp;(Elektrik)";	
	}
	if($x == "23")
	{
		$x = "G6&nbsp;(Elektrik)";	
	}
	if($x == "25")
	{
		$x = "G7&nbsp;(Elektrik)";	
	}
	
	return $x;
	
}

function ya_tidak($x)
{
	
	if($x == "1")
	{
	 	$x = "Ya";	
	}	
	if($x == "0")
	{
		$x = "Tidak";	
	}
	return $x;	
}
function get_showAmount($pid,$jenis){		
		
		$kategori = process_sql("select project_category_id from project where project_id = ".$pid,"project_category_id");
		if($jenis=="kadar"){
			$valKadar = process_sql("select * from project where project_id = ".$pid,"kadar_harga");
			if($valKadar==0){
				return "none";
				//return "";
			}
		}else{
			if($kategori==3){
				if($jenis<>"project_cost_month"){
					return "none";
					//return "";
				}else{
					return "";	
				}	
					
			}else{
				$val = process_sql("select * from project where project_id = ".$pid,$jenis);
				if($val==0.00000){
					return "none";	
					//return "";	
				}else{
					return "";
				}
			}
			
		}

	
}

function check_type($val){
	if($val == ""){
		return 1;	
	}else{
		return 0;	
	}
	
}
// syed 27062012 start

function getDataDate($projek_id,$colno) {
	$date="";
	$sql = "select * from project where project_id =".$projek_id;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	$split = $row['project_duration'];
	if ($split=="") {
		$split = "0 bulan";
	}
	$splitarray = preg_split('/ /',$split);
	
	$datadate = $row['date_start'];	
	//echo date('Y-m-d', strtotime("+90 days"));
	//echo $splitarray[1];
	
	//if(strtolower($splitarray[1])=="hari"){		
	//	$datadate = $row['date_start'];	
	//	$date = date("Y-m-d", strtotime($datadate."+".$colno."days"));
	//}
	//if(strtolower($splitarray[1])=="minggu"){
	//	$datadate = $row['date_start'];	
	//	$date = date("Y-m-d", strtotime($datadate."+".$colno." weeks"));
	//}
	//if(strtolower($splitarray[1])=="bulan"){
		$datadate = $row['date_start'];	
		$date = date("Y-m-d", strtotime($datadate."+".($colno-1)." months"));
	//}
	//if(strtolower($splitarray[1])=="tahun"){
	//	$datadate = $row['date_start'];	
	//	$date = date("Y-m-d", strtotime($datadate."+".$colno." years"));
	//}
	return $date;
}

// syed 27062012 end

function first_date($mula){
	
	//echo $mula;
	//$day = (date("d", strtotime($mula)));
	$month = (date("m", strtotime($mula)));
	$year = (date("Y", strtotime($mula)));
	//$first_date = (date("Y", strtotime($mula)));
	//echo $day.">>".$month.">>".$year;
	$first_date = $year."-".$month."-01";
	return $first_date;	

}

function insertTempDatabase($data,$year,$id){
		//echo $data."<br>";
		$sql = "insert into cost_peryear (cp_project_id,cost,year) values (".$id.",".$data.",".$year.")";
		mysql_query($sql);

}

function updateTempDatabase($data,$year,$id){
		//echo $data."<br>";
		$sql = "update cost_peryear set cost = ".$data." where cp_project_id = ".$id." and year = ".$year."";
		mysql_query($sql);

}
function TotalPro($selYear){
		$sql = "select count(*) as count from project where kwsn_id_p is not null and kwsn_id_p <> 0 AND DATE_FORMAT(date_start, '%Y') = '".$selYear."'";
		$TotalPro = process_sql($sql,"count");
		return $TotalPro;
}
function TotalProByKawasan($kwsn,$selYear){
		$sql = "select count(*) as count from project where kwsn_id_p = ".$kwsn." AND DATE_FORMAT(date_start, '%Y') = '".$selYear."'";
		$TotalProByKawasan = process_sql($sql,"count");
		return $TotalProByKawasan;
}
function prcProByKwsn($kwsn,$selYear){
	
	$prcProByKwsn = ((TotalProByKawasan($kwsn,$selYear)<>0) && (TotalPro($selYear)<>0)) ? number_format(TotalProByKawasan($kwsn,$selYear)/TotalPro($selYear)*100,0)."%" : "0%";	

	return "<font color='#00000'>".$prcProByKwsn."</font>";
}
function cnvrIntMonth($string){
	switch ($string)
	{
		case "Januari":
		   return 1;
		   break;
		case "Februari":
		   return 2;
		   break;
		case "Mac":
		   return 3;
		   break;
		case "April":
		   return 4;
		   break;
		case "Mei":
		   return 5;
		   break;
		case "Jun":
		   return 6;
		   break;
		case "Julai":
		   return 7;
		   break;
		case "Ogos":
		   return 8;
		   break;
		case "September":
		   return 9;
		   break;
		case "Oktober":
		   return 10;
		   break;
		case "November":
		   return 11;
		   break;
		case "Disember":
		   return 12;
		   break;
	}	
}

function cnvrStringMonth($int){
	switch ($int)
	{
		case 1:
		   return "Januari";
		   break;
		case 2:
		   return "Februari";
		   break;
		case 3:
		   return "Mac";
		   break;
		case 4:
		   return "April";
		   break;
		case 5:
		   return "Mei";
		   break;
		case 6:
		   return "Jun";
		   break;
		case 7:
		   return "Julai";
		   break;
		case 8:
		   return "Ogos";
		   break;
		case 9:
		   return "September";
		   break;
		case 10:
		   return "Oktober";
		   break;
		case 11:
		   return "November";
		   break;
		case 12:
		   return "Disember";
		   break;
	}	
}

function cnvrtMonthYear($val){
	$pieces = explode("/",$val);
	$result = cnvrStringMonth($pieces[1])." ".$pieces[2];
	return $result;
}

function radio_checked($val1,$val2){
	if($val1==$val2){
		return "checked";	
	}else{
		return "";	
	}	
}
?>