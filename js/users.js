'use strict';

const recargar = (destino,idUser = 0) =>{
  const id = window.location.search.split('=')[1]
  window.location.href = `${destino}?id=${id}&idUser=${idUser}`
}

document.getElementById('newUser').addEventListener('click',e =>{
  recargar('../helper/formNewUser.php')
})

const pictures = document.getElementsByClassName('users')[0].getElementsByTagName('img')

for(let index = 0; index < pictures.length; index++) {
  pictures[index].addEventListener('click', (e) =>{
    const id = e.target.parentNode.parentNode.childNodes[1].id
    const usuario = e.target.parentNode.parentNode.childNodes[1].innerHTML
    let confirmacion = false
    if(e.target.alt == 'eliminar')
      confirmacion = confirm(`¿Quieres eliminar el usuario ${usuario}`)
    const src = e.target.alt == 'eliminar' ? 
    '../api/deleteUser.php' :
    '../api/updateUser.php'
    const data = new FormData
    data.append('id', id)
    if(confirmacion){
      fetch(src,{
        method: 'POST',
        body:data
      })
      recargar('../update/configUsers.php')
    }else{
      recargar('../helper/formEditUser.php',id)
    }
  })

}