<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
	echo "<div class='alert alert-danger'>NPK data ID is missing.</div>";
	return;
}

$npkId = intval($_GET['id']);
?>

<div class="card shadow p-4 mb-4" style="min-height: 500px;">
	<div class="container">
		<h5 class="text-muted">Update NPK Data</h5>
		<form id="update-npk-data-form">
			<div class="row">
				<div class="mb-3 col-md-6">
					<label class="form-label">Nitrogen</label>
					<input type="text" class="form-control" name="update_nitrogen" id="update_nitrogen"
						placeholder="Enter nitrogen level" required>
				</div>
				<div class="mb-3 col-md-6">
					<label class="form-label">Phosporous</label>
					<input type="text" class="form-control" name="update_phosphorus" id="update_phosphorus"
						placeholder="Enter phosphorus level" required>
				</div>
				<div class="mb-3 col-md-6">
					<label class="form-label">Potassium</label>
					<input type="text" class="form-control" name="update_potassium" id="update_potassium"
						placeholder="Enter potassium level" required>
				</div>
				<div class="mb-3 col-md-6">
					<label class="form-label">Moisture</label>
					<input type="text" class="form-control" name="update_moisture" id="update_moisture"
						placeholder="Enter moisture level" required>
				</div>
				<div class="mb-3 form-group col-md-6">
					<label class="form-label">User Id</label>
					<input class="form-control" name="update_user_id" id="update_user_id" placeholder="Enter user id"
						required>
				</div>
				<div class="mb-3 form-group col-md-6">
					<label class="form-label">Plot Id</label>
					<input class="form-control" name="update_plot_id" id="update_plot_id" placeholder="Enter plot id"
						required>
				</div>
			</div>
			<button type="submit" class="btn btn-primary w-100 mt-3" id="submitBtn">Update NPK Data</button>
		</form>
		<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
			<div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						You're logged in successfully!
					</div>
					<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>

			<div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body" id="errorMessage">
						Something went wrong.
					</div>
					<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	const form = document.getElementById('update-npk-data-form');

	form.addEventListener('submit', function(e) {
		e.preventDefault();
		const submitBtn = document.getElementById('submitBtn');
		submitBtn.disabled = true;
		submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Updating...`;

		const formData = new FormData(form);
		const id = <?= json_encode($npkId) ?>;
		formData.append('id', id);

		fetch('api/data_update.php', {
				method: 'POST',
				body: formData
			})
			.then(res => res.json())
			.then(data => {
				if (data.success === 1) {
					const successToast = new bootstrap.Toast(document.getElementById('successToast'));
					document.querySelector('#successToast .toast-body').textContent = data.message;
					successToast.show();
				} else {
					const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
					document.getElementById('errorMessage').textContent = data.error;
					errorToast.show();
				}
			})
			.catch(err => {
				console.error(err);
				const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
				document.getElementById('errorMessage').textContent = "Something went wrong.";
				errorToast.show();
			})
			.finally(() => {
				submitBtn.disabled = false;
				submitBtn.innerHTML = "Update NPK Data";
			});
	});

	document.addEventListener("DOMContentLoaded", () => {
		const id = <?= json_encode($npkId) ?>;

		fetch(`api/data_read_details.php?id=${id}`)
			.then(res => res.json())
			.then(data => {
				if (data.success === 1) {
					const npkData = data.npkData;
					document.getElementById('update_nitrogen').value = npkData.nitrogen;
					document.getElementById('update_phosphorus').value = npkData.phosphorus;
					document.getElementById('update_potassium').value = npkData.potassium;
					document.getElementById('update_moisture').value = npkData.moisture;
					document.getElementById('update_user_id').value = npkData.user_id;
					document.getElementById('update_plot_id').value = npkData.plot_id;
				} else {
					alert("Failed to load npk data.");
				}
			})
			.catch(err => {
				console.error(err);
				alert("Error loading npk details.");
			});
	});
</script>