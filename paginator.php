<?php
	/*
		Place code to connect to your DB here.
	*/
	//include('include/connection.php');	// include your code to connect to DB.

	$tbl_name="gred";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	
	$query = "SELECT COUNT(*) as num FROM '".$tbl_name."'";
	$total_pages = mysql_fetch_array($query);
	//$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "pagination.php"; 	//your file name  (the name of this file)
	$limit = 2; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * FROM $tbl_name LIMIT $start, $limit";
	$result = mysql_query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">� previous</a>";
		else
			$pagination.= "<span class=\"disabled\">� previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">next �</a>";
		else
			$pagination.= "<span class=\"disabled\">next �</span>";
		$pagination.= "</div>\n";		
	}
?>
<div  >
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
		  <a style="font-size:10px; font-weight:bold; color:#0000FF" title="Tambah Rekod" href="main.php?m=<?=$_GET['m']?>&sm=<?=$_GET['sm']?>&md=1"><img src="./images/addIcon.gif" style="vertical-align:middle;" border="0" /> Tambah rekod</a>
		  </div>
		 
		</div>
		
		<form name="theForm" method="post"> 
		<table border="1" bordercolor="#FFFFFF" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid" >
		
				<tr class="Color-header" >
				<td width="5%"><input type="checkbox" name="chk_all" onclick="check_all()" title="Klik untuk pilih semua rekod" style="cursor:hand" /></td>
				<td width="5%">Bil.</td>				
				<?php
				$i=0;
				while ($i < mysql_num_fields($result)) {						
					$meta = mysql_fetch_field($result, $i);
					if($meta->primary_key==0){
						?><td><?php echo $meta->name?></td><?php	
					}
					
				$i++;		  								
				}
				?>
				</tr>			
				<?php					
				$j=0;
				$k_=0;
				$l_=0;

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
							<tr  class="<?php echo $class?>" height="20" onmouseover="effect2('1',this,'<?php echo $color?>')" onmouseout="effect2('2',this,'<?php echo $color?>')">
								<td>
								<input type="checkbox" name="chk_del[]"  style="cursor:hand" value="<?=$row[0]?>"/><a href="#" title="Kemaskini Rekod"><img src="./images/editIcon.gif" border="0" /></a>
								</td>
								<td>
								<?php
								if($label=='Jabatan/Bahagian/Unit'){
									if($row['Peringkat']==2){
										echo '&nbsp;&nbsp;&nbsp;&nbsp;';
										echo ($k_).'.'.($l_+1);
										$l_++;
									}else{
										echo $k_+1;
										$k_++;
									}
								}else{
									echo $j+1	;							
								}                                
								?>
                                
								
                                </td>
								<?php
								$k=0;
								while ($k < mysql_num_fields($result)) {						
									$meta = mysql_fetch_field($result, $k);
									if($meta->primary_key==0){
										if($meta->name=='Warna'){
											?><td bgcolor="<?php echo $row[$meta->name]?>">&nbsp;</td><?php	
										}else{
											?><td >										
											<?
											if($meta->name=='Jabatan/Bahagian/Unit'){
												if($row['Peringkat']==2){
													echo '&nbsp;&nbsp;&nbsp;&nbsp;';
												}
											}																						
											if($k==1){
												?><a  class="text_link" href="#" title="Kemaskini Rekod"><?
											}																						
											echo $row[$meta->name];
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
					?>		<tr><td colspan="20" align="center" style="font-size:10px; background-color:#666666; color:#FFFFFF; font-style: italic">-- Senarai Tamat --</td></tr>						<?php
				}else{
					?><tr><td colspan="20" align="center" style="font-size:10px; color: #333333; color:#FF0000">-- Tiada Rekod --</td></tr><?php						
				}	
		?>
		</table>
		</form>
		
	</div>
</div>	
        
<?=$pagination?>
	