<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
    <h4>Checkpoint Schedule</h4>
  </div>
  <?= $this->session->flashdata('message'); ?>
  <br>
  <div class="row">
    <div class="col-5 border-right">
      <div class="card card-patrol">
        <div class="card-body">
          <div class="float-left font-weight-bold">Date :</div>
          <div class="float-right"><?php date_default_timezone_set('Asia/Jakarta');
          echo date('l, d F Y H:i')." WIB";?> <br></div>
        </div>
      </div>
      <br>
      <?php echo form_open(base_url('security')); ?>
      <div class="row">
      <div class="col-12">
      <select class="form-control btn-sm" required name="route">
        <option disabled selected>Choose route name</option>
        <?php foreach ($route as $r): ?>
        <option value="<?php echo $r->id_route; ?>"><?php echo "Route $r->id_route, $r->route_name" ?></option>
        <?php endforeach ?>
      </select>
          <?php echo form_error("route"); ?> 
      </div>
    </div>
      <br>
      <div class="row after-add-sec">
        <div class="col-10">
          <div class="form-group">
            <select class="form-control btn-sm" required name="employee[]">
              <option disabled selected>Choose security name</option>
              <?php foreach ($employee as $e): ?>
              <option value="<?php echo $e->no_badge."-".$e->name; ?>"><?php echo "$e->no_badge - $e->name" ?></option>
              <?php endforeach ?>
            </select>
           <?php echo form_error("employee[]"); ?>
          </div>
        </div>
        <div class="col-2 text-left p-0">
          <button type="button" class="btn btn-primary btn-sm btn-add-sec">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </button>
      </div>
    </div>
    <div class="copy-input-sec d-none">
      <div class="row control-sec">
        <div class="col-10">
          <div class="form-group">
            <select class="form-control btn-sm" required name="employee[]">
              <option disabled selected>Choose security name</option>
              <?php foreach ($employee as $e): ?>
              <option value="<?php echo $e->no_badge."-".$e->name; ?>"><?php echo "$e->no_badge - $e->name" ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="col-2 text-left p-0">
          <button type="button" class="btn btn-danger btn-sm btn-remove-sec">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </button>
      </div>
    </div>
  </div>
  <input type="hidden" name="patrol_date" value="<?php echo date('Y-m-d H:i:s') ?>">
  <br>
  <input type="submit" class="form-control btn-schedule btn-sm col-5 float-right" value="Generate Schedule">
</div>
<div class="col-7">
  <div class="card" id="schedule">
    <div class="card-body">
      <div class="float-left font-weight-bold"><h5>Route <?php echo $var_route[0]->id_route; ?></h5><br>  <h6>Security name : </h6>
        <?php foreach($security as $s): ?>
        <?php echo $s."<br>"; ?>
        <?php endforeach; ?>
        <br>
      </div>
      <div class="float-right"><?php date_default_timezone_set('Asia/Jakarta');
      echo date('l, d F Y H:i')." WIB" ?> <br></div>
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col"> ID Location</th>
            <th scope="col"> Location Name</th>
          </tr>
        </thead>
        <?php foreach ($schedule as $s ): ?>
        <tbody>
          <tr>
            <td><?php echo $s->id_location; ?></td>
            <td><?php echo $s->location_name; ?></td>
          </tr>
        </tbody>
        <?php endforeach ?>
      </table>
    </div>
  </div>
  <br>
  <div class="text-center">
    <button onclick="Print('schedule')"type="button" class="col-5 btn btn-info btn-sm" >Print</button>
    <br><br><br><br>
    <script type="text/javascript">
    function Print(schedule){
    var backup = document.body.innerHTML;
    var divcontent = document.getElementById(schedule).innerHTML;
    document.body.innerHTML = divcontent;
    window.print();
    document.body.innerHTML = backup;
    }
    </script>
  </div>
</div>
</div>
</main>