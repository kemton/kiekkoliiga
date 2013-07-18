// Aurora Menu v1.5
// Design and conception by Aurora Studio http://www.aurora-studio.co.uk
// Plugin development by Invent Partners http://www.inventpartners.com
// Plugin optimised a bit by Armoured Minds http://www.armouredminds.com
// Copyright Invent Partners & Aurora Studio 2009

var auroraMenuSpeed = 150;
var auroraAnimateSlide = true;

$(document).ready(function(){
	$('.auroramenu').each(function(){
  	var auroraMenuCount = $('.auroramenu').index($(this))
		var auroraMenuItems = $(this).children('li');
		auroraMenuItems.each(function(){
  		var auroraMenuItem = $(this);
			var auroraMenuItemCount = $(auroraMenuItems).index(auroraMenuItem);
		  var auroraSubMenu = auroraMenuItem.children('ul');
			if($.cookie('arMenu_' + auroraMenuCount + '_arItem_' + auroraMenuItemCount) == 1){
				auroraSubMenu.show().addClass('auroraopen');
			} else {
				auroraSubMenu.hide().removeClass('auroraopen');
			}
			auroraMenuItem
		    .attr('auroramenuitem','arMenu_' + auroraMenuCount + '_arItem_' + auroraMenuItemCount)
			  .children('a').click(function(e){
  			  e.preventDefault();
					var arshow = 0;
					var auroraThisMenuItem = $(this).parent('li');
					var auroraThisSubMenu = $(this).siblings('ul');					
        	if ($.browser.msie && parseInt($.browser.version) < 8 && $.fx.off = false) {
            var auroraFxStateAltered = true;
        		$.fx.off = true;
        	}
					if(auroraThisMenuItem.hasClass('auroraopen')){
						auroraThisMenuItem.removeClass('auroraopen');
						auroraThisSubMenu.slideUp(auroraMenuSpeed);
					} else {
						arshow = 1;
						auroraThisMenuItem.addClass('auroraopen');
						auroraThisSubMenu.slideDown(auroraMenuSpeed);
					}		
        	if (auroraFxStateAltered) {
        		$.fx.off = false;
        	}
				  $.cookie($(this).attr('auroramenuitem') , arshow , {path: '/'});
  			});
		});
	});
});