<?php if (count($errors)> 0) { ?>
	<div class="formContainerError">
		<h4>There were <?= count($errors) ?> error(s) in the form. They are:</h4>
		<ul>
			<?php foreach($errors as $error){ ?>
				<li><?php echo $error . "<br>"; ?></li>
			<?php }?>
		</ul>
	</div>
<?php } ?>	

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-horizontal">
	<h4>Personal Details</h4>
	<div class="form-group">
		<label for="name" class="col-md-4 control-label">Name: *</label>
		<div class="col-md-8">
			<input type="text" name="name" class="form-control" id="name" value="<?= $name; ?>">
		</div>
	</div>
	<div class="form-group">
			<label for="faculty_id" class="col-md-4 control-label">Faculty: *</label>
			<div class="col-md-8">
				<select name="faculty_id" class="form-control" id="faculty_id">
				  <option value="">Faculty selection:</option>
				  <?php foreach($faculty_names as $row) { ?>
					<option value="<?= $row['id']; ?>" <?php if($row["id"] == $faculty_id ){ ?> selected="selected" <?php } ?>>
						<?= $row['name']; ?>
					</option>
				  <?php } ?>
				</select>

			</div>
	</div>
	<div class="form-group">
			<label for="department_id" class="col-md-4 control-label">Department: *</label>
			<div class="col-md-8">
				<select name="department_id" class="form-control" id="department_id">
				 <option value="">Department selection:</option>
				</select>
			</div>
	</div>
	<div class="form-group">
		<label for="username" class="col-md-4 control-label">Username: * </label>
		<div class="col-md-8">
			<input type="text" name="username" class="form-control" id="username" value="<?= $username; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="email" class="col-md-4 control-label">Email: *</label>
		<div class="col-md-8">
			<input type="text" name="email" class="form-control" id="email" value="<?= $email; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="phone" class="col-md-4 control-label">Phone:</label>
		<div class="col-md-8">
			<input type="text" name="phone" class="form-control" id="phone" value="<?= $phone; ?>">
		</div>
	</div>
	<h4>Roles</h4>
	<p>
		Select the role you would like access to from the list below.
		If you need further details on which role is suitable for you, please see the myTeam Capability Profiles page.
	</p>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?php foreach($role_names as $row) { ?>
				<div class="checkbox">
						<label>
							<input type="checkbox" name="roles[]" id="roles[]" value="<?= $row['id']; ?>" 
								<?php if (isset($rolesArray) && in_array($row['id'] , $rolesArray)) { ?> checked = "checked" <?php } ?>>			
								<?= $row['name']; ?>
						</label>
				</div>		
			<?php } ?>
		</div>
	</div>
	<h4>Further Information</h4>  
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<textarea name="further_info" id="further_info" class="form-control" rows="5">
				<?= $further_info; ?>
			</textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-10">
		 <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
		</div>
	</div>
</form>		
			