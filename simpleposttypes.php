<?php
   /*
   Plugin Name: Simple Starter Post Types
   Plugin URI: http://craigwfox.com
   Description: Just a simple custom post type plugin.
   Version: 1.0
   Author: Craig Fox
   Author URI: http://craigwfox.com
   License: GPL2
   */


// Banners Post Type
// ----------------------------------------
   function sspt_banners() {
    $labels = array(
      'name'               => _x( 'Banners', 'post type general name' ),
      'singular_name'      => _x( 'Banner', 'post type singular name' ),
      'add_new'            => _x( 'Add New', 'book' ),
      'add_new_item'       => __( 'Add New Banner' ),
      'edit_item'          => __( 'Edit Banner' ),
      'new_item'           => __( 'New Banner' ),
      'all_items'          => __( 'All Banners' ),
      'view_item'          => __( 'View Banner' ),
      'search_items'       => __( 'Search Banners' ),
      'not_found'          => __( 'No banners found' ),
      'not_found_in_trash' => __( 'No banners found in the Trash' ), 
      'parent_item_colon'  => '',
      'menu_name'          => 'Banners'
    );
    $args = array(
      'labels'        => $labels,
      'description'   => 'Controls the banners on the site.',
      'public'        => true,
      'menu_position' => 5,
      'supports'      => array( 'title', 'thumbnail'),
      'has_archive'   => true,
      'rewrite'       => array(
        'slug' => 'banners', 
      ),
    );
    register_post_type( 'sspt_banners', $args ); 
  }
  add_action( 'init', 'sspt_banners' );

  // ----- Banners Taxonomy
  function sspt_tax_banners() {
    $labels = array(
      'name'              => _x( 'Banner Categories', 'taxonomy general name' ),
      'singular_name'     => _x( 'Banner Category', 'taxonomy singular name' ),
      'search_items'      => __( 'Search Banner Categories' ),
      'all_items'         => __( 'All Banner Categories' ),
      'parent_item'       => __( 'Parent Banner Category' ),
      'parent_item_colon' => __( 'Parent Banner Category:' ),
      'edit_item'         => __( 'Edit Banner Category' ), 
      'update_item'       => __( 'Update Banner Category' ),
      'add_new_item'      => __( 'Add New Banner Category' ),
      'new_item_name'     => __( 'New Banner Category' ),
      'menu_name'         => __( 'Banner Categories' ),
    );
    $args = array(
      'labels' => $labels,
      'hierarchical' => true,
    );
    register_taxonomy( 'sspt_tax_banners', 'sspt_banners', $args );
  }
  add_action( 'init', 'sspt_tax_banners', 0 );

  // ----- Banners Filtering
    add_action( 'restrict_manage_posts', 'sspt_banner_filter' );
    function sspt_banner_filter() {
      $screen = get_current_screen();
      global $wp_query;
      if ( $screen->post_type == 'sspt_banners' ) {
        wp_dropdown_categories( array(
          'show_option_all' => 'Show All Categories',
          'taxonomy' => 'sspt_tax_banners',
          'name' => 'sspt_tax_banners',
          'orderby' => 'name',
          'selected' => ( isset( $wp_query->query['sspt_tax_banners'] ) ? $wp_query->query['sspt_tax_banners'] : '' ),
          'hierarchical' => false,
          'depth' => 3,
          'show_count' => false,
          'hide_empty' => true,
        ) );
      }
    }
    add_filter( 'parse_query','sspt_banner_filtering' );
    function sspt_banner_filtering( $query ) {
      $qv = &$query->query_vars;
      if ( ( $qv['sspt_tax_banners'] ) && is_numeric( $qv['sspt_tax_banners'] ) ) {
        $term = get_term_by( 'id', $qv['sspt_tax_banners'], 'sspt_tax_banners' );
        $qv['sspt_tax_banners'] = $term->slug;
      }
    }



// Callouts Post Type
// ----------------------------------------
  function sspt_callouts() {
    $labels = array(
      'name'               => _x( 'Callouts', 'post type general name' ),
      'singular_name'      => _x( 'Callout', 'post type singular name' ),
      'add_new'            => _x( 'Add New', 'book' ),
      'add_new_item'       => __( 'Add New Callout' ),
      'edit_item'          => __( 'Edit Callout' ),
      'new_item'           => __( 'New Callout' ),
      'all_items'          => __( 'All Callouts' ),
      'view_item'          => __( 'View Callout' ),
      'search_items'       => __( 'Search Callouts' ),
      'not_found'          => __( 'No callouts found' ),
      'not_found_in_trash' => __( 'No callouts found in the Trash' ), 
      'parent_item_colon'  => '',
      'menu_name'          => 'Callouts'
    );
    $args = array(
      'labels'        => $labels,
      'description'   => 'Controls the Callouts on the site.',
      'public'        => true,
      'menu_position' => 6,
      'supports'      => array( 'title', 'thumbnail', 'editor', 'excerpt'),
      'has_archive'   => true,
      'rewrite'       => array(
        'slug' => 'callouts', 
      ),
    );
    register_post_type( 'sspt_callouts', $args );  
  }
  add_action( 'init', 'sspt_callouts' );

  // ----- Callouts Taxonomy
    function sspt_tax_callout() {
      $labels = array(
        'name'              => _x( 'Callout Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Callout Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Callout Categories' ),
        'all_items'         => __( 'All Callout Categories' ),
        'parent_item'       => __( 'Parent Callout Category' ),
        'parent_item_colon' => __( 'Parent Callout Category:' ),
        'edit_item'         => __( 'Edit Callout Category' ), 
        'update_item'       => __( 'Update Callout Category' ),
        'add_new_item'      => __( 'Add New Callout Category' ),
        'new_item_name'     => __( 'New Callout Category' ),
        'menu_name'         => __( 'Callout Categories' ),
      );
      $args = array(
        'labels' => $labels,
        'hierarchical' => true,
      );
      register_taxonomy( 'sspt_tax_callout', 'sspt_callouts', $args );
    }
    add_action( 'init', 'sspt_tax_callout', 0 );
  
  // ----- Callouts Filtering
    add_action( 'restrict_manage_posts', 'sspt_callout_filter' );
    function sspt_callout_filter() {
      $screen = get_current_screen();
      global $wp_query;
      if ( $screen->post_type == 'sspt_callouts' ) {
        wp_dropdown_categories( array(
          'show_option_all' => 'Show All Categories',
          'taxonomy' => 'sspt_tax_callout',
          'name' => 'sspt_tax_callout',
          'orderby' => 'name',
          'selected' => ( isset( $wp_query->query['sspt_tax_callout'] ) ? $wp_query->query['sspt_tax_callout'] : '' ),
          'hierarchical' => false,
          'depth' => 3,
          'show_count' => false,
          'hide_empty' => true,
        ) );
      }
    }
    add_filter( 'parse_query','sspt_callout_filtering' );
    function sspt_callout_filtering( $query ) {
      $qv = &$query->query_vars;
      if ( ( $qv['sspt_tax_callout'] ) && is_numeric( $qv['sspt_tax_callout'] ) ) {
        $term = get_term_by( 'id', $qv['sspt_tax_callout'], 'sspt_tax_callout' );
        $qv['sspt_tax_callout'] = $term->slug;
      }
    }
?>