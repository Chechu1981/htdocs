const createStatus = (data) =>{
  var xValues = ["Uno", "Dos", "Tres", "Cuatro", "Cinco"];
  var yValues = [data[0]];
  var barColors = ["red", "green","blue","orange","brown"];
  
  new Chart("myChart", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {
      legend: {display: false},
      title: {
        display: false,
        text: "World Wine Production 2018"
      }
    }
  });
}