'use strict';

const recargar = (destino,idUser = 0) =>{
  const id = getIdByCookie(document.cookie)
  window.location.href = `${destino}?userId=${idUser}`
}

document.getElementById('newUser').addEventListener('click',e =>{
  recargar('../helper/formNewProv.php')
})

const cargarEventos = () =>{
  const pictures = document.getElementsByClassName('split-screen')[0].getElementsByTagName('img')
  for(let index = 0; index < pictures.length; index++) {
    pictures[index].addEventListener('click', (e) =>{
      const id = e.target.parentNode.parentNode.childNodes[3].id
      const proveedor = e.target.parentNode.parentNode.childNodes[3].innerHTML
      let confirmacion = false
      if(e.target.alt == 'eliminar')
        confirmacion = confirm(`¿Quieres eliminar a ${proveedor} como proveedor?`)
      const src = e.target.alt == 'eliminar' ? 
      '../api/deleteProv.php' :
      '../api/updateProv.php'
      const data = new FormData
      data.append('id', id)
      if(confirmacion){
        fetch(src,{
          method: 'POST',
          body:data
        })
        .then(rec=>rec.text())
        .then(fin => recargar('../update/configProv.php'))
      }else{
        recargar('../helper/formEditProv.php',id)
      }
    })
  }
}

$('buttons_plates').addEventListener('click', e =>{
  if(e.target.className != 'btn')
    return
  const buttons = document.getElementsByClassName('btn')
  for(let btn of buttons){
    btn.classList.remove('active')
  }
  e.target.classList.add('active')
  fetch('../api/getProvList.php',{
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({placa: e.target.innerText})
    })
  .then(res => res.text())
  .then(data => {
    $('prov-list').innerHTML = data
    cargarEventos()
  })
})