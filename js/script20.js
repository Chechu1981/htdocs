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
  let src = ruta[window.location.pathname.split('/').length] + 'api/getNotes.php'
  fetch(src)
  .then((response) => response.text())
  .then((notes) => {
    modal(notes,'Notas')
  })
})

$('calc').addEventListener('click',(e) => {
  let src = ruta[window.location.pathname.split('/').length] + 'api/calc.php'
  fetch(src)
  .then((response) => response.text())
  .then((notes) => {
    modal(notes,'Calculador')
    const script = document.createElement('script')
    script.src = `${ruta[window.location.pathname.split('/').length]}/js/calc.js`
    document.getElementsByClassName('note-active')[0].appendChild(script)
  })
})

document.addEventListener('click',(e)=>{
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
  

$('menu').childNodes[7].addEventListener('click',(e) => {
  if(e.target.title == "Configuración"){
    let src = ''
    src = ruta[window.location.pathname.split('/').length] + '../helper/modalConfig.php'
    fetch(src)
    .then(response => response.text())
    .then((res) => {
      modal(res,"Configuración")
      const newScript = document.createElement('script')
      newScript.type = 'text/javascript'
      newScript.src = '../../js/config11.js?1000'
      $('contacts').append(newScript)
    })
  }
})

menu.childNodes[9].addEventListener('click',() => {
  window.location.href = '../../../'
})

let titulo = (title) => document.getElementsByClassName('head-img')[0].childNodes[1].innerText = title.toUpperCase()
let user = ''


document.addEventListener('DOMContentLoaded', () => {
  const id = window.location.search.split('id=')[1]
  const data = new FormData()
  data.append('id', id)
  fetch(`${ruta[window.location.pathname.split('/').length]}/api/getUserById.php`,{
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(res => {
    user = res
    $('menu').childNodes[1].childNodes[1].innerText = res.nombre.toUpperCase()
    let puesto = res.puesto.toUpperCase()
    if(window.location.pathname.includes('home')){
      const options = $('search-line').childNodes[5].childNodes[1].childNodes
      for(let i=0; i<options.length; i++){
        puesto == 'GALICIA' ? puesto = 'VIGO' : null
        if(options[i].value == puesto){
          $('search-line').childNodes[5].childNodes[1].childNodes[i].selected = true
        }
      }
    }else if(window.location.pathname.includes('cesionesADV')){
      for(let i = 0; i < $$('form')[0][1].options.length; i++){
        let centro = puesto
        if(puesto == 'GALICIA')
          centro = 'VIGO'
      
        if($$('form')[0][1].options[i].value == centro)
          $$('form')[0][1].options[i].selected = true;
      }
    }else if(window.location.pathname.includes('cesionesAll')){
      for(let i = 0; i < $$('form')[0][1].options.length; i++){
        let centro = puesto
        if(puesto == 'GALICIA')
          centro = 'VIGO'
      
        if($$('form')[0][1].options[i].value == centro)
          $$('form')[0][1].options[i].selected = true;
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

class notifyStatic {
  constructor(text){
    this.notif = document.createElement('div')
    this.texto = document.createTextNode(text)
  }
  setTexto(text){
    document.getElementsByClassName('copy-container')[0].childNodes[1] = text
  }
  get showText(){
    this.notif.classList.add('copy-container')
    this.notif.appendChild(this.texto)
    document.body.appendChild(this.notif)
  }
  get eliminar(){
    this.notif.remove()
  }
}

const customConfirm = (text,action) => {
  $('notes').parentNode.parentNode.parentNode.children[1].classList.toggle('filter')
  $('notes').parentNode.parentNode.parentNode.children[0].classList.toggle('filter')
  const alertContainer = document.createElement('div')
  const btnContainer = document.createElement('div')
  const textContainer = document.createElement('div')
  const texto = document.createTextNode(text)
  const buttonAcepter = document.createElement('button')
  buttonAcepter.innerHTML = "Aceptar"
  const buttonCancel = document.createElement('button')
  buttonCancel.innerHTML = "Cancelar"
  btnContainer.appendChild(buttonAcepter)
  btnContainer.appendChild(buttonCancel)
  textContainer.appendChild(texto)
  alertContainer.appendChild(textContainer)
  alertContainer.appendChild(btnContainer)
  alertContainer.classList.add('alert-conatiner')
  document.body.appendChild(alertContainer)
  buttonCancel.onclick = function(){
    alertContainer.remove()
    $('notes').parentNode.parentNode.parentNode.children[1].classList.toggle('filter')
    $('notes').parentNode.parentNode.parentNode.children[0].classList.toggle('filter')
    action = false
  }
  buttonAcepter.onclick = function(){
    alertContainer.remove()
    $('notes').parentNode.parentNode.parentNode.children[1].classList.toggle('filter')
    $('notes').parentNode.parentNode.parentNode.children[0].classList.toggle('filter')
    action = true
  }
}

const customAlert = (text) =>{
  if(document.getElementsByClassName('note-active')[0] == undefined){
    $('notes').parentNode.parentNode.parentNode.children[1].classList.toggle('filter')
    $('notes').parentNode.parentNode.parentNode.children[0].classList.toggle('filter')
    $('notes').parentNode.parentNode.parentNode.children[2].classList.toggle('filter')
  }
  const alertContainer = document.createElement('div')
  const btnContainer = document.createElement('div')
  const textContainer = document.createElement('div')
  const texto = document.createTextNode(text)
  const buttonAcepter = document.createElement('button')
  buttonAcepter.innerHTML = "Aceptar"
  btnContainer.appendChild(buttonAcepter)
  textContainer.appendChild(texto)
  alertContainer.appendChild(textContainer)
  alertContainer.appendChild(btnContainer)
  alertContainer.classList.add('alert-conatiner')
  document.body.appendChild(alertContainer)
  document.getElementsByClassName('alert-conatiner')[0].childNodes[1].childNodes[0].focus()
  buttonAcepter.addEventListener('click', () => {
    alertContainer.remove()
    if(document.getElementsByClassName('note-active')[0] == undefined){
      $('notes').parentNode.parentNode.parentNode.children[0].classList.toggle('filter')
      $('notes').parentNode.parentNode.parentNode.children[1].classList.toggle('filter')
      $('notes').parentNode.parentNode.parentNode.children[2].classList.toggle('filter')
    }
  })
}

document.addEventListener('click', (e) => {
  if(document.getElementsByClassName('note-active').length != 0 && e.target.localName == 'body'){
    document.getElementsByClassName('note-active')[0].style.animation = 'rebound .2s'
    setTimeout(() => {
      document.getElementsByClassName('note-active')[0].style.animation = 'none'
    }, 1000);
  }
})

const formatRef = (ref)=>{
  const long = ref.length
  if(long == 6){
    return `${ref.substring(0,4)}  ${ref.substring(4)}`
  }else if(long == 10){
    return `${ref.substring(0,2)} ${ref.substring(2,5)} ${ref.substring(5,8)} ${ref.substring(8)}`
  }else{
    return ref;
  }
}

/* Notificaciones */
function checkNotificationPromise() {
  try {
    Notification.requestPermission().then();
  } catch (e) {
    return false;
  }

  return true;
}

const notificacion = (titulo, texto) => {
  const ifNotif = checkNotificationPromise() 
  icon = '../img/icons8-coche-64.png'
  if(ifNotif){
    const notif = new Notification(titulo,{
      body: texto,
      icon: icon
    })
  }
}

const newAssigns = setInterval(() => {
  const dataUser = new FormData()
  dataUser.append('id',window.location.href.split('?id=')[1])
  if(user.puesto != "ADV")
    return null
  const data = new FormData()
  data.append('usuario','all')
  fetch(ruta[window.location.pathname.split('/').length] + "./api/getCountAssigns.php",{
    method: 'POST',
    body: data
  })
  .then(item => item.text())
  .then(valor => {
    const actual = $('cesionesActivas').childNodes[1].title
    if(parseInt(valor) != parseInt(actual)){
      $('cesionesActivas').childNodes[1].title = `${valor}`
      const dataAssign = new FormData()
      dataAssign.append('usr',user.nombre)
      fetch(ruta[window.location.pathname.split('/').length] + "./api/getAssigLast.php",{
        method: 'POST',
        body: dataAssign
      })
      .then(ass => ass.json())
      .then(cesion =>{
        if(cesion.puesto !== undefined){
          notificacion(`Nueva cesión de ${cesion.puesto}.`,
          `referencia: ${cesion.ref} de ${cesion.origen} a ${cesion.destino}`)
          const path = window.location.pathname
          if(path.includes('cesiones') || path.includes('assigns'))
            console.log("Entra!")
        }
      })
    }
  })
},10000)