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
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php the_content(); ?>
    </article>
<?php
  endwhile;
endif;
?>

<?php get_footer(); ?>
