'use strict'
const src = location.href.split('/').length > 4 ? '../..' : '..'
const caracteresEspeciales = "'\"[`¡!@#$%&*()_+/=|<>¿?{}\\[\\]~-] .,Ç^·%ºª"
const correosCorporativos = {
  'MADRID': 'recambios-ppcr@stellantis.com',
  'BARCELONA': 'pcr-bcn-recambios@stellantis.com',
  'VALENCIA': 'recambios-paterna-ppcr@stellantis.com',
  'ZARAGOZA': 'recambios-ebro-ppcr@stellantis.com',
  'GALICIA': 'recambios-galicia-ppcr@stellantis.com',
  'SEVILLA': 'recambios-sevilla-ppcr@stellantis.com',
  'MÁLAGA': 'recambios-granada-ppcr@stellantis.com',
  'PALMA': 'recambios-baleares-ppcr@stellantis.com',
}

export const limpiarReferencia = (referencia) => {
  for(let i = 0; i < caracteresEspeciales.length; i++){
    referencia.includes(caracteresEspeciales[i]) ? referencia = referencia.replaceAll(caracteresEspeciales[i],'') : null
  }
  return referencia
}

export const cargarProveedor = (tipo = '', marca = '', proveedor = '', selectTipo, selectMarca, selectProveedor) =>{
  for(let i = 0; selectTipo.options.length > 0; i++){
    selectTipo.remove(0)
  }
  for(let i = 0; selectMarca.options.length > 0; i++){
    selectMarca.remove(0)
  }
  for(let i = 0; selectProveedor.options.length > 0; i++){
    selectProveedor.remove(0)
  }
  fetch('../../api/getProvExt.php',{
    method: 'POST',
    body: JSON.stringify({tipo: tipo, marca: marca, proveedor: proveedor}),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    let tipoRecambio = {'':'','IAM': 'Recambio compatible','OEM':'Recambio original'}
    let marcaVacio = document.createElement('option')
    marcaVacio.value = ''
    marcaVacio.textContent = 'Selecciona una marca'
    let provVacio = document.createElement('option')
    provVacio.value = ''
    provVacio.textContent = 'Selecciona un proveedor'
    selectMarca.appendChild(marcaVacio)
    selectProveedor.appendChild(provVacio)
    Object.entries(tipoRecambio).forEach(([value, text]) => {
      let optTipo = document.createElement('option')
      if( tipo === value ) optTipo.selected = true
      optTipo.value = value
      optTipo.textContent = text
      selectTipo.appendChild(optTipo)
    })
    if(data.length === 0){
      let optMarcaSelected = document.createElement('option')
      optMarcaSelected.value = marca
      optMarcaSelected.textContent = marca
      optMarcaSelected.selected = true
      selectMarca.appendChild(optMarcaSelected)
      
      let optProvSelected = document.createElement('option')
      optProvSelected.selected = true
      optProvSelected.value = proveedor
      optProvSelected.textContent = proveedor
      selectProveedor.appendChild(optProvSelected)

    }else{    
      data.forEach(option => {
        let optMarca = document.createElement('option')
        let optProv = document.createElement('option')
        if( marca === option.marca ) optMarca.selected = true
        optMarca.value = option.marca
        optMarca.textContent = option.marca
        selectMarca.appendChild(optMarca)
        if(parseInt(proveedor) === option.id ) optProv.selected = true
        optProv.value = option.nombre
        optProv.textContent = option.nombre
        selectProveedor.appendChild(optProv)
      })
    }
  })
}

export const actualizarPedido = (id) =>{
  const idUsuario = user.hash
  const placa = `${$('destino').value}`
  const cliente = `${$('client').value}-${$('envio').value} (${$('clientName').innerText})`
  const envio = `${$('envio').value}`
  const coment = `${$('coment').value}`
  fetch(`${src}/api/updateOrderExtBrand.php`,{
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'id': id,
      'idUsuario': idUsuario,
      'placa': placa,
      'cliente': cliente,
      'destino': envio,
      'comentario': coment
    })
  })
}

