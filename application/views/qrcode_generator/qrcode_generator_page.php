<div id="qrcode-generator-container" class="container">
	<div class="row">
		<div class="col-12">
			<form action="#" id="qrcode-generator-form">
				<div class="form-group">
					<label for="qrcode-content" class="form-label">QR Code content</label>
					<input type="text" name="qrcode-content" id="qrcode-content" class="form-control" required="required">
				</div>
				<div class="form-group mt-3">
					<label for="qrcode-filename" class="form-label">QR Code filename</label>
					<input type="text" name="qrcode-filename" id="qrcode-filename" class="form-control">
				</div>
				<div class="form-group mt-3">
					<button type="button" id="generate-qrcode-btn" class="btn btn-primary">Generate QRCode</button>
				</div>
			</form>
		</div>
	</div>
	<div class="row mt-5">
		<div id="loading" class="col-12"></div>
	</div>
	<div class="row mt-5">
		<div id="qrcode-image-col" class="col-12">
			<div class="row">
				<div id="loading" class="col-12"></div>
			</div>
			<div id="qrcode-image-card" class="card" hidden>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<img src="" alt="QRCode" id="generated-qrcode-image">
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<button type="button" class="btn btn-success">Download</button>
						</div>
						<div class="col-lg-6 col-md-12">
							<button type="button" class="btn btn-secondary">Send to email</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#generate-qrcode-btn').click(function() {
		let spinner = '<div id="qrcode-spinner" class="spinner-border" role="status">' +
			'<span class="sr-only">Loading...</span>' +
			'</div> Generating QR Code. Please wait...';
		$('#loading').html(spinner);
		let qrcode_content = $('#qrcode-content').val();
		let qrcode_filename = $('#qrcode-filename').val();
		$.ajax({
			type: 'post',
			url: '<?= base_url(); ?>qrcode_generator/generate_qrcode_image',
			data: {
				qrcode_content: qrcode_content,
				qrcode_filename: qrcode_filename
			},
			success: function(response) {
				response = JSON.parse(response);
				if (response.status == '1') {
					$('#generated-qrcode-image').attr('src', '<?= base_url(); ?>' + response.qrcode_image_path);
					$('#qrcode-image-card').attr('hidden', false);
					$('#loading').html('<p id="qrcode-generated-message">QR Code generated successfully!</p>');
				}
			}
		});
	});
</script>