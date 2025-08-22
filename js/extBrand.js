'use strict'
import { buscarCliente } from "./alertsAssigns.js?106"
const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `../cesionesAll.php`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location = `../cesionesADV.php`
})

document.getElementById('extBrand').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./buscar.php`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./ready.php`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./finish.php`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./status.php`
})

let contadorLineas = 1

$('addLine').addEventListener('click',()=>{
  let inputRef = document.createElement('input')
  let inputUni = document.createElement('input')
  let inputDesc = document.createElement('input')
  let familySelect = document.createElement('select')
  let familyOpt1 = document.createElement('option')
  let familyOpt2 = document.createElement('option')
  let familyOpt3 = document.createElement('option')
  let familyOpt4 = document.createElement('option')
  let img = document.createElement('img')
  let span = document.createElement('span')
  let div = document.createElement('div')
  let section = document.createElement('section')
  inputRef.id = `ref${contadorLineas}`
  inputUni.id = `units${contadorLineas}`
  inputDesc.id = `comentLine${contadorLineas}`
  familySelect.id = `familyParts${contadorLineas}`
  familyOpt1.value = ''
  familyOpt1.innerText = ''
  familyOpt2.innerText = 'Carrocería'
  familyOpt3.innerText = 'Mecánica'
  familyOpt4.innerText = 'Reman'
  familyOpt2.value = 'CARROCERIA'
  familyOpt3.value = 'MECANICA'
  familyOpt4.value = 'REMAN'
  familySelect.appendChild(familyOpt1)
  familySelect.appendChild(familyOpt2)
  familySelect.appendChild(familyOpt3)
  familySelect.appendChild(familyOpt4)
  img.src = '../../img/delete_FILL0_wght400_GRAD0_opsz24.png'
  img.alt = 'Eliminar'
  img.title = 'Eliminar'
  img.className = 'deleteLine'
  span.innerText = ++contadorLineas
  img.id = `delete${contadorLineas}`
  div.classList.add('form-extLine')
  section.appendChild(span)
  section.appendChild(inputRef)
  section.appendChild(inputUni)
  section.appendChild(inputDesc)
  section.appendChild(familySelect)
  section.appendChild(img)
  div.appendChild(section)
  $('contacts-items').getElementsByTagName('form')[0].appendChild(div)
})

$('client').addEventListener('blur',(e)=>{
  buscarCliente($('destino').value.substring(0,3),$('client').value.split('-')[0])
})

const clearImportant = () => {
  for (const select of $$('select')) {
    select.classList.remove('important')
  }
  for (const input of $$('input')) {
    input.classList.remove('important')
  }
}

$('sendProv').addEventListener('click',(e)=>{
  clearImportant()
  const tipo = $('tipo')
  const marca = $('marca')
  const destino = $('destino')
  const cliente = $('client')
  const envio = $('envio')
  const coment = $('coment')
  if(destino.value === ''){
    customAlert('Debe seleccionar un destino')
    destino.classList.add('important')
    return
  }
  if(cliente.value === ''){
    customAlert('Debe seleccionar un cliente')
    cliente.classList.add('important')
    return
  }
  if(envio.value === ''){
    customAlert('Debe seleccionar un envío')
    envio.classList.add('important')
    return
  }
  if(marca.value === ''){
    customAlert('Debe seleccionar una marca')
    marca.classList.add('important')
    return
  }
  if(tipo.value === ''){
    customAlert('Debe seleccionar un tipo de recambio')
    tipo.classList.add('important')
    return
  }
  const orderExt = new FormData()
  orderExt.append('id',user.hash)
  orderExt.append('tipo',tipo.value)
  orderExt.append('marca',marca.value)
  orderExt.append('destino',destino.value)
  orderExt.append('cliente',cliente.value)
  orderExt.append('envio',envio.value)
  orderExt.append('comentarios',coment.value)
  let lineas = []
  for (let i = 0; i <= contadorLineas - 1; i++) {
    lineas.push({
      referencia: $(`ref${i}`).value,
      cantidad: $(`units${i}`).value,
      designacion: $(`comentLine${i}`).value,
      familia: $(`familyParts${i}`).value
    })
  }

  orderExt.append('lineas', JSON.stringify(lineas))

  //e.target.disabled = true
  e.preventDefault()
  $('senMail').disabled = false
  fetch(src + 'api/addListExt.php',{
    method: 'POST',
    body: orderExt
  })
  .then(e => e.json())
  .then((csvlineas)=>{
    //CREA UN FICHERO CSV CON LOS CAMPOS REFERENCIA Y DESIGNACION
    let csvLineas = ''
    csvlineas.forEach(element => {
      csvLineas += `${element}\n`
    });
    let csvContent = "data:text/csv;charset=utf-8," + encodeURIComponent(csvLineas)
    const link = document.createElement("a")
    link.setAttribute("href", csvContent)
    link.setAttribute("download", "contacts.csv")
    document.body.appendChild(link)
    link.click()
  })
})

// Elimina la fila creada al hacer click sobre la imagen de eliminar
$('contacts-items').addEventListener('click',(e)=>{
  if(e.target.tagName === 'IMG'){
    let id = e.target.id.substring(6)
    let div = document.getElementById(`delete${id}`)
    div.parentNode.parentNode.remove()
    contadorLineas--
  }
})