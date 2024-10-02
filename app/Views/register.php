<div class="container">
	<div class="form-container">
		<h1 class="text-center">Créer un compte</h1>

		<?php if (isset($validation)): ?>
			<div class="alert alert-danger">
				<?= $validation->listErrors(); ?>
			</div>
		<?php endif; ?>

		<form method="post" action="/register">
			<div class="mb-3">
				<label for="username" class="form-label">Nom d'utilisateur</label>
				<input type="text" class="form-control" name="username" id="username" value="<?= set_value('username') ?>" required>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input type="email" class="form-control" name="email" id="email" value="<?= set_value('email') ?>" required>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Mot de passe</label>
				<input type="password" class="form-control" name="password" id="password" required>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Confirmer le mot de passe</label>
				<input type="password" class="form-control" name="password_confirm" id="password_confirm" required>
			</div>   
			<div class="text-center">
				<button type="submit" class="btn btn-primary">S'inscrire</button>
			</div>
		</form>
	</div>
</div>