'use strict';

document.getElementsByTagName('form')[0].addEventListener('submit', (event) => {
  const method = window.location.href.includes('Edit') ? 'edit' : 'new'
  event.preventDefault()
  const nombre = $('nombre').value
  const email = $('email').value
  const direccion = $('direccion').value

  if(nombre == ''){
    customAlert("El nombre no puede estar vacío")
    $('nombre').value = ""
    return null
  }
  const datos = new FormData()
    datos.append('placa', $('placa').value)
    datos.append('nombre', nombre)
    datos.append('id_prov', $('nprov').value)
    datos.append('marca', $('marca').value)
    datos.append('tipo', $('tipo').value)
    datos.append('email', email)
    datos.append('telefono', $('tlf').value)
    datos.append('direccion', direccion)
    datos.append('entrega', $('entrega').checked ? 'S' : 'N')
    if(method == 'new'){
      fetch('/../api/addNewProv.php',{
        method: 'POST',
        body: datos
      })
      const id = window.location.search.split('?userId=')[1]
      window.location.href = `../update/configProv.php?id=${id}`
    }else if(method == 'edit'){
      datos.append('id', window.location.search.split('?userId=')[1])
      fetch('/../api/updateProv.php',{
        method: 'POST',
        body: datos
      })
      const id = window.location.search.split('?userId=')[1]
    window.location.href = `../update/configProv.php?id=${id}`
  }
})

document.getElementById('userList').addEventListener('click',e =>{
  const id = window.location.search.split('=')[1].split('&')[0]
  window.location.href = `../update/configProv.php?id=${id}`
})