<?php
session_start();
?>

<html>

<head>
	<title>RSA Algorithm</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
	<nav class="navbar navbar-dark bg-primary">
		<div class="container">
			<a class="navbar-brand" href="#">
				<h2>RSA Algorithm </h2>
			</a>
		</div>
	</nav>

	<div class="container">
		<h1>P : <span id="txt_p"></span> | Q : <span id="txt_q"></span> </h1>
		<br>
		<button type="button" class="btn btn-primary" onclick="generateKey()">Generate Key</button>
		<hr>

		<form style="border: 1px solid grey; padding:20px" action="save_key.php" method="POST">
			<h4 class="text-center">Menu Pembangkitan
			</h4>
			<br>
			<div class="key_">
				<div class="row g-2">
					<div class="col-md">
						<label for="floatingSelectGrid">Public Key</label>
						<textarea name="public_key" class="form-control" id="public_key" rows="5" readonly></textarea>
						<br>
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="submit" name="type" value="public" class="btn btn-primary" id="btnSave">Save</button>
						</div>
					</div>
					<div class="col-md">
						<label for="floatingSelectGrid">Private Key</label>
						<textarea name="private_key" class="form-control" id="private_key" rows="5" readonly></textarea>
						<br>
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="submit" name="type" value="private" class="btn btn-primary" id="btnSave1">Save</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div style="border: 1px solid grey; padding:20px">
			<h4 class="text-center">Menu Digital Signature</h4>
			<br>
			<div class="key_">
				<div class="col text-center">
					<?php if (!isset($_SESSION["file_upload_name"])) : ?>
						<form action="upload_file.php" method="POST" enctype="multipart/form-data">
							<label for="floatingSelectGrid">Upload a File : </label>
							<input type="file" id="file_upload" name="file_upload">
							<button type="submit" class="btn btn-primary">Upload</button>
						</form>
					<?php else : ?>
						<form action="remove_file.php">
							<label>File uploaded : <?php echo $_SESSION["file_upload_name"]; ?></label>
							<button type="submit" class="btn btn-danger">Remove</button>
						</form>
					<?php endif; ?>
				</div>
				<br><br>
				<div class="row g-2">
					<div class="col-md" style="border: 2px solid grey; padding:20px; margin: 5px">
						<div class="row">
							<div class="col-12">
								<form action="sign_file.php" method="POST" enctype="multipart/form-data">
									<label for="floatingSelectGrid">Private Key : </label>
									<input type="file" id="private_key" name="private_key">
									<br><br>
									<div class="col text-center">
										<button type="submit" class="btn btn-primary" id="btnSigning">Signing</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md" style="border: 2px solid grey; padding:20px; margin: 5px">
						<div class="row">
							<div class="col-12">
								<form action="verify_file.php" method="POST" enctype="multipart/form-data">
									<label for="floatingSelectGrid">Public Key : </label>
									<input type="file" id="public_key" name="public_key">
									<br><br>
									<div class="col text-center">
										<button type="submit" class="btn btn-primary">Verifying</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
			generateKey();
		});

		function generateKey() {
			$.ajax({
				method: 'POST',
				url: "generate_key.php",
				dataType: "json",
				success: function(data) {
					$('#txt_p').text(data.p);
					$('#txt_q').text(data.q);
					$('#txtP').val(data.p);
					$('#txtQ').val(data.q);
					$('#private_key').val(data.private_key);
					$('#public_key').val(data.public_key);
				}
			});
		}
	</script>
	<?php if(isset($_SESSION['alert_msg'])): ?>
		<script>
			alert("<?php echo $_SESSION['alert_msg']; ?>");
		</script>
		<?php
		unset($_SESSION['alert_msg']);
		?>
	<?php endif; ?>
</body>

</html>