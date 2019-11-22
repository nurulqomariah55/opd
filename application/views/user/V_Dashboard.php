<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
<br>
<?= $this->session->flashdata('message'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
  <h4>Dashboard</h4>
</div>
<div class="row">
  <div class="col-4">
    <?php echo $error; ?>
    <?php $dataJSON = json_encode(array_combine($day_after, $date_day_total_duration),JSON_PRETTY_PRINT); ?>
    <?php file_put_contents('assets/js/data.json', $dataJSON); ?>
    <?php $dataJSON2 = json_encode($stime,JSON_PRETTY_PRINT); ?>
    <?php file_put_contents('assets/js/stime.json', $dataJSON2); ?>
    <?php $dataJSON3 = json_encode($cdate,JSON_PRETTY_PRINT); ?>
    <?php file_put_contents('assets/js/cdate.json', $dataJSON3); ?>
  </div>
</div>
<div class="row border-bottom">
  <div class="col-4">
    <?php echo form_open_multipart(base_url('dashboard')); ?>
    <div class="custom-file">
      <input type="file" name="filepdf" class="custom-file-input" id="validatedCustomFile" required>
      <label class="custom-file-label" for="validatedCustomFile">Choose pdf file</label>
      <div class="invalid-feedback">Example invalid custom file feedback</div>
    </div>
  </div>
  <div class="col-2 ">
    <input type="submit" class="form-control btn-check" value="Check">
  </div>
</form>
<br><br><br>
</div>
<div class="font-card">
<br>
<div class="row">
  <div class="col-lg-3">
    <div class="card card-dashboard">
      <div class="card-body">
        <div class="text-left font-weight-bold">Collector No: <?php echo $collector; ?></div><br>
        <div class="text-right">Total check : <?php echo $total_check; ?>
          <br>First check : <?php echo $date_first.", ".$hour_first; ?>
        <br>Last check : <?php echo $date_last.", ".$hour_last; ?></div>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="card card-dashboard">
      <div class="card-body">
        <div class="text-left font-weight-bold">Place</div>
        <div class="text-right"> <h5><?php echo $route; ?></h5></div>
        <div class="text-left">Location 01
        <br><?php echo $location; ?> </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="card card-dashboard">
      <div class="card-body">
        <div class="text-left font-weight-bold">Standard Time/1 Time Checkpoint</div><br>
        <div class="text-center"><h3>
        <?php echo $standard_time. " min"; ?></h3></div>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="card card-dashboard">
      <div class="card-body font-weight-bold">
        <!-- Button trigger modal -->
        Highest duration on this week
        <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-toggle="modal" data-target="#modalMax">Duration : <?php echo $max_duration. " min"; ?></button>
        <!-- Modal -->
        <div class="modal fade" id="modalMax" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-detail-duration modal-content"><br>
              <div class="text-center">
                <h6 class="text-center" id="exampleModalCenterTitle">Highest duration on this week</h6>
                <div class="col-10 offset-1">
                  <hr id="hr-detail-duration">
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-6">
                    Duration : <?php echo $max_duration. " min"; ?>
                  </div>
                  <div class="col-6 text-right">
                    <?php echo $route; ?><br>
                    Collector No: <?php echo $collector; ?><br>
                    <?php if ($max_duration!="-"){
                    echo $date_shift[$max_index];
                    } ?>
                    <br><br>
                  </div>
                </div>
                <?php foreach ($data_max as $key => $dm): ?>
                <div class="row">
                  <div class="col-4 offset-1">
                    <?php echo ($key+1).". ".$dm['time_location']." ".$dm['id_location'] ?>
                  </div>
                  <div class="col-1">
                    <hr class="hr-border-detail">
                  </div>
                  <div class="col-5">
                    <?php echo $dm['name_location'] ?>
                  </div>
                </div>
                <?php endforeach ?>
              </div><br><br>
              <div class="col-12 text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
              </div>
              <br>
            </div>
          </div>
        </div>
        Lowest duration on this week
        <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-toggle="modal" data-target="#modalMin">Duration : <?php echo $min_duration. " min"; ?></button>
        <div class="modal fade" id="modalMin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-detail-duration modal-content"><br>
              <div class="text-center">
                <h6 class="text-center" id="exampleModalCenterTitle">Lowest duration on this week</h6>
                <div class="col-10 offset-1">
                  <hr id="hr-detail-duration">
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-6">
                    Duration : <?php echo $min_duration. " min"; ?>
                  </div>
                  <div class="col-6 text-right">
                    <?php echo $route; ?><br>
                    Collector No: <?php echo $collector; ?><br>
                    <?php if ($min_duration!="-"){
                    echo $date_shift[$min_index];
                    } ?>
                    <br><br>
                  </div>
                </div>
                <!-- <hr id="vertical-border-detail2"> -->
                <?php foreach ($data_min as $key => $dm): ?>
                <div class="row">
                  <div class="col-4 offset-1">
                    <?php echo ($key+1).". ".$dm['time_location']." ".$dm['id_location'] ?>
                  </div>
                  <div class="col-1">
                    <hr class="hr-border-detail">
                  </div>
                  <div class="col-5">
                    <?php echo $dm['name_location'] ?>
                  </div>
                </div>
                <?php endforeach ?>
              </div><br><br>
              <div class="col-12 text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
              </div>
              <br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br>  <br>
<div class="row">
  <div class="col-lg-9">
    <div class="card">
      <div class="col-12">
        <canvas id="myChart" width="800" height="450"></canvas>
      </div>
    </div>
    <br><br>
  </div>
  <div class="col-lg-3">
    <div class="card">
      <div class="card-body">
        <div class="text-left font-weight-bold">Daily Report </div><br>
        <?php foreach ($data_day as $day_key => $day): ?>
        <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-toggle="modal" data-target="#modal<?php echo str_replace(".","",substr($day_key, 4)); ?>"><?php echo $day_key; ?></button>
        <div class="modal fade" id="modal<?php echo str_replace(".","",substr($day_key, 4)); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-detail-duration modal-content"><br>
              <div class="text-center">
                <h6 class="text-center" id="exampleModalCenterTitle"><?php echo $day_key ?></h6>
                <div class="col-10 offset-1">
                  <hr id="hr-detail-duration">
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-6">
                  </div>
                  <div class="col-6 text-right">
                    <?php echo $route; ?><br>
                    Collector No: <?php echo $collector; ?><br>
                    <br><br>
                  </div>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <?php foreach ($day as $shift_key => $shift): ?>
                  <li class="nav-item">
                    <a class="nav-link <?php if($shift_key==0){ echo "active"; } ?>" id="shift<?php echo ($shift_key+1) ?>-tab" data-toggle="tab" href="#patrol<?php echo str_replace(".","",substr($day_key, 4)); ?>Shift<?php echo ($shift_key+1) ?>" role="tab" aria-controls="patrol<?php str_replace(".","",substr($day_key, 4)); ?>Shift<?php echo ($shift_key+1) ?>-tab" aria-selected="<?php if($shift_key==0){ echo true; }else{ echo false; } ?>">
                      <?php echo ($shift_key+1); ?>
                    </a>
                  </li>
                  <?php endforeach ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <?php foreach ($day as $shift_key => $shift): ?>
                  <div class="tab-pane fade <?php if($shift_key==0){ echo "show active"; } ?>" id="patrol<?php echo str_replace(".","",substr($day_key, 4)); ?>Shift<?php echo ($shift_key+1); ?>" role="tabpanel" aria-labelledby="shift<?php echo ($shift_key+1) ?>-tab">
                    <?php foreach ($shift as $data_shift_key => $data_shift): ?>
                    <div class="row">
                      <div class="col-4 offset-1">
                        <?php echo ($data_shift_key+1).". ".$data_shift['time_location']." ".$data_shift['id_location']?>
                      </div>
                      <div class="col-1">
                        <hr class="hr-border-detail">
                      </div>
                      <div class="col-5">
                        <?php echo $data_shift['name_location']?>
                      </div>
                    </div>
                    <?php endforeach ?>
                  </div>
                  <?php endforeach ?>
                </div>
              </div><br><br>
              <div class="col-12 text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
              </div>
              <br>
            </div>
          </div>
        </div>
        <?php endforeach ?>
        <br>
        <div class="text-left font-weight-bold"> Rounds : <?php echo $round; ?>
          <br> Checks : <?php echo $total_check; ?>
        <br> Total duration : <?php echo $total_duration; ?> </div>
      </div>
    </div>
    <br>
    <div class="col text-center">
      <button type="button" class="btn btn-save" data-toggle="modal" data-target="#modalsave"> Save File</button>
    </div>
    <!-- Button trigger modal -->
    
    <div class="modal fade" id="modalsave" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <?php if(!empty($save_file)){ ?>
        <div class="modal-detail-duration modal-content"><br>
          <div class="text-center pt-3">
            <h6 class="text-center" id="exampleModalCenterTitle">
            Are you sure want to save this file?</h6>
          </div>
          <br><br>
          <div class="text-center">
            <button type="button" class="btn btn-danger col-3" data-dismiss="modal">No</button>
            <a href="<?php echo $save_file; ?>" class="btn btn-primary col-3 offset-1">Yes</a>
          </div>
          <br>
        </div>
         <?php }else{ ?>
          <div class="modal-detail-duration modal-content"><br>
          <div class="text-center pt-3">
            <h6 class="text-center" id="exampleModalCenterTitle">
            Please upload the PDF file before clicking save button. </h6>
          </div><br>
          <div class="text-right mr-5">
            <button type="button" class="btn btn-secondary btn-sm col-2" data-dismiss="modal">OK</button>
          </div>
          <br>
        </div>
         <?php } ?>
      </div>
    </div>
    <!-- Modal -->
  </div>
</div>
</div>
</main>
</div>
</div>