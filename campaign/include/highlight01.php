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
	$rowsArray=getRows("Highlight.txt");
	for($i=0;$i<count($rowsArray);$i++){
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[2]=='Active')
			print("photo[".$i."]=\"upload/Highlight/$itemArray[5]\";\n");
			print("photolink[".$i."]=\"$itemArray[3]\";\n");
			print("photodesc[".$i."]=\"".getLang($itemArray[4])."\";\n");
	}
	print("k=".count($rowsArray).";\n");
?>

cycle=0;
function FadeImg(pr_cycle){

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
		j=i+1;
		if (j==k) j=0;
		document.getElementById('img1').src=photo[i];
		document.getElementById('img2').src=photo[j];
		document.getElementById('highlightdesc').innerHTML=photodesc[j];
		i++;
		if (i==k) i=0;
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

<img src=images/shim.gif border=0 width=800 height=304>
<div style="position:relative;left:0px; top:-304px;" align="left">
  <img id="img1" src="images/shim.gif" border=0 width=800 height=304 style="position:absolute; width:800px; height:304px; left:0px; top:0px; z-index:1;">
  <img id="img2" src="images/shim.gif" border=0 width=800 height=304 style="position:absolute; width:800px; height:304px; left:0px; top:0px; z-index:2" onClick="cycle++;FadeImg(cycle);//document.location.href=photolink[j];">
</div>
<div id="highlightdesc"></div>
