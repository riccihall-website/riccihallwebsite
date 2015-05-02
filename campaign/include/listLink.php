<?
function listLink($dbname){
print("<table border=0 cellpadding=4 cellspacing=0 width=100%>");

$rowsArray=getRows($dbname.".txt");
for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[2]=='Active') {
		print("<tr><td valign=top>".getLang($itemArray[1])."</td>");
		if ($itemArray[3]<>"")
			print("<td valign=top><a href=\"$itemArray[3]\" target=_blank>$itemArray[3]</a></td></tr>\n");
	}
}
print("</table><br>\n");
}
?>