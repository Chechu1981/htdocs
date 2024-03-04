$('nombre').addEventListener('blur', (e) =>{
  const data = new FormData()
  data.append('usuario', e.target.value)
  fetch('/../api/getUserExist.php',{
    method: 'POST',
    body: data
  })
  .then((response) => response.text())
  .then((responseData) => {
    if(responseData){
      customAlert("Usuario exsiste")
      $('nombre').value = ""
      return null
    }
  })
})

document.getElementsByTagName('form')[0].addEventListener('submit', (event) => {
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
  fetch('/../api/addNewUser.php',{
    method: 'POST',
    body: datos
  })
  window.location.reload()
})