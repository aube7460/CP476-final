<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" href="./css/main.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="http://listjs.com/no-cdn/list.js"></script>
		<meta charset="UTF-8">
		<title>Main</title>
	</head>
	<body>
		<?php
		$con = mysql_connect("localhost", "leun4090", "bigtop6");
		if (!$con){
			die("Could not connect: ".mysql_error());
		}
		$db = mysql_select_db("leun4090", $con);

		$htmlmenu = 
			'<div id="booklist">
			<input class="search" />
			<ul class="list">';

		$query = mysql_query('SELECT * FROM books');
		while ($parse = mysql_fetch_array($query)){
			$id = $parse['id'];
			$bookname = $parse['title'];
			$author = $parse['author'];
			$genre = $parse['genre'];
			$PDFPath = $parse['pdfpath'];
			$htmlmenu .= 
<<<<<<< HEAD
				"<li id='.$id.'>
				<h3 class='booktitle'>" .$bookname. "</h3>
				<h4 class='bookauthor'>" .$author. "</h4>
				<h5 class='bookgenre'>" .$genre. "</h5>
				</li>
				<script>
				document.getElementById('.$id.').addEventListener('click', function() {
					getBookInfo('$PDFPath');
				}, false);
				</script>";
=======
				"
				<li id = '.$id.'>
				<h3 class='booktitle' id='BTitle'>" .$bookname. "</h3>
				<h4 class='bookauthor' id='Writer'>" .$author. "</h4>
				<h5 class='bookgenre' id='BGenre'>" .$genre. "</h5>
				</li>
				<script>
				document.getElementById("".$id."").addEventListener("click", function() {
					url = $parse['pdfpath'];
				}, false);
				";
>>>>>>> 82325b299dcf83a62d827721a10894155f52e142
		}
		$htmlmenu .= '</ul></div>';
		echo $htmlmenu;
		mysql_close($con);
		?>
	
		<script>
			var options = {
				valueNames: [ 'booktitle', 'bookauthor', 'bookgenre' ]
			};
			
			var bookList = new List('booklist', options);
		</script>
			
		<div style="margin-left:15%; padding:0px,10px;">
			<div id="bookPages">
				<canvas id="pageleft"></canvas>
				<canvas id="pageright"></canvas>
			</div>
			<div id="pagecount">
				<span id="page_num"></span> / <span id="page_count"></span>
			</div>
			<div id="results">results go here</div>
		</div>
		
		<div style="clear:both" id="BookInformation">This is where this is</div>
		
		<script src="./build/pdf.js"></script>

		<script id="script">

			var bookurl = 'books/A-Room-with-a-View.pdf';
			var rightPDF = null,
				pageNum = 1,
				pageRendering = false,
				pageNumPending = null,
				scale = 0.8,
				canvasone = document.getElementById('pageright'),
				ctxone = canvasone.getContext('2d'),
				canvastwo = document.getElementById('pageleft'),
				ctxtwo = canvastwo.getContext('2d');
					
			function getBookInfo(filepath){
	
				PDFJS.getDocument(filepath).then(function (rightPDF_) {
				rightPDF = rightPDF_;
				document.getElementById('page_count').textContent = rightPDF.numPages;
				pageNum = 1;
				// Initial/first page rendering
				renderPage(pageNum);
				
			});	
			};
			
			function renderPage(num) {
				pageRendering = true;
				// Using promise to fetch the page
				rightPDF.getPage(num).then(function(page) {
					var viewport = page.getViewport(scale);
					canvastwo.height = viewport.height;
					canvastwo.width = viewport.width;
					ctxtwo.drawImage(canvasone, 0, 0);

					canvasone.height = viewport.height;
					canvasone.width = viewport.width;

					// Render PDF page into canvas context
					var renderContext = {
						canvasContext: ctxone,
						viewport: viewport
					};
					var renderTask = page.render(renderContext);

					// Wait for rendering to finish
					renderTask.promise.then(function () {
						pageRendering = false;
						if (pageNumPending !== null) {
							// New page rendering is pending
							renderPage(pageNumPending);
							pageNumPending = null;
						}
					});
				});

				// Update page counters
				document.getElementById('page_num').textContent = pageNum;


			}

			/**
* If another page rendering in progress, waits until the rendering is
* finised. Otherwise, executes rendering immediately.
*/
			function queueRenderPage(num) {
				if (pageRendering) {
					pageNumPending = num;
				} else {
					renderPage(num);
				}
			}

			/**
* Displays previous page.
*/
			function onPrevPage() {
				if (pageNum <= 1) {
					return;
				}
				canvasone = document.getElementById('pageleft'),
					ctxone = canvasone.getContext('2d'),
					canvastwo = document.getElementById('pageright'),
					ctxtwo = canvastwo.getContext('2d');
				pageNum--;
				queueRenderPage(pageNum);
			}
			document.getElementById('pageleft').addEventListener('click', onPrevPage);

			function onNextPage() {
				if (pageNum >= rightPDF.numPages) {
					return;
				}
				canvasone = document.getElementById('pageright'),
					ctxone = canvasone.getContext('2d'),
					canvastwo = document.getElementById('pageleft'),
					ctxtwo = canvastwo.getContext('2d');
				pageNum++;
				queueRenderPage(pageNum);
			}
			
			document.getElementById('pageright').addEventListener('click', onNextPage);

			PDFJS.getDocument(bookurl).then(function (rightPDF_) {
			rightPDF = rightPDF_;
			document.getElementById('page_count').textContent = rightPDF.numPages;

			// Initial/first page rendering
			renderPage(pageNum);
		});						
		</script>	

	</body>
</html>
