<table border="" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td width="1%" style="padding:3px">
		<?php include 'left_menu.php';?>
	</td>

	<td style="padding:5px">
		<?php 
		if(!(isset($_GET['sm']))){
			include 'admin_main.php';		
		}else{
			if(!(isset($_GET['md']))){
				include 'list.php';		
			}elseif($_GET['md']=='1'||$_GET['md']=='2'){ //add or edit action
				include 'form.php';							
			}	
		}
		?>
	</td>
</tr>
</table>