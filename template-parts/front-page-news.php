<?php

/**
 * Template Name: トップページの投稿セクション
 * Description:
 */
?>
<?php
$args = array(
  'post_type' => 'post',
  'posts_per_page' => 3,
  'no_found_rows' => true,
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) :
?>
  <div>
    <?php
    while ($the_query->have_posts()) :
      $the_query->the_post();
    ?>
      <?php get_template_part('template-parts/archive1-item'); ?>
    <?php endwhile; ?>
  </div>
<?php
endif;
wp_reset_postdata();
?>
