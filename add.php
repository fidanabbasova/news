<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<title>Xəbər</title>
	</head>
	<body>
		<div class="container">
		
		<?php 
		$db = mysqli_connect("localhost", "root", "123456", "news");
		if( mysqli_connect_errno()) {
			echo '<h4 class="alert alert-danger">Baza ile əlaqə qurmaq mümkün deyil. Komfiqurasiyanı dəyişiməyiniz xahiş olunur!</h4>';
			die();
		}
		if ($_POST) {	
			$title = $_POST["title"];
			$subject = $_POST["subject"];
			$category_id = $_POST["category"];
			if($_FILES["file"]["size"] > 1048576) {
				$error = "Yükləyidiniz faylin həcmi maksimum 1Mb ola bilər.";
			}
			$divide = explode(".", $_FILES["file"]["name"]);
			$type = end($divide);

			if( $type != "jpg" && $type != "jpeg" && $type != "png" && $type != "gif" ){
				$error = "Yükləyidiniz faylin formatı yanlız jpg, jpeg, png, gif ola bilər.";
			}
			// if(!is_uploaded_file($_FILES["file"]["tmp_name"])) {
			// 	$error = "Şəkilin yüklənməsində xəta baş verdi.";
			// }
			$new_name = time()."".rand(111111,999999).".".$type;
			move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/". $new_name);

			if(!empty($error)) {
				echo '<p class="alert alert-warning">'.$error.'</p>';
				echo '<a href="." class="btn btn-primary">Xəbər səhifəsinə dön</a>';
				die();
			}
			$insert = mysqli_query( $db, "insert into news set title = '$title', subject = '$subject', image = '$new_name', category_id = '$category_id' " );
			if ($insert) {
				header('Location: /index.php');
			}else {
				echo '<p class="alert alert-warning">Xəbərin əlavə olunmasında xəta baş verdi, yenidən cəht edin.</p>';
				echo '<a href="." class="btn btn-primary">Xəbər səhifəsinə dön</a>';
				die();
			}
		} else {
			echo '  
				<h2>Xəbər əlavə edin: </h2>
				<form method="post" action="add.php" enctype="multipart/form-data">	
				    <div class="form-group">
				        <label for="inputTitle">Xəbərin başlığı</label>
				        <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Başlıq" required>
				    </div>		
				    <div class="form-group">
				        <label for="inputSubject">Xəbərin mövzusu</label>
				        <textarea class="form-control" rows="13" id="inputSubject" name="subject" placeholder="Mövzu" required></textarea>
				    </div>
					<div class="form-group">
						<label for="category">Xəbərin kategoriyası:</label>
						<select class="form-control" id="category" name="category">';
						$categories = mysqli_query( $db, "select * from categories" );
							while ($category = mysqli_fetch_array($categories) ) {
								echo("<option value=".$category["id"].">".$category["category_title"]."</option>");
							}
						echo '</select>
					</div>
				    <div class="form-group">
						<label for="inputFile">Şəkil əlavə edin</label>
						<input type="file" class="form-control" id="inputFile" name="file" required>
					</div>
					<input type="submit" class="btn btn-primary" value="Əlavə etin">
				</form>';
		}
		?>
		</div>
	</body>
</html>

