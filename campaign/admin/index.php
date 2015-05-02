<?
//////////////// global setting ////////////////////////////////////////////
$dbpath="20140813/";
$pageItem=1000;
if (isset($_REQUEST['section'])) $section=$_REQUEST['section'];
if (isset($_REQUEST['password'])) {
	$inputpassword=$_REQUEST['password'];
} else {
	$inputpassword='';
}
//////////////// check login ///////////////////////////////////////////////
if ($inputpassword==getSetting("AdminPassword") || $_COOKIE['cookieadmin']=='admin') {
	setcookie("cookieadmin","admin",time()+1800); // set or refresh cookie
} else {
	print "<meta http-equiv=\"refresh\" content=\"0; url=login.php\">";  // no password redirect
	exit;
}
//////////////// check login end ///////////////////////////////////////////


?>
<html>
<head>
<title><?print(getSetting("BrowserTitle"))?> Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
body {
	font-family: "Arial";
	font-size: 12px;
	color:#000000;
	text-decoration: none
}
a {
	font-family: "Arial";
	color:#0000ff;
	text-decoration: none
}
a:hover {
	font-family: "Arial";
	color:#734202; 
	text-decoration: underline
} 
td.Header {
	font-family: "Arial";
	font-size: 16px;
	font-weight: bold;
	color: #000000;
	background:#afc9f7;
}
td.Left {
	font-family: "Arial";
	font-size: 14px;
	font-weight: bold;
	color: #000000;
	background:#bbbbbb;
}
td.Main {
	font-family: "Arial";
	font-size: 12px;
	font-weight: bold;
	color: #000000;
	background:#dddddd;
}
td.Footer {
	font-family: "Arial";
	font-size: 10px;
	text-decoration: none
	color: #000000;
	background:#ffffff;
}
.SectionTitle {
	font-family: "Arial";
	font-size: 14px;
	font-weight: bold;
	color: #000000;
}
td.tablehead {
	font-family: "Arial";
	font-size: 12px;
	font-weight: bold;
	color: #000000;
	background:#afc9f7;
}
td {
	font-family: "Arial";
	font-size: 12px;
	color: #000000;
}
</style>
</head>

<body text="#000000" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">

<TABLE WIDTH="90%" CELLPADDING="4" CELLSPACING="1" BORDER="0" BGCOLOR="#000000">

<tr><td align=center colspan=2 class=Header><a href="../" target=_blank><?print(getSetting("SiteName"))?></a> Admin</td></tr>

<tr><td width=160 class=Left valign=top>
<!--Menu begin-->
<a href=index.php>Home</a><br>
<br>
<hr>
<? $leftArray=getRows("Master.txt");
for($i=0; $i<count($leftArray);$i++) {
	$itemArray=explode("\t",trim($leftArray[$i]));
	print ("<a href=?section=$itemArray[1]>$itemArray[1]</a><br>");
}
?>
<hr>
<br>
<a href=logout.php>Logout</a><br>
<br>
<!--Menu End-->
</td>

<td width=800 class=Main valign=top>
<!--Main begin-->
<?
if (isset($section)) {
	print("<span class=SectionTitle>$section</span> &nbsp;&nbsp;&nbsp; (<a href=?section=$section"."&editaction=f>manage files</a>)<P> ");
	$page=$_REQUEST['page'];
	$edititem=$_REQUEST['edititem'];
	$dir="../upload/".$section."/";		//path for upload
	$dataFile=$section.".txt";

	$defArray=getDef($section);		//get section db definition from master file
	$nameArray=$defArray[0];
	$typeArray=$defArray[1];
	$defaultArray=$defArray[2];
	$showArray=$defArray[3];
	$imageMap=$defArray[4];

	$tempLang=getSetting("Languages");
	$langArray=explode("::",trim($tempLang));

	switch ($_REQUEST['editaction']) {
		case "e":
		case "c":
		case "i":
			include("include/dataedit.php");
			break;
		case "ee":
			dataedited();
			include("include/datalist.php");
			break;
		case "cc":
		case "ii":
			datainserted();
			include("include/datalist.php");
			break;
		case "d":
			datadel();
			include("include/datalist.php");
			break;
		case "f":
			include("include/fileupload.php");
			break;
		case "ff":
			fileuploaded();
			include("include/fileupload.php");
			break;
		case "fd":
			filedelete();
			include("include/fileupload.php");
			break;
		case "r":
			datarise();
			include("include/datalist.php");
			break;
		case "s":
			datasink();
			include("include/datalist.php");
			break;
		default:
			include("include/datalist.php");
	}
	if ($imageMap<>"")
		include("include/imagemap.php");
}
?>
<!--Main end-->
</td></tr>

