// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
var ctx = document.getElementById("myPieChart");
var def,nor,exc;
$.ajax({
  url: "/ajax-request",
  type:"GET",
  success:function(response){
    console.log(response);
    def = response.val['Deficiente'];
    exc = response.val['Excelente'];
    nor = response.val['Normal'];

    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Deficiente", "Excelente", "Normal"],
        datasets: [{
          data: [def , exc, nor],
          backgroundColor: ['#e74a3b', '#1cc88a', '#f6c23e'],
          hoverBackgroundColor: ['#e74a3b', '#17a673', '#f6c23e'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });
  },
 });



