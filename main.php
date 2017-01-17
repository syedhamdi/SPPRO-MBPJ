<?php 	
session_start(); 
include './include/connection.php';
include 'include/serversidescript.php';
include('MyFCPHPClassCharts/Class/FusionCharts.php');
include('MyFCPHPClassCharts/Class/DBConn.php');

if($_SESSION['user_name']==""){
	 header( 'Location: http://localhost:81/sppro-mbpj/index.php' ) ;
}

if(isset($_SESSION['peringkat'])==""){ $_SESSION['peringkat']=""; }
if(isset($_SESSION['kawasan'])==""){ $_SESSION['kawasan']=""; }

?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<style type="text/css">
  /*this is what we want the div to look like
    when it IS showing*/
  div.centered{
    position:fixed;
    top: 50%;
    left: 50%;
    width:30em;
    height:18em;
    margin-top: -9em; /*set to a negative number 1/2 of your height*/
    margin-left: -15em; /*set to a negative number 1/2 of your width*/
    border: 1px solid #ccc;
    background-color: #f3f3f3;
  }
</style>

<script language="javascript" type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery-ui-1.10.3.js"></script>
<script language="javascript" type="text/javascript" src="MyFCPHPClassCharts/FusionCharts/FusionCharts.js"></script>
<script language="javascript" type="text/javascript" src="js/AjaxScriptNew.js"></script>
<script language="javascript" type="text/javascript" src="js/javascript.js"></script>
<script src="js/datetimepicker_css.js"></script>

<title>

<?php echo $_SESSION['system_name']?>

</title>
<link rel="stylesheet" href="CSS/jquery-ui-1.10.3.css" />
<link href="CSS/Style.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" style="background-repeat:repeat-x; background:url(images/login_bg2.png); overflow-Y:auto; overflow-X:hidden;">

<div id="container" style="display:none;position:absolute;border:0px red solid; width:100%; z-index:99999999999; overflow-Y:auto;">
	<?=include 'container.php';?>
</div>



<div style=" width:100%; background: url(images/top_bg.jpg); position:relative; background-repeat:repeat-x " align="center">
  <div style="color: #FFFFFF; font-size:11px; font-weight:bold; width:99%; height:28px; padding-top:0px; font-size:10px" align="right" >
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="50%" class="teks-whiteb" style="color: #E4E4E4">
             <img src="images/mbpj_logo.gif" height="80" style="vertical-align:middle; float:left; position:absolute; left:0px"><br>
            <br>
            <br>
            <!--Jabatan Kejuruteraan<br> Bahagian Mekanikal & Elektrikal-->
        </td>
        <td class="teks-whiteb" valign="top" align="right" width="50%"> 
			<img src="images/user.gif" title="Kemaskini Profil">
            <?
            	if(isset($_SESSION['ahli_majlis'])==0){
					?><span style="position:relative; top:-7px;"><?=$_SESSION['user_name']?>&nbsp;[&nbsp;<?=$_SESSION['user_group_desc']?>&nbsp;]</span><?	
				}else{
					/*?><span style="position:relative; top:-7px;"><?=$_SESSION['user_name']?>&nbsp;[&nbsp;<?=$_SESSION['peringkat']?>&nbsp;:&nbsp;<?=$_SESSION['kawasan']?>]</span><?*/
				}
			?>
	    </td>
      </tr>
    </table>
  </div>
  <div style="color: #FFFFFF; font-size:11px; font-weight:bold; width:99%;  margin-top:0px; position:relative;  background:url(images/banner_bg.jpg);background-repeat:no-repeat; background-position: top" align="left" > 
	  <div align="left"><img src="images/Logo.gif" style="margin-left:60px" >
 	  <div align="right" class="teks-white" style="position:absolute; top:0px; right:0px">
	  <a class="teks-whiteb" href="#" onClick="update()">Kemaskini Profil</a> | 
	  <a class="teks-whiteb" href="#" onClick="password()">Tukar Katalaluan</a> | 
	  <a class="teks-whiteb" onClick="" href="logout.php">Logout</a></div>
	  </div> 
   
		<div id="menu_bar" style="border:0px red solid; margin-top:4px; background:url(images/center_menu_bar.png); background-repeat:repeat-x; background-position:top; font-size:11px; color: #FFFFFF; padding-top:0px; padding-left:15px; height:42px;">
            <div id="div1" style="display:none"><a id="mnu" href="main.php"><font id="font1" style="font-size:14px;">Laman Utama</font></a><img src="images/divider_menu_bar.gif" style="vertical-align:middle;"></div>
            <div id="div2" style="display:none"><a id="mnu1" href="main.php?m=<?=urlEncrypt(1)?>"><font id="font2" style="font-size:14px;">Pentadbir</font></a> <img src="images/divider_menu_bar.gif" style="vertical-align: middle;"></div>
            <div id="div3" style="display:none"><a id="mnu2" href="main.php?m=<?=urlEncrypt(2)?>"><font id="font3" style="font-size:14px;">Projek Info</font></a> <img src="images/divider_menu_bar.gif" style="vertical-align: middle;"></div>
            <div id="div6" style="display:none"><a id="mnu5" href="main.php?m=<?=urlEncrypt(5)?>"><font id="font6" style="font-size:14px;">Projek Dirancang</font></a> <img src="images/divider_menu_bar.gif" style="vertical-align: middle;"></div> 
            <div id="div4" style="display:none"><a id="mnu3" href="main.php?m=<?=urlEncrypt(3)?>"><font id="font4" style="font-size:14px;">Kemaskini Kemajuan Projek</font></a> <img src="images/divider_menu_bar.gif" style="vertical-align: middle;"></div>  
            <div id="div5" style="display:none"><a id="mnu4" href="main.php?m=<?=urlEncrypt(4)?>"><font id="font5" style="font-size:14px;">Carian Laporan</font></a> <img src="images/divider_menu_bar.gif" style="vertical-align: middle;"></div>
            <!--<div id="div6" style="display:none"><a id="mnu5" href="main.php?m=5">Carian</a> <img src="images/divider_menu_bar.gif" style="vertical-align: middle;"></div> 
            <div id="div7" style="display:none"><a id="mnu6" href="main.php?m=6">Bantuan</a>-->
		</div>
	  <script language="javascript">
	 // if(document.getElementById('mnu< ?php echo $_GET['m']?>')) {
	//  document.getElementById('mnu< ?php echo $_GET['m']?>').style.color='#FFFF00';
	  //}
	  </script>
	  </div>
	
	  <div id="content_box" style="width:99%;position:relative; color:#666666; background-repeat:repeat-x; background-color:#FFFFFF;border: #999999 3px solid; margin-top:0px;">
	  <table width="100%" cellpadding="0" cellspacing="0" height="430px" >
	  <tr>
	  <td valign="top">		
			<?php
			
			if(!(isset($_GET['m']))){
				if($_SESSION['ahli_majlis']==0){
					if($_SESSION['user_group_id']<=3){
						include './home/home_vip.php';
					}elseif($_SESSION['user_group_id']==4){
						include './home/home.php';
					}elseif($_SESSION['user_group_id']==5){
						include './project/project.php';					
					}
				}else{
					include './home/home_vip.php';
				}
			}elseif($_GET['m']=='0'){
				include './project/details.php';
			}elseif(urlDecrypt($_GET['m'])=='1'){
				include './admin/admin.php';
			}elseif(urlDecrypt($_GET['m'])=='2'){
				include './project/project.php';
			}elseif(urlDecrypt($_GET['m'])=='3'){
				include './kemasukandata/project.php';
			}elseif(urlDecrypt($_GET['m'])=='4'){
				include './report/report.php';
			}elseif(urlDecrypt($_GET['m'])=='5'){
				include './projekdirancang/projekdirancang.php';
			}elseif(urlDecrypt($_GET['m'])=='6'){
				include './help/help.php';
			}	
			?>
		</td>		
		</tr>
        <tr> 
        	<td>
            <div id="res" style="padding:6;width:100%;overflow:auto;overflow-y:hidden;overflow-x:auto;"></div>
            </td>
        </tr>
		<tr> 
		<td height="10">
		  <div style=" width:100%; position: relative; bottom:0px;color: #666666; font-size:9px; background-color:#EEEEEE;height:25px; padding-top:5px; z-index:-999999999; border-top: #999999 1px solid" align="center" > 
			  &copy; <?php echo date('Y')?> Hak Cipta Terpelihara  AUFA Intelligence Sdn. Bhd. 
			  Paparan Terbaik : 1024 x 768 dengan Pelayar Internet Explorer 5.0 ke atas.	  
			   
		  </div>
		 </td>
		 </tr>
		 </table> 	  
	  </div>
  
  </div>  

  </div>
  

