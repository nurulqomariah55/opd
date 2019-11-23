<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
    <h4>Setting - Employees</h4>
  </div>
  <?= $this->session->flashdata('message'); ?>
  <?php echo form_open(base_url('employee/list')); ?>
  <div class="row">
    <div class="form-group col-5 ">
      <input type="input" name="no_badge" class="form-control btn-sm" id="NoBadge" aria-describedby="nobadge" placeholder="No Badge">
      <?php echo form_error("no_badge"); ?>
    </div>
    <div class="form-group col-5">
      <input type="input" name="name" class="form-control btn-sm" id="Name" placeholder="Name">
      <?php echo form_error("name"); ?>
    </div> 
    <div class="col-2">
      <button type="submit" name="submit" value="add employee" class="form-control btn btn-primary btn-sm">Add Employee</button>
    </div>
  </div>
</form> 
<br>
<div class="table-responsive">
  <table class="table table-striped table-sm" id="employee">
    <thead>
      <tr>
        <th scope="col"> No Badge</th>
        <th scope="col"> Name</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
     <tbody>
    <?php foreach ($show as $key ): ?>
      <tr>
        <td><?php echo $key->no_badge; ?></td>
        <td><?php echo $key->name; ?></td>
        <td><a href="<?php echo base_url("employee/edit/$key->no_badge"); ?>" data-toggle="modal" data-target="#modalEdit<?php echo $key->no_badge; ?>">Edit</a>
        <div class="modal fade" id="modalEdit<?php echo $key->no_badge; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-detail-duration modal-content"><br>
              <div class="text-center">
                <h6 class="text-center" id="exampleModalCenterTitle">Security Employee</h6>
                <div class="col-10 offset-1">
                  <hr id="hr-detail-duration">
                </div>
              </div>
              <form action="<?php echo base_url("employee/edit/$key->no_badge"); ?>" method="post">
                <div class="modal-body">
                  <div class="row justify-content-center">
                    <div class="form-group col-5">
                      <label for="NoBadge"> No Badge </label>
                      <input type="text" name="no_badge" value="<?php echo $key->no_badge; ?>"class="form-control" id="NoBadge" aria-describedby="NoBadge" placeholder="No Badge">
                    </div>
                    <br>
                    <div class="form-group col-5">
                      <label for="Name">Employee Name</label>
                      <input type="text" name="name" value="<?php echo $key->name; ?>" class="form-control" id="Name" placeholder="Name">
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
        <a href="#" data-toggle="modal" data-target="#modalDelete<?php echo $key->no_badge; ?>">Delete</a></td>
        <div class="modal fade" id="modalDelete<?php echo $key->no_badge; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-detail-duration modal-content"><br>
              <div class="text-center pt-3">
                <h6 class="text-center" id="exampleModalCenterTitle">
                Are you sure want to delete this data?</h6>
              </div>
              <br><br>
              <div class="text-center">
                <button type="button" class="btn btn-secondary col-3" data-dismiss="modal">Cancel</button>
                <a href="<?php echo base_url("employee/delete/$key->no_badge"); ?>" class="btn btn-danger col-3 offset-1">Delete</a>
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