export const crearLineas = (id,linea = {}) =>{
  const prov = '0' //pendiente de selecionar el proveedor
  const contadorLineas = $('formLine0').querySelectorAll('section').length - 1
  let inputRef = document.createElement('input')
  let inputUni = document.createElement('input')
  let inputDesc = document.createElement('input')
  let inputPvp = document.createElement('input')
  let inputDtoCompra = document.createElement('input')
  let inputDtoVenta = document.createElement('input')
  let familySelect = document.createElement('select')
  let img = document.createElement('img')
  let span = document.createElement('span')
  let section = document.createElement('section')
  inputRef.id = `ref${contadorLineas}`
  inputUni.type = 'number'
  inputPvp.type = 'number'
  inputDtoCompra.type = 'number'
  inputDtoVenta.type = 'number'
  inputUni.id = `units${contadorLineas}`
  inputDesc.id = `comentLine${contadorLineas}`
  inputDesc.maxLength = 35
  familySelect.id = `familyParts${contadorLineas}`
  inputPvp.id = `pvp${contadorLineas}`
  inputDtoCompra.id = `dtoCompra${contadorLineas}`
  inputDtoVenta.id = `dtoVenta${contadorLineas}`
  if(linea.id != undefined){
    inputRef.value = linea.referencia
    inputRef.title = linea.id
  }else{
    grabarExtLinea(prov)
  }
  if(linea.cantidad) inputUni.value = linea.cantidad
  if(linea.designacion) inputDesc.value = linea.designacion
  if(linea.pvp) inputPvp.value = linea.pvp
  if(linea.dto_compra) inputDtoCompra.value = linea.dto_compra
  if(linea.dto_venta) inputDtoVenta.value = linea.dto_venta
  let idLinea = linea.id
  if ($('destino').value == '' || $('client').value == '') 
    return

  let timeout;
  let eventos = ["keydown", "blur"]
  eventos.forEach(evento =>{
    inputRef.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
        e.target.value = limpiarReferencia(e.target.value.toUpperCase())
        actualizarLinea(idLinea, contadorLineas)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputUni.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
        actualizarLinea(idLinea, contadorLineas)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputDesc.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
      e.target.value = e.target.value.toUpperCase()
      actualizarLinea(idLinea, contadorLineas)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputPvp.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
        actualizarLinea(idLinea, contadorLineas)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputDtoCompra.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
      actualizarLinea(idLinea, contadorLineas)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputDtoVenta.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
        actualizarLinea(idLinea, contadorLineas)
      }, 1000)
    })
  })

  familySelect.addEventListener('change',(e)=>{
    actualizarLinea(idLinea, contadorLineas)
  })
  const familyOptions = ['','CARROCERIA','MECANICA','REMAN']
  familyOptions.forEach(fam => {
    let opt = document.createElement('option')
    opt.value = fam
    opt.innerText = fam
    familySelect.appendChild(opt)
    if(fam === linea.familia) opt.selected = true
  })

  img.src = '../../img/delete_FILL0_wght400_GRAD0_opsz24.png'
  img.alt = 'Eliminar'
  img.title = 'Eliminar'
  img.className = 'deleteLine'
  img.id = `delete${contadorLineas}`
  section.appendChild(span)
  section.appendChild(inputRef)
  section.appendChild(inputUni)
  section.appendChild(inputDesc)
  section.appendChild(familySelect)
  section.appendChild(inputPvp)
  section.appendChild(inputDtoCompra)
  section.appendChild(inputDtoVenta)
  section.appendChild(img)
  $(`formLine${id}`).appendChild(section)
  inputRef.focus()
}

