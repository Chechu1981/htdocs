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
  newScript.src = './../js/formSoc.js'
  $('contacts').append(newScript)
}

const loadItems = (search) => {
  $('soc-items').innerHTML = ''
  let data = new FormData()
  data.append('search', search)
  fetch('../api/getSoc.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(datos =>{
      $('soc-items').innerHTML = datos
      $('soc-items').addEventListener('click',(e) => {
        e.stopImmediatePropagation()
        const id = e.target.parentNode.id
        const data = new FormData()
        data.append('id',id)
        if(e.target.id.includes('delete')){
          if(confirm('¿Quieres eliminar este registro?') == true){
            let data = new FormData();
            data.append('id', id)
            fetch('./../api/deleteSoc.php',{
              method: 'POST',
              body: data})
            .then(response => response.text())
            .then(response => {
              e.target.parentNode.parentNode.style.display = 'none'
              notify(response)
            })
            .catch(functions => console.log("error: "+functions))
          }
        }else if(e.target.alt.includes('Guardar')){
          const id= e.target.parentNode.id
          const data = new FormData()
          data.append('id',id)
          data.append('ncuenta',e.target.parentNode.parentNode.childNodes[1].firstChild.value)
          data.append('cuenta',e.target.parentNode.parentNode.childNodes[3].firstChild.value)
          data.append('nombre',e.target.parentNode.parentNode.childNodes[5].firstChild.value)
          data.append('cif',e.target.parentNode.parentNode.childNodes[7].firstChild.value)
          data.append('cp',e.target.parentNode.parentNode.childNodes[9].firstChild.value)
          data.append('ciudad',e.target.parentNode.parentNode.childNodes[11].firstChild.value)
          data.append('nplaca',e.target.parentNode.parentNode.childNodes[13].firstChild.value)
          data.append('placa',e.target.parentNode.parentNode.childNodes[15].firstChild.value)
          fetch(success['update'],{
            method: 'POST',
            body: data
          })
          .then(response => response.text())
          .then(res =>{
            notify("Guardado")
          })
        }
      })
      $('addSoc').addEventListener('click', (e)=>{
        let newForm = `<form action="" class="form-new" title="new" id="frmNewNotebook">`
        newForm += "<label></label><select type='text' placeholder='placa' id='placa'>"
        newForm += "<option value='PPCR MADRID'>Madrid</option>"
        newForm += "<option value='PPCR SEVILLA'>Sevilla</option>"
        newForm += "<option value='PPCR VIGO'>Vigo</option>"
        newForm += "<option value='PPCR GRANADA'>Granada</option>"
        newForm += "<option value='PPCR ZARAGOZA'>Zaragoza</option>"
        newForm += "<option value='PPCR PALMA'>Palma</option>"
        newForm += "<option value='PPCR PATERNA'>Paterna</option>"
        newForm += "<option value='PPCR BARCELONA'>Barcelona</option>"
        newForm += "</select>"
        newForm += "<label></label><input type='text' placeholder='Nº cliente' id='ncliente'>"
        newForm += "<label></label><input type='text' placeholder='CIF' id='cif'>"
        newForm += "<label></label><input type='text' placeholder='RRDI' id='rrdi'>"
        newForm += "<label></label><input type='text' placeholder='nombre' id='nombre'>"
        newForm += "<input type='submit' class='note-btn' style='position: absolute;' value='añadir'>"
        newForm += "</form>"
        modal(newForm,`Nuevo SOC`)
        const scrpt = Array.prototype.slice.call(document.scripts)
        scrpt.forEach(e => {
          e.src.split('/')[4] == 'formSoc.js' ? null : createScript()
        })
      })
  })
  .catch(err => console.log("error: "+err))
}

loadItems('%%')

const success = {
  update:"../api/updateSoc.php",
  delete:"../api/deleteSoc.php",
  new:"../api/addSoc.php"
}