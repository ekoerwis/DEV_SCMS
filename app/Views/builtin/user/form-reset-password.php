<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title.' : '.$user->ID_USER .' - '.$user->USERNAME?></h5>
	</div>
	<div class="card-body">
		<?php
		if (!empty($msg)) {
			show_message($msg);
		}
		?>
		<form method="post" action="" class="form-horizontal">
			<div class="tab-content" id="myTabContent">
				<!-- <div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Password Lama</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="password" name="password_old" required="required"/>
					</div>
				</div> -->
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">ID User</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="id" value="<?= $user->ID_USER ?>" required="required" readonly/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Username</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="username" value="<?= $user->USERNAME ?>" required="required" readonly/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Password Baru</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="password" name="password_new" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Ulangi Password Baru</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="password" name="password_new_confirm" required="required"/>
					</div>
				</div>
				<div class="form-group row mb-0">
					<div class="col-sm-8">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>