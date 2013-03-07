function customise_dock_for_theme() {
    var dock = M.core_dock;

    dock.on('dock:itemschanged', theme_dockmod_handle_spans);
    dock.on('dock:panelgenerated', theme_dockmod_blockstyle);
}
function theme_dockmod_blockstyle() {
    this.Y.all('.dockeditempanel_content').each(function(dockblock){
    	dockblock.addClass('block');
    });
}


function theme_dockmod_handle_spans() {
    if (this.Y.all('.block.dock_on_load').size()>0) {
        // Do not resize during initial load
        return;
    }
    

    var blockregions = [];
    var populatedblockregions = 0;
    var hasregionpost = 0;
    var hasregionpre = 0;

    this.Y.all('.block-region').each(function(region){
        var hasblocks = (region.all('.block').size() > 0);
        var regioncheck = region.get('id');
        if (hasblocks) {
        	if (regioncheck == 'region-pre') {
        		hasregionpre++;
        	}
        	if (regioncheck == 'region-post') {
        		hasregionpost++;
        	}
        	
            populatedblockregions++;
            //region.addClass('span3');
        } else {
        	if (regioncheck == 'region-post') {
        		region.removeClass('span3');
        		region.addClass('span0');
        	}
        }
    });
    
    console.log('Post' + hasregionpost);
    console.log('Pre' + hasregionpre);
   // alert('hasregionpost' . hasregionpost);
    var bodynode = M.core_dock.nodes.body;
    var showregions = false;
    if (bodynode.hasClass('blocks-moving')) {
        // open up blocks during blocks positioning
        showregions = true;
    }
    
    var maincontent = this.Y.all('#region-bs-main');
    var mainprecontent = this.Y.all('#region-bs-main-and-pre');
    var regionpre = this.Y.all('#region-pre');
    var regionpost = this.Y.all('#region-post');
    
    if (hasregionpost==0 && hasregionpre==0 && showregions==false) {
    	console.log('1');
    	mainprecontent.removeClass('span9');
    	mainprecontent.addClass('span12');
    	
    	maincontent.removeClass('span8');
    	maincontent.addClass('span12');
    	
    	regionpost.removeClass('span3');
    	regionpost.addClass('span0');
    	
    	regionpre.removeClass('span4');
    	regionpre.addClass('span0');
    	
    } else if (hasregionpost==1 && hasregionpre==0 && showregions==false) {
    	
    	console.log('2');
    	regionpre.removeClass('span4');
    	regionpre.addClass('span0');
    	
    	maincontent.removeClass('span8');
    	maincontent.addClass('span12');
    	
    	regionpost.removeClass('span0');
    	regionpost.addClass('span3');
    	
    	mainprecontent.removeClass('span12');
    	mainprecontent.addClass('span9');

    } else if (hasregionpost==0 && hasregionpre==1 && showregions==false) {
    	console.log('3');
    	mainprecontent.removeClass('span9');
    	mainprecontent.addClass('span12');
    	
    	regionpre.removeClass('span0');
    	regionpre.addClass('span4');
    	
    	maincontent.removeClass('span12');
    	maincontent.addClass('span8');
    	
    }  else if (hasregionpost==1 && hasregionpre==1 && showregions==false) {
    	console.log('4');
    	
    	maincontent.removeClass('span12');
    	maincontent.addClass('span8');
    	
    	mainprecontent.removeClass('span12');
    	mainprecontent.addClass('span9');
    	
    	regionpost.removeClass('span0');
    	regionpost.addClass('span3');
    	
    	regionpre.removeClass('span0');
    	regionpre.addClass('span4');
    }
}
