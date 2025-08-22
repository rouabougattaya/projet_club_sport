<div class="d-flex justify-content-between align-items-center mb-4">
	<h2 class="mb-0"><?= !empty($isAdmin) && $isAdmin ? 'Inscriptions' : 'Inscriptions de mes activités' ?></h2>
</div>

<div class="card shadow-sm">
	<div class="card-body">

		<div class="table-responsive">
			<table class="table table-hover align-middle mb-0">
				<thead class="table-light">
					<tr>
						
						<th>Activité</th>
						<th>Adhérent</th>
						<th>Date</th>
						<th>Statut</th>
						<th class="text-end" style="width:220px">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($inscriptions)): ?>
					<tr><td colspan="6" class="text-center p-4 text-muted">Aucune inscription trouvée.</td></tr>
					<?php endif; ?>
					<?php foreach ($inscriptions as $insc): ?>
						<tr>
							<td><?= htmlspecialchars($insc['activity_nom']) ?></td>
							<td><?= htmlspecialchars(trim(($insc['user_prenom'] ?? '') . ' ' . ($insc['user_nom'] ?? ''))) ?></td>
							<td><span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars((string)$insc['date_inscription']) ?></span></td>
							<td>
								<?php $s = strtolower((string)$insc['statut']);
									$label = ($s === 'validée') ? 'Validée' : (($s === 'refusée') ? 'Refusée' : (($s === 'annulée') ? 'Annulée' : (($s === 'terminée') ? 'Terminée' : 'En attente')));
									$cls = ($label === 'Validée') ? 'bg-success' : (($label === 'Refusée') ? 'bg-danger' : (($label === 'Annulée') ? 'bg-secondary' : (($label === 'Terminée') ? 'bg-dark' : 'bg-warning text-dark')));
								?>
								<span class="badge <?= $cls ?>"><?= $label ?></span>
							</td>
							<td class="text-end">
								<?php if ($s === 'en_attente'): ?>
									<a class="btn btn-sm btn-success" href="index.php?controller=inscriptions&action=validate&id=<?= urlencode((string)$insc['id']) ?>">Valider</a>
									<a class="btn btn-sm btn-outline-danger" href="index.php?controller=inscriptions&action=refuse&id=<?= urlencode((string)$insc['id']) ?>" onclick="return confirm('Refuser cette inscription ?');">Refuser</a>
								<?php elseif ($s === 'validée'): ?>
									<a class="btn btn-sm btn-outline-danger" href="index.php?controller=inscriptions&action=refuse&id=<?= urlencode((string)$insc['id']) ?>" onclick="return confirm('Refuser cette inscription ?');">Refuser</a>
								<?php elseif ($s === 'refusée' || $s === 'annulée' || $s === 'terminée'): ?>
									<button class="btn btn-sm btn-secondary" disabled>Aucune action</button>
								<?php else: ?>
									<button class="btn btn-sm btn-secondary" disabled>Aucune action</button>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


