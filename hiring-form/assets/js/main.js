/**
 * Created by YanTotal on 01.09.15.
 */
jQuery( document ).ready(function() {
    function slide(el, val) {
        jQuery(el).find(".slider__block--value").css("width", val + "%");
        jQuery(el).find("input").val(val);
    }
    jQuery(".sliderjs").click(function(e) {
        var slider_width = jQuery(this).width();
        var posX = jQuery(this).position().left;
        var value_px = e.pageX - posX;
        var value_percent = value_px/slider_width*100;
        var value = Math.round(value_percent);
        slide(this, value);
    });
    jQuery(".slider__labels label").click(function() {
        var value = jQuery(this).attr("data-skill");
        var slider = jQuery(this).parent().prev();
        slide(slider, value);
    });
});