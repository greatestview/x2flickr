<?php

class ImageToAverageColorConverter {

	function __construct() {
		$flickr = new Zend_Service_Flickr('928313896fa75bede0fd995b6624432e');
	}
	
	function tagSearch($tag, $per_page, $page, $min_upload_date) {

	}
}

new ImageDownloader();
