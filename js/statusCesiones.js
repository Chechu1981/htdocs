import contadores from "./updateCounter.js"

setInterval(() =>{contadores()},1000)

const id = window.location.search.split('?id=')[1]
const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `../cesionesAll.php?id=${id}`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location = `../cesionesADV.php?id=${id}`
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./buscar.php?id=${id}`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./ready.php?id=${id}`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./finish.php?id=${id}`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location.reload()
})

const colorArray = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
  '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
  '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A', 
  '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
  '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC', 
  '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
  '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680', 
  '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
  '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3', 
  '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];

window.addEventListener('load',()=>{
  if(document.getElementsByTagName('select').length > 0)
    return false
  const divContainer = document.createElement('div')
  divContainer.style.margin = "auto"
  divContainer.style.height = `calc(70vh - (${$('menu').offsetHeight}px + ${$('contacts').offsetHeight}px))`
  $('cesiones').innerHTML = ''
  const chart = document.createElement('script')
  chart.src = "https://cdn.jsdelivr.net/npm/chart.js"
  document.head.appendChild(chart)
  const canvas = document.createElement('canvas')
  canvas.id = "myChart"
  divContainer.appendChild(canvas)
  $('cesiones').appendChild(divContainer)
  let data = {
    datasets: []
  }
  fetch('../../api/getAssigStatus.php',{
    method: 'POST'
  })
  .then(e => e.json())
  .then(res => {
    const input = document.createElement('select')
    input.name = "Users"
    input.style = "width: 150px;border: 2px solid var(--main-font-color);border-radius: 8px;font-size: 2em; text-transform: uppercase;height: fit-content;"
    input.addEventListener("change",(e)=>{
      if(window.graph){
        window.graph.clear()
        window.graph.destroy()
      }
      if(res[e.target.value][1].length > 0){
        let sum = res[e.target.value][1].slice(0,20).reduce((previous, current) => parseInt(current) + parseInt(previous));
        avg = Math.round((sum / res[e.target.value][1].slice(-20).length) * 100)/100;
      }

      data.labels = res[e.target.value][2]
      data.datasets = [{
        label: "Media: " + avg,
        data: res[e.target.value][1],
        backgroundColor: colorArray,
        stack: 'Stack 0',
      }]
      window.graph = new Chart("myChart", {
        type: 'bar',
        data: data,
        options: {
          plugins: {
            title: {
              display: true,
              text: 'Cesiones diarias por usuario'
            },
          },
          responsive: true,
          interaction: {
            intersect: false,
          },
          scales: {
            x: {
              stacked: true,
            },
            y: {
              stacked: true
            }
          }
        }
      })
    })    

    // Creo los usuarios en un selection
    let usuario = 0
    for(let i = 0; i < res.length; i++) {
      let name = res[i][0]
      let option = document.createElement('option')
      option.innerHTML = name
      option.setAttribute('value',i)
      input.appendChild(option)
      if(name.toUpperCase() == user.nombre.toUpperCase()){
        usuario = i
        option.setAttribute('selected',true)
      }
    }
    $('contacts').appendChild(input)

    
    let sum = res[usuario][1].slice(0,20).reduce((previous, current) => parseInt(current) + parseInt(previous));
    let avg = Math.round((sum / res[usuario][1].slice(0,20).length) * 100)/100;
    data.labels = res[usuario][2]
    data.datasets = [{
      label: "Media: " + avg,
      data: res[usuario][1],
      backgroundColor: colorArray,
      stack: 'Stack 0',
    }]
    
    window.graph = new Chart("myChart", {
      type: 'bar',
      data: data,
      options: {
        plugins: {
          title: {
            display: true,
            text: 'Cesiones diarias por usuario'
          },
        },
        responsive: true,
        interaction: {
          intersect: false,
        },
        scales: {
          x: {
            stacked: true,
          },
          y: {
            stacked: true
          }
        }
      }
    })
    //Cesiones por placa
    const divChartPlacas = document.createElement('div')
    divChartPlacas.style.margin = "auto"
    divChartPlacas.style.height = `calc(70vh - (${$('menu').offsetHeight}px + ${$('contacts').offsetHeight}px))`
    const canvasPlacas = document.createElement('canvas')
    canvasPlacas.id = "chartPlacas"
    divChartPlacas.appendChild(canvasPlacas)
    $('cesiones').appendChild(divChartPlacas)
    fetch('../../api/getAssigStatusByPlate.php',{
      method: 'POST'
    })
    .then(e => e.json())
    .then(res => {  
      let datos = []
      let etiquetas = []
      res[0].map(volumen => {
        datos.push(volumen.vol)
        etiquetas.push(volumen.origen)
      })
      window.graph1 = new Chart("chartPlacas", {
        type: 'polarArea',
        data: {
          datasets:[{
            data: datos,
            backgroundColor: colorArray,
          }],
          labels: etiquetas,
          hoverOffset: 4
        },
        options: {
          actions:[{
            name: 'Randomize',
            handler(chart) {
              chart.data.datasets.forEach(dataset => {
                dataset.data = Utils.numbers({count: chart.data.labels.length, min: -100, max: 100});
              });
              chart.update();
            }
          }],
          plugins: {
            title: {
              display: true,
              text: 'Cesiones totales por placa origen'
            },
          },
          responsive: true,
          interaction: {
            intersect: false,
          },
          scales: {
            y: {
              stacked: true
            }
          }
        },
      })
    })
  })
})