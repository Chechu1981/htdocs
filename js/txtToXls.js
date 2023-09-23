document.getElementsByTagName('form')[0].addEventListener('submit',e=>{
  e.preventDefault()
  document.getElementsByTagName('input')[2].disabled = true
  const fileSize = pending.files[0].size
  const barra = setInterval(function(){
    const secondsEstimated = (fileSize / 4621) / 1000
    const byteForSecond = fileSize / secondsEstimated
    const valor = document.getElementById('spinnerBar').value
    document.getElementById('spinnerBar').value = valor + byteForSecond
  document.getElementById('spinnerBar').innerHTML = `${Math.round((valor + byteForSecond * 100) / fileSize)} %`
  },500)
  document.getElementsByTagName('div')[7].childNodes[1].innerHTML = `
    <progress id="spinnerBar" value="0" max="${fileSize}">0%</progress>`
  e.target.appendChild(document.createElement('div'))
  const file = e.target.childNodes[1].files[0]
  const data = new FormData()
  data.append('file',file)
  fetch('../api/txtToXls.php',{
    method: 'POST',
    body: data
  })
  .then(item => item.text())
  .then(items => {
    clearInterval(barra)
    document.getElementsByTagName('div')[7].childNodes[1].innerHTML = `<progress id="spinnerBar" value="100" max="100">100%</progress>`
    setTimeout(() => {
      document.getElementsByTagName('div')[7].childNodes[1].innerHTML = `${items}`
      document.getElementsByTagName('input')[2].disabled = false
    },500)
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