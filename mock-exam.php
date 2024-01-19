<?php

/**
 * @package Mock Exam
 * @version 1.0
 * 
 * Plugin Name: Mock Exam
 * Plugin URI: https://internest-agency.github.io/mock_test/
 * Description: Mock Exam Plugin to publish hall ticket and publish results.
 * Version: 1.0.0
 * Requires PHP: 7.4.0
 * Author: Internest Team
 * 
 */


wp_enqueue_script( 'exam-pdf-script', 'https://unpkg.com/pdf-lib', array(), false, false );
wp_enqueue_script( 'exam-pdf-script', 'https://unpkg.com/downloadjs@1.4.7', array(), false, false );
wp_enqueue_script( 'hallticket-script', '/wp-content/plugins/mock-exam/public/js/download-hallticket.js', array(), false, false );
wp_enqueue_style( 'exam-style', '/wp-content/plugins/mock-exam/public/css/style.css', array(), false, 'all');

add_filter( 'page_template', 'get_custom_post_type_template' );

function get_custom_post_type_template( $page_template ) {
   global $post;

   if ( is_page ( 'download-hallticket' ) ) {
         $page_template = dirname( __FILE__ ) . '/public/templates/page-download-hallticket.php';
   }
   return $page_template;
}

