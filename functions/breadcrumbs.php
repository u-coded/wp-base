<?php

/**
 * パンクズリスト
 * 参考 https://wemo.tech/356
 *
 */
if (!function_exists('breadcrumbs')) {
  function breadcrumbs() {

    // トップページでは何も出力しない
    if (is_front_page()) return false;

    // 現在のページのWPオブジェクトを取得
    $wp_obj = get_queried_object();

    // JSON-LD用のデータを保持する変数
    $json_array = array();

    // 投稿ページのIDとURLを取得
    $home_id = get_option('page_for_posts');
    $home_title = wp_strip_all_tags(get_the_title($home_id), true);
    $home_url = get_page_link($home_id);

    // パンくずリストの開始: nav要素を追加し、aria-labelを指定
    echo '<nav id="breadcrumb" aria-label="Breadcrumb">';
    echo '<ul class="l-breadcrumb u-inner u-font-bold" role="list">'; // ulタグにrole="list"を追加

    // ホームリンクを表示
    echo '<li class="l-breadcrumb__item" role="listitem">';
    echo '<a href="' . esc_url(home_url('/')) . '" class="l-breadcrumb__txt u-alpha"><span class="l-breadcrumb__txt">ホーム</span></a>';
    echo '</li>';

    if (is_attachment()) {
      // 添付ファイルページの場合
      $post_title = apply_filters('the_title', $wp_obj->post_title);
      echo '<li class="l-breadcrumb__item" role="listitem"><span class="l-breadcrumb__txt u-alpha" aria-current="page">' . esc_html($post_title) . '</span></li>';
    } elseif (is_single()) {
      // 通常の投稿ページの場合
      $post_id    = $wp_obj->ID;
      $post_type  = $wp_obj->post_type;
      $post_title = apply_filters('the_title', $wp_obj->post_title);

      if ($post_type !== 'post') {
        // カスタム投稿タイプの場合
        $the_tax = "case"; // 投稿タイプに応じてタクソノミーを指定
        $tax_array = get_object_taxonomies($post_type, 'names');
        foreach ($tax_array as $tax_name) {
          if ($tax_name !== 'post_format') {
            $the_tax = $tax_name;
            break;
          }
        }

        $post_type_link = esc_url(get_post_type_archive_link($post_type));
        $post_type_label = esc_html(get_post_type_object($post_type)->label);

        echo '<li class="l-breadcrumb__item" role="listitem">';
        echo '<a href="' . $post_type_link . '"  class="l-breadcrumb__txt u-alpha"><span>' . $post_type_label . '</span></a>';
        echo '</li>';

        $json_array[] = array(
          'id' => $post_type_link,
          'name' => $post_type_label
        );
      } else {
        // 通常の投稿の場合、投稿ページのリンクを追加
        // echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . $home_url . '" class="l-breadcrumb__txt u-alpha">' . esc_html(strip_tags($home_title)) . '</a></li>';
        echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . get_permalink(38) . '" class="l-breadcrumb__txt u-alpha">' . 'お知らせ・ブログ' . '</a></li>';
        $the_tax = 'category';
      }
      echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page"  class="l-breadcrumb__txt">' . esc_html(strip_tags($post_title)) . '</span></li>';
    } elseif (is_page() || is_home()) {
      // 固定ページまたはホームの場合
      $page_id    = $wp_obj->ID;
      $page_title = apply_filters('the_title', $wp_obj->post_title);

      if ($wp_obj->post_parent !== 0) {
        $parent_array = array_reverse(get_post_ancestors($page_id));
        foreach ($parent_array as $parent_id) {
          if ($parent_id !== 10) { // ハゲーラキッズのトップを除外
            $parent_link = esc_url(get_permalink($parent_id));
            $parent_name = esc_html(get_the_title($parent_id));
            echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . $parent_link . '" class="l-breadcrumb__txt u-alpha"><span>' . $parent_name . '</span></a></li>';

            $json_array[] = array(
              'id' => $parent_link,
              'name' => $parent_name
            );
          }
        }
      }

      echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">' . esc_html(strip_tags($page_title)) . '</span></li>';
    } elseif (is_post_type_archive()) {
      // 投稿タイプアーカイブページの場合
      echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">' . esc_html($wp_obj->label) . '</span></li>';
    } elseif (is_date()) {
      // 日付アーカイブの場合
      $year  = get_query_var('year');
      $month = get_query_var('monthnum');
      $day   = get_query_var('day');

      if ($day !== 0) {
        echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . esc_url(get_year_link($year)) . '" class="l-breadcrumb__txt u-alpha"><span>' . esc_html($year) . '年</span></a></li>';
        echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . esc_url(get_month_link($year, $month)) . '" class="l-breadcrumb__txt u-alpha"><span>' . esc_html($month) . '月</span></a></li>';
        echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">' . esc_html($day) . '日</span></li>';
      } elseif ($month !== 0) {
        echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . $home_url . '" class="l-breadcrumb__txt u-alpha">' . esc_html(strip_tags($home_title)) . '</a></li>';
        echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">' . esc_html($year) . '年' . esc_html($month) . '月</span></li>';
      } else {
        echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">' . esc_html($year) . '年</span></li>';
      }
    } elseif (is_author()) {
      // 投稿者アーカイブの場合
      echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">' . esc_html($wp_obj->display_name) . ' の執筆記事</span></li>';
    } elseif (is_archive()) {
      // タームアーカイブの場合
      $term_id   = $wp_obj->term_id;
      $term_name = $wp_obj->name;
      $tax_name  = $wp_obj->taxonomy;

      $post_type = get_taxonomy($tax_name)->object_type[0];
      $post_type_link = esc_url(get_post_type_archive_link($post_type));
      $post_type_label = esc_html(get_post_type_object($post_type)->label);

      if (is_tax()) {
        echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . $post_type_link . '" class="l-breadcrumb__txt u-alpha">' . $post_type_label . '</a></li>';
      } else {
        echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . $home_url . '" class="l-breadcrumb__txt u-alpha">' . esc_html(strip_tags($home_title)) . '</a></li>';
      }

      if ($wp_obj->parent !== 0) {
        $parent_array = array_reverse(get_ancestors($term_id, $tax_name));
        foreach ($parent_array as $parent_id) {
          $parent_term = get_term($parent_id, $tax_name);
          $parent_link = esc_url(get_term_link($parent_id, $tax_name));
          $parent_name = esc_html($parent_term->name);
          echo '<li class="l-breadcrumb__item" role="listitem"><a href="' . $parent_link . '" class="l-breadcrumb__txt u-alpha"><span>' . $parent_name . '</span></a></li>';

          $json_array[] = array(
            'id' => $parent_link,
            'name' => $parent_name
          );
        }
      }

      echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">' . esc_html($term_name) . '</span></li>';
    } elseif (is_search()) {
      // 検索結果ページの場合
      echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">「' . esc_html(get_search_query()) . '」で検索した結果</span></li>';
    } elseif (is_404()) {
      // 404ページの場合
      echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">お探しの記事は見つかりませんでした。</span></li>';
    } else {
      // その他のページの場合
      echo '<li class="l-breadcrumb__item" role="listitem"><span aria-current="page" class="l-breadcrumb__txt">' . esc_html(get_the_title()) . '</span></li>';
    }

    echo '</ul>'; // ulタグの閉じ
    // JSON-LDの出力
    if (!empty($json_array)) :
      $pos = 1;
      $json = '';
      foreach ($json_array as $data) :
        $json .= '{
                  "@type": "ListItem",
                  "position": ' . $pos++ . ',
                  "item": {
                      "@id": "' . $data['id'] . '",
                      "name": "' . $data['name'] . '"
                  }
              },';
      endforeach;

      echo '<script type="application/ld+json">{
              "@context": "http://schema.org",
              "@type": "BreadcrumbList",
              "itemListElement": [' . rtrim($json, ',') . ']
          }</script>';
    endif;

    echo '</nav>';  // navタグの閉じ
  }
}
