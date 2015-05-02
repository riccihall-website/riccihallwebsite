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
		//print_r($itemArray);
		$nameArray=explode("::",trim($itemArray[1]));
		if ($nameArray[0]==$name) 
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
function getStyle($name) {				// get website style 
	return getValueByNameCol("Style.txt",$name,2);
}
function getLabel($name) {	
	global $langflag;				// get website label 
	$labelArray=explode("::",trim(getValueByNameCol("Label.txt",$name,2)));
	return $labelArray[$langflag];
}
function getLang($name) {	
	global $langflag;
	global $defaultLanguage;				// get lang from array 
	$nameArray=explode("::",trim($name));
	if ($nameArray[$langflag]<>"")
		return $nameArray[$langflag];
	else
		return $nameArray[$defaultLanguage];
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

function showPage($pageTotal,$page,$link){			// show page numbers for navigation of list of objects
	$next=$page+1;
	$previous=$page-1;
	print "<span class=\"pagenav\">".getLabel("Page")." &nbsp; ";
	if ($previous>0) {
		print "<a href=$link&page=$previous>&lt;&lt;</a> &nbsp; ";
	}
	for($j=1; $j<=$pageTotal;$j++) {
		if ($j==$page){
			print "<b>$j</b> &nbsp; ";
		} else {
			print "<a href=$link&page=$j>$j</a> &nbsp; ";
		}
	}
	if ($next<=$pageTotal) {
		print "<a href=$link&page=$next>&gt;&gt;</a> &nbsp; </span>";
	}
}


function counter($dbname){
global $section;
global $id;
global $dbpath;

$link="?";							// set page base link
if ($section<>"")
	$link.="section=".$section;
if ($id<>"")
	$link.="&id=".$id;

$link_exist=0;							// flag for link exist in db.
$rowsArray=getRows($dbname.".txt");	
$datafile=fopen($dbpath.$dbname.".txt","w");			// loop for rows in db

for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[1]==$link) {				// link found
			$link_exist=1;
			$itemArray[2]++;
			$rowsArray[$i] = implode("\t", $itemArray)."\n";
	}
	fwrite($datafile,$rowsArray[$i]);
}

if ($link_exist<1) {
	$newLine=getTableID($dbname)."\t".$link."\t1";
	fwrite($datafile,$newLine."\n");
}

}


?>