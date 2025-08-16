<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>NPKitty | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/root.css">
</head>

<body>
	<div class="container d-flex justify-content-center align-items-center h-100">
		<div class="card shadow-lg border-0 p-4 rounded-4" style="max-width: 400px; width: 100%;">
			<h3 class="text-center mb-4 step-title">Welcome Back</h3>
			<form id="login-form">
				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<input type="email" class="form-control form-control" id="email" name="email" placeholder="Enter email"
						required>
				</div>
				<div class="mb-4">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control form-control" id="password" name="password"
						placeholder="Enter password" required>
				</div>
				<button type="submit" class="btn w-100 btn-theme mb-3" id="submitBtn">
					Login
				</button>
			</form>
		</div>
	</div>

	<!-- Toast Container -->
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

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		const form = document.getElementById('login-form');
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
			submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Logging in...`;

			const formData = new FormData(form);

			fetch('api/user_login.php', {
					method: 'POST',
					body: formData
				})
				.then(res => res.json())
				.then(data => {
					if (data.success === "1") {
						localStorage.setItem("user_id", data.id);
						localStorage.setItem("user_email", data.email);
						localStorage.setItem("user_role", data.role);

						successToast.show();
						setTimeout(() => {
							window.location.href = 'home.php';
						}, 2000);
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
					submitBtn.innerHTML = "Login";
				});
		});
	</script>
</body>

</html>