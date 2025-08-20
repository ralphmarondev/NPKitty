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

		fetch('api/user_change_password.php', {
				method: 'POST',
				body: formData
			})
			.then(res => res.json())
			.then(data => {
				if (data.success === "1") {

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