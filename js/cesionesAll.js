"use strict";
import { createMail, enviarMailDisgon, createMailMat } from "./createMail.js?100";
import contadores from "./updateCounter.js?100";

setInterval(() =>{contadores()},1200)

let refresco

const newChanges = (response) =>{
  const oldInputs = $('cesiones').getElementsByTagName('input')
  const newInputs = response.getElementsByTagName('input')
  if($('cesiones').getElementsByClassName('assignPendingAdv').length != response.getElementsByClassName('assignPendingAdv').length)
    return true

  for(let i = 0;i < oldInputs.length; i++){
    if(oldInputs[i].value != newInputs[i].value || oldInputs[i].checked != newInputs[i].checked)
      return true
  }
  return false
}

//const rutasDirectas = ["12753","12754-1","12750-1","11433-1","9071-1","6279-1","12849-1","12864-1","7545-1","14075-1","105250","105253-1","105249-1","105251-1","105342-1","78766-1","105228-1","78664-1","105510-1","105310-1"]
const rutasDirectas = ["6251-2","78709-1","12752-1","105252-1","105342-1","14075-1","7545-1","78766-1"]
const rutasPreguntar = ["6254-1","78713-1"]
const rutasPortes = ["12874","14079-1","14101-1","6280-1","14086-1","105247-1","105511-1","105400-1","78665-1","78713-1","105311-1"]


const iniciar = () => {
  refresco = setInterval(() =>{
    showAssig()
  },1000)
}

document.addEventListener('DOMContentLoaded',()=>{
  iniciar()
})

const stopUpdates = ()=>{
  clearInterval(refresco)
}

const markLines = (ul) =>{
  const codeClient = ul.childNodes[1].childNodes[6].textContent
  const id = ul.childNodes[25].id
  const filas = $('cesiones').getElementsByTagName('ul')
  for(let i=1; i < filas.length; i++){
    const codeClientLi = filas[i].childNodes[1].childNodes[6].textContent
    const idLi = filas[i].childNodes[25].id
    filas[i].classList.remove('marcado')
    filas[i].classList.remove('equal')
    codeClientLi == codeClient && idLi != id ? filas[i].classList.add('equal') : ''
  }
  ul.classList.add('marcado')
}

const updateBubble = (operador) =>{
  const bubble = $('contacts').childNodes[3].childNodes[1].childNodes[0]
  const bubbleAll = $('contacts').childNodes[3].childNodes[3].childNodes[0]
  const bubbleReady = $('contacts').childNodes[3].childNodes[7].childNodes[0]
  if(operador == '-'){
    bubble != undefined ? bubble.innerText = parseInt(bubble.innerText) - 1 : ''
    bubbleAll != undefined ? bubbleAll.innerText = parseInt(bubbleAll.innerText) - 1 : ''
    bubbleReady != undefined ? bubbleReady.innerText = parseInt(bubbleReady.innerText) - 1 : ''
  }else{
    bubble != undefined ? bubble.innerText = parseInt(bubble.innerText) + 1 : ''
    bubbleAll != undefined ? bubbleAll.innerText = parseInt(bubbleAll.innerText) + 1 : ''
    bubbleReady != undefined ? bubbleReady.innerText = parseInt(bubbleReady.innerText) + 1 : ''
  }
}

const updateCounterAssignment = (id,comentario) => {
  const data = new FormData()
  data.append('id',id)
  data.append('comentario',comentario)
  fetch('../api/updateAssignADV2023.php',{
    method: 'POST',
    body: data
  })
}