</body>
</html>
<?	
	$m = !(isset($_GET['m']))?'1':urlDecrypt($_GET['m'])+1;
?>
<script language="javascript">
	if(document.getElementById('font<?=$m;?>')) {
		document.getElementById('font<?=$m;?>').style.color='#0DFF36';
	}
</script>

<script language="javascript">
function searching(){
	document.sform.action='main.php?m=4&sm=1';
	document.sform.submit();
}

<?
if($_SESSION['ahli_majlis']==0){
	$sql="select * from user_group_module where user_group_id=".$_SESSION['user_group_id'];
	$result = mysql_query($sql);							
	while($rows = mysql_fetch_array($result)){
		?>
			if (document.getElementById('div<?=$rows[2]?>')) {
				document.getElementById('div<?=$rows[2]?>').style.display='inline';
			}
		<?
	}
}else{
	?>
		document.getElementById('div1').style.display='inline';
		document.getElementById('div5').style.display='inline';
	<?
}	
?>

if(document.getElementById("leftmenu_Admin")){
	var menu = document.getElementById("menu_bar").clientWidth
	var leftMenu_AdminH = document.getElementById("leftmenu_Admin").clientHeight
	var leftMenu_AdminW = document.getElementById("leftmenu_Admin").clientWidth
	if(document.getElementById("list")){
		document.getElementById("list").style.width = menu - leftMenu_AdminW -50;
		document.getElementById("list").style.height = leftMenu_AdminH-40;		
	}
}
if(document.getElementById("leftmenu_Project")){
	var menu = document.getElementById("menu_bar").clientWidth
	var leftMenu_AdminW = document.getElementById("leftmenu_Project").clientWidth
	if(document.getElementById("list")){
		document.getElementById("list").style.width = menu - leftMenu_AdminW -43;	
	}
}
if(document.getElementById("leftmenu_Entry")){
	var menu = document.getElementById("menu_bar").clientWidth
	var leftmenu_EntryW = document.getElementById("leftmenu_Entry").clientWidth
	if(document.getElementById("projectData")){
		document.getElementById("projectData").style.width = menu - leftmenu_EntryW -49;	
	}
}
if(document.getElementById("leftmenu_Report")){
	var menu = document.getElementById("menu_bar").clientWidth
	if(document.getElementById("res")){
		document.getElementById("res").style.width = menu-30;	
	}
}

//setTimeout(function(){alert(.height)},3000);

</script>
<?php
$sql = "UPDATE project set no_peruntukan = TRIM(no_peruntukan) where no_peruntukan <> ''";
mysql_query($sql);
?>
<?php mysql_close($con);?> 