<?
//////////////// global setting ////////////////////////////////////////////
$dbpath="20140813/";
?>
<html>
<head>
<title><?print(getSetting("SiteName"))?> Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
body {
	font-family: "Arial";
	font-size: 12px;
	color:#000000;
	text-decoration: none
}
.SectionTitle {
	font-family: "Arial";
	font-size: 14px;
	font-weight: bold;
	color: #000000;
}
</style>
<script language="javascript">
<!--
function checkform() {
	if (document.f1.password.value.length==0) {
		alert("Please fill in password!");
		return false;
	}
}
//-->
</script>
</head>
<body>
<span class="SectionTitle"><?print(getSetting("SiteName"))?> Admin</span><P>

<form action="index.php" name=f1 method=post onSubmit="return checkform()">
Admin Password: <input type=password size=15 name=password> <input type=submit value="Login">
</form>
</body>
</html>
<?
function getRows($filename){
	global $dbpath;
	$filename=$dbpath.$filename;
	if (file_exists($filename)) {
		$datafile=fopen($filename,"r");
		$rowsArray=file($filename);
		fclose($datafile);
		return $rowsArray;
	}
}

function getValueByNameCol($filename,$name,$col){
	// db file name, row name, column to get
	$rowsArray=getRows($filename);
	for($i=0; $i<count($rowsArray);$i++) {
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[1]==$name) 
			return $itemArray[$col];
	}
}

function getSetting($name) {
	return getValueByNameCol("Setting.txt",$name,2);
}
?>