let success = {
  update:"../api/updateNotebook.php",
  delete:"../api/deleteNotebook.php",
  new:"../api/addNotebook.php"
}
document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{A
  const src = success[e.target.title]
  e.preventDefault()
  e.stopImmediatePropagation()
  e.target.children[8].value != "" ? fileTarget = e.target.children[8].files[0] : fileTarget = document.getElementById('dropContainer').innerText
  document.getElementById('dropContainer').innerText == "Arrastra aqui algún fichero" ? fileTarget = "" : null
  const data = new FormData()
  const id = e.target.children[11].value
  const hash = window.parent.location.search.split('=')[1]
  if(e.target.children[11] != undefined)
    data.append('id',id)

  data.append('marca', e.target.children[1].value)
  data.append('modelo', e.target.children[3].value)
  data.append('descripcion', e.target.children[5].value)
  data.append('referencia', e.target.children[7].value)
  data.append('file', fileTarget)

  //check for empty inputs
  if(e.target.children[1].value+e.target.children[3].value+e.target.children[5].value+e.target.children[7].value == '')
    return null
  fetch(src,{
      method: 'POST',
      body: data
  })
  .then(res => res.text())
  .then(response =>{
      window.parent.document.getElementById('menu').classList.remove('filter')
      window.parent.document.getElementById('contacts').parentNode.classList.remove('filter')
      window.parent.location.href = `../src/libreta.php?id=${hash}`
      window.parent.document.getElementsByClassName('note-active')[0].remove()
  })
})

document.getElementById('dropContainer').ondragover = function(evt) {
    evt.preventDefault();
}
  
document.getElementById('dropContainer').ondragleave = function() {
  document.getElementById('dropContainer').classList.remove('leave');
}
  
document.getElementById('dropContainer').ondragenter = function(){
  document.getElementById('dropContainer').classList.add('leave');
}
  
document.getElementById('dropContainer').ondrop = function(evt) {
  document.getElementById('dropContainer').classList.remove('leave');
  document.getElementById('dropContainer').classList.add('drop');
  // pretty simple -- but not for IE :(
    docFile.files = evt.dataTransfer.files

  // If you want to use some of the dropped files
  const dT = new DataTransfer()
  dT.items.add(evt.dataTransfer.files[0])
  //dT.items.add(evt.dataTransfer.files[3])
  docFile.files = dT.files
  //console.log(evt.dataTransfer.files[0])
  document.getElementById('dropContainer').innerText = evt.dataTransfer.files[0].name

  evt.preventDefault()
}