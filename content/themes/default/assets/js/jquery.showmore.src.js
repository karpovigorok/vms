/*
 * Show More jQuery Plugin
 * Author: Jason Alvis
 * Author Site: http://www.jasonalvis.com
 * License: Free General Public License (GPL)
 * Version: 1.0.4
 * Date: 21.05.2013
 */
(function(jQuery) {
	jQuery.fn.showMore = function (options) {
			
		// Default showmore 
		var defaults = {
		   	speedDown	: 	300,
		   	speedUp		:	300,
		   	height		: 	'265px',
		   	showText	: 	'Show',
		   	hideText	: 	'Hide'	 
		};
			
		var options = jQuery.extend(defaults, options);
					
		return this.each(function() {			
			var	$this					= jQuery(this),
				$showMoreOrgHeight 		= $this.height();
			
			if( $showMoreOrgHeight > parseInt(options.height) ){
				// Insert showmore_content within the showmore div
				$this.wrapInner('<div class="showmore_content" />');
								
				// Set the height of the showmore_content			
				$this.find('.showmore_content').css('height', options.height)
											
				// Append the showmore trigger within the showmore div			
				$this.append('<div class="showmore_trigger"><span class="more">' + options.showText + '</span><span class="less" style="display:none;">' + options.hideText + '</span></div>')
											
				// Showmore going down
				$this.find('.showmore_trigger').on('click', '.more', function (){
					jQuery(this).hide();
					jQuery(this).next().show();
					jQuery(this).parent().prev().animate({ height: $showMoreOrgHeight }, options.speedDown);
				});
											
				// Showmore going up
				$this.find('.showmore_trigger').on('click', '.less', function(){
					jQuery(this).hide();
					jQuery(this).prev().show();
					jQuery(this).parent().prev().animate({ height: options.height }, options.speedUp);
				});
            }		

		});
		
	};
})(jQuery);

/* 
 
BASIC USAGE
$(document).ready(function() {
     	
    $('.showmore').showMore({
		speedDown: 300,
	    speedUp: 300,
	    height: '165px',
	    showText: 'Show more',
	    hideText: 'Show less'
	});
	      
});

DEFAULT STYLES, ADD TO YOUR CSS
.showmore_content		{ position:relative; overflow:hidden; }			
.showmore_trigger 		{ width:100%; height:45px; line-height:45px; cursor:pointer; }
.showmore_trigger span	{ display:block; }

*/
