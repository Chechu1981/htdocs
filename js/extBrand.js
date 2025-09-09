'use strict'
import { buscarCliente } from "./alertsAssigns.js?106"
import { cargarProveedor, crearLineas, actualizarPedido, enviarCorreoAlProveedor } from "./ExtApi.js?106"

//Botones del menú

const btnAll = document.getElementById('all') ?? 0
let contadorLineas = $('formLine0').childNodes.length / 2

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `./ext/orderList.php`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location = `./extBrand.php`
})

const crearPedido = () =>{
  const idUsuario = user.hash
  const placa = `${$('destino').value}`
  const cliente = `${$('client').value}-${$('envio').value}`
  const envio = `${$('envio').value}`
  const coment = `${$('coment').value}`
  if(placa == '' || $('client').value == '')
    return true
  fetch('../api/addOrderExtBrand.php',{
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'idUsuario': idUsuario,
      'placa': placa,
      'cliente': cliente,
      'destino': envio,
      'comentario': coment
    })
  })
  .then(res => res.text())
  .then(num => {
    $('numPedido').innerText = num
    crearLineas(0,contadorLineas)
  })
}

$('addLine').addEventListener('click',(e)=>{
  e.preventDefault()
  crearLineas(e.target.parentNode.parentNode.childNodes[3].id.split('formLine')[1],contadorLineas)
})

const clearImportant = () => {
  for (const select of $$('select')) {
    select.classList.remove('important')
  }
  for (const input of $$('input')) {
    input.classList.remove('important')
  }
}

$('addOrder').addEventListener('click',(e)=>{
  clearImportant()
  const divProvNumber = e.target.parentNode.parentNode.id.split('prov')[1]
  const tipo = $(`tipo${divProvNumber}`)
  const marca = $(`marca${divProvNumber}`)
  const destino = $(`destino`)
  const cliente = $(`client`)
  const envio = $(`envio`)
  const coment = $(`coment`)
  if(destino.value === ''){
    customAlert('Debe seleccionar un destino')
    destino.classList.add('important')
    return
  }
  if(cliente.value === ''){
    customAlert('Debe seleccionar un cliente')
    cliente.classList.add('important')
    return
  }
  if(envio.value === ''){
    customAlert('Debe seleccionar un envío')
    envio.classList.add('important')
    return
  }
  if(marca.value === ''){
    customAlert('Debe seleccionar una marca')
    marca.classList.add('important')
    return
  }
  if(tipo.value === ''){
    customAlert('Debe seleccionar un tipo de recambio')
    tipo.classList.add('important')
    return
  }
  const orderExt = new FormData()
  orderExt.append('id',user.hash)
  orderExt.append('tipo',tipo.value)
  orderExt.append('marca',marca.value)
  orderExt.append('destino',destino.value)
  orderExt.append('cliente',cliente.value)
  orderExt.append('envio',envio.value)
  orderExt.append('comentarios',coment.value)
  let lineas = []
  for (let i = 0; i <= contadorLineas - 1; i++) {
    lineas.push({
      referencia: $(`ref${i}`).value,
      cantidad: $(`units${i}`).value,
      designacion: $(`comentLine${i}`).value,
      familia: $(`familyParts${i}`).value
    })
  }

  orderExt.append('lineas', JSON.stringify(lineas))

  //e.target.disabled = true
  e.preventDefault()
  $('senMail').disabled = false
  fetch(src + 'api/addListExt.php',{
    method: 'POST',
    body: orderExt
  })
  .then(e => e.json())
  .then((csvlineas)=>{
    //CREA UN FICHERO CSV CON LOS CAMPOS REFERENCIA Y DESIGNACION
    let csvLineas = ''
    csvlineas.forEach(element => {
      csvLineas += `${element}\n`
    });
    let csvContent = "data:text/csv;charset=utf-8," + encodeURIComponent(csvLineas)
    const link = document.createElement("a")
    link.setAttribute("href", csvContent)
    link.setAttribute("download", "contacts.csv")
    document.body.appendChild(link)
    link.click()
  })
})

$('selectProv').addEventListener('click',(e)=>{
  e.preventDefault()
  enviarCorreoAlProveedor()
})

