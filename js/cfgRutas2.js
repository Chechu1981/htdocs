document.getElementsByClassName('config-routes')[0].addEventListener('click', (e) => {
  const data = new FormData()
  const ruta = e.target.parentNode.parentNode.children[1].innerText
  data.append('id', e.target.parentNode.id)
  data.append('corte', e.target.parentNode.parentNode.children[2].firstChild.value)
  data.append('salida', e.target.parentNode.parentNode.children[3].firstChild.value)
  if(e.target.alt == 'Guardar'){
    fetch('../api/updateRoute.php',{
      method: 'POST',
      body: data
    })
    .then(r => r.text)
    .then(s => {
      notify(`!GUARDADO - ${e.target.parentNode.parentNode.children[1].firstChild.data}!`)
      e.target.parentNode.parentNode.children[2].firstChild.style.backgroundColor = '#ffd3788a'
      e.target.parentNode.parentNode.children[3].firstChild.style.backgroundColor = '#ffd3788a'
    })
  }else if(e.target.alt == 'Eliminar'){
    if(confirm(`Quieres eliminar la ${ruta}`))
    fetch('../api/removeRoute.php',{
      method: 'POST',
      body: data
    })
    .then(r => r.text)
    .then(s => {
      e.target.parentNode.parentNode.remove()
      notify(`!ELIMINADO - ${e.target.parentNode.parentNode.children[1].firstChild.data}!`)
      e.target.parentNode.parentNode.children[2].firstChild.style.backgroundColor = '#ffd3788a'
      e.target.parentNode.parentNode.children[3].firstChild.style.backgroundColor = '#ffd3788a'
    })
  }
})

$('newRoute').addEventListener('click', () =>{
  const form = `
  <ul class="form-addRoute">
    <li>
      <label>Centro</label>
      <select id="centro">
        <option selected >--</option>
        <option value="MAD">MADRID</option>
        <option value="SEV">SEVILLA</option>
        <option value="VIG">VIGO</option>
        <option value="GRA">GRANADA</option>
        <option value="ZAR">ZARAGOZA</option>
        <option value="PAL">PALMA</option>
        <option value="VAL">VALENCIA</option>
        <option value="BAR">BARCELONA</option>
      </select>
    </li>
    <li>
      <label>Nombre ruta</label>
      <input  id="nombre"></input>
    </li>
    <li>
      <label>Hora de corte</label>
      <input id="cutt"></input>
    </li>
    <li>
      <label>Hora de salida</label>
      <input id="salida"></input>
    </li>
    <li>
      <button id="saveNewRoute">Guardar</button>
    </li>
  </ul>
  `
  modal(form,"NUEVA RUTA")
  $('saveNewRoute').addEventListener('click', e =>{
    const centro = $('centro').value
    const nombre = $('nombre').value
    const cutt = $('cutt').value
    const salida = $('salida').value
    const data = new FormData()
    data.append('centro',centro)
    data.append('nombre',nombre)
    data.append('cutt',cutt)
    data.append('salida',salida)
    console.log(centro, nombre, cutt, salida)
    fetch('../api/addRoute.php',{
      method: 'POST',
      body: data
    })
    $('close').click()
  })
})

const buscarRutas = (target,placa) => {
  const data = new FormData()
  data.append('ruta', target)
  data.append('placa', placa)
  fetch('../api/getRoutesFilter.php',{
    method: 'POST',
    body: data
  })
  .then((it) => it.text())
  .then(item => {
    document.getElementsByClassName('config-routes')[0].innerHTML = item
  })
}

$('search-route').addEventListener('keyup',e =>{
  let bototnes = $('buttons_plates').children
  let placa = ''
  for(let btns of bototnes){
    if(btns.classList.contains('active')){
      placa = btns.innerText
      break
    }
  }
  buscarRutas(e.target.value, placa)
})

$('buttons_plates').addEventListener('click', e => {
  let bototnes = $('buttons_plates').children
  for(let btns of bototnes)
    btns.classList.remove('active')
  if(e.target.classList.contains('btn')){
    e.target.classList.toggle('active')
    buscarRutas($('search-route').value,e.target.innerText)
  }
})