const rutasDirectas = ["6251-2","78709-1","12752-1","105252-1","105342-1","14075-1"]
const rutasPreguntar = ["6254-1","78713-1"]
const rutasPortes = ["12874","14079-1","14101-1","6280-1","14086-1","105247-1","105511-1","105400-1","78665-1","78713-1","105311-1"]

export function isAlertRoutes(route){
  pclient.classList.remove('important')
  pclient.classList.remove('route')
  let encontrado
  let mensaje = ''
  rutasDirectas.filter(rutas => {
    if(rutas.includes(route)){
      encontrado = route
      mensaje = "Ruta"
      pclient.classList.add('route')
    }
  })
  rutasPreguntar.filter(rutas => {
    if(rutas.includes(route)){
      encontrado = route
      mensaje = "Preguntar"
      pclient.classList.add('important')
    }
  })
  rutasPortes.filter(rutas => {
    if(rutas.includes(route)){
      encontrado = route
      mensaje = "Portes"
      pclient.classList.add('important')
    }
  })
  return mensaje
}

export const cesiones = (origen, destino,nfm,seg) =>{
  $('newTitle').innerText = `${origen}>${destino}`
  let cesion = null
  origen != destino ? cesion = origen + '' + destino:''
  seg ? cesion += 'SEG' :''
  nfm ? cesion += 'NM' :''
  fetch('../json/cesionesCliente.json?107',
    {cache: "reload"}
  )
  .then(response => response.json())
  .then(response => {
    const numDest = response[cesion]
    let alerta = ""
    if(origen != 'MAT' || origen != 'EXT'){
      alerta = isAlertRoutes(numDest)
    }
    numDest != undefined ? pclient.innerText = `${numDest} ${alerta}` : pclient.innerText = ""
  })
}
export const createInputMat = (ref) => {
  return `
  <input type="text" id="refMat" 
    style="margin-bottom: -25px;width:141px;margin-top:0;position:absolute;font-size:15px;" 
    value="${ref}"></input>
    <span style="font-size: small;line-height: 7;">Ref. Mister-Auto</span>`
}

export const createInputExt = (placa) => {
  let inputs = `<select id="refMat" style="margin-bottom: -25px;width:141px;margin-top:0;position:absolute;font-size:15px;">
            <option value="Nombre de la placa" label=""></option>`
  fetch('../api/getProvExt.php',{
    method: 'POST'
  })
  .then(e => e.json())
  .then(proveedores => {
    proveedores.map(proveedor => {
      inputs +=  `<option value="${proveedor.mail}" label="${proveedor.nombre}">${proveedor.nombre}</option>`
    })
    pclient.innerHTML = `${inputs}</select><span id="mailExt" style="font-size: small;line-height: 7;">Nombre de la placa</span>`
    pclient.querySelector('#refMat').addEventListener('change',(e) => mailExt.innerHTML = e.target.value)
  })
}

export const eliminarLinea = (id,referencia,tratado) =>{
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
      if(origenActivo || destinoActivo || (tratado != '' && user.puesto != 'ADV')){
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
      })
    })
  })
}

export const esDisgon = (esSeguro) =>{
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
  dsgButton.addEventListener('change',e => {
    cesiones($('origen').value,$('destino').value,$('nfm').checked,e.target.checked)
  })
  if(esSeguro && $('disgonBox') == null){
    document.getElementsByClassName('form-group')[0].childNodes[15].appendChild(dsgDiv)
    $('disgonBox').addEventListener('change',(e) => {
      let seguro = e.target.checked
      buscarDenominacionReferencia($('ref').value)
      const origen = $('origen').value
      const nfm = $('nfm').checked
      if(origen == 'MAT'){
        const refMat = $('refMat') == null ? 'ZZMAT' : $('refMat').value
        pclient.innerHTML = createInputMat(refMat)
        return null
      }else if(origen == 'EXT'){
        pclient.innerHTML = createInputExt($('destino').value)
        refMat.addEventListener('blur',() => buscar_ultimo_correo($('refMat').value))
      }
      cesiones(origen,$('destino').value,nfm,seguro)
  })
  }
  else if(!esSeguro && $('disgonBox'))
    $('disgonDiv').remove()
}

export const buscarCliente = (placa,cliente) => {
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

export const buscarDenominacionReferencia = (refer) =>{
  const data = new FormData()
  data.append('referencia', refer.replaceAll(/\t/g, ''))
  fetch('../api/getDescRefer.php',{
    method: 'POST',
    body: data
  })
  .then(res => res.json())
  .then((res) => {
    $('descRef').innerHTML = res.descripcionPrecio
    let pvp = 0
    const stringAlert = ['E:BATERÍA','E:BATERIA','E:LUBRICANTE']
    if($('origen').value == 'GRANADA'){
      stringAlert.forEach(e =>{
        if(res.descripcionPrecio.includes(e))
          customAlert("🚫No se pueden hacer cesiones desde Granada de baterías ni de aceite Eurorepar hasta Enero 2025")
      })
    }
    if(!res.descripcionPrecio.includes('Desconocido'))
      pvp = parseFloat(res.precio.replaceAll(',','.'))
      let dto = parseInt(res.descuento)
    if($('destino').value == 'ZARAGOZA' && ($('origen').value != 'MAT' || $('origen').value != 'EXT') && $('disgonBox') != null) {
      if(!$('coment').value.includes(` \n¡¡OJO!! ${Math.round(pvp * ((100 - dto)/100) * 0.10)}€ de portes.`) && $('disgonBox').checked)
        $('coment').value += ` \n¡¡OJO!! ${Math.round(pvp * ((100 - dto)/100) * 0.10)}€ de portes.`
      if(!$('disgonBox').checked)
        $('coment').value = $('coment').value.replaceAll(` \n¡¡OJO!! ${Math.round(pvp * ((100 - dto)/100) * 0.10)}€ de portes.`,'')
    }
    if($('destino').value == 'PALMA' && ($('origen').value != 'MAT' || $('origen').value != 'EXT')){
      let portes = '40€'
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

export const updateCounterAssignment = (id,comentario) => {
  const data = new FormData()
  data.append('id',id)
  data.append('comentario',comentario)
  fetch('../api/updateAssignADV2023.php',{
    method: 'POST',
    body: data
  })
}

export const buscar_ultimo_correo = (proveedor) => {
  const data = new FormData()
  data.append('proveedor',proveedor)
  fetch('../api/getMailProv.php',{
    method: 'POST',
    body: data
  }).then(e => e.json())
  .then(mail => $('mailExt').value = mail.correo_prov)
}