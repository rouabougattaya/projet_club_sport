<div class="card shadow-sm">
	<div class="card-body">
		<h2 class="mb-4">Modifier l'activité </h2>
		<?php if (!empty($errors)): ?>
		<div class="alert alert-danger">
			<ul class="mb-0">
				<?php foreach ($errors as $e): ?>
					<li><?= htmlspecialchars($e) ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		<form method="post">
			<div class="row g-3">
				<div class="col-md-6">
					<label class="form-label">Nom</label>
					<input type="text" name="nom" class="form-control" required value="<?= htmlspecialchars($activity['nom']) ?>">
				</div>
				<div class="col-md-4">
					<label class="form-label">Date</label>
					<input type="date" name="date_activite" class="form-control" value="<?= htmlspecialchars($activity['date_activite'] ?? '') ?>">
				</div>
				<div class="col-md-4">
					<label class="form-label">Heure début</label>
					<input type="time" name="heure_debut" class="form-control" value="<?= htmlspecialchars($activity['heure_debut'] ?? '') ?>">
				</div>
				<div class="col-md-4">
					<label class="form-label">Heure fin</label>
					<input type="time" name="heure_fin" class="form-control" value="<?= htmlspecialchars($activity['heure_fin'] ?? '') ?>">
				</div>
				<div class="col-md-6">
					<label class="form-label">Capacité</label>
					<input type="number" name="capacite" class="form-control" min="0" value="<?= htmlspecialchars($activity['capacite'] ?? '0') ?>">
				</div>
				<div class="col-md-6">
					<label class="form-label">Statut</label>
					<select name="statut" class="form-select">
						<?php $s = strtolower(trim((string)($activity['statut'] ?? 'actif'))); $isActif = in_array($s, ['actif','active','1','true','oui','yes','on'], true); ?>
						<option value="actif" <?= $isActif ? 'selected' : '' ?>>Actif</option>
						<option value="inactif" <?= !$isActif ? 'selected' : '' ?>>Inactif</option>
					</select>
				</div>
				<div class="col-12">
					<label class="form-label">Description</label>
					<textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($activity['description']) ?></textarea>
				</div>
				<?php if (!empty($isAdmin) && $isAdmin): ?>
				<div class="col-md-6">
					<label class="form-label">Entraîneur</label>
					<select name="id_entraineur" class="form-select" required>
						<option value="">-- Sélectionner --</option>
						<?php foreach ($coaches as $coach): ?>
							<option value="<?= (int)$coach['id'] ?>" <?= ((int)$activity['id_entraineur'] === (int)$coach['id']) ? 'selected' : '' ?>>
								<?= htmlspecialchars($coach['prenom'] . ' ' . $coach['nom'] . ' (#' . $coach['id'] . ')') ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<?php endif; ?>
			</div>
			<div class="mt-4 d-flex gap-2">
				<button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Enregistrer</button>
				<a href="index.php?controller=activities&action=index" class="btn btn-secondary">Annuler</a>
			</div>
		</form>
	</div>
</div>


