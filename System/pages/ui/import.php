<?php 
include('session.php');   
$conn = new mysqli("localhost", 'root', '', 'pdmis') or die(mysqli_error());
date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d h:i a");    


$conn->query ("INSERT INTO `maintenance` (`employeeid`, `action`, `m_date`) VALUES ('$id', 'Import', '$date');") or die(mysqli_error());




$connection = mysqli_connect('localhost', 'root', '', 'pdmis');







$filename = "pdmis.sql";
$handle = fopen($filename,'r+');
$contents = fread($handle,filesize($filename));

$sql = explode(';',$contents);
foreach($sql as $query){
	$result = mysqli_query($connection,$query);
	if($result){
		echo '<tr><tr><br></td></tr>';
		echo '<tr><td>'.$query.'<b>SUCCESS</b></td></tr>';
		echo '<tr><tr><br></td></tr>';
	}
}

fclose($handle);


header("Location: maintenance.php");

?>