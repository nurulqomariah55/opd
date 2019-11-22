
$(document).ready(function(){
  $.ajax({
    dataType: 'json',
    url: 'assets/js/data.json',
    success: function(data) {
      // begin accessing JSON data here
      dataJSON = data;
      console.log(dataJSON);
      for (var i in dataJSON) {
          day.push(i);
          duration.push(dataJSON[i]);
          sTime.push(90);
      }
      console.log(day);
      console.log(sTime);
      console.log(duration);
    },
  });
         var ctx = document.getElementById('myChart').getContext('2d');
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
                
                labels: day
            },
            options: {
                title:{
                    display: true,
                    text: 'Historical Analysis Report'
                }
            }
        });


  $.ajax({
    dataType: 'json',
    url: 'assets/js/data.json',
    success: function(data) {
      // begin accessing JSON data here
      dataJSON = data;
      console.log(dataJSON);
      for (var i in dataJSON) {
          day.push(i);
          duration.push(dataJSON[i]);
          sTime.push(50);
      }
      console.log(day);
      console.log(sTime);
      console.log(duration);
    },
  });
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
                
                labels: day
            },
            options: {
                title:{
                    display: true,
                    text: 'Historical Analysis Report'
                }
            }
        });


  $.ajax({
    dataType: 'json',
    url: '/dataChart',
    success: function(data) {
      // begin accessing JSON data here
      dataJSON = data;
      console.log(dataJSON);
      for (var i in dataJSON) {
          day.push(i);
          duration.push(dataJSON[i]);
          sTime.push(50);
      }
      console.log(day);
      console.log(sTime);
      console.log(duration);
    },
  });
});