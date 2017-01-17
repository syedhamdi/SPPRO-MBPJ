<link rel="stylesheet" type="text/css" media="all" href="CSS/jsDatePick_ltr.min.css" />
<script language="javascript" type="text/javascript" src="js/javascript.js"></script>
<script language="javascript" type="text/javascript" src="js/AjaxScriptNew.js"></script>

<script type="text/javascript">


</script>
<?php

function show_input($name,$typ,$data,$len){
	if($typ!='datetime'&&$typ!='date'){
		if($name=='Peringkat'){
			$sql='select * from layer where layer>1 order by seq_no';			
			$result = mysql_query($sql);									
			?>
			<script language="javascript">
			function show_parent(f){
				if(f.value=='3'){
					document.getElementById('div_parent').style.display='inline';
				}else{
					document.getElementById('div_parent').style.display='none';
				}
			}
			</script>
			
			<select name="layer" onchange="show_parent(this)" >
				<option>---Sila Pilih---</option>
				<?php 
				while($row = mysql_fetch_array($result)){
				?>
				<option value="<?php echo $row['layer']?>"><?php echo $row['layer_name']?></option>
				<?php
				}
				?>
			</select>
			
			<div id="div_parent" style=" display:none; padding-left:10px">
			Bahagian
			<select name="parent_id">
				<option>---Sila Pilih---</option>
				<?php 
				$sql='select * from department where layer=2 order by seq_no';			
				$result = mysql_query($sql);				
				while($row = mysql_fetch_array($result)){
				?>
				<option value="<?php echo $row[0]?>"><?php echo $row[1]?></option>
				<?php
				}
				?>
			</select>			
			</div>
			<?php
		}else{
			if(strpos($name,'*')>0){
				?>
				<select name="sel" style="width:100%">
					<option>--Sila Pilih--</option>
					<?php 
					$sql='select * from '.substr($name,0,strlen($name)-1);			
					$result = mysql_query($sql);				
					while($row = mysql_fetch_array($result)){
					?>
					<option value="<?php echo $row[0]?>"><?php echo $row[1]?></option>
					<?php
					}
					?>
				</select>
				<?php
			}else{
				$val='';
				if($_GET['md']=='2'){
					$val=$data;
				}
				?>
				<input type="text" name="<?=$name?>" size="80" maxlength="<?php echo $len?>" value="<?=$val?>" /><? //=$name?>		
				<?php
			}
		}		
	?>

	<?php
	}else{
		//echo $typ;
		?>
		<input name="date" size="15" readonly="" class="text" >&nbsp;	
		<a href="Javascript:show_calendar('document.theForm.QID<%=QId%>', document.theForm.QID<%=QId%>.value,'../Images/')" title="select date">
		<img src="Images/Date.gif" width="16" height="14" border="0">
		</a> 													
		<?php
	}
}
		if(urlDecrypt($_GET['sm'])=='1'){
	
					$sql='select * from department where layer=1 order by seq_no';
					$result = mysql_query($sql);
					?>
					<form action="admin/form_p.php" method="post" enctype="multipart/form-data" name="theForm" id="theForm" onsubmit="return checkform()">
					<input name="m" value="1" type="hidden" />
					<input name="sm" value="1" type="hidden" />
				 		 <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
							<tr>
					 	 		<td colspan="3"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Jabatan/Bahagian/Unit</strong></td>
					  			<td>&nbsp;</td>
					  			<td>&nbsp;</td>
					  			<td>&nbsp;</td>
							</tr>
							<tr>
							  <td>&nbsp;</td>
							  <td colspan="2">&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
						   </tr>
							<tr>
                                 <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Peringkat</td>
                                 <td colspan="2"><select name="peringkat" id="peringkat" onchange="hidejabatan()">
                                    <option value="1">Jabatan/Unit</option>
                                    <option value="2">Bahagian</option>
                                  </select></td>
                                 <td width="5%">&nbsp;</td>
                                 <td width="4%">&nbsp;</td>
                                 <td width="7%">&nbsp;</td>
							</tr>
							<tr id="jabatan" style="display:none">
					  			<td >&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
					  			<td colspan="2"><select name="bahagian" id="Jabatan" >
					 				<option value="0">---Sila Pilih--</option>
									<?
					  				while($row = mysql_fetch_array($result))
									{
									?> 
									<option value="<?=$row['department_id'] ?>"><?=$row['department_desc']?></option> 
									<? 
									}	
									?>
					  			 	</select></td>
					  			<td>&nbsp;</td>
					  			<td>&nbsp;</td>
					  			<td>&nbsp;</td>
							</tr>
				
							<tr>
                                 <td>&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
                                 <td colspan="2"><input type="text" accept="check" name="nama" id="nama" onblur="capitalize(this)" size="40" /></td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
							</tr>
							<tr>
					  			<td>&nbsp;</td>
					  			<td width="36%">&nbsp;</td>
					  			<td width="33%">&nbsp;</td>
					  			<td>&nbsp;</td>
					  			<td>&nbsp;</td>
					  			<td>&nbsp;</td>
							</tr>
							<tr bgcolor="#999999">
					  			<td colspan="6" align="right"><input type="submit" name="button" id="button" value="Simpan" class="button_style" />					  			  
                                <input type="reset" name="button3" id="button3" value="Set Semula" class="button_style"/>
				  			    <input type="button" name="button2" id="button2" value="Batal" class="button_style" onclick="backpage()" /></td>
							</tr>
				  		</table>
					</form>
                    
								<?
								}
			if(urlDecrypt($_GET['sm'])=='2'){ ?>

            		<form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="2" type="hidden" />
                            <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                              <tr>
                                <td colspan="3"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Kumpulan Pengguna</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Kumpulan Pengguna</td>
                                <td colspan="2"><input name="kumpengguna" accept="check" type="text" id="kumpulan pengguna" size="40" /><span id="check" style="display:none"><strong>&nbsp;&nbsp;*</strong></span></td>
                                <td width="5%">&nbsp;</td>
                                <td width="4%">&nbsp;</td>
                                <td width="7%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Turutan</td>
                                <td colspan="2"><input name="turutan" accept="check" type="text" id="turutan" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)"/><span id="check" style="display:none"><strong>&nbsp;&nbsp;*</strong></span>  
                                  * nombor sahaja</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Level</td>
                                <td><p>
                                  <label>
                                    <input type="radio" accept="check" name="RadioGroup" value="3" id="RadioGroup_0" />
                                    Semua</label>                                  
                                  <label>
                                    <input type="radio" accept="check" name="RadioGroup" value="1" id="RadioGroup_1" />
                                    Jabatan</label>                                  
                                  <label>
                                    <input type="radio" accept="check" name="RadioGroup" value="2" id="RadioGroup_2" />
                                    Bahagian</label>
                                 
                                </p></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;Modul</td>
                                <td colspan="2"><p>
                                  <?
                                	$sql = "Select * from module";
									$result = mysql_query($sql);
									while($row = mysql_fetch_array($result))
									{
										?>
                                  <input type="checkbox" name="checkbox_module[]" value="<?=$row['id']?>" id="checkbox_module[]" />
                                  <?=$row['det']?>
                                  </label>
                                  </br>
                                  <?
                                    }
								?>
                                </p></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="36%">&nbsp;</td>
                                <td width="33%">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style"/>
                                <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                                <input type="button" name="button14" id="button15" value="Batal" class="button_style" onclick="backpage()" /></td>
                              </tr>
                            </table>
					</form>
                            
                              <?
								}
			if(urlDecrypt($_GET['sm'])=='3'){ ?>

            				<form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="3" type="hidden" />
                            <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                              <tr>
                                <td colspan="3"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Jawatan</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Jawatan</td>
                                <td colspan="2"><input accept="check" name="jawatan" type="text" id="jawatan" size="40" onblur="capitalize(this)"/></td>
                                <td width="5%">&nbsp;</td>
                                <td width="4%">&nbsp;</td>
                                <td width="7%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="36%">&nbsp;</td>
                                <td width="33%">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style"/>
                                <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                                <input type="button" name="button13" id="button14" value="Batal" class="button_style" onclick="backpage()" /></td>
                              </tr>
                            </table>
                            </form>
                            
            <? }
			if(urlDecrypt($_GET['sm'])=='4'){
				 
			?>				<form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="4" type="hidden" />
								<table width="100%" border="0">
                              <tr>
                                <td colspan="6"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Gred</strong></td>
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="5">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Gred&nbsp;</td>
                                <td width="85%" colspan="5"><input accept="check" name="gred" type="text" id="gred" size="40" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="5">&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="32" colspan="6">&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" />
                                  								<input type="reset" name="button7" id="button8" value="Set Semula" class="button_style"/>
																<input type="button" name="button5" id="button5" value="Batal" class="button_style"onClick="backpage()"/></td>
                              </tr>
                </table>
                
                	 </form>
                <? }
			if(urlDecrypt($_GET['sm'])=='5'){ 
	
			?>
					<form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="5" type="hidden" />
              <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                <tr>
                  <td colspan="2"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Akaun Pengguna</strong></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;ID Pengguna</td>
                  <td width="48%"><input accept="check" name="idpengguna" type="text" id="id pengguna" size="40" /></td>
                  <td width="12%">&nbsp;</td>
                  <td width="11%">&nbsp;</td>
                  <td width="14%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
                  <td><input accept="check" name="nama" type="text" id="nama" size="40"/></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Kumpulan Pengguna</td>
                  <td><select accept="check" name="kumpengguna" id="kumpengguna" >
                    <option value="0">---Sila Pilih--</option>
                    <?
								$sql='select * from user_group order by seq';
								$result = mysql_query($sql);
					  				while($row = mysql_fetch_array($result))
									{
									?>
                    <option value="<?=$row['user_group_id'] ?>">
                      <?=$row['user_group_desc']?>
                    </option>
                    <? 
									}	
									?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
                  <td><select accept="check" name="jabatan" id="jabatan">
                    <option value="0">---Sila Pilih--</option>
                    <?
									$sql='select * from department where parent_id=0';
									$result = mysql_query($sql);
					  				while($row = mysql_fetch_array($result))
									{	
										?>
                    <option value="<?=$row['department_id'] ?>">
                      <?=$row['department_desc']?>
                    </option>
                    <?
										$sql2="select * from department where parent_id=".$row['department_id'];
										$result2 = mysql_query($sql2);
										while($row2 = mysql_fetch_array($result2))
										{
											?>
                    <option value="<?=$row2['department_id'] ?>"> ---
                      <?=$row2['department_desc']?>
                    </option>
                    <?
										}
									}
									?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Jawatan</td>
                  <td><select accept="check" name="jawatan" id="jawatan">
					 				<option value="0">---Sila Pilih--</option>
									<?
								$sql='select * from jawatan order by jawatan_desc';
								$result = mysql_query($sql);
					  			while($row = mysql_fetch_array($result))
									{
									?> 
									<option value="<?=$row['jawatan_id'] ?>"><?=$row['jawatan_desc']?></option> 
									<? 
									}	
									?>
					  </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Gred</td>
                  <td><select name="gred" id="gred" >
                    <option value="0">---Sila Pilih--</option>
                    <?
								$sql='select * from gred order by gred_desc';
								$result = mysql_query($sql);
					  			while($row = mysql_fetch_array($result))
									{
									?>
                    <option value="<?=$row['gred_id'] ?>"><?=$row['gred_desc']?></option>
                    				<? 
									}	
									?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Email</td>
                  <td><input name="email" type="text" id="email" size="40" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Tel</td>
                  <td><input name="notel" type="text" id="no tel" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />                    * nombor sahaja</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Tel Bimbit</td>
                  <td><input name="notelbimbit" type="text" id="no tel bimbit" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />
                  * nombor sahaja</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr >
                  <td colspan="5" align="right">&nbsp;</td>
                </tr>
                <tr bgcolor="#999999">
                  <td colspan="5" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" />
                  <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                  <input type="button" name="button6" id="button7" value="Batal" onclick="backpage()" class="button_style"/></td>
                </tr>
              </table>
              </form>
                            <?
                            }
             
			 if(urlDecrypt($_GET['sm'])=='6'){ ?>
					<div style="border:thin solid black">
                    <form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
					<input name="m" value="1" type="hidden" />
					<input name="sm" value="6" type="hidden" />
  					<table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tambah Maklumat Perunding</strong></td>
      							<td>
   							    <input type="hidden" name="perunding" id="perunding" value="1" /></td>
      							<td></td>
      							<td></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
    						  <td>&nbsp;</td>
    						  <td>&nbsp;</td>
    						  <td></td>
    						  <td></td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
      							<td width="400"><label for="textfield5">&nbsp;&nbsp;&nbsp;&nbsp;Nama Perunding</label></td>
      							<td width="645"><input accept="check" name="nama_kontraktor" type="text" id="nama_perunding" onblur="capitalize(this)" size="40" /></td>
      							<td width="51"></td>
      							<td width="48"></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;No. Pendaftaran Perunding</td>
      							<td><input accept="check" name="no_pendaftaran" type="text" id="no_pendaftaran" size="40" onblur="checkKon_Pe(this,'perunding')" /></td>
      							<td></td>
      							<td></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
      							<td><label for="textarea2">&nbsp;&nbsp;&nbsp;&nbsp;Alamat</label></td>
      							<td><textarea accept="check" name="alamat" id="alamat" cols="45" rows="5"></textarea></td>
      							<td></td>
      							<td></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;Email</td>
      							<td><input name="email" type="text" id="e-mail" size="40" /></td>
      							<td></td>
      							<td></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon Pejabat</td>
      							<td><input  name="telefon" type="text" id="no. tel" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />
   							    * nombor sahaja</td>
      							<td></td>
      							<td></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon Bimbit</td>
    						  <td><input name="telefon2" type="text" id="no. tel2" size="40" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />
    						    * nombor sahaja</td>
    						  <td></td>
    						  <td></td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Fax</td>
    						  <td><input name="no_fax" type="text" id="no. tel3" size="40" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />
   						      * nombor sahaja</td>
    						  <td></td>
    						  <td></td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
      							<td>&nbsp;&nbsp;&nbsp;&nbsp;Bumiputra</td>
                                 <td>
                                   
                                     <label>
                                       <input name="bumiputra" type="radio" id="bumiputra" value="1" checked="checked" />
                                       Ya</label>
                                   
                                     <label>
                                       <input type="radio" name="bumiputra" id="bumiputra" value="0"  />
                                       Tidak</label>
                                 </td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                </tr>
    						<tr>
    						  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Rujukan Pendaftaran</br> &nbsp;&nbsp;&nbsp;&nbsp;Kementerian Kewangan Malaysia (KKM)</td>
    						  <td>
   						      <input type="text" name="nokkm" id="nokkm" /></td>
    						  <td></td>
    						  <td></td>
    						  <td colspan="2"></td>
  						  </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Bidang</td>
                                  <td colspan="5">
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
                                                	<input type="checkbox" id="bidang[]" name="bidang[]" value="<?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?>"><?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?> - <?=$row['kepala_anak_desc']?></br>
                                                	</td>
                                                    <td>
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
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td width="7"></td>
                                  <td width="50"></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                              </table>
							<input name="counter" type="hidden" id="counter" size="40" value = '1' /> 
  							<div id="dynamicInput">
                              <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                                <tr>
                                  <td width="32%">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Maklumat Pemilik</strong></td>
                                  <td width="68%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Pemilik</td>
                                  <td><input accept="check" name="pemilik1" type="text" id="pemilik" size="40" /> 
                                  </td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Kad Pengenalan</td>
                                  <td><input accept="check" name="no_ic1" type="text" id="kad penggenalan5" size="40" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Alamat</td>
                                  <td><textarea name="alamat1" id="alamat1" cols="45" rows="5"></textarea> </td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon 1</td>
                                  <td><input name="telefon1" type="text" id="no tel" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon 2</td>
                                  <td><input name="telefon21" type="text" id="no tel2" size="40" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                      </div>
                     		<span><input type="button" value="Tambah Pemilik" onClick="addInput('dynamicInput');"></span>
                     		<table width="100%" border="0" cellpadding="1" cellspacing="1">
                              <tr>
                                <td align="right">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="right" bgcolor="#999999"><span style="alignment-adjust:after-edge">
                                  <span style="text-align: right"></span>
                                  <input type="submit" name="button9" id="button10" value="Simpan" class="button_style"/>
                                  <input type="reset" name="button10" id="button11" value="Set Semula" class="button_style"/>
                                </span>
                                <input type="button" name="button15" id="button16" value="Batal" onclick="backpage()" class="button_style"/>
                                <span style="text-align: right"></span></td>
                              </tr>
                      </table>
                    </form>
                           </div>
  							<?
							} 
							              			
			if(urlDecrypt($_GET['sm'])=='7'){ ?>
					<div style="border:thin solid black">
                    <form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
					<input name="m" value="1" type="hidden" />
					<input name="sm" value="7" type="hidden" />
  					<table border="0" style="padding:2px; width:100%; border:#999999 1px solid">
    						<tr>
      							<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tambah Maklumat Kontraktor</strong>
   							      <input type="hidden" name="perunding" id="perunding" value="0" /></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
    						  <td colspan="2">&nbsp;</td>
    						  <td>&nbsp;</td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
      							<td colspan="2"><label for="textfield5">&nbsp;&nbsp;&nbsp;&nbsp;Nama Kontraktor</label></td>
      							<td width="725"><input accept="check" name="nama_kontraktor" type="text" id="nama_kontraktor" onblur="capitalize(this)" size="40" /></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
      							<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;No. Pendaftaran Kontraktor</td>
      							<td><input accept="check" name="no_pendaftaran" type="text" id="no_pendaftaran" size="40" onblur="checkKon_Pe(this,'kontraktor')" /></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
      							<td colspan="2"><label for="textarea2">&nbsp;&nbsp;&nbsp;&nbsp;Alamat</label></td>
      							<td><textarea name="alamat" id="alamat" cols="45" rows="5"></textarea></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
      							<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Email</td>
      							<td><input name="email" type="text" id="e-mail" size="40" /></td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
      							<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon Pejabat</td>
      							<td><input name="telefon" type="text" id="no. tel" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />
   							    * nombor sahaja</td>
      							<td colspan="2"></td>
    						</tr>
    						<tr>
    						  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon Bimbit</td>
    						  <td><input name="telefon2" type="text" id="no. tel2" size="40" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />
    						    * nombor sahaja</td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
    						  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;No. Fax</td>
    						  <td><input name="no_fax" type="text" id="no. fax" size="40" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />
   						      * nombor sahaja </td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
      							<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Bumiputra</td>
                                 <td><p>
                                   <label>
                                     <input name="bumiputra" type="radio" id="RadioGroup2_0" value="1" checked="checked" />
                                     Ya</label>
                                   <label>
                                     <input type="radio" name="bumiputra" value="0" id="RadioGroup2_1" />
                                     Tidak</label>
                                   <br />
                                 </p></td>
                                  <td colspan="2"></td>
                                </tr>
    						<tr>
    						  <td colspan="2">
    						    &nbsp;&nbsp;&nbsp;&nbsp;Perakuan&nbsp;Pendaftaran&nbsp;Kontraktor&nbsp;(PPK)</td>
    						  <td><p>
    						    <label>
    						      <input name="cidb" type="radio" id="RadioGroup1_6" value="1" checked="checked" />
    						      Ya</label>
    						    <label>
    						      <input type="radio" name="cidb" value="0" id="RadioGroup1_7" />
    						      Tidak</label>
    						    <br />
  						    </p></td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
    						  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Sijil&nbsp;Perolehan&nbsp;Kerja&nbsp;Kerajaan&nbsp;(SPKK)</td>
    						  <td><input name="pkk" type="text" id="pkk" size="40" /></td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
    						  <td colspan="2">&nbsp;</td>
    						  <td>&nbsp;</td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
    						  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Kelas (PKK)</td>
    						  <td>
							  	<select name="kelas" id="kelas">
                                	<option value="0">---Sila Pilih---</option>
								<?
                              		$sqlGred = "select * from contractor_class where CSdateE < '2012-10-15' order by seq_no";
									$sqlresultGred = mysql_query($sqlGred);
									while($rowGred = mysql_fetch_array($sqlresultGred)){
										if($rowGred["kategori_kerja"]==1){
											$kategori = "Kerja";
										}elseif($rowGred["kategori_kerja"]==2){
											$kategori = "Elektrik";
										}else{
											$kategori = "";
										}
										?><option value="<?=$rowGred["contractor_class_id"]?>"><?=$rowGred["class_desc"]."&nbsp;&nbsp;(".$kategori.")"?></option><?
									}							
								?>
  						      </select> &nbsp;&nbsp;<font color="#FF0000">* Jika Ada</font>
							  </td>
    						  <td colspan="2"></td>
  						  </tr>
                          <tr>
    						  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Kelas (SPKK)</td>
    						  <td>
							  	 <select name="kelasNew" id="kelasNew">
                                	<option value="0">---Sila Pilih---</option>
								<?
                              		$sqlGred = "select * from contractor_class where CSdateE > '2012-10-14' order by seq_no";
									$sqlresultGred = mysql_query($sqlGred);
									while($rowGred = mysql_fetch_array($sqlresultGred)){
										if($rowGred["kategori_kerja"]==1){
											$kategori = "Kerja";
										}elseif($rowGred["kategori_kerja"]==2){
											$kategori = "Elektrik";
										}else{
											$kategori = "";
										}
										?><option value="<?=$rowGred["contractor_class_id"]?>"><?=$rowGred["class_desc"]."&nbsp;&nbsp;(".$kategori.")"?></option><?
									}							
								?>
  						      </select>&nbsp;&nbsp;<font color="#FF0000">* Jika Ada</font>
                             
                             </td>
    						  <td colspan="2"></td>
  						  </tr>
    						<tr>
    						  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;No. Rujukan Pendaftaran<br />
    						    &nbsp;&nbsp;&nbsp;&nbsp;Kementerian Kewangan Malaysia (KKM)</td>
    						  <td><input type="text" name="kkm" id="kkm" /></td>
    						  <td colspan="2"></td>
  						  </tr>
                                <tr>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td width="1"></td>
                                  <td width="41"></td>
                              <!--  </tr>
                                <tr>
                                  <td colspan="2">Bidang</td>
                                  <td><div>
                                 
                                  
                                    <?	$sql = "select * from kepala k ".
												"inner join kepala_sub ks on ks.kepala_id = k.kepala_id ".
												"inner join kepala_pecahan kp on kp.kepala_sub_id = ks.kepala_sub_id ".
												"where k.perunding = 1 ";
										$result = mysql_query($sql);
										
										while($row = mysql_fetch_array($result)){
													?>
                                                   
                                                    <input type="checkbox" id="bidang[]" name="bidang[]" value="<?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?>"><?=$row['kepala_kod'].$row['kepala_sub_kod'].$row['kepala_anak_kod']?> - <?=$row['kepala_anak_desc']?></br>
													

											<? }
											?>
														
                                  
                                    </div></td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>-->
                                <tr>
                                  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Berdaftar dengan unit Perancangan Ekonomi<br />
                                    &nbsp;&nbsp;&nbsp;&nbsp;Negeri Selangor (UPEN)</td>
                                  <td><label>
                                    <input name="upen" type="radio" id="RadioGroup1_" value="1" checked="checked" />
                                    Ya</label>
                                    <label>
                                      <input type="radio" name="upen" value="0" id="RadioGroup1_2" />
                                      Tidak</label></td>
                                  <td colspan="2"></td>
                                </tr>
                                <tr style="display:none">
                                  <td width="284">&nbsp;&nbsp;&nbsp;&nbsp;Bon Perlaksanaan</td>
                                  <td width="65" align="right">RM</td>
                                  <td><label for="bon"></label>
                                  <input type="text" name="bon" id="bon" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr style="display:none">
                                  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Kaedah </td>
                                  <td><label for="kaedahbon"></label>
                                    <select name="kaedahbon" id="kaedahbon">
                                      <option value="">---Sila Pilih---</option>
                                      <option value="1">Tunai / Bank Draf</option>
                                      <option value="2">Jaminan Bank</option>
                                      <option value="3">Jaminan Insuran</option>
                                      <option value="4">Wang Jaminan Perlaksanaan (WJP)</option>
									</select>
                                  </td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td colspan="5">
                                		
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                              </table>
                              <table width="100%">
                              <tr style="display:none">
                                  <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Maklumat Insuran</strong></td>
                                  <td width="16%" colspan="2" align="right"><label for="textfield2"></label>
                                  <input type="hidden" name="counter2" id="counter2" value="4" /></td>
                                  <td width="67%"><label for="textfield3"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                                  <td width="2%" colspan="2">&nbsp;</td>
                                </tr>
                              <tr style="display:none">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Polisi Insuran</td>
                                <td align="right">&nbsp;</td>
                                <td colspan="2" align="right"><table width="100%" border="0">
                                  <tr>
                                  	<td width="6%" align="right">1.</td>
                                    <td width="34%"><input type="text" name="insuran1" id="insuran1" size="40" value="Insuran Risiko Semua Kontraktor" /></td>
                                    <td width="43%">&nbsp;RM
                                      <label for="textfield4"></label>
                                      <input type="text" name="nilai1" id="nilai1" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/></td>
                                    
                                  </tr>
                                  </table>
                                  <table width="100%" border="0">
                                  <tr>
                                  	<td width="6%" align="right">2.</td>
                                    <td width="34%"><input type="text" name="insuran2" id="insuran2" size="40" value="Insuran Pampasan Pekerja" /></td>
                                    <td width="43%">&nbsp;RM
                                      <label for="textfield4"></label>
                                      <input type="text" name="nilai2" id="nilai2" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/></td>
                                    
                                  </tr>
                                  </table>
                                  <table width="100%" border="0">
                                  <tr>
                                  	<td width="6%" align="right">3.</td>
                                    <td width="34%"><input type="text" name="insuran3" id="insuran3" size="40" value="Insuran Tanggungan Awam" /></td>
                                    <td width="43%">&nbsp;RM
                                      <label for="textfield4"></label>
                                      <input type="text" name="nilai3" id="nilai3" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/></td>
                                   
                                  </tr>
                                  </table>
                                  <table width="100%" border="0">
                                  <tr>
                                  	<td width="6%" align="right">4.</td>
                                    <td width="34%"><input type="text" name="insuran4" id="insuran4" size="40" value="Insuran Profesionam Indemnity" /></td>
                                    <td width="43%">&nbsp;RM
                                      <label for="textfield4"></label>
                                      <input type="text" name="nilai4" id="nilai4" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/>
                                   </td>
                                  </tr>
                                  </table>
                                <div id="kaedah"></div> 
                                 <span style="text-align: left"></span>
                                 <span style="text-align: left"></span>
                                 <input type="button" name="Tambah" id="Tambah" value="Tambah Insuran" onclick="addinsuran('kaedah')" />                               
                                </td>
                                <td colspan="2">&nbsp;</td>
                              </tr>
                      </table>
                              
                              <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                                <tr>
                                  <td width="32%">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Maklumat Pemilik</strong><input name="counter" type="hidden" id="counter" size="40" value = '1' /></td>
                                  <td width="68%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Pemilik</td>
                                  <td><input accept="check" name="pemilik1" type="text" id="pemilik" size="40" /> 
                                  </td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Kad Pengenalan</td>
                                  <td><input accept="check" name="no_ic1" type="text" id="kad penggenalan" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Alamat</td>
                                  <td><textarea name="alamat1" id="alamat1" cols="45" rows="5"></textarea></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon</td>
                                  <td><input name="telefon1" type="text" id="no tel" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon 2</td>
                                  <td><input name="telefon21" type="text" id="no tel2" size="40" onkeyup="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                      </table>
                      		<div id="dynamicInput">
                      		 
                            </div>
                             <input type="button" value="Tambah Pemilik" onclick="addInput('dynamicInput');" />
               		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td height="26">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                              </tr>
                              <tr  bgcolor="#999999">
                                <td height="26">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right"><span style="alignment-adjust:after-edge">
                                  <input type="submit" name="button16" id="button17" value="Simpan" class="button_style"/>
                                  <input type="reset" name="button16" id="button18" value="Set Semula" class="button_style"/>
                                </span>
                                <input type="button" name="button16" id="button19" value="Batal" onclick="backpage()" class="button_style"/></td>
                              </tr>
                      </table>
                    </form></div>
  							<?
							} 
							                  			
			if(urlDecrypt($_GET['sm'])=='9'){ ?>
            
            <form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="9" type="hidden" />
                            <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                              <tr>
                                <td colspan="3"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Kategori Projek</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Kategori Projek</td>
                                <td colspan="2"><input accept="check" name="kategori" type="text" id="kategori" size="40" /></td>
                                <td width="5%">&nbsp;</td>
                                <td width="4%">&nbsp;</td>
                                <td width="7%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Singkatan</td>
                                <td colspan="2"><input accept="check" name="singkatan" type="text" id="singkatan" size="40" /></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="36%">&nbsp;</td>
                                <td width="33%">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style"/>
                                <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                                <input type="button" name="button8" id="button9" value="Batal" onclick="backpage()" class="button_style"/></td>
                              </tr>
                            </table>
                            </form>
            	
            <? } ?>

				<?
							                   			
			if(urlDecrypt($_GET['sm'])=='8'){ ?>
            
            <form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="8" type="hidden" />
                            <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                              <tr>
                                <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tambah Jenis Projek</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Jenis untuk</td>
                                <td colspan="2"><p>
                                  <label>
                                    <input accept="check" type="radio" name="RadioGroup1" value="0" id="RadioGroup1_0" />
                                    Kontraktor</label>
                                  <label>
                                    <input accept="check" type="radio" name="RadioGroup1" value="1" id="RadioGroup1_1" />
                                    Perunding</label>
                                  <br />
                                </p></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Jenis Projek</td>
                                <td colspan="2"><input accept="check" name="jenis" type="text" id="jenis" size="40" /></td>
                                <td width="5%">&nbsp;</td>
                                <td width="4%">&nbsp;</td>
                                <td width="7%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Singkatan</td>
                                <td colspan="2"><input accept="check" name="singkatan" type="text" id="singkatan" size="40" /></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="36%">&nbsp;</td>
                                <td width="33%">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style"/>
                                <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                                <input type="button" name="button11" id="button12" value="Batal" onclick="backpage()" class="button_style"/></td>
                              </tr>
                            </table>
                            </form>
            	
            <? } 

