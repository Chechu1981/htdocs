const placas = {
  "027130L":"PPCR BALEARES",
  "027135M":"PPCR BARCELONA",
  "027120K":"PPCR GRANADA",
  "027015L":"PPCR MADRID",
  "027066M":"PPCR PATERNA",
  "027110G":"PPCR SEVILLA",
  "027115E":"PPCR VIGO",
  "027125R":"PPCR ZARAGOZA"
}

const nplacas = {
  "PPCR BALEARES" :"027130L",
  "PPCR BARCELONA": "027135M",
  "PPCR GRANADA":"027120K",
  "PPCR MADRID":"027015L",
  "PPCR PATERNA":"027066M",
  "PPCR SEVILLA":"027110G",
  "PPCR VIGO":"027115E",
  "PPCR ZARAGOZA":"027125R"
}

/* Volcado al arrastar el fichero */

$$('form')[0].addEventListener('submit',(e) =>{
  e.target[1].disabled = true
  e.preventDefault()
  const data = new FormData() 
  data.append('file',$('csvFile').files[0])
  if($('csvFile').files[0] != undefined){
    resultRef.innerHTML = '<span class="spinner">'
    fetch('../api/uploadRefCsvFileCopy.php',{
      method: 'POST',
      body: data
    })
    .then(response => response.text())
    .then(items =>{
      resultRef.innerHTML = items
      const itemPlaca = new FormData()
      itemPlaca.append('placa',items.split('-')[0].split('<h2>')[1])
      resultRef.addEventListener('click', f => copyAndCheck(f))
      e.target[1].disabled = false
      fetch('../api/getCsvRefFile.php',{
        method: 'POST',
        body: itemPlaca
      })
      .then(olditm => olditm.text())
      .then(oitm => {
        completeRef.innerHTML = oitm
      })
    })
  }
})


/* Arrastrar el fichero */
dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
  evt.preventDefault();
}

dropContainer.ondragleave = function() {
  dropContainer.classList.remove('leave');
}

dropContainer.ondragenter = function(){
  dropContainer.classList.add('leave');
}

dropContainer.ondrop = function(evt) {
  dropContainer.classList.remove('leave');
  dropContainer.classList.add('drop');
  // pretty simple -- but not for IE :(
    csvFile.files = evt.dataTransfer.files

  // If you want to use some of the dropped files
  const dT = new DataTransfer()
  dT.items.add(evt.dataTransfer.files[0])
  //dT.items.add(evt.dataTransfer.files[3])
  csvFile.files = dT.files
  $('dropContainer').innerText = evt.dataTransfer.files[0].name

  evt.preventDefault()
}

/* Copiar y chek en BBDD */
const copyAndCheck = (e) =>{
  const marca = e.target.parentNode.childNodes[9] ?? ''
  const refFiat = marca.title == "3136"
  let refer = null
  e.target.classList.value.includes('copy') ? refer = e.target.childNodes[1].data.replaceAll(' ','') : ''
  if(e.target.classList.value.includes('copy')){
    e.target.classList.add('check')
    for(let i = 0; i < resultRef.getElementsByTagName('ul').length; i++){
      if(resultRef.getElementsByTagName('ul')[i].childNodes[9].childNodes[1].data.replaceAll(' ','') == refer)
        resultRef.getElementsByTagName('ul')[i].style = "color:yellow; font-weight: auto;"
      else
        resultRef.getElementsByTagName('ul')[i].style = ""
    }
    e.target.parentNode.style = "color: #2de376;"
    const idData = new FormData()
    idData.append('id', e.target.id)
    idData.append('referencia', refer)
    idData.append('placa', resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[0])
    
    // Copio al portapepeles
    if(refFiat){
      let ceros = ""
      for(let i = 0; i < 13 - refer.length; i++)
        ceros += '0'
      refer = `${ceros}${refer}`
    }
    navigator.clipboard.writeText(refer)
    notify(`Copiado: ${refer}`)

    // Actualizo el check en la BBDD       
    fetch('../api/updateCsvShortRefFile.php',{
      method: 'POST',
      body: idData
    })
    
    //Cargo las referencias en completeRef
    fetch('../api/getCsvRefFile.php',{
      method: 'POST',
      body: idData
    })
    .then(response => response.text())
    .then(res =>{
      completeRef.innerHTML = res
      const placa = resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[0]
      const fecha = resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[1]
      const lineas = completeRef.getElementsByTagName('h2')[0].innerText.split(' - ')[2]
      resultRef.getElementsByTagName('h2')[0].innerHTML = `${placa} - ${fecha} - ${lineas}`
    })
  }
}

