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
      </tr>
    </thead>
     <tbody>
    <?php foreach ($list as $key ): ?>
      <tr>
        <td><?php echo $key->patrol_date; ?></td>
        <td><?php echo $key->id_route; ?></td>
        <td><?php echo $key->id_schedule; ?></td>
       </tr>
    <?php endforeach ?>
    </tbody>
  </table>
</div>
</main>