<script>
<!--

function showhidemap(){
	if(document.getElementById('mapbox').style.visibility=='hidden')
		document.getElementById('mapbox').style.visibility='visible';
	else
		document.getElementById('mapbox').style.visibility='hidden';
}
//-->
</script>
<?

print "<br><br><a href=\"javascript:showhidemap();\">Show/Hide Areas</a>";
print "<br><br><div style=\"position:absolute; z-index:200;\" id=mapbox></div>";

if($editaction=="e" || $editaction=="i") {
	print "<img src=\"../upload/Master/$imageMap\" border=1 onclick=\"addxy(event)\" useMap=#Map id=map><br><br>";
?>
<script>
<!--

function addxy(e){
	pos_x = event.offsetX?(event.offsetX):event.pageX-document.getElementById("map").offsetLeft;
	pos_y = event.offsetY?(event.offsetY):event.pageY-document.getElementById("map").offsetTop;

	if (document.getElementById('Co-ordinates').value=='')
		document.getElementById('Co-ordinates').value=pos_x+','+pos_y;
	else
		document.getElementById('Co-ordinates').value+=','+pos_x+','+pos_y;
}
//-->
</script>
<?
} else {
	print "<img src=\"../upload/Master/$imageMap\" border=1 useMap=#Map><br><br>";
}

$dir="../upload/$section/";
$rowsArray=getRows($section.".txt");
foreach($rowsArray as $line) {
	$itemArray=explode("\t",trim($line));
	$coordArray=explode(",",trim($itemArray[3]));
	$left=$coordArray[0];
	$top=$coordArray[1];
	$width=$coordArray[2]-$coordArray[0];
	$height=$coordArray[3]-$coordArray[1];
	print("<script>document.getElementById('mapbox').innerHTML+='<div onClick=\"window.open(\'$dir$itemArray[5]\',\'\',\'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,width=600,height=400\')\" style=\"position:absolute; width:".$width."px; height:".$height."px; left: ".$left."px; top: ".$top."px; background-color:#ff0000; color:#ffffff; opacity:0.3; filter:alpha(opacity=60); text-align: center; font-size: 10pt; font-weight: bold; cursor:hand;\">$itemArray[1]</div>'</script>\n");
}