/* Escucha el div completeRef */
$('completeRef').addEventListener('click', e =>{
  /* Carga las referencias filtradas */
  if(e.target.id == 'showFilterAll'){
    const refer = e.target.parentNode.childNodes[1].data.replaceAll(' ','')
    const idData = new FormData()
    idData.append('id', e.target.parentNode.id)
    idData.append('referencia', refer)
    idData.append('placa', resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[0])

    fetch('../api/getCsvRefFile.php',{
      method: 'POST',
      body: idData
    })
    .then(response => response.text())
    .then(res =>{
      completeRef.innerHTML = res
      const placa = resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[0]
      const fecha = resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[1]
      const lineas = completeRef.getElementsByTagName('h2')[0].innerText.split(' - ')[2]
      resultRef.getElementsByTagName('h2')[0].innerHTML = `${placa} - ${fecha} - ${lineas}`
      $('slide-button-all').classList.toggle('arrow-slider-active')
      $('slide-button-short').classList.toggle('arrow-slider-active')
    })
  }

  if(e.target.className == 'alertReemp' && e.target.id != 'showFilterAll'){
    if(e.target.id == 'all')
      console.log('Lo que sea')
    else
      customAlert(`${e.target.parentNode.childNodes[1].data.replaceAll(' ','')} ➡ ${e.target.id}`)
  }

  /* Marca las referencias iguales */
  if(e.target.className == 'copy '){
      const mismaRef = $('completeRef').getElementsByClassName('copy')
      for(let i = 0; i < mismaRef.length; i++)
        mismaRef[i].style.color = "inherit"
      for(let i = 0; i < mismaRef.length; i++){
        if(e.target.childNodes[1].data.replaceAll(' ','') == mismaRef[i].childNodes[1].data.replaceAll(' ',''))
          mismaRef[i].style.color = "yellow"
      }
  }
})

/* Volcado al dar al botón de histórico */
const eventoClick = e =>{
  if(e.target.innerText.split(' - ')[0] == 'Calcular')
    return
  resultRef.innerHTML = '<span class="spinner">'
  const data = new FormData()
  data.append('placa',e.target.innerText.split(' - ')[0])
  resultRef.removeEventListener('click',copyAndCheck)
  fetch('../api/getCsvRefFile.php',{
    method: 'POST',
    body: data
  })
  .then(olditm => olditm.text())
  .then(oitm => {
    completeRef.innerHTML = oitm
  })
  fetch('../api/getCsvRefFilterFile.php',{
    method: 'POST',
    body: data
  })
  .then(shortsItems => shortsItems.text())
  .then(short => {
    resultRef.innerHTML = short
    resultRef.addEventListener('click', e => copyAndCheck(e))
  })
}

for(let index = 1;index < $$('button').length;index++){
  $$('button')[index].addEventListener('click',e => eventoClick(e))
}

const sliderActive = (e) =>{
    let slide = e.target
    e.target.localName == 'img' ? slide = e.target.parentNode : slide = e.target
    const activoFiltro = slide.parentNode.parentNode.childNodes[3].childNodes[1].classList.value.includes('active')
    const activoTodo = slide.parentNode.parentNode.childNodes[3].childNodes[3].classList.value.includes('active')
    if((activoFiltro || activoTodo) && ! slide.classList.value.includes('active')){
      slide.parentNode.parentNode.childNodes[3].childNodes[1].classList.toggle('arrow-slider-active')
      slide.parentNode.parentNode.childNodes[3].childNodes[3].classList.toggle('arrow-slider-active')
    }else{
      slide.classList.toggle('arrow-slider-active')
      slide.parentNode.parentNode.classList.toggle('completa')
      slide.parentNode.parentNode.classList.toggle('nocompleta')
      if($('completeRef').classList != 'hidden'){
        setTimeout(function(){
          $('completeRef').classList.toggle('hidden')
        },250)
      }else{
        $('completeRef').classList.toggle('hidden')
      }
    }
}

