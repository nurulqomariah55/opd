<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
    <h4>Setting - Locations </h4>
  </div>
  <?= $this->session->flashdata('message'); ?>
  <?php echo form_open('location/list'); ?>
  <div class="row">
    <div class="form-group col-5">
      <input type="number" name="id_location" class="form-control btn-sm" id="idlocation" aria-describedby="idlocation" placeholder="ID Location">
       <?php echo form_error("id_location"); ?> 
    </div>
    <div class="form-group col-5">
      <input type="text" name="location_name" class="form-control btn-sm" id="locationname" placeholder="Location Name">
      <?php echo form_error("location_name"); ?>
    </div>
    
    <div class="col-2">
      <button type="submit" name="submit" value="add location" class="form-control btn btn-primary btn-sm">Add Location</button>
    </div>
  </div>
</form>
<br>
<div class="table-responsive">
  <table class="table table-striped table-sm table" id="location">
    <thead>
      <tr>
        <th scope="col"> ID Location</th>
        <th scope="col"> Location Name</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($display as $key ): ?>
      <tr>
        <td><?php echo $key->id_location; ?></td>
        <td><?php echo $key->location_name; ?></td>
        <td><a href="<?php echo base_url("location/edit/$key->id_location"); ?>" data-toggle="modal" data-target="#modalEdit<?php echo $key->id_location; ?>">Edit</a>
        <a href="#" data-toggle="modal" data-target="#modalDelete<?php echo $key->id_location; ?>">Delete</a></td>
      </tr>
      <div class="modal fade" id="modalDelete<?php echo $key->id_location; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-detail-duration modal-content"><br>
            <div class="text-center pt-3">
              <h6 class="text-center" id="exampleModalCenterTitle">
              Are you sure want to delete this data?</h6>
            </div>
            <br><br>
            <div class="text-center">
              <button type="button" class="btn btn-secondary col-3" data-dismiss="modal">Cancel</button>
              <a href="<?php echo base_url("location/delete/$key->id_location"); ?>" class="btn btn-danger col-3 offset-1">Delete</a>
            </div>
            <br>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modalEdit<?php echo $key->id_location; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-detail-duration modal-content"><br>
            <div class="text-center">
              <h6 class="text-center" id="exampleModalCenterTitle">Location</h6>
              <div class="col-10 offset-1">
                <hr id="hr-detail-duration">
              </div>
            </div>
            <form action="<?php echo base_url("location/edit/$key->id_location"); ?>" method="post">
              <div class="modal-body">
                <div class="row justify-content-center">
                  <div class="form-group col-5">
                    <label for="ID_location"> ID location </label>
                    <input type="input" name="id_location" value="<?php echo $key->id_location; ?>" class="form-control btn-sm" id="idlocation" aria-describedby="idlocation" placeholder="ID Location">
                  </div>
                  <div class="form-group col-5">
                    <label for="Location_Name">Location Name</label>
                    <input type="input" name="location_name" value="<?php echo $key->location_name; ?>" class="form-control btn-sm" id="locationname" placeholder="Location Name">
                  </div>
                </div>
              </div><br>
              <div class="text-center">
                <button type="button" class="btn btn-secondary col-3" data-dismiss="modal">Cancel </button>
                <button type="submit" class="btn btn-primary col-3 offset-1" value="Update">Update</button>
              </div>
            </form>
            <br>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<br><br>
</main>