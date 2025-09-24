'use strict';
import { createMailBparts, createMailJumasa, createMailWiuse } from "./createMail.js?240925"
const btnBuscar = document.getElementById("btnBuscar")
const proveedores = {
  'B-Parts': createMailBparts,
  'Jumasa': createMailJumasa,
  'Wiuse': createMailWiuse
}

btnBuscar.addEventListener('click', e => {
  e.preventDefault()
  const nCliente = document.getElementById("clientNumber").value
  const data = new FormData()
  data.append('search',nCliente)
  data.append('placa','MAD')
  fetch(`${src}api/getClientName.php`, {
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(client => {
    if (client[0] == '{') 
      return $('resultado').innerHTML = '<p>No se ha encontrado coincidencias</p>'
    let resultado = '<section id="result" style="height: inherit">'
    client.forEach(item => {
      resultado +=  `<ul style="font-size: 0.9em;grid-template-columns:6% 39% 30% 15% 7%;padding-left: revert;">
        <li>${item.envio}</li>
        <li>${item.cliente}</li>
        <li>${item.direccion}</li>
        <li>${item.poblacion}</li>
        <li class="send" style="cursor:pointer" id="id${item.id}" title="Enviar correo a placa de Madrid para notificar B-Parts del cliente ${item.code}">📨</li>
      </ul>`
    })
    $('resultado').innerHTML = resultado + '</section>'
  })
})

$('resultado').addEventListener('click', e => {
  const proveedor = document.getElementsByClassName('note-body')[0].getElementsByTagName('h2')[0].textContent
  if(e.target.id.startsWith('id')){
    const id = e.target.id.split('id')[1]
    const data = new FormData()
    data.append('id',id)
    fetch(`${src}api/getClientById.php`, {
      method: 'POST',
      body: data
    }).then(response => response.json())
    .then(client => {
      if(proveedor === 'WIUSE'){
        createMailWiuse(client[0])
      }else if(proveedor === 'JUMASA'){
        createMailJumasa(client[0])
      }else if(proveedor === 'B-PARTS'){
        createMailBparts(client[0])
      }
      location.reload()
    })
  }
})

clientNumber.focus()