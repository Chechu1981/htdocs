document.getElementsByTagName("form")[0].onsubmit = e => {
  e.preventDefault()
  const key = document.getElementById("passrecovery").value
  const email = window.location.search.split('?mail=')[1]
  const data = new FormData();
  data.append('key', key);
  data.append('email', email);
  fetch('../api/recoverPassKey.php', {
    method: 'POST',
    body: data,
  })
  .then((response) => response.text())
  .then((data) => {
    if (data == "true") {
      window.location.href = `./newPass.php?mail=${email}&key=${key}`
    } else {
      errorText.innerHTML = "Clave inválida"
    }
  })
}