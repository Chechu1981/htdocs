"use strict";

export default function updateCounterAssignment(){
  const googles = document.getElementsByClassName('round')
    let CesUser = $('userAssignsready')
    let CesNew = googles[0]
    let CesReady = googles[1] == undefined ? googles[0] : googles[1]
    let CesAll = ''
  if(googles.length > 2){
    CesAll = googles[1]
    CesReady = googles[2]
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
    if(googles.length > 2)
      CesAll.innerHTML = itemsNumbers.todas
  })
}