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
    }else if(origen == 'PALMA'){
      $('pclient').classList.add('important')
      alerta = "Portes"
    }  
    /*else if(origen == "VIGO"){
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
      let li, id, origen, destino, cliente, refCliente, comentario, referencia, cantidad, pedido, fragil, pvp, tratado, nfm, disgon, btnSendMail, btnEliminar = ''
      li = $('cesiones').childNodes[i]
      id = $(`cesiones`).childNodes[i].childNodes[25].id
      origen = $('cesiones').childNodes[i].childNodes[1].childNodes[1]
      destino = $('cesiones').childNodes[i].childNodes[1].childNodes[2]
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
          const bubble = $('contacts').childNodes[3].childNodes[1].childNodes[0]
          bubble != undefined ? bubble.innerText = parseInt(bubble.innerText) - 1 : ''
        })
      })
    }
  })
}

const refreshInputs = (id,nfm,fragil,pedido,tratado,origen,destino) => {
  let cesion = null
  let code = $(id).parentNode.childNodes[1].childNodes[4]
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
  const destinoBtn = $(id).parentNode.childNodes[1].childNodes[2].className.includes('press') ? '1':'0'
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
      const bubble = document.getElementById('new').firstChild
      bubble != undefined ?  bubble.innerText = parseInt(bubble.innerText) - 1 : ''
    })
  })
}

const updateAssig = (id,values) => {
  console.log(id + ': ' + values)
}

$$('form')[0].addEventListener('submit',(e)=>{
  $('pclient').classList.remove('important')
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
      const bubble = document.getElementById('new')
      $('newTitle').innerHTML = "Nueva cesión"
      $('pclient').innerHTML = ""
      bubble.firstChild.nextSibling != null ? bubble.firstChild.innerText = parseInt(bubble.firstChild.innerText) + 1 : bubble.innerHTML = ' Nuevas Cesiones <span class="round">1</span>'
      e.target.reset()
    }
  })
})

showAssig()

const id = window.location.search.split('?id=')[1]

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