const id = window.location.search.split('?id=')[1]

document.getElementById('new').addEventListener('click',()=>{
  document.location = `../cesionesADV.php?id=${id}`
})

document.getElementById('all').addEventListener('click',()=>{
  document.location = `../cesionesAll.php?id=${id}`
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./buscar.php?id=${id}`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./ready.php?id=${id}`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./status.php?id=${id}`
})

window.addEventListener('load',()=>{
  let info
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
  data.append('id','all')
  data.append('session',id)
  data.append('sort','date')
  fetch('../../api/getAssig.php',{
    method: 'POST',
    body: data
  })
  .then(item => item.text())
  .then(rows =>{
    section.innerHTML = rows
    const refCopy = document.getElementsByClassName('copy')
    for(let i = 0; i < refCopy.length;i++){
      refCopy[i].addEventListener('click',e =>{
        copyClipboard(e.target.textContent.replaceAll(' ',''))
      })
    }
  })
})

const copyClipboard = (copiar) =>{
  navigator.clipboard.writeText(copiar)
  notify(`${copiar} copiado!`)
}