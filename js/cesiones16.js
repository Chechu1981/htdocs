const cesiones = (origen, destino) =>{
  let cesion = null
  origen != destino ? cesion = origen + '' + destino:''
  fetch('../json/cesiones.json')
    .then(response => response.json())
    .then(response => {
      const numDest = response[cesion]
      numDest != undefined ? $('provider').innerText = response[cesion] : $('provider').innerText = ""
    })
  fetch('../json/cesionesCliente.json')
  .then(response => response.json())
  .then(response => {
    const numDest = response[cesion]
    numDest != undefined ? $('pclient').innerText = response[cesion] : $('pclient').innerText = ""
  })
}

$('origen').addEventListener('change',()=>{
    cesiones($('origen').value,$('destino').value)
})

$('destino').addEventListener('change',()=>{
    cesiones($('origen').value,$('destino').value)
})

const showAssig = () =>{
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  fetch('../api/getAssig.php',{
    method: 'POST',
    body: data
  })
    .then(response => response.text())
    .then(response => $('cesiones').innerHTML = response)
}

$$('form')[0].addEventListener('submit',(e)=>{   
  e.preventDefault()
  const fecha = new Date()
  const origen = $('origen').value
  const destino = $('destino').value
  const referencia = $('ref').value
  const cliente = $('client').value
  const pedido = $('order').value
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
    La entrada en Geode debe ser realizada como entrada esperada 107 y no con el 109. 
    Pedido Icar ${pedido}.
    Saludos.`)
  const mailBodyNfm = encodeURIComponent(`Va a llegar de la placa de ${origen} a ${destino} la referencia ${referencia} para la cuenta ${cliente}.
    La entrada en Geode debe ser realizada como entrada 109.   
    Saludos.`)
  let mailTarget
  Number.isInteger(parseInt($('order').value)) ? mailTarget = mailBody : mailTarget = mailBodyNfm
  if(origen != '' && destino != '' && referencia != '' && cliente != '' && pvp != '' && pedido != ''){
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
    data.append('pvp',$('pvp').value)
    data.append('pedido',pedido)
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
    alert('Debes rellenar todos los campos')
  }
})

showAssig()

const botones = {
  nueva:$('contacts').childNodes[3].childNodes[1].childNodes[1],
  buscar:$('contacts').childNodes[3].childNodes[1].childNodes[3],
  recibidas:$('contacts').childNodes[3].childNodes[1].childNodes[5],
  pendientes:$('contacts').childNodes[3].childNodes[1].childNodes[7]
}

botones.nueva.addEventListener('click',()=>{
  window.location.reload()
})

botones.buscar.addEventListener('click',() => {
  const boton = `<div id="search-line" class="nPass search-line search-focused">
  <span class="lupa">
    <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
      <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
    </svg>
  </span>
  <div class="textbox" id="search-box">
    <input type="text" id="search-assig" placeholder="Buscar cesión...">
  </div>
</div>`
  $('contacts-items').childNodes[1].classList.add('change')
  setTimeout(function(){
    $('contacts-items').childNodes[1].classList.remove('change')
    $('contacts-items').childNodes[1].innerHTML = boton
    $('search-assig').focus()
    $('search-assig').addEventListener('keyup',(e)=>{
      const data = new FormData()
      data.append('id',e.target.value)
      data.append('session',window.location.href.split('=')[1])
      fetch('../api/getAssig.php',{
        method: 'POST',
        body: data
      })
      .then((e) => e.text())
      .then((res) => {      
        $('cesiones').innerHTML = res
      })
    },500)  
  })
})

$('client').addEventListener('blur',(e)=>{
  const data = new FormData()
  data.append('search',$('client').value != '' ? $('client').value : null)
  fetch('../api/getClientName.php',{method: 'POST', body:data})
  .then(respose => respose.text())
  .then((res) => $('clientName').innerHTML = res)
})

botones.recibidas.addEventListener('click', () =>{
  $('contacts-items').childNodes[1].innerHTML = ''
  const data = new FormData()
  data.append('id','all')
  data.append('session',window.location.href.split('=')[1])
  fetch('../api/getAssig.php',{
    method: 'POST',
    body: data
  })
  .then((e) => e.text())
  .then((res) => $('cesiones').innerHTML = res)
})

botones.pendientes.addEventListener('click', () =>{
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
  })
})

document.addEventListener('keyup',(e)=>{
  if(!$$('form')[0].childNodes[1] == false && !$$('form')[0].childNodes[1].className != 'form-group'){
    for (var element = 0;element < $$('form')[0].length;element++){
      $$('form')[0][element].value != '' ? $$('form')[0][element].classList.add('fondo') : $$('form')[0][element].classList.remove('fondo')
    }
  }
})