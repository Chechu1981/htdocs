'use strict'
import { buscarCliente } from "../../js/alertsAssigns.js?106"
import { cargarProveedor, crearLineas, actualizarPedido, enviarCorreoAlProveedor, enviarCorreoGestion, enviarCorreoTransporte, actualizarPedidoLineas, validarFormulario } from "./ExtApi.js?106"

const numPedido = document.location.search.split('=')[1]

// Botones del menú Compras exteriores
$('all').addEventListener('click',()=>{
  document.location.href = './orderList.php'
})

$('new').addEventListener('click',()=>{
  document.location.href = '../extbrand.php'
})

const bloquearPedido = (lineas) => {
  $('addOrder').style.display = 'none'
  $('addLine').style.display = 'none'
  $('selectProv').style.display = 'none'
  $('coment').setAttribute('disabled','true')
  $('client').setAttribute('disabled','true')
  $('destino').setAttribute('disabled','true')
  $('envio').setAttribute('disabled','true')
  $('marca0').setAttribute('disabled','true')
  $('tipo0').setAttribute('disabled','true')
  $('proveedor0').setAttribute('disabled','true')
  for(let i = 0; i < lineas; i++){
    $(`ref${i}`).setAttribute('disabled','true')
    $(`comentLine${i}`).setAttribute('disabled','true')
    $(`units${i}`).setAttribute('disabled','true')
    $(`familyParts${i}`).setAttribute('disabled','true')
    $(`pvp${i}`).setAttribute('disabled','true')
    $(`dtoCompra${i}`).setAttribute('disabled','true')
    $(`dtoVenta${i}`).setAttribute('disabled','true')
  }
  for(let img of document.querySelectorAll('img')){
    if(img.id.substring(0,6) == 'delete')
      img.style.display = 'none'
  }
}

//Cargo la cabecera del pedido
document.addEventListener('DOMContentLoaded', () => {
  let numLineas = 0
  fetch(`../../api/getExtAllOrdersById.php?id=${numPedido}`)
  .then(response => response.json())
  .then(data => {
    $('client').value = data[0].cliente.split('-')[0] ?? ''
    $('coment').innerText = data[0].comentario
    let enviado = false
    if(data[0].conf_pedido != null)
      enviado = true
    
    let envio = data[0]['cliente'].split('-')[1] == "" ? '0' : data[0]['cliente'].split('-')[1].split(' ')[0] ?? ''
    if(envio != ''){
      $('envio').innerHTML = `<option value="${envio}">${envio}</option>`
      $('envio').value = envio
    }
    $('clientName').innerText = data[0]['cliente'].split('-')[1] == '' ? '' : data[0].cliente.split(' (')[1].split(')')[0]
    //Cargo las lineas del  pedido
    fetch(`../../api/getExtOrderLines.php?id=${numPedido}`)
    .then(response => response.json())
    .then(dataLinea => {
      numLineas = dataLinea.length
      if(dataLinea.length <= 0)
        return
      cargarProveedor(dataLinea[0].tipo, dataLinea[0].marca, dataLinea[0].proveedor, $('tipo0'), $('marca0'), $('proveedor0'))
      for(let tipos of $('tipo0').childNodes){
        if(tipos.value == dataLinea[0].tipo)
          tipos.selected = true
      }
      for(let marcas of $('marca0').childNodes){
        if(marcas.value == dataLinea[0].marca)
          marcas.selected = true
      }
      for(let proveedores of $('proveedor0').childNodes){
        if(proveedores.value == dataLinea[0].proveedor)
          proveedores.selected = true
      }
      $('tipo0').value = dataLinea[0].tipo
      dataLinea.forEach(linea => {
        for (let element of $('destino').childNodes) {
          if (element.value == linea.placa)
            element.selected = true
        }
        crearLineas('0',linea)
      })
      if(enviado)
        bloquearPedido(numLineas)
    })
  })
})


//doy funcionalidad a los campos del pedido
$('destino').addEventListener('change',()=>{
  const cliente = $('client').value.split('-')[0]
  const destino = $('destino').value.substring(0,3)
  buscarCliente(destino,cliente)
  actualizarPedido(numPedido)
})

$('client').addEventListener('blur',(e)=>{
  const cliente = $('client').value.split('-')[0]
  const destino = $('destino').value.substring(0,3)
  buscarCliente(destino,cliente)
  actualizarPedido(numPedido)
})

$('envio').addEventListener('change',()=>{
  actualizarPedido(numPedido)
})

$('coment').addEventListener('blur',e =>{
  e.target.value = e.target.value.toUpperCase()
  actualizarPedido(numPedido)
})

$('marca0').addEventListener('change',e =>{
  cargarProveedor($('tipo0').value, e.target.value, $('proveedor0').value, $('tipo0'), $('marca0'), $('proveedor0'))
  setTimeout(() => actualizarPedidoLineas(numPedido), 500)
})

$('tipo0').addEventListener('change',e =>{
  cargarProveedor(e.target.value, '', '', $('tipo0'), $('marca0'), $('proveedor0'))
  setTimeout(() => actualizarPedidoLineas(numPedido), 500)
})

$('proveedor0').addEventListener('change',() =>{
  actualizarPedidoLineas(numPedido)
})

$('addLine').addEventListener('click',(e)=>{
  e.preventDefault()
  crearLineas(e.target.parentNode.parentNode.childNodes[3].id.split('formLine')[1])
})

// Elimina la fila creada al hacer click sobre la imagen de eliminar
$('formLine0').addEventListener('click',(e)=>{
  if(e.target.tagName === 'IMG'){
    let id = e.target.id.substring(6)
    let div = document.getElementById(`delete${id}`)
    let idLine = $(`ref${id}`).title
    if(!confirm("¿Quieres eliminra la línea?"))
      return true
    fetch(`${src}/api/deleteLineExt.php?id=${idLine}&user=${user.hash}`)
    .then(res => res.text())
    .then(res => {
      res === 'ok' ? div.parentNode.remove() : customAlert('Error al eliminar la línea') 
    })
  }
})

//Doy funcionalidad a los botones de Solicitar presupuesto y Enviar pedido
/*
$('selectProv').addEventListener('click',(e)=>{
  e.preventDefault()
})*/

$('addOrder').addEventListener('click', e =>{
  e.preventDefault()
  if(!validarFormulario(e))
    return
  let datos = new FormData()
  datos.append('id', numPedido)
  
  fetch(`${src}/api/updateConfirmOrder.php`,{
    method: 'POST',
    body: datos
  })
  .then(res => res.text())
  .then(res => {
    if(res === 'Fichero creado correctamente\nok'){
      customAlert('Pedido creado correctamente')
      if($('proveedor0').value != 'AUTOPARTS')
        enviarCorreoAlProveedor()
      enviarCorreoGestion()
      enviarCorreoTransporte()
      bloquearPedido(document.querySelectorAll('[id^="ref"]').length)
    }else{
      customAlert('Error al crear el pedido')
    }
  })
})
