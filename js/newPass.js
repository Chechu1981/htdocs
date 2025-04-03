document.getElementsByTagName("form")[0].onsubmit = e => {
  e.preventDefault()
  const email = window.location.search.split("=")[1].split('&')[0]
  const key = window.location.search.split("&key=")[1]
  const psw1 = e.target.psw1.value
  const psw2 = e.target.psw2.value
  if(psw1.length < 8) {
    return errorText.innerHTML = "La clave debe tener al menos 8 caracteres"
  }
  if( psw1 != psw2){
    return errorText.innerHTML = "Las claves no coinciden"
  }
  const data = new FormData();
  data.append('pass', psw1);
  data.append('key', key);
  data.append('email', email);
  fetch('../api/recoverPass.php', {
    method: 'POST',
    body: data,
  })
  .then((response) => response.text())
  .then((data) => {
    if (data == "true") {
      window.location.href = `../`
    } else {
      errorText.innerHTML = "Ha ocurrido un error"
    }
  })
}