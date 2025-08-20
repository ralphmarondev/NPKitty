<div class="card shadow p-4 mb-4" style="min-height: 500px;">
	<div class="container">
		<h5 class="text-muted">Account Information</h5>
		<form id="change-password-form">
			<div class="row mb-2">
				<div class="mb-3 col-md-12">
					<label class="form-label">Current Password:</label>
					<input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter current password" required>
				</div>
				<div class="mb-3 col-md-12">
					<label class="form-label">New Password:</label>
					<input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter new password" required>
				</div>
				<div class="mb-3 col-md-12">
					<label class="form-label">Confirm New Password:</label>
					<input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Cofirm new password" required>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" id="submitBtn">Update Password</button>
	</div>
	</form>

	<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
		<div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex">
				<div class="toast-body">
					Password updated successfully!
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
	const form = document.getElementById('change-password-form');
	const errorMessage = document.getElementById('errorMessage');

	const successToastEl = document.getElementById('successToast');
	const errorToastEl = document.getElementById('errorToast');

	const successToast = new bootstrap.Toast(successToastEl, {
		delay: 1000
	});
	const errorToast = new bootstrap.Toast(errorToastEl, {
		delay: 3000
	});

	form.addEventListener('submit', function(e) {
		e.preventDefault();
		const submitBtn = document.getElementById('submitBtn');
		submitBtn.disabled = true;
		submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Updating...`;

		const formData = new FormData(form);
		const userId = localStorage.getItem('user_id');
		formData.append('id', userId);

		fetch('api/user_change_password.php', {
				method: 'POST',
				body: formData
			})
			.then(res => res.json())
			.then(data => {
				if (data.success === 1) {
					successToast.show();
				} else {
					errorMessage.textContent = data.error || "Something went wrong.";
					errorToast.show();
				}
			})
			.catch(err => {
				errorMessage.textContent = "Server error: " + err;
				errorToast.show();
			})
			.finally(() => {
				submitBtn.disabled = false;
				submitBtn.innerHTML = "Update Password";
			});
	});
</script>