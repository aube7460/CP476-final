<?php

$xml = simplexml_load_file("bookInfo.xml");

$writer = $_POST['Writer'];
$title = $_POST['BTitle'];

foreach ($xml->book as $book) {
    if ($book->title == $title || $book->author == $writer) {
        $response .= $book->author."<br>";
		$response .= $book->title."<br>";
		$response .= $book->title."<br>";
		$response .= $book->publisher."<br>";
		$response .= $book->publishdate."<br>";
		echo $response;
	}
}
?>