</TABLE>

<!--footer-->
<table cellpadding="0" cellspacing="0" width="90%">
<tr><td class=Footer>&nbsp;&nbsp; &copy Copyright <?print(date("Y"));?> Easy WebCMS. &nbsp;&nbsp; All rights reserved. &nbsp;&nbsp; <a href="mailto:easywebcms@gmail.com" target=_blank>easywebcms@gmail.com</a></td>
<td align=right class=Footer></td></tr>
</table>
<!--footer End-->
</body>
</html>

<?

function substrChi($mystring,$num) {	// substring with double byte support. minus for right side start
	if ($num<0) {
		$num=strlen($mystring)+$num; 
		$reverse=1;
	}
	$chiflag=1;
	for ($m=0;$m<$num;$m++) {
		if ($chiflag==-1) {
			$chiflag=1;
		} else if (ord(substr($mystring,$m,1))>127) {
			$chiflag*=-1;
		}
	}
	if ($reverse) {
		if ($chiflag==-1)
			return substr($mystring,$num+1,strlen($mystring)-$num-1);
		else
			return substr($mystring,$num,strlen($mystring)-$num);
	} else {
		if ($chiflag==-1)
			return substr($mystring,0,$num-1);
		else
			return substr($mystring,0,$num);
	}
}

function getRows($filename){			//get array of all rows in a table
	global $dbpath;
	$filename=$dbpath.$filename;
	if (file_exists($filename)) {
		$datafile=fopen($filename,"r");
		$rowsArray=file($filename);
		fclose($datafile);
		return $rowsArray;
	}
}

function getRowByName($filename,$name){		// get array of columns of a row in a table by row name 1st match
	// db file name, row name
	$rowsArray=getRows($filename);
	for($i=0; $i<count($rowsArray);$i++) {
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[1]==$name)
			return $itemArray;
	}
}

function getRowById($filename,$id){		// get array of columns of a row in a table by row id
	// db file name, row id
	$rowsArray=getRows($filename);
	for($i=0; $i<count($rowsArray);$i++) {
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[0]==$id)
			return $itemArray;
	}
}

function getValueByNameCol($filename,$name,$col){	// get value of a certain column of a table by row name 1st match
	// db file name, row name, column to get
	$rowsArray=getRows($filename);
	for($i=0; $i<count($rowsArray);$i++) {
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[1]==$name) 
			return $itemArray[$col];
	}
}

function getValueByIdCol($filename,$id,$col){		// get value of a certain column of a table by row id
	// db file name, row id, column to get
	$rowsArray=getRows($filename);
	for($i=0; $i<count($rowsArray);$i++) {
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[0]==$id) 
			return $itemArray[$col];
	}
}

function getSetting($name) {				// get website setting 
	return getValueByNameCol("Setting.txt",$name,2);
}

function getDef($section) {				// get table definition 4 arrays
	$tempArray=getRowByName("Master.txt",$section);

	$resultArray[0]=explode("::",trim($tempArray[3]));	//nameArray

	$resultArrayTemp=explode("::",trim($tempArray[4]));	//typeArray
	for($i=0; $i<count($resultArrayTemp);$i++) {
		if(eregi("@@",$resultArrayTemp[$i])) {
			$tempArray2=explode("@@",$resultArrayTemp[$i]);
			if(eregi("Refer",$tempArray2[0])) {		// select type refer to another table
				$tempArray3=getRows($tempArray2[1].".txt");
				if(eregi("Multiple",$tempArray2[0])) $tempArray4[]="boxList";
				else $tempArray4[]="select";
				if(eregi("Check",$tempArray2[0])) $tempArray4[0].="Check";
				for($j=0; $j<count($tempArray3);$j++) {
					$itemArray=explode("\t",trim($tempArray3[$j]));
					if ($itemArray[2]=="Inactive") {
						$tempArray4[]=$itemArray[0]."&&*".$itemArray[1];
					} else {
						$tempArray4[]=$itemArray[0]."&&".$itemArray[1];
					}
				}
				$resultArrayTemp[$i]=$tempArray4;
			} else {
				$resultArrayTemp[$i]=$tempArray2;
			}
		}
	}
	$resultArray[1]=$resultArrayTemp;

	$tempString=eregi_replace("::","&&",trim($tempArray[5]));
	$tempString=eregi_replace("__","::",$tempString);
	$resultArray[2]=explode("&&",$tempString);		//defaultArray

	$resultArray[3]=explode("::",trim($tempArray[6]));	//showArray
	$resultArray[4]=$tempArray[7];

	return $resultArray;
}

