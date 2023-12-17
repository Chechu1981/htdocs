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
    if(numDest == "6254-1" || numDest == "78713-1"){
      $('pclient').classList.add('important')
      alerta = "Preguntar"
    }/*else if(origen == "VIGO"){
      $('pclient').classList.add('important')
      alerta = "Preguntar"
    }*/else{
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
  if(esDisgon && destino == 'VIGO')
    document.getElementsByClassName('form-group')[0].childNodes[15].appendChild(dsgDiv)
  else if($('disgonBox'))
    $('disgonDiv').remove()
}

$('frag').addEventListener('change', e =>{
  e.target.checked ? disgon(true) : disgon(false)
})

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
      const codeClient = li.childNodes[1].childNodes[5].textContent
      const id = li.childNodes[25].id
      const filas = $('cesiones').getElementsByTagName('ul')
      copyClipboard(text)
      for(let i=1; i<filas.length; i++){
        const codeClientLi = filas[i].childNodes[1].childNodes[5].textContent
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
      let li, id, origen, destino, cliente, refCliente, comentario, referencia, cantidad, pedido, fragil, pvp, tratado, nfm, disgon = ''
      li = $('cesiones').childNodes[i]
      id = $(`cesiones`).childNodes[i].childNodes[25].id
      origen = $('cesiones').childNodes[i].childNodes[1].childNodes[1]
      destino = $('cesiones').childNodes[i].childNodes[1].childNodes[3]
      cliente = $('cesiones').childNodes[i].childNodes[5]
      refCliente = $('cesiones').childNodes[i].childNodes[1]
      comentario = $('cesiones').childNodes[i].childNodes[9]
      referencia = $('cesiones').childNodes[i].childNodes[11]
      cantidad = $('cesiones').childNodes[i].childNodes[13].textContent
      pedido = $('cesiones').childNodes[i].childNodes[15].firstChild
      fragil = $('cesiones').childNodes[i].childNodes[19].firstChild
      disgon = $('cesiones').childNodes[i].childNodes[21].firstChild
      pvp = $(`cesiones`).childNodes[i].childNodes[11].childNodes[1].textContent
      tratado = $(`cesiones`).childNodes[i].childNodes[23].firstChild
      nfm = $(`cesiones`).childNodes[i].childNodes[17].firstChild
      btnSendMail = $(`cesiones`).childNodes[i].childNodes[27]
      btnEliminar = $(`cesiones`).childNodes[i].childNodes[25]

      if(disgon != null)
        disgon.addEventListener('change',() => updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value, destino))
      if($('cesiones').childNodes[i].localName == 'ul' && $('cesiones').childNodes[i].localName != undefined)
        pedido.addEventListener('keyup', e => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.textContent,destino.textContent))

      nfm.addEventListener('change', () => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.textContent,destino.textContent))
      fragil.addEventListener('change', () => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.textContent,destino.textContent))
      tratado.addEventListener('keyup', () => refreshInputs(id,nfm.checked,fragil.checked,pedido.value,tratado.value,origen.textContent,destino.textContent))
      referencia.addEventListener('click', () => {clearRowsMark(li,referencia.childNodes[0].textContent.replaceAll(' ',''))})
      comentario.addEventListener('click', () => {clearRowsMark(li,comentario.textContent)})
      cliente.addEventListener('click', () => {
        let fragilTxt = ''
        fragil.checked ? fragilTxt = '..~** ¡¡MATERIAL FRÁGIL!! **~.. Por favor, en lo posible, reforzar embalaje. Gracias; ' : ''
        clearRowsMark(li,`Cesión ${origen.textContent}>${destino.textContent} - Cliente: ${cliente.childNodes[0].textContent} (${cliente.childNodes[1].textContent}) ${fragilTxt}`)
      })
      refCliente.addEventListener('click', () => {clearRowsMark(li,`Cliente: ${cliente.childNodes[0].textContent}`)})
      origen.addEventListener('click', () => {
        origen.classList.toggle('active-city-press')
        updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
      })
      destino.addEventListener('click', () => {
        destino.classList.toggle('active-city-press')
        updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
      })
      btnSendMail.addEventListener('click',() => enviarMail(pedido.value, origen.textContent, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), `${cliente.firstChild.textContent} (${cliente.childNodes[1].textContent})`, fragil.checked, pvp, id, cantidad, nfm.checked, tratado.value))
      btnEliminar.addEventListener('click', () => eliminarLinea(id,referencia.firstChild.textContent.replaceAll(' ','')))
    }
  })
}

