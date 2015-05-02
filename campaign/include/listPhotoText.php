<?
function listPhotoText($dbname){
print("<table border=0 cellpadding=4 cellspacing=0 width=100%>");

$rowsArray=getRows($dbname.".txt");
print("<tr><td valign=top><img src=\"images/shim.gif\" width=170 height=1 border=0></td><td valign=top><img src=\"images/shim.gif\" width=580 height=1 border=0></td></tr>\n");
for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[2]=='Active') {
		print("<tr><td valign=top><a name=$itemArray[0]></a>");
		if ($itemArray[4]<>"")
			print("<a href=\"upload/$dbname/$itemArray[5]\" rel=\"lightbox\"><img src=\"upload/$dbname/".$itemArray[4]."\" border=0></a>");
		print("<br>&nbsp;</td><td valign=top>");
		print("<span class=SectionTitle2>".getLang($itemArray[1])."</span><br>");
		if ($itemArray[3]<>"")
			print(getLang($itemArray[3]));
		print("<br>&nbsp;</td></tr>\n");
	}
}
print("</table><br><br><br>\n");
}
?>