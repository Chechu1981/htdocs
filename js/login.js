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

const box = document.getElementsByClassName('mainBox')[0]
document.addEventListener('mousemove', e => {
    const x = e.clientX
    const y = e.clientY
    let widthScreen = window.innerWidth / 2
    let heightScreen = window.innerHeight / 2
    box.style.transform = `matrix3d(1, 0, 0, ${(x / 5000000) - (widthScreen / 5000000)}, 0, 1, 0, ${(y / 5000000) - (heightScreen / 5000000)}, 0, 0, 1, 0, 0, 0, -200, 1)`
    box.style.boxShadow = `-${x / 100}px -${y / 100}px 21px`
    box.style.transition = 'transform 0.1s ease'
})