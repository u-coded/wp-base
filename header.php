<?php
global $has_sidebar;

/**
 * ページ別のタグやタイトルなど
 */
$page_id = ''; // ページ別にJS動かすときに
if (is_404()) {
  $page_title = 'ページが見つかりません';
} elseif (is_search()) {
  $page_title = '「' . esc_html(get_search_query()) . '」の検索結果';
} elseif (is_home()) { // 投稿ホームは固定ページのタイトルを取得(get_the_titleしても投稿の1件目のタイトルになってしまう)
  $home_id = get_option('page_for_posts'); // 表示設定の投稿ページに指定したページIDを取得
  $page_title = wp_strip_all_tags(get_the_title($home_id), true);
  $has_sidebar = true;
} elseif (is_singular('post')) { // 記事
  // $page_title = $post->post_title; // サブイメージに投稿タイトル表示する時
  $home_id = get_option('page_for_posts'); // サブイメージは投稿名
  $page_title = wp_strip_all_tags(get_the_title($home_id), true);
  $has_sidebar = true;
} elseif (is_category() || is_tag()) { // カテゴリ一覧、タグ一覧
  $page_title = single_cat_title('', false);
  $has_sidebar = true;
} elseif (is_year()) {
  $page_title = get_the_time('Y年');
  $has_sidebar = true;
} elseif (is_month()) {
  $page_title = get_the_time('Y年m月');
  $has_sidebar = true;
} elseif (is_post_type_archive()) { // カスタム投稿アーカイブ
  $page_title = esc_html(get_post_type_object($post_type)->label);
} elseif (is_tax()) { // カスタムタクソノミー
  $page_title = single_term_title('', false);
} elseif (!is_page() || is_single()) { // カスタム投稿記事
  $page_title = $post->post_title;
} elseif (is_front_page()) {
  $page_id = 'index';
} else { // その他、固定ページ
  $page_title = get_the_title();
  $page_id = $post->post_name;
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css?<?php echo filemtime(get_stylesheet_directory() . '/assets/css/style.css'); ?>">
</head>

<?php wp_head(); ?>

<body id="<?php echo $page_id; ?>" <?php body_class(); ?> ontouchstart="">

  <header class="l-header">
    <?php
    if (is_front_page()) {
      $head_tag = 'h1';
    } else {
      $head_tag = 'p';
    }
    ?>
    <<?php echo $head_tag; ?> class="l-header__logo">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="l-header__logo-link">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/logo_main1.png" alt="">
      </a>
    </<?php echo $head_tag; ?>>
    <nav class="l-nav">
      <ul class="l-nav__list" role="list">
        <li class="l-nav__item">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="l-nav__link">フロントページ</a>
        </li>
        <li class="l-nav__item">
          <a href="<?php echo esc_url(home_url('lorem-ipsum/')); ?>" class="l-nav__link">文章例ページ</a>
        </li>
        <li class="l-nav__item">
          <a href="<?php echo esc_url(home_url('blog/')); ?>" class="l-nav__link">ブログ</a>
        </li>
      </ul>
    </nav>
  </header>

  <div class="l-container<?php if ($has_sidebar = true) {
                            echo ' -has-sidebar';
                          }; ?>">

    <?php breadcrumbs(); ?>
