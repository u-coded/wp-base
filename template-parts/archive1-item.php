<?php

/**
 * Template Name: 投稿単体
 * Description:
 */
?>
<article id="post-<?php the_ID(); ?>">
  <a href="<?php the_permalink() ?>">
    <?php if (has_post_thumbnail()) : ?>
      <figure>
        <img src="<?php the_post_thumbnail_url('medium'); ?>">
      </figure>
    <?php else : ?>
      <figure>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/img_dummy1.png" alt="" loading="lazy" width="300" height="300">
      </figure>
    <?php endif; ?>
    <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
    <?php
    $post_type = get_post_type();
    $term_slug = $post_type . '_cat';
    if ($post_type === "post") {
      $term_slug = 'category';
    }
    $terms = get_the_terms(get_the_ID(), $term_slug);
    if ($terms && !is_wp_error($terms)) :
    ?>
      <p><?php echo $terms[0]->name; ?></p>
    <?php endif; ?>
    <h2><?php the_title(); ?></h2>
    <p><?php echo mb_substr(get_the_excerpt(), 0, 20); ?>… [続きを読む]</p>
  </a>
</article>
