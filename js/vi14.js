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

$$('form')[0].addEventListener('submit',(e) =>{
  e.preventDefault()
  const data = new FormData() 
  data.append('file',$('csvFile').files[0])
  if($('csvFile').files[0] != undefined){
    result.innerHTML = '<span class="spinner">'
    fetch('../api/uploadCsvFile.php',{
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(items =>{
      if(items.length > 1){
        sortJSON(items,'referencia','asc')
        result.innerHTML = `<h2>${placas[items[0].placa]}</h2>`;
        items.map(item =>{
          if(item.aviso != 'Aviso'){
            result.innerHTML += `
            <ul>
              <li>${item.fecha}</li>
              <li>${item.cuenta}</li>
              <li>${item.nombre}</li>
              <li>${item.npedido}</li>
              <li class="copy" title="copiar">
                <input type="text" value="${item.referencia}"></input>${item.referencia}
              <li>${item.designacion}</li>
              <li>${item.cantidad}</li>
            </ul>`
          }
        })
      }else{
        result.innerHTML = `<h2>${placas[items[0].placa]}</h2>`;
        result.innerHTML += `<h3>No hay nuevos inmovilizados</h3>`
      }
    })

    fetch('../api/uploadCsvFileCopy.php',{
      method: 'POST',
      body: data
    })
    .then(olditm => olditm.json())
    .then(oitm => {
      sortJSON(oitm,'referencia','asc')
      complete.innerHTML = `<h2>${placas[oitm[0].placa]} ${oitm.length-1} referencias </h2>`
      oitm.map(reg=>{
        if(reg.aviso != 'Aviso'){
          complete.innerHTML += `
          <ul>
            <li>${reg.fecha}</li>
            <li>${reg.cuenta}</li>
            <li>${reg.nombre}</li>
            <li>${reg.npedido}</li>
            <li>${reg.referencia}</li>
            <li>${reg.designacion}</li>
            <li>${reg.cantidad}</li>
          </ul>`
        }
      })
    })
  }
})

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
  console.log(evt.dataTransfer.files[0])
  $('dropContainer').innerText = evt.dataTransfer.files[0].name

  evt.preventDefault()
}

for(let index = 1;index < $$('button').length;index++){
  $$('button')[index].addEventListener('click',(e)=>{
    fetch(`../json/${nplacas[e.target.innerText.split(' - ')[0]]}.json`)
    .then(olditm => olditm.json())
    .then(oitm => {
      sortJSON(oitm,'npedido','asc')
      sortJSON(oitm,'referencia','asc')
      complete.innerHTML = `<h2>${e.target.innerText}</h2>`
      oitm.map(reg=>{
        if(reg.aviso != 'Aviso'){
          complete.innerHTML += `
          <ul>
            <li>${reg.fecha}</li>
            <li>${reg.cuenta}</li>
            <li>${reg.nombre}</li>
            <li>${reg.npedido}</li>
            <li>${reg.referencia}</li>
            <li>${reg.designacion}</li>
            <li>${reg.cantidad}</li>
          </ul>`
        }
      })
    })
    result.innerHTML=``
    fetch(e.target.id)
    .then(res => res.json())
    .then(item =>{
      sortJSON(item,'npedido','asc')
      sortJSON(item,'referencia','asc')
      result.innerHTML = `<h2>${e.target.innerText}</h2>`
      item.map(it =>{
        if(it.aviso != 'Aviso'){
          result.innerHTML += `
          <ul>
            <li>${it.fecha}</li>
            <li>${it.cuenta}</li>
            <li>${it.nombre}</li>
            <li>${it.npedido}</li>
            <li class="copy" title="copiar">
              <input type="text" value="${it.referencia}"></input>${it.referencia}
            <li>${it.designacion}</li>
            <li>${it.cantidad}</li>
          </ul>`
        }
      })
    })
  })
}

$('result').addEventListener('click', (e) => {
  if(e.target.children.length > 0){
    if(e.target.title =='copiar' || e.target.children[0].value != undefined){
      e.target.style = "color:red;font-weight: 700;"
      navigator.clipboard.writeText(e.target.children[0].value)
      notify('¡¡Copiado!!')
    }
    fetch(`../json/${nplacas[result.childNodes[0].innerText.split(' - ')[0]]}.json`)
    .then((e) => e.json())
    .then((response) =>{
      sortJSON(response,'npedido','asc')
      sortJSON(response,'referencia','asc')
      let tabla = ""
      let cont = 0
      response.map(ma =>{
        if(ma.referencia == e.target.children[0].value){
          cont++
          tabla += `
          <ul>
            <li>${ma.fecha}</li>
            <li>${ma.cuenta}</li>
            <li>${ma.nombre}</li>
            <li>${ma.npedido}</li>
            <li class="copy" title="copiar">
              <input type="text" value="${ma.referencia}"></input>${ma.referencia}
            <li>${ma.designacion}</li>
            <li>${ma.cantidad}</li>
          </ul>`
        }
      })
      let refere = ''
      cont > 1 ? refere = `referencias` : refere = `referencia`
      complete.innerHTML = `<h2>${placas[response[1].placa]} - ${e.target.children[0].value}:  (${cont}) ${refere}</h2>`
      complete.innerHTML += tabla
    }) 
  }
})

function sortJSON(data, key, orden) {
  return data.sort(function (a, b) {
      var x = a[key],
      y = b[key];

      if (orden === 'asc') {
          return ((x < y) ? -1 : ((x > y) ? 1 : 0));
      }

      if (orden === 'desc') {
          return ((x > y) ? -1 : ((x < y) ? 1 : 0));
      }
  });
}

$('slide-button').addEventListener('click',(e) =>{
  e.target.parentNode.classList.toggle('completa')
  e.target.parentNode.classList.toggle('nocompleta')
})