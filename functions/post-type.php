<?php

/**
 * 投稿タイプとタクソノミーを追加
 */
function create_post_type() {

  register_post_type(
    'case', // スラッグ
    array(
      'label' => '実績', // 表示名称
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'menu_position' => 5,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'revisions',
      ),
    )
  );

  register_taxonomy(
    'case_cat', // カテゴリースラッグ
    'case', // カテゴリーを追加する投稿タイプ
    array(
      'label' => '実績カテゴリー', // 表示名称
      'hierarchical' => true, // 階層構造を持つか(trueでカテゴリー、falseでタグ)
      'public' => true,
      'show_in_rest' => true,
    )
  );
}
add_action('init', 'create_post_type');


/**
 * 管理画面の一覧の項目をカスタマイズ
 */

// 見出し行の設定
function add_report_columns($columns) {
  $columns['author'] = '投稿者';
  $columns['report_cat'] = 'カテゴリー';
  return $columns;
}
add_filter('manage_edit-report_columns', 'add_report_columns');

// タクソノミーを表示
function add_report_columns_content($column_name, $post_id) {
  $terms = get_the_terms($post_id, $column_name);
  if ($column_name === 'report_cat') {
    if ($terms && !is_wp_error($terms)) {
      $report_cat = array();
      foreach ($terms as $term) {
        $report_cat[] = $term->name;
      }
      echo join(", ", $report_cat);
    }
  }
}
add_action('manage_report_posts_custom_column', 'add_report_columns_content', 10, 2);