const enviarMail = (pedido, origen, destino, referencia, cliente, fragil, pvp, id, cantidad, nfm, tratado) =>{
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
          console.log(res)
          let destinoFragil = ''
          if($('frag').checked){
            destinoFragil = res['fragil']
          }
          createMail(cantidad,origen,destino,referencia,cliente,pedido,nfm,fragil,destinoFragil,res['origen'],res['destino'],res['conCopia'],disgon)
          $(`send${id}`).parentNode.remove()
          const bubble = $('contacts').childNodes[3].childNodes[1].childNodes[1].childNodes[1]
          bubble != undefined ? bubble.innerText = parseInt(bubble.innerText) - 1 : ''
        })
      })
    }
  })
}

const refreshInputs = (id,nfm,fragil,pedido,tratado,origen,destino) => {
  let cesion = null
  let code = $(id).parentNode.childNodes[1].childNodes[5]
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

const updateChkbx = (id,nfm,fragil,pedido,tratado,destino) => {
  const disgon = $(id).parentNode.childNodes[21].firstChild == null ? false : $(id).parentNode.childNodes[21].firstChild.checked
  const origenBtn = $(id).parentNode.childNodes[1].childNodes[1].className.includes('press') ? '1':'0'
  const destinoBtn = $(id).parentNode.childNodes[1].childNodes[3].className.includes('press') ? '1':'0'
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
  fetch('../api/updateAssignADV2023.php',{
    method: 'POST',
    body: data
  })
  const disgonLi = $(`${id}`).parentNode.childNodes[21]
  if(fragil && destino == 'VIGO' && disgonLi.firstChild == undefined) {
    const chkDisgon = document.createElement('input')
    chkDisgon.setAttribute('type', 'checkbox')
    chkDisgon.addEventListener('change', () => {
      updateChkbx(id,nfm,fragil,pedido,tratado, destino)
    })
    disgonLi.appendChild(chkDisgon)
  }
  if(!fragil && disgonLi.firstChild != null)
    disgonLi.firstChild.remove()
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
  const mailSub = `CESION ${asuntoDisgon} ${origen} -> ${destino}`
  const mailSaludo = fecha.getHours() > 14 ? `${mailFragil}Buenas tardes: ` : `${mailFragil}Buenos días: `
  mailTarget = encodeURIComponent(`
Va a llegar de la placa de ${origen} a ${destino} ${strCantidad} ${referencia} para la cuenta ${cliente}.
${strNfm}
${strDisgon}
Saludos.`)
  
  window.open(`mailto:${destinoFragil};${mailDestino};${mailOrigen}?subject=${mailSub}&cc=${bcc}&body=${mailSaludo + mailTarget}`)  
}
const eliminarLinea = (id,referencia) =>{
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
    const confirmacion = confirm(`¿Quieres eliminar la referencia ${referencia}?`)
    if(!confirmacion) 
      return true
    const data = new FormData()
    data.append('id',id)
    fetch('../api/deleteAssignADV.php', {
      method: 'POST',
      body: data
    })
    .then(e => e.text())
    .then(()=>{
      $(id).parentNode.remove()
      const bubble = $('contacts').childNodes[3].childNodes[1].childNodes[1].childNodes[1]
      bubble != undefined ?  bubble.innerText = parseInt(bubble.innerText) - 1 : ''
    })
  })
}

