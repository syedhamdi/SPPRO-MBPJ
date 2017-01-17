

<? 
$old_date = '15-10-2012';              // returns Saturday, January 30 10 02:06:34
$old_date_timestamp = strtotime($old_date);
$new_date = date('Y-m-d', $old_date_timestamp);   

echo $old_date."^".$new_date;

$date1 = "2007-03-24";
$date2 = "2009-06-26";

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

printf("%d years, %d months, %d days\n", $years, $months, $days);



?>