<?php
/**
 * Created by PhpStorm.
 * User: saharelsayed
 * Date: 06/09/17
 * Time: 01:34
 */

vc_map(
    array(
        'name' => __( 'Flex Separator', 'js_composer' ),
        'base' => 'gazaway_separator',
        'icon' => 'icon-wpb-ui-separator',
        'category' => 'Gazaway',
        'description' =>'Flex Separator',
        'params' => array(
            vc_map_add_css_animation(),
            array(
                'type' => 'el_id',
                'heading' => __( 'Element ID', 'js_composer' ),
                'param_name' => 'el_id',
                'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'js_composer' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => __( 'Extra class name', 'js_composer' ),
                'param_name' => 'el_class',
                'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => 'Separator color',
                'param_name' => 'separator_color',
                'description' => 'Separator color',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Thickness',
                'param_name' => 'separator_thickness',
                'description' => 'set the separator thickness',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Top margin',
                'param_name' => 'separator_top_margin',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Bottom margin',
                'param_name' => 'separator_bottom_margin',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Width',
                'param_name' => 'separator_width',
            ),

        ),
    )
);


if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Gazaway_Separator extends WPBakeryShortCode{
        protected function content($atts, $content = null){
            extract(shortcode_atts(array(
                'el_id' => '',
                'el_class' => '',
                'separator_color' => '#000',
                'separator_thickness' => '10px',
                'separator_top_margin' => '0px',
                'separator_bottom_margin' => '0px',
                'separator_width' => '50%',
            ), $atts));
            $intValTopMargin = intval($separator_top_margin);
            $intValBtmMargin = intval($separator_bottom_margin);
            $sepThickness = intval($separator_thickness);
            $sepWidth = intval($separator_width);

            $color = 'background-color: '.$separator_color.';';
            $top_margin = ($intValTopMargin>0)?'margin-top::'.$intValTopMargin.'px;':'';
            $btm_margin = ($intValBtmMargin>0)?'margin-bottom:'.$intValBtmMargin.'px;':'';

            $thickness = ($sepThickness>0)?'height:'.$sepThickness.'px;':'';
            $width = ($sepWidth>0)?'width:'.$sepWidth.'%;':'';


            ?>
            <div style="margin-left: auto;margin-right: auto;<?php echo $color,$top_margin.$btm_margin.$thickness.$width; ?>"></div>
            <?php
        }
    }
}