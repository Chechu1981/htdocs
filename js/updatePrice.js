document.getElementsByTagName('form')[0].addEventListener('submit',e=>{
  e.preventDefault()
  document.getElementsByTagName('input')[2].disabled = true
  document.getElementsByTagName('div')[7].childNodes[1].innerHTML = `<span class="spinner"></span>`
  e.target.appendChild(document.createElement('div'))
  const file = e.target.childNodes[1].files[0]
  const data = new FormData()
  data.append('file',file)
  fetch('../api/updatePrices.php',{
    method: 'POST',
    body: data
  })
  .then(item => item.text())
  .then(items => {
    document.getElementsByTagName('div')[7].childNodes[1].innerHTML = `${items}`
    document.getElementsByTagName('input')[2].disabled = false
  })
})

dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
  evt.preventDefault();
}

dropContainer.ondragleave = function() {
  dropContainer.classList.remove('leave');
}

dropContainer.ondragenter = function(){
  dropContainer.classList.add('leave');
}

dropContainer.ondrop = function(evt) {
  dropContainer.classList.remove('leave');
  dropContainer.classList.add('drop');
  // pretty simple -- but not for IE :(
    pending.files = evt.dataTransfer.files

  // If you want to use some of the dropped files
  const dT = new DataTransfer()
  dT.items.add(evt.dataTransfer.files[0])
  //dT.items.add(evt.dataTransfer.files[3])
  pending.files = dT.files
  console.log(evt.dataTransfer.files[0])
  $('dropContainer').innerText = evt.dataTransfer.files[0].name

  evt.preventDefault()
}