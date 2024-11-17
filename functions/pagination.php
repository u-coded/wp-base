<?php

/**
 * ページネーション
 * 参考 https://wemo.tech/978
 *
 * ページネーション出力関数
 * $paged : 現在のページ
 * $pages : 全ページ数
 * $range : 左右に何ページ表示するか
 * $show_only : 1ページしかない時に表示するかどうか
 */
if (!function_exists('pagination')) {
	function pagination($pages, $paged, $range = 2, $show_only = false) {
		$pages = (int) $pages;
		$paged = $paged ?: 1;

		$text_first   = "<<";
		$text_before  = "<";
		$text_next    = ">";
		$text_last    = ">>";

		if ($show_only && $pages === 1) {
			echo '<nav class="c-pagination1" aria-label="Pagination"><span class="current" aria-current="page">1</span></nav>';
			return;
		}

		if ($pages === 1) return;

		if (1 !== $pages) {
			echo '<nav class="c-pagination1"  aria-label="Pagination">';
			echo '<ul class="c-pagination1__list u-font-bold" role="list">';

			// 最初のページリンク
			if ($paged > $range + 1) {
				echo '<li><a href="', get_pagenum_link(1), '" class="first" aria-label="First Page">', $text_first, '</a></li>';
			}

			// 前へリンク
			if ($paged > 1) {
				echo '<li><a href="', get_pagenum_link($paged - 1), '" class="prev" aria-label="Previous Page">', $text_before, '</a></li>';
			}

			// ページ番号の出力
			for ($i = 1; $i <= $pages; $i++) {
				if ($i === 1 || $i === $pages || ($i >= $paged - $range && $i <= $paged + $range)) {
					// 最初・最後のページ または 現在のページ範囲内
					if ($paged === $i) {
						echo '<li><span class="current" aria-current="page">', $i, '</span></li>';
					} else {
						echo '<li><a href="', get_pagenum_link($i), '" aria-label="Page ', $i, '">', $i, '</a></li>';
					}
				} elseif ($i === 2 && $paged - $range > 2) {
					// 2番目のページと現在のページの間に省略記号
					echo '<li><span class="between" aria-hidden="true">…</span></li>';
				} elseif ($i === $pages - 1 && $paged + $range < $pages - 1) {
					// 最後のページと現在のページの間に省略記号
					echo '<li><span class="between" aria-hidden="true">…</span></li>';
				}
			}

			// 次へリンク
			if ($paged < $pages) {
				echo '<li><a href="', get_pagenum_link($paged + 1), '" class="next" aria-label="Next Page">', $text_next, '</a></li>';
			}

			// 最後のページリンク
			if ($paged + $range < $pages) {
				echo '<li><a href="', get_pagenum_link($pages), '" class="last" aria-label="Last Page">', $text_last, '</a></li>';
			}

			echo '</ul>';
			echo '</nav>';
		}
	}
}
