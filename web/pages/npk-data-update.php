<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
	echo "<div class='alert alert-danger'>User ID is missing.</div>";
	return;
}

$userId = intval($_GET['id']);
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
		const id = <?= json_encode($userId) ?>;

		fetch('api/data_update.php', {
				method: 'POST',
				body: formData
			})
			.then(res => res.json())
			.then(data => {
				if (data.success === '1') {
					alert(data.message);
					form.reset();
				} else {
					alert('Error: ' + data.error);
				}
			})
			.catch(err => {
				console.error(err);
				alert('Something went wrong. Check console.');
			})
			.finally(() => {
				submitBtn.disabled = false;
				submitBtn.innerHTML = "Update NPK data information";
			});
	});

	document.addEventListener("DOMContentLoaded", () => {
		const id = <?= json_encode($userId) ?>;

		fetch(`api/data_read_details.php?id=${id}`)
			.then(res => res.json())
			.then(data => {
				if (data.success === "1") {
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