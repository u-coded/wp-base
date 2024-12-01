<?php

/**
 * Template Name: 404ページ
 * Description:
 */
?>

<?php get_header(); ?>

<main>
  <hgroup>
    <h1>404 NOT FOUND</h1>
    <p>ページが見つかりません</p>
  </hgroup>
  <p>申し訳ございません。<br>お客様がお探しのページが見つかりませんでした。<br>削除されたか、入力したURLが間違っている可能性があります。</p>
  <div>
    <a href="<?php echo esc_url(home_url('/')); ?>">トップページに戻る</a>
  </div>
</main>

<?php get_footer(); ?>
