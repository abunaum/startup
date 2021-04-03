<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Oooops!</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<style>
		.center {
			text-align: center;
			margin: auto;
		}

		.page_404 {
			padding: 40px 0;
			background: #fff;
			font-family: 'Arvo', serif;
		}

		.page_404 img {
			width: 100%;
		}

		.four_zero_four_bg {

			background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
			height: 400px;
			background-position: center;
		}


		.four_zero_four_bg h1 {
			font-size: 80px;
		}

		.four_zero_four_bg h3 {
			font-size: 80px;
		}

		.link_404 {
			color: #fff !important;
			padding: 10px 20px;
			background: #39ac31;
			margin: 20px 0;
			display: inline-block;
		}

		.contant_box_404 {
			margin-top: -50px;
		}
	</style>
</head>

<body>
	<section class="page_404">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 ">
					<div class="col-sm-10 col-sm-offset-1  text-center">
						<div class="four_zero_four_bg">
							<h1 class="text-center "><?= $exception->getCode() ?></h1>
						</div>

						<div class="contant_box_404">
							<h3 class="h2">
								Ooops!
							</h3>

							<p>
								<?= $exception->getMessage() ?>
							</p>

							<a href="<?= base_url() ?>" class="link_404">Kembali ke beranda</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>