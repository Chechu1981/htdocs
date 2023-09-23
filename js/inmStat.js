document.getElementsByTagName('section')[1].addEventListener('click',e =>{
  if(e.target.nodeName.toLowerCase() == 'button'){
    const data = new FormData()
    data.append('placa', e.target.value)
    fetch('../api/getInmStatus.php',{
      method: 'POST',
      body: data
    })
    .then(inm => inm.text())
    .then(status => 
      document.getElementsByTagName('section')[2].innerHTML = status
    )
  }
})