$$('form')[0].addEventListener('submit',(e)=>{
  e.preventDefault();
  e.stopPropagation();
  const data = new FormData()
  data.append('pedido', e.target.childNodes[1].childNodes[1].childNodes[3].value)
  data.append('origen', e.target.childNodes[1].childNodes[3].childNodes[5].value)
  data.append('destino', e.target.childNodes[1].childNodes[3].childNodes[7].value)
  data.append('cliente', e.target.childNodes[1].childNodes[5].childNodes[3].value)
  data.append('ref', e.target.childNodes[1].childNodes[7].childNodes[3].value)
  data.append('cantidad', e.target.childNodes[1].childNodes[9].childNodes[3].value)
  data.append('comentario', e.target.childNodes[1].childNodes[11].childNodes[3].value)
  data.append('nfm', e.target.childNodes[1].childNodes[13].childNodes[3].checked)
  data.append('frag', e.target.childNodes[1].childNodes[15].childNodes[3].checked)
  fetch('../api/addAsignADV2023.php',{
    method: 'POST',
    body: data
  })
  e.target.reset()
})

const refresh = setInterval(function (){
  const data = new FormData()
  data.append('id','new')
  data.append('session',window.location.href.split('=')[1])
  data.append('sort', 'date')
  fetch('../api/getAssigADVSend2023.php',{
    method: 'POST',
    body: data
  })
  .then(e => e.text())
  .then((item) =>{
    const cliente = $('cesiones').innerHTML.split('ul').length
    const servidor = item.split('ul').length
    if(cliente != servidor)
      $('cesiones').innerHTML = item
  })
},1000)