const showAssig = () =>{
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  data.append('sort', 'date')
  fetch('../api/getAssigADV_all.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(response => {
    const clearRowsMark = (ul,text) =>{
      copyClipboard(text)
      markLines(ul)
    }
    const divTest = document.createElement('div')
    let lineaMarcada = 0
    for(let l = 0;l < $('cesiones').getElementsByTagName('ul').length; l++){
      if($('cesiones').getElementsByTagName('ul')[l].className.includes('marcado'))
      lineaMarcada = l
    }
    divTest.innerHTML = response
    if(divTest.innerHTML != $('cesiones').innerHTML.replaceAll(' marcado','').replaceAll(' equal','')){
      $('cesiones').style = ''
      $('cesiones').innerHTML = response
      for(let i = 2; i < $('cesiones').childNodes.length; i = i+2){
        let ul, id, origen, destino, cliente, refCliente, comentario, referencia, cantidad, pedido, fragil, pvp, tratado, nfm, disgon, btnSendMail, btnEliminar, puesto, btnSendMailDisgon, rechazo, usuario, origenLed = ''
        ul = $('cesiones').childNodes[i]
        id = ul.childNodes[25].id
        origen = ul.childNodes[1].childNodes[2]
        origenLed = ul.childNodes[1].childNodes[1]
        destino = ul.childNodes[1].childNodes[4]
        cliente = ul.childNodes[5]
        refCliente = ul.childNodes[1].childNodes[6]
        comentario = ul.childNodes[9]
        referencia = ul.childNodes[11]
        cantidad = ul.childNodes[13].textContent
        pedido = ul.childNodes[15].firstChild
        fragil = ul.childNodes[19].firstChild
        disgon = ul.childNodes[21].firstChild
        pvp = ul.childNodes[11].childNodes[1].textContent
        tratado = $(`agente${id}`)
        nfm = ul.childNodes[17].firstChild
        btnEliminar = ul.childNodes[25]
        rechazo = $(`rechazo${id}`)
        usuario = ul.childNodes[27].childNodes[0].data
        puesto = ul.childNodes[27].childNodes[2].nodeValue.replaceAll('(','').replaceAll(')','')
        if(disgon != null)
          disgon.addEventListener('change',() => updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value, destino))
        if(ul.localName == 'ul' && ul.localName != undefined){
          pedido.addEventListener('focus', ()=>stopUpdates())
          tratado.addEventListener('focus', ()=>stopUpdates())
          origen.addEventListener('focus', ()=> stopUpdates())
          nfm.addEventListener('change', () => {refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent),iniciar()})
          fragil.addEventListener('change', () => {refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent),iniciar()})
          tratado.addEventListener('change', () => {refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent),iniciar()})
          origen.addEventListener('change', () => {refreshInputs(id,fragil.checked,pedido.value,tratado.value,origen.value,destino.textContent),iniciar()})
          comentario.childNodes[0].addEventListener('focus', ()=> stopUpdates())
          comentario.childNodes[0].addEventListener('keyup', () => {updateCounterAssignment(id,comentario.firstElementChild.value)})
          comentario.childNodes[0].addEventListener('blur', ()=> iniciar())
        }
        rechazo.addEventListener('click', ()=>{
          const data = new FormData()
          data.append('id',id)
          data.append('switch',true)
          data.append('usuario',usuario)
          data.append('tratado',user.nombre.toUpperCase())
          fetch('../helper/formRechazo.php',{
            method: 'POST',
            body: data
          })
          .then((inp) => inp.text())
          .then(items => {
            modal(items,`Rechazar la cesión de ${origen.value} -> ${destino.textContent}`)
            const texto = document.getElementById("texto")
            const enviar = document.getElementById("enviar")
            const cancelar = document.getElementById("cancelar")
            cancelar.addEventListener("click", () => {
              $('close').click()
            })
            enviar.addEventListener("click", () => {
              data.append('texto',`(${user.nombre}) ${texto.value}`)
              const fecha = new Date()
              const mailSaludo = fecha.getHours() > 14 ? `Buenas tardes: ` : `Buenos días: `
              const mailTarget = encodeURIComponent(`
              ${texto.value}
              
              Un saludo ${user.nombre}`)
              fetch('../api/getEmailByUsername.php',{
                method: 'POST',
                body: data
              })
              .then(usrAll => usrAll.json())
              .then(usrSend => {
                window.open(`mailto:${usrSend.mail}?subject=Cesión de la ${referencia.childNodes[0].textContent.replaceAll(' ','')} rechazada&body=${mailSaludo + mailTarget}`)
              })
              fetch('../api/updateRechazo.php',{
                method: 'POST',
                body: data
              })
              $('close').click()
            })
          })
        })
        referencia.addEventListener('click', () => {clearRowsMark(ul,referencia.childNodes[0].textContent.replaceAll(' ',''))})
        comentario.addEventListener('click', () => {clearRowsMark(ul,comentario.textContent)})
        cliente.addEventListener('click', () => {
          let fragilTxt = ''
          if(disgon != null){
            disgon.checked && $(`disgon${id}`).innerHTML == '📦' ? fragilTxt += 'Recoge LOGISTICA. ' : ''
            disgon.checked && $(`disgon${id}`).innerHTML == '🚚' ? fragilTxt += 'Recoge DISGON. ' : ''
          }
          fragil.checked ? fragilTxt += '..~** ¡¡MATERIAL FRÁGIL!! **~..Reforzar embalaje;' : ''
          clearRowsMark(ul,`Cesión ${origen.value}>${destino.textContent} - Cliente: ${cliente.childNodes[0].textContent} (${cliente.childNodes[1].textContent}) ${fragilTxt}`)
        })
        refCliente.addEventListener('click', () => {clearRowsMark(ul,`Cliente: ${cliente.childNodes[0].textContent}`)})
        destino.addEventListener('click', () => {
          destino.classList.toggle('active-city-press')
          updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
        })
        if(btnSendMail != null){
          btnSendMail.addEventListener('click',() => enviarMail(pedido.value, origen.value, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), `${cliente.firstChild.textContent} (${cliente.childNodes[1].textContent})`, fragil.checked, pvp, id, cantidad, nfm.checked, tratado.childNodes[1].value, refCliente.innerText,comentario.firstChild.textContent.innerHTML))
          if(btnSendMailDisgon != null)
            btnSendMailDisgon.addEventListener('click',() => enviarMailDisgon(cantidad, origen.value, destino.textContent, referencia.firstChild.textContent.replaceAll(' ',''), id))
        }
        origenLed.addEventListener('click', (e) => {
          e.target.classList.toggle('ledOn')
          updateChkbx(id,nfm.checked,fragil.checked,pedido.value,tratado.value,destino.textContent)
        })
        btnEliminar.addEventListener('click', () => eliminarLinea(id,referencia.firstChild.textContent.replaceAll(' ',''),tratado.value))
        if(lineaMarcada > 0)
          markLines($('cesiones').getElementsByTagName('ul')[lineaMarcada])
      }
    }
  })
}

