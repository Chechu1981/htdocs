'use strict';
$$('input')[1].focus()

//Show Contacts
$$('input')[1].addEventListener('keyup', (e) => {
  loadItems(e.target.value)
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
  newScript.src = './../js/formNotebook1.js?251006'
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
          const target = $('search-contacts').value
          iframe.src = '../../helper/modalNotebook.php?id='+id
          modal('<iframe src="../../helper/modalNotebook.php?id='+id+'&target='+target+'" class="libreta"></iframe>','Editar nota')
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
            toggleFilter()
            document.getElementsByClassName('search-table')[0].classList.remove('filter')
          })
          if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'webp'){
            divImg.style.backgroundImage = `url(../../docs/${target.title})`
            divImg.style.width = '42%'
            divImg.style.height = '80%'
            toggleFilter()
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
            toggleFilter()
            document.body.appendChild(divImg)
          }else{
            window.open(`../../docs/${target.title}`)
          }
        }
      })
  })
  .catch(err => console.log("error: "+err))
}

$('addNotebook').addEventListener('click', (e)=>{
  const id = 'new'
  modal('<iframe src="../../helper/modalNotebook.php?id='+id+'" class="libreta"></iframe>',"Nueva nota")
})

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

document.addEventListener('DOMContentLoaded', () => {
 if (document.location.search.split('target=')[1] != undefined) {
   loadItems(document.location.search.split('target=')[1])
   $('search-contacts').value = document.location.search.split('target=')[1]
 } 
})