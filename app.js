/* Foundation v2.2.1 http://foundation.zurb.com */
jQuery(document).ready(function ($) {
	
	/* TABS --------------------------------- */
	/* Remove if you don't need :) *

	function activateTab($tab) {
		var $activeTab = $tab.closest('dl').find('a.active'),
				contentLocation = $tab.attr("href") + 'Tab';
				
		// Strip off the current url that IE adds
		contentLocation = contentLocation.replace(/^.+#/, '#');

		//Make Tab Active
		$activeTab.removeClass('active');
		$tab.addClass('active');

    //Show Tab Content
		$(contentLocation).closest('.tabs-content').children('li').hide();
		$(contentLocation).css('display', 'block');
	}

	$('dl.tabs').each(function () {
		//Get all tabs
		var tabs = $(this).children('dd').children('a');
		tabs.click(function (e) {
			activateTab($(this));
		});
	});

	if (window.location.hash) {
		activateTab($('a[href="' + window.location.hash + '"]'));
		$.foundation.customForms.appendCustomMarkup();
	}

	/* ALERT BOXES ------------ *
	$(".alert-box").delegate("a.close", "click", function(event) {
    event.preventDefault();
	  $(this).closest(".alert-box").fadeOut(function(event){
	    $(this).remove();
	  });
	});


	/* PLACEHOLDER FOR FORMS ------------- */
	/* Remove this and jquery.placeholder.min.js if you don't need :) 

	$('input, textarea').placeholder();

	/* TOOLTIPS ------------ *
	$(this).tooltips();



	/* UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE6/7/8 SUPPORT AND ARE USING .block-grids */
//	$('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'left'});
//	$('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'left'});
//	$('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'left'});
//	$('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'left'});



	/* DROPDOWN NAV ------------- 

	var lockNavBar = false;
	$('.nav-bar a.flyout-toggle').live('click', function(e) {
		e.preventDefault();
		var flyout = $(this).siblings('.flyout');
		if (lockNavBar === false) {
			$('.nav-bar .flyout').not(flyout).slideUp(500);
			flyout.slideToggle(500, function(){
				lockNavBar = false;
			});
		}
		lockNavBar = true;
	});
  if (Modernizr.touch) {
    $('.nav-bar>li.has-flyout>a.main').css({
      'padding-right' : '75px'
    });
    $('.nav-bar>li.has-flyout>a.flyout-toggle').css({
      'border-left' : '1px dashed #eee'
    });
  } else {
    $('.nav-bar>li.has-flyout').hover(function() {
      $(this).children('.flyout').show();
    }, function() {
      $(this).children('.flyout').hide();
    })
  }

*/
	
	// jttip Nav Tooltip

var imageurl = "img/nav_arrow.png";

$(document).ready(function(){
			
	var mouseX = 0;
	var mouseY = 0;
	$().mousemove( function(e) {
		mouseX = e.pageX; 
		mouseY = e.pageY;
	});
	 
	$(".jttip").hover(
		function () {
			id = $(this).attr('id');
			
			split = id.split('-', 2)
			number = split[1];
			
			clearTimeout(window['ta' + number]);
			$('#'+id).show();

			
		}, 
		function () {
			
			id = $(this).attr('id');
			$('#'+id).fadeOut('fast');
			
		}
	);
	 
	$(".jttip").each(function (i) {
		var prepend$$i = 0;
		
		$("#jttrigger-"+i).hover(
	      function () {
			
			if(prepend$$i == 0)
			{
				$("#jttip-"+i).prepend('<img class="nubbin" src="'+imageurl+'" alt="arrow" height="13" width="27">');
				prepend$$i = "done";
			}
			
			var triggerPos = $("#jttrigger-"+i).position();
			var jttipPos = $("#jttip-"+i).position();
			var triggerHeight = $("#jttrigger-"+i).height();
			var triggerWidth = $("#jttrigger-"+i).width();
			
	      	var jttipWidth = $("#jttip-"+i).width();
	      	
	      	var offsetX = triggerWidth-jttipWidth;
	      	
	      	$("#jttip-"+i).css('top',triggerPos.top+triggerHeight);
	      	
	      	if(offsetX > 0)
	      	{
	      		$("#jttip-"+i).css('left',triggerPos.left-(offsetX/2));
	      	}
	      	else
	      	{
	      		$("#jttip-"+i).css('left',triggerPos.left+(offsetX/2));
	      	}
	      	
	      	window['t' + i] = setTimeout(function() { $("#jttip-"+i).fadeIn('fast'); },100);
	        
	      }, 
	      function () {
				
				clearTimeout(window['t' + i]);

				if($("#jttip-"+i).css("display") == 'block')
				{
					window['ta' + i] = setTimeout(function() { $("#jttip-"+i).hide(); },100);
				}

	      });
	      
		});
	
});
  
});
