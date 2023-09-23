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

const prioridadIcar = {
  "1" : "2",
  "2" : "3",
  "3" : "4",
  "4" : "6",
  "5" : "7",
  "" : "8"
}

/* Volcado al arrastar el fichero */

$$('form')[0].addEventListener('submit',(e) =>{
  e.target[1].disabled = true
  e.preventDefault()
  const data = new FormData() 
  data.append('file',$('csvFile').files[0])
  if($('csvFile').files[0] != undefined){
    result.innerHTML = '<span class="spinner">'
    fetch('../api/uploadCsvFileCopy.php',{
      method: 'POST',
      body: data
    })
    .then(response => response.text())
    .then(items =>{
      result.innerHTML = items
      const itemPlaca = new FormData()
      itemPlaca.append('placa',items.split('-')[0].split('<h2>')[1])
      result.addEventListener('click', f => copyAndCheck(f))
      e.target[1].disabled = false
      fetch('../api/getCsvOldFile.php',{
        method: 'POST',
        body: itemPlaca
      })
      .then(response => response.text())
      .then(items1 =>{
        complete.innerHTML = items1
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
  const refFiat = e.target.parentNode.childNodes[9].title == "3136"
  let refer = e.target.title
  if(e.target.classList.value.includes('copy')){
    e.target.classList.add('check')
    for(let i = 0; i < result.getElementsByTagName('ul').length; i++){
      if(result.getElementsByTagName('ul')[i].childNodes[11].title == refer)
        result.getElementsByTagName('ul')[i].style = "color:yellow; font-weight: auto;"
      else
        result.getElementsByTagName('ul')[i].style = ""
    }
    e.target.parentNode.style = "color: #2de376; font-weight: 800;"
    const idData = new FormData()
    idData.append('id', e.target.id)
    idData.append('referencia', refer)
    idData.append('placa', result.getElementsByTagName('h2')[0].innerText.split(' - ')[0])
    
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
    fetch('../api/updateCsvShortFile.php',{
      method: 'POST',
      body: idData
    })
    
    //Cargo las referencias en Complete
    fetch('../api/getCsvOldFile.php',{
      method: 'POST',
      body: idData
    })
    .then(response => response.text())
    .then(res =>{
      complete.innerHTML = res
      const placa = result.getElementsByTagName('h2')[0].innerText.split(' - ')[0]
      const fecha = result.getElementsByTagName('h2')[0].innerText.split(' - ')[1]
      const lineas = complete.getElementsByTagName('h2')[0].innerText.split(' - ')[2]
      result.getElementsByTagName('h2')[0].innerHTML = `${placa} - ${fecha} - ${lineas}`
    })
  }
}

/* Volcado al dar al botón de histórico */
const eventoClick = e =>{
  result.innerHTML = '<span class="spinner">'
  const data = new FormData()
  data.append('placa',e.target.innerText.split(' - ')[0])
  result.removeEventListener('click',copyAndCheck)
  fetch('../api/getCsvOldFile.php',{
    method: 'POST',
    body: data
  })
  .then(olditm => olditm.text())
  .then(oitm => {
    complete.innerHTML = oitm
  })
  fetch('../api/getCsvShortFile.php',{
    method: 'POST',
    body: data
  })
  .then(shortsItems => shortsItems.text())
  .then(short => {
    result.innerHTML = short
    result.addEventListener('click', e => copyAndCheck(e))
  })
}

for(let index = 1;index < $$('button').length;index++){
  $$('button')[index].addEventListener('click',e => eventoClick(e))
}

$('slide-button').addEventListener('click',(e) =>{
  $('slide-button').parentNode.classList.toggle('completa')
  $('slide-button').parentNode.classList.toggle('nocompleta')
  $('slide-button').classList.toggle('arrow-slider-inverter')
  if($('complete').classList != 'hidden'){
    setTimeout(function(){
      $('complete').classList.toggle('hidden')
    },250)
  }else{
    $('complete').classList.toggle('hidden')
  }
})

result.addEventListener('click', (e)=>{
  if(e.target.id != '' && e.target.localName == "span")
    customAlert(`${e.target.parentNode.title} ➡ ${e.target.id}`)
})

complete.addEventListener('click', (e)=>{
  if(e.target.id != '' && e.target.id != 'complete'){
    let ref = e.target.parentNode.firstChild.data.replaceAll(' ','') + " ➡ " + e.target.id
    if(e.target.id == 'all'){
      ref = ""
      const element = complete.getElementsByTagName('span')
      for(let i=1; i<element.length; i++)
        ref += `${element[i].parentNode.firstChild.data.replaceAll(' ','')} ➡ ${element[i].id} `
    }
    customAlert(ref)
  }
  if(e.target.tagName == "A"){
    const ref = e.target.parentNode.parentNode.childNodes[11].innerText
    const client = e.target.parentNode.parentNode.childNodes[7].innerText
    const id = e.target.parentNode.parentNode.childNodes[1].id
    const priority = e.target.parentNode.parentNode.childNodes[17]
    const title = e.target.parentNode.parentNode.childNodes[9].getElementsByTagName('a')[0].title
    const lineItem = e.target.parentNode.parentNode
    let formModal = `
      <div><h2>${ref} - ${client}</h2></div>
      <form id="updateInmov" action="#">
        <label for="name">Nombre</label>
        <input type="text" id="name" value="${title.replace('Amuentar la prioridad','')}"></input>
        <label for="num">Número</label>
        <select type="number" id="num">`
    for (var i = 1;i<10;i++){
      if(i == priority.innerText)
        formModal += `<option value="${i}" selected >${i}</option>`
      else
        formModal += `<option value="${i}">${i}</option>`
    }
    formModal +=`</select>
        <input type="submit" value="Guardar"></input>
      </form>
    `
    modal(formModal,'Prioridad')
    document.getElementById('name').focus()

    $('updateInmov').addEventListener('submit',e =>{
      e.preventDefault()
      e.stopImmediatePropagation()
      const nameAut = document.getElementById('name').value
      const idpriority = document.getElementById('num').value
      if(nameAut == ''){
        customAlert('El campo nombre no puede estar vacío')
        return
      }
      priority.innerHTML = num.value
      title.innerText = `${nameAut}`
      lineItem.style.color = '#0d0d72'
      lineItem.style.backgroundColor = '#cd0a0a'
      const data = new FormData()
      data.append('id',id)
      data.append('priority',idpriority)
      data.append('name',nameAut)
      fetch('../api/updatePriorityInmov.php',{
        method: 'POST',
        body:data          
      })
      .then((fet) => fet.text)
      .then((data) => {
        $('notes').parentNode.parentNode.parentNode.children[1].classList.toggle('filter')
        $('notes').parentNode.parentNode.parentNode.children[0].classList.toggle('filter')
        document.getElementsByClassName('note-active')[0].remove()
      })
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