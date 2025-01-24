'use strict';
const btnBuscar = document.getElementById("btnBuscar")

btnBuscar.addEventListener('click', e => {
  e.preventDefault()
  const nCliente = document.getElementById("clientNumber").value
  const data = new FormData()
  data.append('search',nCliente)
  data.append('placa','MAD')
  fetch('../api/getClientName.php', {
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
        <li class="send" style="cursor:pointer" id="id${item.id}">📨</li>
      </ul>`
    })
    $('resultado').innerHTML = resultado + '</section>'
    
  })
})