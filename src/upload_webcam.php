<?php
	require_once("includes/header.php");
	require_once("functions.php");

?>
<div class="content">

	<div class="web-photo">
    <button id="start-camera">Start Camera</button>
    <div class="picture-preview">
      <video class="d-none" id="video" width="500" height="375" autoplay></video>
      <img class="d-none" id="selected-sticker1"></img>
      <img class="d-none" id="selected-sticker2"></img>
    </div>
    <button id="click-photo">Click Photo</button>
    
    <form action="upload_picture.php" method="post" enctype="multipart/form-data">
      <input name="submit" type="submit" value="Submit">
      <input id="canvas-picture" type="hidden" name="canvas_picture" value="">
      <input id="sticker1" type="hidden" name="sticker1" value="">
      <input id="sticker2" type="hidden" name="sticker2" value="">
    </form>
    
    <button id="clear-img">Clear Selection</button>
    <div class="picture-preview">
      <canvas id="canvas" width="0" height="0"></canvas>
      <img class="d-none" id="canvas-sticker1"></img>
      <img class="d-none" id="canvas-sticker2"></img>
    </div>
  </div>

	<a href="upload_file.php">upload from files</a>

  <div class="stickers">
    <img class="sticker" src="../img/stickers/bee_sticker.png" alt="" id="sticker1">
    <img class="sticker" src="../img/stickers/best-mom_sticker.png" alt="" id="sticker2">
    <img class="sticker" src="../img/stickers/corgi_sticker.png" alt="" id="sticker3">
    <img class="sticker" src="../img/stickers/dontworry_sticker.png" alt="" id="sticker4">
    <img class="sticker" src="../img/stickers/yass_sticker.png" alt="" id="sticker5">
  </div>

</div>
<script>
const camera_button = document.querySelector("#start-camera");
const video = document.querySelector("#video");
const click_button = document.querySelector("#click-photo");
const canvas = document.querySelector("#canvas");
const stop_button = document.querySelector("#clear-img");
const canvas_picture = document.querySelector('#canvas-picture');
const selected_sticker1 = document.querySelector("#selected-sticker1");
const selected_sticker2 = document.querySelector("#selected-sticker2");
const canvas_sticker1 = document.querySelector("#canvas-sticker1");
const canvas_sticker2 = document.querySelector("#canvas-sticker2");
const sticker1 = document.querySelector("#sticker1");
const sticker2 = document.querySelector("#sticker2");

const stickers = document.querySelectorAll(".sticker");

for (let i=0; i<stickers.length; i++) {
	stickers[i].addEventListener('click', e => {
		addSticker(e.target.id);
	})
}

const addSticker = (sticker) => {
	let selectedSticker = document.getElementById(sticker);
	let ctx = canvas.getContext("2d");
  selected_sticker1.classList.remove("d-none");
  selected_sticker2.classList.remove("d-none");

	switch (sticker) {
		case "sticker1":
      selected_sticker1.src = "../img/stickers/bee_sticker.png";
      canvas_sticker1.src = "../img/stickers/bee_sticker.png";
      sticker1.value = "../img/stickers/bee_sticker.png";
			break;

      case "sticker2":
      selected_sticker2.src = "../img/stickers/best-mom_sticker.png";
      canvas_sticker2.src = "../img/stickers/best-mom_sticker.png";
      sticker2.value = "../img/stickers/best-mom_sticker.png";
      break;
      
      case "sticker3":
      selected_sticker1.src = "../img/stickers/corgi_sticker.png";
      canvas_sticker1.src = "../img/stickers/corgi_sticker.png";
      sticker1.value = "../img/stickers/corgi_sticker.png";
      break;

      case "sticker4":
      selected_sticker2.src = "../img/stickers/dontworry_sticker.png";
      canvas_sticker2.src = "../img/stickers/dontworry_sticker.png";
      sticker2.value = "../img/stickers/dontworry_sticker.png";
			break;
      
      case "sticker5":
      selected_sticker1.src = "../img/stickers/yass_sticker.png";
      canvas_sticker1.src = "../img/stickers/yass_sticker.png";
      sticker1.value = "../img/stickers/yass_sticker.png";
			break;
	}
}

camera_button.addEventListener('click', async () => {
	video.classList.remove("d-none");
	let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.srcObject = stream;
});

click_button.addEventListener('click', () => {
	if (video.srcObject) {
    canvas_sticker1.classList.remove("d-none");
    canvas_sticker2.classList.remove("d-none");
		canvas.width = 500;
		canvas.height = 375;
		canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
		// canvas.getContext('2d').drawImage(selected_sticker1, 375, 250, 100, 100);
		// canvas.getContext('2d').drawImage(selected_sticker2, 20, 20, 100, 100);
		let image_data_url = canvas.toDataURL();
	
		canvas_picture.value = image_data_url;
	}

});

stop_button.addEventListener('click', () => {
	let stream = video.srcObject;
	if (stream) {
		let tracks = stream.getTracks();
	
		for (let i = 0; i < tracks.length; i++) {
				let track = tracks[i];
				track.stop();
		}
		video.srcObject = null;
	}

	canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
	canvas_picture.value = "";
})
</script>

<?php require_once("includes/footer.php"); ?>