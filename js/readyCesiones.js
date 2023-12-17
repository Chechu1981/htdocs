const id = window.location.search.split('?id=')[1]

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
              e.target.parentNode.parentNode.style.display = 'none'
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