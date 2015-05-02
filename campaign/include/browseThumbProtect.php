<?
function browseThumbProtect($dbname){
print("<table border=0 cellpadding=4 cellspacing=0 width=100%><tr>\n");


$rowsArray=getRows($dbname.".txt");
//print("<tr><td valign=top><img src=\"images/shim.gif\" width=170 height=1 border=0></td><td valign=top><img src=\"images/shim.gif\" width=580 height=1 border=0></td></tr>\n");

for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));

	$tempsizetag="";
	if ($itemArray[6]) {
		$tempfilename="upload/$dbname/$itemArray[6]";
		$tempsize = getimagesize($tempfilename); 
		if($tempsize[0]>=$tempsize[1]) {
			$tempsizetag="width=180";
		} else {
			$tempsizetag="height=180";
		}
		$tempThumb="<img src=\"upload/$dbname/$itemArray[6]\" $tempsizetag border=0>";
	} else {
		$tempThumb="<img src=\"images/shim.gif\" border=0 height=180 width=1>";
	}

	if ($itemArray[5]) {
		$tempcontent=getLang($itemArray[5]);
	} else {
		$tempcontent="";
	}

	if ($itemArray[2]=='Active') {
		if ($itemArray[4]) { // redirect link
			print("<td align=center valign=bottom><a href=\"$itemArray[4]\" target=_blank>$tempThumb<br>".getLang($itemArray[1])."</a><br>$tempcontent</td>\n");
		} elseif ($itemArray[7]) {
			if(eregi(".gif",$itemArray[7]) || eregi(".jpg",$itemArray[7]) || eregi(".png",$itemArray[7])) { //pop image
				print("<td align=center valign=bottom><a href=\"upload/$dbname/$itemArray[7]\" rel=\"lightbox\">$tempThumb<br>".getLang($itemArray[1])."</a><br>$tempcontent</td>\n");
			} else {  // pop attachment
				print("<td align=center valign=bottom><a href=\"download.php?ds=".$dbname."&df=".$itemArray[7]."\" target=_blank>$tempThumb<br>".getLang($itemArray[1])."</a><br>$tempcontent</td>\n");
 			}
		} else {
			print("<td align=center valign=bottom>$tempThumb<br>".getLang($itemArray[1])."<br>$tempcontent</td>\n");
		}
	}
	$j=round(($i+1)/4)*4-1;
	if ($j==$i) print ("</tr>\n<tr>");
}
print("</tr></table><br>\n");
}
?>