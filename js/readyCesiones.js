"use strict";
import contadores from "./updateCounter.js"

setInterval(() =>{contadores()},1000)

const id = window.location.search.split('?id=')[1]
const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `../cesionesAll.php?id=${id}`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location = `../cesionesADV.php?id=${id}`
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./buscar.php?id=${id}`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./finish.php?id=${id}`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./status.php?id=${id}`
})

document.getElementById('extBrand').addEventListener('click',()=>{
  document.location = `./extBrand.php?id=${id}`
})

window.addEventListener('load',()=>{
  const uriData = new FormData()
  uriData.append('subfolder',id)
  fetch('../../api/spinner.php',{
    method: 'POST',
    body:uriData
  })
  .then(fn => fn.text())
  .then(req => section.innerHTML = req)
  const section = document.getElementById('cesiones')
  const data = new FormData()
  data.append('id','new')
  data.append('session',id)
  data.append('sort','date')
  fetch('../../api/getAssig.php',{
    method: 'POST',
    body: data
  })
  .then(item => item.text())
  .then(rows => {
    section.innerHTML = rows
    const refCopy = document.getElementsByClassName('copy')
    for(let i = 0; i < refCopy.length;i++)
      refCopy[i].addEventListener('click',e =>{
        let listRows = $('cesiones').getElementsByTagName('ul')
        for(let j = 0; j < listRows.length ; j++)
          listRows[j].style = ''
        e.target.parentNode.style.color = 'royalblue'
        e.target.parentNode.style.backgroundColor = 'aquamarine'
        copyClipboard(e.target.textContent.replaceAll(' ',''))
    })
    const btnTik = cesiones.getElementsByTagName('img')
    for(let i = 0;i < btnTik.length; i++){
      if(btnTik[i].alt == 'tick'){
        btnTik[i].addEventListener('click',e=>{
          if(confirm("Se ha recibido esta cesion?") == true){
            const data = new FormData()
            data.append('id',e.target.id)
            fetch('../../api/updateAssig.php',{
              method: 'POST',
              body: data
            })
            .then(response => response.text())
            .then(() => {
              e.target.parentNode.parentNode.remove()
              ready.firstChild.innerText = parseInt(ready.firstChild.innerText) - 1
            })
          }
        })
      }
    }
  })
})

const copyClipboard = (copiar) =>{
  navigator.clipboard.writeText(copiar)
  notify(`${copiar} copiado!`)
}