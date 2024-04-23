'use strict';
$$('input')[1].focus()

//Show Contacts
$$('input')[1].addEventListener('keyup', (e) => {
  e.target.value == '' ? window.location = window.location : loadItems(e.target.value)
});

//Focus on the input when load page
for(let input = 0;input < $$('input').length; input++) {
  $$('input')[input].addEventListener('focus', (e) => {
    e.target.select();
  })
}

const createScript = () => {
  const newScript = document.createElement('script')
  newScript.type = 'text/javascript'
  newScript.src = './../js/formNotebook1.js'
  $('contacts').append(newScript)
}

const loadItems = (search) => {
  $('contacts-items').innerHTML = ''
  let data = new FormData()
  data.append('search', search)
  fetch('../api/getNotebook.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(datos =>{
      $('contacts-items').innerHTML = datos
      $('contacts-items').addEventListener('click',(e) => {
        e.stopImmediatePropagation()
        if(e.target.classList == "copy"){
          window.navigator.clipboard.writeText(e.target.title)
          notify(`${e.target.title} copiado!!`)
        }
        const id = e.target.parentNode.id
        const data = new FormData()
        data.append('id',id)
        if(e.target.id.includes('delete')){
          if(confirm('¿Quieres eliminar este registro?') == true){
            let data = new FormData();
            data.append('id', id)
            fetch('./../api/deleteNotebook.php',{
              method: 'POST',
              body: data})
            .then(response => response.text())
            .then(response => {
              e.target.parentNode.parentNode.parentNode.style.display = 'none'
              notify(response)
            })
            .catch(functions => console.log("error: "+functions))
          }
        }
        if(e.target.id.includes('edit')){
          const id= e.target.parentNode.id
          const data = new FormData()
          data.append('id',id)
          const iframe = document.createElement('iframe')
          iframe.src = '../../helper/modalNotebook.php?id='+id
          modal('<iframe src="../../helper/modalNotebook.php?id='+id+'" class="libreta"></iframe>',"Editar nota")
        }
        if(e.target.classList.value === 'openFile' || e.target.parentNode.classList.value === 'openFile'){
          let target
          e.target.classList.value === 'openFile' ? target = e.target : target = e.target.parentNode
          const ext = target.title.split('.')[target.title.split('.').length - 1]
          const divImg = document.createElement('div')
          divImg.style.backgroundColor = "var(--bg-body-color)"
          divImg.classList.add('popUpImg')
          divImg.id = 'popUpImg'
          const imgClose = document.createElement('img')
          imgClose.classList.add('note-btn')
          imgClose.id = "close"
          imgClose.src = "../img/close_FILL0_wght400_GRAD0_opsz24.png"
          imgClose.addEventListener('click', () => {
            divImg.classList.remove('popUpImg')
            divImg.classList.add('popUpImgOff')
            setTimeout(function() {
              divImg.parentNode.removeChild(divImg)
            },290)
            $('menu').classList.remove('filter')
            document.getElementsByClassName('search-table')[0].classList.remove('filter')
          })
          if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'webp'){
            divImg.style.backgroundImage = `url(../../docs/${target.title})`
            divImg.style.width = '42%'
            divImg.style.height = '80%'
            $('menu').classList.add('filter')
            document.getElementsByClassName('search-table')[0].classList.add('filter')
            divImg.appendChild(imgClose)
            document.body.appendChild(divImg)
          }else if(ext === 'pdf'){
            const object = document.createElement('object')
            const height = window.innerHeight - 100
            const width = window.innerWidth - 100
            object.type = "application/pdf"
            object.height = `${height}px`
            object.width = `${width}px`
            divImg.style.width = `${width}px`
            divImg.style.top = `calc(50vh - ${height / 2}px)`
            divImg.style.left = `calc(50% - ${width / 2}px)`
            object.data = `../../docs/${target.title}`
            divImg.appendChild(imgClose)
            divImg.appendChild(object)
            $('menu').classList.add('filter')
            document.getElementsByClassName('search-table')[0].classList.add('filter')
            document.body.appendChild(divImg)
          }else{
            window.open(`../../docs/${target.title}`)
          }
        }
      })
        /* ARREGLAR ESTE PROBLEMA */
      $('addNotebook').addEventListener('click', (e)=>{
        const id= 'new'
        modal('<iframe src="../../helper/modalNotebook.php?id='+id+'" class="libreta"></iframe>',"Editar nota")
        /*
        let newForm = `<form action="" class="form-new" title="new" id="frmNewNotebook">`
        newForm += "<label></label><select type='text' placeholder='marca' id='marca'>"
        newForm += "<option value='MULTIMARCA'>Multimarca</option>"
        newForm += "<option value='CITROEN'>Citroen</option>"
        newForm += "<option value='PEUGEOT'>Peugeot</option>"
        newForm += "<option value='OPEL'>Opel</option>"
        newForm += "<option value='FIAT/JEEP'>Fiat / Jeep</option>"
        newForm += "<option value='EUROREPAR'>Eurorepar</option>"
        newForm += "<option value='DOCUMENTOS'>Documentos</option>"
        newForm += "<option value='POWER'>Power Supply</option>"
        newForm += "</select>"
        newForm += "<label></label><input type='text' placeholder='modelo' id='modelo'>"
        newForm += "<label></label><input type='text' placeholder='descripcion' id='descripcion'>"
        newForm += "<label></label><input type='text' placeholder='referencia' id='referencia'>"
        newForm += "<input type='file' id='docFile' style='display:none'>"
        newForm += "<input type='submit' class='note-btn' style='position: absolute;' value='añadir'>"
        newForm += "<div id='dropContainer'>Arrastra aqui algún fichero</div>"
        newForm += "</form>"
        modal(newForm,`Nueva nota`)
        const scrpt = Array.prototype.slice.call(document.scripts)
        scrpt.forEach(e => {
          e.src.split('/')[4] == 'formNotebook1.js' ? null : createScript()
        }) */
      })
  })
  .catch(err => console.log("error: "+err))
}

const openFile = (file) => {
  modal(file,"Fichero")
}

const success = {
  update:"../api/updateNotebook.php",
  delete:"../api/deleteNotebook.php",
  new:"../api/addNotebook.php"
}

$('center-items-pass').addEventListener('click',e =>{
  if(e.target.title == "ACEITE")
    location.href = `./aceite.php${location.search}`
  else if(e.target.title == "BATERIAS")
    location.href = `./baterias.php${location.search}`
  else
    loadItems(e.target.title)
})