if(urlDecrypt($_GET['sm'])=='10'){
	if(isset($_GET['fd'])){
		include 'listDirancang.php';
	}else{
	?>
            <form id="form6" name="theForm" method="post" action="admin/form_p.php" onsubmit="return checkform()">
                <input name="m" value="1" type="hidden" />
                <input name="sm" value="10" type="hidden" />
                <input name="p_award" id="p_award" value="1" type="hidden" />
              <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                <tr>
                  <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Pendaftaran&nbsp;Projek&nbsp;Baru</strong></td>
                </tr>
                <tr>
                  <td colspan="8">&nbsp;</td>
                </tr>
                 <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Import Daripada Projek Dirancang</td>
                  <td colspan="4">
					<input style="cursor:pointer" type="button" value="Import" onclick="location.href='main.php?m=<?=urlEncrypt(1)?>&sm=<?=urlEncrypt(10)?>&md=1&fd=1'" />
                <tr>
                  <td colspan="8">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="8"><input name="year" value="<?=date("Y")?>" type="hidden" />
                  <input name="referen" value="0" type="hidden" />
                  <input name="bahagian" value="0" type="hidden" /></td>
                </tr>
                <tr>
                  <?
                    $sqlref="SELECT MAX(project_id) FROM project";
                    $ref=mysql_query($sqlref);	
                    $refoutput = mysql_fetch_row($ref);
                    
                    $refd = $refoutput[0] + 1;
                
               		 ?>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Pendaftaran Projek </td>
                  <td colspan="4"><input type="text" name="tarikh" id="tarikh" value="<?=date("d-m-Y");?>" readonly="readonly"/></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Lantikan Projek </td>
                  <td colspan="4"><input accept="check" type="text" name="tarikhLantikan" id="tarikhLantikan" readonly="readonly" style="cursor:pointer"/></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Projek Untuk</td>
                  <td colspan="4"><input accept="check" name="perunding" type="radio" id="perunding" value="0" onclick="bidangshow(this),jenis(this),get_contractor1(),get_type(this)"  />
                  <label for="Kontraktor">Kontraktor</label>
                    <input type="radio" accept="check" name="perunding" id="perunding" value="1" onclick="bidangshow(this),jenis(this),get_contractor1(),get_type(this)"  />
                  <label for="Perunding">Perunding</label>
                  </td>
                  <td width="1%"></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;No Kontrak</td>
                  <td colspan="4"><span id="type_short"><select  accept="check" id="no_kontrak" name="no_kontrak">
                  				<option value="0">---Sila Pilih---</option>
                    			</select>
                    			</span>
                      <input accept="check" type="text" name="no_kontrak2" id="no_kontrak2" size="5" onblur="check_kontrak()"/>
                      <strong>* 10
                      <input accept="check" type="text" name="no_kontrak3" id="no_kontrak3" onblur="check_kontrak()"  size="5"/>
                      * 2012</strong></td>
                  <td></td>
                </tr>
                <tr id="display_kategori" style="display:none">
                  <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;Kategori</td>
                  <td colspan="4"><div id="title"></div></td>
                  <td></td>
                </tr>
                <tr id="kategori_kerja" style="display:none">
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kategori&nbsp;Kerja</td>
                  <td colspan="4"><input name="katKerja" type="radio" id="katKerja" value="1" onclick="bidangshow2(this)"  />
                    <label for="Kontraktor4">Bangunan/Awam/Mekanikal</label>
                    &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="katKerja" id="katKerja" value="2" onclick="bidangshow2(this)"  />
                    <label for="Perunding4">Elektrik</label></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3"><span id="label_bidang"></span></td>
                  <td colspan="4"><div id="bidang"></div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Jenis</td>
                  <td colspan="4"><div id="jenisAjax"><select accept="check" >
                    <option value="0">---Sila Pilih---</option>
                  </select>
                    </div></td>
                  <td></td>
                </tr>
                
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kontraktor / Perunding </td>
                  <td colspan="4"><div id="kontraktor_bidang">
                    <select accept="check" name="kontraktor" id="kontraktor">
                      <option value="0">---Sila Pilih---</option>
                    </select>
                  </div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
                  <td colspan="4"><select accept="check" name="jabatan" id="jabatan" >
                    <option value="0">---Sila Pilih--</option>
                    <?
									$sql='select * from department where parent_id=0';
									$result = mysql_query($sql);
					  				while($row = mysql_fetch_array($result))
									{	
										?>
                    <option value="<?=$row['department_id'] ?>">
                      <?=$row['department_desc']?>
                    </option>
                    <?
										$sql2="select * from department where parent_id=".$row['department_id'];
										$result2 = mysql_query($sql2);
										while($row2 = mysql_fetch_array($result2))
										{
											?>
                    <option value="<?=$row2['department_id'] ?>"> ---
                      <?=$row2['department_desc']?>
                    </option>
                    <?
										}
									}
									?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Nama Projek</td>
                  <td colspan="4"><label for="nama projek2"></label>
                    <textarea accept="check" name="nama_projek" id="nama projek" cols="45" rows="5" ></textarea></td>
                  <td></td>
                </tr>
                
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Mula</td>
                  <td colspan="2"><input accept="check" type="text" name="datemula" id="mula" readonly="readonly" style="cursor:pointer"/>
                    &nbsp;</td>
                  <td width="7%" align="right">&nbsp;&nbsp;&nbsp;&nbsp;Tarikh&nbsp;Siap</td>
                  <td width="41%"><input accept="check" type="text" name="datetamat" id="tamat"  readonly="readonly" style="cursor:pointer" />
                    &nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Tempoh Siap</td>
                  <td colspan="4">
                  <input accept="check" type="radio" name="radio1" id="radio" value="radio" onclick="datediffhari()" />
                  <label for="hari">Hari</label>
                  <input accept="check" type="radio" name="radio1" id="radio2" value="radio2" onclick="datediffminggu()"/>
                  <label accept="check" for="minggu">Minggu</label>
                  <input accept="check" type="radio" name="radio1" id="radio3" value="radio3" onclick="datediffbulan()"/>
                  <label for="bulan">Bulan</label>
                  <input accept="check" type="radio" name="radio1" id="radio4" value="radio4" onclick="datedifftahun()"/>
                  <label for="tahun">Tahun</label>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td colspan="2"><span id="txtdatediff"></span></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Kawasan</td>
                  <td colspan="4">
                  	<table width="100%">
                    	<tr>
                        	<td width="10%">Parlimen</td>
                            <td width="1%"> : </td>
                        	<td>
							  <?
                              $sql = "Select * from kawasan where layer = 1";
                              $result = mysql_query($sql);						  
                              ?>
                              <select name="parlimen" id="parlimen" onchange="list_adun(this.value)" >
                              	<option value="0">---TIADA---</option>
                                <? while( $row = mysql_fetch_array($result)){?>
                                <option value="<?=$row['kwsn_id']?>"><?=$row['kwsn_desc']?></option>
                                <? }?>
                              </select>
                              &nbsp;&nbsp;<input type="checkbox" name="semuazon" id="semuazon" value="1" onclick="zonSemua()" /> Semua Zon
                             </td>
                   		</tr>
                        </tr>
                         <tr id="adunTr" style="display:none">
                          <td width="10%">Adun</td>
                          <td width="1%"> : </td>
                          <td><div id="adunAjax"></div> </td>
                        </tr>
                        <tr id="majlisTr" style="display:none">
                          <td width="10%">Majlis</td>
                          <td width="1%"> : </td>
                          <td><div id="majlisAjax"></div> </td>
                        </tr>
                     </table>
                   </td>
                <tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;No. Peruntukan</td>
                  <td colspan="4"><input name="no_peruntukan" type="text" id="no_peruntukan" size="40" /> <font color="#FF0000">* CTH : 30-05-02-01-92153</font></td> 
                  <td></td>
                </tr>
                <tr id="KonPerSebenar">
                  <td colspan="2"><label for="kos">&nbsp;&nbsp;&nbsp;&nbsp;Harga Kontrak Sebenar</label></td>
                  <td align="right">RM</td>
                  <td colspan="4"><span id="kosdisplay"><input accept="check" name="kos" type="text" id="kos" size="40" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></span> <input type="checkbox" value="1" name="checkbox_kos" id="checkbox_kos" onclick="kadar_harga()" />
                  Kadar Harga</td>
                  <td></td>
                </tr>
                 <tr id="KonAnggaran">
                  <td colspan="2"><label for="kos">&nbsp;&nbsp;&nbsp;&nbsp;Harga Kontrak Anggaran</label></td>
                  <td align="right">RM</td>
                  <td colspan="4"><span id="kosdisplay"><input accept="" name="kosAnggaran" type="text" id="kos" size="40" onKeyUp="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                  </td>
                  <td></td>
                </tr>
                <tr id="KonPerBulan">
                  <td colspan="2"><label for="kos2">&nbsp;&nbsp;&nbsp;&nbsp;Harga Kontrak Per Bulan</label></td>
                  <td width="4%" align="right">RM</td>
                  <td colspan="4"><span id="kosBulan">
                    <input name="kos2" type="text" id="kos2" size="40" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                  </span></td>
                  <td></td>
                </tr>
                <tr id="KonPerTahun">
                  <td colspan="2"><label for="kos3">&nbsp;&nbsp;&nbsp;&nbsp;Harga Kontrak Per Tahun</label></td>
                  <td align="right">RM</td>
                  <td colspan="4"><span id="kos3">
                    <input name="kos3" type="text" id="kos3" size="40" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" />
                   </span></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
              
                
                <!-- athirah 16102012 start -->
                
                <tr>
                  <td colspan="2"><label for="bon">&nbsp;&nbsp;&nbsp;&nbsp;Bon Perlaksanaan</label></td>
                  <td align="right">RM</td>
                  <td width="12%"><input type="text" name="bon" id="bon" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)" /></td>
                  <td width="17%"><input type="checkbox" value="1" name="checkbox_bon" id="checkbox_bon" />Kesemua</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                        
                <tr>
                  <td width="7%"><label for="kaedahbon">&nbsp;&nbsp;&nbsp;&nbsp;Kaedah</label></td>
                  <td colspan="2" align="right">RM</td>
                  <td colspan="4"><select name="kaedahbon" id="kaedahbon">
                                    <option value="">---Sila Pilih---</option>
                                    <option value="1">Tunai / Bank Draf</option>
                                    <option value="2">Jaminan Bank</option>
                                    <option value="3">Jaminan Insuran</option>
                                    <option value="4">Wang Jaminan Perlaksanaan (WJP)</option>
                                  </select></td>
                  <td></td>
                </tr>
                              <tr>
                                <td colspan="3" align="right"><label for="textfield2"></label>
                                  <input type="hidden" name="counter2" id="counter2" value="4" /></td>
                                <td colspan="2"><label for="textfield3"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                                </tr>
                              <tr>
                                <td colspan="7"><table width="100%">
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2" align="right">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td width="14%">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Maklumat Insuran</strong></td>
                                    <td colspan="2" align="right"><label for="textfield10"></label>
                                      <input type="hidden" name="counter3" id="counter3" value="4" /></td>
                                    <td width="65%"><label for="textfield11"></label>
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                                    <td width="1%" colspan="2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Polisi Insuran</td>
                                    <td colspan="2" align="right"><table width="100%" border="0">
                                      <tr>
                                        <td width="6%" align="right">1.</td>
                                        <td width="34%"><input type="text" name="insuran1" id="insuran1" size="40" value="Insuran Risiko Semua Kontraktor" /></td>
                                        <td width="43%">&nbsp;RM
                                          <label for="textfield12"></label>
                                          <input type="text" name="nilai1" id="nilai1" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/></td>
                                      </tr>
                                    </table>
                                      <table width="100%" border="0">
                                        <tr>
                                          <td width="6%" align="right">2.</td>
                                          <td width="34%"><input type="text" name="insuran2" id="insuran2" size="40" value="Insuran Pampasan Pekerja" /></td>
                                          <td width="43%">&nbsp;RM
                                            <label for="textfield12"></label>
                                            <input type="text" name="nilai2" id="nilai2" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/></td>
                                        </tr>
                                      </table>
                                      <table width="100%" border="0">
                                        <tr>
                                          <td width="6%" align="right">3.</td>
                                          <td width="34%"><input type="text" name="insuran3" id="insuran3" size="40" value="Insuran Tanggungan Awam" /></td>
                                          <td width="43%">&nbsp;RM
                                            <label for="textfield12"></label>
                                            <input type="text" name="nilai3" id="nilai3" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/></td>
                                        </tr>
                                      </table>
                                      <table width="100%" border="0">
                                        <tr>
                                          <td width="6%" align="right">4.</td>
                                          <td width="34%"><input type="text" name="insuran4" id="insuran4" size="40" value="Insuran Profesionam Indemnity" /></td>
                                          <td width="43%">&nbsp;RM
                                            <label for="textfield12"></label>
                                            <input type="text" name="nilai4" id="nilai4" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/></td>
                                        </tr>
                                      </table>
                                      <div id="kaedah"></div>
                                      <span style="text-align: left"></span> <span style="text-align: left"></span>
                                        <table width="100%" border="0">
                                        <tr>
                                          <td width="6%" align="right"></td>
                                          <td width="34%"><input type="checkbox" value="1" name="checkbox_insuran" id="checkbox_insuran" />Kesemua</td>
                                          <td width="43%"></td>
                                        </tr>
                                      </table>
                                      <center><input type="button" name="Tambah" id="Tambah" value="Tambah Insuran" onclick="addinsuran('kaedah')" /></center></td>
                                   
                                    <td colspan="2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="2" align="right">&nbsp;</td>
                                    <td colspan="2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Maklumat Pegawai Projek</strong></td>
                                    <td colspan="2" align="right">&nbsp;</td>
                                    <td colspan="2">&nbsp;</td>
                                  </tr>
                                </table></td>
                              </tr>
                      
                <tr>
                                <td colspan="3">&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Pegawai Projek</td>
                  <td colspan="2"><select accept="check" name="p_projek" id="p_projek" onchange="email2(this), jawatan2(this)" >
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sql='select * from user order by user_name';
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result))
                        {
                    ?>
                    <option value="<?=$row['user_id'] ?>">
                      <?=$row['user_name']?>
                    </option>
                    <? 
                    }	
                        ?>
                  </select></td>
                  <td align="right">Jawatan</td>
                  <td><div id="jawatanAjax">
                    <input type="text" accept="check" name="jawatan_pprojek" id="jawatan_pprojek" size="40" readonly="readonly" />
                  </div></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Email Pegawai Projek</td>
                  <td colspan="2"><label for="textfield7"></label>
                    <div id="emailAjax">
                      <input type="text" accept="check" name="email" id="email" size="40" readonly="readonly"/>
                  </div></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Penolong Pegawai Projek</td>
                  <td colspan="2"><input name="pen_projek" type="text" id="pen_projek" onmouseover="" size="40" />
                    <!--<input name="bulan" id="bulan" type="hidden" onmouseover="" size="40" />
                  					<input name="tahun" id="tahun" type="hidden" onmouseover="" size="40" />--></td>
                  <td align="right">Jawatan</td>
                  <td><select name="jawatan_penprojek" id="jawatan_penprojek">
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sql='select * from jawatan order by jawatan_desc';
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result))
                        {
                    ?>
                    <option value="<?=$row['jawatan_id'] ?>">
                      <?=$row['jawatan_desc']?>
                    </option>
                    <? 
                    }	
                        ?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;PTBK/PTB/Juruteknik</td>
                  <td colspan="2"><input name="ptbk" type="text" id="ptbk" size="40"/></td>
                  <td align="right">Jawatan</td>
                  <td><select name="jawatan_ptbk" id="jawatan_ptbk">
                    <option value="0">---Sila Pilih---</option>
                    <?
                    $sql='select * from jawatan order by jawatan_desc';
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result))
                        {
                    ?>
                    <option value="<?=$row['jawatan_id'] ?>">
                      <?=$row['jawatan_desc']?>
                    </option>
                    <? 
                    }	
                        ?>
                  </select></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="4">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="4">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td colspan="4">&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="8">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="8">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="8"><div id="txtconvertdate"></div>&nbsp;</td>
                </tr>
                <tr bgcolor="#999999" align="right">
                  <td colspan="8"><input type="submit" name="hantar" id="hantar" value="Simpan" class="button_style"/>        
                  				<input type="reset" name="reset" id="reset" value="Set Semula" class="button_style"/>
                                <input type="button" name="batal" id="batal" value="Batal" onclick="backpage()" class="button_style"/></td>
                </tr>
              </table>
              
            </form>
