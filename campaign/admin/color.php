<TABLE WIDTH="960" CELLPADDING="0" CELLSPACING="0" BORDER="0"  ALIGN="CENTER"><TR><TD>
<h1>Color</h1>
<table CELLPADDING="0" CELLSPACING="0" BORDER="0"><tr>
<?
$step=4;
$steph=$step*2;
for ($j=0; $j<=127;$j+=$step){
	for($i=0; $i<=255;$i+=$steph) {
		$r=round(255-$j);
		$g=round($i+$j-2*$i*$j/255);
		$b=$j;
		print("<td bgcolor=#".dechexz($r).dechexz($g).dechexz($b)."><a href=\"javascript:showbar(".$r.",".$g.",".$b.");\"><img src=/images/shim.gif width=$step height=$step border=0></a></td>\n");
	}
	for($i=255; $i>=0;$i-=$steph) {
		$g=round(255-$j);
		$r=round($i+$j-2*$i*$j/255);
		$b=$j;
		print("<td bgcolor=#".dechexz($r).dechexz($g).dechexz($b)."><a href=\"javascript:showbar(".$r.",".$g.",".$b.");\"><img src=/images/shim.gif width=$step height=$step border=0></a></td>\n");
	}
	for($i=0; $i<=255;$i+=$steph) {
		$g=round(255-$j);
		$b=round($i+$j-2*$i*$j/255);
		$r=$j;
		print("<td bgcolor=#".dechexz($r).dechexz($g).dechexz($b)."><a href=\"javascript:showbar(".$r.",".$g.",".$b.");\"><img src=/images/shim.gif width=$step height=$step border=0></a></td>\n");
	}
	for($i=255; $i>=0;$i-=$steph) {
		$b=round(255-$j);
		$g=round($i+$j-2*$i*$j/255);
		$r=$j;
		print("<td bgcolor=#".dechexz($r).dechexz($g).dechexz($b)."><a href=\"javascript:showbar(".$r.",".$g.",".$b.");\"><img src=/images/shim.gif width=$step height=$step border=0></a></td>\n");
	}
	for($i=0; $i<=255;$i+=$steph) {
		$b=round(255-$j);
		$r=round($i+$j-2*$i*$j/255);
		$g=$j;
		print("<td bgcolor=#".dechexz($r).dechexz($g).dechexz($b)."><a href=\"javascript:showbar(".$r.",".$g.",".$b.");\"><img src=/images/shim.gif width=$step height=$step border=0></a></td>\n");
	}
	for($i=255; $i>=0;$i-=$steph) {
		$r=round(255-$j);
		$b=round($i+$j-2*$i*$j/255);
		$g=$j;
		print("<td bgcolor=#".dechexz($r).dechexz($g).dechexz($b)."><a href=\"javascript:showbar(".$r.",".$g.",".$b.");\"><img src=/images/shim.gif width=$step height=$step border=0></a></td>\n");
	}
	print("</tr>\n<tr>");
}
?>
</tr></table>

<script>
<!--
function showbar(rr, gg, bb) {
//alert('#'+d2h(rr)+d2h(gg)+d2h(bb));

tempHTML='<table CELLPADDING=0 CELLSPACING=0 BORDER=1><tr><td><table CELLPADDING=0 CELLSPACING=0 BORDER=0><tr>'
step=4;
for (i=0;i<=255;i+=step){
	rrr=Math.round(rr*i/255);
	ggg=Math.round(gg*i/255);
	bbb=Math.round(bb*i/255);
	tempHTML+='<td bgcolor=#'+d2h(rrr)+d2h(ggg)+d2h(bbb)+'><a href="javascript:showcolor('+rrr+', '+ggg+', '+bbb+');"><img src=/images/shim.gif width='+step+' height=30 border=0></a></td>\n';
}
for (i=0;i<=255;i+=step){
	rrr=Math.round(rr+(i-rr*i/255));
	ggg=Math.round(gg+(i-gg*i/255));
	bbb=Math.round(bb+(i-bb*i/255));
	tempHTML+='<td bgcolor=#'+d2h(rrr)+d2h(ggg)+d2h(bbb)+'><a href="javascript:showcolor('+rrr+', '+ggg+', '+bbb+');"><img src=/images/shim.gif width='+step+' height=30 border=0></a></td>\n';
}
tempHTML+='</tr></table></td></tr></table>';
//alert(tempHTML);
document.getElementById("range").innerHTML=tempHTML;
document.getElementById("colorselect").style.background ='#'+d2h(rr)+d2h(gg)+d2h(bb);
document.getElementById("colorselecttext").innerHTML='#'+d2h(rr)+d2h(gg)+d2h(bb)+'<br>'+rr+', '+gg+', '+bb;
}

function showcolor(rr, gg, bb) {
document.getElementById("colorselect").style.background ='#'+d2h(rr)+d2h(gg)+d2h(bb);
document.getElementById("colorselecttext").innerHTML='#'+d2h(rr)+d2h(gg)+d2h(bb)+'<br>'+rr+', '+gg+', '+bb;
}


function d2h(dd){
	if (dd<16) {
		return '0'+dd.toString(16);
	} else {
		return dd.toString(16);
	}
}
//-->
</script>

<br>

<div id=range>
<table CELLPADDING="0" CELLSPACING="0" BORDER="0"><tr><td width=100>
<img src=/images/shim.gif width=100 height=20 border=0>
</td></tr></table>
</div>
<br>

<table CELLPADDING="0" CELLSPACING="0" BORDER="0"><tr><td width=100>
<div id=colorselect><img src=/images/shim.gif width=100 height=100 border=1></div>
<div id=colorselecttext></div>
</td></tr></table>

</TD></TR></TABLE>
<?
function dechexz($x) {
if ($x<16) {
	return "0".dechex($x);
} else {
	return dechex($x);
}
}
?>
