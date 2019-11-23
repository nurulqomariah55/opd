<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
		<h4>Setting - Schedules</h4>
	</div>
	<?= $this->session->flashdata('message'); ?>
	<?php echo form_open(base_url('schedule/list')); ?>
	<div class="row">
		<div class="col-5 border-right">
			<div class="row">
				<div class="col-11">
					<select class="form-control btn-sm" name="id_route">
						<option disabled selected>Choose route name</option>
						<?php foreach ($route as $r): ?>
						<option value="<?php echo $r->id_route; ?>"><?php echo "Route $r->id_route, $r->route_name" ?></option>
						<?php endforeach ?>
					</select>
					<?php echo form_error('id_route'); ?>
					<br>
				</div>
			</div>
			<div class="row after-add-loc">
				<div class="col-10">
					<div class="form-group">
						<select name="id_location[]" class="form-control btn-sm">
							<option disabled selected value="">Add location</option>
							<?php foreach ($location as $key) : ?>
							<option value="<?php echo $key->id_location; ?>"><?php echo "$key->id_location -  $key->location_name" ?></option>
							<?php endforeach ?>
						</select>
					<?php echo form_error('id_location[]'); ?>
					</div>
				</div>
				<div class="col-2 text-left p-0">
					<button type="button" class="btn btn-primary btn-sm btn-add-loc">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
				</button>
			</div>
		</div>
		<div class="copy-input-a d-none">
			<div class="row control-group">
				<div class="col-10">
					<div class="form-group">
						<select name="id_location[]" class="form-control btn-sm">
							<option value="" disabled selected>Add location</option>
							<?php foreach ($location as $key) : ?>
							<option value="<?php echo $key->id_location; ?>"><?php echo "$key->id_location -  $key->location_name" ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="col-2 text-left p-0">
					<button type="button" class="btn btn-danger btn-sm btn-remove-loc">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
				</button>
			</div>
		</div>
	</div>
	<div class="col-5 float-right">
		<input type="submit" class="form-control btn-save btn-sm" value="Add Schedule">
	</div>
</form>
</div>
<div class="col-7">
<div class="table-responsive">
	<table class="table table-striped table-sm" id="route">
		<thead>
			<tr>
				<th scope="col">Route</th>
				<th scope="col">Varian</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($schedule as $key):?>
			<tr>
				<td><?php echo $key->id_route; ?></td>
				<td><?php echo $key->id_schedule; ?></td>
				<td><a href="#" class="btn-edit" data-id_route="<?php echo $key->id_route ?>" data-id_schedule="<?php echo $key->id_schedule ?>" data-toggle="modal" data-target="#modalEdit">Edit</a>
				<a href="#" data-toggle="modal" data-target="#modalDelete<?php echo "$key->id_route-$key->id_schedule"; ?>">Delete</a></td>
				<div class="modal fade" id="modalDelete<?php echo "$key->id_route-$key->id_schedule"; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-detail-duration modal-content"><br>
							<div class="text-center pt-3">
								<h6 class="text-center" id="exampleModalCenterTitle">
								Are you sure want to delete this schedule? 
								<br><br>All the following <strong>related items</strong> will be <strong>deleted.</strong></h6>
							</div>
							<br><br>
							<div class="text-center">
								<button type="button" class="btn btn-secondary col-3" data-dismiss="modal">Cancel</button>
								<a href="<?php echo base_url("schedule/delete/$key->id_route/$key->id_schedule"); ?>" class="btn btn-danger col-3 offset-1">Delete</a>
							</div>
							<br>
						</div>
					</div>
				</div>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
</div>
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-detail-duration modal-content"><br>
		<div class="text-center">
			<h6 class="text-center" id="exampleModalCenterTitle">Schedule</h6>
			<div class="col-10 offset-1">
				<hr id="hr-detail-duration">
			</div>
		</div>
		<form method="post" id="editForm">
			<div class="modal-body">
				<div class="row" id="editModalContent">
					<div class="form-group col-10 offset-1">
						<label for="ID_Route">  Route </label>
						<input type="input" name="id_route" value=""class="form-control" id="idroute" aria-describedby="idroute" placeholder="Route">
					</div>
					<div class="form-group col-10 offset-1">
						<label for="Route_Name">Varian</label>
						<input type="input" name="id_schedule" value="" class="form-control" id="varian" placeholder="Varian">
					</div>
					<div class="d-none copy-input-sch">
						<div class="col-10 offset-1 control-group form-group">
							<div class="row">
								<div class="col-10">
									<label for="Route_Name">Location Name</label>
									<select name="id_location[]" class="form-control">
										<option value="" disabled selected>Add location</option>
										<?php foreach ($location as $key) : ?>
										<option value="<?php echo $key->id_location; ?>"><?php echo "$key->id_location -  $key->location_name" ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="col-2">
									<label for="Route_Name" class="invisible">Name</label>
									<button type="button" class="btn btn-danger btn-sm btn-remove-modal-schedule">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div><br>
			<div class="text-center">
				<button type="button" class="btn btn-secondary col-3" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-primary col-3 offset-1" value="Update">Update</button>
			</div>
		</form>
		<br>
	</div>
</div>
</div>
</main>