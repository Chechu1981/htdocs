const cesiones = (origen, destino,nfm) =>{
  $('newTitle').innerText = `${origen}>${destino}`
  let cesion = null
  origen != destino ? cesion = origen + '' + destino:''
  nfm ? cesion += 'NM' :''
  fetch('../json/cesionesCliente.json')
  .then(response => response.json())
  .then(response => {
    const numDest = response[cesion]
    let alerta = ""
    const date = new Date()
    if(numDest == "6254-1" || numDest == "78713-1"){
      $('pclient').classList.add('important')
      alerta = "Preguntar"
    }else if(destino == "VIGO" && date.getDate() >= 6){
      $('pclient').classList.add('important')
      alerta = "Denegado"
    }else if(origen == "VIGO" && date.getDate() >= 9){
      $('pclient').classList.add('important')
      alerta = "Denegado"
    }else if(origen == 'PALMA'){
      $('pclient').classList.add('important')
      alerta = "Portes"
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
  $('newTitle').style.fontWeight = ''
  $('newTitle').classList.remove('copy')
  if($('origen').value != $('destino').value){
    cesiones($('origen').value,$('destino').value,$('nfm').checked)
  }else{
    $('provider').innerText = ""
    $('pclient').innerText = ""
    $('newTitle').innerText = "Nueva cesión"
  }
})

$('destino').addEventListener('change',()=>{
  $('newTitle').style.fontWeight = ''
  $('newTitle').classList.remove('copy')
  $('frag').checked ? disgon(true) : disgon(false)
  buscarCliente($('destino').value.substring(0,3),$('client').value)
  if($('origen').value != $('destino').value){
    cesiones($('origen').value,$('destino').value,$('nfm').checked)
  }else{
    $('provider').innerText = ""
    $('pclient').innerText = ""
    $('newTitle').innerText = "Nueva cesión"
  }
})

const disgon = (esDisgon) =>{
  const dsgDiv = document.createElement('div')
  const dsgButton = document.createElement('input')
  const dsgLabel = document.createElement('label')
  dsgButton.type = 'checkbox'
  dsgButton.id = 'disgonBox'
  dsgLabel.textContent = 'Disgon'
  dsgLabel.id = 'disgonLabel'
  dsgDiv.id = 'disgonDiv'
  dsgDiv.style = 'display: flex;margin-top: -26px;'
  dsgDiv.appendChild(dsgLabel)
  dsgDiv.appendChild(dsgButton)
  const destino = $('destino').value
  if(esDisgon && $('disgonBox') == null)
    document.getElementsByClassName('form-group')[0].childNodes[15].appendChild(dsgDiv)
  else if(!esDisgon && $('disgonBox'))
    $('disgonDiv').remove()
}

$('frag').addEventListener('change', e =>{
  e.target.checked ? disgon(true) : disgon(false)
})

const buscarCliente = (placa,cliente) => {
  const data = new FormData()
  const section = $('envio').parentNode
  data.append('search',cliente != '' ? cliente : null)
  data.append('placa', placa.toUpperCase())
  fetch('../api/getClientName.php',{method: 'POST', body:data})
  .then(respose => respose.json())
  .then((res) => {
    if(res[0].cliente == undefined){
      $('clientName').innerHTML = 'desconocido'
      $('envio').remove()
      const inputEnvio = document.createElement('input')
      inputEnvio.setAttribute('id','envio')
      section.appendChild(inputEnvio)
    }else{
      $('clientName').innerHTML = res[0].cliente
      const selected = document.createElement('select')
      selected.setAttribute('id', 'envio')
      selected.appendChild(document.createElement('option'))
      res.map(element => {
        const option = document.createElement('option')
        option.value = element.envio
        option.text = `${element.envio}: ${element.denvio}(${element.poblacion})`
        selected.appendChild(option)
      });
      $('envio').remove()
      section.appendChild(selected)
    }
  })
}

$('client').addEventListener('blur',(e)=>{
  buscarCliente($('destino').value.substring(0,3),$('client').value.split('-')[0])
})

$('ref').addEventListener('blur',() =>{
  buscarDenominacionReferencia($('ref').value)
})

const buscarDenominacionReferencia = (refer) =>{
  const data = new FormData()
  data.append('referencia', refer)
  fetch('../api/getDescRefer.php',{
    method: 'POST',
    body: data
  })
  .then(res => res.text())
  .then((res) => {
    $('descRef').innerHTML = res
    if($('origen').value == 'PALMA' || $('destino').value == 'PALMA'){
      let portes = '40€'
      const pvp = parseFloat(res.split('PVP: ')[1].split('€')[0].replaceAll(',','.'))
      if(pvp < 150)
        portes = '30€'
      else if(pvp > 400)
        portes = '55€'
      if($('coment').value != '')
        $('coment').value += ` \n¡¡OJO!! ${portes} de portes.`
      else
        $('coment').value += `¡¡OJO!! ${portes} de portes.`
    }
  })
}

const showAssig = () =>{
  const divSpinner = document.createElement('div')
  fetch('../api/spinner.php')
  .then(fn => fn.text())
  .then(req => {
    divSpinner.innerHTML = req
    divSpinner.className = 'spinner-center'
    $('contacts-items').append(divSpinner)
    $('cesiones').className = 'filter'
  })
  $('descRef').innerHTML = ""
  $('clientName').innerHTML = ""
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  data.append('sort', 'date')
  fetch('../api/getAssigADV_test.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(response => {
    $('contacts-items').removeChild(divSpinner)
    $('cesiones').classList.remove('filter')
    const clearRowsMark = (li,text) =>{
      const codeClient = li.childNodes[1].childNodes[6].textContent
      const id = li.childNodes[25].id
      const filas = $('cesiones').getElementsByTagName('ul')
      copyClipboard(text)
      for(let i = 1; i < filas.length; i++){
        const codeClientLi = filas[i].childNodes[1].childNodes[6].textContent
        const idLi = filas[i].childNodes[25].id
        filas[i].classList.remove('marcado')
        filas[i].classList.remove('equal')
        codeClientLi == codeClient && idLi != id ? filas[i].classList.add('equal') : ''
      }
      li.classList.add('marcado')
    }
    $('cesiones').style = ''
    $('cesiones').innerHTML = response
    for(let i = 2; i < $('cesiones').childNodes.length; i = i+2){
      let ul, id, origen, destino, cliente, refCliente, comentario, referencia, cantidad, pedido, fragil, pvp, tratado, nfm, disgon, btnSendMail, btnEliminar = ''
        ul = $('cesiones').childNodes[i]
        id = ul.childNodes[25].id
        origenLed = ul.childNodes[1].childNodes[1]
        origen = ul.childNodes[1].childNodes[2]
        destino = ul.childNodes[1].childNodes[4]
        cliente = ul.childNodes[5]
        refCliente = ul.childNodes[1].childNodes[6]
        comentario = ul.childNodes[9]
        referencia = ul.childNodes[11]
        cantidad = ul.childNodes[13].textContent
        pedido = ul.childNodes[15].firstChild
        fragil = ul.childNodes[19].firstChild
        disgon = ul.childNodes[21].firstChild
        pvp = ul.childNodes[11].childNodes[1].textContent
        tratado = $(`agente${id}`)
        nfm = ul.childNodes[17].firstChild
        btnSendMail = ul.childNodes[27] != undefined ? ul.childNodes[27].childNodes[0] : null
        btnSendMailDisgon = ul.childNodes[27] != undefined ? ul.childNodes[27].childNodes[1] : null
        btnEliminar = ul.childNodes[25].firstChild

      if(disgon != null)
        disgon.addEventListener('change',() => updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value, destino))
      if($('cesiones').childNodes[i].localName == 'ul' && $('cesiones').childNodes[i].localName != undefined)
        pedido.addEventListener('keyup', e => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))

      nfm.addEventListener('change', () => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))
      fragil.addEventListener('change', () => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent))
      tratado.addEventListener('change', () => {refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent)})
      referencia.addEventListener('click', () => {clearRowsMark(ul,referencia.childNodes[0].textContent.replaceAll(' ',''))})
      comentario.addEventListener('click', () => {clearRowsMark(ul,comentario.textContent)})
      cliente.addEventListener('click', () => {
        let fragilTxt = ''
        fragil.checked ? fragilTxt = '..~** ¡¡MATERIAL FRÁGIL!! **~.. Por favor, en lo posible, reforzar embalaje. Gracias; ' : ''
        clearRowsMark(ul,`Cesión ${origen.value}>${destino.textContent} - Cliente: ${cliente.childNodes[0].textContent} (${cliente.childNodes[1].textContent}) ${fragilTxt}`)
      })
      refCliente.addEventListener('click', () => {clearRowsMark(ul,`Cliente: ${cliente.childNodes[0].textContent}`)})
      
      if(user.puesto == 'ADV'){
        origen.addEventListener('change', (e) => {
          refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent)
          })
        origenLed.addEventListener('click', (e) => {
          e.target.classList.toggle('ledOn')
          updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
        })
        destino.addEventListener('click', () => {
          destino.classList.toggle('active-city-press')
          updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
        })
      }
      if(btnSendMail != null){
        btnSendMail.addEventListener('click',() => enviarMail(pedido.value, origen.value, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), `${cliente.firstChild.textContent} (${cliente.childNodes[1].textContent})`, fragil.checked, pvp, id, cantidad, nfm.checked, tratado.value, id))
        if(btnSendMailDisgon != null)
          btnSendMailDisgon.addEventListener('click',() => enviarMailDisgon(cantidad, origen.value, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), id))
      }
      btnEliminar.addEventListener('click', () => eliminarLinea(id,referencia.firstChild.textContent.replaceAll(' ',''),tratado.value))
    }
  })
}

