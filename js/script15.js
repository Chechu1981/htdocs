const $ = (id) => document.getElementById(id)
const $$ = (tagName) => document.getElementsByTagName(tagName)

const ruta = {
  1 : './',
  2 : './',
  3 : '../',
  4 : '../../',
  5 : '../../'
}

$$('input')[0].addEventListener('keyup', (e) => {
  $('repere').value != '' ? $('referencia').classList.add('is_repere') : $('referencia').classList.remove('is_repere')
  $('referencia').classList.add('spinner');
  let src = ''
  src = ruta[window.location.pathname.split('/').length] + 'api/getRepere.php'
  let data = new FormData();
  data.append('search', e.target.value)
  fetch(src,{
    method: 'POST',
    body: data})
  .then(response => response.text())
  .then(response => {
    $('referencia').classList.remove('spinner');
    $('referencia').innerHTML = response
  })
  .catch(functions => console.log("error: "+functions))
})

const modal = (params,title) =>{
  $('notes').parentNode.parentNode.parentNode.children[1].classList.toggle('filter')
  $('notes').parentNode.parentNode.parentNode.children[0].classList.toggle('filter')
  let box = document.createElement('div')
  box.className = 'note-active'
  let contentBox = document.createElement('div')
  contentBox.className = 'note-body'
  box.innerHTML = `<img class='note-btn' id='close' src='${ruta[window.location.pathname.split('/').length]}img/close_FILL0_wght400_GRAD0_opsz24.png'></img>`
  contentBox.innerHTML = `<h2>${title}</h2>`
  contentBox.innerHTML += params
  box.append(contentBox)
  document.body.append(box)
  $('close').addEventListener('click',(e)=>{
    e.target.parentNode.classList.remove('note-active')
    e.target.parentNode.classList.add('note-desactive')
    for(let i = 0; i < document.getElementsByTagName('script').length; i++){
      let item = document.getElementsByTagName('script')[i].src.split('/')[4]
      if(item == 'formNotebook.js' || item == 'form.js'){
        document.getElementsByTagName('script')[i].remove()
        window.location.reload()
      }
    }
    $('notes').parentNode.parentNode.parentNode.children[1].classList.toggle('filter')
    $('notes').parentNode.parentNode.parentNode.children[0].classList.toggle('filter')
    setTimeout(()=>box.remove(),350)
  })
}

$('notes').addEventListener('click',(e) => {
  src = ruta[window.location.pathname.split('/').length] + 'api/getNotes.php'
  fetch(src)
  .then((response) => response.text())
  .then((notes) => {
    modal(notes,'Notas')
  })
})

document.addEventListener('click',(e)=>{
  if(e.target.parentNode.title.includes('recibida')){
    if(confirm("Se ha recibido esta cesion?") == true){
      const data = new FormData()
      data.append('id',e.target.id)
      fetch('../api/updateAssig.php',{
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(() => showAssig())
    }
  }
  if(e.target.id == 'saveNotes'){
    const txt = $('txtNotes').value;
    const data = new FormData()
    data.append('txt',txt)
    let src = ruta[window.location.pathname.split('/').length] + 'api/updateNotes.php'
    fetch(src,{
      method: 'POST',
      body: data
    })
    e.target.parentNode.parentNode.parentNode.children[0].classList.remove('filter')
    e.target.parentNode.parentNode.parentNode.children[1].classList.remove('filter')
    e.target.parentNode.parentNode.remove()
    window.location.reload()
  }
})

let rnd = Math.floor(Math.random() * (100000 - 9000) + 9000)

setInterval(() => {
  $('menu').children[0].classList.toggle('rotation')
  $('menu').children[0].classList.toggle('hide')
},rnd)
  

$('menu').childNodes[9].addEventListener('click',() => {
  let src = ''
  src = ruta[window.location.pathname.split('/').length] + '../helper/modalConfig.php'
  fetch(src)
  .then(response => response.text())
  .then((res) => {
    modal(res,"Configuración")
    const newScript = document.createElement('script')
    newScript.type = 'text/javascript'
    newScript.src = '../../js/config11.js'
    $('contacts').append(newScript)
  })
})

menu.childNodes[11].addEventListener('click',() => {
  window.location.href = '../../../'
})

let titulo = (title) => document.getElementsByClassName('head-img')[0].childNodes[1].innerText = title.toUpperCase()
fetch(ruta[window.location.pathname.split('/').length] + 'json/sesiones.json')
.then(response => response.json())
.then(res => {
  const id = window.location.search.split('id=')[1]
  res.map(ids =>{
    if(ids.hash == id){
      titulo(ids.nombre)
      if(window.location.pathname.includes('home')){
        const options = $('search-line').childNodes[5].childNodes[1].childNodes
        for(let i=0; i<options.length; i++){
          let usuario = ids.nombre.toUpperCase()
          ids.nombre.toUpperCase() == 'GALICIA' ? usuario = 'VIGO' : null
          if(options[i].value == usuario){
            $('search-line').childNodes[5].childNodes[1].childNodes[i].selected = true
          }
        }
      }
    }
  })
})

const notify = (text) => {
  const notif = document.createElement('div')
  const texto = document.createTextNode(text)
  notif.classList.add('copy-container')
  notif.appendChild(texto)
  document.body.appendChild(notif)
  setTimeout(() => {
    notif.remove()
  }, 1800)
}