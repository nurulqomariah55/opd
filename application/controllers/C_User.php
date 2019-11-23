 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

  use Spatie\PdfToText\Pdf;

class C_User extends CI_Controller 
{
  public function __construct()
  {    
    parent::__construct();
  }

  public function index()
  {
    $data['title'] ='Dashboard';
    $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();
    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'pdf';
    $data['date_first']="-";
    $data['hour_first']="-";
    $data['collector']="-";
    $data['date_last']="-";
    $data['hour_last']="-";
    $data['location']="-";
    $data['route']="-";
    $data['total_check']="-";
    $data['total_duration']="-";
    $data['round']="-";
    $data['time_location']="-";
    $data['id_location']="-";
    $data['checkpoint']=array();
    $data['date_day']=array();
    $data['data_day']=array();
    $data['day_after']=array();
    $data['date_day_total_duration']=array();
    $data['max_duration']="-";
    $data['min_duration']="-";
    $data['standard_time']="-";
    $data['max_index']=null;
    $data['min_index']=null;
    $data['data_max']=array();
    $data['data_min']=array();
    $data['date_shift']=array();
    $data['stime']=array();
    $data['cdate']=array();
    $data['save_file']= "";


    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('filepdf'))
    {
            $data['error'] = $this->upload->display_errors();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('user/V_Dashboard', $data);
            $this->load->view('templates/footer', $data);
    }
    else
    {
            $filename = $this->upload->data('file_name');
            $this->showData($filename);
    }
  }

  public function showData($filename)
  {
    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile(base_url("uploads/$filename"));
    $text = $pdf->getText();
    $pdfText= nl2br($text);
    $textPerLine = explode("\n", $pdfText);
    $duration= array();
    $data['round'] = 0;
    $data['total_duration'] = 0;
    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'pdf';
    $duration=array();
    $data['date_shift']=array();
    $data['start']=array();
    $data['finish']=array();
    $data['date_day_duration']=array_fill(0, 15, 0);
    $count_date=0;
    $this->load->library('upload', $config);
    foreach($textPerLine as $key => $textAsli)
    {
      //Ambil tgl first check
        if(preg_match('/(\bFirst\s+[a-z]+\b):\s+(\d{2}.\d{2}.\d{4}),\s+(\d{2}:\d{2})\s+/', $textAsli, $matches)){
          $data['date_first']=$matches[2];
          $data['hour_first']=$matches[3]; 
        }else if(preg_match('/(\bLast\s+[a-z]+\b):\s+(\d{2}.\d{2}.\d{4}),\s+(\d{2}:\d{2})\s+/', $textAsli, $matches)){          
          $data['date_last']=$matches[2];
          $data['hour_last']=$matches[3];
        }else if(preg_match('/(\bCollector\s+[a-z]+\b.):\s+(\d{4,5})\s+(\bTotal\s+[a-z]+\b):\s+(\d{3,4})\s+/', $textAsli, $matches)){
          $data['collector']=$matches[2];
          $data['total_check']=$matches[4];
        }else if(preg_match('/(\bLocation\s+\d{2}\b,)\s+([a-zA-Z\s]+)\s+/', $textAsli, $matches)){
          $data['location']=$matches[2]." Park";
        }else if(preg_match('/([A-Z][a-z])\s+(\d{2}.\d{2}.\d{4})/', $textAsli, $matches)){
           $data['date_day'][]=$matches[1].", ".$matches[2];
           $day_before[]=explode(".",$matches[2]);
        }else if(preg_match('/(\d{2}.\d{2}.\d{4})\s(\bRound\s[0-9]\b,)\s(Route\s[A-Z]).*,\s(Duration:)\s(\d{2,3})\s([a-z]+)/', $textAsli, $matches)){
          $data['date_shift'][]=$matches[1];
          if(substr($data['date_day'][$count_date], 4)==$matches[1]){
            $data['date_day_duration'][$count_date]+=1;  
          }else if(substr($data['date_day'][++$count_date], 4)==$matches[1]){
            $data['date_day_duration'][$count_date]+=1;
          }
          $data['route']=$matches[3];
          $duration[]=$matches[5];
          $data['round']++;
        }else if(preg_match('/(\d{1,}).\s+(\d{2}:\d{2})\s+(\d{8})\s+([\w \(\)\-\/]+)/', $textAsli, $matches)){
            $data['time_location'][]=$matches[2];
            $data['id_location'][]= $matches[3];
            $data['name_location'][]=$matches[4];
            
          if((sizeof($data['id_location'])>1 && $data['id_location'][count($data['id_location'])-2]!=$matches[3]) || (sizeof($data['id_location'])==1 && end($data['id_location'])==$matches[3])){
            if(strpos($matches[4], "Start")!== false){
            }else if(strpos($matches[4], "Finish")!== false){              
              $data['id_finish']=$matches[3];
            }
          }else if(sizeof($data['id_location'])>1 && $data['id_location'][count($data['id_location'])-2]==$matches[3]){
            array_pop($data['time_location']);
            array_pop($data['id_location']);
            array_pop($data['name_location']);
          }
        }else if(preg_match('/Start/', $textAsli, $matches)) {
            if(preg_match('/(\d{1,}).\s+(\d{2}:\d{2})\s+(\d{8})\s([a-zA-Z]*\s[a-zA-Z]*\s.*)/', $textPerLine[$key-1], $matches)){
                // $data['start']=$textPerLine[$key-1];
              }
        }else if(preg_match('/([\(\w\)]+)\sFinish/', $textAsli, $matches)){
            if(preg_match('/(\d{1,}).\s+(\d{2}:\d{2})\s+(\d{8})\s([a-zA-Z]*\s[a-zA-Z]*\s.*)/', $textPerLine[$key-1], $matches)){ 
            $data['id_finish']=$matches[3];
          }
        }    
      }
      $count_date_divider=0;
      $day_idx=array();
      $data['date_day_total_duration']=array_fill(0, sizeof($data['date_day']), 0);
      //data perhari
          for ($i=0; $i < sizeof($data['date_day']); $i++) {
            //durasi perhari
            for ($j=0; $j < $data['date_day_duration'][$i]; $j++) { 
              //untuk menjumlahkan durasi perhari
              $data['date_day_total_duration'][$i]+=$duration[$count_date_divider];
              $day_index[$i][]=$count_date_divider++;
            }
          } 
          //ambiltotal shift dlm satu hari
          foreach ($day_index as $key => $idt) {
            $day_idx[]=sizeof($idt);
          }

          //hari pada data chart
            for ($i=0; $i < count($day_before); $i++) { 
               $data['day_after'][] =  date("l", mktime(0, 0, 0, $day_before[$i][1], $day_before[$i][0], $day_before[$i][2]));
            }          
            $count=0;
            //count sebagai tanda/index pembatas antara patroli
            $data['max_duration']= max($duration);
            $data['min_duration']= min($duration);
            $data['max_index']= array_search(max($duration),$duration);
            $data['min_index']= array_search(min($duration),$duration);
            $data['data_day']=array();
            for ($i=0; $i < sizeof($data['id_location']); $i++) {
              //cek apakah id location sudah mencapai id terakhir dalam satu patroli
              if ($data['id_location'][$i]==$data['id_finish']) {
                //index hari
                foreach ($day_index as $date_key => $date) {
                  //index shift
                  foreach ($date as $shift_key => $shift_index) {
                    //jika index shift sama dengan pembatas antar shift
                    if($count==$shift_index){
                      $data['data_day'][$data['date_day'][$date_key]][$shift_key][]=array( 
                          'time_location' => $data['time_location'][$i],
                          'id_location' => $data['id_location'][$i],
                          'name_location' => $data['name_location'][$i]
                          );
                    }
                  }
                }
                  
                if($count==$data['max_index']){                  
                  $data['data_max'][]=array( 
                    'time_location' => $data['time_location'][$i],
                    'id_location' => $data['id_location'][$i],
                    'name_location' => $data['name_location'][$i]
                  ); 
                }
                if($count==$data['min_index']){                  
                  $data['data_min'][]=array( 
                    'time_location' => $data['time_location'][$i],
                    'id_location' => $data['id_location'][$i],
                    'name_location' => $data['name_location'][$i]
                  ); 
                }
                $count++;
              }else{
                foreach ($day_index as $date_key => $date) {
                  foreach ($date as $shift_key => $shift_index) {
                    if($count==$shift_index){
                      $data['data_day'][$data['date_day'][$date_key]][$shift_key][]=array( 
                          'time_location' => $data['time_location'][$i],
                          'id_location' => $data['id_location'][$i],
                          'name_location' => $data['name_location'][$i]
                      );
                    }
                  }
                }
                    if($count==$data['max_index']){
                      $data['data_max'][]=array( 
                        'time_location' => $data['time_location'][$i],
                        'id_location' => $data['id_location'][$i],
                        'name_location' => $data['name_location'][$i]
                      ); 
                    }
                    if($count==$data['min_index']){
                      $data['data_min'][]=array( 
                        'time_location' => $data['time_location'][$i],
                        'id_location' => $data['id_location'][$i],
                        'name_location' => $data['name_location'][$i]
                      );  
                    }
                  } 
                }
          $data['total_duration']=round((array_sum($duration)/60))." hrs. ".(array_sum($duration)%60)." min.";
          $data['error'] =  " ";            
          $data['title'] ='Dashboard';
          $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();
          $standard_time=$this->M_Route->get(substr($data['route'],-1,1));
          $data['stime']=$standard_time;
          $data['cdate']=$day_idx;
          $data['standard_time']=$standard_time[0]->standard_time;
          $data['save_file'] = base_url("data/save");
          $this->session->set_userdata('data', $data);
          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('user/V_Dashboard', $data);
          $this->load->view('templates/footer', $data);
  }
  public function save(){
    $this->M_Checkpoint->save();
    $this->save_success();
  }
  public function save_success()
  {
    $this->session->unset_userdata('data');
    $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has <strong> successfully saved! </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
      redirect('dashboard');
  }
  public function dataChart($id_route=FALSE, $time_location=FALSE){
      if(!$time_location){  
         $time_location = $this->M_Checkpoint->get_min_date($id_route);
         $time_location = $time_location[0]->time_location;
      }    
      $index=0;
      $id_checkpoint = $this->M_Checkpoint->get_date_location($id_route);
      foreach ($id_checkpoint as $key => $dt) {
        if($time_location>=date('d-m-Y',strtotime($dt->first_check)) && $time_location<=date('d-m-Y',strtotime($dt->last_check))){
          $index=$key;
        }
      }
      $time_location = date('Y-m-d',strtotime($time_location));
      $min_max_timeshift = $this->M_Location->get_min_max_timeshift($id_checkpoint[$index]->id_checkpoint,$time_location);
      foreach ($min_max_timeshift as $minmax_key => $mm) {
        $interval = (new DateTime($min_max_timeshift[$minmax_key]->max))->diff(new DateTime($min_max_timeshift[$minmax_key]->min)); 
        $duration[$minmax_key] = (int)$interval->days * 24 * 60;
        $duration[$minmax_key] += (int)$interval->h * 60;
        $duration[$minmax_key] += (int)$interval->i;
        $min_max_timeshift[$minmax_key]->duration=$duration[$minmax_key];
      }
    echo json_encode($min_max_timeshift, JSON_PRETTY_PRINT);
  }
  public function dataStandard($id_route){
    echo json_encode($this->M_Route->get($id_route));
  }
  public function search($id_route=FALSE)
  {
    echo json_encode($this->M_Checkpoint->get_search_date($id_route));
  }     
}
?>