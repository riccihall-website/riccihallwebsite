<?
include_once("include/function.php");

//////////////// global setting ////////////////////////////////////////////
$dbpath="admin/20140813/";					// get page variables
$section=$_REQUEST['section'];
$id=$_REQUEST['id'];
//$mid=$_REQUEST['mid'];
$page=$_REQUEST['page'];
$pageItem=getSetting("RowPerPage");
$defaultLanguage=getSetting("DefaultLanguage");

$link="?";							// set page base link
if ($section<>"")
	$link.="section=".$section;
if ($id<>"")
	$link.="&id=".$id;
if ($mid<>"")
	$link.="&mid=".$mid;
if ($page<>"")
	$link.="&page=".$page;

if (isset($_REQUEST['la'])) {					// check page language
	setcookie("language",$_REQUEST['la'],time()+1800);
	$langflag=$_REQUEST['la'];
} elseif (isset($_COOKIE['language'])) {
	setcookie("language",$_COOKIE['language'],time()+1800);
	$langflag=$_COOKIE['language'];
} else {
	setcookie("language",$defaultLanguage,time()+1800);
	$langflag=$defaultLanguage;
}

counter("Counter");
//////////////// global setting ////////////////////////////////////////////

//////////////// logout ////////////////////////////////////////////
if ($_REQUEST['section']=="Logout") {
	setcookie("cookieuser","member",time()-1800);
	print "<meta http-equiv=\"refresh\" content=\"0; url=./\">";
}
//////////////// check login ///////////////////////////////////////////////

