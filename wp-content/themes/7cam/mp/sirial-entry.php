<?php
/**
 * Template Name: マイページ（シリアル登録）
 */
get_header();
?>

<div id="container">

<?php
  /* 共通ヘッダー */
  echo apply_filters('the_content', get_page_by_path('cmn/hdr', OBJECT, 'page') -> post_content);
?>

<div id="content">

<div id="contentIn">
<?php
  /* コンテンツヘッダー */
  echo apply_filters('the_content', get_page_by_path('fair/'.CODE.'/mpsrlenthdr', OBJECT, 'page') -> post_content);
?>

<div id="main">
<?php
  /* サイドバー */
  echo apply_filters('the_content', get_page_by_path('fair/'.CODE.'/mpsidebar', OBJECT, 'page') -> post_content);
  /* メインコンテンツ */
  echo apply_filters('the_content', get_page_by_path('mp/apply', OBJECT, 'page') -> post_content);
?>
</div><!-- main END-->

</div><!-- contentIn END-->

</div><!-- content END-->
</div><!-- container END-->

<?php
  /* 共通フッター */
  echo apply_filters('the_content', get_page_by_path('cmn/ftr', OBJECT, 'page') -> post_content);
?>

<?php get_footer(); ?>
