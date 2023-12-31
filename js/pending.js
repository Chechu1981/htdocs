const $ = (e) => document.getElementById(e)
const inputs = document.getElementsByTagName('input');
for (var i = 0; i < inputs.length; i++) {
  document.getElementsByTagName('input')[i].addEventListener('focus', e =>{
    if(e.target.value != "Consultar")
      e.target.labels[0].classList.add('focus')
  })
  document.getElementsByTagName('input')[i].addEventListener('blur', e =>{
    if(e.target.value == "")
      e.target.labels[0].classList.remove('focus')
  })
}

document.getElementsByTagName('form')[0].addEventListener('keyup', e => {
  e.target.style = ""
  if(e.target.value != '')
   e.target.style = "border-width: 0px 0px 2px 0px;border-color: rgb(14, 14, 97);"
})

const searchItems = (e) =>{
  const data = new FormData
  data.append('ncliente',e[1].value)
  data.append('placa',e[0].value)
  fetch('../api/getSendClient.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(items => {
    let oldEnvio = document.getElementsByTagName('input')[1]
    if(document.getElementsByTagName('input')[1].id != 'envio')
      oldEnvio = document.getElementsByTagName('select')[1]
    const envio = document.createElement('select')
    envio.id = 'envio'
    let select0 = document.createElement('option')
    select0.value = ""
    let optionTxt0 = "Todas"
    let select1 = document.createElement('option')
    select1.value = 0
    let optionTxt1 = "D. principal: 0"
    select1.appendChild(document.createTextNode(optionTxt1))
    envio.appendChild(select0)
    envio.appendChild(select1)
    if(items.length > 0)
      select0.appendChild(document.createTextNode(optionTxt0))
    items.map(item =>{     
      let select = document.createElement('option')
      select.value = `${item.envio}`
      let optionTxt = `Dirección: ${item.envio}` 
      select.appendChild(document.createTextNode(optionTxt))
      envio.appendChild(select)
    })
    document.getElementsByTagName('form')[0].replaceChild(envio, oldEnvio)
  })
}

document.getElementsByTagName('form')[0].childNodes[13].addEventListener('keyup', e =>{
  searchItems(e.target.parentNode)
})

$('placa').addEventListener('change',(e) => {
  searchItems(e.target.parentNode)
})

document.getElementsByTagName('form')[0].addEventListener('submit', e =>{
  e.preventDefault()
  document.getElementById('items').innerHTML = 
    `<div class="lds-ring">
      <img width="130px" src="../img/Logo-PPCR-2022.png" alt="PPCR">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>`
  const nplacas = {
    "PALMA" :"027130L",
    "BARCELONA": "027135M",
    "GRANADA":"027120K",
    "MADRID":"027015L",
    "VALENCIA":"027066M",
    "SEVILLA":"027110G",
    "VIGO":"027115E", 
    "ZARAGOZA":"027125R"
  }
  const data = new FormData()
  const cliente = $('cliente').value
  const placa = nplacas[$('placa').value]
  const envio = $('envio').value
  const referencia = $('referencia').value
  if(cliente == ""){
    $('cliente').style.borderBottom = "4px solid #ff0e0ed9"
    customAlert("El campo cliente está vacío.")
    document.getElementById('items').innerHTML = ""
    return true
  }
  data.append('placa', placa)
  data.append('cliente',cliente)
  data.append('ref',referencia)
  data.append('envio',envio)
  fetch('../api/getPending.php',{
    method: 'POST',
    body: data
  })
  .then(e => e.text())
  .then(item =>{
    document.getElementsByTagName('span')[1] != undefined ? document.getElementsByTagName('span')[1].remove() : null
    if(item.includes('No hay coincidencias')){
      document.getElementById('items').innerHTML = `<div class="empty">NO SE HAN ENCONTRADO COINCIDENCIAS</div>`
    }
    else{
      document.getElementById('items').innerHTML = item
      const btnCsv = document.createElement('span')
      const img = document.createElement('img')
      img.src = '../img/filetype-csv.svg'
      img.style.width = '30px'
      img.style.filter = 'invert(1)'
      btnCsv.appendChild(img)
      btnCsv.onclick = (e) =>{
        const file = document.getElementById('items').childNodes[0].id
        window.open(`../csv/${file}.csv`)
      }
      btnCsv.className = 'csv-file'
      btnCsv.title = "Descargar fichero CSV"
      document.getElementsByClassName('cuadro')[0].childNodes[1].append(btnCsv)

      // Anoto la consulta
      const dataClient = new FormData()
      dataClient.append('cliente',cliente)
      dataClient.append('placa',placa)      
      dataClient.append('referencia',referencia)
      dataClient.append('envio',envio)
      fetch('../api/newSelectPending.php',{
        method: 'POST',
        body: dataClient
      })
    }
  })
})

const customAlert = (text) =>{
  document.body.childNodes[1].classList.toggle('filter')
  document.body.childNodes[3].classList.toggle('filter')
  document.body.childNodes[5].classList.toggle('filter')
  const alertContainer = document.createElement('div')
  const btnContainer = document.createElement('div')
  const textContainer = document.createElement('div')
  const texto = document.createTextNode(text)
  const buttonAcepter = document.createElement('button')
  buttonAcepter.innerHTML = "Aceptar"
  btnContainer.appendChild(buttonAcepter)
  textContainer.appendChild(texto)
  alertContainer.appendChild(textContainer)
  alertContainer.appendChild(btnContainer)
  alertContainer.classList.add('alert-conatiner')
  document.body.appendChild(alertContainer)
  document.getElementsByClassName('alert-conatiner')[0].childNodes[1].childNodes[0].focus()
  buttonAcepter.addEventListener('click', () => {
    alertContainer.remove()
    document.body.childNodes[1].classList.toggle('filter')
    document.body.childNodes[3].classList.toggle('filter')
    document.body.childNodes[5].classList.toggle('filter')
  })
}