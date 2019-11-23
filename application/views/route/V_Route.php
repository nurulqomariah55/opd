<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
    <h4>Setting - Routes</h4>
  </div>
  <?= $this->session->flashdata('message'); ?>
  <?php echo form_open(base_url('route/list')); ?>
  <div class="row">
    <div class="form-group col-4 ">
      <input type="input" name="id_route" class="form-control btn-sm" id="idroute" aria-describedby="idroute" placeholder="ID Route">
       <?php echo form_error("id_route"); ?>
    </div>
    <div class="form-group col-4">
      <input type="input" name="route_name" class="form-control btn-sm" id="routename" placeholder="Route Name">
       <?php echo form_error("route_name"); ?>
    </div>
    <div class="form-group col-2">
      <input type="input" name="standard_time" class="form-control btn-sm" id="standardtime" placeholder="Standard Time (min.)">
       <?php echo form_error("standard_time"); ?>
    </div>
    <div class="col-2">
      <button type="submit" name="submit" value="add route" class="form-control btn btn-primary btn-sm">Add Route</button>
    </div>
  </div>
</form> 
<br>
<div class="table-responsive">
  <table class="table table-striped table-sm" id="route">
    <thead>
      <tr>
        <th scope="col"> ID Route</th>
        <th scope="col"> Route Name</th>
        <th scope="col"> Standard Time (minutes)</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
     <tbody>
    <?php foreach ($show as $key ): ?>
      <tr>
        <td><?php echo $key->id_route; ?></td>
        <td><?php echo $key->route_name; ?></td>
        <td><?php echo $key->standard_time; ?></td>
        <td><a href="<?php echo base_url("route/edit/$key->id_route"); ?>" data-toggle="modal" data-target="#modalEdit<?php echo $key->id_route; ?>">Edit</a>
        <div class="modal fade" id="modalEdit<?php echo $key->id_route; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-detail-duration modal-content"><br>
              <div class="text-center">
                <h6 class="text-center" id="exampleModalCenterTitle">Route</h6>
                <div class="col-10 offset-1">
                  <hr id="hr-detail-duration">
                </div>
              </div>
              <form action="<?php echo base_url("route/edit/$key->id_route"); ?>" method="post">
                <div class="modal-body">
                  <div class="row justify-content-center">
                    <div class="form-group col-5">
                      <label for="ID_Route"> ID Route </label>
                      <input type="input" name="id_route" value="<?php echo $key->id_route; ?>"class="form-control" id="idroute" aria-describedby="idroute" placeholder="ID Route">
                    </div>
                    <div class="form-group col-5">
                      <label for="Route_Name">Route Name</label>
                      <input type="input" name="route_name" value="<?php echo $key->route_name; ?>" class="form-control" id="routename" placeholder="Route Name">
                    </div>
                     <div class="form-group col-5">
                      <label for="Route_Name">Standard Time (minutes)</label>
                      <input type="input" name="standard_time" value="<?php echo $key->standard_time; ?>" class="form-control" id="standardtime" placeholder="Standard Time">
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
        <a href="#" data-toggle="modal" data-target="#modalDelete<?php echo $key->id_route; ?>">Delete</a></td>
        <div class="modal fade" id="modalDelete<?php echo $key->id_route; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-detail-duration modal-content"><br>
              <div class="text-center pt-3">
                <h6 class="text-center" id="exampleModalCenterTitle">
                Are you sure want to delete this data?</h6>
              </div>
              <br><br>
              <div class="text-center">
                <button type="button" class="btn btn-secondary col-3" data-dismiss="modal">Cancel</button>
                <a href="<?php echo base_url("route/delete/$key->id_route"); ?>" class="btn btn-danger col-3 offset-1">Delete</a>
              </div>
              <br>
            </div>
          </div>
        </div>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>
</div>
<!-- Modal -->
<br><br>
</main>