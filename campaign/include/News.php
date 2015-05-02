<?

print("<span class=SectionTitle>".getLabel($section)."</span><br><br>");

$dbname=$section;
if($id<>"") {									// show item
	$itemArray=getRowById($dbname.".txt",$id);

	print("<span class=SectionTitle2>".getLang($itemArray[1])."</span><br><br>");

	print("<table><tr><td valign=top>".getLang($itemArray[3])."<br><br></td><td valign=top>");
	if($itemArray[4]<>"")
		print("<img src=\"upload/".$dbname."/".$itemArray[4]."\" border=0><br><br>");
	if($itemArray[5]<>"")
		print("<img src=\"upload/".$dbname."/".$itemArray[5]."\" border=0><br><br>");
	print("</td></tr></table>");
	print("<a href=\"?section=$section\">".getLabel("More").getLabel($section)."</a>");
} else {
 
	$rowsArray=getRows($dbname.".txt");					// show list
	for($i=0;$i<count($rowsArray);$i++){
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[2]=='Active')
			print("<a href=\"?section=$section&id=$itemArray[0]\">".getLang($itemArray[1])."</a><br>");
	}
}
?>