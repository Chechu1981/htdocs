'use strict';

$$('input')[1].focus()

const buscar = (e) => {
  const placa = $('placa').value == 'SANTIAGO' ? 'GALICIA' : $('placa').value
  let data = new FormData();
  data.append('search', e)
  data.append('tipo', placa)
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

$('addLink').addEventListener('click',() =>{
  let id = document.location.search.split('=')[1]
  modal(`<iframe src='../helper/formNewLink.php?id=${id}' class='libreta'></iframe>`,"Nuevo enlace")
})

document.addEventListener('click',(e)=>{
  const idItem = e.target.parentNode.id
  const data = new FormData()
  data.append('idItem',idItem)
  const createScript = () =>{
    const newScript = document.createElement('script')
    newScript.type = 'text/javascript'
    newScript.src = './js/form2.js'
    $('contacts').append(newScript)
  }
  if(e.target.id.includes('delete')){
    if(confirm('¿Quieres eliminar este registro?') == true){
      let data = new FormData();
      data.append('idItem', idItem)
      fetch('./api/deletePass.php',{
        method: 'POST',
        body: data})
      .then(response => response.text())
      .then(response => {
        buscar($('search-pass').value)
        notify(response)
      })
      .catch(functions => console.log("error: "+functions))
    }
  }else if(e.target.id.includes('edit')){
    let id = document.location.search.split('=')[1]
    modal(`<iframe src='../helper/formNewLink.php?id=${id}&idItem=${idItem}' class='libreta'></iframe>`,"Editar enlace")
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