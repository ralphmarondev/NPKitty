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
</div>
</div>

<script>
	const searchInput = document.getElementById('searchInput');
	searchInput.addEventListener('input', fetchFilteredNpkData);

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
										<button onclick='openViewModal(${u.id})' class="btn btn-sm btn-success me-1">
												<i class="bi bi-eye"></i>
										</button>
										<a href="home.php?page=npk-data-update&id=${u.id}" class="btn btn-sm btn-primary me-1" title="Update">
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
</script>