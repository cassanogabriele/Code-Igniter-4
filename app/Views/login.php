<div class="container mt-5">
	<div class="form-container">
		<h1 class="text-center">Se connecter</h1>

		<?php if (isset($error)): ?>
			<div class="alert alert-danger">
				<?= $error ?>
			</div>
		<?php endif; ?>

		<form action="/login" method="post">
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Mot de passe</label>
				<input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-primary">Se connecter</button>
			</div>
		</form>
	</div>
</div>