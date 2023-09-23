$$('input')[1].focus()

const findClient = (e,route) => {
  $('route-items').innerHTML = 'buscando... ' + e.target.value
  let data = new FormData();
  data.append('search', e.target.value);
  fetch(`../api/${route}.php`,{
    method: 'POST',
    body: data
    })
  .then(response => response.text())
  .then(datos =>{
    $('route-items').innerHTML = `
    ${datos}`
  })
  .catch(err => console.log("error: "+err))
}

//Show Routes
$$('input')[1].addEventListener('keyup', (e) => {
  findClient(e,'getRoutes')
})

//Show client
$$('input')[2].addEventListener('keyup',e =>{
  findClient(e,'getClient')
})

//Focus on the input
for(let input = 0;input < $$('input').length; input++) {
  $$('input')[input].addEventListener('focus', (e) => {
    e.target.select();
  })
}

$$('input')[1].addEventListener('focus', (e) =>{
  $('search-line-nclient').classList.add('search-focused');
});

$$('input')[1].addEventListener('blur', (e) =>{
  $('search-line-nclient').classList.remove('search-focused');
});
$$('input')[2].addEventListener('focus', (e) =>{
  $('search-line-client').classList.add('search-focused');
});

$$('input')[2].addEventListener('blur', (e) =>{
  $('search-line-client').classList.remove('search-focused');
});

const moveScreen = window.addEventListener('scroll', (e)=>{
  if(window.scrollY >= 100){
    $('contacts').classList.add('search-small')
    $('search-line-client').classList.add('search-line-small')
    $('search-line-nclient').classList.add('search-line-small')
  }else{
    $('contacts').classList.remove('search-small')
    $('search-line-client').classList.remove('search-line-small')
    $('search-line-nclient').classList.remove('search-line-small')
  }
})