function getTableID($tableName){				// get next new row id for a table
	global $dbpath;
	$rowsArray=getRows("Master.txt");
	$datafile=fopen($dbpath."Master.txt","w");
	$newkey=0;
	for($i=0; $i<count($rowsArray);$i++) {
		$itemarray=explode("\t",trim($rowsArray[$i]));
		if ($itemarray[1]==$tableName)	{
			$newkey=$itemarray[2];
			$itemarray[2]++;
			$rowsArray[$i] = implode("\t", $itemarray);
			fwrite($datafile,$rowsArray[$i]."\n");
		} else {
			fwrite($datafile,$rowsArray[$i]);
		}
	}
	if($newkey<1){
		$newkey=1;
		fwrite($datafile,"$tableName\t2\n");
	}
	fclose($datafile);
	return $newkey;
}

function getDirectory($dir){					// get directory file list in a array
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				$rowsArray[]="$file";
			}
			closedir($dh);
			if (count($rowsArray)>0) {
				sort($rowsArray);
				array_shift($rowsArray);
				array_shift($rowsArray);
			}
			return $rowsArray;
		}
	}
}

function datadel() {
/////////////////////////// del ////////////////////////////////
global $dataFile;
global $edititem;
global $dbpath;
global $section;

$rowsArray=getRows($dataFile);

//loop each news
$datafile=fopen($dbpath.$dataFile,"w");
for($i=0; $i<count($rowsArray);$i++) {
	$itemarray=explode("\t",$rowsArray[$i]);
	if ($itemarray[0]==$edititem) {
		$obj=$itemarray[1];
	} else {
		fwrite($datafile,$rowsArray[$i]);
	}
}
fclose($datafile);

// remove upload folder and db file
$dir="../upload/".$obj."/";
$dbfile=$dbpath.$obj.".txt";
if ($section=="Master"){
	if(is_dir($dir)) {
		$mydir = opendir($dir);
		while(false !== ($file = readdir($mydir))) {
			if($file != "." && $file != "..")
				unlink($dir.$file);
		}
		rmdir($dir);
	}
	if(is_file($dbfile))
		unlink($dbfile);
}
/////////////////////////// del ////////////////////////////////
}

function fileuploaded() {
/////////////////////////// file uploaded ////////////////////////////////
global $dir;

if ($_FILES['upfile']['name']<>"") {			// save file if upload exists
	move_uploaded_file($_FILES['upfile']['tmp_name'],$dir.$_FILES['upfile']['name']);
}
/////////////////////////// file uploaded ////////////////////////////////
}

function filedelete() {
/////////////////////////// file delete ////////////////////////////////
global $edititem;
global $dir;

if ($edititem) {
	unlink($dir.$edititem);
}
/////////////////////////// file delete ////////////////////////////////
}

function datarise() {
/////////////////////////// rise ////////////////////////////////
global $dataFile;
global $edititem;
global $dbpath;

$rowsArray=getRows($dataFile);

//loop each row
$templine='';
$datafile=fopen($dbpath.$dataFile,"w");
for($i=0; $i<count($rowsArray);$i++) {
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[0]==$edititem) {
		fwrite($datafile,$rowsArray[$i]);
	} else {
		if($i>0)
			fwrite($datafile,$templine);
		$templine=$rowsArray[$i];
	}
}
fwrite($datafile,$templine);
fclose($datafile);
/////////////////////////// rise ////////////////////////////////
}

function datasink() {
/////////////////////////// sink ////////////////////////////////
global $dataFile;
global $edititem;
global $dbpath;

$rowsArray=getRows($dataFile);

//loop each row
$templine='';
$datafile=fopen($dbpath.$dataFile,"w");
for($i=0; $i<count($rowsArray);$i++) {
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[0]==$edititem) {
		$templine=$rowsArray[$i];
	} else {
		fwrite($datafile,$rowsArray[$i]);
		if($templine) {
			fwrite($datafile,$templine);
			$templine='';
		}
	}
}
fclose($datafile);
/////////////////////////// sink ////////////////////////////////
}

