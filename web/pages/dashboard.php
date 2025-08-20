<div class="card shadow p-4 mb-4" style="min-height: 500px;">
	<div class="container">
		<h3 class="step-title">NPK Data</h3>
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
						<th style="width: 16%;" class="text-center">Nitrogen (N)</th>
						<th style="width: 16%;" class="text-center">Phosporous (P)</th>
						<th style="width: 16%;" class="text-center">Potassium (K)</th>
						<th style="width: 22%;" class="text-center">Timestamp</th>
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

	<!-- View Modal -->
	<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
		aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
			<div class="modal-content rounded-4 cute-modal">
				<div class="modal-header cute-modal-header">
					<h5 class="modal-title" id="viewModalLabel">View NPK Data</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-section form-section-basic">
						<div class="row">
							<div class="mb-3 col-md-6">
								<label class="form-label">Nitrogen</label>
								<input type="text" class="form-control" name="view_nitrogen" id="view_nitrogen"
									placeholder="Enter nitrogen level" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Phosporous</label>
								<input type="text" class="form-control" name="view_phosphorus" id="view_phosphorus"
									placeholder="Enter phosphorus level" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Potassium</label>
								<input type="text" class="form-control" name="view_potassium" id="view_potassium"
									placeholder="Enter potassium level" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Moisture</label>
								<input type="text" class="form-control" name="view_moisture" id="view_moisture"
									placeholder="Enter moisture level" readonly>
							</div>
							<div class="mb-3 form-group col-md-6">
								<label>User Id</label>
								<input class="form-control" name="view_user_id" id="view_user_id" placeholder="Enter user id"
									readonly>
							</div>
							<div class="mb-3 form-group col-md-6">
								<label>Plot Id</label>
								<input class="form-control" name="view_plot_id" id="view_plot_id" placeholder="Enter plot id"
									readonly>
							</div>
							<div class="mb-3 form-group col-md-12">
								<label>Timestamp</label>
								<input class="form-control" name="view_timestamp" id="view_timestamp"
									placeholder="Enter timestamp" readonly>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-light-gray" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
		aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
			<div class="modal-content rounded-4 cute-modal">
				<div class="modal-header cute-modal-header">
					<h5 class="modal-title" id="deleteModalLabel">Delete NPK Data</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-section form-section-basic">
						<div class="row">
							<div class="mb-3 col-md-6">
								<label class="form-label">Nitrogen</label>
								<input type="text" class="form-control" name="delete_nitrogen" id="delete_nitrogen"
									placeholder="Enter nitrogen level" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Phosporous</label>
								<input type="text" class="form-control" name="delete_phosphorus" id="delete_phosphorus"
									placeholder="Enter phosphorus level" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Potassium</label>
								<input type="text" class="form-control" name="delete_potassium" id="delete_potassium"
									placeholder="Enter potassium level" readonly>
							</div>
							<div class="mb-3 col-md-6">
								<label class="form-label">Moisture</label>
								<input type="text" class="form-control" name="delete_moisture" id="delete_moisture"
									placeholder="Enter moisture level" readonly>
							</div>
							<div class="mb-3 form-group col-md-6">
								<label>User Id</label>
								<input class="form-control" name="delete_user_id" id="delete_user_id" placeholder="Enter user id"
									readonly>
							</div>
							<div class="mb-3 form-group col-md-6">
								<label>Plot Id</label>
								<input class="form-control" name="delete_plot_id" id="delete_plot_id" placeholder="Enter plot id"
									readonly>
							</div>
							<div class="mb-3 form-group col-md-12">
								<label>Timestamp</label>
								<input class="form-control" name="delete_timestamp" id="delete_timestamp"
									placeholder="Enter timestamp" readonly>
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

	<div id="successToast" class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3" role="alert">
		<div class="d-flex">
			<div class="toast-body">
				NPK data deleted successfully!
			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
		</div>
	</div>

	<div id="errorToast" class="toast align-items-center text-bg-danger border-0 position-fixed bottom-0 end-0 m-3" role="alert">
		<div class="d-flex">
			<div class="toast-body" id="errorMessage">Something went wrong</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
		</div>
	</div>

</div>
</div>