export const grabarExtLinea = (prov) => {
  const contadorLineas = $('formLine0').querySelectorAll('section').length - 1
  const idUsuario = user.hash
  const numPedido = $('numPedido').innerText
  const tipo = $(`tipo${prov}`).value
  const marca = $(`marca${prov}`).value
  const proveedor = $(`proveedor${prov}`).value
  const ref = $(`ref${contadorLineas}`) == null ? '' : limpiarReferencia($(`ref${contadorLineas}`).value)
  const units = $(`units${contadorLineas}`) == null ? '' : $(`units${contadorLineas}`).value
  const coment = $(`coment`).value
  const family = $(`familyParts${contadorLineas}`) == null ? '' : $(`familyParts${contadorLineas}`).value
  const pvp = $(`pvp${contadorLineas}`) == null ? '' : $(`pvp${contadorLineas}`).value
  const dtoCompra = $(`dtoCompra${contadorLineas}`) == null ? '' : $(`dtoCompra${contadorLineas}`).value
  const dtoVenta = $(`dtoVenta${contadorLineas}`) == null ? '' : $(`dtoVenta${contadorLineas}`).value
  const cliente = `${$('client').value}-${$('envio').value}`
  const placa = `${$('destino').value}`
  const comentario = `${$('coment').value}`
  if(placa == '' || $('client').value =='')
    return true
  let datos = new FormData()
  datos.append('idUsuario',idUsuario)
  // Aquí puedes agregar la lógica para crear una nueva línea
  fetch(`${src}/api/addExtBrand.php`,{
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'idUsuario': idUsuario,
      'numPedido': numPedido,
      'tipo': tipo,
      'marca': marca,
      'proveedor': proveedor,
      'ref': ref,
      'units': units,
      'coment': coment,
      'family': family,
      'pvp': pvp,
      'dtoCompra': dtoCompra,
      'dtoVenta': dtoVenta,
      'cliente': cliente,
      'placa': placa,
      'comentario': comentario
    })
  }).then(res => res.text())
  .then(text => {
    $(`ref${contadorLineas}`).title = text
  })
}

export const actualizarLinea = (id, numlinea) => {
  if (id === undefined)
    id = $(`ref${numlinea}`) != null ? $(`ref${numlinea}`).title : numlinea--
  const idLinea = id
  const idUsuario = user.hash
  const cliente = `${$('client').value}-${$('envio').value}`
  const nombre_cliente = `${$('clientName').innerText}`
  const comentario = `${$('coment').value}`
  const tipo = $(`tipo0`).value
  const marca = $(`marca0`).value
  const proveedor = $(`proveedor0`).value
  const referencia = limpiarReferencia($(`ref${numlinea}`).value)
  const cantidad = $(`units${numlinea}`).value
  const designacion = $(`comentLine${numlinea}`).value
  const familia = $(`familyParts${numlinea}`).value
  const pvp = $(`pvp${numlinea}`).value
  const dto_compra = $(`dtoCompra${numlinea}`).value
  const dto_venta = $(`dtoVenta${numlinea}`).value
  fetch(`${src}/api/updateExtLine.php`,{
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'id': idLinea,
      'idUsuario': idUsuario,
      'cliente': cliente,
      'nombre_cliente': nombre_cliente,
      'comentario': comentario,
      'tipo': tipo,
      'marca': marca,
      'referencia': referencia,
      'cantidad': cantidad,
      'designacion': designacion,
      'familia': familia,
      'proveedor': proveedor,
      'pvp': pvp,
      'dto_compra': dto_compra,
      'dto_venta': dto_venta
    })
  })
}

export const actualizarPedidoLineas = numpedido =>{
  const tipo = $('tipo0').value
  const marca = $('marca0').value
  const proveedor = $('proveedor0').value
  const idUsuario = user.hash
  
  fetch(`${src}/api/updateOrderDataByLine.php`,{
    method: 'POST',
    body: JSON.stringify({
      'tipo': tipo,
      'marca': marca,
      'proveedor': proveedor,
      'idUsuario': idUsuario,
      'numpedido': numpedido
    })
  })
}