const enviarMail = (pedido, origen, destino, referencia, cliente, fragil, pvp, id, cantidad, nfm, tratado) =>{
  if($(`disgon${id}`).innerHTML == "🚚"){
    customAlert("Debes enviar primero el correo a Disgón")
    return false
  }
  const dataName = new FormData()
  const disgon = $(id).parentNode.childNodes[21].firstChild == null ? false : $(id).parentNode.childNodes[21].firstChild.checked
  dataName.append('id', id)
  dataName.append('nfm',nfm)
  dataName.append('fragil',fragil)
  dataName.append('pedido',pedido)
  dataName.append('tratado',tratado)
  dataName.append('envio', true)
  dataName.append('disgon', disgon)
  dataName.append('origenBtn', '1')
  dataName.append('destinoBtn', '1')
  dataName.append('origen', origen)
  dataName.append('destino', destino)
  dataName.append('destinoC', `${destino}C`)
  dataName.append('origenF', `${origen}F`)
  fetch('../api/isSend.php',{
    method: 'POST',
    body: dataName
  })
  .then((isSend)=>isSend.text())
  .then(enviado => {
    if(enviado){
      customAlert("Esta cesión ya está enviada")
      $(`send${id}`).parentNode.remove()
      return true
    }
    if(confirm(`¿Enviar Correo?`)){
      fetch('../api/updateAssignADV2023.php', {
        method: 'POST',
        body:dataName
      })
      .then((item) => item.text())
      .then((item) => {
        fetch('../api/getBccMails.php',{
          method: 'POST',
          body: dataName
        })
        .then(response => response.json())
        .then(res => {
          let destinoFragil = ''
          if(fragil){
            destinoFragil = res['fragil']
          }
          createMail(cantidad,origen,destino,referencia,cliente,pedido,nfm,fragil,destinoFragil,res['origen'],res['destino'],res['conCopia'],disgon)
          $(`send${id}`).parentNode.parentNode.remove()
          updateBubble('-')
        })
      })
    }
  })
}