<?			}		
} if(urlDecrypt($_GET['sm'])=='12'){
?>	
	
			<form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="12" type="hidden" />
                    <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid; color: #000;">
                      <tr>
                        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tambah Bidang Perunding
                          <label for="textfield"></label>
                          <input type="hidden" name="perunding" id="perunding" value="1" />
                        </strong></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Bidang</td>
                        <td colspan="2"><div id="bidangdata"><label for="Bidang"></label>
                          <?
                          $sql = "Select * from kepala where perunding = 1";
						  $result = mysql_query($sql);						  
						  ?>
                          <select accept="check" name="bidangselect" id="bidangselect" onchange="subbidang(this.value)">
                            <option value="0">---Sila Pilih---</option>
                            <? while( $row = mysql_fetch_array($result)){?>
                            <option value="<?=$row['kepala_id']?>|<?=$row['kepala_kod']?>"> <?=$row['kepala_kod']?> - <?=$row['kepala_desc']?></option>
                            <? }?>
                        </select>&nbsp;&nbsp;&nbsp;<a href="#" onclick="tambah_bidang()" style=" color:#00F ; text-decoration:underline">Tambah Bidang</a></div></td>
                        <td width="5%"><input name="kod_1" id="kod_1" value="" type="hidden" /></td>
                        <td width="4%">&nbsp;</td>
                        <td width="7%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Sub Bidang</td>
                        <td colspan="2"><div id="sub_kepala"></div></td>
                        <td><input name="kod_2" id="kod_2" value="" type="hidden" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Pecahan Sub Bidang <strong>:</strong></td>
                        <td><span id="pecahan_bidang">Kod</span></td>
                        <td><label for="textfield"></label>
                        <input type="text" accept="check"name="kod" id="kod" size="40" onkeyup="checknumber(this),limitText(this,2,2)"/></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>Pecahan Sub Bidang</td>
                        <td><input accept="check" type="text" name="nama" id="nama" size="40" onBlur="first_uppercase(this)"/></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td width="12%">&nbsp;</td>
                        <td width="57%">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr bgcolor="#999999">
                        <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style"/>
                        <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                        <input type="button" name="button12" id="button13" value="Batal" onclick="backpage()" class="button_style"/></td>
                      </tr>
                    </table>
                    </form><?
	}	
	
