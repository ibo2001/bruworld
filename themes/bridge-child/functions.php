<?php

// enqueue the child theme stylesheet

Function wp_schools_enqueue_scripts() {
wp_register_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css'  );
wp_enqueue_style( 'childstyle' );
}
add_action( 'wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);


if (!function_exists('latest_post')) {
    function latest_post($atts, $content = null) {
        $blog_hide_comments = "";
        if (isset($qode_options_proya['blog_hide_comments'])) {
            $blog_hide_comments = $qode_options_proya['blog_hide_comments'];
        }

        $qode_like = "on";
        if (isset($qode_options_proya['qode_like'])) {
            $qode_like = $qode_options_proya['qode_like'];
        }

        $args = array(
            "type"       			=> "date_in_box",
            "number_of_posts"       => "",
            "number_of_colums"      => "",
            "number_of_rows"        => "1",
            "text_from_edge"      	=> "",
            "rows"                  => "",
            "order_by"              => "",
            "order"                 => "",
            "category"              => "",
            "text_length"           => "",
            "title_tag"             => "h5",
            "display_category"    	=> "0",
            "display_time"          => "1",
            "display_comments"      => "1",
            "display_like"          => "0",
            "display_share"         => "0",
        );

        extract(shortcode_atts($args, $atts));

        $headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

        //get correct heading value. If provided heading isn't valid get the default one
        $title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

        if($type != "boxes" && $type != "dividers"){
            $q = new WP_Query(
                array('orderby' => $order_by, 'order' => $order, 'posts_per_page' => $number_of_posts, 'category_name' => $category)
            );
        } else {
            $q = new WP_Query(
                array('orderby' => $order_by, 'order' => $order, 'posts_per_page' => $number_of_colums*$number_of_rows, 'category_name' => $category)
            );
        }

        $columns_number = "";
        if($type == 'boxes' || $type == 'dividers') {
            if($number_of_colums == 2){
                $columns_number = "two_columns";
            } else if ($number_of_colums == 3) {
                $columns_number = "three_columns";
            } else if ($number_of_colums == 4) {
                $columns_number = "four_columns";
            }
        }

        //get number of rows class for boxes type
        $rows_number = "";
        if($type == 'boxes' || $type == 'dividers') {
            switch($number_of_rows) {
                case 1:
                    $rows_number = 'one_row';
                    break;
                case 2:
                    $rows_number = 'two_rows';
                    break;
                case 3:
                    $rows_number = 'three_rows';
                    break;
                case 4:
                    $rows_number = 'four_rows';
                    break;
                case 5:
                    $rows_number = 'five_rows';
                    break;
                default:
                    break;
            }
        }

        $html = "";
        $html .= "<div class='latest_post_holder $type $columns_number $rows_number'>";
        $html .= "<ul>";

        while ($q->have_posts()) : $q->the_post();
            $li_classes = "";

            $cat = get_the_category();

            $html .= '<li class="clearfix">';
            if($type == "date_in_box") {
                $html .= '<div itemprop="dateCreated" class="latest_post_date entry_date updated">';
                $html .= '<div class="post_publish_day">'.get_the_time('d').'</div>';
                $html .= '<div class="post_publish_month">'.get_the_time('M').'</div>';
                $html .= '<meta itemprop="interactionCount" content="UserComments: <?php echo get_comments_number(qode_get_page_id()); ?>"/></div>';
            }

            if($type == "boxes" || $type == 'dividers'){
                $html .= '<div class="boxes_image">';
                $html .= '<a itemprop="url" href="'.get_permalink().'">'.get_the_post_thumbnail(get_the_ID(), 'latest_post_boxes').'</a>';
                $html .= '</div>';
            }
            $html .= '<span class="post_infos bru_post_info">';
            if($display_time == '1'  && $type !== 'dividers'){
                $html .= '<span class="date_hour_holder">';
                if($type != 'date_in_box'){
                    $html .= '<span itemprop="dateCreated" class="date entry_date updated">' . get_the_time('d F, Y') . '<meta itemprop="interactionCount" content="UserComments: <?php echo get_comments_number(qode_get_page_id()); ?>"/></span>';
                } else {
                    $html .= '<span itemprop="dateCreated" class="date entry_date updated">' . get_the_time('g:h') . 'h<meta itemprop="interactionCount" content="UserComments: <?php echo get_comments_number(qode_get_page_id()); ?>"/></span>';
                }

                $html .= '</span>';//close date_hour_holder
            }
            if($qode_like == "on" && function_exists('qode_like')) {
                if($display_like == '1'){
                    if ($type != "dividers"){
                        $html .= '<span class="dots"><i class="fa fa-square"></i></span>';
                    }
                    $html .= '<span class="blog_like">'.qode_like_latest_posts().'</span>';
                }
            }
            $padding_latest_post = "";
            if($text_from_edge == "yes" && $type == "boxes"){
                $padding_latest_post = " style='padding-left:0;padding-right:0;'";
            }
            $html .= '<div class="latest_post"'. $padding_latest_post .'>';
            if($type == "image_in_box") {
                $html .= '<div class="latest_post_image clearfix">';
                $html .= '<a itemprop="url" href="'.get_permalink().'">';
                $featured_image_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                $html .= '<img itemprop="image" src="'. $featured_image_array[0] .'" alt="" />';
                $html .= '</a>';
                $html .= '</div>';
            }
            $html .= '<div class="latest_post_text">';
            $html .= '<div class="latest_post_inner">';
            if ($type == "dividers") {
                $html .= '<div itemprop="dateCreated" class="latest_post_date entry_date updated">';
                $html .= '<div class="latest_post_day">'.get_the_time('d').'</div>';
                $html .= '<div class="latest_post_month">'.get_the_time('M').'</div>';
                $html .= '<meta itemprop="interactionCount" content="UserComments: <?php echo get_comments_number(qode_get_page_id()); ?>"/></div>';
            }
            $html .= '<div class="latest_post_text_inner">';
            if($type != "minimal") {
                $html .= '<'.$title_tag.' itemprop="name" class="latest_post_title entry_title"><a itemprop="url" href="' . get_permalink() . '">' . get_the_title() . '</a></'.$title_tag.'>';
            }
            if($type != "minimal") {
                if($text_length != '0') {
                    $excerpt = ($text_length > 0) ? mb_substr(get_the_excerpt(), 0, intval($text_length)) : get_the_excerpt();
                    $html .= '<p itemprop="description" class="excerpt">'.$excerpt.'...</p>';
                }

            }

            if($display_category == '1'){
                if ($type == "dividers"){
                    foreach ($cat as $categ) {
                        $html .='<a itemprop="url" href="' . get_category_link($categ->term_id) . '">' . $categ->cat_name . '</a>';
                    }
                }
                else{
                    $html .= '<span class="dots"><i class="fa fa-square"></i></span>';
                    foreach ($cat as $categ) {
                        $html .=' <a itemprop="url" href="' . get_category_link($categ->term_id) . '">' . $categ->cat_name . ' </a> ';
                    }
                }
            }
            //generate comments part of description
            if ($blog_hide_comments != "yes" && $display_comments == "1") {
                $comments_count = get_comments_number();

                switch ($comments_count) {
                    case 0:
                        $comments_count_text = __('No comment', 'qode');
                        break;
                    case 1:
                        $comments_count_text = $comments_count . ' ' . __('Comment', 'qode');
                        break;
                    default:
                        $comments_count_text = $comments_count . ' ' . __('Comments', 'qode');
                        break;
                }
                if ($type != "dividers"){
                    $html .= '<span class="dots"><i class="fa fa-square"></i></span>';
                }
                $html .= '<a itemprop="url" class="post_comments" href="' . get_comments_link() . '">';
                $html .= $comments_count_text;
                $html .= '</a>';//close post_comments
            }


            if($display_share == '1'){
                if ($type != "dividers"){
                    $html .= '<span class="dots"><i class="fa fa-square"></i></span>';
                }
                $html .= do_shortcode('[social_share]');
            }
            $html .= '</span>'; //close post_infos span
            if($type == "minimal") {
                $html .= '<'.$title_tag.' itemprop="name" class="latest_post_title entry_title"><a itemprop="url" href="' . get_permalink() . '">' . get_the_title() . '</a></'.$title_tag.'>';
            }
            $html .= '</div>'; //close latest_post_text_inner span
            $html .= '</div>'; //close latest_post_inner div
            $html .= '</div>'; //close latest_post_text div
            $html .= '</div>'; //close latest_post div

        endwhile;
        wp_reset_postdata();

        $html .= "</ul></div>";
        return $html;
    }
    add_shortcode('latest_post', 'latest_post');
}

add_filter( 'mce_buttons_3', 'add_more_buttons' );
if(!function_exists('add_more_buttons')){
    function add_more_buttons( $buttons ){
        $buttons[] = 'fontselect';
        $buttons[] = 'styleselect';

        return $buttons;
    }
}

function load_custom_fonts($init) {
    $font_formats = isset($init['font_formats']) ? $init['font_formats'] : 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
    $custom_fonts = ';';
    $custom_fonts .= "Steinem Bold Italic=steinembolditalic;";
    $custom_fonts .= "Steinem Roman=steinemroman;";
    $custom_fonts .= "Steinem Bold=steinembold;";
    $custom_fonts .= "Steinem Roman Italic=steinemromanitalic;";
    $custom_fonts .= "Steinem Unicode Regular=steinem_unicoderegular;";

    $custom_fonts .= "San Francisco Display Black=san_francisco_displayblack;";
    $custom_fonts .= "San Francisco Display Bold=san_francisco_displaybold;";
    $custom_fonts .= "San Francisco Display Heavy=san_francisco_displayheavy;";
    $custom_fonts .= "San Francisco Display Light=san_francisco_displaylight;";
    $custom_fonts .= "San Francisco Display Medium=san_francisco_displaymedium;";
    $custom_fonts .= "San Francisco Display Regular=san_francisco_displayregular;";
    $custom_fonts .= "San Francisco Display Semibold=san_francisco_displaysemibold;";
    $custom_fonts .= "San Francisco Display Thin=san_francisco_displaythin;";
    $custom_fonts .= "San Francisco Display Ultralight=san_francisco_displayultraLt;";

    $custom_fonts .= "San Francisco Text Bold=san_francisco_textbold;";
    $custom_fonts .= "San Francisco Text Bold Italic=san_francisco_textbold_italic;";
    $custom_fonts .= "San Francisco Text Heavy=san_francisco_textheavy;";
    $custom_fonts .= "San Francisco Text Heavy Italic=san_francisco_textHvIt;";
    $custom_fonts .= "San Francisco Text Light=san_francisco_textlight;";
    $custom_fonts .= "San Francisco Text Light Italic=san_francisco_textLtIt;";
    $custom_fonts .= "San Francisco Text Medium=san_francisco_textmedium;";
    $custom_fonts .= "San Francisco Text Medium Italic=san_francisco_textMdIt;";
    $custom_fonts .= "San Francisco Text Regular=san_francisco_textregular;";
    $custom_fonts .= "San Francisco Text Italic=san_francisco_textitalic;";
    $custom_fonts .= "San Francisco Text SemiBold=san_francisco_textsemibold;";
    $custom_fonts .= "San Francisco Text SemiBold Italic=san_francisco_textSBdIt;";
    $init['font_formats'] = $font_formats . $custom_fonts;

    return $init;
}
add_filter('tiny_mce_before_init', 'load_custom_fonts');


function load_custom_fonts_frontend() {
    wp_enqueue_style( 'sanfrancisco1', get_stylesheet_directory_uri() .'/fonts/sanfrancisco1/stylesheet.css' );
    wp_enqueue_style( 'sanfrancisco2', get_stylesheet_directory_uri() .'/fonts/sanfrancisco2/stylesheet.css' );
    wp_enqueue_style( 'steinem', get_stylesheet_directory_uri() .'/fonts/steinem/steinem.css' );
}
add_action('wp_head', 'load_custom_fonts_frontend');
add_action('admin_head', 'load_custom_fonts_frontend');
