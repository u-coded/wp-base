<?php

/**
 * Template Name: ページャー(詳細ページ用)
 * Description:
 */
?>

<nav class="c-pager2" aria-label="Post Navigation">
  <div class="c-pager2__prev">
    <?php
    $prev_post = get_previous_post(false, ''); // 同じカテゴリ内の記事を取得する場合、第一引数をtrueにする
    if (!empty($prev_post)) :
      $prev_url = get_permalink($prev_post->ID);
    ?>
      <a href="<?php echo esc_url($prev_url); ?>" class="u-alpha" aria-label="Previous Post: <?php echo esc_attr(get_the_title($prev_post)); ?>">
        <span>前の記事</span>
      </a>
    <?php endif; ?>
  </div>
  <div class="c-pager2__back">
    <a href="<?php echo esc_url(get_post_type_archive_link(get_post_type())); ?>" class="u-alpha">一覧へ戻る</a>
  </div>
  <div class="c-pager2__next">
    <?php
    $next_post = get_next_post(false, ''); // 同じカテゴリ内の記事を取得する場合、第一引数をtrueにする
    if (!empty($next_post)) :
      $next_url = get_permalink($next_post->ID);
    ?>
      <a href="<?php echo esc_url($next_url); ?>" class="u-alpha" aria-label="Next Post: <?php echo esc_attr(get_the_title($next_post)); ?>">
        <span>次の記事</span>
      </a>
    <?php endif; ?>
  </div>
</nav>
