<?php

class hob_Admin {
  
  public function __construct(){
    add_action( 'admin_init',             array($this, 'admin_init') );
    add_action('admin_menu',              array($this, 'my_admin_menu') );
    add_action( 'admin_enqueue_scripts',  array($this, 'admin_enqueue_scripts') );
  }
    
  public function admin_init() {
    foreach ( get_post_types( array( 'public' => true ), 'names' ) as $post_type ) {
      add_action( 'manage_' . $post_type . '_posts_columns', array($this, 'hob_manage_posts_columns'), 11, 1 );
      add_filter( 'manage_' . $post_type .  '_posts_custom_column', array($this, 'hob_manage_posts_custom_column'), 11, 2 );
    }
  }

  public function my_admin_menu() {
    global $submenu;
    if ($frontid = get_option('page_on_front')){
      $frontlink = array('<span class="hb-icon icon-home"></span> Home Page', 'edit_posts',  sprintf('%s/post.php?post=%s&action=edit', get_admin_url(), $frontid) );
      array_push($submenu['edit.php?post_type=page'], $frontlink);
    }
    if ($homeid = get_option('page_for_posts')){
      $homelink = array('<span class="hb-icon icon-pin"></span> Blog Page', 'edit_posts',  sprintf('%s/post.php?post=%s&action=edit', get_admin_url(), $homeid) );
      array_push($submenu['edit.php?post_type=page'], $homelink);
    }
  }

  public function admin_enqueue_scripts(){
    wp_enqueue_style( 'hob_css', plugins_url('style.css', HOBADGES_FILE), array(), time() );
  }

  public function hob_manage_posts_custom_column( $column_name, $post_id ) {
    
    if ($column_name !== 'hob_badges') {
      return;
    }

    $front_page_id = get_option('page_on_front');
    $posts_page_id = get_option('page_for_posts');

    switch ($post_id){
      case $front_page_id:
        $class = 'front';
        break;
      case $posts_page_id:
        $class = 'posts';
        break;
      default:
        $class = false;
      break;
    }

    if ($class) {
      printf('<div class="badge %s"></div>', $class );
    }

  }

  public function hob_manage_posts_columns($columns) {
    return array_merge( $columns, array('hob_badges' => __('')) );
  }

}