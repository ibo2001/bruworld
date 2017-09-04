<?php
/*
 * Banner Shortcode
 * Author: ebutikken
 * Author URI: http://ebutikken.com/
 * Version: 1.0.0
 */

function getGridsPosts(){
    $query = array(
        'post_type' => 'grid_template',
        'posts_per_page' => -1,
        'orderby' => 'post__in'
    );
    $posts = get_posts( $query );
    $values = array();
    if ( $posts ){
        foreach($posts as $post){
            $values[$post->post_name] = $post->ID;
        }
    }
        return $values;
}

vc_map(
    array(
        'name' => __( 'GazaWay Tiles2', 'js_composer' ),
        'base' => 'gazaway_tiles',
        'icon' => 'icon-wpb-images-stack',
        'category' => __( 'Content', 'js_composer' ),
        'description' => __( 'Responsive tiles', 'js_composer' ),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __( 'Widget title', 'js_composer' ),
                'param_name' => 'title',
                'description' => __( 'Enter text used as widget title (Note: located above content element).', 'js_composer' ),
            ),

            array(
                'type' => 'attach_images',
                'heading' => __( 'Images', 'js_composer' ),
                'param_name' => 'images',
                'value' => '',
                'description' => __( 'Select images from media library.', 'js_composer' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Main grid template', 'js_composer' ),
                'param_name' => 'main_grid_id',
                'value' => getGridsPosts(),
                'description' => 'Select main grid template.',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Grid padding',
                'param_name' => 'grid_padding',
                'description' => 'Enter padding value without px unit eg. 5',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Small grid template', 'js_composer' ),
                'param_name' => 'small_grid_id',
                'value' => getGridsPosts(),
                'description' => 'Select small screen grid template.',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Small screen breaking point',
                'param_name' => 'breaking_point',
                'description' => 'Breaking point for small template',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Defalutl grid template', 'js_composer' ),
                'param_name' => 'default_grid_id',
                'value' => getGridsPosts(),
                'description' => 'in case of main grid faild.',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'On click action', 'js_composer' ),
                'param_name' => 'onclick',
                'value' => array(
                    __( 'None', 'js_composer' ) => '',
                    __( 'Link to large image', 'js_composer' ) => 'img_link_large',
                    __( 'Open custom link', 'js_composer' ) => 'custom_link',
                ),
                'description' => __( 'Select action for click action.', 'js_composer' ),
                'std' => 'link_image',
            ),
            array(
                'type' => 'exploded_textarea_safe',
                'heading' => __( 'Custom links', 'js_composer' ),
                'param_name' => 'custom_links',
                'description' => __( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'js_composer' ),
                'dependency' => array(
                    'element' => 'onclick',
                    'value' => array( 'custom_link' ),
                ),
            ),
            array(
                'type' => 'exploded_textarea_safe',
                'heading' => __( 'Custom titles', 'js_composer' ),
                'param_name' => 'custom_titles',
                'description' => __( 'Enter titles for each image (Note: divide links with linebreaks (Enter)).', 'js_composer' ),
                'dependency' => array(
                    'element' => 'onclick',
                    'value' => array( 'custom_link' ),
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Title height',
                'param_name' => 'title_height',
                'description' => 'Height for title without unit',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => 'Title text color',
                'param_name' => 'title_text_color',
                'description' => 'Title Text color',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => 'Title background color',
                'param_name' => 'title_background_color',
                'description' => 'Title background color',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Font size',
                'param_name' => 'font_size',
                'description' => 'Tile title font size with px',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Custom link target', 'js_composer' ),
                'param_name' => 'custom_links_target',
                'description' => __( 'Select where to open  custom links.', 'js_composer' ),
                'dependency' => array(
                    'element' => 'onclick',
                    'value' => array(
                        'custom_link',
                        'img_link_large',
                    ),
                ),
                'value' => vc_target_param_list(),
            ),

            array(
                'type' => 'textfield',
                'heading' => __( 'Extra class name', 'js_composer' ),
                'param_name' => 'el_class',
                'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
            ),
            array(
                'type' => 'css_editor',
                'heading' => __( 'CSS box', 'js_composer' ),
                'param_name' => 'css',
                'group' => __( 'Design Options', 'js_composer' ),
            ),
        ),
    )
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Gazaway_Tiles extends WPBakeryShortCode{

        protected function content( $atts, $content = null ) {

            extract( shortcode_atts( array(
                'title' 			            => '',
                'source' 			            => '',
                'images' 			            => '',
                'custom_srcs' 		            => '',
                'onclick'                       => '',
                'custom_links'                  => '',
                'custom_titles'                 => '',
                'custom_links_target'           => '',
                'el_class'                      => '',
                'css' 		 		            => '',
                'main_grid_id'                  => '',
                'small_grid_id'                 => '',
                'default_grid_id'               => '',
                'grid_padding'                  => '5',
                'breaking_point'                => '800',
                'title_height'                  => '40',
                'title_text_color'              => '#000',
                'font_size'                     => '30px',
                'title_background_color'        => '#000'
            ), $atts ) );
            //echo '<h3>att: '.print_r($atts,true).'</h3>';
            /* values */
            $custom_links_array = explode(',',$custom_links);
            $custom_titles_array = explode(',',$custom_titles);
            $main_grid_post = get_post($main_grid_id);
            $small_screen_grid_post = get_post($small_grid_id);

            $main_grid = json_encode($this->gazaway_tiles_format_grid($main_grid_post->post_content));
            $main_grid_name = $main_grid_post->post_name;

            $small_grid = json_encode($this->gazaway_tiles_format_grid($small_screen_grid_post->post_content));

            $break_point = 800;

            /* end values */

            ?>
                <?php if(strlen($images)>0):?>
                <div class="wp-tiles-container">
                    <div id="wp_tiles_1" class="wp-tiles-grid wp-tiles-byline-align-bottom wp-tiles-byline-animated wp-tiles-byline-slide-up wp-tiles-loaded">

                <?php foreach(explode(',',$images) as $key => $image_id):?>
                    <?php $section_id = (array_key_exists($key, $custom_links_array))?$custom_links_array[$key]:''; ?>
                    <?php $custom_title = (array_key_exists($key, $custom_titles_array))?$custom_titles_array[$key]:''; ?>
                    <?php $image_url = wp_get_attachment_url( $image_id );?>
                            <div class="wp-tiles-tile" id="tile-<?php echo $image_id; ?>">
                                <a href="#<?php echo $section_id; ?>" title="<?php echo $custom_title ?>" class="gazaway_tile_link">
                                    <article class="wp-tiles-tile-with-image wp-tiles-tile-wrapper" itemscope="" itemtype="http://schema.org/CreativeWork">
                                        <?php if ( $image_url ) : ?>
                                            <div class='wp-tiles-tile-bg'>
                                                <img src='<?php echo $image_url ?>' class='wp-tiles-img' itemprop="image" />
                                            </div>
                                        <?php endif; ?>
                                        <?php if(strlen($custom_title)>0):?>
                                            <div class="wp-tiles-byline">
                                                <div class="wp-tiles-byline-wrapper gazaway-tiles-byline-wrapper">
                                                    <div id="gazaway_tiles_borderTop"></div>
                                                    <h4 itemprop="name" class="wp-tiles-byline-title gazaway-tiles-byline-title" style="color:<?php echo $title_text_color; ?>; font-size: <?php echo $font_size; ?>"><?php echo $custom_title ?></h4>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </article>
                                </a>
                            </div>
                    <?php endforeach; ?>

                    </div>
                </div>
<?php

                //echo '<h3>grid_post: '.$grid_content.'</h3>';

                $json = json_decode('{"wp_tiles_1":{"grids":{"'.$main_grid_name.'":'.$main_grid.'},"default_grid":"'.$default_grid_id.'","small_screen_grid":'.$small_grid.',"breakpoint":'.$break_point.',"grid_selector_color":"","colors":"","background_opacity":"","padding":'.$grid_padding.',"byline_template":"","byline_template_textonly":false,"byline_opacity":"","byline_color":"'.$title_background_color.'","byline_height":'.$title_height.',"byline_height_auto":false,"text_color":"","image_text_color":"","link":"","link_new_window":"","text_only":false,"images_only":false,"hide_title":false,"animate_init":true,"animate_resize":false,"animate_template":true,"image_size":"medium","image_source":"","byline_effect":"slide-up","byline_align":"bottom","image_effect":"none","pagination":"none","legacy_styles":"","extra_classes":[],"extra_classes_grid_selector":[],"full_width":false,"next_query":false,"id":"wp_tiles_1"}}');
                //echo '<h3>json: '.print_r($json,true).'</h3>';

                wp_localize_script( 'wp-tiles', 'wptilesdata', $json ); ?>
                <?php endif; ?>
            <?php


        }
        public function gazaway_tiles_format_grid( $grid ) {
            if ( !is_array( $grid ) )
                $grid = explode( "\n", str_replace( "|", "\n", $grid ) );

            $grid = array_map( 'trim', $grid );

            return $grid;
        }
    }
}