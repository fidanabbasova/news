<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<title>Xəbər</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-9">	
					<?php 
						$db = mysqli_connect("localhost", "root", "123456", "news");
						$news = mysqli_query( $db, "select * from news inner join categories on  categories.id = news.category_id" );
						while ($n = mysqli_fetch_array($news) ) {
							echo '
								<div class="col-sm-6 col-md-4">
									<div class="thumbnail">
										<img src="uploads/'. $n["image"] .'">
										<div class="caption">
											<h4>'. $n["title"] .'</h4>
											<p>' . substr($n["subject"], 0, 120). '...</p>
											<p>' . $n["date"]. '</p>
											<p><a href="/category.php?id='.$n["category_id"].'" class="btn btn-info" role="button">'. $n["category_title"] .' xəbərləri</a></p>
											<p><a href="/news.php?id='.$n["news_id"].'" class="btn btn-primary" role="button">Ətraflı</a> Baxış sayı: '. $n["view"] . '</p>
											<p></p>
										</div>
									</div>
								</div>
							';
						}
					?>
				</div>
				<div class="col-xs-3">
					<?php
					$categories = mysqli_query( $db, "select * from categories" );
					while ($category = mysqli_fetch_array($categories) ) {
						$count = mysqli_query( $db, "select * from news where category_id = "  . $category["id"]. " ");  
						echo '<p><a  href="/category.php?id='.$category["id"].'">'. $category["category_title"] .' ('. mysqli_num_rows($count) .')</a><p>';
					}
					?>
				</div>	
			</div>
		</div>
	</body>
</html>

