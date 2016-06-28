<?php

// Configuration
$picture = (isset($_GET['p'])) ? $_GET['p'] : null;
$pseudo = 'Eywek';
$path = 'img/';
$domain = 'http://pic.eywek.fr/';

$extension = pathinfo($path.$picture, PATHINFO_EXTENSION);

// If image exists
if(!empty($picture) && file_exists($path.$picture)) {

	// If it's a PNG
	if($extension == "png") {

		// For Twitter Cards
		if(stripos($_SERVER['HTTP_USER_AGENT'], 'bot')) {

			$size = getimagesize($path.$picture);

			// Meta for Twitter
			echo '<!DOCTYPE html>';
			echo '<html lang="en">';
				echo '<head>';
					echo '<meta name="twitter:card" content="photo" />';
					echo '<meta name="twitter:site" content="Cliquez pour agrandir" />';
					echo '<meta property="og:image" content="'.$domain.$path.$picture.'" />';
					echo '<meta name="twitter:image" content="'.$domain.$path.$picture.'" />';
					echo '<meta name="twitter:title" content="Image de '.$pseudo.'" />';
					echo '<meta name="twitter:url" content="'.$domain.$picture.'" />';

					echo '<meta name="twitter:image:width" content="'.$size[0].'"></meta>';
					echo '<meta name="twitter:image:height" content="'.$size[1].'"></meta>';
				echo '</head>';
				echo '<body>';
					echo 'Hello world.';
				echo '</body>';
			echo '</html>';

		} else {

			// Display image for lambda user
			$im = imagecreatefrompng($path.$picture);

			header('Content-Type: image/png');

			imagepng($im);
			imagedestroy($im);

		}

	} else {
		// forbidden
		header('HTTP/1.0 403 Not Found');
    echo "<h1>Error 403 Forbidden</h1>";
    echo "You don't have permission to access on this page.";
    exit();
	}

} else {
	// not found
	header('HTTP/1.0 404 Not Found');
  echo "<h1>Error 404 Not Found</h1>";
  echo "The page that you have requested could not be found.";
  exit();
}


?>
