let success = {
  update:"../api/updateNotebook.php",
  delete:"../api/deleteNotebook.php",
  new:"../api/addNotebook.php"
}

// Establecer imagen por defecto en el dropContainer
window.addEventListener('DOMContentLoaded', () => {
  const dropContainer = document.getElementById('dropContainer')
  if(dropContainer && dropContainer.innerText === '') {
    dropContainer.innerHTML = '<img src="../img/upload-default.png" alt="Subir archivo" style="max-width: 100%; opacity: 0.5;" />'
  }
})

document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
  const src = success[e.target.title]
  e.preventDefault()
  e.stopImmediatePropagation()
  const fileTarget = e.target.children[8].files[0] ? e.target.children[8].files[0] : document.getElementById('dropContainer').innerText
  document.getElementById('dropContainer').innerText == "Arrastra aqui algún fichero" ? fileTarget = "" : null

  let id = e.target.children[11].value
  const hash = window.parent.location.search.split('=')[1]
  if(e.target.children[11] != undefined)
    id = id

  const marca = e.target.children[1].value
  const modelo = e.target.children[3].value
  const descripcion = e.target.children[5].value
  const referencia = e.target.children[7].value
  const file = fileTarget

  //check for empty inputs
  if(e.target.children[1].value+e.target.children[3].value+e.target.children[5].value+e.target.children[7].value == '')
    return null
  
  // Crear elemento para mostrar el progreso
  const progressContainer = document.createElement('div')
  progressContainer.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 9999; min-width: 300px; text-align: center;'
  progressContainer.innerHTML = `
    <div style="margin-bottom: 10px; font-weight: bold;">Subiendo archivo...</div>
    <div style="width: 100%; background: #e0e0e0; border-radius: 10px; overflow: hidden; height: 30px; position: relative;">
      <div id="progressBar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #4CAF50, #45a049); transition: width 0.3s;"></div>
      <div id="progressText" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: bold; color: #333;">0%</div>
    </div>
  `
  document.body.appendChild(progressContainer)

  // Usar XMLHttpRequest para monitorear el progreso
  const xhr = new XMLHttpRequest()
  
  // Evento de progreso de subida
  xhr.upload.addEventListener('progress', (event) => {
    if (event.lengthComputable) {
      const percentComplete = Math.round((event.loaded / event.total) * 100)
      document.getElementById('progressBar').style.width = percentComplete + '%'
      document.getElementById('progressText').textContent = percentComplete + '%'
    }
  })
  
  // Evento cuando la subida se completa
  xhr.addEventListener('load', () => {
    if (xhr.status === 200) {
      document.getElementById('progressText').textContent = '100% - Completado'
      setTimeout(() => {
        document.body.removeChild(progressContainer)
        //window.parent.location.href = `../src/libreta.php?target=${document.location.search.split('target=')[1]}`
      }, 500)
    } else {
      document.getElementById('progressText').textContent = 'Error en la subida'
      setTimeout(() => {
        document.body.removeChild(progressContainer)
      }, 2000)
    }
  })
  
  // Evento de error
  xhr.addEventListener('error', () => {
    document.getElementById('progressText').textContent = 'Error de conexión'
    setTimeout(() => {
      document.body.removeChild(progressContainer)
    }, 2000)
  })
  
  // Configurar y enviar la petición
  xhr.open('POST', src, true)
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  xhr.send('id='+id+'&hash='+hash+'&marca='+marca+'&modelo='+modelo+'&descripcion='+descripcion+'&referencia='+referencia+'&file='+file.name)
})

document.getElementById('dropContainer').ondragover = function(evt) {
    evt.preventDefault();
}
  
document.getElementById('dropContainer').ondragleave = function() {
  document.getElementById('dropContainer').classList.remove('leave');
}
  
document.getElementById('dropContainer').ondragenter = function(){
  document.getElementById('dropContainer').classList.add('leave');
}
  
document.getElementById('dropContainer').ondrop = function(evt) {
  document.getElementById('dropContainer').classList.remove('leave');
  document.getElementById('dropContainer').classList.add('drop');
  // pretty simple -- but not for IE :(
    docFile.files = evt.dataTransfer.files

  // If you want to use some of the dropped files
  const dT = new DataTransfer()
  dT.items.add(evt.dataTransfer.files[0])
  //dT.items.add(evt.dataTransfer.files[3])
  docFile.files = dT.files
  
  // Crear vista previa del archivo arrastrado
  const file = evt.dataTransfer.files[0]
  if (file && file.type.startsWith('image/')) {
    const imageUrl = URL.createObjectURL(file)
    document.getElementById('dropContainer').innerHTML = `<img src="${imageUrl}" alt="${file.name}" style="max-width: 100%; max-height: 200px; object-fit: contain;" />`
  } else if (file) {
    // Si no es imagen, mostrar el nombre del archivo
    document.getElementById('dropContainer').innerHTML = `<div style="padding: 20px; text-align: center;"><strong>${file.name}</strong></div>`
  }

  evt.preventDefault()
}