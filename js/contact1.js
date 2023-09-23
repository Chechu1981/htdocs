$$('input')[1].focus()

//Show Contacts
$$('input')[1].addEventListener('keyup', (e) => {
  $('contacts-items').innerHTML = ''
  let data = new FormData()
  data.append('search', e.target.value)
  fetch('../api/getContacts.php',{
    method: 'POST',
    body: data
  })
  .then(response => response.text())
  .then(datos =>{
      $('contacts-items').innerHTML += datos
  })
  .catch(err => console.log("error: "+err))
});

//Focus on the input
for(let input = 0;input < $$('input').length; input++) {
  $$('input')[input].addEventListener('focus', (e) => {
    e.target.select();
  })
}

$$('input')[1].addEventListener('focus', (e) =>{
  $('search-line').classList.add('search-focused')
});

$$('input')[1].addEventListener('blur', (e) =>{
  $('search-line').classList.remove('search-focused')
});