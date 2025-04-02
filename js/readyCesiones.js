"use strict";
import contadores from "./updateCounter.js"

setInterval(() =>{contadores()},1000)

const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `../cesionesAll.php`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location = `../cesionesADV.php`
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./buscar.php`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./finish.php`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./status.php`
})

document.getElementById('extBrand').addEventListener('click',()=>{
  document.location = `./extbrand.php`
})

window.addEventListener('load',()=>{
  const uriData = new FormData()
  const id = document.cookie.split('id=')[1]
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