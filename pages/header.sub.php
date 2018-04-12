<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $html['title']; ?></title>
<?php
if (!empty($html['_css']))
    getStylesheet($html['_css']);

if (!empty($html['_jquery']))
    getjQuery($html['_jquery']);
else
    getjQuery(array());

if (!empty($html['_js']['header']))
    getJavascript($html['_js']['header']);

if ((!defined('_ADMIN_') || !_ADMIN_) && !$is_admin) {
?>
<!-- Global site tag (gtag.js) - Google Analytics -->
</script>
<?php
}
?>
</head>
<body>