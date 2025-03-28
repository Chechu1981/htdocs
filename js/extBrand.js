'use strict'
import { buscarCliente } from "./alertsAssigns.js?106"
const id = window.location.search.split('?id=')[1]
const btnAll = document.getElementById('all') ?? 0

if(btnAll){
  btnAll.addEventListener('click',()=>{
    document.location = `../cesionesAll.php?id=${id}`
  })
}

document.getElementById('new').addEventListener('click',()=>{
  document.location = `../cesionesADV.php?id=${id}`
})

document.getElementById('extBrand').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./buscar.php?id=${id}`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./ready.php?id=${id}`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./finish.php?id=${id}`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./status.php?id=${id}`
})

let contadorLineas = 1

$('addLine').addEventListener('click',()=>{
  let inputRef = document.createElement('input')
  let inputUni = document.createElement('input')
  let inputDesc = document.createElement('input')
  let span = document.createElement('span')
  let div = document.createElement('div')
  let section = document.createElement('section')
  span.innerText = ++contadorLineas
  div.classList.add('form-extLine')
  section.appendChild(span)
  section.appendChild(inputRef)
  section.appendChild(inputUni)
  section.appendChild(inputDesc)
  div.appendChild(section)
  $('contacts-items').getElementsByTagName('form')[0].appendChild(div)
})

$('client').addEventListener('blur',(e)=>{
  buscarCliente($('destino').value.substring(0,3),$('client').value.split('-')[0])
})

$('sendProv').addEventListener('click',(e)=>{
  e.target.disabled = true
  e.preventDefault()
  $('senMail').disabled = false
  const data = new FormData()
  data.append('id',id)
  /*fetch('../api/sendProv.php',{
    method: 'POST',
    body: data
  })
  .then(e => e.text())
  .then(()=>{
    document.location.reload()
  })*/
})