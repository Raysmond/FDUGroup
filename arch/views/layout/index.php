<?php
    $baseurl = Rays::app()->getBaseUrl();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>/public/css/main.css" />

</head>

<body>
<div class="container" id="page">
    <div id="header">
        <div id="logo">
            <h1><a href="<?php echo $baseurl; ?>"><?php echo HtmlHelper::encode(Rays::app()->name); ?></a></h1>
        </div>
    </div>
    <div id="main-menu">

    </div>

    <div id="content">
        <?php echo $content; ?>
    </div>

    <div id="footer">
    All Rights Reserved.
    </div>
</div>

</body>

</html>