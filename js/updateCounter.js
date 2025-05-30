"use strict";

export default function updateCounterAssignment(){
  const googles = document.getElementsByClassName('round')
    let CesUser = googles[0]
    let CesNew = googles[1]
    let CesReady = googles[2] == undefined ? googles[1] : googles[2]
    let CesAll = ''
  if(googles.length > 3){
    CesAll = googles[2]
    CesReady = googles[3]
  }
  const data = new FormData()
  data.append('id', getIdByCookie(document.cookie))
  fetch('../../api/updateCounterAssig.php',{
    method: 'POST',
    body: data
  })
  .then(numbers => numbers.json())
  .then(itemsNumbers =>{
    CesNew.innerHTML = itemsNumbers.nuevas > 99 ? '+99' : itemsNumbers.nuevas
    CesReady.innerHTML = itemsNumbers.enCurso > 99 ? '+99' : itemsNumbers.enCurso
    if(googles.length > 3)
      CesAll.innerHTML = itemsNumbers.todas
  })
}