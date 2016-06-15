<?php
function dva_zerif_lite_setup() {
	load_child_theme_textdomain( 'dva-zerif-lite', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'dva-zerif-lite' );
?>