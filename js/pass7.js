'use strict';

$$('input')[1].focus()

const buscar = (e) => {
  let data = new FormData();
  data.append('search', e)
  data.append('tipo', $('placa').value)
  data.append('usuario', $('placa').value)
  fetch('./api/getPass.php',{
    method: 'POST',
    body: data})
  .then(response => response.text())
  .then(response => {
    $('center-items-pass').classList.remove('bottons')
    $('center-items-pass').classList.add('pass-items')
    $('center-items-pass').innerHTML = response
  })
}

$$('input')[1].addEventListener('keyup', (e) => buscar(e.target.value))

$('center-items-pass').addEventListener('click', (e) => {
  const texto = e.target.innerText
  if(texto.length > 0){
    if(e.target.title =='copiar'){
      navigator.clipboard.writeText(texto)
      notify(`${texto} Copiado`)
    }
  }
})

document.addEventListener('click',(e)=>{
  const id = e.target.parentNode.id
  const data = new FormData()
  data.append('id',id)
  const createScript = () =>{
    const newScript = document.createElement('script')
    newScript.type = 'text/javascript'
    newScript.src = './js/form2.js'
    $('contacts').append(newScript)
  }
  if(e.target.id.includes('addPass')){
    let newForm = "<form class='form-new' title='new'>"
    newForm += '<label></label><select type="text" placeholder="web" id="grupo">'
    newForm += '<option value=""></option>'
    newForm += '<option value="transporte">TRANSPORTE</option>'
    newForm += '<option value="neumaticos">NEUMÁTICOS</option>'
    newForm += '<option value="catalogo">CATÁLOGO</option>'
    newForm += '<option value="ppcr">PPCR</option>'
    newForm += '<option value="stellantis">STELLANTIS</option>'
    newForm += '</select>'
    newForm += "<label></label><input type='text' placeholder='web' id='web'>"
    newForm += "<label></label><input type='text' placeholder='marca' id='marca'>"
    newForm += "<label></label><input type='text' placeholder='placa' id='placa'>"
    newForm += "<label></label><input type='text' placeholder='cuenta' id='cuenta'>"
    newForm += "<label></label><input type='text' placeholder='usuario' id='usuario'>"
    newForm += "<label></label><input type='text' placeholder='contrsaeña' id='paswd'>"
    newForm += "<label></label><input type='text' placeholder='teléfono' id='phone'>"
    newForm += "<label></label><input type='hidden' id='id'>"
    newForm += "<input type='submit' class='note-btn' value='añadir'>"
    newForm += "</form>"
    modal(newForm,"Nueva contraseña")
    const scrpt = Array.prototype.slice.call(document.scripts)
    scrpt.forEach(e => {
      e.src.split('/')[4].includes('form2.js') ? null : createScript()
    })
  }else if(e.target.id.includes('delete')){
    if(confirm('¿Quieres eliminar este registro?') == true){
      let data = new FormData();
      data.append('id', id)
      fetch('./api/deletePass.php',{
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
    fetch('../helper/modal.php?id='+id)
    .then(response => response.text())
    .then(res =>{
      modal(res,"Editar contraseña")
      const scrpt = Array.prototype.slice.call(document.scripts)
      scrpt.forEach(e => {
        e.src.split('/')[4].includes('form2.js') ? null : createScript()
      })
    })
  }
})

$('placa').addEventListener('change', (e) => {
  buscar($('search-pass').value)
})

if($('center-items-pass').childNodes[1].childNodes[1] != undefined){
  $('center-items-pass').childNodes[1].addEventListener('click', (e) => {
    e.target.title != "" ? buscar(`btn${e.target.title.toLowerCase()}`) : null
  })
}