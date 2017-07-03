<?php
/**
 * Template Name: キャンペーン
 */
get_header();

$status = '';
$now = date('Y-m-d G:i:s');
if ($now <= START) {    // キャンペーン開始前
  $status = 'teaser';
} elseif (END <= $now) {    // キャンペーン終了後
  $status = 'end';
}
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
  echo apply_filters('the_content', get_page_by_path('cam/'.CODE.'/'.$status.'hdr', OBJECT, 'page') -> post_content);
?>

<div id="main">
<?php
  if ($status == '') {
    /* サイドバー */
    echo apply_filters('the_content', get_page_by_path('cam/'.CODE.'/side', OBJECT, 'page') -> post_content);
  }
  /* メインコンテンツ */
  echo apply_filters('the_content', get_page_by_path('cam/'.CODE.'/'.$status, OBJECT, 'page') -> post_content);
?>
</div><!-- main END-->

</div><!-- contentIn END-->

<?php
  if ($status == '') {
    /* 共通ボトムリード */
    echo apply_filters('the_content', get_page_by_path('cmn/btmld', OBJECT, 'page') -> post_content);
    /* 共通ヘッジ */
    echo apply_filters('the_content', get_page_by_path('cmn/hdg', OBJECT, 'page') -> post_content);
  }
?>

</div><!-- content END-->
</div><!-- container END-->

<?php
  /* 共通フッター */
  echo apply_filters('the_content', get_page_by_path('cmn/ftr', OBJECT, 'page') -> post_content);
?>

<?php get_footer(); ?>
