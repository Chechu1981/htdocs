'use strict';

function usuarioExiste(usuario){
  const data = new FormData()
  data.append('usuario', usuario)
  let exsiste = false
  fetch('/../api/getUserExist.php',{
    method: 'POST',
    body: data
  })
  .then((response) => response.text())
  .then((responseData) => {
    if(responseData){
      customAlert("Usuario exsiste")
      $('nombre').value = ""
      exsiste = true
      return exsiste
    }else{
      return exsiste
    }
  })
}

$('nombre').addEventListener('blur', (e) =>{
  usuarioExiste(e.target.value)
})

document.getElementsByTagName('form')[0].addEventListener('submit', (event) => {
  const method = window.location.href.includes('Edit') ? 'edit' : 'new'
  event.preventDefault()
  const nombre = $('nombre').value
  const email = $('email').value
  const puesto = $('puesto').value
  const pass1 = $('pass1').value
  const pass2 = $('pass2').value
  if(pass1 != pass2){
    customAlert("contraseñas no coinciden")
    $('nombre').value = ""
    return null
  }
  if(nombre == ''){
    customAlert("El nombre no puede estar vacío")
    $('nombre').value = ""
    return null
  }
  const datos = new FormData()
    datos.append('nombre', nombre)
    datos.append('email', email)
    datos.append('puesto', puesto)
    datos.append('pass', pass1)
  if(method == 'new'){
    fetch('/../api/addNewUser.php',{
      method: 'POST',
      body: datos
    })
    const id = window.location.search.split('=')[1].split('&')[0]
    window.location.href = `../update/configUsers.php?id=${id}`
  }else if(method == 'edit'){
    datos.append('id', window.location.search.split('=')[2].split('&userId=')[0])
    fetch('/../api/updateUser.php',{
      method: 'POST',
      body: datos
    })
    const id = window.location.search.split('=')[1].split('&')[0]
    window.location.href = `../update/configUsers.php?id=${id}`
  }
})

document.getElementById('userList').addEventListener('click',e =>{
  const id = window.location.search.split('=')[1].split('&')[0]
  window.location.href = `../update/configUsers.php?id=${id}`
})