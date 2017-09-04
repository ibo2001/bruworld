<?php
define("GAZA_WAY_TILES_TABLE", "ibrahim_gaza_way_tiles");

if ( ! function_exists( 'CreateDatabseTable' ) ) {
    function CreateDatabseTable($sql = false){
        if(!$sql)return false;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

}


if ( ! function_exists( 'plugin_get_version' ) ) {
    function plugin_get_version($plugin_file) {
        if ( ! function_exists( 'get_plugins' ) )
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        $plugin_folder = get_plugins();
        //echo '<h3>'.print_r($plugin_folder[$plugin_file],true).'</h3>';

        $name       = $plugin_folder[$plugin_file]['Name'];
        $author     = $plugin_folder[$plugin_file]['Author'];
        $version    = $plugin_folder[$plugin_file]['Version'];
        return $name.' v.'.$version.' by: '.$author;
    }
}


if ( ! function_exists( 'ibo_asset_url' ) ) {
    function ibo_asset_url( $file ) {
        global $plugin_url;
        return preg_replace( '/\s/', '%20', $plugin_url.'assets/'.$file);
    }
}

if ( ! function_exists( 'CreateGazaWayTilesTable' ) ) {
    function CreateGazaWayTilesTable(){
        global $wpdb;
        $table_name = (strlen($wpdb->base_prefix)>0)?$wpdb->base_prefix.GAZA_WAY_TILES_TABLE:$wpdb->prefix .GAZA_WAY_TILES_TABLE;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name(
          tile_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          tile_name varchar(200) NOT NULL,
          tile_shortcode varchar(255) NOT NULL,
          tile_thumbnail varchar(255) NOT NULL,
          tile_status varchar(20) DEFAULT 'active' NOT NULL,
          UNIQUE KEY id (tile_id)
        ) $charset_collate;";

        CreateDatabseTable($sql);

    }

}

if ( ! function_exists( 'GetAllGazaWayTiles' ) ) {
    function GetAllGazaWayTiles(){
        global $wpdb;
        $table_name = (strlen($wpdb->base_prefix)>0)?$wpdb->base_prefix.GAZA_WAY_TILES_TABLE:$wpdb->prefix . GAZA_WAY_TILES_TABLE;
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            CreateGazaWayTilesTable();
        }
        return $wpdb->get_results( "SELECT * FROM {$table_name}",OBJECT);

    }
}

if ( ! function_exists( 'GazaWay_GetTileById' ) ) {
    function GazaWay_GetTileById($tile_id = 0){
        global $wpdb;
        $table_name = (strlen($wpdb->base_prefix)>0)?$wpdb->base_prefix.GAZA_WAY_TILES_TABLE:$wpdb->prefix . GAZA_WAY_TILES_TABLE;
        return $wpdb->get_row( "SELECT * FROM {$table_name} where tile_id = {$tile_id} ",OBJECT);

    }
}

if ( ! function_exists( 'GazaWay_DeleteTile' ) ) {
    function GazaWay_DeleteTile($tile_id = 0){
        global $wpdb;
        $table_name = (strlen($wpdb->base_prefix)>0)?$wpdb->base_prefix.GAZA_WAY_TILES_TABLE:$wpdb->prefix . GAZA_WAY_TILES_TABLE;
        $tile = GazaWay_GetTileById($tile_id);

        if($tile){
            echo '<h3>tile = '.$tile->tile_id.'</h3>';
            $wpdb->delete(
                $table_name,
                array(
                    'tile_id' =>$tile->tile_id
                ));
        }

    }
}


