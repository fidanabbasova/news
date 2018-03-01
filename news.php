<?php

if(isset($_GET['id'])) {
	$db = mysqli_connect("localhost", "root", "123456", "news");
	mysqli_query( $db, "update news set view = view+1 where news_id = ". $_GET['id'] ." " );
	$news = mysqli_query($db, "select * from news inner join categories on  categories.id = news.category_id where news_id = ". $_GET['id'] ." ");
	echo '
	<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<title>'. $n["title"] .'</title>
	</head>
	<body>
		<div class="container">';
			while ($n = mysqli_fetch_array($news) ) {
				if ($_POST) {	
					$comment = $_POST["comment"];
					$insert = mysqli_query( $db, "insert into comments set content = '$comment', news_id = ". $_GET["id"] ." " );
				}

				echo '<div class="row">
					<div class="col-xs-6 col-xs-offset-3">
						<img class="img-responsive" src="uploads/'. $n["image"] .'"> 
						<h3>'. $n["title"] .'</h3>
						<p>'. $n["subject"] . '</p>
					</div>
					<div class="col-xs-2">
						<p>'. $n["date"] . '</p>
						<p><a href="/category.php?id='.$n["category_id"].'">'. $n["category_title"] .' </a></p>
						<p> Baxış sayı: '. $n["view"] . '</p>

					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-xs-offset-3">';
					$comments = mysqli_query($db, "select * from comments where news_id = ". $_GET['id'] ." " );

					while ($c = mysqli_fetch_array($comments)) {
						echo ' <p class="alert alert-warning" >'. $c["content"] . '</p> ';
					}

					echo '<form method="post" action="news.php?id='.$n["news_id"].'" >	
					    <div class="form-group">
					        <input type="text" class="form-control" name="comment" placeholder="Şərh əlavə edin" required>
					    </div>	
					    <input type="submit" class="btn btn-primary" value="Əlavə etin">
					</form>
					</div>
				</div>';
			}
	echo '</div>
		</body>
	</html>';	
}

?>

