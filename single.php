<?php

/**
 * Template Name: 投稿詳細
 * Description:
 */
?>

<?php get_header() ?>

<?php
if (have_posts()) :
  while (have_posts()) : the_post();
?>
    <div id="single">
      <article id="post-<?php the_ID(); ?>" <?php post_class('c-single1'); ?>>
        <header>
          <time datetime="<?php the_time("Y-m-d"); ?>"><?php the_time('Y.m.d'); ?></time>
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
          <h1><?php the_title(); ?></h1>
        </header>
        <div>
          <?php the_content(); ?>
        </div>
      </article>
      <?php get_template_part('template-parts/pager2'); ?>
    </div>
<?php
  endwhile;
endif;
?>

<?php get_footer() ?>