const refreshInputs = (id,nfm,fragil,pedido,tratado,origen,destino) => {
  let cesion = null
  let code = $(id).parentNode.childNodes[1].childNodes[6]
  origen != destino ? cesion = origen + '' + destino:''
  nfm ? cesion += 'NM' :''
  fetch('../json/cesionesCliente.json')
  .then(response => response.json())
  .then(response => {
    response[cesion] != undefined ? code.innerHTML = response[cesion] : code.innerHTML = ""
  })
  updateChkbx(id,nfm,fragil,pedido,tratado,destino)
}

const copyClipboard = (copiar) =>{
  navigator.clipboard.writeText(copiar)
  notify(`${copiar} copiado!`)
}

const updateBubble = (operador) =>{
  const bubble = $('contacts').childNodes[3].childNodes[1].childNodes[0]
  const bubbleAll = $('contacts').childNodes[3].childNodes[3].childNodes[0]
  const bubbleReady = $('contacts').childNodes[3].childNodes[7].childNodes[0]
  if(operador == '-'){
    bubble != undefined ? bubble.innerText = parseInt(bubble.innerText) - 1 : ''
    bubbleAll != undefined ? bubbleAll.innerText = parseInt(bubbleAll.innerText) - 1 : ''
    bubbleReady != undefined ? bubbleReady.innerText = parseInt(bubbleReady.innerText) - 1 : ''
  }else{
    bubble != undefined ? bubble.innerText = parseInt(bubble.innerText) + 1 : ''
    bubbleAll != undefined ? bubbleAll.innerText = parseInt(bubbleAll.innerText) + 1 : ''
    bubbleReady != undefined ? bubbleReady.innerText = parseInt(bubbleReady.innerText) + 1 : ''
  }
}

