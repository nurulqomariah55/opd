<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute; width:200%;height:200%;left:0; top:0"></div></div></div>
<?php if($route_location[0]->id_route=='None'){
	echo "<br><h6>There is no data for Route ".$this->uri->segment(2)." yet, use dashboard and save the file to see the data.</h6>";
}else{ ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3"><h6>Location Report -
	<?php echo "Route ".$route_location[0]->id_route ?>, Batamindo Industrial Park</h6>
</div>
<div class="font-size-15">
	<div class="row">
		<div class="col-2 border-right">
			<form>
				<div id="SearchDate">
					<input type="text" class="typeahead form-control shadow" placeholder="Search date">
				</div>
				<br>
				<?php foreach ($date_location as $key => $dl){ ?>
				<div class="col-12 text-center">
					<?php $date1= new DateTime($dl->first_check); ?>
					<a class="btn btn-primary <?php if($date1->diff(new DateTime($this->uri->segment(3)))->format('%R%a')>=0 && (int)$date1->diff(new DateTime($this->uri->segment(3)))->format('%R%a')<(int)$count_perId[$key]->time_location) echo "active";  ?> btn-date shadow"  href="<?php echo site_url('location/'.$dl->id_route.'/'.date('d-m-Y',strtotime($dl->first_check))); ?>">
					<?php echo date('d-m-Y',strtotime($dl->first_check)); ?></a>
				</div><br>
				<?php } ?>
			</form>
		</div>
		<div class="col-10">
			<div class="row">
				<?php foreach ( $date_perday as $dpd){ ?>
				<div class="col-2 text-center">
					<a class="btn btn-primary <?php if((date('d-m-Y',strtotime($dpd->time_location))==$this->uri->segment(3)) || ($min_date && date('d-m-Y',strtotime($dpd->time_location))==$min_date) && !$this->uri->segment(3)){echo "active"; } ?> btn-date shadow"  href="<?php echo site_url('location/'.$route_location[0]->id_route.'/'.date('d-m-Y',strtotime($dpd->time_location))); ?>">
					<?php echo date('l<\b\r/> d-m-Y',strtotime($dpd->time_location)); ?></a>
				</div>
				<?php } ?>
			</div><br>
			<div class="row">
				<div class="col-10">
					<canvas id="locationChart" width="1000" height="600"></canvas>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-10">
					<div class="card card-detail text-center">
						<div class="card-header">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<?php foreach ( $shift_perday as $key => $spd){ ?> <!-- <?php if($spd->shift==1){ echo "pr-0"; }else if(sizeof($shift_perday)==$spd->shift){ echo "pl-0"; }else{ echo "pr-0 pl-0"; } ?> -->
								<li class="nav-item">
									<a class="nav-link <?php if($spd->shift==1) echo "active"; ?>" id="home-tab" data-toggle="tab" href="#shift<?php echo $spd->shift ?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $spd->shift; ?></a>
								</li>
								<?php } ?>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="myTabContent">
								<?php foreach ($min_max_timeshift as $minmax_key => $mm): ?>
								<div class="tab-pane fade <?php if($minmax_key==0){ echo "show active"; } ?>" id="shift<?php echo $mm->shift; ?>" role="tabpanel" aria-labelledby="home-tab">
									<?php $interval = (new DateTime($min_max_timeshift[$minmax_key]->max))->diff(new DateTime($min_max_timeshift[$minmax_key]->min));
										$minutes = (int)$interval->days * 24 * 60;
										$minutes += (int)$interval->h * 60;
										$minutes += (int)$interval->i;
									echo "<h6 class=text-left>Duration: ". $minutes." min.</h6>"; ?> <br>
									<div class="row">
										<div class="col-3 font-weight-bold">
											Id Location
										</div>
										<div class="col-1">
											
										</div>
										<div class="col-5 font-weight-bold">
											Location Name
										</div>
										<div class="col-2 font-weight-bold">
											Interval
										</div>
									</div>
									<?php $count=1; $countPerShift=1;  $max=array_fill(0, sizeof($min_max_timeshift), 0);
									// var_dump($max);
									foreach ( $data_pershift as $dps_key => $dps):
											if($dps->shift==$mm->shift){
												if($dps->shift>$countPerShift){
													$countPerShift=$dps->shift;
													$count=1;
												}
												if($dps_key==0 || $count==1 || date('H:i',strtotime($dps->time_location))==date('H:i',strtotime($data_pershift[$dps_key-1]->time_location))){
													// var_dump($dps_key);
													// var_dump($count);
													// $var_dump()
													// continue;
												}else if($dps_key>0  && date('H:i',strtotime($dps->time_location))>date('H:i',strtotime($data_pershift[$dps_key-1]->time_location))){
														$inval = (new DateTime($data_pershift[$dps_key-1]->time_location))->diff(new DateTime($dps->time_location));
												$minutes = (int)$inval->days * 24 * 60;
												$minutes += (int)$inval->h * 60;
												$minutes += (int)$inval->i;
												$temp = [$minutes, $max[$countPerShift-1]];
												$max[$countPerShift-1]= max($temp);
												// var_dump($temp);
												// var_dump($max);
												} 
												$count++;
										}
									endforeach;
									// var_dump($max); echo"<br>";
									$count=1; $countPerShift=1;
									foreach ( $data_pershift as $dps_key => $dps):
											if($dps->shift==$mm->shift){
												if($dps->shift>$countPerShift){
													$countPerShift=$dps->shift;
													$count=1;
												} ?>
									<br>
									<div class="row">
										<div class="col-3">
											<?php echo ($count).". ".date('H:i',strtotime($dps->time_location))." ".$dps->id_location; ?>
										</div>
										<div class="col-1">
											<hr class="hr-border-detail">
										</div>
										<div class="col-5">
											<?php echo $dps->location_name; 
											?>
										</div>
										<div class="col-2">
											<?php if($dps_key==0 || $count==1 || date('H:i',strtotime($dps->time_location))==date('H:i',strtotime($data_pershift[$dps_key-1]->time_location))){ ?>	
												<div class="card bg-info text-white"> 
													0 min
												</div>
											<?php }else if($dps_key>0  && date('H:i',strtotime($dps->time_location))>date('H:i',strtotime($data_pershift[$dps_key-1]->time_location))){
														$inval = (new DateTime($data_pershift[$dps_key-1]->time_location))->diff(new DateTime($dps->time_location));
												$minutes = (int)$inval->days * 24 * 60;
												$minutes += (int)$inval->h * 60;
												$minutes += (int)$inval->i;

												if($minutes==$max[$countPerShift-1]){ ?>

													<div class="card bg-danger text-white"> 
														<?php echo $minutes." min."; ?>
													</div>
											<?php }
												else { ?>
													<div class="card bg-info text-white"> 
														<?php echo $minutes." min."; ?>
													</div>
											<?php }
											} ?> 
										</div>
									</div><br>
									<?php $count++; } ?>
									<?php endforeach; ?>

								</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br><br><br><br>
		</div>
	</div>
</div>
<?php } ?>
</main>