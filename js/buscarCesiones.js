
// Accion de los botones de navegación
const id = window.location.search.split('?id=')[1]

document.getElementById('new').addEventListener('click',()=>{
  document.location = `../cesionesADV.php?id=${id}`
})

document.getElementById('find').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./ready.php?id=${id}`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./finish.php?id=${id}`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./status.php?id=${id}`
})

//Código de la búsqueda
document.getElementById('search-ref').addEventListener('submit',e=>{
  e.preventDefault()
  e.stopImmediatePropagation()
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
  data.append('id',ref)
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
        copyClipboard(e.target.textContent.replaceAll(' ',''))
    })
  })
})

window.addEventListener('load',()=>{
  document.getElementById('refAssig').focus()
}) 

const copyClipboard = (copiar) =>{
  navigator.clipboard.writeText(copiar)
  notify(`${copiar} copiado!`)
}