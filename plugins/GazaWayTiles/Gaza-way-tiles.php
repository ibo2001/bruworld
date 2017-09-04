<?php

/*
Plugin Name: Gaza Way Tiles
Plugin URI: http://m360.no
Description: Visual composer addon for Image tiles with linkes.
Version: 1.01
Author: ibrahim-2015
Author URI: http://m360.no
License: A "Slug" license name e.g. GPL2
*/

// add in constant name path
defined( 'GAZA_WAY_ROOT' )   or define( 'GAZA_WAY_ROOT',   dirname(__FILE__) );
defined( 'GAZA_WAY_URI' )     or define( 'GAZA_WAY_URI',     get_template_directory_uri() );
defined( 'GAZA_WAY_PATH' )    or define( 'GAZA_WAY_PATH',    get_template_directory() );
defined( 'GAZA_WAY_IMG' )	   or define( 'GAZA_WAY_IMG',	   GAZA_WAY_URI . '/assets/images' );
defined( 'GAZA_WAY_FUNC_PATH' ) or define( 'GAZA_WAY_FUNC_PATH', GAZA_WAY_PATH . '/inc' );
define("GAZA_WAY_TILES_PLUGIN", "GazaWayTiles/Gaza-way-tiles.php");


$dir = plugin_dir_path(__FILE__);
$plugin_url = plugin_dir_url(__FILE__);

include_once ($dir.'inc/functions.php');

if( !defined( 'ABSPATH' ) ) {
    exit;
}



if(!class_exists('GAZA_WAY_MainClass')){
    class GAZA_WAY_MainClass{
        private $assets_js;

        public function __construct() {
            $this->assets_js = plugins_url('/composer/js', __FILE__);

            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if (!is_plugin_active( 'wp-tiles/wp-tiles.php' ) ) return;

            if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {

                require_once( WP_PLUGIN_DIR . '/js_composer/js_composer.php');

                add_action( 'admin_init', array($this, 'wpc_plugin_init') );
                add_action( 'wp', array($this, 'wpc_plugin_init') );
                add_action( 'get_footer', array( $this, 'register_styles' ) );
                add_action( 'get_footer', array( $this, 'register_scripts' ) );

            }

        }

        public function register_scripts(){
            wp_enqueue_script( 'wp-tiles' );
            wp_enqueue_script( 'jquery-autosize');
            wp_enqueue_script( 'wp-tiles-grid-templates');
            wp_enqueue_script( 'gazaway_tiles', plugins_url( '/assets/js/gazaway_tiles.js', __FILE__ ), array( 'jquery' ) );

        }
        public function register_styles(){
            wp_enqueue_style( 'gazaway_tiles_css', plugins_url( '/assets/css/style.css', __FILE__ ) );
            wp_enqueue_style( 'wp-tiles' );

        }
        public function wpc_plugin_init(){

            //require_once( GAZA_WAY_ROOT .'/composer/init.php');

            foreach( glob( GAZA_WAY_ROOT . '/'. 'composer/shortcodes/gazaway_*.php' ) as $shortcode ) {
                require_once(GAZA_WAY_ROOT .'/'. 'composer/shortcodes/'. basename( $shortcode ) );
            }


        }

    }
}

$mainClass = new GAZA_WAY_MainClass();