<?php

/**
 * headタグ関係
 */

// titleタグの出力
add_theme_support('title-tag');

// titleタグのセパレーターを変更
function custom_document_title_separator($separator) {
  $separator = '｜';
  return $separator;
}
add_filter('document_title_separator', 'custom_document_title_separator');

// フロント、投稿トップにtitleタグのディスクリプションを表示しない
function custom_document_title_parts($title) {
  if (is_home() || is_front_page()) {
    unset($title['tagline']);
  }
  return $title;
}
add_filter('document_title_parts', 'custom_document_title_parts', 10, 1);

// サイトではjQueryを読み込ませない
// function remove_jquery() {
// 	if (!is_admin()) {
// 		wp_deregister_script('jquery');
// 	}
// }
// add_action('wp_enqueue_scripts', 'remove_jquery');

// ヘッダー内タグ出力しない
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// WordPressのバージョン削除
function remove_wp_var($src) {
  if (strpos($src, 'ver=' . get_bloginfo('version')))
    $src = remove_query_arg('ver', $src);
  return $src;
}
add_filter('style_loader_src', 'remove_wp_var', 9999);
add_filter('script_loader_src', 'remove_wp_var', 9999);

// DNSプリフェッチ削除
function remove_dns_prefetch($hints, $relation_type) {
  if ('dns-prefetch' === $relation_type) {
    return array_diff(wp_dependencies_unique_hosts(), $hints);
  }
  return $hints;
}
add_filter('wp_resource_hints', 'remove_dns_prefetch', 10, 2);
