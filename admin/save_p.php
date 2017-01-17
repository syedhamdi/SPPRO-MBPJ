<? include '../include/connection.php';?>

<?
		$sql="insert into kepala(kepala_kod,kepala_desc,perunding) values('".$_POST['kod']."','".$_POST['bidang']."',".$_POST['perunding'].")";		
		mysql_query($sql);
		//echo $sql;
?>