const updateChkbx = (id,nfm,fragil,pedido,tratado,destino) => {
  const disgon = $(id).parentNode.childNodes[21].firstChild == null ? false : $(id).parentNode.childNodes[21].firstChild.checked
  const origenBtn = $(id).parentNode.childNodes[1].childNodes[1].className.includes('ledOn') ? '1':'0'
  const destinoBtn = $(`destinoBtn${id}`).className.includes('press') ? '1':'0'
  const origen = $(`origen${id}`).nodeName == 'SELECT' ? $(`origen${id}`).value : $(`origen${id}`).innerHTML
  const data = new FormData()
  data.append('id', id)
  data.append('nfm',nfm)
  data.append('fragil',fragil)
  data.append('pedido',pedido)
  data.append('tratado',tratado)
  data.append('envio', false)
  data.append('disgon', disgon)
  data.append('origenBtn', origenBtn)
  data.append('destinoBtn', destinoBtn)
  data.append('origen', origen)
  fetch('../api/updateAssignADV2023.php',{
    method: 'POST',
    body: data
  })
  const disgonLi = $(`${id}`).parentNode.childNodes[21]
  const disgonSend = $(`${id}`).parentNode.childNodes[27] != undefined ? $(`${id}`).parentNode.childNodes[27].childNodes[1]: null
  if(fragil && disgonLi.firstChild == undefined) {
    const chkDisgon = document.createElement('input')
    chkDisgon.setAttribute('type', 'checkbox')
    chkDisgon.addEventListener('change', () => {
      updateChkbx(id,nfm,fragil,pedido,tratado, destino)
    })
    disgonLi.appendChild(chkDisgon)
  }
  if(disgonSend != null && user.puesto == 'ADV'){
    if(fragil && disgonLi.childNodes[0].checked)
      disgonSend.innerText = '🚚'
    else if(fragil && !disgonLi.childNodes[0].checked)
      disgonSend.innerText = ''
    if(!fragil && disgonLi.firstChild != null){
      disgonLi.firstChild.remove()
      disgonSend.innerHTML = ''
    }
  }
}

const createMail = (cantidad,origen,destino,referencia,cliente,pedido,nfm,fragil,destinoFragil,mailOrigen,mailDestino,bcc,disgon) =>{
  let mailTarget, asuntoDisgon = ''
  let strDisgon = ``
  let mailFragil = encodeURIComponent(``)
  let strNfm = 'La entrada en Geode debe ser realizada como entrada esperada 103 y no con el 109. '
  let strCantidad = 'la referencia'
  if(cantidad > 1){
    strCantidad = `${cantidad} unidades de la referencia`
  }
  if(fragil){
    mailFragil = encodeURIComponent(`
    *******__‼️ ATENCIÓN ‼️__*******
    ******************************
    **⚠️⚠️ MATERIAL FRÁGIL ⚠️⚠️**
    ******************************
    
    `)
  }
  if(disgon){
    asuntoDisgon = `DISGON`
    strDisgon = `🚚🚩🚩ATENCIÓN RECOGE DISGON O LOGISTICA🚩🚩🚚`
  }
  if(nfm)
    strNfm = `La entrada en Geode debe ser realizada como entrada 109. PIEZA SIN SOLUCIÓN DE REEMPLAZO.   `

  const fecha = new Date()
  const mailSub = `${asuntoDisgon} CESION ${origen} -> ${destino}`
  const mailSaludo = fecha.getHours() > 14 ? `${mailFragil}Buenas tardes: ` : `${mailFragil}Buenos días: `
  mailTarget = encodeURIComponent(`
Va a llegar de la placa de ${origen} a ${destino} ${strCantidad} ${referencia} para la cuenta ${cliente}.
${strNfm}
${strDisgon}
Saludos.`)

  window.open(`mailto:${destinoFragil};${mailDestino};${mailOrigen}?subject=${mailSub}&cc=${bcc}&body=${mailSaludo + mailTarget}`)  
}

