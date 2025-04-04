'use strict';

const mail = document.getElementById('mail')

document.getElementsByTagName('form')[0].addEventListener('submit', function(e){
  e.preventDefault()
  e.stopImmediatePropagation()
  document.getElementsByTagName('form')[0].children[1].disabled = true
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
      document.getElementsByTagName('form')[0].children[1].disabled = false
    }else{
      if(!datos){
        errorText.innerHTML = "Correo no registrado"
        document.getElementsByTagName('form')[0].children[1].disabled = false
        return
      }else{
        data.append('key', datos)
        data.append('newpassword', datos)
        fetch('./mailRecoveryTemplate.php',{
          method: 'POST',
          body: data
        }).then(response => response.text())
        .then(() => {
          fetch('../../api/updateRecoveryPass.php',{
            method: 'POST',
            body: data
          }).then(response => response.text())
          .then(() => {
            window.location.href = `./recuperarPass2.php?mail=${mail.value}`
          })
        })
        errorText.innerHTML = "Enviando correo electrónico"
      }
    }
  })
}
)