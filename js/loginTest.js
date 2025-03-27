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


if(window.location.pathname == '/pendientes')
    window.location = "https://ppcr.es/pendientes/"