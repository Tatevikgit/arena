<?php

/**
 * The template for displaying all single posts.
 *
 * @package thim
 */
global $wpdb;
$a = $wpdb->get_results("select * from wp_postmeta where meta_key='captain' and post_id = 9165 ",ARRAY_N);
//print_r($a);
?>

<div class="page-content">



</div>