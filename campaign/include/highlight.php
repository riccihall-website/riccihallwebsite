<?
function highlight($argument) {

$argArray=explode("@@",trim($argument));
$dbname=$argArray[0];
$width=$argArray[1];
$height=$argArray[2];
?>
<SCRIPT LANGUAGE="JavaScript">

<!-- Begin

var ie5=(document.getElementById && document.all);
var ns6=(document.getElementById && !document.all);

nPlus = 5;   //the % of fading for each step
speed = 50;  //the speed
sleep = 1000*<?print(getSetting("HighlightRotationPeriod"));?>;
i=0;
j=0;
k=0;
opacity = -nPlus;

var photo=new Array();
var photolink=new Array();
var photodesc=new Array();
<?
	$rowsArray=getRows($dbname.".txt");
	for($i=0;$i<count($rowsArray);$i++){
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[2]=='Active')
			print("photo[".$i."]=\"upload/".$dbname."/$itemArray[5]\";\n");
			print("photolink[".$i."]=\"$itemArray[3]\";\n");
			print("photodesc[".$i."]=\"".getLang($itemArray[4])."\";\n");
	}
	print("k=".count($rowsArray).";\n");
?>

cycle=0;
function FadeImg(pr_cycle,direction){

    if (pr_cycle == null ) { // manual
        pr_cycle = 0;
    }

    if(document.getElementById && pr_cycle == cycle){  // manual
        //document.getElementById('img1').style.visibility="visible";
        imgs = document.getElementById('img2');
	opacity = opacity +nPlus;
        if(opacity>100){
	        opacity = 0;
	}
        if(ie5){
        	imgs.style.filter="alpha(opacity=0)";
		imgs.filters.alpha.opacity = opacity;
        }
        if(ns6){
     	   imgs.style.opacity = 0;
		imgs.style.opacity = opacity/100.0;
        }
        if(opacity==0){
		if (direction == 1) { // reverse direction
			j=i-1;
			if (j==-1) j=k-1;
			document.getElementById('img1').src=photo[i];
			document.getElementById('img2').src=photo[j];
			document.getElementById('highlightdesc').innerHTML=photodesc[j];
			i--;
			if (i==-1) i=k-1;
		} else {
			j=i+1;
			if (j==k) j=0;
			document.getElementById('img1').src=photo[i];
			document.getElementById('img2').src=photo[j];
			document.getElementById('highlightdesc').innerHTML=photodesc[j];
			i++;
			if (i==k) i=0;
		}
	}

        if(opacity==100){
   		setTimeout(function(){FadeImg(pr_cycle);},sleep);
	} else {
   		setTimeout(function(){FadeImg(pr_cycle);},speed);
	}
    }
}



//  End -->
</script>

<img src=images/shim.gif border=0 width=<?=$width?> height=<?=$height?>>
<div style="position:relative;left:0px; top:-<?=$height?>px;" align="left">
  <img id="img1" src="images/shim.gif" border=0 width=<?=$width?> height=<?=$height?> style="position:absolute; width:<?=$width?>px; height:<?=$height?>px; left:0px; top:0px; z-index:1;">
  <img id="img2" src="images/shim.gif" border=0 width=<?=$width?> height=<?=$height?> style="position:absolute; width:<?=$width?>px; height:<?=$height?>px; left:0px; top:0px; z-index:2" useMap=#Map id=map>
</div>
<div id="highlightdesc"></div>
<MAP name=Map>
<AREA href="javascript:cycle++;FadeImg(cycle,1)" shape=rect coords="0,0,<?=$width/2?>,<?=$height?>">
<AREA href="javascript:cycle++;FadeImg(cycle,0);" shape=rect coords="<?=$width/2?>,0,<?=$width?>,<?=$height?>">
</MAP>
<?
}
?>