const enviarMailDisgon = (cantidad,origen,destino,referencia,id) =>{
  $(`disgon${id}`).className = "wait"
  const direcciones = {
    MADRID: 'Carretera de Seseña a Esquivias, Km 0,8 - 45224 Seseña Nuevo (Toledo)',
    VALENCIA: 'Carrer dels Bombers, 20 - 46980 PATERNA - VALENCIA',
    VIGO: 'Avenida de Citroën, 3 y 5, Naves 05/09 Zona Franca de Vigo 36210 VIGO (PONTEVEDRA)',
    BARCELONA: 'Calle D, nº 41 - Polig. Ind. Zona Franca - 08040 BARCELONA',
    ZARAGOZA: 'C/ Río de Janeiro, 3 Polígono Industrial Centrovia 50198 - La Muela - ZARAGOZA',
    GRANADA: 'Polígono Industrial Huerta Ardila - Ctra. A-92 Km 6 - 18320 SANTA FE - GRANADA',
    SEVILLA: 'Parque Logístico de Carmona - MANZANA B, NAVE 1.Autovía A-4 Km. 521    41410 Carmona - Sevilla',
    PALMA:'Avda. 16 de Julio, 5 - 07009 SON CASTELLO- PALMA DE MALLORCA'
  }

  const hora = new Date().getHours()
  let saludo = `Buenos días`
  if(hora > 14)
    saludo = `Buenas tardes`

  const datos = new FormData()
  datos.append('search',referencia)
  fetch('../api/getRefer.php',{
    method: 'POST',
    body: datos
  })
  .then(item => item.json())
  .then(result => {
    $(`disgon${id}`).innerHTML = "✅"
    $(`disgon${id}`).className = ""
    const descRef = result.denominacion
    const dirOrigen = direcciones[origen]
    const dirDestino = direcciones[destino]
    const importe = Math.ceil(result.pvp * ((100 - result.dtoNum) / 100))
    const asunto = "RECOGIDA PPCR - DISGON"
    const mail = encodeURIComponent(`${saludo}:
    Necesitamos recoger la referencia ${result.referencia} cantidad ${cantidad} ${descRef} en PPCR ${origen}
    ${dirOrigen}
    
    Para enviarlo a PPCR ${destino}
    ${dirDestino}
  
    ENVÍO ASEGURADO EN    ${importe}€
    
    
    Saludos.`)
    if(confirm(`¿Enviar Correo a Disgón?`)){
      window.open(`mailto:pedidos@disgon.com; info@disgon.com; julio@disgon.com; carlosalberto.fernandez@stellantis.com?subject=${asunto}&body=${mail}`)
      $(`disgon${id}`).innerHTML = "✅"
    }
  })
}

const eliminarLinea = (id,referencia,tratado) =>{
  const dataName = new FormData()
  dataName.append('id',id)
  fetch('../api/isSend.php',{
    method: 'POST',
    body: dataName
  })
  .then((isSend)=>isSend.text())
  .then(enviado => {
    if(enviado){
      customAlert("Ya está enviado. No se puede eliminar.")
      showAssig()
      return true
    }
    fetch('../api/isInProgress.php',{
      method: 'POST',
      body: dataName
    })
    .then(response => response.json())
    .then(consulta =>{
      const origenActivo = parseInt(consulta.emisor)
      const destinoActivo = parseInt(consulta.receptor)
      if(origenActivo || destinoActivo){
        customAlert("Ya está en curso. Habla con ADV si quieres eliminar.")
        showAssig()
        return true
      }
      const confirmacion = confirm(`¿Quieres eliminar la referencia ${referencia}?`)
      if(!confirmacion) 
        return true
      const data = new FormData()
      data.append('id',id)
      data.append('puesto',tratado)
      fetch('../api/deleteAssignADV.php', {
        method: 'POST',
        body: data
      })
      .then(e => e.text())
      .then(()=>{
        $(id).parentNode.remove()
        updateBubble('-')
      })
    })
  })
}