function dataedited() {
/////////////////////////// edited ////////////////////////////////
global $dataFile;
global $edititem;
global $dbpath;
global $nameArray;
global $typeArray;
global $section;

$newline=$edititem;

$dir="../upload/".$section."/";
while ($type = current($typeArray)) {				// save upload images
    if ($type == 'image' || $type == 'imageCheck'|| $type == 'textImageCheck') {
	$thiskey=key($typeArray);
	$name=$nameArray[$thiskey]."upfile";
	if ($_FILES[$name]['name']<>"") {			// save file if upload exists
		move_uploaded_file($_FILES[$name]['tmp_name'],$dir.$_FILES[$name]['name']);
		$_REQUEST[$nameArray[$thiskey]]=$_FILES[$name]['name'];
	}
    }
    next($typeArray);
}

foreach($nameArray as $name)					// construct new line
	$newline.="\t".eregi_replace("\r\n","<br>",stripslashes($_REQUEST[$name]));
$newline.="\n";

$rowsArray=getRows($dataFile);

//loop each row
$datafile=fopen($dbpath.$dataFile,"w");
for($i=0; $i<count($rowsArray);$i++) {
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[0]==$edititem) {
		fwrite($datafile,$newline);
		$oldobj=$itemArray[1];
	} else {
		fwrite($datafile,$rowsArray[$i]);
	}
}
fclose($datafile);

// rename upload folder and db file
$newobj=$_REQUEST["Name"];
$olddir="../upload/".$oldobj."/";
$newdir="../upload/".$newobj."/";
$olddbfile=$dbpath.$oldobj.".txt";
$newdbfile=$dbpath.$newobj.".txt";
if ($section=="Master") {
	if (!is_dir($newdir)) {
		if(is_dir($olddir)) {
			rename($olddir,$newdir);
		} else {
			mkdir($newdir);
		}
	}
	if (!is_file($newdbfile) && is_file($olddbfile)) {
		rename($olddbfile,$newdbfile);
	}
	
}
/////////////////////////// edited ////////////////////////////////
}


function datainserted() {
/////////////////////////// inserted ////////////////////////////////
global $dataFile;
global $edititem;
global $dbpath;
global $nameArray;
global $typeArray;
global $section;

$newline=getTableID($section);

$dir="../upload/".$section."/";
while ($type = current($typeArray)) {				// save upload images
    if ($type == 'image' || $type == 'imageCheck'|| $type == 'textImageCheck') {
	$thiskey=key($typeArray);
	$name=$nameArray[$thiskey]."upfile";
	if ($_FILES[$name]['name']<>"") {			// save file if upload exists
		move_uploaded_file($_FILES[$name]['tmp_name'],$dir.$_FILES[$name]['name']);
		$_REQUEST[$nameArray[$thiskey]]=$_FILES[$name]['name'];
	}
    }
    next($typeArray);
}

foreach($nameArray as $name)					// construct new line
	$newline.="\t".eregi_replace("\r\n","<br>",stripslashes($_REQUEST[$name]));
$newline.="\n";

$rowsArray=getRows($dataFile);

if(ereg("a",$edititem)) {
	$tempArray=explode("a",$edititem);
	$edititem=$tempArray[0];
	$addafter=1;
}


//loop each row
$flag=1;
$datafile=fopen($dbpath.$dataFile,"w");
for($i=0; $i<count($rowsArray);$i++) {
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[0]==$edititem) {
		if($addafter) {
			fwrite($datafile,$rowsArray[$i]);
			fwrite($datafile,$newline);	
		} else {
			fwrite($datafile,$newline);	
			fwrite($datafile,$rowsArray[$i]);
		}
		$flag=0;
	} else {
		fwrite($datafile,$rowsArray[$i]);
	}
}
if ($flag)
	fwrite($datafile,$newline);	
fclose($datafile);

// create upload folder
$dir="../upload/".$_REQUEST["Name"];
if ($section=="Master" && (!is_dir($dir)))
	mkdir($dir);

/////////////////////////// inserted ////////////////////////////////
}


?>