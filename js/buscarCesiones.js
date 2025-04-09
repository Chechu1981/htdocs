import contadores from "./updateCounter.js"

setInterval(() =>{contadores()},1000)

// Accion de los botones de navegación
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
  document.location.reload()
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./ready.php`
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

//Código de la búsqueda  
const seacrhRef = e => {
  e.preventDefault()
  e.stopImmediatePropagation()
  const id = getIdByCookie(document.cookie)
  let referencia = $('refAssig').value
  let origen = $('origen').value
  let destino = $('destino').value
  let asegurado = $('seguro').checked
  const uriData = new FormData()
  uriData.append('subfolder',id)
  fetch('../../api/spinner.php',{
    method: 'POST',
    body:uriData
  })
  .then(fn => fn.text())
  .then(req => section.innerHTML = req)
  const section = document.getElementById('cesiones')
  const ref = document.getElementById('refAssig').value.replaceAll(' ','')
  const data = new FormData()
  data.append('id',referencia)
  data.append('origen',origen)
  data.append('destino',destino)
  data.append('asegurado',asegurado)
  data.append('session',id)
  fetch('./../../api/getAssig.php',{
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
              seacrhRef(e)
              ready.firstChild.innerText = parseInt(ready.firstChild.innerText) - 1
            })
          }
        })
      }
    }
  })
}

document.getElementById('search-ref').addEventListener('submit',e => seacrhRef(e))

window.addEventListener('load',()=>{
  document.getElementById('refAssig').focus()
}) 

const copyClipboard = (copiar) =>{
  navigator.clipboard.writeText(copiar)
  notify(`${copiar} copiado!`)
}