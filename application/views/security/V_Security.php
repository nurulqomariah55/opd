<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
    <h4>Security Schedule</h4>
  </div>
  <br>
  <div class="table-responsive">
  <table class="table table-striped table-sm" id="security">
    <thead>
      <tr>
        <th scope="col"> Patrol Date</th>
        <th scope="col">Route</th>
        <th scope="col">Variant</th>
        <th scope="col">action</th>
      </tr>
    </thead>
     <tbody>
    <?php foreach ($list as $key ): ?>
      <tr>
        <td><?php echo $key->patrol_date; ?></td>
        <td><?php echo $key->id_route; ?></td>
        <td><?php echo $key->id_schedule; ?></td>
        <td><a class="btn-security" data-toggle="modal" data-patrol_date="<?php echo str_replace(" ", "_", $key->patrol_date); ?>" data-target="#modalSecurity" href="#">detail</a>
       </tr>
    <?php endforeach ?>
    <div class="modal fade" id="modalSecurity" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-detail-duration modal-content"><br>
    <div class="text-center">
      <h6 class="text-center" id="exampleModalCenterTitle">Security Schedule</h6>
      <div class="col-10 offset-1">
        <hr id="hr-detail-duration">
      </div>
    </div>
    <div id="detailSecurity"></div>
    <br>
    <div class="col-2 offset-9">
        <button type="button" class="btn btn-secondary form-control btn-sm" data-dismiss="modal">OK</button>
    </div>
    <br>
  </div>
</div>
</div>
    </tbody>
  </table>
</div>
</main>