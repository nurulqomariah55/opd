

$(document).ready(function(){
    
    $(function(){
      if(location.pathname.split("/")[3]){
        $('li a.nav-link[href$="/' + location.pathname.split("/")[2] + "/"+ location.pathname.split("/")[3] +'"]').addClass('active');
      }else{
        $('li a.nav-link[href$="/' + location.pathname.split("/")[2] + '"]').addClass('active');
      }
      let template = null;
      $('#modalEdit').on('show.bs.modal', function(event){
        if(template==null){
          template = $(this).html();
        }else{
          $(this).html(template);
        }
      }); 
    });
    let duration=[], day=[], sTime=[];
    let dataTime, dataDt;
    

    $.ajax({
      dataType: 'json',
      url: 'assets/js/stime.json',
    }).done(function(data){
      // begin accessing JSON data here
      console.log(data);
      dataTime = data;
    });
    
    let dataDate=[];  
    $.ajax({
      dataType: 'json',
      url: 'assets/js/cdate.json',
    }).done(function(data){
      // begin accessing JSON data here
      dataDate = data;
    });


    console.log(dataDate);
    let ctDate=0;
    $.ajax({
      dataType: 'json',
      url: 'assets/js/data.json',
    }).done(function(data){
      // begin accessing JSON data here
      dataJSON = data;
      console.log(dataJSON);
      for (var i in dataJSON) {
        day.push(i);
        duration.push(dataJSON[i]);
        sTime.push(dataTime[0].standard_time*dataDate[ctDate++]);
      }
      console.log(sTime);
      var ctx = document.getElementById('myChart').getContext('2d');
         var mixedChart = new Chart(ctx, {
            type: 'line',
            data: {
              datasets: [{
                label: 'Total Duration',
                data: duration,
                borderColor: 'rgb(246, 74, 138)',
              }, {
                data: sTime,
                borderColor: 'rgb(0, 142, 204)',
                label: 'Standard time',
                // Changes this dataset to become a line
                type: 'line',
              }],
              labels: day,
            },
            options: {
              title:{
                display: true,
                text: 'Historical Analysis Report',
              }
            }
          });
         console.log(day);
         console.log(sTime);
         console.log(duration);
       });

    let min=[], max=[], shift=[], dur=[];
    let loc = '/'+location.pathname.split("/")[1]+'/data/chart/'+location.pathname.split("/")[3];
    if(location.pathname.split("/")[4]){
      loc+='/'+location.pathname.split("/")[4];
    }
    
    let datastandard = '/'+location.pathname.split("/")[1]+'/data/standard/'+location.pathname.split("/")[3];
    let standard;
    

    $.ajax({
      dataType: 'json',
      type: 'GET',
      url: datastandard,
    }).done(function(data){
      standard = data;
      $.ajax({
        dataType: 'json',
        type: 'GET',
        url: loc,
      }).done(function(data){
        // begin accessing JSON data here
        console.log(data);
        dataJSON = data;
        console.log(dataJSON);
        for (var i in dataJSON) {
          shift.push("Shift "+dataJSON[i].shift);
          console.log(standard);
          sTime.push(standard[0].standard_time);
          duration.push(dataJSON[i].duration);
        }
        var ctx = document.getElementById('locationChart').getContext('2d');
        var mixedChart = new Chart(ctx, {
          type: 'line',
          data: {
            datasets: [{
              label:'Total Duration',
              data: duration,
              borderColor: 'rgb(246, 74, 138)',
            }, {
              label: 'Standard time',
              data: sTime,
              borderColor: 'rgb(0, 142, 204)',
              // Changes this dataset to become a line
              type: 'line'
            }],                
            labels: shift
          },
          options: {
            title:{
              display: true,
              text: 'Historical Analysis Report'
            }
          }
        });
        console.log(min);
        console.log(max);
        console.log(shift);
      });
    });
    

    var substringMatcher = function(strs) {
      return function findMatches(q, cb) {
        var matches, substringRegex;
        // an array that will be populated with substring matches
        matches = [];
        // regex used to determine if a string contains the substring `q`
        substrRegex = new RegExp(q, 'i');
        // iterate through the pool of strings and for any string that
        // contains the substring `q`, add it to the `matches` array
        $.each(strs, function(i, str) {
          if (substrRegex.test(str)) {
            matches.push(str);
          }
        });
        cb(matches);
      }; 
    };
    let data_search=[];
    let routes= '/'+location.pathname.split("/")[1]+'/search/';
    let link_route = '/'+location.pathname.split("/")[1]+'/location/';
    
    $.ajax({
      dataType: 'json',
      type: 'GET',
      url: routes
    }).done(function(data){
      console.log(data);
      for(i in data){
        data_search.push("Route "+data[i].id_route+", "+data[i].route_name);
      }
      console.log(data_search);
    });

    
    $(".btn-security").click(function(){
      let patrol_date = $(this).data('patrol_date'); 
      let link_security = '/'+location.pathname.split("/")[1]+'/security/detail/'+patrol_date;
    
      $.ajax({
        dataType: 'json',
        type: 'GET',
        url: link_security
      }).done(function(data){
        console.log(data);
        html = `<div class="col-11 offset-1"> Patrol Date : <b>${data[0].patrol_date}</b> <br>
                Route : <b>${data[0].id_route} </b><br>
                Security Name : <br>
                `;

        for(i in data){
          html+=`
          <b>${data[i].no_badge} - ${data[i].name} </b> <br>
          `;
        }
        html+=`</div>`;
        $('#detailSecurity').html(html);
      });
    });

    $('#the-basics .typeahead').typeahead({
      hint: true,
      highlight: true,
      minLength: 1
    },
    {
      name: 'data_search',
      source: substringMatcher(data_search),
      templates:{
        suggestion:function(data) {
          return "<a class='link-search' href="+ link_route + (data.substring(6,7)) +">"+data +"</a>"
        }
      }
    });


    $('#validatedCustomFile').on('change',function(){
      //get the file name

      var fileName = $(this).val().split('\\');
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName[fileName.length-1]);
    });

    let tgl=[];
    let loca = '/'+location.pathname.split("/")[1]+'/route/search/'+location.pathname.split("/")[3];
    let link = '/'+location.pathname.split("/")[1]+'/location/'+location.pathname.split("/")[3]+"/";
    

    $.ajax({
      dataType: 'json',
      type: 'GET',
      url: loca
    }).done(function(data){
      for(i in data){
        tgl.push(data[i].time_location);
      }
      console.log(tgl);
    });

    

    $('#SearchDate .typeahead').typeahead({
      hint: true,
      highlight: true,
      minLength: 1
    },
    {
      name: 'tgl',
      source: substringMatcher(tgl),
      templates:{
        suggestion:function(data) {
          console.log(data);
          return "<a class='link-search' href=" + link + data +">"+ data +"</a>"
        }
      }
    });

    

    $('#SearchDate').keyup(function(){
      console.log('ngetik');
      if(event.key=="Enter"){
        location.replace($('.link-search').attr('href'));
        console.log($('.link-search').attr('href'));
        console.log('bisa');
      }
    });
    

    $('#location').DataTable({
      responsive:true
    });  
    

    $('#route').DataTable({
      responsive:true
    });
    
    $('#employee').DataTable({
      "order":[[1,"asc"]]
    })

    $('#security').DataTable({
      "order":[[0,"desc"]]
    })

    $(".btn-add-loc").click(function(){
      var html = $(".copy-input-a").html();
      $(".copy-input-a").before(html);
    });
    
    $("body").on("click",".btn-remove-loc", function(){
      $(this).parents(".control-group").remove();
    });

    $(".btn-add-sec").click(function(){
      var html = $(".copy-input-sec").html();
      $(".copy-input-sec").before(html);
    });

    $("body").on("click",".btn-remove-sec", function(){
      $(this).parents(".control-sec").remove();
    });
    

    let data_location = [];
    let link_loc = '/'+location.pathname.split("/")[1]+'/location/data/';
    $.ajax({
      dataType: 'json',
      type: 'GET',
      url: link_loc
    }).done(function(data){
      console.log(data);
      data_location = data;
    });


    $('.btn-edit').click(function(){
      let id_route = $(this).data('id_route');
      let id_schedule = $(this).data('id_schedule');
      let html = ``;
      let link_edit = '/'+location.pathname.split("/")[1]+'/schedule/edit/'+id_route+"/"+id_schedule;
      $('#editForm').attr('action',link_edit);
      let link_schedule = '/'+location.pathname.split("/")[1]+'/schedule/data/'+id_route+"/"+id_schedule;
      
      $.ajax({
        dataType: 'json',
        type: 'GET',
        url: link_schedule
      }).done(function(data){
        $('#idroute').val(data[0].id_route);
        console.log(data);
        $('#varian').val(data[0].id_schedule);
        for(i in data){
          html+=`
          <div class="col-10 offset-1 control-group form-group">
          <div class="row">
            <div class="col-10">
            <label for="Route_Name">Location Name</label>
            <select name="id_location[]" class="form-control">`;
            for(j in data_location){
              if(data[i].id_location==data_location[j].id_location){
                html += `
                <option selected value="${data[i].id_location}">${data[i].id_location} - ${data[i].location_name}</option>
              `; 
              }else{
                html += `
                <option value="${data_location[j].id_location}">${data_location[j].id_location} - ${data_location[j].location_name}</option>
              `;
              }
            }
          html+=`
            </select>
            </div>
            <div class="col-2">
              <label for="Route_Name" class="invisible">Name</label>
              <button type="button" class="btn btn-danger btn-sm btn-remove-modal-schedule">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                  </button>
            </div>
          </div>
          </div>
          `;
        }
        html+=`
         <div class="col-10 offset-1 form-group" id="edit_sch_before">
         <button type="button" class="btn btn-primary btn-sm" id="btn-add-modal-schedule">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
         </button>
         </div>`;
        $('#editModalContent').append(html);

        $("#btn-add-modal-schedule").click(function(){
          var html = $(".copy-input-sch").html();
          $("#edit_sch_before").before(html);
        });


        $("body").on("click",".btn-remove-modal-schedule", function(){
          $(this).parents(".control-group").remove();
        });
      });
    });
});