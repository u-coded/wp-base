<?php

/**
 * Template Name:
 * Description: 投稿一覧
 */
?>

<?php get_header(); ?>

<?php
if (have_posts()) :
?>
  <div id="archive">
    <?php while (have_posts()) : the_post(); ?>

      <?php get_template_part('template-parts/archive1-item'); ?>

    <?php endwhile; ?>
  </div>

  <?php get_template_part('template-parts/pager1'); ?>

<?php endif; ?>
</div>

<?php get_footer(); ?>