export const validarFormulario = e =>{
  //Limpiar avisos
  for (const select of $$('select')) {
    select.classList.remove('important')
  }
  for (const input of $$('input')) {
    input.classList.remove('important')
  }

  const divProvNumber = e.target.parentNode.parentNode.id.split('prov')[1]
  const tipo = $(`tipo${divProvNumber}`)
  const marca = $(`marca${divProvNumber}`)
  const destino = $(`destino`)
  const cliente = $(`client`)
  const envio = $(`envio`)
  if(destino.value === ''){
    customAlert('Debe seleccionar una placa de destino')
    destino.classList.add('important')
    return false
  }
  if(cliente.value === ''){
    customAlert('Debe seleccionar un cliente')
    cliente.classList.add('important')
    return false
  }
  if(envio.value === ''){
    customAlert('Debe seleccionar un envío')
    envio.classList.add('important')
    return false
  }
  if(marca.value === ''){
    customAlert('Debe seleccionar una marca')
    marca.classList.add('important')
    return false
  }
  if(tipo.value === ''){
    customAlert('Debe seleccionar un tipo de recambio')
    tipo.classList.add('important')
    return
  }

  //valida que todos los campos esten completos
  for (let i = 0; i < $('prov0').getElementsByTagName('input').length / 6; i++) {
    if($(`ref${i}`).value === ''){
      customAlert('Debe completar todos los campos')
      $(`ref${i}`).classList.add('important')
      $(`ref${i}`).focus()
      return false
    }
    if($(`units${i}`).value === '' || $(`units${i}`).value < 1){
      customAlert('Debe completar todos los campos')
      $(`units${i}`).classList.add('important')
      $(`units${i}`).focus()
      return false
    }
    if($(`comentLine${i}`).value === ''){
      customAlert('Debe completar todos los campos')
      $(`comentLine${i}`).classList.add('important')
      $(`comentLine${i}`).focus()
      return false
    }
    if($(`pvp${i}`).value === '' || $(`pvp${i}`).value < 0){
      customAlert('Debe completar todos los campos')
      $(`pvp${i}`).classList.add('important')
      $(`pvp${i}`).focus()
      return false
    }
    if($(`dtoCompra${i}`).value === '' || $(`dtoCompra${i}`).value < 0){
      customAlert('Debe completar todos los campos')
      $(`dtoCompra${i}`).classList.add('important')
      $(`dtoCompra${i}`).focus()
      return false
    }
    if($(`dtoVenta${i}`).value === '' || $(`dtoVenta${i}`).value < 0){
      customAlert('Debe completar todos los campos')
      $(`dtoVenta${i}`).classList.add('important')
      $(`dtoVenta${i}`).focus()
      return false
    }
    if($(`familyParts${i}`).value === ''){
      customAlert('Debe completar todos los campos')
      $(`familyParts${i}`).classList.add('important')
      $(`familyParts${i}`).focus()
      return false
    }
  }
  return true
}

export const enviarCorreoAlProveedor = e =>{
  let date = new Date()
  let lineas = []
  let lineasPedidoEnCurso = $('prov0').childNodes[3].childNodes
  for (let i = 3; i < lineasPedidoEnCurso.length; i++) {
    lineas.push({
      referencia: lineasPedidoEnCurso[i].getElementsByTagName('input')[0].value,
      cantidad: lineasPedidoEnCurso[i].getElementsByTagName('input')[1].value,
      designacion: lineasPedidoEnCurso[i].getElementsByTagName('input')[2].value,
      pvp: lineasPedidoEnCurso[i].getElementsByTagName('input')[3].value,
      dtoCompra: lineasPedidoEnCurso[i].getElementsByTagName('input')[4].value
    })
  }
  if(lineas.length === 0){
    customAlert('Debe añadir al menos una línea de recambio')
    return
  }
  let saludo = date.getHours() < 13 ? 'Buenos días' : 'Buenas tardes'
  let mail = {
    to: $('client').value,
    subject: 'Nueva pedido PPCR Otras Marcas',
    body: `${saludo}: 
      %0ASolicito el siguiente listado de piezas de recambio:

      ${lineas.map(linea => `%0A
        ${linea.cantidad} ${linea.cantidad > 1 ? 'unidades de la referencia ' : 'unidad de la referencia '}${linea.referencia}(${linea.designacion})
        PVP: ${linea.pvp}€ - ${linea.dtoCompra}%
      `).join('')}
      %0A%0APor favor, adjuntar el albarán en este mismo hilo de correos.
      %0AMuchas gracias.`
  }
  fetch(`${src}/api/getExtMail.php`,{
    method: 'POST',
    body: JSON.stringify({
      'placa': $('destino').value,
      'proveedor': $('proveedor0').value,
      'usuario': user.hash
    })
  })
  .then(res => res.json())
  .then(res => {
    res[0]['gestion1'] = res[0]['gestion1'].replaceAll('\r\n',';')
    res[0]['almacen1'] = res[0]['almacen1'].replaceAll('\r\n',';')
    res[0]['transporte1'] = res[0]['transporte1'].replaceAll('\r\n',';')
    let proveedor = res[1]['mail']
    let cc = correosCorporativos[$('destino').value]
    window.location.href = `mailto:${proveedor};${res[0]['gestion1']};${res[0]['almacen1']};${res[0]['transporte1']}?subject=${mail.subject}&body=${mail.body}&cc=${cc};${user.mail}`
  })
}