elseif ($_REQUEST['section'] && getValueByIdCol($_REQUEST['section'].".txt",$_REQUEST['id'],9)==1) { // if page is restricted

	if ($_REQUEST['password']==getSetting("MemberPassword") || $_COOKIE['cookieuser']=='member') {
		setcookie("cookieuser","member",time()+1800); // set or refresh cookie
	} else {
		$showloginform=1;
	}
} // end restricted page
//////////////// check login end ///////////////////////////////////////////
?><html>
<head>
<title><?print(getSetting("BrowserTitle"))?></title>
<meta name="KEYWORDS" value="<?print(getSetting("SearchKeyword"))?>">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="lightbox.js"></script>
<link rel=stylesheet type="text/css" href="lightbox.css">
<style>
body {		font-family: "Arial";	font-size: 14px;	text-decoration: none;		color:#000000;}
a {		font-family: "Arial";				text-decoration: none;		color:#0000ff;}
a:hover	{	font-family: "Arial";				text-decoration: underline;	color:#734202;} 

td.Header {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #000000;	background:#ffffff;}
td.Left {	font-family: "Arial";	font-size: 12px;	font-weight: bold;		color: #000000;	background:#<?print(getStyle("Left"))?>;}
td.Right {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #000000;	background:#<?print(getStyle("Right"))?>;}
td.Main {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #000000;	background:#<?print(getStyle("Main"))?>;}
td.MainBg {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #000000;	background:#<?print(getStyle("MainBg"))?>;}
td.Footer {	font-family: "Arial";	font-size: 12px;	text-decoration: none;		color:#<?print(getStyle("FooterText"))?>; background:#<?print(getStyle("FooterBg"))?>;}
td.Footer2 {	font-family: "Arial";	font-size: 12px;	text-decoration: none;		background:#<?print(getStyle("Footer"))?>;}

td.High1 {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #000000;	background:#<?print(getStyle("High1"))?>;}
td.High2 {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #000000;	background:#<?print(getStyle("High2"))?>;}
td.High3 {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #000000;	background:#<?print(getStyle("High3"))?>;}

.lMenu {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color:#<?print(getStyle("lMenuText"))?>;	}
.lMenuOver {	font-family: "Arial";	font-size: 14px;	font-weight: bold; 		color:#<?print(getStyle("lMenuTextOver"))?>;	background:#<?print(getStyle("lMenuOver"))?>;  text-decoration: underline;} 

.hMenu {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color:#<?print(getStyle("hMenuText"))?>;	background:#<?print(getStyle("hMenuBg"))?>; background-image:url('upload/Style/<?print(getStyle("hMenuBgImg"))?>')}
.hMenuOver {	font-family: "Arial";	font-size: 14px;	font-weight: bold; 		color:#<?print(getStyle("hMenuText"))?>;	background:#<?print(getStyle("hMenuBgOver"))?>;  background-image:url('upload/Style/<?print(getStyle("hMenuBgImgOver"))?>')} 

.vMenu {	font-family: "Arial";	font-size: 16px;	font-weight: bold;		color:#<?print(getStyle("vMenuText"))?>;	background:#<?print(getStyle("vMenuBg"))?>;}
.vMenuOver {	font-family: "Arial";	font-size: 16px;	font-weight: bold; 		color:#<?print(getStyle("vMenuText"))?>;	background:#<?print(getStyle("vMenuBgOver"))?>;  } 

.SectionTitle {	font-family: "Arial";	font-size: 20px;	font-weight: bold;		color: #<?print(getStyle("SectionTitle"))?>;}
.SectionTitle2 {font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #<?print(getStyle("SectionTitle2"))?>;}

td.tablehead {	font-family: "Arial";	font-size: 14px;	font-weight: bold;		color: #000000;	background:#<?print(getStyle("Tablehead"))?>;}
td {		font-family: "Arial";	font-size: 14px;					color: #000000;}

td.scorehead  {font-weight: bold; color:#ffffff; background:#848484} 
td.score  {color:#000000; background:#ffffff} 

td.tabhead { 	font-family: "Arial", "Helvetica", "sans-serif"; font-size: 10pt; color: #000088; font-weight:bold;}
tr.tab {	background-color:#ffffff; }
</style>
</head>

<body marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" background="upload/Style/<?print(getStyle("BackgroundImage"))?>" onload="initLightbox();document.getElementById('img2').src=photo[0];document.getElementById('highlightdesc').innerHTML=photodesc[0];setTimeout('FadeImg()',sleep);">

<TABLE WIDTH="1000" CELLPADDING="0" CELLSPACING="0" BORDER="0" BGCOLOR="#000000" ALIGN="CENTER">

<tr><td align=center colspan=3 class=Header><?banner();?></td></tr>
<tr><td align=cente colspan=3 class=hMenu><?hMenu("Top")?></td></tr>

<tr><td width=10 class=MainBg><img src="images/shim.gif" width=10 height=300 border=0></td>
<td valign=top class=Main><table width=980 CELLPADDING="0" CELLSPACING="0" BORDER="0">
<td class=Left valign=top width=180><?vMenu("Left")?></td>
<td class=Main valign=top width=800>
<? if (isset($section)) { ?>
<?include("include/main.php");?>
<? } else { ?>
<?include("include/highlight.php");
highlight("Highlight@@800@@358");?>
<? } ?>
</td>
</table></td>
<td width=10 class=MainBg><img src="images/shim.gif" width=10 height=1 border=0></td></tr>


<tr><td align=center colspan=3 class=Footer><?footer();?></td></tr>

</TABLE>
<br>
</body>
</html>

<?

function banner() {
	print("<table border=0 width=1000 cellpadding=0 cellspacing=0><tr bgcolor=#ffffff><td valign=bottom><a href=./home.php><img src=\"upload/Style/".getStyle("Logo")."\" border=0></a></td>");
	print("<td valign=bottom align=center><img src=\"upload/Style/".getStyle("Banner01")."\" border=0></a></td>");
	print("</tr></table>");
}

function hMenu($dbname) {
global $langflag;

?><script language="javascript">
function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
//-->
</script>
<?
print("<table border=0 cellpadding=2 cellspacing=0><tr>");	// horizontal menu buttons, with drop downs
print("<td><img src=\"images/shim.gif\" width=15 height=26 border=0></td>\n");
$rowsArray=getRows($dbname.".txt");
foreach($rowsArray as $line) {
	$itemArray=explode("\t",trim($line));
	if ($itemArray[2]=='Active' && $itemArray[3]==1) {
           if ($itemArray[4]<>"") {
		$thislink=$itemArray[4];
	   } else {
		$thislink="?section=".$dbname."&id=".$itemArray[0];
	   }
//print($thislink);
?>
<?if (eregi("http://",$thislink)){?>
<td align=center valign=center class=hMenu style="cursor:pointer" onmouseover="javascript:this.className='hMenuOver'; MM_showHideLayers('L<?print($itemArray[0]);?>','','show')" onmouseout="javascript:this.className='hMenu'; MM_showHideLayers('L<?print($itemArray[0]);?>','','hide')" onClick="javascript:window.open('<?print($thislink);?>');">
<?}else{?>
<td align=center valign=center class=hMenu style="cursor:pointer" onmouseover="javascript:this.className='hMenuOver'; MM_showHideLayers('L<?print($itemArray[0]);?>','','show')" onmouseout="javascript:this.className='hMenu'; MM_showHideLayers('L<?print($itemArray[0]);?>','','hide')" onClick="javascript:document.location.href='<?print($thislink);?>'">
<?}?>
<!--menu layers
<div style="position:absolute; z-index:200;"><div id="L<?print($itemArray[0]);?>" style="position:absolute; width:180px; height:60px; left: 0px; top: 18px; visibility: hidden" onMouseOver="MM_showHideLayers('L<?print($itemArray[0]);?>','','show')" onMouseOut="MM_showHideLayers('L<?print($itemArray[0]);?>','','hide')"> 
<table width="180" border="0" cellspacing="0" cellpadding="0">
<?if (eregi("http://",$thislink)){?>
<tr><td align=center valign=center class=hMenu style="cursor:pointer" onmouseover="javascript:this.className='hMenuOver';" onmouseout="javascript:this.className='hMenu';" onClick="javascript:window.open('$thislink');'">
<?}else{?>
<tr><td align=center valign=center class=hMenu style="cursor:pointer" onmouseover="javascript:this.className='hMenuOver';" onmouseout="javascript:this.className='hMenu';" onClick="javascript:document.location.href='<?print($thislink)?>'">
<?}?>
<td></tr>
</table></div></div>
<!--menu layers end-->
&nbsp;&nbsp;&nbsp;&nbsp;<?print(getLang($itemArray[1]));?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?
	}
}
print("<td><img src=\"images/shim.gif\" width=15 height=25 border=0></td>\n");
print("</tr></table>\n");
}


function searchBox() {
?><form name=f1 action=?section=Search><input type=text name=searchText value="<?print(getLabel("Search"))?>" onFocus="this.value='';"> <input type=submit value="<?print(getLabel("Go"))?>"></form><?
}



function lMenu() {
global $link;
print("<table border=0 cellpadding=8 cellspacing=0><tr>");	// language buttons
	$rowsArray=explode("::",trim(getSetting("Languages")));
	for($i=0;$i<count($rowsArray);$i++)
		print("<td width=50 align=center valign=center class=lMenu style=\"cursor:pointer\" onmouseover=\"javascript:this.className='lMenuOver'\" onmouseout=\"javascript:this.className='lMenu'\" onClick=\"javascript:document.location.href='".$link."&la=".$i."'\">$rowsArray[$i]</td>\n");
print("</tr></table>");
}

function vMenu($dbname) {
global $langflag;

print("<table border=0 cellpadding=8 cellspacing=0 width=100%>");	// vertical menu buttons
$rowsArray=getRows($dbname.".txt");
foreach($rowsArray as $line) {
	$itemArray=explode("\t",trim($line));
	if ($itemArray[2]=='Active') {
		if ($itemArray[4]<>"") 
			$thislink=$itemArray[4];
		else 
			$thislink="?section=".$dbname."&id=$itemArray[0]";
		if (eregi("http://",$thislink))
			print("<tr><td align=center valign=center class=vMenu style=\"cursor:pointer\" onmouseover=\"javascript:this.className='vMenuOver'\" onmouseout=\"javascript:this.className='vMenu'\" onClick=\"javascript:window.open('$thislink');\"><img src=images/shim.gif width=1 height=10>".getLang($itemArray[1])."</td></tr>\n");
		else
			print("<tr><td align=center valign=center class=vMenu style=\"cursor:pointer\" onmouseover=\"javascript:this.className='vMenuOver'\" onmouseout=\"javascript:this.className='vMenu'\" onClick=\"javascript:document.location.href='$thislink'\"><img src=images/shim.gif width=1 height=10>".getLang($itemArray[1])."</td></tr>\n");
	}
}
print("</table><br><br>\n");
}

function vAd($dbname){
global $langflag;

print("<table border=0 cellpadding=4 cellspacing=0 width=100%>");	// vertical ad buttons
$rowsArray=getRows($dbname.".txt"); 				
foreach($rowsArray as $line) {
	$itemArray=explode("\t",trim($line));
	if ($itemArray[2]=='Active') {
		print("<tr><td align=center>\n");
		if (isset($itemArray[1]))
			print("<a href=\"$itemArray[3]\" target=_blank>".getLang($itemArray[1])."</a><br>");
		if (isset($itemArray[4]))
			print("<a href=\"$itemArray[3]\" target=_blank><img src=\"upload/$dbname/$itemArray[4]\" border=0></a><br>");
		print("<br></td></tr>\n");
	}
}
print("</table><br><br>\n");
}

function footer() {
?>
<table width="1000" cellpadding="5" cellspacing="0" border=0 style="background-image:url('upload/Style/<?print(getStyle("Footer01"))?>')">
<tr><td width=100% align=center valign=top class=Footer>
<a href="?section=Top&id=3"><font color=#ffffff><?print(getLabel("ContactUs"));?></font></a>
<img src=images/shim.gif width=190 height=1>
	&copy Copyright 2014 <?print(getSetting("SiteName"));?>. <?print(getLabel("AllRightsReserved"));?>. 
<img src=images/shim.gif width=190 height=1>
</tr></table><?
}


?>