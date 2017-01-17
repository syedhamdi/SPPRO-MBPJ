<? session_start();?>
<? include '../include/connection.php';?>
<? include '../include/serversidescript.php';?>
<?
		//echo $_POST['sm'];
		//exit();
	if($_POST['sm']=='1'){
		
			if($_POST['peringkat']==1) { 
				$sqlSeq = "select MAX(seq_no) FROM department WHERE layer=1";
				$seq = mysql_query($sqlSeq);
				$seq_no = mysql_fetch_row($seq);
				$seq_number = $seq_no[0]+1;
				
			}
			
			if($_POST['peringkat']==2) {
				$parent = $_POST['bahagian'];
				$sqlSeq = "select MAX(seq_no) FROM department where parent_id = " .$parent;;
				$seq = mysql_query($sqlSeq);
				$seq_no = mysql_fetch_row($seq);
				$seq_number = number_format($seq_no['0'],2)+(0.1);
			}

		$sql="insert into department(department_desc,layer,seq_no,parent_id) values('".replace($_POST['nama'])."',".$_POST['peringkat'].",'".$seq_number."',".$_POST['bahagian'].")";		
		mysql_query($sql);
	}
	
	if($_POST['sm']=='2'){
		
		$sql="insert into user_group(user_group_desc,user_group_layer,seq) values('".replace($_POST['kumpengguna'])."','".$_POST['RadioGroup']."','".$_POST['turutan']."')";		
		mysql_query($sql);
		
		$sqlug="SELECT MAX(user_group_id) FROM user_group";
		$idug=mysql_query($sqlug);
		$resug = mysql_fetch_row($idug);
		
		$sqlreset = "alter table user_group_module auto_increment = 1";
		mysql_query($sqlreset);
		
		if(isset($_POST['checkbox_module']))
		{
			$chk = $_POST['checkbox_module'];
		
			for ($i=0;$i<sizeof($chk);$i++)
			{
				//echo $chk[$i];	
					
				$sqlug_module="insert into user_group_module(user_group_id,module_id) values (".$resug[0].",".$chk[$i].")";
				mysql_query($sqlug_module);
				//echo $sqlbidang;
				//echo $chk[$i]; 		
			} 	
		}
	}
		
	if($_POST['sm']=='3'){

		$sql="insert into jawatan(jawatan_desc) values('".replace($_POST['jawatan'])."')";		
		mysql_query($sql);
		//echo $sql;
		//exit();
		}
		
	if($_POST['sm']=='4'){

		$sql="insert into gred(gred_desc) values('".replace($_POST['gred'])."')";		
		mysql_query($sql);
		}
		
	if($_POST['sm']=='5'){
		
		$sql="insert into user(user_name,user_login,user_jawatan_id,user_email,user_notel,User_nobimbit,user_group_id,department_id,gred_id,user_admin) values('".replace($_POST['nama'])."','".replace($_POST['idpengguna'])."','".$_POST['jawatan']."','".replace($_POST['email'])."','".replace($_POST['notel'])."','".replace($_POST['notelbimbit'])."',".$_POST['kumpengguna'].",".$_POST['jabatan'].",".$_POST['gred'].",0)";		
		//echo $sql;
		//exit();
		mysql_query($sql);
		}
	if($_POST['sm']=='6'){

			$counter = $_POST['counter'];

			$sql="insert into contractor(contractor_name,contractor_regno,contractor_address,contractor_email,contractor_phone,bumiputra,perunding,no_kkm,contractor_fax,contractor_phonepejabat) values('".replace($_POST['nama_kontraktor'])."','".replace($_POST['no_pendaftaran'])."','".replace($_POST['alamat'])."','".replace($_POST['email'])."','".replace($_POST['telefon'])."',".$_POST['bumiputra'].",".$_POST['perunding'].",'".replace($_POST['nokkm'])."','".replace($_POST['no_fax'])."','".replace($_POST['telefon2'])."')";
			mysql_query($sql);

			$sqlc="SELECT MAX(contractor_id) FROM contractor";
			$idc=mysql_query($sqlc);
			$resc = mysql_fetch_row($idc);
				
			if(isset($_POST['bidang']))
			{
				$chk = $_POST['bidang'];
				for ($i=0;$i<sizeof($chk);$i++){
						
					$sqlbidang="insert into bidang_perunding(bidang_id,contractor_id) values (".$chk[$i].",".$resc[0].")";
					mysql_query($sqlbidang);
					//echo $sqlbidang;
					//echo $chk[$i]; 		
				} 
			}
			//loop
			
			for ($i=1; $i<=$counter; $i++)
			{
				if(isset($_POST['pemilik'.$i]))
				{
					$sql2="insert into owner(owner_name,no_tel,no_tel2,no_ic,address,contractor_id) values('".replace($_POST['pemilik'.$i])."','".replace($_POST['telefon'.$i])."','".replace($_POST['telefon2'.$i])."','".replace($_POST['no_ic'.$i])."','".replace($_POST['alamat'.$i])."',".$resc[0].")";
					mysql_query($sql2);
				}
			}

	}
	
		if($_POST['sm']=='7'){
		
			$counter = $_POST['counter'];
			$counter2 = $_POST['counter2'];
			$bon = str_replace(",","",$_POST['bon']);
			
			$sql="insert into contractor(perunding,contractor_name,contractor_regno,contractor_address,contractor_email,contractor_phone,contractor_phonepejabat,contractor_fax,bumiputra,cidb,upen,no_pkk,no_kkm,contractor_class_id,contractor_class_idNew,bon_perlaksanaan,kaedah) values('".$_POST['perunding']."','".replace($_POST['nama_kontraktor'])."','".replace($_POST['no_pendaftaran'])."','".replace($_POST['alamat'])."','".replace($_POST['email'])."','".replace($_POST['telefon'])."','".replace($_POST['telefon2'])."','".replace($_POST['no_fax'])."','".$_POST['bumiputra']."','".$_POST['cidb']."','".$_POST['upen']."','".replace($_POST['pkk'])."','".replace($_POST['kkm'])."','".$_POST['kelas']."','".$_POST['kelasNew']."','".$bon."','".$_POST['kaedahbon']."')";
			mysql_query($sql);
			//echo $sql;
			//echo $sql2;
			//exit();
			
			
			$sqlc="SELECT MAX(contractor_id) FROM contractor";
			$idc=mysql_query($sqlc);
			$resc = mysql_fetch_row($idc);
			//loop
			/*for ($i=0;$i<sizeof($chk);$i++){
					
				$sqlbidang="insert into bidang_contractor(bidang_id,contractor_id) values (".$chk[$i].",".$resc[0].")";
				mysql_query($sqlbidang);
				//echo $chk[$i]; 		
			} 	*/
			
			for ($i=1; $i<=$counter2; $i++){
				if(isset($_POST['insuran'.$i]))
				{
					$nilai = str_replace(",","",$_POST['nilai'.$i]);	
					$sql2="insert into insuran(insuran_name,nilai,contractor_id) values('".replace($_POST['insuran'.$i])."','".$nilai."',".$resc[0].")";
					mysql_query($sql2);
				}
			//echo $sql2."XXXX";
			//exit;
			}
			
			for ($i=1; $i<=$counter; $i++){
				if(isset($_POST['pemilik'.$i]))
				{
					$sql3="insert into owner(owner_name,no_tel,no_tel2,no_ic,address,contractor_id) values('".replace($_POST['pemilik'.$i])."','".replace($_POST['telefon'.$i])."','".replace($_POST['telefon2'.$i])."','".replace($_POST['no_ic'.$i])."','".replace($_POST['alamat'.$i])."',".$resc[0].")";
					mysql_query($sql3);
				}
			}
			//echo $sql3."XXXX";
			//exit();	
			//$ido=mysql_query($sqlo);
			//$reso = mysql_fetch_row($ido);
			
			//$sql3="insert into contractor_owner(contractor_id,owner_id) values(".$resc[0].",".$reso[0].")";
			//mysql_query($sql3);
	}

	if($_POST['sm']=='8'){

		$sql="insert into project_type(project_type_desc,project_type_short,project_type_perunding) values('".replace($_POST['jenis'])."','".replace($_POST['singkatan'])."',".$_POST['RadioGroup1'].")";		
		mysql_query($sql);
	}
	
	if($_POST['sm']=='9'){

		$sql="insert into project_category(project_category_desc,project_category_short) values('".replace($_POST['kategori'])."','".replace($_POST['singkatan'])."')";		
		mysql_query($sql);
	}
	//echo $sql;
	if($_POST['sm']=='10'){
		
			$counter2 = $_POST['counter2'];
			$bon = str_replace(",","",$_POST['bon']);
			
		if(isset($_POST['checkbox_kos'])){
			$checkbox_kos = $_POST['checkbox_kos'];	
		}else{
			$checkbox_kos = 0;
		}
		if(isset($_POST['kos'])){
			$kos = str_replace(",","",$_POST['kos']);	
		}else{
			$kos = 0;
		}
		if(isset($_POST['kosAnggaran'])){
			$kosAnggaran = str_replace(",","",$_POST['kosAnggaran']);	
		}else{
			$kosAnggaran = 0;
		}
		$kos2 = $_POST['kos2'];
		if($kos2!=""){
			$kos2 = str_replace(",","",$kos2);	
		}else{
			$kos2 = 0;
		}
		$kos3 = $_POST['kos3'];
		if($kos3!=""){
			$kos3 = str_replace(",","",$kos3);	
		}else{
			$kos3 = 0;
		}
		if(isset($_POST['kategori'])){
			$kategori = $_POST['kategori'];
		}
		else{
			$kategori = 0;	
		}
		if(isset($_POST['bidangprojek'])){
			$bidang_projek = $_POST['bidangprojek'];	
		}else{
			$bidang_projek = "";
		}
		if(isset($_POST['checkbox_bon'])){
			$checkbox_bon = $_POST['checkbox_bon'];	
		}else{
			$checkbox_bon = 0;
		}
		if(isset($_POST['checkbox_insuran'])){
			$checkbox_insuran = $_POST['checkbox_insuran'];	
		}else{
			$checkbox_insuran = 0;
		}
		
		$jenisId = $_POST["jenis_projek"];
		//$mula = date("Y") ;
		$perunding = $_POST["perunding"];
		
		if(isset($_POST['semuazon'])){		
			$semuazon = 1;
			$parlimen = "NULL";
			$adun = "NULL";	
			$majlis = "NULL";
		}else{			
			if(isset( $_POST['parlimen'])){
				$parlimen =  $_POST['parlimen'];
				if($parlimen == 0){
					$parlimen = "NULL";	
				}else{
					$parlimen = $_POST['parlimen'];
				}	
			}else{
				$parlimen = "NULL";
			}
			if(isset( $_POST['adun'])){
				$adun =  $_POST['adun'];	
			}else{
				$adun = "NULL";
			}
			if(isset( $_POST['majlis'])){
				$majlis =  $_POST['majlis'];
			}else{
				$majlis = "NULL";
			}
			$semuazon = 0;
		}

		if($perunding==0){
		
			$space = "&nbsp;";
			$space2 = " ";
			$slash = "/";

			$no_kontrak_1 = replace($_POST['no_kontrak']);
			$no_kontrak_2 = replace($_POST['no_kontrak2']);
			$no_kontrak_3 = replace($_POST['no_kontrak3']);
			
			$no_referen = $no_kontrak_1.$space.$no_kontrak_2.$slash.$no_kontrak_3;
			$no_referen2 = $_POST['no_kontrak'].$space2.$_POST['no_kontrak2'].$slash.$_POST['no_kontrak3'];
			$seq_category = $no_kontrak_1;
			$no = $no_kontrak_2;
			$mula = $no_kontrak_3;
			
			$sql="insert into project(perunding,bidang,project_reference,project_date,project_name,kwsn_id_p,kwsn_id_a,kwsn_id_m,date_start,date_end,project_duration,department_id,contractor_id,project_type_id,project_category_id,project_cost,project_costA,pegawai_projek,jawatan_pprojek,pen_pegawai_projek,jawatan_penprojek,ptbk,jawatan_ptbk,year,eot,seq,seq_year,seq_category,email_pegawai,project_cost_month,project_cost_year,no_peruntukan,kadar_harga,user_insert,time_insert,bon_perlaksanaan2,kaedah,kesemua_bon,kesemua_insuran,semuazon,tarikhLantikanP) ".
				"values ('".replace($_POST['perunding'])."','".$bidang_projek."','".$no_referen."','".date("Y-m-d", strtotime($_POST['tarikh']))."','".replace($_POST['nama_projek'])."',".$parlimen.",".$adun.",".$majlis.",'".date("Y-m-d", strtotime($_POST['datemula']))."','".date("Y-m-d", strtotime($_POST['datetamat']))."','".$_POST['jangkamasa']."','".$_POST['jabatan']."','".$_POST['kontraktor']."','".$_POST['jenis_projek']."','".$kategori."','".$kos."','".$kosAnggaran."','".replace($_POST['p_projek'])."','".$_POST['jawatan_pprojek']."','".replace($_POST['pen_projek'])."','".$_POST['jawatan_penprojek']."','".replace($_POST['ptbk'])."','".$_POST['jawatan_ptbk']."','".date("Y", strtotime($_POST['datemula']))."','".date("Y-m-d", strtotime($_POST['datetamat']))."','".$no."','".$mula."','".$seq_category."','".replace($_POST['email'])."','".$kos2."','".$kos3."','".replace($_POST['no_peruntukan'])."','".$checkbox_kos."',".$_SESSION['id'].",now(),'".$bon."','".$_POST['kaedahbon']."','".$checkbox_bon."','".$checkbox_insuran."',".$semuazon.",'".date("Y-m-d", strtotime($_POST['tarikhLantikan']))."')";
			//echo $sql;
			//exit();
			mysql_query($sql);
		}
		
		if($perunding==1){
			
			$space = "&nbsp;";
			$space2 = " ";
			$slash = "/";		

			$no_referen = replace($_POST['no_kontrak']).$space.replace($_POST['no_kontrak2']).$slash.replace($_POST['no_kontrak3']);
			$no_referen2 = $_POST['no_kontrak'].$space2.$_POST['no_kontrak2'].$slash.$_POST['no_kontrak3'];
			$seq_category = replace($_POST['no_kontrak']);
			$no = replace($_POST['no_kontrak2']);
			$mula = replace($_POST['no_kontrak3']);
			
			$sql="insert into project(perunding,project_reference,project_date,project_name,kwsn_id_p,kwsn_id_a,kwsn_id_m,date_start,date_end,project_duration,department_id,contractor_id,project_type_id,project_category_id,project_cost,project_costA,pegawai_projek,jawatan_pprojek,pen_pegawai_projek,jawatan_penprojek,ptbk,jawatan_ptbk,year,eot,seq,seq_year,seq_category,email_pegawai,project_cost_month,project_cost_year,no_peruntukan,kadar_harga,user_insert,time_insert,bon_perlaksanaan2,kaedah,kesemua_bon,kesemua_insuran,semuazon,tarikhLantikanP) ".
				"values ('".replace($_POST['perunding'])."','".$no_referen."','".date("Y-m-d", strtotime($_POST['tarikh']))."','".replace($_POST['nama_projek'])."','".$parlimen."','".$adun."','".$majlis."','".date("Y-m-d", strtotime($_POST['datemula']))."','".date("Y-m-d", strtotime($_POST['datetamat']))."','".$_POST['jangkamasa']."','".$_POST['jabatan']."','".$_POST['kontraktor']."','".$_POST['jenis_projek']."','".$kategori."','".$kos."','".$kosAnggaran."','".replace($_POST['p_projek'])."','".$_POST['jawatan_pprojek']."','".replace($_POST['pen_projek'])."','".$_POST['jawatan_penprojek']."','".replace($_POST['ptbk'])."','".$_POST['jawatan_ptbk']."','".date("Y", strtotime($_POST['datemula']))."','".date("Y-m-d", strtotime($_POST['datetamat']))."','".$no."','".$mula."','".$seq_category."','".replace($_POST['email'])."','".$kos2."','".$kos3."','".replace($_POST['no_peruntukan'])."','".$checkbox_kos."',".$_SESSION['id'].",now(),'".$bon."','".$_POST['kaedahbon']."','".$checkbox_bon."','".$checkbox_insuran."',".$semuazon.",'".date("Y-m-d", strtotime($_POST['tarikhLantikan']))."')";
			//echo $sql;
			//exit();
			mysql_query($sql);

			$sqlc="SELECT MAX(project_id) FROM project";
			$idc=mysql_query($sqlc);
			$resc = mysql_fetch_row($idc);
				
			if(isset($_POST['bidang_perunding']))
			{
				$chk = $_POST['bidang_perunding'];
				for ($i=0;$i<sizeof($chk);$i++){
						
					$sqlbidang="insert into bidang_projek(bidang,projek) values (".$chk[$i].",".$resc[0].")";
					mysql_query($sqlbidang);
					
				} 
			}
			//loop
		}
		
		
		$sqlc="SELECT MAX(project_id) FROM project";
		$idc=mysql_query($sqlc);
		$resc = mysql_fetch_row($idc);
			
		//$resc = $resc[0]+1;
			
		for ($i=1; $i<=$counter2; $i++){
			if(isset($_POST['insuran'.$i]))
			{
				$nilai = str_replace(",","",$_POST['nilai'.$i]);	
				$sql2="insert into insuran(insuran_name,nilai,project_id) values('".replace($_POST['insuran'.$i])."','".$nilai."',".$resc[0].")";
				mysql_query($sql2);
			}
		}

	}
	if($_POST['sm']=='12'){
			
			$kod_subbidang1 = $_POST['sub_bidang'];
			$kod_subbidang2	= explode("|",$kod_subbidang1);
			$kod_subbidang3 = $kod_subbidang2[0];
			
			$sql="insert into kepala_pecahan(kepala_sub_id,kepala_anak_kod,kepala_anak_desc,kod) values('".$kod_subbidang3."','".$_POST['kod']."','".replace($_POST['nama'])."','".$_POST['kod_1'].$_POST['kod_2'].$_POST['kod']."')";
			//$sql2="insert into contractor_owner(owner_name) values('".$_POST['pemilik']."')";		
			mysql_query($sql);
			//mysql_query($sql2);
		
	}
	if($_POST['sm']=='13.1'){
		$_POST['sm'] =13;
			if($_POST['layer']==1) { 
				$parent=0;
				$sqlSeq = "select MAX(seq_no) FROM kawasan WHERE layer=1";
				$seq = mysql_query($sqlSeq);
				$seq_no = mysql_fetch_row($seq);
				if(isset($seq_no[0]))
					$seq_number = $seq_no[0]+1;
				else
					$seq_number = 1;
			}
			
			if($_POST['layer']==2) {
				$parent = $_POST['parlimen'];
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
			
			if($_POST['layer']==3) {
				$parent = $_POST['adun'];
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
		$sql="insert into kawasan(kwsn_desc,layer,seq_no,parent_id) values('".replace($_POST['nama2'])."',".$_POST['layer'].",'".$seq_number."',".$parent.")";		
		mysql_query($sql);
	}
	
	if($_POST['sm']=='13.2'){
		$_POST['sm'] =13;
		if ($_POST['datetamat'] =="-"){
			$tamat = "2999-01-01";
		}else{
			$tamat = date("Y-m-d", strtotime($_POST['datetamat'])); 	
		}
		$sql="insert into ahli(kawasan_id,nama_ahli,dateS,dateE) values('".$_POST['kawasan']."','".replace($_POST['nama2'])."','".date("Y-m-d", strtotime($_POST['datemula']))."','".$tamat."')";		
		mysql_query($sql);
	}
	if($_POST['sm']=='14'){
			
		if ($_POST['datetamat'] =="-"){
			$tamat = "2999-01-01";
		}else{
			$tamat = date("Y-m-d", strtotime($_POST['datetamat'])); 	
		}
		$seq = process_sql("select max(seq_no) as max from contractor_class","max");
		$seq = $seq+1;
		$sql="insert into contractor_class(class_desc,seq_no,had,kategori_kerja,CSdateS,CSdateE) values('".replace($_POST['gred'])."',".$seq.",'".replace($_POST['had'])."','".$_POST['RadioGroup1']."','".date("Y-m-d", strtotime($_POST['datemula']))."','".$tamat."')";
		mysql_query($sql);
		//mysql_query($sql2);
		
	}
	if($_POST['sm']=='15'){
		
		$nama_ahli = process_sql("select nama_ahli from ahli where ahli_id = ".$_POST['ahli'],"nama_ahli");
		$sql="insert into user(user_name,user_login,user_email,user_notel,User_nobimbit,ahli_majlis) values('".replace($nama_ahli)."','".replace($_POST['idpengguna'])."','".replace($_POST['email'])."','".replace($_POST['notel'])."','".replace($_POST['notelbimbit'])."','".replace($_POST['ahli'])."')";		
		mysql_query($sql);
		$sqlUpdate = "update ahli set regAcc = 1 where ahli_id = ".$_POST['ahli'];
		mysql_query($sqlUpdate);
	}
		
		if($_POST['sm']=='10'){
			?>
			<script language="Javascript" type="text/javascript">
			alert("Data telah disimpan. No. Kontrak ialah <?=$no_referen2?>");
			document.location.href="../main.php?m=<?=urlEncrypt($_POST['m'])?>&sm=<?=urlEncrypt($_POST['sm'])?>&md=1";
			//box = document.theForm.elements[1];
			//box.focus();
			</script>
			<?	
		}
		else{
		
			?>
			<script language="Javascript" type="text/javascript">
			alert("Data tidak disimpan.");
			document.location.href="../main.php?m=<?=urlEncrypt($_POST['m'])?>&sm=<?=urlEncrypt($_POST['sm'])?>&md=1";
			//box = document.theForm.elements[1];
			//box.focus();
			</script>
			<?	
		}
		