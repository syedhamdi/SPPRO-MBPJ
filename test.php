<? include 'include/connection.php';?>
<html>
 <head>
 <script type="text/javascript">
 function showUser(str)
 {
 if (str=="")
   {
   document.getElementById("txtHint").innerHTML="";
   return;
   } 
 if (window.XMLHttpRequest)
   {// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
   }
 else
   {// code for IE6, IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
 xmlhttp.onreadystatechange=function()
   {
   if (xmlhttp.readyState==4 && xmlhttp.status==200)
     {
     document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
     }
   }
 xmlhttp.open("GET","getuser.php?q="+str,true);
 xmlhttp.send();
 }
 </script>
 </head>
 <body>

 <form>
 
									<?
								$sql='select * from department';
								$result = mysql_query($sql);?>
									<select name="users" onChange="showUser(this.value)">
					 				<option value="0">---Sila Pilih--</option><?
					  				while($row = mysql_fetch_array($result))
									{
									?> 
									<option value=<?=$row['department_id'] ?>><?=$row['department_desc']?></option> 
									<? 
									}	
									?>
					  			 	</select>
 </form>
 <br />
 <div id="txtHint"><b>Person info will be listed here.</b></div>

 

 </body>
 </html>