$('addProvider').addEventListener('click',(e)=>{
  let countProv = document.getElementsByClassName('form-extLine').length
  e.preventDefault()
  let divContainer = document.createElement('div')
  let divHeader = document.createElement('div')
  let divLine = document.createElement('div')
  let divAddLine = document.createElement('div')
  let divSubmit = document.createElement('div')
  let divSumnitOrder = document.createElement('div')
  let sectionHeader = document.createElement('section')
  let spanNumerLine = document.createElement('span')
  let selectTipo = document.createElement('select')
  let selectMarca = document.createElement('select')
  let selectProveedor = document.createElement('select')
  let lblReferencia = document.createElement('label')
  let lblCantidad = document.createElement('label')
  let lblDesignacion = document.createElement('label')
  let lblFamilia = document.createElement('label')
  let lblPVP = document.createElement('label')
  let lblDtoCompra = document.createElement('label')
  let lblDtoVenta = document.createElement('label')
  let btnNewLine = document.createElement('button')
  let btnPpo = document.createElement('button')
  let btnOrder = document.createElement('button')

  // Aquí añade las opciones a los select
  cargarProveedor('','','',selectTipo, selectMarca, selectProveedor) //['DirIberica', 'Proveedor 2 Hyundai', 'Proveedor 3 BMW']

  lblReferencia.textContent = '*Referencia PR'
  lblCantidad.textContent = '*Cantidad'
  lblDesignacion.textContent = '*Descripción'
  lblFamilia.textContent = '*Familia'
  lblPVP.textContent = '*PVP'
  lblDtoCompra.textContent = '*Dto Compra'
  lblDtoVenta.textContent = '*Dto Venta'
  divContainer.id = `prov${countProv}`
  divLine.id = `formLine${countProv}`
  divContainer.classList.add('form-extLine')
  divHeader.classList.add('provHeader')
  divLine.classList.add('formLine')
  divAddLine.classList.add('addLine')
  divSubmit.classList.add('submitOrder')
  divSumnitOrder.classList.add('submitOrder')
  btnNewLine.textContent = 'Añadir línea'
  btnNewLine.id = 'addLine'
  btnNewLine.addEventListener('click',(e)=>{
    e.preventDefault()
    crearLineas(countProv,contadorLineas)
  })
  btnPpo.textContent = 'Solicitar presupuesto al proveedor'
  btnPpo.addEventListener('click',(e)=>{
    e.preventDefault()
    customAlert('Funcionalidad en desarrollo')
  })
  btnPpo.id = 'selectProv'
  btnOrder.textContent = 'Confirmar pedido'
  btnOrder.addEventListener('click',(e)=>{
    e.preventDefault()
    customAlert('Funcionalidad en desarrollo')
  })
  btnOrder.id = 'addOrder'
  selectTipo.id = `tipo${contadorLineas}`
  selectMarca.id = `marca${contadorLineas}`
  selectProveedor.id = `proveedor${contadorLineas}`
  selectTipo.addEventListener('change',(e)=>{
    cargarProveedor(e.target.value, '', '', selectTipo, selectMarca, selectProveedor)
  })
  selectMarca.addEventListener('change',(e)=>{
    cargarProveedor(selectTipo.value, e.target.value, selectProveedor.value, selectTipo, selectMarca, selectProveedor)
  })
  selectProveedor.addEventListener('change',(e)=>{
    cargarProveedor(selectTipo.value, selectMarca.value, e.target.value, selectTipo, selectMarca, selectProveedor)
  })

  $('contacts-items').appendChild(selectTipo)
  $('contacts-items').appendChild(selectMarca)
  $('contacts-items').appendChild(selectProveedor)
  sectionHeader.appendChild(spanNumerLine)
  sectionHeader.appendChild(lblReferencia)
  sectionHeader.appendChild(lblCantidad)
  sectionHeader.appendChild(lblDesignacion)
  sectionHeader.appendChild(lblFamilia)
  sectionHeader.appendChild(lblPVP)
  sectionHeader.appendChild(lblDtoCompra)
  sectionHeader.appendChild(lblDtoVenta)
  divHeader.appendChild(selectTipo)
  divHeader.appendChild(selectMarca)
  divHeader.appendChild(selectProveedor)
  divSumnitOrder.appendChild(btnPpo)
  divSumnitOrder.appendChild(btnOrder)

  divContainer.appendChild(divHeader)
  divLine.appendChild(sectionHeader)
  divContainer.appendChild(divLine)
  divContainer.appendChild(btnNewLine)
  divContainer.appendChild(divSumnitOrder)
  $$('form')[0].appendChild(divContainer)
  crearLineas(countProv,contadorLineas)
  contadorLineas++
})

// Elimina la fila creada al hacer click sobre la imagen de eliminar
$('contacts-items').addEventListener('click',(e)=>{
  if(e.target.tagName === 'IMG'){
    let id = e.target.id.substring(6)
    let div = document.getElementById(`delete${id}`)
    fetch(`../api/deleteLineExt.php?id=${id}&user=${user.hash}`)
    .then(res => res.text())
    .then(res => {
      if(res === 'ok')  {
        div.parentNode.remove()
        contadorLineas--
        customAlert('Línea eliminada correctamente')
      }else customAlert('Error al eliminar la línea') 
      })
  }
})

$('destino').addEventListener('change',()=>{
  const cliente = $('client').value.split('-')[0]
  const destino = $('destino').value.substring(0,3)
  buscarCliente(destino,cliente)
  const numPedido = $('numPedido').innerText
  numPedido === '' ? crearPedido() : actualizarPedido($('numPedido').innerText)
})

$('client').addEventListener('blur',(e)=>{
  const cliente = $('client').value.split('-')[0]
  const destino = $('destino').value.substring(0,3)
  buscarCliente(destino,cliente)
  const numPedido = $('numPedido').innerText
  numPedido === '' ? crearPedido() : actualizarPedido($('numPedido').innerText)
})

$('envio').addEventListener('blur',()=>{
  actualizarPedido($('numPedido').innerText)
})

$('coment').addEventListener('blur',()=>{
  actualizarPedido($('numPedido').innerText)
})

$('marca0').addEventListener('change',e=>{
  cargarProveedor($('tipo0').value, e.target.value, $('proveedor0').value, $('tipo0'), $('marca0'), $('proveedor0'))
})

$('tipo0').addEventListener('change',e=>{
  cargarProveedor(e.target.value, '', '', $('tipo0'), $('marca0'), $('proveedor0'))
})