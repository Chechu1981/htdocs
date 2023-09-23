const createScript = () => {
  let isset = () =>{
    let exist = false
    const scrpt = Array.prototype.slice.call(document.scripts)
    scrpt.forEach(e => {
      if(e.src.split('/')[4] == 'formContacts1.js')
        exist = true
    })
    return exist
  }
  if(!isset()){
    const newScript = document.createElement('script')
    newScript.type = 'text/javascript'
    newScript.src = '../../js/formContacts1.js'
    $('contacts').append(newScript)
  }
}

const clickAdd = () =>{
  $('addContact').addEventListener('click', ()=>{
    let centro = ''
    !$('contacts').childNodes[3] ? centro = '' :centro = $('contacts').childNodes[3].innerText
    let newForm = "<form class='form-new' title='new'>"
    newForm += `<input type="hidden" value="${centro}">`
    newForm += "<label></label><input type='text' placeholder='entidad' id='entidad'>"
    newForm += "<label></label><input type='text' placeholder='equipo' id='equipo'>"
    newForm += "<label></label><input type='text' placeholder='nombre' id='nombre'>"
    newForm += "<label></label><input type='text' placeholder='puesto' id='puesto'>"
    newForm += "<label></label><input type='text' placeholder='ext' id='ext'>"
    newForm += "<label></label><input type='text' placeholder='nº largo' id='nlargo'>"
    newForm += "<label></label><input type='text' placeholder='móvil' id='movil'>"
    newForm += "<label></label><input type='text' placeholder='nº corto' id='ncorto'>"
    newForm += "<label></label><input type='text' placeholder='correo' id='correo'>"
    newForm += "<input type='hidden' placeholder='id' id='id'>"
    newForm += "<input type='submit' class='note-btn' value='añadir'>"
    newForm += "</form>"
    modal(newForm,`Nuevo contacto en ${centro}`)
    const scrpt = Array.prototype.slice.call(document.scripts)
    createScript()
  })
}
const data = new FormData()
data.append('center',$$('h1')[0].innerHTML)
data.append('search','')
fetch('../../api/getCenter.php',{
    method: 'POST',
    body: data
})
.then(e => e.text())
.then(item => {
  if($('center-list-items') != null){
    $('center-list-items').innerHTML = item
    clickAdd()
  }
})

const buscar = (e) => {
  if($$('h1')[0].innerHTML.toUpperCase() == "Centros".toUpperCase() && $('search-contacts').value != "" && $('center-items') != null){
    $('center-items').remove()
    let divList = document.createElement('div')
    divList.setAttribute('id','center-list-items')
    $('search-line').parentNode.parentNode.appendChild(divList)
    const footer = document.getElementsByTagName('footer')[0]
    document.getElementsByClassName('search-table')[0].style.minHeight = 0
    document.getElementsByClassName('search-table')[0].style.top = '30px'
    document.getElementsByClassName('search-table')[0].style.position = 'sticky'
    footer.remove()
  }
  let search = ''
  e === undefined ? search = "" : search = e.target.value;
  let data = new FormData();
  data.append('center',$$('h1')[0].innerHTML)
  data.append('search', search)
  fetch('../../api/getCenter.php',{
    method: 'POST',
    body: data})
  .then(response => response.text())
  .then(response => {
    $('center-list-items').innerHTML = response
    $('contacts').innerText == 'Centros' ? $('addContact').style.display = 'none' : null
    clickAdd()
  })
  .catch(functions => console.log("error: "+functions))
}
  
$$('input')[1].addEventListener('keyup', e => buscar(e))

document.addEventListener('click', (e) => {
  let titulo = e.target.title
  let texto = e.target.innerText
  if((titulo == 'Nº Largo: ' || 
    titulo == 'Móvil:' ||
    titulo == 'Correo: ' ||
    titulo == 'Nº Corto: ' ||
    titulo == 'Ext: ') &&
    texto != ""){
    navigator.clipboard.writeText(texto)
    notify(`¡¡ ${texto} Copiado!!`)
  }
})

document.addEventListener('click',(e)=>{
  const id = e.target.parentNode.id
  const data = new FormData()
  data.append('id',id)
  if(e.target.id.includes('delete')){
    if(confirm('¿Quieres eliminar este registro?') == true){
      let data = new FormData();
      data.append('id', id)
      fetch('../../api/deleteContact.php',{
        method: 'POST',
        body: data})
      .then(response => response.text())
      .then(response => {
        buscar()
        notify(response)
      })
      .catch(functions => console.log("error: "+functions))
    }
  }else if(e.target.id.includes('edit')){
    const id= e.target.parentNode.id
    const data = new FormData()
    data.append('id',id)
    fetch('../../helper/modalContact.php?id='+id)
    .then(response => response.text())
    .then(res =>{
      modal(res,"Editar plataforma")
      createScript()
    })
  }
})

$('contacts').childNodes[1].addEventListener('click', (e)=>{
  const title = $$('h1')[0].innerHTML 
  fetch('../../json/center.json')
  .then(response => response.json())
  .then(res => {
    modal(res[title],title)
  })
})

$('search-contacts').focus()