<?php 
  $src = "../";
  if(isset($_POST['subfolder']))
    $src = "../..";
?>
<div class="lds-ring">
  <img width="75px" src="<?php echo $src ?>/img/Logo-PPCR-2022.png" alt="PPCR">
  <div></div>
  <div></div>
  <div></div>
  <div></div>
</div>
<style>
  .lds-ring {
  display: inline-block;
  position: relative;
  width: 120px;
  height: 120px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: calc(100vh - (100vh / 2));
  margin: auto;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 90px;
  height: 90px;
  margin: 8px;
  border: 8px solid #2A3E86;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: var(--main-font-color) transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
.lds-ring img{
  position: absolute;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>