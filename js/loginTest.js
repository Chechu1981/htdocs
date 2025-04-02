'use strict';

const mail = document.getElementById('mail')

document.getElementsByTagName('form')[0].addEventListener('submit', function(e){
  e.preventDefault()
  e.stopImmediatePropagation()
  const data = new FormData(this)
  fetch('../../api/getMailExist.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(datos => {
    if(datos.error){
      mail.innerHTML = datos.error
      mail.classList.add('error')
    }else{
      if(!datos){
        errorText.innerHTML = "Correo no registrado"
        return
      }else{
        data.append('cuerpo', `Hola, este es tu código de verificación: ${datos}`)
        data.append('asunto', 'Código de verificación - Chechuparts')
        data.append('newpassword', datos)
        fetch('../../helper/mail.php',{
          method: 'POST',
          body: data
        })
        fetch('../../api/updatePassword.php',{
          method: 'POST',
          body: data
        })
        

        errorText.innerHTML = "Comprueba tu correo electrónico e intruduce el código enviado en la casilla"
      }
    }
  })
}
)