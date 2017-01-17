<? include '../include/connection.php';?>
<? include '../include/serversidescript.php';?>
<?
if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='1'){	
	$sql_query1 = 'delete from department where department_id in ';	
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='2'){	
	$sql_query1 = 'delete from user_group where user_group_id in ';
	$sql_query2 = 'delete from user_group_module where user_group_id in ';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='3'){	
	$sql_query1 = 'delete from jawatan where jawatan_id in ';
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='4'){	
	$sql_query1 = 'delete from gred where gred_id in ';
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='5'){	
	$sql_query1 = 'delete from user where user_id in ';
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='6'){	
	$sql_query1 = 'delete from contractor where contractor_id in ';
	$sql_query2 = 'delete from bidang_perunding where contractor_id in ';
	$sql_query3 = 'delete from owner where contractor_id in ';	
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='7'){	
	$sql_query1 = 'delete from contractor where contractor_id in ';
	$sql_query2 = 'delete from insuran where contractor_id in ';
	$sql_query3 = 'delete from owner where contractor_id in ';	
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='8'){	
	$sql_query1 = 'delete from project_type where project_type_id in ';
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='9'){	
	$sql_query1 = 'delete from project_category where project_category_id in ';
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='10'){	
	$sql_query1 = 'delete from project where project_id in ';
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='12'){	
	$sql_query1 = 'delete from kepala_pecahan where kepala_anak_id in ';
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='13'){	
	$sql_query1 = 'delete from kawasan where kwsn_id in ';	
	$sql_query2 = '';
	$sql_query3 = '';
}

if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='14'){	
	$sql_query1 = 'delete from contractor_class where contractor_class_id in ';	
	$sql_query2 = '';
	$sql_query3 = '';
}
if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='15'){	
	$sql_query1 = 'delete from user where user_id in ';
	$sql_query2 = '';
	$sql_query3 = '';
}

$cnt=count($_POST['chk_del']);
	
	$str_id="";
	if($cnt>0){		 
		for($i=0;$i<$cnt;$i++){
			$str_id=$str_id.$_POST['chk_del'][$i].',';			
		}
			if($str_id!=''){
				$str_id=substr($str_id,0,strlen($str_id)-1);
			}
		if(urlDecrypt($_GET['m'])=='1' && urlDecrypt($_GET['sm'])=='15'){	
			$sql = "select ahli_majlis from user where user_id in "."(".$str_id.")";
			$result = mysql_query($sql);							
			while($rows = mysql_fetch_array($result)){
				$sqlUpdate = "update ahli set regAcc = 0 where ahli_id =".$rows['ahli_majlis'];
				mysql_query($sqlUpdate);
			}
		}
		
		$sql = $sql_query1."(".$str_id.")";
		mysql_query($sql);
		
		if($sql_query2!=''){
			$sql2 = $sql_query2."(".$str_id.")";	
			mysql_query($sql2);
		}
		
		if($sql_query3!=''){
			$sql3 = $sql_query3."(".$str_id.")";	
			mysql_query($sql3);
		}
	}

?>
	<script language="Javascript" type="text/javascript"> 
		alert("Data telah dipadam");
		document.location.href="../main.php?m=<?=urlencode($_GET['m'])?>&sm=<?=urlencode($_GET['sm'])?>";
	</script>