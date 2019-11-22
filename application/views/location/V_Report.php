<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
    <h4>Location Report</h4>
  </div>
  <div class="row">
    <?php foreach ($allroute as $ar): ?>
    <div class="col-lg-3">
      <a href="<?php echo site_url('location/'.$ar->id_route); ?>">
        <div class="card" style="width: 14rem;">
        <img src="assets/img/batam.jpg" class="card-img-top" alt="card image cap">
          <div class="card-body">
            <p class="card-text">      
              <h5><?php echo "Route ".$ar->id_route; ?></h5>
              <h6><?php echo $ar->route_name; ?></h6>
             </p>
          </div>
        </div>
        <br>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
  <br><br>
</main>