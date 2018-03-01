<?php

if(isset($_GET['id'])) {
	$db = mysqli_connect("localhost", "root", "123456", "news");
	echo '<!DOCTYPE html>
		<head>
			<meta charset="utf-8">
			<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
			<link rel="stylesheet" type="text/css" href="css/style.css">
			<title>Xəbər</title>
		</head>
		<body>
			<div class="container">
				<div class="row">';
					$news = mysqli_query( $db, "select * from news inner join categories on  categories.id =  news.category_id where id = ". $_GET['id'] ." ");
					while ($n = mysqli_fetch_array($news) ) {
						echo ' <div class="col-sm-6 col-md-4">
							<div class="thumbnail">
								<img src="uploads/'. $n["image"] .'">
								<div class="caption">
									<h4>'. $n["title"] .'</h4>
									<p>' . substr($n["subject"], 0, 120). '...</p>
									<p>' . $n["date"]. '</p>
									<p><a href="/category.php?id='.$n["category_id"].'" class="btn btn-info" role="button">'. $n["category_title"] .' xəbərləri</a></p>
									<p><a href="/news.php?id='.$n["news_id"].'" class="btn btn-primary" role="button">Ətraflı</a> Baxış sayı: '. $n["view"] . '</p>
								</div>
							</div>
						</div>';
					}
				echo '</div>
			</div>

		</body>
		</html>';

}

?>


<!-- where id = ". $_GET['id'] ."  -->