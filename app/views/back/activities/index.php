<div class="d-flex justify-content-between align-items-center mb-4">
	<h2 class="mb-0"><?= !empty($isAdmin) && $isAdmin ? 'Activités' : 'Mes activités' ?></h2>
	<a class="btn btn-primary" href="index.php?controller=activities&action=create"><i class="bi bi-plus-lg me-1"></i> Nouvelle activité</a>
</div>

<div class="card shadow-sm">
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-hover align-middle mb-0">
				<thead class="table-light">
					<tr>
						<th>Nom</th>
						<th>Date</th>
						<th>Début</th>
						<th>Fin</th>
						<th>Capacité</th>
						<th>Statut</th>
						<th>Description</th>
						<?php if (!empty($isAdmin) && $isAdmin): ?>
						<th>Coach</th>
						<?php endif; ?>
						<th style="width: 180px">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($activities)): ?>
						<tr>
							<td colspan="6" class="text-center p-5 text-muted">
								<div class="mb-2">Aucune activité trouvée.</div>
								<a class="btn btn-sm btn-primary" href="index.php?controller=activities&action=create"><i class="bi bi-plus-lg me-1"></i>Créer la première activité</a>
							</td>
						</tr>
					<?php endif; ?>
					<?php foreach ($activities as $a): ?>
						<tr>
							<td><strong><?= htmlspecialchars($a['nom']) ?></strong></td>
							<td><span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars($a['date_activite'] ?? '') ?></span></td>
							<td><span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars($a['heure_debut'] ?? '') ?></span></td>
							<td><span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars($a['heure_fin'] ?? '') ?></span></td>
							<td><?= htmlspecialchars((string)($a['capacite'] ?? '0')) ?></td>
							<td>
								<?php
									$rawStatut = strtolower(trim((string)($a['statut'] ?? 'actif')));
									$isActive = (
										$rawStatut === 'actif' ||
										$rawStatut === 'active' ||
										$rawStatut === '1' ||
										$rawStatut === 'true' ||
										$rawStatut === 'oui' ||
										$rawStatut === 'yes' ||
										$rawStatut === 'on'
									);
									$status = $isActive ? 'Actif' : 'Inactif';
								?>
								<span class="badge <?= $status === 'Actif' ? 'bg-success' : 'bg-secondary' ?>"><?= $status ?></span>
							</td>
							<td class="text-truncate" style="max-width:420px"><?= htmlspecialchars($a['description']) ?></td>
							<?php if (!empty($isAdmin) && $isAdmin): ?>
							<td><?= htmlspecialchars(trim(($a['coach_prenom'] ?? '') . ' ' . ($a['coach_nom'] ?? ''))) ?: '—' ?></td>
							<?php endif; ?>
							<td>
								<a class="btn btn-sm btn-outline-secondary" href="index.php?controller=activities&action=edit&id=<?= urlencode((string)$a['id']) ?>"><i class="bi bi-pencil"></i></a>
								<a class="btn btn-sm btn-outline-danger" href="index.php?controller=activities&action=delete&id=<?= urlencode((string)$a['id']) ?>" onclick="return confirm('Supprimer cette activité ?');"><i class="bi bi-trash"></i></a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


