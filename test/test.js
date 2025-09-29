const placas = ['(SE)PLACAS DE PIEZAS Y COMPONENTES', 
  '(PO)PLACAS DE PIEZAS Y COMPONENTES', 
  '(GR)PLACAS DE PIEZAS Y COMPONENTES', 
  '(Z)PLACAS DE PIEZAS ZARAGOZA', 
  '(PM)PLACAS DE PIEZAS Y COMPONENTES', 
  '(B)PLACAS DE PIEZAS Y COMPONENTES D', 
  'PPCR PATERNA']

document.forms[0].addEventListener("submit",(e)=>{
  e.preventDefault()
  let valor = document.getElementById('id').value
  let result = document.getElementById('result')
  let progressBar = document.getElementById('progressBar')
  let barraProgreso = document.createElement('progress')
  barraProgreso.id = 'barraProgreso'
  barraProgreso.max = 30
  barraProgreso.value = 0
  barraProgreso.style.transition = 'width 0.5s ease-in-out'
  barraProgreso.style.height = '20px'
  barraProgreso.style.marginBottom = '10px'
  progressBar.appendChild(barraProgreso)
  setInterval(() => {
    let width = parseInt(barraProgreso.value)
    if(width < 100){
      barraProgreso.value += 0.01
    }
  }, 10)
  result.innerHTML = `Buscando disponibilidades de la referencia ${valor} en PowerSupply...`
  fetch(`https://ppcr.es:3001/ejecutar`,{
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      referencia: valor
    })
  })
  .then(response => response.text())
  .then(data => {
    if(data.includes('Ha ocurrido un error')){
      result.innerHTML = 'No se encontraron resultados'
      progressBar.removeChild(barraProgreso)
      return
    }
    let dataSplit = data.split('~')
    let stock = dataSplit[0].split(';')
    let cesiones = dataSplit[1].split(';')
    let placaExterna = false
    result.innerHTML = '<div class="table"><div class="stock">'
    result.innerHTML += '<b>Stock:</b><br>'
    for(let i = 0; i < stock.length - 1; i = i + 4){
      result.innerHTML += `${stock[i+2].replaceAll('\\"', '')} ${stock[i].replaceAll('\\"', '')} ${stock[i+1].replaceAll('\\"', '')} <br>`
    }
    result.innerHTML += '</div><div class="cesiones">'
    result.innerHTML += '<p><b>Cesiones:</b><br>'
    for(let i = 0; i < cesiones.length; i++){
      if(placas.includes(cesiones[i])){
        result.innerHTML += cesiones[i] + '<br>'
      }else{
        if (!placaExterna){
          result.innerHTML += 'COMPRA EXTERNA<br>'
          placaExterna = true
        }
      } 
    }
    result.innerHTML += '</div></div>'
    progressBar.removeChild(barraProgreso)
  })
})