//athirah 21-03-2013 start
   if(urlDecrypt($_GET['sm'])=='13'){
?>	
	
  <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Tambah Kawasan</a></li>
    <li><a href="#tabs-2">Tambah Ahli</a></li>
  </ul>
   <form id="tabs-1" action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="13.1" type="hidden" />
                    <table width="200" border="0" style="padding:2px; width:80%; border:#999999 1px solid; color: #000;">
                      <tr>
                        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tambah Kawasan Parlimen/Adun/Majlis</strong></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                      	<td>&nbsp;</td>
                        <td width="100%">
                        	<table width="100%">
                            	<tr>
                                	<td width="10%">Peringkat</td>
                                    <td width="1%"> : </td>
                                    <td>
                                         <?
										  $sql = "Select * from kwsn_peringkat";
										  $result = mysql_query($sql);						  
										  ?>
										  <select accept="check" name="layer" id="layer" onchange="hide_kwsn(1)">
										  <option value="0">---Sila Pilih---</option>
											<? while( $row = mysql_fetch_array($result)){?>
											<option value="<?=$row['kp_ID']?>"><?=$row['nama_peringkat']?></option>
											<? }
										 ?>
                                    </td>
    							</tr>
							</table>
                        </td>
                         <td width="5%">&nbsp;</td>
                         <td width="4%">&nbsp;</td>
                         <td width="7%">&nbsp;</td>
					  </tr>
                      <tr id="parlimen" style="display:none">
                      	<td>&nbsp;</td>
                        <td width="100%">
                        	<table width="100%">
                            	<tr>
                                	<td width="10%">Parlimen</td>
                                    <td width="1%"> : </td>
                                    <td>
									  <?
                                      $sql = "Select * from kawasan where layer = 1";
                                      $result = mysql_query($sql);						  
                                      ?>
                                      <select name="parlimen" id="parlimen" onchange="list_adunAdd(this.value)">
                                      	<option value="0">---Sila Pilih---</option>
                                        <? while( $row = mysql_fetch_array($result)){?>
                                        <option value="<?=$row['kwsn_id']?>"><?=$row['kwsn_desc']?></option>
                                        <? }?>
                                      </select>
                                  </td>
                              </tr>
							</table>
                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="4%">&nbsp;</td>
                        <td width="7%">&nbsp;</td>
                      </tr>
                      <tr id="adun" style="display:none">
                      	<td>&nbsp;</td>
                        <td width="100%">
                        	<table width="100%">
                            	<tr>
                                	<td width="10%">Adun</td>
                                    <td width="1%"> : </td>
                                    <td>
									  <div id="adunAjax"></div>
                                  </td>
                              </tr>
							</table>
                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="4%">&nbsp;</td>
                        <td width="7%">&nbsp;</td>
                      </tr>
                      <tr>
                      	<td>&nbsp;</td>
                        <td width="100%">
                        	<table width="100%">
                            	<tr>
                                	<td width="10%">Nama</td>
                                    <td width="1%"> : </td>
                                    <td><input type="text" accept="check" name="nama2" id="nama2" onblur="capitalize(this)" size="40" /></td>
                                </tr>
							</table>
                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="4%">&nbsp;</td>
                        <td width="7%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td width="12%">&nbsp;</td>
                        <td width="57%">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr bgcolor="#999999">
                        <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style"/>
                        <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                        <input type="button" name="button12" id="button13" value="Batal" onclick="backpage()" class="button_style"/></td>
                      </tr>
                    </table>
                    </form>
                    
 					 <form id="tabs-2" action="admin/form_p.php" method="post" name="theForm2" onsubmit="">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="13.2" type="hidden" />
                    <table width="200" border="0" style="padding:2px; width:80%; border:#999999 1px solid; color: #000;">
                      <tr>
                        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tambah Ahli Parlimen/Adun/Majlis</strong></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                      	<td>&nbsp;</td>
                        <td width="100%">
                        	<table width="100%">
                            	<tr>
                                	<td width="20%">Parlimen/Adun/Majlis</td>
                                    <td width="1%"> : </td>
                                    <td>
                                         <?
										  $sql = "Select * from kawasan order by seq_no";
										  $result = mysql_query($sql);						  
										  ?>
										  <select accept="check" name="kawasan" id="kawasan">
										  <option value="0">---Sila Pilih---</option>
											<? while( $row = mysql_fetch_array($result)){
												if($row['layer']==3){
													$sign="&nbsp;----";	
												}
												elseif($row['layer']==2){
													$sign="&nbsp;--";	
												}else{
													$sign="";
												}	
											?>
											<option value="<?=$row['kwsn_id']?>"><?=$sign.$row['kwsn_desc']?></option>
											<? }
										 ?>
                                    </td>
    							</tr>
							</table>
                        </td>
                         <td width="5%">&nbsp;</td>
                         <td width="4%">&nbsp;</td>
                         <td width="7%">&nbsp;</td>
					  </tr>
                      <tr>
                      	<td>&nbsp;</td>
                        <td width="100%">
                        	<table width="100%">
                            	<tr>
                                	<td width="20%">Nama Ahli</td>
                                    <td width="1%"> : </td>
                                    <td><input type="text" accept="check" name="nama2" id="nama2" onblur="capitalize(this)" size="40" /></td>
                                </tr>
							</table>
                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="4%">&nbsp;</td>
                        <td width="7%">&nbsp;</td>
                      </tr>
                       <td>&nbsp;</td>
                        <td width="100%">
                        	<table width="100%">
                            	<tr>
                                	<td width="20%">Tarikh Efektif</td>
                                    <td width="1%"> : </td>
                                    <td><input accept="check" type="text" name="datemula" id="mula" readonly="readonly" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;hingga&nbsp;&nbsp;&nbsp;<input accept="check" type="text" name="datetamat" id="tamat" style="cursor:pointer" value="-"/></td>
                                </tr>
                                <tr>
                               	  <td>&nbsp;
                                  </td>
                                	<td colspan="2" >
                                    <br><font color="#FF0000">* Isikan (-) untuk set tarikh efektif sampai bila-bila </font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="4%">&nbsp;</td>
                        <td width="7%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td width="12%">&nbsp;</td>
                        <td width="57%">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr bgcolor="#999999">
                        <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style"/>
                        <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                        <input type="button" name="button12" id="button13" value="Batal" onclick="backpage()" class="button_style"/></td>
                      </tr>
                    </table>
                    </form>
 </div>
<?
//	athirah 21-03-2013 end
//shah 20/6/13 start
}if(urlDecrypt($_GET['sm'])=='14'){
?>	
	
			<form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="14" type="hidden" />
                            <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                              <tr>
                                <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tambah Gred Pendaftaran Projek</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                              <tr>
                                <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Nama Gred</td>
                                <td colspan="2"><input accept="check" name="gred" type="text" id="gred" size="40" /></td>
                                <td width="5%">&nbsp;</td>
                                <td width="4%">&nbsp;</td>
                                <td width="7%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Had</td>
                                <td colspan="2"><input accept="" name="had" type="text" id="had" size="40" /></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Kategori Kontraktor</td>
                                <td colspan="2"><p>
                                  <label>
                                    <input accept="check" type="radio" name="RadioGroup1" value="1" id="RadioGroup1_0" />
                                    Kerja</label>
                                  <label>
                                    <input accept="check" type="radio" name="RadioGroup1" value="2" id="RadioGroup1_1" />
                                    Elektrik</label>
                                  <br />
                                </p></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Efektif</td>
                                <td colspan="2"><input accept="check" name="datemula" readonly="readonly" type="text" id="mula" size="20" />&nbsp;&nbsp;&nbsp;hingga&nbsp;&nbsp;&nbsp;<input accept="check" name="datetamat" type="text" id="tamat" value="-" size="20" /></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                             <tr>
                                <td>&nbsp;</td>
                                <td width="36%">  <br><font color="#FF0000">* Isikan (-) untuk set tarikh efektif sampai bila-bila </font></td>
                                <td width="33%">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr bgcolor="#999999">
                                <td colspan="6" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style"/>
                                <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                                <input type="button" name="button11" id="button12" value="Batal" onclick="backpage()" class="button_style"/></td>
                              </tr>
                            </table>
                            </form>
			<? 
			}
			if(urlDecrypt($_GET['sm'])=='15'){ 	
			?>
					<form action="admin/form_p.php" method="post" name="theForm" onsubmit="return checkform()">
							<input name="m" value="1" type="hidden" />
							<input name="sm" value="15" type="hidden" />
              <table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid">
                <tr>
                  <td colspan="2"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Akaun Ahli Majlis</strong></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
                  <td><?
					  $sql = "Select * from ahli where regAcc = 0 order by nama_ahli";
					  $result = mysql_query($sql);						  
					  ?>
					  <select accept="check" name="ahli" id="ahli" onchange="infoAhli(this.value)">
					  <option value="0">---Sila Pilih---</option>
						<? while( $row = mysql_fetch_array($result)){	
						?>
						<option value="<?=$row['ahli_id']?>"><?=$row['nama_ahli']?></option>
						<? }
					 ?>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="15%">&nbsp;&nbsp;&nbsp;&nbsp;Parlimen/Adun/Majlis</td>
                  <td width="48%"><span id="kwsnAhli" style="height:17px;">&nbsp;-</span></td>
                  <td width="12%">&nbsp;</td>
                  <td width="11%">&nbsp;</td>
                  <td width="14%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Tempoh Khidmat</td>
                  <td><span id="tempohAhli" style="height:17px;">&nbsp;-</span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Id Pengguna</td>
                  <td><input name="idpengguna" type="text" id="idpengguna" size="40" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
    			<tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Email</td>
                  <td><input name="email" type="text" id="email" size="40" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Tel</td>
                  <td><input name="notel" type="text" id="no tel" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />                    * nombor sahaja</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Tel Bimbit</td>
                  <td><input name="notelbimbit" type="text" id="no tel bimbit" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" />
                  * nombor sahaja</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr >
                  <td colspan="5" align="right">&nbsp;</td>
                </tr>
                <tr bgcolor="#999999">
                  <td colspan="5" align="right"><input type="submit" name="button4" id="button4" value="Simpan" class="button_style" />
                  <input type="reset" name="button4" id="button6" value="Set Semula" class="button_style"/>
                  <input type="button" name="button6" id="button7" value="Batal" onclick="backpage()" class="button_style"/></td>
                </tr>
              </table>
              </form>
            <?
          }//shah end	
?> 					

<script language="Javascript" type="text/javascript"> 
		function backpage(){
		document.location.href="main.php?m=<?=urlDecrypt($_GET['m'])?>&sm=<?=urlDecrypt($_GET['sm'])?>";
		}
</script>			