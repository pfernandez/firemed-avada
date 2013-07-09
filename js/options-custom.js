jQuery(document).ready(function($) {

    // Color Scheme Options - These array names should match
    // the values in color_scheme of options.php
    
    var green = new Array();
    green['primary_color']='#a0ce4e';
    green['pricing_box_color']='#92C563';
    green['image_gradient_top_color']='#D1E990';
    green['image_gradient_bottom_color']='#AAD75B';
    green['button_gradient_top_color']='#D1E990';
    green['button_gradient_bottom_color']='#AAD75B';
    green['button_gradient_text_color']='#54770f';

    var darkgreen = new Array();
    darkgreen['primary_color']='#9db668';
    darkgreen['pricing_box_color']='#a5c462';
    darkgreen['image_gradient_top_color']='#cce890';
    darkgreen['image_gradient_bottom_color']='#afd65a';
    darkgreen['button_gradient_top_color']='#cce890';
    darkgreen['button_gradient_bottom_color']='#AAD75B';
    darkgreen['button_gradient_text_color']='#577810';

    var yellow = new Array();
    yellow['primary_color']='#e9a825';
    yellow['pricing_box_color']='#c4a362';
    yellow['image_gradient_top_color']='#e8cb90';
    yellow['image_gradient_bottom_color']='#d6ad5a';
    yellow['button_gradient_top_color']='#e8cb90';
    yellow['button_gradient_bottom_color']='#d6ad5a';
    yellow['button_gradient_text_color']='#785510';

    var lightblue = new Array();
    lightblue['primary_color']='#67b7e1';
    lightblue['pricing_box_color']='#62a2c4';
    lightblue['image_gradient_top_color']='#90c9e8';
    lightblue['image_gradient_bottom_color']='#5aabd6';
    lightblue['button_gradient_top_color']='#90c9e8';
    lightblue['button_gradient_bottom_color']='#5aabd6';
    lightblue['button_gradient_text_color']='#105378';

    var lightred = new Array();
    lightred['primary_color']='#f05858';
    lightred['pricing_box_color']='#c46262';
    lightred['image_gradient_top_color']='#e89090';
    lightred['image_gradient_bottom_color']='#d65a5a';
    lightred['button_gradient_top_color']='#e89090';
    lightred['button_gradient_bottom_color']='#d65a5a';
    lightred['button_gradient_text_color']='#781010';

    var pink = new Array();
    pink['primary_color']='#e67fb9';
    pink['pricing_box_color']='#c46299';
    pink['image_gradient_top_color']='#e890c2';
    pink['image_gradient_bottom_color']='#d65aa0';
    pink['button_gradient_top_color']='#e890c2';
    pink['button_gradient_bottom_color']='#d65aa0';
    pink['button_gradient_text_color']='#78104b';

    var lightgrey = new Array();
    lightgrey['primary_color']='#9e9e9e';
    lightgrey['pricing_box_color']='#c4c4c4';
    lightgrey['image_gradient_top_color']='#e8e8e8';
    lightgrey['image_gradient_bottom_color']='#d6d6d6';
    lightgrey['button_gradient_top_color']='#e8e8e8';
    lightgrey['button_gradient_bottom_color']='#d6d6d6';
    lightgrey['button_gradient_text_color']='#787878';

    var brown = new Array();
    brown['primary_color']='#ab8b65';
    brown['pricing_box_color']='#c49862';
    brown['image_gradient_top_color']='#e8c090';
    brown['image_gradient_bottom_color']='#d69e5a';
    brown['button_gradient_top_color']='#e8c090';
    brown['button_gradient_bottom_color']='#d69e5a';
    brown['button_gradient_text_color']='#784910';

    var red = new Array();
    red['primary_color']='#e10707';
    red['pricing_box_color']='#c40606';
    red['image_gradient_top_color']='#e80707';
    red['image_gradient_bottom_color']='#d60707';
    red['button_gradient_top_color']='#e80707';
    red['button_gradient_bottom_color']='#d60707';
    red['button_gradient_text_color']='#780404';

    var blue = new Array();
    blue['primary_color']='#1a80b6';
    blue['pricing_box_color']='#62a2c4';
    blue['image_gradient_top_color']='#90c9e8';
    blue['image_gradient_bottom_color']='#5aabd6';
    blue['button_gradient_top_color']='#90c9e8';
    blue['button_gradient_bottom_color']='#5aabd6';
    blue['button_gradient_text_color']='#105378';

    // When the select box #base_color_scheme changes
    // of_update_color updates each of the color pickers
    $('#color_scheme').change(function() {
        colorscheme = $(this).val();
        if (colorscheme == 'green') { colorscheme = green; }
        if (colorscheme == 'darkgreen') { colorscheme = darkgreen; }
        if (colorscheme == 'yellow') { colorscheme = yellow; }
        if (colorscheme == 'lightblue') { colorscheme = lightblue; }
        if (colorscheme == 'lightred') { colorscheme = lightred; }
        if (colorscheme == 'pink') { colorscheme = pink; }
        if (colorscheme == 'lightgrey') { colorscheme = lightgrey; }
        if (colorscheme == 'brown') { colorscheme = brown; }
        if (colorscheme == 'red') { colorscheme = red; }
        if (colorscheme == 'blue') { colorscheme = blue; }

        for (id in colorscheme) {
            of_update_color(id,colorscheme[id]);
        }
    });
    
    // This does the heavy lifting of updating all the colorpickers and text
    function of_update_color(id,hex) {
        $('#section-' + id + ' .of-color').css({backgroundColor:hex});
        $('#section-' + id + ' .colorSelector').ColorPickerSetColor(hex);
        $('#section-' + id + ' .colorSelector').children('div').css('backgroundColor', hex);
        $('#section-' + id + ' .of-color').val(hex);
        $('#section-' + id + ' .of-color').animate({backgroundColor:'#ffffff'}, 600);
    }
});
