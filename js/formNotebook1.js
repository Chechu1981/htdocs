let success = {
  update:"../api/updateNotebook.php",
  delete:"../api/deleteNotebook.php",
  new:"../api/addNotebook.php"
}
document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
  const src = success[e.target.title]
  e.preventDefault()
  e.stopImmediatePropagation()
  e.target.children[8].value != "" ? $fileTarget = e.target.children[8].files[0] : $fileTarget = $('dropContainer').innerText
  $('dropContainer').innerText == "Arrastra aqui algún fichero" ? $fileTarget = "" : null
  const data = new FormData()
  if(e.target.children[11] != undefined)
    data.append('id',e.target.children[11].value)

  data.append('marca', e.target.children[1].value)
  data.append('modelo', e.target.children[3].value)
  data.append('descripcion', e.target.children[5].value)
  data.append('referencia', e.target.children[7].value)
  data.append('file', $fileTarget)

  //check for empty inputs
  if(e.target.children[1].value+e.target.children[3].value+e.target.children[5].value+e.target.children[7].value == '')
    return null
  fetch(src,{
      method: 'POST',
      body: data
  })
  .then(res => res.text())
  .then(response =>{
      if(response == 'ok'){
        for(let i = 0; i < document.getElementsByTagName('script').length; i++){
          let item = document.getElementsByTagName('script')[i].src.split('/')[4]
          if(item == 'formNotebook.js' || item == 'form.js'){
            document.getElementsByTagName('script')[i].remove()
          }
        }
      }
      e.target.parentNode.parentNode.remove()
      $('menu').classList.remove('filter')
      $('contacts').parentNode.classList.remove('filter')
      loadItems(e.target.children[3].value)
  })
})

$('dropContainer').ondragover = function(evt) {
    evt.preventDefault();
}
  
$('dropContainer').ondragleave = function() {
  $('dropContainer').classList.remove('leave');
}
  
$('dropContainer').ondragenter = function(){
  $('dropContainer').classList.add('leave');
}
  
$('dropContainer').ondrop = function(evt) {
  $('dropContainer').classList.remove('leave');
  $('dropContainer').classList.add('drop');
  // pretty simple -- but not for IE :(
    docFile.files = evt.dataTransfer.files

  // If you want to use some of the dropped files
  const dT = new DataTransfer()
  dT.items.add(evt.dataTransfer.files[0])
  //dT.items.add(evt.dataTransfer.files[3])
  docFile.files = dT.files
  //console.log(evt.dataTransfer.files[0])
  $('dropContainer').innerText = evt.dataTransfer.files[0].name

  evt.preventDefault()
}