/* Muestra los listados al dar al boton correspondiente */
$('slide-button-short').addEventListener('click',e => {
  sliderActive(e)
  const itemPlaca = new FormData()
  itemPlaca.append('placa',resultRef.innerHTML.split('-')[0].split('<h2>')[1])
  resultRef.addEventListener('click', f => copyAndCheck(f))
  fetch('../api/getCsvRefFile.php',{
    method: 'POST',
    body: itemPlaca
  })
  .then(olditm => olditm.text())
  .then(oitm => {
    completeRef.innerHTML = oitm
  })
}) 
$('slide-button-all').addEventListener('click',e => {
  sliderActive(e)
  const itemPlaca = new FormData()
  itemPlaca.append('placa',resultRef.innerHTML.split('-')[0].split('<h2>')[1])
  resultRef.addEventListener('click', f => copyAndCheck(f))
  fetch('../api/getCsvRefShortFile.php',{
    method: 'POST',
    body: itemPlaca
  })
  .then(olditm => olditm.text())
  .then(oitm => {
    completeRef.innerHTML = oitm
    $('showFilterAll').addEventListener('click', e =>{
      ref = e.taget.parentNode
    })
  })
})

resultRef.addEventListener('click', (e)=>{
  if(e.target.id != '' && e.target.innerText == "⚠")
    customAlert(`${e.target.parentNode.childNodes[1].data.replaceAll(' ','')} ➡ ${e.target.id}`)
  if(e.target.id != '' && e.target.innerText == "🔻"){
    const refer = e.target.parentNode.childNodes[1].data.replaceAll(' ','')
    const idData = new FormData()
    idData.append('id', e.target.parentNode.id)
    idData.append('referencia', refer)
    idData.append('placa', resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[0])

    fetch('../api/getCsvRefFile.php',{
      method: 'POST',
      body: idData
    })
    .then(response => response.text())
    .then(res =>{
      completeRef.innerHTML = res
      const placa = resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[0]
      const fecha = resultRef.getElementsByTagName('h2')[0].innerText.split(' - ')[1]
      const lineas = completeRef.getElementsByTagName('h2')[0].innerText.split(' - ')[2]
      resultRef.getElementsByTagName('h2')[0].innerHTML = `${placa} - ${fecha} - ${lineas}`
      $('slide-button-all').classList.toggle('arrow-slider-active')
      completeRef.parentNode.classList.toggle('completa')
      completeRef.parentNode.classList.toggle('nocompleta')
      $('completeRef').classList.toggle('hidden')
    })
  }
})

$('placas').addEventListener('click', e =>{
  if(e.target.alt == "🔽"){
    const btnInmov = document.getElementsByClassName('btn-inmov')
    if(e.target.parentNode.childNodes[5].classList == "carrusel-off"){
      for(let i=0;i < btnInmov.length;i++){
        btnInmov[i].childNodes[5].innerHTML = ""
        btnInmov[i].childNodes[5].classList.remove('carrusel')
        btnInmov[i].childNodes[5].classList.add("carrusel-off")
        btnInmov[i].childNodes[3].classList.remove('btn-inmov')
        btnInmov[i].childNodes[3].classList.add("btn-inmov-normal")
      }
    }
    e.target.parentNode.childNodes[5].classList.toggle('carrusel')
    e.target.parentNode.childNodes[5].classList.toggle("carrusel-off")
    e.target.classList.toggle("btn-inmov-inverter")
    e.target.classList.toggle("btn-inmov-normal")
  }
  if(e.target.childNodes[0].textContent != 'Calcular'){
    if(e.target.parentNode.childNodes[5].classList != "carrusel"){
      setTimeout(() =>{
        e.target.parentNode.childNodes[5].innerHTML = ""
      },100)
    }
    if(e.target.parentNode.childNodes[5].classList == "carrusel"){
      fetch('../api/getHistoryVi.php')
      .then(item => item.text())
      .then(result => {
        e.target.parentNode.childNodes[5].innerHTML = result
      })
    }
  }
})

$('filtrado').addEventListener('click',() =>{
  fetch('../api/getFiltradoForm.php')
  .then(items => items.text())
  .then(form =>{
    modal(form, "Frases claves de filtrado")
    const script = document.createElement("script")
    script.src = "../js/refForm.js"
    document.head.appendChild(script)
  })
})

completeRef.addEventListener('click',e =>{
  e.target.className.includes("copy") ? copiarTexto(e.target.childNodes[1].data.replaceAll(' ','')) : ''
})

const copiarTexto = (texto) =>{
  navigator.clipboard.writeText(texto)
  notify(`Copiado: ${texto}`)
}