const refreshInputs = (id,fragil,pedido,tratado,origen,destino) => {
  let cesion = null
  let chkSeguro = document.getElementById(id).parentNode.childNodes[21].childNodes[0]
  let seguro =  chkSeguro == undefined ? false : chkSeguro.checked
  let nfm = document.getElementById(id).parentNode.childNodes[17].childNodes[0].checked
  let code = $(id).parentNode.childNodes[1].childNodes[6]
  origen != destino ? cesion = origen + '' + destino : ''
  seguro = fragil ? seguro = seguro : false 
  seguro && origen == "MADRID" ? cesion += 'SEG' : ''
  nfm ? cesion += 'NM' : ''
  if(origen != 'MAT' && origen != 'EXT'){
    fetch('../json/cesionesCliente.json?105',
      {cache: "reload"}
    )
    .then(response => response.json())
    .then(response => {
      response[cesion] != undefined ? code.innerHTML = response[cesion] : code.innerHTML = ""
    })
  }else{
    const session = window.location.search.split('?id=')[1]
    const data = new FormData()
    data.append('id', id)
    data.append('session', session)
    fetch('../api/getAssignZzmat.php',{
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(response => {
      const refZZMAT = document.getElementById(`destinoBtn${id}`).parentNode.childNodes[6]
      refZZMAT.innerHTML = `<span class="copy " style="grid-column: 1 / 4;font-size: medium;">${response.refClient}</span>`
    })
  }
  updateChkbx(id,nfm,fragil,pedido,tratado,destino)
}

const copyClipboard = (copiar) =>{
  navigator.clipboard.writeText(copiar)
  notify(`${copiar} copiado!`)
}

const updateChkbx = (id,nfm,fragil,pedido,tratado,destino) => {
  const disgon = $(id).parentNode.childNodes[21].firstChild == null ? false : $(id).parentNode.childNodes[21].firstChild.checked
  const origenBtn = $(id).parentNode.childNodes[1].childNodes[1].className.includes('ledOn') ? '1':'0'
  const destinoBtn = $(id).parentNode.childNodes[1].childNodes[4].className.includes('press') ? '1':'0'
  const origen = $(id).parentNode.childNodes[1].childNodes[2].value
  const comentario = $(`coment${id}`).value
  const data = new FormData()
  data.append('id', id)
  data.append('nfm',nfm)
  data.append('fragil',fragil)
  data.append('pedido',pedido)
  data.append('tratado',tratado)
  data.append('envio', false)
  data.append('disgon', disgon)
  data.append('comentario', comentario)
  data.append('origenBtn', origenBtn)
  data.append('destinoBtn', destinoBtn)
  data.append('origen', origen)
  fetch('../api/updateAssignADVall.php',{
    method: 'POST',
    body: data
  })
  const disgonLi = $(`${id}`).parentNode.childNodes[21]
  if(fragil && disgonLi.firstChild == undefined) {
    const chkDisgon = document.createElement('input')
    chkDisgon.setAttribute('type', 'checkbox')
    chkDisgon.addEventListener('change', () => {
      updateChkbx(id,nfm,fragil,pedido,tratado, destino)
    })
    disgonLi.appendChild(chkDisgon)
  }
}

const eliminarLinea = (id,referencia,puesto) =>{
  const dataName = new FormData()
  dataName.append('id',id)
  fetch('../api/isSend.php',{
    method: 'POST',
    body: dataName
  })
  .then((isSend)=>isSend.text())
  .then(enviado => {
    if(enviado){
      customAlert("Ya está enviado. No se puede eliminar.")
      return true
    }
    const confirmacion = confirm(`¿Quieres eliminar la referencia ${referencia}?`)
    if(!confirmacion)
      return true
    
    const data = new FormData()
    data.append('id',id)
    data.append('puesto',puesto)
    fetch('../api/deleteAssignADV.php', {
      method: 'POST',
      body: data
    })
    .then(e => e.text())
    .then(()=>{
      $(id).parentNode.remove()
      updateBubble('-')
    })
  })
}

const updateAssig = (id,values) => {
  console.log(id + ': ' + values)
}

const limpiarSpinner = () =>{
  $('contacts-items').getElementsByClassName('spinner-center')[0].remove()
  $('cesiones').classList.remove('filter')
}

const id = window.location.search.split('?id=')[1]

document.getElementById('new').addEventListener('click',()=>{
  document.location = `./cesionesADV.php?id=${id}`
})

document.getElementById('all').addEventListener('click',()=>{
  document.location.reload()
})

document.getElementById('find').addEventListener('click',()=>{
  document.location = `./assigns/buscar.php?id=${id}`
})

document.getElementById('ready').addEventListener('click',()=>{
  document.location = `./assigns/ready.php?id=${id}`
})

document.getElementById('finish').addEventListener('click',()=>{
  document.location = `./assigns/finish.php?id=${id}`
})

document.getElementById('status').addEventListener('click',()=>{
  document.location = `./assigns/status.php?id=${id}`
})