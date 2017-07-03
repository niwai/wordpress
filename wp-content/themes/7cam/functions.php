<?php
/**
 * Javascriptの関数定義
 */



/**
 * 固定ページの更新、公開前の確認ダイアログ表示
 *
 */
function pre_post_dialog() {
echo <<< EOF
<script>
  jQuery("#publish").live("click", function(e){
    var val = jQuery("#publish").val();
    if (val == "公開" || val == "更新") {
      if (!confirm("ページを" + val + "してもよろしいですか？")) {
        return false;
      }
    }
  });
</script>
EOF;
}
add_action('admin_head-post.php','pre_post_dialog');
add_action('admin_head-post-new.php','pre_post_dialog');

// クイック編集 TODO 不要かも・・・
function pre_post_dialog2() {
echo <<< EOF
<script>
  jQuery(".save").live("click", function(e){
    var val2 = jQuery(".save").text();
    if (val2 == "更新") {
      if (!confirm("ページを" + val2 + "してもよろしいですか？")) {
        return false;
      }
    }
  });
</script>
EOF;
}

add_action('admin_head-edit.php','pre_post_dialog2');




?>