const updateAssig = (id,values) => {
  console.log(id + ': ' + values)
}

const disabledForm = () =>{
  const formInputs = $('contacts-items').getElementsByTagName('form')[0].getElementsByTagName('input')
  const formSelects = $('contacts-items').getElementsByTagName('form')[0].getElementsByTagName('select')
  for(let i = 0; i < formInputs.length; i++)
    formInputs[i].disabled = true
  for(let i = 0; i < formSelects.length; i++)
    formSelects[i].disabled = true
}

const enabledForm = () =>{
  const formInputs = $('contacts-items').getElementsByTagName('form')[0].getElementsByTagName('input')
  const formSelects = $('contacts-items').getElementsByTagName('form')[0].getElementsByTagName('select')
  for(let i = 0; i < formInputs.length; i++)
    formInputs[i].disabled = false
  for(let i = 0; i < formSelects.length; i++)
    formSelects[i].disabled = false
}

$$('form')[0].addEventListener('submit',(e)=>{
  document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = true
  $('pclient').classList.remove('important')
  e.preventDefault()
  const origen = $('origen').value
  const destino = $('destino').value
  const envio = $('envio').value
  const cliente = $('client').value
  const pedido = $('pedido').value
  const ref = $('ref').value
  const cantidad = $('units').value
  const nfm = $('nfm').checked
  if(origen === destino){
    customAlert('El destino y el origen debe ser diferente')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    return false
  }
  if(cliente === ''){
    customAlert('Debes rellenar el cliente')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    $('client').focus()
    return false
  }
  if(envio === ''){
    customAlert('La dirección de envio no puede estar vacía')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    $('envio').focus()
    return false
  }
  else if(ref === ''){
    customAlert('Debes rellenar la referencia')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    $('ref').focus()
    return false
  }
  else if(cantidad === ''){
    customAlert('Debes rellenar la cantidad')
    document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
    $('units').focus()
    return false
  }
  disabledForm()
  const divSpinner = document.createElement('div')
  fetch('../api/spinner.php')
  .then(fn => fn.text())
  .then(req => {
    divSpinner.innerHTML = req
    divSpinner.className = 'spinner-center'
    $('contacts-items').append(divSpinner)
    $('cesiones').className = 'filter'
  })
  let disgonStatus = false
  const data = new FormData() 
  data.append('origen',origen)
  data.append('destino',destino)
  data.append('cliente',`${cliente}-${envio}`)
  data.append('refClient','')
  data.append('comentario',$('coment').value)
  data.append('ref',ref)
  data.append('cantidad',cantidad)
  data.append('pvp','')
  data.append('pedido',pedido)
  data.append('nfm',nfm)
  data.append('frag',$('frag').checked)
  data.append('session',window.location.href.split('=')[1])
  $('disgonBox') == null ? null : disgonStatus = $('disgonBox').checked
  data.append('disgon', disgonStatus)
  fetch('../api/addAsignADV2023.php',{
    method: 'POST',
    body:data
  })
  .then(response => response.text())
  .then(res =>{
    if(res == 'ok'){
      showAssig()
      enabledForm()
      $('newTitle').innerHTML = "Nueva cesión"
      $('pclient').innerHTML = ""
      $('contacts-items').removeChild(divSpinner)
      $('cesiones').classList.remove('filter')
      document.getElementsByTagName('form')[0].getElementsByTagName('input')[6].disabled = false
      updateBubble('+')
      e.target.reset()
      $('destino').value = user.puesto
      if($('disgonBox'))
        $('disgonDiv').remove()
    }
  })
})

showAssig()

const id = window.location.search.split('?id=')[1]
const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `./cesionesAll.php?id=${id}`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./assigns/buscar.php?id=${id}`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./assigns/ready.php?id=${id}`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./assigns/finish.php?id=${id}`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./assigns/status.php?id=${id}`
})

/* Se colorea los fondos de los input cuando hay algo escrito */
$$('form')[0].addEventListener('keyup',(e)=>{
  if(!$$('form')[0].childNodes[1] == false && !$$('form')[0].childNodes[1].className != 'form-group'){
    for (var element = 0;element < $$('form')[0].length;element++){
      $$('form')[0][element].value != '' ? $$('form')[0][element].classList.add('fondo') : $$('form')[0][element].classList.remove('fondo')
    }
  }
})