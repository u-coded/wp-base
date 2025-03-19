<?php

/**
 * サムネイル設定
 */

// アイキャッチを有効化
add_theme_support('post-thumbnails');

// トリミングサイズ設定
// add_image_size('w1000h500', 1000, 500, true); // メインサムネ用


/**
 * 特定の属性内でショートコードを使用できるように
 */
function my_wp_kses_allowed_html($tags, $context) {
  $tags['source'] = array(
    'data-srcset' => true,
    'srcset' => true,
    'src' => true,
  );
  $tags['use'] = array(
    'href' => true,
  );
  return $tags;
}
add_filter('wp_kses_allowed_html', 'my_wp_kses_allowed_html', 10, 2);

/**
 * 固定ページのみp,brを自動挿入しない
 */
remove_filter('the_content', 'wpautop');
if (!function_exists('remove_wpautop')) {
  add_action('wp', 'remove_wpautop');
  function remove_wpautop() {
    if (!is_page()) add_filter('the_content', 'wpautop');
  }
}

/**
 * メインクエリの表示件数
 */
function custom_main_query($query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }
  if ($query->is_home()) { // 投稿
    return;
  }
  // if ($query->is_post_type_archive('カスタム投稿タイプ名')) { //カスタム投稿
  // 	$query->set('posts_per_page', 6);
  // }
  // if ($query->is_tax('タクソノミ名')) { //タクソノミ
  // 	$query->set('posts_per_page', 6);
  // }
}
add_action('pre_get_posts', 'custom_main_query');

/**
 * 空欄での検索を除外する
 */
function exclude_empty_search($search, \WP_Query $q) {
  if ($q->is_search() && $q->is_main_query() && !$q->is_admin()) {
    $s = $q->get('s');
    $s = trim($s);
    if (empty($s)) {
      $search .= " AND 0=1 ";
    }
  }
  return $search;
}
add_filter('posts_search', 'exclude_empty_search', 10, 2);

/**
 * 親ページのスラッグを取得する関数
 */
function is_parent_slug() {
  global $post;
  if (!is_404()) {
    if ($post->post_parent) {
      $post_data = get_post($post->post_parent);
      return $post_data->post_name;
    }
  }
}

/**
 * get_previous_post()、get_next_post()をカスタム投稿にも対応させる
 */
add_filter('get_previous_post_where', function ($where) {
  global $post;
  $post_type = get_post_type($post); // 現在の投稿タイプを取得
  if ($post_type) {
    $where = str_replace("'post'", "'" . $post_type . "'", $where);
  }
  return $where;
});

add_filter('get_next_post_where', function ($where) {
  global $post;
  $post_type = get_post_type($post); // 現在の投稿タイプを取得
  if ($post_type) {
    $where = str_replace("'post'", "'" . $post_type . "'", $where);
  }
  return $where;
});

/**
 * ショートコード設定
 */
function shortcode_template_parts($atts) {
  ob_start();
  include(TEMPLATEPATH . '/template-parts/' . $atts['name'] . '.php');
  return ob_get_clean();
}
add_shortcode('template-parts', 'shortcode_template_parts');

function shortcode_home_url($atts) {
  ob_start();
  echo esc_url(home_url($atts['name']));
  return ob_get_clean();
}
add_shortcode('home_url', 'shortcode_home_url');

function shortcode_theme_url() {
  ob_start();
  echo get_stylesheet_directory_uri();
  return ob_get_clean();
}
add_shortcode('theme_url', 'shortcode_theme_url');


/**
 * REST API関連
 */
// アイキャッチ画像のURLを追加
function add_featured_image_to_rest($data, $post, $context) {
  if (has_post_thumbnail($post->ID)) {
    $data->data['featured_image_url'] = get_the_post_thumbnail_url($post->ID, 'full');
  } else {
    $data->data['featured_image_url'] = null;
  }
  return $data;
}

// 投稿タイプ "post" にカスタムフィールドを追加
add_filter('rest_prepare_post', 'add_featured_image_to_rest', 10, 3);
