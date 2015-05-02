<?
function browseNews($dbname){
print("<table border=0 cellpadding=10 cellspacing=0 width=100%><tr>\n");


$rowsArray=getRows($dbname.".txt");
//print("<tr><td valign=top><img src=\"images/shim.gif\" width=170 height=1 border=0></td><td valign=top><img src=\"images/shim.gif\" width=580 height=1 border=0></td></tr>\n");

$k=0;
for($i=0;$i<count($rowsArray);$i++){

	$itemArray=explode("\t",trim($rowsArray[$i]));

	$tempsizetag="";
	if ($itemArray[7]) {
		$tempfilename="upload/$dbname/$itemArray[7]";
		$tempsize = getimagesize($tempfilename); 
		if($tempsize[0]>=$tempsize[1]) {
			$tempsizetag="width=180";
		} else {
			$tempsizetag="height=180";
		}
		$tempThumb="<img src=\"upload/$dbname/$itemArray[7]\" $tempsizetag border=0>";
	} else {
		$tempThumb="<img src=\"images/shim.gif\" border=0 height=180 width=1>";
	}

	//if ($itemArray[5]) {
	//	$tempcontent=getLang($itemArray[5]);
	//} else {
	//	$tempcontent="";
	//}

	if ($itemArray[2]=='Active') {
		if ($itemArray[4]) { // redirect link
			//print("<td align=center valign=bottom width=25%><a href=\"$itemArray[4]\" target=_blank>$tempThumb<br><font color=#000000>".getLang($itemArray[1])."</font></a><br>$tempcontent</td>\n");
			print("<td align=center valign=bottom width=25%><a href=\"$itemArray[4]\" target=_blank>$tempThumb<br>".getLang($itemArray[1])."</a></td>\n");
		//} elseif ($itemArray[7]) {
		//	if(eregi(".gif",$itemArray[7]) || eregi(".jpg",$itemArray[7]) || eregi(".png",$itemArray[7])) { //pop image
		//		print("<td align=center valign=bottom><a href=\"upload/$dbname/$itemArray[7]\" rel=\"lightbox\">$tempThumb<br><font color=#000000>".getLang($itemArray[1])."</font></a><br>$tempcontent</td>\n");
		//	} else {  // pop attachment
		//		print("<td align=center valign=bottom><a href=\"upload/$dbname/$itemArray[7]\" target=_blank>$tempThumb<br><font color=#000000>".getLang($itemArray[1])."</font></a><br>$tempcontent</td>\n");
 		//	}
		} else {
			print("<td align=center valign=bottom width=200><a href=\"?section=$dbname&id=$itemArray[0]\">$tempThumb<br>".getLang($itemArray[1])."</a></td>\n");
		}
		$j=round(($k+1)/4)*4-1;
		if ($j==$k) print ("</tr>\n<tr>");
		$k++;
	}

}
print("</tr></table><br>\n");
}
?>