<?php

/**
 * Template Name: 固定ページ
 * Description:
 */
?>

<?php get_header(); ?>

<?php
if (have_posts()) :
  while (have_posts()) : the_post();
?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php the_content(); ?>
    </div>
<?php
  endwhile;
endif;
?>

<?php get_footer(); ?>
