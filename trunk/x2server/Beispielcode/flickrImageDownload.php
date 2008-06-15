<?php
require_once 'Zend/Service/Flickr.php';

$flickr = new Zend_Service_Flickr('928313896fa75bede0fd995b6624432e');
$results = $flickr->tagSearch("Bielefeld", array(per_page=>20));

foreach ($results as $result) {
	
	$image = $flickr->getImageDetails($result->id);
	$img = $result->Square;

	echo "<div style='font-size: 10pt; font-family: arial; border-bottom: 1px solid #ddd; padding: 10px 0px 10px 0px;'>";
	echo "<img style='float:left;' width='30' height='30' src=\"$img->uri\" />";
    echo "<b>" . $result->title . '</b><small> (ID: ' . $result->id .')</small><br />';
    echo "von " . $result->ownername;
    echo "</div>";
}

?>