import contadores from "./updateCounter.js?101"

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
  document.location = `./ready.php`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./status.php`
})

document.getElementById('extBrand').addEventListener('click',()=>{
  document.location = `./extbrand.php`
})

setTimeout(()=>{
    const id = document.cookie.split('id=')[1]
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
    data.append('id','stop')
    data.append('session',id)
    data.append('sort','date')
    data.append('puesto',user.puesto)
    fetch('../../api/getAssig.php',{
      method: 'POST',
      body: data
    })
    .then(item => item.text())
    .then(rows =>{
      section.innerHTML = rows
      const refCopy = document.getElementsByClassName('copy')
      for(let i = 0; i < refCopy.length;i++){
        const id = refCopy[i].parentNode.id
        $(`rechazo${id}`).addEventListener('click',() =>{
          if(user.puesto != 'ADV')
            return false
          const anular = confirm('¿Reanudar la cesión?')
          if(anular){
            const data = new FormData()
            data.append('id',id)
            fetch('./../../api/updateDeclane.php',{
              method: 'POST',
              body: data
            })
            window.location.reload()
          }
        })
        refCopy[i].addEventListener('click',e =>{
          copyClipboard(e.target.textContent.replaceAll(' ',''))
        })
      }
    })
},500)


const copyClipboard = (copiar) =>{
  navigator.clipboard.writeText(copiar)
  notify(`${copiar} copiado!`)
}