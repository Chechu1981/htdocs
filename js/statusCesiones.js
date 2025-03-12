import contadores from "./updateCounter.js"

setInterval(() =>{contadores()},1000)
let barras =window.graph
let chartOrigen = window.graph
let chartDestino = window.graph

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

window.addEventListener('load',() => {
  if(document.getElementsByTagName('select').length > 0)
    return false
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
      if(barras){
        barras.clear()
        barras.destroy()
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
      barras = new Chart("myChart", {
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
    
    barras = new Chart("myChart", {
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

   //Los que más piden
  let value = new Date()
  const selectDateInit = document.createElement('input')
  const selectDateFinal = document.createElement('input')
  selectDateFinal.type = "date"
  selectDateFinal.value = value.toISOString().split('T')[0]
  selectDateInit.type = "date"
  $('ceden').appendChild(selectDateInit)
  $('ceden').appendChild(selectDateFinal)
  
  selectDateInit.addEventListener("change", e => {
    if(chartOrigen){
      chartOrigen.clear()
      chartOrigen.destroy()
    }
    cargarGrafico('../../api/getAssigStatusByPlateDestination.php',"chartCeden",{
      dateIn: e.target.value,
      dateOut: selectDateFinal.value
    },'Los que más ceden',chartOrigen)
  })
  
  selectDateFinal.addEventListener('change',e => {
    if(chartOrigen){
      chartOrigen.clear()
      chartOrigen.destroy()
    }
    cargarGrafico('../../api/getAssigStatusByPlateDestination.php',"chartCeden",{
      dateIn: selectDateInit.value,
      dateOut: e.target.value
    },'Los que más ceden',chartOrigen)
  })

  cargarGrafico('../../api/getAssigStatusByPlate.php',"chartPiden",{dateIn:'',dateOut:''},'Los que más piden', chartDestino)
  cargarGrafico('../../api/getAssigStatusByPlateDestination.php',"chartCeden",{dateIn:'2025-01-01',dateOut:'2025-02-21'}, 'Los que más ceden',chartOrigen)
  
})
const cargarGrafico = (url,cartId,post,title, chartId) => { 
  const data =  new FormData()
  data.append('dateIn',post.dateIn)
  data.append('dateOut',post.dateOut)
  fetch(url,{
    method: 'POST',
    body: data
  })
  .then(e => e.json())
  .then(res => {
    let datos = []
    let etiquetas = []
    res.map(volumen => {
      datos.push(volumen.vol)
      if(cartId == 'chartPiden')
        etiquetas.push(volumen.origen)
      else
        etiquetas.push(volumen.destino)
    })
    if(chartId != undefined){
      chartId.destroy()
      chartId.clear()
    }else{
      chartId = new Chart(cartId, {
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
          plugins: {
            title: {
              display: true,
              text: title
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
    }
  })
}