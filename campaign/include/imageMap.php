<?
function imageMap($dbname){
print("<DIV ID=\"dek\" style=\"POSITION:absolute;VISIBILITY:hidden;Z-INDEX:200;\"></DIV>");
?>

<SCRIPT TYPE="text/javascript">
<!--
Xoffset=-60;    // modify these values to ...
Yoffset= 20;    // change the popup position.

var old,skn,iex=(document.all),yyy=-1000;

var ns4=document.layers
var ns6=document.getElementById&&!document.all
var ie4=document.all

if (ns4)
skn=document.dek
else if (ns6)
skn=document.getElementById("dek").style
else if (ie4)
skn=document.all.dek.style
if(ns4)document.captureEvents(Event.MOUSEMOVE);
else{
skn.visibility="visible"
skn.display="none"
}
document.onmousemove=get_mouse;

function popup(msg,bak){
var content="<TABLE  WIDTH=150 BORDER=1 BORDERCOLOR=black CELLPADDING=2 CELLSPACING=0 "+
"BGCOLOR="+bak+"><TD ALIGN=center><FONT COLOR=black SIZE=2>"+msg+"</FONT></TD></TABLE>";
yyy=Yoffset;
 if(ns4){skn.document.write(content);skn.document.close();skn.visibility="visible"}
 if(ns6){document.getElementById("dek").innerHTML=content;skn.display=''}
 if(ie4){document.all("dek").innerHTML=content;skn.display=''}
}

function get_mouse(e){
var x=(ns4||ns6)?e.pageX:event.x+document.body.scrollLeft;
skn.left=x+Xoffset;
var y=(ns4||ns6)?e.pageY:event.y+document.body.scrollTop;
skn.top=y+yyy;
}

function kill(){
yyy=-1000;
if(ns4){skn.visibility="hidden";}
else if (ns6||ie4)
skn.display="none"
}

//-->
</SCRIPT>

<?
$mapfile=getValueByNameCol("Master.txt",$dbname,7);
print("<img src=\"upload/Master/$mapfile\" useMap=#imageMap border=0><br><br><br>\n<map name=imageMap>\n");

$rowsArray=getRows($dbname.".txt");

for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[2]=='Active') {
		if ($itemArray[4]<>"") 
			$thislink="href=\"$itemArray[4]\"";
		else
			$thislink="";		
		print("<AREA $thislink shape=rect coords=\"$itemArray[3]\" ONMOUSEOVER=\"popup('<img src=\'upload/$dbname/$itemArray[5]\' border=0 width=160><br>".getLang($itemArray[1])."','lightgreen');\" ONMOUSEOUT=\"kill();\" style=\"cursor:pointer; cursor:hand;\">\n");
	}
}
print("</map><br>\n");
}
?>