const updateAssig = (id,values) => {
  console.log(id + ': ' + values)
}

$$('form')[0].addEventListener('submit',(e)=>{
  $('pclient').classList.remove('important')
  $('descRef').innerHTML = ""
  $('clientName').innerHTML = ""
  e.preventDefault()
  const origen = $('origen').value
  const destino = $('destino').value
  const cliente = $('client').value
  const pedido = $('pedido').value
  const ref = $('ref').value
  const cantidad = $('units').value
  const nfm = $('nfm').checked
  if(origen === destino){
    customAlert('El destino y el origen debe ser diferente')
    return false
  }
  if(cliente === ''){
    customAlert('Debes rellenar el cliente')
    $('client').focus()
    return false
  }
  else if(ref === ''){
    customAlert('Debes rellenar la referencia')
    $('ref').focus()
    return false
  }
  else if(cantidad === ''){
    customAlert('Debes rellenar la cantidad')
    $('units').focus()
    return false
  }
  let disgonStatus = false
  const data = new FormData() 
  data.append('origen',origen)
  data.append('destino',destino)
  data.append('cliente',cliente)
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
      const bubble = $('contacts').childNodes[3].childNodes[1].childNodes[1].childNodes[1]
      $('newTitle').innerHTML = "Nueva cesión"
      $('pclient').innerHTML = ""
      bubble != undefined ?  bubble.innerText = parseInt(bubble.innerText) + 1 : $('contacts').childNodes[3].childNodes[1].childNodes[1].innerHTML = 'Nueva <span class="round">1</span>'
      e.target.reset()
    }
  })
})

showAssig()

const botones = {
  nueva:$('contacts').childNodes[3].childNodes[1].childNodes[1],
  buscar:$('contacts').childNodes[3].childNodes[1].childNodes[3],
  recibidas:$('contacts').childNodes[3].childNodes[1].childNodes[7],
  pendientes:$('contacts').childNodes[3].childNodes[1].childNodes[5],
  estadistica:$('contacts').childNodes[3].childNodes[1].childNodes[9]
}

const clearSelect = () => {
  if($('contacts').childNodes[5] != undefined)
    $('contacts').childNodes[5].remove()
}

botones.nueva.addEventListener('click',()=>{
  window.location.reload()
})

botones.buscar.addEventListener('click',() => {
  clearSelect()
  $('newTitle').innerHTML = "Buscar cesiones"
  const boton = `
  <div id="search-line" class="nPass search-line search-focused">
    <span class="lupa">
      <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
      </svg>
    </span>
    <div class="textbox" id="search-box">
      <input type="search" id="search-assig" placeholder="Buscar cesión...">
    </div>
  </div>`
  //$('contacts-items').childNodes[1].classList.add('change')
  setTimeout(function(){
    //$('contacts-items').childNodes[1].classList.remove('change')
    $('contacts-items').innerHTML = boton
    $('contacts-items').innerHTML += `<div id="cesiones"></div>`
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
            const referencia = rows[i].childNodes[7]
            referencia.addEventListener('click',e =>{
              copyClipboard(e.target.textContent.replaceAll(' ',''))
            })
            const data = new FormData
            data.append('id', id)
            data.append('referencia', referencia.innerHTML.replaceAll(' ',''))
            fetch('../api/getDescRefer.php',{
              method: 'POST',
              body: data
            })
            .then(response => response.text())
            .then(res => {
              if($('cesiones').getElementsByTagName('ul').length <= rows.length)
                rows[i].childNodes[9].innerHTML = res.replace('<p>',' / ')
            })
          }
        })
      },1000)
    },500)  
  })
})

$('client').addEventListener('blur',()=>{
  buscarCliente($('destino').value.substring(0,3),$('client').value.split('-')[0])
})

$('ref').addEventListener('blur',() =>{
  buscarDenominacionReferencia($('ref').value)
})

