<?php

/**
 * 管理画面
 */

if (is_admin()) {

	// 「投稿」の名称を変更
	add_action('admin_menu', 'change_post_menu_label');
	function change_post_menu_label() {
		global $menu;
		global $submenu;
		$post_name = '新着情報';
		$menu[5][0] = $post_name;
		$submenu['edit.php'][5][0] = $post_name . '一覧';
		$submenu['edit.php'][10][0] = '新規追加';
		$submenu['edit.php'][15][0] = 'カテゴリー';
		$submenu['edit.php'][16][0] = 'タグ';
	}

	add_action('init', 'change_post_label');
	function change_post_label() {
		global $wp_post_types;
		$post_name = '新着情報';
		$labels = $wp_post_types['post']->labels;
		$labels->name = $post_name;
		$labels->singular_name = $post_name;
		$labels->name_admin_bar = $post_name;
		$labels->add_new = '新規' . $post_name;
		$labels->add_new_item = '新規' . $post_name . 'を追加';
		$labels->edit_item = '新規' . $post_name . 'を編集';
		$labels->new_item = '新規' . $post_name;
		$labels->view_item = $post_name . 'を表示';
		$labels->view_items = $post_name . 'を表示';
		$labels->search_items = $post_name . 'を検索';
		$labels->not_found = $post_name . 'が見つかりませんでした';
		$labels->not_found_in_trash = 'ゴミ箱に' . $post_name . 'が見つかりませんでした';
	}
}

// 不要メニューを非表示
function remove_menus() {
	remove_menu_page('edit-comments.php'); // コメントメニュー
	// remove_submenu_page('themes.php', 'theme-editor.php'); // テーマエディター
	remove_submenu_page('plugins.php', 'plugin-editor.php'); // プラグインエディター
	remove_submenu_page('themes.php', 'customize.php?return=' . urlencode($_SERVER["REQUEST_URI"])); // 外観 / カスタマイズ
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag'); // 投稿 / タグ.

	// 編集者のみ表示しないメニュー
	if (current_user_can('editor') && !current_user_can('administrator')) {
		remove_menu_page('wpcf7'); // Contact Form 7 のメニューを非表示にする
		remove_menu_page('tools.php'); // ツールメニュー
	}
}
add_action('admin_menu', 'remove_menus', 110);
