'use strict';

const recargar = (destino,idUser = 0) =>{
  const id = getIdByCookie(document.cookie)
  window.location.href = `${destino}?id=${id}&userId=${idUser}`
}

document.getElementById('newUser').addEventListener('click',e =>{
  recargar('../helper/formNewProv.php')
})

const pictures = document.getElementsByClassName('users')[0].getElementsByTagName('img')

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