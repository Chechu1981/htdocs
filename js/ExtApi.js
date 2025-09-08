'use strict'
const src = location.href.split('/').length > 4 ? '../..' : '..'

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

export const crearLineas = (id,contadorLineas,linea = {}) =>{
  const prov = '0' //pendiente de selecionar el proveedor
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
  inputUni.id = `units${contadorLineas}`
  inputDesc.id = `comentLine${contadorLineas}`
  familySelect.id = `familyParts${contadorLineas}`
  inputPvp.id = `pvp${contadorLineas}`
  inputDtoCompra.id = `dtoCompra${contadorLineas}`
  inputDtoVenta.id = `dtoVenta${contadorLineas}`
  if(linea.id){
    inputRef.value = linea.referencia
    inputRef.title = linea.id
  }
  if(linea.cantidad) inputUni.value = linea.cantidad
  if(linea.designacion) inputDesc.value = linea.designacion
  if(linea.pvp) inputPvp.value = linea.pvp
  if(linea.dto_compra) inputDtoCompra.value = linea.dto_compra
  if(linea.dto_venta) inputDtoVenta.value = linea.dto_venta
  let idLinea = linea.id
  if(!linea.id) {
    grabarExtLinea(contadorLineas, prov)
  }
  let timeout;
  let eventos = ["keydown", "blur"]
  eventos.forEach(evento =>{
    inputRef.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
        actualizarLinea(idLinea, contadorLineas, prov)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputUni.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
        actualizarLinea(idLinea, contadorLineas, prov)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputDesc.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
      actualizarLinea(idLinea, contadorLineas, prov)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputPvp.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
        actualizarLinea(idLinea, contadorLineas, prov)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputDtoCompra.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
      actualizarLinea(idLinea, contadorLineas, prov)
      }, 500)
    })
  })

  eventos.forEach(evento =>{
    inputDtoVenta.addEventListener(evento,(e)=>{
      clearTimeout(timeout);
      timeout = setTimeout(()=>{
        actualizarLinea(idLinea, contadorLineas, prov)
      }, 1000)
    })
  })

  familySelect.addEventListener('change',(e)=>{
    actualizarLinea(idLinea, contadorLineas, prov)
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

export const grabarExtLinea = (contadorLineas, prov) => {
  const idUsuario = user.hash
  const numPedido = $('numPedido').innerText
  const tipo = $(`tipo${prov}`).value
  const marca = $(`marca${prov}`).value
  const proveedor = $(`proveedor${prov}`).value
  const ref = $(`ref${contadorLineas}`) == null ? '' : $(`ref${contadorLineas}`).value
  const units = $(`units${contadorLineas}`) == null ? '' : $(`units${contadorLineas}`).value
  const coment = $(`coment`).value
  const family = $(`familyParts${contadorLineas}`) == null ? '' : $(`familyParts${contadorLineas}`).value
  const pvp = $(`pvp${contadorLineas}`) == null ? '' : $(`pvp${contadorLineas}`).value
  const dtoCompra = $(`dtoCompra${contadorLineas}`) == null ? '' : $(`dtoCompra${contadorLineas}`).value
  const dtoVenta = $(`dtoVenta${contadorLineas}`) == null ? '' : $(`dtoVenta${contadorLineas}`).value
  const cliente = `${$('client').value}-${$('envio').value}`
  const placa = `${$('destino').value}`
  const comentario = `${$('coment').value}`
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

export const actualizarLinea = (id, contadorLineas) => {
  if (id === undefined)
    id = $(`ref${contadorLineas}`) != null ? $(`ref${contadorLineas}`).title : contadorLineas--
  const idLinea = id
  const idUsuario = user.hash
  const cliente = `${$('client').value}-${$('envio').value}`
  const nombre_cliente = `${$('clientName').innerText}`
  const comentario = `${$('coment').value}`
  const tipo = $(`tipo0`).value
  const marca = $(`marca0`).value
  const proveedor = $(`proveedor0`).value
  const referencia = $(`ref${contadorLineas}`).value
  const cantidad = $(`units${contadorLineas}`).value
  const designacion = $(`comentLine${contadorLineas}`).value
  const familia = $(`familyParts${contadorLineas}`).value
  const pvp = $(`pvp${contadorLineas}`).value
  const dto_compra = $(`dtoCompra${contadorLineas}`).value
  const dto_venta = $(`dtoVenta${contadorLineas}`).value
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