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
    datos.append('nombre', nombre)
    datos.append('email', email)
    datos.append('direccion', direccion)
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