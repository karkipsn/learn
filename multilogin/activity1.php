 <?php

 include('connection.php');

 $result = mysqli_query($db, "SELECT * FROM images ");

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 	<style type="text/css">
 	#content{
 		width: 50%;
 		margin: 20px auto;
 		border: 1px solid #cbcbcb;
 	}

 	#img_div{
 		width: 60%;
 		padding: 5px;
 		margin: 15px auto;
 		border: 1px solid #cbcbcb;
 	}
 	#img_div:after{
 		content: "";
 		display: block;
 		clear: both;
 	}
 	img{
 		float: left;
 		margin: 5px;
 		width: 300px;
 		height: 140px;
 	}
 </style>
</head>
<body>
	<div id="content">

		<?php
		while ($row = mysqli_fetch_array($result)) {
			echo "<div id='img_div'>";
			echo "<img src='images/".$row['image']."' >";
			echo "<p>".$row['image_text']."</p>";
			echo "</div>";
		} ?>
	</div>

</body>
</html>
