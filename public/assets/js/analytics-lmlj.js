"use strict";
$(document).ready(function() {
  chart();
});

function generateChart(datachart){
  var ctx = document.getElementById("myChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
      datasets: [{
        label: 'LMLJ',
        data: datachart,
        borderWidth: 2,
        backgroundColor: 'rgba(63,82,227,.8)',
        borderWidth: 0,
        borderColor: 'transparent',
        pointBorderWidth: 0,
        pointRadius: 3.5,
        pointBackgroundColor: 'transparent',
        pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            // display: false,
            drawBorder: false,
            color: '#f2f2f2',
          },
          ticks: {
            beginAtZero: true,
            stepSize: 5,
            callback: function(value, index, values) {
              return value;
            }
          }
        }],
        xAxes: [{
          gridLines: {
            display: false,
            tickMarkLength: 15,
          }
        }]
      },
    }
  });

}


