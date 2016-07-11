<html>
	<head>
		<?php 
			if($assets)
				foreach($assets as $asset)
					echo $asset;
		?>
	</head>
	<body>
		<?php include $view; ?>
	</body>
</html>
