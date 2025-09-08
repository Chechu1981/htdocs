'use strict'
import { buscarCliente } from "../../js/alertsAssigns.js?106"
import { cargarProveedor, crearLineas, actualizarPedido } from "./ExtApi.js?106"

const numPedido = document.location.search.split('=')[1]
let contadorLineas = 1

// Botones del menú Compras exteriores
$('all').addEventListener('click',()=>{
  document.location.href = './orderList.php'
})

$('new').addEventListener('click',()=>{
  document.location.href = '../extbrand.php'
})

//Cargo las lineas del  pedido
fetch(`../../api/getExtOrderLines.php?id=${numPedido}`)
.then(response => response.json())
.then(data => {
  $('client').value = data[0].cliente.split('-')[0] ?? ''
  $('coment').innerText = data[0].comentario
  $('envio').value = data[0].cliente.split('-')[1] ?? ''
  $('clientName').innerText = data[0].nombre_cliente
  cargarProveedor(data[0].tipo, data[0].marca, data[0].proveedor, $('tipo0'), $('marca0'), $('proveedor0'))
  for(let tipos of $('tipo0').childNodes){
    if(tipos.value == data[0].tipo)
      tipos.selected = true
  }
  for(let marcas of $('marca0').childNodes){
    if(marcas.value == data[0].marca)
      marcas.selected = true
  }
  for(let proveedores of $('proveedor0').childNodes){
    if(proveedores.value == data[0].proveedor)
      proveedores.selected = true
  }
  $('tipo0').value = data[0].tipo
  data.forEach(linea => {
    for (let element of $('destino').childNodes) {
      if (element.value == linea.placa)
        element.selected = true
    }
    crearLineas('0',contadorLineas,linea)
    contadorLineas++
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

$('envio').addEventListener('blur',()=>{
  actualizarPedido(numPedido)
})

$('coment').addEventListener('blur',()=>{
  actualizarPedido(numPedido)
})

$('marca0').addEventListener('change',e=>{
  cargarProveedor($('tipo0').value, e.target.value, $('proveedor0').value, $('tipo0'), $('marca0'), $('proveedor0'))
})

$('tipo0').addEventListener('change',e=>{
  cargarProveedor(e.target.value, '', '', $('tipo0'), $('marca0'), $('proveedor0'))
})

$('addLine').addEventListener('click',(e)=>{
  e.preventDefault()
  crearLineas(e.target.parentNode.parentNode.childNodes[3].id.split('formLine')[1],contadorLineas)
  contadorLineas++
})

// Elimina la fila creada al hacer click sobre la imagen de eliminar
$('formLine0').addEventListener('click',(e)=>{
  if(e.target.tagName === 'IMG'){
    let id = e.target.id.substring(6)
    let div = document.getElementById(`delete${id}`)
    let idLine = $(`ref${id}`).title
    fetch(`${src}/api/deleteLineExt.php?id=${idLine}&user=${user.hash}`)
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

//Doy funcionalidad a los botones de Solicitar presupuesto y Enviar pedido

$('selectProv').addEventListener('click',(e)=>{
  customAlert('Funcionalidad en desarrollo')
})

$('addOrder').addEventListener('click', (e) =>{
  e.preventDefault()
  let datos = new FormData()
  datos.append('id', numPedido)

  fetch(`${src}/api/updateConfirmOrder.php`,{
    method: 'POST',
    body: datos
  })
  .then(res => res.text())
  .then(res => {
    if(res === 'ok'){
      customAlert('Pedido creado correctamente')
    }else{
      customAlert('Error al crear el pedido')
    }
  })
})
