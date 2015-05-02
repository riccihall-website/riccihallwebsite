<?
function browsePhotoGalleryProtect($dbname){
global $link;
$mid=$_REQUEST['mid'];

if ($mid) { // list each gallery
  $itemArray=getRowById($dbname.".txt",$mid);
  print("<b>".getLang($itemArray[1])."</b>");

  print("<table border=0 cellpadding=4 cellspacing=0 width=100%><tr>");


// get directory
$dir="upload/".$dbname."/".$mid;
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
	}
}

  print("<table border=0 cellpadding=4 cellspacing=0 width=100%><tr>\n");
  for($i=0;$i<count($rowsArray);$i++){
	$tempfilename="$dir/$rowsArray[$i]";
	$tempsize = getimagesize($tempfilename); 
	if($tempsize[0]>=$tempsize[1]) {
		$tempsizetag="width=180";
	} else {
		$tempsizetag="height=180";
	}
	$tempfilename="download.php?ds=".$dbname."/".$mid."&df=".$rowsArray[$i];
	print("<td align=center valign=bottom><a href=\"$tempfilename\" rel=\"lightbox\"><img src=\"$tempfilename\" border=0 $tempsizetag></a></td>\n");
	$j=round(($i+1)/4)*4-1;
	if ($j==$i) print ("</tr>\n<tr>");
  }
  print("</tr></table><br>\n");
  print "<a href=\"javascript:history.back()\">".getLabel("Back")."</a><br>\n";

} else { // list all gallery

  print("<table border=0 cellpadding=4 cellspacing=0 width=100%><tr>");


  $rowsArray=getRows($dbname.".txt");
  //print("<tr><td valign=top><img src=\"images/shim.gif\" width=170 height=1 border=0></td><td valign=top><img src=\"images/shim.gif\" width=580 height=1 border=0></td></tr>\n");

  for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[2]=='Active') {
		print("<td align=center valign=bottom><a href=\"$link"."&mid=".$itemArray[0]."\"><img src=\"download.php?ds=".$dbname."&df=".$itemArray[6]."\" border=0><br>".getLang($itemArray[1])."</a></td>");
	}
	$j=round(($i+1)/4)*4-1;
	if ($j==$i) print ("</tr><tr>");
  }
  print("</tr></table><br>\n");

} // end list all gallery


}
?>