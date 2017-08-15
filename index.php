<?php

require_once 'config.inc.php';

// Configuration
$picture = (isset($_GET['p'])) ? $_GET['p'] : null;

// If image exists
if(!empty($picture) && file_exists(PATH.$picture)) {

	// If it's a PNG
	if(in_array(pathinfo(PATH.$picture, PATHINFO_EXTENSION), explode(',', ACCEPT_FILE_TYPES))) {

		// For bots
		if(stripos($_SERVER['HTTP_USER_AGENT'], 'bot') AND stripos($_SERVER['HTTP_USER_AGENT'], 'TelegramBot') === false) {

			$size = getimagesize(PATH.$picture);
			// Meta for Robots
			ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <meta name="twitter:card" content="summary_large_image" />
                <meta name="twitter:description" content="Click to zoom" />
                <meta name="twitter:image" content="<?php echo PUBLIC_DOMAIN.PATH.$picture; ?>" />
                <meta name="twitter:title" content="Screenshot <?php echo $picture; ?>" />
                <meta name="twitter:url" content="<?php echo PUBLIC_DOMAIN.$picture; ?>" />

                <meta name="twitter:image:width" content="<?php echo $size[0]; ?>" />
                <meta name="twitter:image:height" content="<?php echo $size[1]; ?>" />

                <meta property="og:image" content="<?php echo PUBLIC_DOMAIN.PATH.$picture; ?>" />
                <meta name="og:title" content="Screenshot <?php echo $picture; ?>" />
                <meta name="og:description" content="Click to zoom" />

                <meta name="description" content="Click to zoom" />

                <title>>Screenshot <?php echo $picture; ?></title>
        </head>
	<body>
		<img src="<?php echo PUBLIC_DOMAIN.PATH.$picture; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>">
	</body>
</html>
			<?php
			ob_end_flush();

		} else {

			// Display image for lambda user
			$im = imagecreatefrompng(PATH.$picture);

			header('Content-Type: image/png');

			imagepng($im);
			imagedestroy($im);
		}

	}
} else {
	// not found
	header('HTTP/1.0 404 Not Found');
  echo "<h1>Error 404 Not Found</h1>";
  echo "This image not exist";
}