botones.recibidas.addEventListener('click', () =>{
  clearSelect()
  $('newTitle').innerHTML = "Cesiones recibidas"
  $('contacts-items').innerHTML = `<div id="cesiones"></div>`
  fetch('../api/spinner.php')
  .then(fn => fn.text())
  .then(req => $('cesiones').innerHTML = req)
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
      const referencia = rows[i].childNodes[7]
      const data = new FormData
      referencia.addEventListener('click',e =>{
        copyClipboard(e.target.textContent.replaceAll(' ',''))
      })
      data.append('id', id)
      data.append('referencia', referencia.textContent.replaceAll(' ',''))
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
  assignOnTrak('date')
})

$('contacts-items').addEventListener('click',e =>{
  if(e.target.parentNode.title.includes('recibida')){
    let enCurso = document.getElementsByClassName('subButtons')[0].childNodes[1].childNodes[5].childNodes[1]
    if(confirm("Se ha recibido esta cesion?") == true){
      const data = new FormData()
      data.append('id',e.target.id)
      fetch('../api/updateAssig.php',{
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(() => {
        e.target.parentNode.parentNode.style.display = 'none'
        enCurso.innerHTML = parseInt(enCurso.innerText) - 1
      })
    }
  }
})

const assignOnTrak = (sort) =>{
  $('newTitle').innerHTML = "Cesiones pendientes de recibir"
  $('contacts-items').innerHTML = `<div id="cesiones"></div>`
  fetch('../api/spinner.php')
  .then(fn => fn.text())
  .then(req => $('cesiones').innerHTML = req)
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  data.append('sort',sort)
  fetch('../api/getAssig.php',{
    method: 'POST',
    body:data
  })
  .then((e) => e.text())
  .then((res) => {
    $('cesiones').innerHTML = res
    if($('sortOrigen')){
      $('sortOrigen').addEventListener('click',()=>{
        assignOnTrak('origen')
      })
      $('sortDestino').addEventListener('click',()=>{
        assignOnTrak('destino')
      })
      $('sortEnvio').addEventListener('click',()=>{
        assignOnTrak('date')
      })
    }
    const rows = $('cesiones').getElementsByTagName('ul')
    for(let i = 1;i < rows.length;i++) {
      const id = rows[i].id
      const referencia = rows[i].childNodes[7]
      const data = new FormData
      referencia.addEventListener('click',e =>{
        const filas = $('cesiones').getElementsByTagName('ul')
        for(let i=0;i<filas.length;i++)
          filas[i].classList.remove('marcado')
        e.target.parentNode.classList.add('marcado')
        copyClipboard(e.target.textContent.replaceAll(' ',''))
      })
      data.append('id', id)
      data.append('referencia', referencia.innerHTML)
      fetch('../api/getDescRefer.php',{
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(res => {
        rows[i].childNodes[9].innerHTML = res.replace('<p>',' / ')
      })
    }
  })
}

botones.estadistica.addEventListener('click', (e) =>{
  if(document.getElementsByTagName('select').length > 0 && $('newTitle').innerHTML == 'Estadísticas')
    return false
  $('newTitle').innerHTML = "Estadísticas"
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
      if(res[e.target.value][1].length > 0){
        let sum = res[e.target.value][1].slice(0,20).reduce((previous, current) => parseInt(current) + parseInt(previous));
        avg = Math.round((sum / res[e.target.value][1].slice(-20).length) * 100)/100;
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
    

    // Creo los usuarios en un selection
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

/* Se colorea los fondos de los input cuando hay algo escrito */
$$('form')[0].addEventListener('keyup',(e)=>{
  if(!$$('form')[0].childNodes[1] == false && !$$('form')[0].childNodes[1].className != 'form-group'){
    for (var element = 0;element < $$('form')[0].length;element++){
      $$('form')[0][element].value != '' ? $$('form')[0][element].classList.add('fondo') : $$('form')[0][element].classList.remove('fondo')
    }
  }
})