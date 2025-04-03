'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const badLoggin = parseInt(window.location.search.split('error=')[1])
    const errorText = document.getElementById('errorText')
    if (badLoggin) {
        errorText.innerHTML = "Usuario o clave incorrectos"
    }
});
document.getElementsByTagName('form')[0].addEventListener = e => {
    e.preventDefault()
    const psw = document.getElementById('psw').value
    const usr = document.getElementById('usr').value
    const data = new FormData()
    data.append('psw', psw)
    data.append('usr', usr)
    fetch('../../api/getUser.php', {
        method: 'POST',
        body: data,
    })
    .then((response) => response.text())
    .then((datos) => {
        if (datos == "true") {
             e.submit()
        } else {
            errorText.innerHTML = "Usuario o clave incorrectos"
        }
    })
    .catch((error) => {
        errorText.innerHTML = 'Error:', error
    });
}