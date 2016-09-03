/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_QuickView
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
var ProductInfo = Class.create();
ProductInfo.prototype = {
    settings: {
        
    },
    
    initialize: function(selector, settings)
    {
        Object.extend(this.settings, settings);
        
        var that = this;
        $j('body').off().on('click', selector, function(e){
            e.preventDefault();
            that.loadInfo(e);
        });
        $j(selector).each(function(index){
            $j(this).hover(
                function() {
                    $j(this).prev('.product-image').fadeTo(200, 0.7);
                    $j(this).parent('.item-images').siblings('.item-info').fadeTo(200, 0.7);
                }, function() {
                    $j(this).prev('.product-image').fadeTo(200, 1);
                    $j(this).parent('.item-images').siblings('.item-info').fadeTo(200, 1);
                }
            );
        });
        $j('#quickview-modal').on('close.fndtn.reveal', function () {
            that.clearContent();
            try {
                setTimeout(function(){ 
                    $j(document).trigger('product-media-loaded');
                },500);
            } catch(err) {
                // there are no configurable products in the page
            }
        });
    },
    
    showLoader: function(el)
    {
        $j(el).prev('.product-image').addClass('spinner');
    },
    
    hideLoader: function(el)
    {
        $j(el).prev('.product-image').removeClass('spinner');
    },
    
    showWindow: function()
    {
        $j('#quickview-modal').foundation('reveal', 'open');
    },
       
    clearContent: function()
    {
        $j('#quickview-modal').remove('.quickview-content');
        $j('#quickview-modal').add('<div class="row quickview-content"></div>');
        // delete price id on product grid or Safari won't update price inside modal
        $j('.products-grid [id^=product-price-]').removeAttr('id');
        $j('.featured-slider [id^=product-price-]').removeAttr('id');
    },
    
    loadInfo: function(e)
    {
        e.preventDefault();
        var that = this;
        var el = e.target;
        $j(el).prev('.product-image').fadeTo(200, 1);
        $j(el).parent('.item-images').siblings('.item-info').fadeTo(200, 1);
        this.showLoader(el);
        $j.ajax({
            type: 'POST',
            url: $j(el).attr('href'),
            dataType: 'html',
            context: document.body,
            success: function(data){
                that.clearContent();
                that.hideLoader(el);
                $j('.quickview-content').html(data);
                $j(".quickview-content").find("script").each(function(i) {
                    $j.globalEval($j(this).text());
                });
                $j(document).foundation();
                that.showWindow();
            }
        });
    }
}

Event.observe(window, 'load', function() {
    new ProductInfo('.quickview-button', {});
});