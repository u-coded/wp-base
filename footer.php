<?php
global $has_sidebar;
?>

<?php if ($has_sidebar): ?>
  <?php get_sidebar(); ?>
<?php endif; ?>

</div><!-- /.l-container -->

<footer class="l-footer">
  <p>フッター</p>
</footer>

<?php
wp_enqueue_script('main_js', get_template_directory_uri() . '/assets/js/script.js', array(), filemtime(get_stylesheet_directory() . '/assets/js/script.js'));
wp_footer();
?>

</body>

</html>
