<?php
session_start();
//setup general variable
include 'include/connection.php';
include 'include/serversidescript.php';
$_SESSION['system_name']='SPPro :: Sistem Pemantauan Projek Online';

?>
<html>
<head>
<title><?php echo $_SESSION['system_name']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="CSS/Style.css" rel="stylesheet" type="text/css">
<script language="javascript">

function submitform(){
	if (validate()) {
		document.getElementById("btnSubmit").disabled="true";
		document.theForm.action='index.php';
		document.theForm.submit();
	}
}
function validate() {
	if (document.getElementById("user_login").value=="") {
		alert("Sila masukkan ID Pengguna");
		return false;
	}
	if (document.getElementById("user_pwd").value=="") {
		alert("Sila masukkan Katalaluan");
		return false;
	}
	return true;
}
function alertmsg(){
	alert("Sila masukkan ID Pengguna dan Katalaluan");
}

function ENTER(theValue)
{
	if(theValue == 13)
		submitform();
		
}
</script>

<style type="text/css">
body,td,th {
	color: #FFF;
}
</style>
</head>

<?php

	if((isset($_POST['user_login']))&&(isset($_POST['user_pwd']))){
		if (($_POST['user_login']!="")&&($_POST['user_pwd']!="")) {
			
			$sqlLoginFirst = "select * from user where user_login='".$_POST['user_login']."' and user_password='".$_POST['user_pwd']."'";
			$loginFirst = mysql_query($sqlLoginFirst);
			$usrCnt=0;
			while($rowLoginFirst = mysql_fetch_array($loginFirst)) {					
					$verifyU = $rowLoginFirst["ahli_majlis"];
				$usrCnt++;				
			}		
			if ($usrCnt==0) {
				?><script language="javascript">
			
				alert("ID Pengguna atau Katalaluan salah");
			
				</script>
				<?php	
			}else{
				if($verifyU==0){
					$sqlLogin = "select *, user_group. *, department. *  from user u ".
								"inner join user_group on u.user_group_id = user_group.user_group_id ".
								"inner join department on u.department_id = department.department_id ".
								"where u.user_login='".$_POST['user_login']."' and u.user_password='".$_POST['user_pwd']."'";
					
					$login = mysql_query($sqlLogin);
				
					while($rowLogin = mysql_fetch_array($login)) {
						$_SESSION['id']=$rowLogin[0];
						$_SESSION['user_login']=$rowLogin[2];
						$_SESSION['user_name']=$rowLogin[1];
						$_SESSION['user_email']=$rowLogin[4];
						$_SESSION['user_notel']=$rowLogin[5];
						$_SESSION['user_nobimbit']=$rowLogin[6];
						$_SESSION['user_group_id']=$rowLogin[8];
						$_SESSION['user_dept']=$rowLogin[10];
						$_SESSION['user_group_desc']=$rowLogin['user_group_desc'];
						$_SESSION['department_desc']=$rowLogin['department_desc'];
						$_SESSION['user_group_layer']=$rowLogin['user_group_layer'];
						//$_SESSION['department_id']=$rowLogin['department_id'];
						$_SESSION['user_group_id']=$rowLogin['user_group_id'];
						$_SESSION['ahli_majlis']=$rowLogin['ahli_majlis'];
						
						$sqlModule="select * from user_group_module where user_group_id=".$_SESSION['user_group_id'];
	
							$resultModule = mysql_query($sqlModule);
							$mainpage=0;
							while($rowsM = mysql_fetch_array($resultModule)){
								if ($rowsM["module_id"]==1) {
								$mainpage=1;
								}
							}
							
							if ($mainpage==1) {
								echo '<META HTTP-EQUIV="Refresh" Content="0; URL=main.php">';
							} else {
								echo '<META HTTP-EQUIV="Refresh" Content="0; URL=main.php?m='.urlEncrypt(2).'">';
							}		
					}
				}else{
					$sqlLogin = "select * from user u ".
								"inner join ahli a on u.ahli_majlis = a.ahli_id ".
								"inner join kawasan k on a.kawasan_id = k.kwsn_id ".
								"inner join kwsn_peringkat kp on kp.kp_id = k.layer ".
								"where u.user_login='".$_POST['user_login']."' and u.user_password='".$_POST['user_pwd']."'";
					
					$login = mysql_query($sqlLogin);
				
					while($rowLogin = mysql_fetch_array($login)) {
						$_SESSION['id']=$rowLogin[0];
						$_SESSION['user_login']=$rowLogin[2];
						$_SESSION['user_name']=$rowLogin[1];
						$_SESSION['user_email']=$rowLogin[4];
						$_SESSION['user_notel']=$rowLogin[5];
						$_SESSION['user_nobimbit']=$rowLogin[6];
						$_SESSION['ahli_majlis']=$rowLogin['ahli_majlis'];
						$_SESSION['peringkat']=$rowLogin['nama_peringkat'];
						$_SESSION['kawasan']=$rowLogin['kwsn_desc'];
						$_SESSION['kawasan_id']=$rowLogin['kwsn_id'];
						$_SESSION['peringkat_id']=$rowLogin['layer'];
						
						echo '<META HTTP-EQUIV="Refresh" Content="0; URL=main.php">';
						//echo '<META HTTP-EQUIV="Refresh" Content="0; URL=main.php?m='.urlEncrypt(4).'">';
					}
				}
			}

		}
		
	}
		
?>

<body background="images/login_bg2.png" onLoad="document.theForm.user_login.focus()">
<form name="theForm" method="post">
<table width="751" height="463" border="0"  align="center" background="images/login_bg.png" >
<tr><td height="382" align="right">

	<table width="255"  border="0" style="margin-right:80px; width:270px; margin-top:130px" >
		<tr>
		<td style="color:#FFFFFF; font-weight:bold" >ID Pengguna</td>
        <?php
        	if (isset($_POST['user_login'])) {
				if (($_POST['user_login'])!="") {
					$user_login = $_POST['user_login'];
				} else {
					$user_login="";
				}
			} else {
				$user_login = "";
			}
		?>
		<td align="right"><input type="text" name="user_login" id="user_login" size="30" value="<?=$user_login?>"></td>
		</tr>
		<tr>
		<td style="color:#FFFFFF; font-weight:bold">Katalaluan</td>
		<td align="right"><input type="password" name="user_pwd" id="user_pwd" size="30" onKeyUp="ENTER(event.keyCode)"></td>
		</tr>		
		<tr>
		<td colspan="2" align="right"><input type="button" name="btnSubmit" id="btnSubmit" value="Login" style="width:50px; font-weight:bold" onClick="submitform(document.theForm)"></td>
		</tr>	
		<tr>
		<td colspan="2" align="left" style="color:#FFFFFF; font-weight:bold"></td>
		</tr>		

	</table>
</td></tr>	
<tr>
<td align="center" valign="middle" style="color:#CCCCCC; font-size:9px">
&copy; Hak Cipta <?php echo date('Y')?> AUFA Intelligence Sdn. Bhd.
</td>
</tr>
</table>	
</form>
</body>
</html>