<script>
	const searchInput = document.getElementById('searchInput');
	searchInput.addEventListener('input', fetchFilteredNpkData);

	let npkId = null;

	function fetchFilteredNpkData() {
		const searchTerm = searchInput.value.trim().toLowerCase();

		fetch('api/data_read_list.php')
			.then(res => res.json())
			.then(data => {
				const tbody = document.getElementById('npkDataTableBody');
				tbody.innerHTML = '';

				if (data.success === "1" && data.npkData.length > 0) {
					let filtered = data.npkData;

					if (filtered.length > 0) {
						filtered.forEach((u, i) => {
							const tr = document.createElement('tr');
							tr.innerHTML = `
								<td class="text-center">${i + 1}</td>
								<td class="text-center">${u.nitrogen || '-'}</td>
								<td class="text-center">${u.phosphorus || '-'}</td>
								<td class="text-center">${u.potassium || '-'}</td>
								<td class="text-center">${u.timestamp || '-'}</td>
								<td class="text-center">
										<button onclick='viewNpkDetails(${u.id})' class="btn btn-sm btn-success me-1">
												<i class="bi bi-eye"></i>
										</button>
										<a href="home.php?page=npk-data-update&id=${u.id}" class="btn btn-sm btn-primary me-1" title="Update">
												<i class="bi bi-pencil-square"></i>
										</a>
										<button onclick="deleteNpkDetails(${u.id})" class="btn btn-sm btn-danger">
												<i class="bi bi-trash"></i>
										</button>
								</td>
						`;
							tbody.appendChild(tr);
						});
					} else {
						tbody.innerHTML = `<tr><td colspan="6" class="text-muted text-center">No npk data found.</td></tr>`;
					}
				} else {
					tbody.innerHTML = `<tr><td colspan="6" class="text-muted text-center">No npk data found.</td></tr>`;
				}
			})
			.catch(err => {
				console.error(err);
				document.getElementById('npkDataTableBody').innerHTML =
					`<tr><td colspan="6" class="text-danger text-center">Error loading data.</td></tr>`;
			});
	}

	fetchFilteredNpkData();

	function viewNpkDetails(id) {
		const modal = new bootstrap.Modal(document.getElementById('viewModal'));
		fetch(`api/data_read_details.php?id=${id}`)
			.then(res => res.json())
			.then(data => {
				if (data.success === "1") {
					const npkData = data.npkData;
					document.getElementById('view_nitrogen').value = npkData.nitrogen;
					document.getElementById('view_phosphorus').value = npkData.phosphorus;
					document.getElementById('view_potassium').value = npkData.potassium;
					document.getElementById('view_moisture').value = npkData.moisture;
					document.getElementById('view_timestamp').value = npkData.timestamp;
					document.getElementById('view_user_id').value = npkData.user_id;
					document.getElementById('view_plot_id').value = npkData.plot_id;

					modal.show();
				} else {
					alert("NPK data not found.");
				}
			})
			.catch(err => {
				console.error(err);
				alert("Error loading npk data.");
			});
	}

	function deleteNpkDetails(id) {
		npkId = id;
		const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
		fetch(`api/data_read_details.php?id=${id}`)
			.then(res => res.json())
			.then(data => {
				if (data.success === "1") {
					const npkData = data.npkData;
					document.getElementById('delete_nitrogen').value = npkData.nitrogen;
					document.getElementById('delete_phosphorus').value = npkData.phosphorus;
					document.getElementById('delete_potassium').value = npkData.potassium;
					document.getElementById('delete_moisture').value = npkData.moisture;
					document.getElementById('delete_timestamp').value = npkData.timestamp;
					document.getElementById('delete_user_id').value = npkData.user_id;
					document.getElementById('delete_plot_id').value = npkData.plot_id;

					modal.show();
				} else {
					alert("NPK data not found.");
				}
			})
			.catch(err => {
				console.error(err);
				alert("Error loading npk data.");
			});
	}

	function confirmDelete() {
		if (!npkId) {
			console.log('NPK id is emtpy.');
			return;
		}

		fetch('api/data_delete.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					id: npkId
				})
			})
			.then(res => res.json())
			.then(data => {
				if (data.success === "1") {
					const toastEl = document.getElementById('successToast');
					const toast = new bootstrap.Toast(toastEl);
					toast.show();

					const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
					if (modal) modal.hide();

					setTimeout(() => location.reload(), 1500);
				} else {
					document.getElementById('errorMessage').textContent = data.error || "Delete failed.";
					const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
					errorToast.show();
				}
			})
			.catch(err => {
				document.getElementById('errorMessage').textContent = "Server error: " + err;
				const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
				errorToast.show();
			});
	}
</script>