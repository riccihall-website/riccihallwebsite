<?
include_once("admin/include/datashow.php");

function directoryForm($dbname){
global $page;
global $pageItem;
global $link;
global $dbpath;
global $dir;
$dataFile=$dbname.".txt";
$dir="upload/".$dbname."/";


$defArray=getDef($dbname);		//get section db definition from master file
$nameArray=$defArray[0];
$typeArray=$defArray[1];
$defaultArray=$defArray[2];
$notshowArray=array(22,23,24,25);
$typeArray[21]="upload";

if($_REQUEST['action']=='inserted'){
/////////////////////////// inserted ////////////////////////////////
$newline=getTableID($dbname);

$_REQUEST['Received_On']=date("Y-m-d H:i:s");
$_REQUEST['Status']="Received";
$_REQUEST['Handled_By']="Web Form";
if ($_REQUEST['Photo']) $_REQUEST['Photo']=date("YmdHis").$_FILES['Photoupfile']['name'];

foreach($nameArray as $name)					// construct new line
	$newline.="\t".eregi_replace("\r\n","<br>",stripslashes($_REQUEST[$name]));
$newline.="\n";

while ($type = current($typeArray)) {				// save upload images
    if ($type == 'upload' || $type == 'image' || $type == 'imageCheck'|| $type == 'textImageCheck') {
	$thiskey=key($typeArray);
	$name=$nameArray[$thiskey]."upfile";
	if ($_FILES[$name]['name']<>"") {			// save file if upload exists
		move_uploaded_file($_FILES[$name]['tmp_name'],$dir.date("YmdHis").$_FILES[$name]['name']);
		$_REQUEST[$nameArray[$thiskey]]=$_FILES[$name]['name'];
	}
    }
    next($typeArray);
}

$rowsArray=getRows($dataFile);

//loop each row
$datafile=fopen($dbpath.$dataFile,"w");
fwrite($datafile,$newline);
for($i=0; $i<count($rowsArray);$i++) {
	fwrite($datafile,$rowsArray[$i]);
}
fclose($datafile);

// mail
//$to      = 'siuholeung@hotmail.com'; 
$to      = getSetting("Email_directory_form");
$headers = 'From: '.getSetting("Email_directory_form");
$subject = 'Directory Web Form';
$message =  $newline;
//$message=iconv("big5", "UTF-8", $message);
	if ($to) mail($to, $subject, $message, $headers);

?>                              <table width="427" align="center" valign=middle>
                                  <tr>
                                    <td class="Main" align="center" valign=middle><?=getLabel("ContactSuccess")?></td>
                                  </tr>
                                </table>
<?
} else {  //
/////////////////////////// show form ////////////////////////////////
?>
<script>
<!--
function checkform() {
<?
for($i=0; $i<count($nameArray);$i++) {
	$tempshow=1;
	for($j=0; $j<count($notshowArray);$j++) {
		if($notshowArray[$j]==$i) $tempshow=0;
	}
	if ($tempshow) {
		showCheck($nameArray[$i],$typeArray[$i]);
	}
}
for($i=0; $i<count($nameArray);$i++) {
	$tempshow=1;
	for($j=0; $j<count($notshowArray);$j++) {
		if($notshowArray[$j]==$i) $tempshow=0;
	}
	if ($tempshow) {
		showExtra($nameArray[$i],$typeArray[$i]);
	}
}
?>
}
//-->
</script>
<form name=f1 action=<?=$link?> method=post enctype="multipart/form-data" onSubmit="return checkform();">
<table cellpadding=4 cellspacing=1 border=0 bgcolor=#000000 width="500"><tr><td colspan=2 class=tablehead align=center>Riccian Directory Input Form</td></tr>
<?
for($i=0; $i<count($nameArray);$i++) {
	$tempshow=1;
	for($j=0; $j<count($notshowArray);$j++) {
		if($notshowArray[$j]==$i) $tempshow=0;
	}
	if ($tempshow) {		
		if ($thisarray[$i+1]) 
			showRow($nameArray[$i],$typeArray[$i],$thisarray[$i+1]);
		 else 
			showRow($nameArray[$i],$typeArray[$i],$defaultArray[$i]);
	}
}
?>
</table>
<P>
<input type=hidden name=action value="inserted">
<input type=submit value="Submit"> &nbsp; <input type=reset value="Reset"> &nbsp; <input type=button value="Cancel" onClick="javascript:document.location='<?print($link)?>'">
</form>
<?
}
/////////////////////////// show form ////////////////////////////////
}

?>