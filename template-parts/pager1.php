<?php

/**
 * Template Name: ページャー(一覧用)
 * Description:
 */
?>

<?php
if (function_exists('pagination')) :
	pagination($wp_query->max_num_pages, get_query_var('paged'));
endif;
?>
