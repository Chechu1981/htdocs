'use strict';

const verTabla = () =>{
  const amperios = $('amperios').value
  const stopStart = $('s&s').checked === true ? 'Option STT possible' : ''
  const normal = $('normal').checked === true ? 'normal' : ''
  $('lblAmp').innerText = `Amperios ${parseInt(amperios) - 5} - ${parseInt(amperios) + 5}`
  const data = new FormData()
  data.append('amperios',amperios)
  data.append('stopStart',stopStart)
  data.append('normal',normal)
  fetch('../api/getBateria.php',{
    method: 'POST',
    body: data
  })
  .then(formato => formato.text())
  .then(result =>{
    $('bat_items').innerHTML = result
  })
}

$('amperios').addEventListener('input', () =>{
  verTabla()
})

$('s&s').addEventListener('change', () =>{
  verTabla()
})

$('normal').addEventListener('change', () =>{
  verTabla()
})

document.addEventListener('click', (texto) =>{
  if(texto.target.className.includes('copy')){
    navigator.clipboard.writeText(texto.target.innerHTML.replaceAll(' ',''))
    notify(`${texto.target.innerText} copiado`)
  }
})