
<div  >
	<div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px">
	Carian
	</div>
	<div>
    <?php 
				if(isset($_POST['btn_cari']))
				{
					$noKontrak = $_POST['noKontrak'];
	 				$jenisProjek = $_POST['jenisProjek'];
	 				$namaProjek = $_POST['namaProjek'];	
					$namaKontraktor = $_POST['namaKontraktor'];
					
					$sql=$sql_ori. " where project_name like '%".$namaProjek."%' and project_reference like '%" .$noKontrak."%' and project_type_short = '".$jenisProjek.  "' and contractor_name like '%" .$namaKontraktor. "%' order by seq_year,seq_category,seq";;
				}
					
	?>
    
    
	<form name="theForm1" method="POST">
	<table width="100%" border="1" bordercolor="#FFFFFF" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid">
	
	<tr>
	<td colspan="3"><strong>Sila masukkan sekurang-kurangnya satu kriteria carian berikut:</strong></td>
	</tr>
    
    <? if (isset($_POST['noKontrak'])){
			
			$_POST['noKontrak']=$_POST['noKontrak'];
		}
		else{
			$_POST['noKontrak']="";
		}
		
		if (isset( $_POST['namaProjek'])){
			
			 $_POST['namaProjek']= $_POST['namaProjek'];
		}
		else{
			$_POST['namaProjek']="";
		}
		
		if (isset($_POST['namaKontraktor'])){
			
			$_POST['namaKontraktor']=$_POST['namaKontraktor'];
		}
		else{
			$_POST['namaKontraktor']="";
		}	
	?>
    <tr>
	<td>No. Kontrak</td>	
	<td><select name="jenisProjek" >
	  <option value="">--Sila Pilih--</option>
	  <?php
	
		if (isset($_POST['jenisProjek'])){
			
			$_POST['jenisProjek']=$_POST['jenisProjek'];
		}
		else{
			$_POST['jenisProjek']="";
		}
		 
	$sqlJ='select project_type_short from project_type';
	$result = mysql_query($sqlJ);
	while($row = mysql_fetch_array($result)){
		if($_POST['jenisProjek']== $row['project_type_short']){
		?>
	  <option selected="selected" value="<?php echo $row['project_type_short']?>"><?php echo $row['project_type_short']?></option>
	  <?
		}else{
		?>
	  <option value="<?php echo $row['project_type_short']?>"><?php echo $row['project_type_short']?></option>
	  <?	
		}
	}	
	?>
	  </select>	  <input name="noKontrak" type="text" size="40" value="<?=$_POST['noKontrak']?>" ></td>
	</tr>
    
	<tr>
	<td>Nama Projek</td>	
	<td><input name="namaProjek" type="text" size="80" value="<?=$_POST['namaProjek']?>"></td>
	</tr>
    
    <tr>
	<td>Nama Kontraktor</td>	
	<td><input name="namaKontraktor" type="text" size="40" value="<?=$_POST['namaKontraktor']?>"></td>
	</tr>

	
		
	<tr>	
	<td colspan="3" style="background-color:#666666">
		<input type="submit" name="btn_cari" value=" Cari " title="Cari" class="button"  />
		<input type="reset" name="btn_reset" value="Set Semula" title="Set Semula" class="button"/>
		<input type="button" name="btn_cancel" value="Batal" title="Batal" class="button" onclick="parent.location='main.php?m=1&sm=10'"/>	</td>
	</tr>
	</table>
    
	</form>
	</div>
	

</div>	