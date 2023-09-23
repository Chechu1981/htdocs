const cesiones = (origen, destino,nfm) =>{
  let cesion = null
  origen != destino ? cesion = origen + '' + destino:''
  nfm ? cesion += 'NM' : ''
  fetch('../json/cesionesCliente.json')
  .then(response => response.json())
  .then(response => {
    const numDest = response[cesion]
    let alerta = ""
    if(numDest == "6254-1" || numDest == "78713-1"){
      $('pclient').classList.add('important')
      alerta = "Preguntar"
    }else{
      $('pclient').classList.remove('important')
      alerta = ""
    }
    numDest != undefined ? $('pclient').innerText = `${numDest} ${alerta}` : $('pclient').innerText = ""
  })
}

$('nfm').addEventListener('change', (e) => {
  cesiones($('origen').value,$('destino').value,e.target.checked)
})

$('origen').addEventListener('change',()=>{
    cesiones($('origen').value,$('destino').value,$('nfm').checked)
})

$('destino').addEventListener('change',()=>{
    cesiones($('origen').value,$('destino').value,$('nfm').checked)
})

const showAssig = () =>{
  $('descRef').innerHTML = ""
  $('clientName').innerHTML = ""
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  data.append('sort', 'date')
  fetch('../api/getAssig.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(response => {
    $('cesiones').innerHTML = response
    const rows = $('cesiones').getElementsByTagName('ul')
    for(let i = 1;i < rows.length;i++) {
      const id = rows[i].id
      const referencia = rows[i].childNodes[7].innerHTML
      const data = new FormData
      data.append('id', id)
      data.append('referencia', referencia)
      fetch('../api/getDescRefer.php',{
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(res => {
        rows[i].childNodes[9].innerHTML = res.replace('<p>', ' / ')
      })
    }
  })
}

const buscarCliente = (placa,cliente) => {
  const data = new FormData()
  data.append('search',cliente != '' ? cliente : null)
  data.append('placa', placa.toUpperCase())
  fetch('../api/getClientName.php',{method: 'POST', body:data})
  .then(respose => respose.text())
  .then((res) => $('clientName').innerHTML = res)
}

const buscarDenominacionReferencia = (refer) =>{
  const data = new FormData()
  data.append('referencia', refer)
  fetch('../api/getDescRefer.php',{
    method: 'POST',
    body: data
  })
  .then(res => res.text())
  .then((res) => $('descRef').innerHTML = res)
}

$$('form')[0].addEventListener('submit',(e)=>{   
  e.preventDefault()
  const fecha = new Date()
  const origen = $('origen').value
  const destino = $('destino').value
  const referencia = $('ref').value
  const cliente = $('client').value
  const nfm = $('nfm').checked
  const comentario = $('coment').value
  const cantidad = $('units').value
  let mailFragil = ''
  let strCantidad = 'la referencia'
  if(cantidad > 1){
    strCantidad = `${cantidad} referencias de la `
  }

  if($('frag').checked){
    mailFragil = encodeURIComponent(`
        ****‼️ ATENCIÓN ‼️****
    ******************************
    **⚠️⚠️ MATERIAL FRÁGIL ⚠️⚠️**
    ******************************
    
    `)
  }
  const mailSub = `CESION ${origen} -> ${destino}`
  const mailSaludo = fecha.getHours() > 15 ? "Buenas tardes: %0A" : "Buenos días: %0A"
  const mailBody = encodeURIComponent(`Va a llegar de la placa de ${origen} a ${destino} ${strCantidad} ${referencia} para la cuenta ${cliente}. 
    La entrada en Geode debe ser realizada como entrada esperada 103 y no con el 109. 
    Saludos.`)
  const mailBodyNfm = encodeURIComponent(`Va a llegar de la placa de ${origen} a ${destino} ${strCantidad} ${referencia} para la cuenta ${cliente}.
    La entrada en Geode debe ser realizada como entrada 109. PIEZA SIN SOLUCIÓN DE REEMPLAZO.  
    Saludos.`)
  let mailTarget
  (nfm) ? mailTarget = mailBodyNfm : mailTarget = mailBody
  if(origen != '' && destino != '' && referencia != '' && cliente != ''){
    const inout = new FormData()
    inout.append('origen', origen)
    inout.append('destino', destino)
    inout.append('destinoC', destino+'C')
    inout.append('origenF', origen+'F')
    fetch('../api/getBccMails.php',{
      method: 'POST',
      body: inout
    })
    .then(response => response.json())
    .then(res => {
      let destinoFragil = ''
      if($('frag').checked){
        destinoFragil = res['fragil']
      }
      window.location = `mailto:${destinoFragil};${res["destino"]};${res["origen"]}?subject=${mailSub}&cc=${res['conCopia']}&body=${mailFragil}${mailSaludo + mailTarget}`
    })

    const data = new FormData()
    data.append('origen',origen)
    data.append('destino',destino)
    data.append('cliente',cliente)
    data.append('ref',referencia)
    data.append('cantidad',cantidad)
    data.append('pvp','')
    data.append('pedido','')
    data.append('comentario',comentario)
    data.append('session',window.location.href.split('=')[1])
    fetch('../api/addAsign.php',{
      method: 'POST',
      body:data
    })
    .then(response => response.text())
    .then(res =>{
      if(res == 'ok'){
        showAssig()
        e.target.reset()
      }
    })
  }else{
    customAlert('Debes rellenar todos los campos')
  }
})

showAssig()

$('contacts-items').addEventListener('click',e =>{
  if(e.target.parentNode.title.includes('recibida')){
    if(confirm("Se ha recibido esta cesion?") == true){
      const data = new FormData()
      data.append('id',e.target.id)
      fetch('../api/updateAssig.php',{
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(() => e.target.parentNode.parentNode.style.display = 'none')
    }
  }
})

const botones = {
  nueva:$('contacts').childNodes[3].childNodes[1].childNodes[1],
  buscar:$('contacts').childNodes[3].childNodes[1].childNodes[3],
  recibidas:$('contacts').childNodes[3].childNodes[1].childNodes[5],
  pendientes:$('contacts').childNodes[3].childNodes[1].childNodes[7],
  estadistica:$('contacts').childNodes[3].childNodes[1].childNodes[9]
}

const clearSelect = () => {
  if($('contacts').childNodes[5] != undefined)
    $('contacts').childNodes[5].remove()
}

botones.nueva.addEventListener('click',()=>{
  window.location.reload()
  const rows = $('cesiones').getElementsByTagName('ul')
  for(let i = 1;i < rows.length;i++) {
    const id = rows[i].id
    const referencia = rows[i].childNodes[7].innerHTML
    const data = new FormData
    data.append('id', id)
    data.append('referencia', referencia)
    fetch('../api/getDescRefer.php',{
      method: 'POST',
      body: data
    })
    .then(response => response.text())
    .then(res => {
      rows[i].childNodes[9].innerHTML = res.replace('<p>', ' / ')
    })
  }
})

botones.buscar.addEventListener('click',() => {
  clearSelect()
  const boton = `<div id="search-line" class="nPass search-line search-focused">
  <span class="lupa">
    <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
      <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
    </svg>
  </span>
  <div class="textbox" id="search-box">
    <input type="search" id="search-assig" placeholder="Buscar cesión...">
  </div>
</div>`
  $('contacts-items').childNodes[1].classList.add('change')
  setTimeout(function(){
    $('contacts-items').childNodes[1].classList.remove('change')
    $('contacts-items').childNodes[1].innerHTML = boton
    $('search-assig').focus()
    let timeOut
    $('search-assig').addEventListener('keyup',(e)=>{
      fetch('../api/spinner.php')
      .then(fn => fn.text())
      .then(req => $('cesiones').innerHTML = req)
      window.clearTimeout(timeOut)
      timeOut = window.setTimeout(() => {
        const data = new FormData()
        data.append('id',e.target.value.trim())
        data.append('session',window.location.href.split('=')[1])
        fetch('../api/getAssig.php',{
          method: 'POST',
          body: data
        })
        .then((e) => e.text())
        .then((res) => {      
          $('cesiones').innerHTML = res
          const rows = $('cesiones').getElementsByTagName('ul')
          for(let i = 1;i < rows.length;i++) {
            const id = rows[i].id
            const referencia = rows[i].childNodes[7].innerHTML
            const data = new FormData
            data.append('id', id)
            data.append('referencia', referencia)
            fetch('../api/getDescRefer.php',{
              method: 'POST',
              body: data
            })
            .then(response => response.text())
            .then(res => {
              rows[i].childNodes[9].innerHTML = res.replace('<p>', ' / ')
            })
          }
        })
      },1000)
    },500)  
  })
})

$('client').addEventListener('blur',(e)=>{
  buscarCliente($('destino').value.substring(0,3),$('client').value.split('-')[0])
})

$('ref').addEventListener('blur',() =>{
  buscarDenominacionReferencia($('ref').value)
})

botones.recibidas.addEventListener('click', () =>{
  clearSelect()
  $('contacts-items').childNodes[1].innerHTML = ''
  const data = new FormData()
  data.append('id','all')
  data.append('session',window.location.href.split('=')[1])
  fetch('../api/getAssig.php',{
    method: 'POST',
    body: data
  })
  .then((e) => e.text())
  .then((res) => {
    $('cesiones').innerHTML = res
    const rows = $('cesiones').getElementsByTagName('ul')
    for(let i = 1;i < rows.length;i++) {
      const id = rows[i].id
      const referencia = rows[i].childNodes[7].innerHTML
      const data = new FormData
      data.append('id', id)
      data.append('referencia', referencia)
      fetch('../api/getDescRefer.php',{
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(res => {
        rows[i].childNodes[9].innerHTML = res.replace('<p>', ' / ')
      })
    }
  })
})

botones.pendientes.addEventListener('click', () =>{
  clearSelect()
  assignOnTrak()
})

const assignOnTrak = () =>{
  //$('newTitle').innerHTML = "Cesiones pendientes de recibir"
  $('contacts-items').childNodes[1].innerHTML = ''
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  fetch('../api/getAssig.php',{
    method: 'POST',
    body:data
  })
  .then((e) => e.text())
  .then((res) => {
    $('cesiones').innerHTML = res
    const rows = $('cesiones').getElementsByTagName('ul')
    for(let i = 1;i < rows.length;i++) {
      const id = rows[i].id
      const referencia = rows[i].childNodes[7].innerHTML
      const data = new FormData
      data.append('id', id)
      data.append('referencia', referencia)
      fetch('../api/getDescRefer.php',{
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(res => {
        rows[i].childNodes[9].innerHTML = res.replace('<p>', ' / ')
      })
    }
  })
}

botones.estadistica.addEventListener('click', () =>{
  if($('contacts').childNodes[5] != undefined)
    return false
  $('contacts-items').childNodes[1].innerHTML = ''
  const divContainer = document.createElement('div')
  divContainer.style.margin = "auto"
  divContainer.style.height = `calc(70vh - (${$('menu').offsetHeight}px + ${$('contacts').offsetHeight}px))`
  divContainer.style.maxWidth = "700px"
  $('cesiones').innerHTML = ''
  const chart = document.createElement('script')
  chart.src = "https://cdn.jsdelivr.net/npm/chart.js"
  document.head.appendChild(chart)
  const canvas = document.createElement('canvas')
  canvas.id = "myChart"
  divContainer.appendChild(canvas)
  $('cesiones').appendChild(divContainer)
  fetch('../api/getAssigStatus.php',{
    method: 'POST'
  })
  .then((e) => e.json())
  .then((res) => {

    const input = document.createElement('select')
    input.style = "width: 150px;border: 2px solid var(--main-font-color);border-radius: 8px;font-size: 2em; text-transform: uppercase;"
    input.addEventListener("change",(e)=>{
      if(window.graph){
        window.graph.clear()
        window.graph.destroy()
      }
      const data = {
        datasets: []
      }
      let avg = 0
      if(res[e.target.value][1].slice(0,20).length > 0){
        let sum = res[e.target.value][1].slice(0,20).reduce((previous, current) => parseInt(current) + parseInt(previous));
        avg = Math.round((sum / res[e.target.value][1].length) * 100)/100;
      }

      data.labels = res[e.target.value][2]
      data.datasets.push({
        label: "Media: " + avg,
        data: res[e.target.value][1],
        backgroundColor: colorArray,
        stack: 'Stack 0',
      })
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
    var colorArray = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
		  '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
		  '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A', 
		  '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
		  '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC', 
		  '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
		  '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680', 
		  '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
		  '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3', 
		  '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];

    const data = {
      datasets: []
    }
    
    let usuario = 0
    for(let i = 0; i < res.length; i++) {
      let name = res[i][0]
      let option = document.createElement('option')
      option.innerHTML = name
      option.setAttribute('value',i)
      input.appendChild(option)
      if(name.toUpperCase() == $('menu').childNodes[1].childNodes[1].innerText.toUpperCase()){
        usuario = i
        option.setAttribute('selected',true)
      }
    }
    $('contacts').appendChild(input)

    
    let sum = res[usuario][1].slice(0,20).reduce((previous, current) => parseInt(current) + parseInt(previous));
    let avg = Math.round((sum / res[usuario][1].slice(0,20).length) * 100)/100;
    data.labels = res[usuario][2]
    data.datasets.push({
      label: "Media: " + avg,
      data: res[usuario][1],
      backgroundColor: colorArray,
      stack: 'Stack 0',
    })

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
})

document.addEventListener('keyup',(e)=>{
  if(!$$('form')[0].childNodes[1] == false && !$$('form')[0].childNodes[1].className != 'form-group'){
    for (var element = 0;element < $$('form')[0].length;element++){
      $$('form')[0][element].value != '' ? $$('form')[0][element].classList.add('fondo') : $$('form')[0][element].classList.remove('fondo')
    }
  }
})

document.addEventListener('click', (e) => {
  if(e.target.title.includes("Referencia: ")){
    const copiar = e.target.title.replace("Referencia: ","")
    navigator.clipboard.writeText(copiar)
    notify(`${copiar} copiado!`)
  }
})