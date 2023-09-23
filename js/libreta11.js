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
      $('addNotebook').addEventListener('click', (e)=>{
        let newForm = "<form class='form-new' title='new'>"
        newForm += "<label></label><select type='text' placeholder='marca' id='marca'>"
        newForm += "<option value='MULTIMARCA'>Multimarca</option>"
        newForm += "<option value='CITROEN'>Citroen</option>"
        newForm += "<option value='PEUGEOT'>Peugeot</option>"
        newForm += "<option value='OPEL'>Opel</option>"
        newForm += "<option value='EUROREPAR'>Eurorepar</option>"
        newForm += "<option value='DOCUMENTOS'>Documentos</option>"
        newForm += "</select>"
        newForm += "<label></label><input type='text' placeholder='modelo' id='modelo'>"
        newForm += "<label></label><input type='text' placeholder='descripcion' id='descripcion'>"
        newForm += "<label></label><input type='text' placeholder='referencia' id='referencia'>"
        newForm += "<input type='file' id='docFile' style='display:none'>"
        newForm += "<input type='submit' class='note-btn' style='position: absolute;' value='añadir'>"
        newForm += "</form>"
        newForm += "<div id='dropContainer'>Arrastra aqui algún fichero</div>"
        modal(newForm,`Nueva nota`)
        const newScript = document.createElement('script')
        newScript.type = 'text/javascript'
        newScript.src = '../../js/formNotebook.js'
        $('contacts').append(newScript)
      })
  })
  .catch(err => console.log("error: "+err))
}

loadItems()

document.addEventListener('click',(e)=>{
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
        loadItems('')
        notify(response)
      })
      .catch(functions => console.log("error: "+functions))
    }
  }else if(e.target.id.includes('edit')){
    const id= e.target.parentNode.id
    const data = new FormData()
    data.append('id',id)
    fetch('../../helper/modalNotebook.php?id='+id)
    .then(response => response.text())
    .then(res =>{
      modal(res,"Editar nota")
      const newScript = document.createElement('script')
      newScript.type = 'text/javascript'
      newScript.src = './../js/formNotebook.js'
      $('contacts').append(newScript)
    })
  }
})