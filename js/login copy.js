const lblUsr = document.getElementsByTagName('label')[0]
const lblPsw = document.getElementsByTagName('label')[1]
const inpUsr = document.getElementsByTagName('input')[0]
const inpPsw = document.getElementsByTagName('input')[1]


inpUsr.addEventListener('keyup', (e) => {
    e.target.value != '' ? lblUsr.classList.add('hide') : lblUsr.classList.remove('hide')
})

inpPsw.addEventListener('keyup', (e) => {
    e.target.value != '' ? lblPsw.classList.add('hide') : lblPsw.classList.remove('hide')
})

document.forms[0].addEventListener('submit', (e) => {
    data = new FormData()
    data.append('usr',inpUsr.value)
    data.append('psw', inpPsw.value)
    fetch("./api/getUser.php", {
        method: 'POST',
        body:data})
    .then(response => response.text())
    .then(res =>{
        res != "false" ? window.location.href = `./home.php?id=${res}` : document.getElementById('msg').innerHTML = `Usuario ${inpUsr.value} no corresponde`
    })
    .catch(error => console.log(error))
    e.preventDefault()
})

document.getElementsByClassName('top')[0].childNodes[1].addEventListener('click', e =>{
    e.target.parentNode.childNodes[3].classList.toggle("show")
})

if(window.location.pathname == '/pendientes')
    window.location = "https://ppcr.es/pendientes/"