<?php
	require_once("includes/header.php");
	require_once("functions.php");
?>
<div class="content">

	<div class="web-photo">
    <button id="start-camera">Start Camera</button>
    <video class="d-none" id="video" width="500" height="375" autoplay></video>
    <button id="click-photo">Click Photo</button>
    
    <form action="upload_picture.php" method="post" enctype="multipart/form-data">
      <input name="submit" type="submit" value="Submit">
      <input id="canvas-picture" type="hidden" name="canvas_picture" value="">
    </form>
    
    <button id="clear-img">Clear Selection</button>
    <img id="picture">
    <canvas id="canvas" width="0" height="0"></canvas>
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
const picture = document.querySelector("#picture");

const sticker = document.querySelectorAll(".sticker");

for (let i=0; i<sticker.length; i++) {
	sticker[i].addEventListener('click', e => {
		addSticker(e.target.id);
	})
}

const addSticker = (sticker) => {
	let selectedSticker = document.getElementById(sticker);
	let ctx = canvas.getContext("2d");

	switch (sticker) {
		case "sticker1":
			ctx.drawImage(selectedSticker, 30, 40, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker2":
			ctx.drawImage(selectedSticker, 300, 40, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker3":
			ctx.drawImage(selectedSticker, 30, 300, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker4":
			ctx.drawImage(selectedSticker, 125, 125, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker5":
			ctx.drawImage(selectedSticker, 250, 250, selectedSticker.width, selectedSticker.height)
			break;
	
		default:
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
		canvas.width = 500;
		canvas.height = 375;
		canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
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