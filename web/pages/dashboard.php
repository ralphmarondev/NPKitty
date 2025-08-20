<div class="card shadow p-4 mb-4" style="min-height: 500px;">
	<div class="container">

		<h3 class="step-title">NPK Data</h3>

		<!-- Filters -->
		<div class="row mb-2">
			<div class="col-md-12 mb-2">
				<input type="text" class="form-control" id="searchInput" placeholder="Search by date. (2025-08-01)">
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered table-hover align-middle">
				<thead class="table-light">
					<tr>
						<th style="width: 10%;" class="text-center">No</th>
						<th style="width: 15%;" class="text-center">Nitrogen (N)</th>
						<th style="width: 15%;" class="text-center">Phosporous (P)</th>
						<th style="width: 15%;" class="text-center">Potassium (K)</th>
						<th style="width: 25%;" class="text-center">Timestamp</th>
						<th style="width: 20%;" class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody id="npkDataTableBody">
					<tr class="text-center">
						<td colspan="6">Loading...</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- View Data Modal -->
	<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
		aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
			<div class="modal-content rounded-4 cute-modal">
				<div class="modal-header cute-modal-header">
					<h5 class="modal-title" id="viewModalLabel">View Data</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-section form-section-basic">
						<h5 class="text-muted">NPK Information</h5>
						<hr>
						<div class="row">
							<div class="mb-3 col-md-6">
								<label class="form-label">Nitrogen (N)</label>
								<input type="text" class="form-control" name="nitrogen_view" id="nitrogen_view" placeholder="Enter nitrogen level"
									readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Phosporous (P)</label>
								<input type="text" class="form-control" name="phosporous_view" id="phosporous_view" placeholder="Enter phosporous level" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Pottasium (K)</label>
								<input type="text" class="form-control" name="pottasium_view" id="pottasium_view" placeholder="Enter Pottasium level" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Timestamp</label>
								<input type="text" class="form-control" name="timestamp_view" id="timestamp_view" placeholder="Enter timestamp" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Owner</label>
								<input type="text" class="form-control" name="owner_view" id="owner_view" placeholder="Enter owner information" readonly>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer border-0">
					<button type="button" class="btn btn-pink" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Delete Account Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
		aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
			<div class="modal-content rounded-4 cute-modal">
				<div class="modal-header cute-modal-header">
					<h5 class="modal-title" id="viewModalLabel">Delete Account</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-section form-section-basic">
						<h5 class="text-muted">Are you sure you want to delete this account? This action cannot be undone.</h5>
						<hr>
						<div class="row">
							<div class="mb-3 col-md-6">
								<label class="form-label">Full Name</label>
								<input type="text" class="form-control" name="full name" id="full_name_delete" placeholder="Enter full name"
									readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Email</label>
								<input type="email" class="form-control" name="email" id="email_delete" placeholder="Enter email" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Role</label>
								<input type="text" class="form-control" name="role" id="role_delete" placeholder="Enter role" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Gender</label>
								<input type="text" class="form-control" name="gender" id="gender_delete" placeholder="Enter gender" readonly>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer border-0">
					<button type="button" class="btn btn-light-gray" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-pink" onclick="confirmDelete()">Delete</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Success Modal -->
	<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content rounded-4 cute-modal">
				<div class="modal-header cute-modal-header">
					<h5 class="modal-title">Success</h5>
				</div>
				<div class="modal-body">
					NPK data deleted successfully!
				</div>

				<div class="modal-footer border-0">
					<button type="button" class="btn btn-pink" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Error Modal -->
	<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content rounded-4 cute-modal">
				<div class="modal-header cute-modal-header">
					<h5 class="modal-title">Failed</h5>
				</div>
				<div class="modal-body" id="errorMessage">
					<!-- error message will be injected -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-pink" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script>
	const searchInput = document.getElementById('searchInput');

	searchInput.addEventListener('input', fetchFilteredNpkData);
	roleFilter.addEventListener('change', fetchFilteredNpkData);

	function fetchFilteredNpkData() {
		const searchTerm = searchInput.value.trim().toLowerCase();

		fetch('api/data_read_list.php')
			.then(res => res.json())
			.then(data => {
				const tbody = document.getElementById('npkDataTableBody');
				tbody.innerHTML = '';

				if (data.success === "1" && data.users.length > 0) {
					let filtered = data.npkData;

					// if (searchTerm) {
					// 	filtered = filtered.filter(u => (u.full_name || '').toLowerCase().includes(searchTerm));
					// }

					// if (role !== 'All') {
					// 	filtered = filtered.filter(u => u.role === role);
					// }

					if (filtered.length > 0) {
						filtered.forEach((u, i) => {
							const tr = document.createElement('tr');
							tr.innerHTML = `
								<td>${i + 1}</td>
								<td>${u.userId || '—'}</td>
								<td>${u.pin || '—'}</td>
								<td>${u.ploatId || '—'}</td>
								<td>${u.nitrogen || '—'}</td>
								<td>${u.phosporous || '—'}</td>
								<td>${u.potassium || '—'}</td>
								<td>${u.moisture || '—'}</td>
								<td>${u.timestamp || '—'}</td>
								<td class="text-center">
										<button onclick='openViewModal(${u.id})' class="btn btn-sm btn-success me-1">
												<i class="bi bi-eye"></i>
										</button>
										<a href="home.php?page=update-administrator&id=${u.id}" class="btn btn-sm btn-primary me-1" title="Update">
												<i class="bi bi-pencil-square"></i>
										</a>
										<button onclick="openDeleteModal(${u.id})" class="btn btn-sm btn-danger">
												<i class="bi bi-trash"></i>
										</button>
								</td>
						`;
							tbody.appendChild(tr);
						});
					} else {
						tbody.innerHTML = `<tr><td colspan="5" class="text-muted text-center">No npk data found.</td></tr>`;
					}
				} else {
					tbody.innerHTML = `<tr><td colspan="5" class="text-muted text-center">No npk data found.</td></tr>`;
				}
			})
			.catch(err => {
				console.error(err);
				document.getElementById('npkDataTableBody').innerHTML =
					`<tr><td colspan="5" class="text-danger text-center">Error loading data.</td></tr>`;
			});
	}

	fetchFilteredNpkData();

	let selectedUserId = null; // to store the data being updated/deleted

	function openViewModal(id) {
		selectedUserId = id;
		fetch(`api/get_user.php?id=${id}`)
			.then(res => res.json())
			.then(data => {
				if (data.success === "1") {
					const user = data.user;
					document.getElementById('full_name_view').value = user.full_name || '';
					document.getElementById('email_view').value = user.email || '';
					document.getElementById('role_view').value = user.role || '';
					document.getElementById('gender_view').value = user.gender || '';
					new bootstrap.Modal(document.getElementById('viewModal')).show();
				} else {
					alert("Error: " + data.error);
				}
			});
	}

	// Show Delete Modal
	function openDeleteModal(id) {
		selectedUserId = id;
		fetch(`api/get_user.php?id=${id}`)
			.then(res => res.json())
			.then(data => {
				if (data.success === "1") {
					const user = data.user;
					document.getElementById('full_name_delete').value = user.full_name || '';
					document.getElementById('email_delete').value = user.email || '';
					document.getElementById('role_delete').value = user.role || '';
					document.getElementById('gender_delete').value = user.gender || '';
					new bootstrap.Modal(document.getElementById('deleteModal')).show();
				} else {
					alert("Error: " + data.error);
				}
			});
	}

	// Confirm Delete
	function confirmDelete() {
		fetch('api/user_delete.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: `id=${selectedUserId}`
			})
			.then(res => res.json())
			.then(data => {
				const deleteModalInstance = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
				if (deleteModalInstance) deleteModalInstance.hide();

				if (data.success === "1") {
					fetchFilteredNpkData();

					new bootstrap.Modal(document.getElementById('successModal')).show();
				} else {
					document.getElementById('errorMessage').innerText = data.error;
					new bootstrap.Modal(document.getElementById('errorModal')).show();
				}
			});
	}
</script>