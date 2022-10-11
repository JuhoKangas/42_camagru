<?php
	require_once("includes/header.php");
	require_once("functions.php");

  if (empty($_SESSION['logged_in_user'])) {
    header("location: home.php");
    exit;
  }

  $user_images = fetch_user_webcam_images($_SESSION['user_id']);

?>
<div class="content">

  <h2 class="title text-center pt-2 pb-4">New post</h2>

  <div class="webcam-container">
    <p>Select a sticker</p>
    <div class="stickers">
        <img class="sticker" src="../img/stickers/bee_sticker.png" alt="" id="sticker1">
        <img class="sticker" src="../img/stickers/best-mom_sticker.png" alt="" id="sticker2">
        <img class="sticker" src="../img/stickers/corgi_sticker.png" alt="" id="sticker3">
        <img class="sticker" src="../img/stickers/dontworry_sticker.png" alt="" id="sticker4">
        <img class="sticker" src="../img/stickers/yass_sticker.png" alt="" id="sticker5">
    </div>

    <div class="web-photo">
      <div class="webcam">
        <div class="picture-preview">
          <video id="video" width="380" height="285" autoplay></video>
          <canvas class="d-none" id="canvas" width="380" height="285"></canvas>
          <img class="d-none" id="selected-sticker1"></img>
          <img class="d-none" id="selected-sticker2"></img>
          <div class="webcam-bottom">
            <p id="save-photo">save photo</p>
            <button class="btn d-flex align-center" id="click-photo" disabled><img src="../img/icons/add_img.svg" alt=""></button>
            <p id="clear-img">take another</p>
          </div>
        </div>
        <form id="picture-form" action="upload_picture.php" method="post" enctype="multipart/form-data">
          <input id="canvas-picture" type="hidden" name="canvas_picture" value="">
          <input id="c_sticker1" type="hidden" name="sticker1" value="">
          <input id="c_sticker2" type="hidden" name="sticker2" value="">
          <input type="text" name="description" id="picture-description" maxlength="255" placeholder="Image description in 255 characters" required>
        </form>
      </div>
      
      <div class="sidebar">
        <h2 class="mb-4">Previously taken photos:</h2>
        <?php foreach ($user_images as $image): ?>
          <img src="../img/uploads/<?php echo $image['img_name']?>" alt="">
        <?php endforeach; ?>
      </div>
    </div>
    <a style="width: fit-content;" href="upload_file.php">Upload from files here!</a>
  </div>
</div>
<script>
const sticker_selected = false;
const video = document.querySelector("#video");
const click_button = document.querySelector("#click-photo");
const canvas = document.querySelector("#canvas");
const take_another = document.querySelector("#clear-img");
const canvas_picture = document.querySelector('#canvas-picture');
const selected_sticker1 = document.querySelector("#selected-sticker1");
const selected_sticker2 = document.querySelector("#selected-sticker2");
const sticker1 = document.querySelector("#c_sticker1");
const sticker2 = document.querySelector("#c_sticker2");
const save_photo = document.querySelector("#save-photo");
const picture_form = document.querySelector("#picture-form");
const description = document.getElementById("picture-description");

click_button.style.cursor = "not-allowed";

// EVENT LISTENERS
window.addEventListener('load', async () => {
	try {
    await start_video();
  } catch (e) {
    alert("In order to take photos we need your permission to use the webcam");
  }
});

save_photo.addEventListener("click", () => {
  if (canvas_picture.value != "" && description.value != "") {
    picture_form.submit();
  }
})

take_another.addEventListener('click', () => {
  click_button.disabled = true;
  click_button.style.cursor = "not-allowed";
  video.classList.remove("d-none");
  canvas.classList.add("d-none");
  remove_stickers();
	clear_canvas();
  start_video();
})

click_button.addEventListener('click', () => {
	if (video.srcObject) {
    video.classList.add("d-none");
    canvas.classList.remove("d-none");
		canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
		
    let image_data_url = canvas.toDataURL();
		canvas_picture.value = image_data_url;
    close_video();
	}
});

const stickers = document.querySelectorAll(".sticker");
for (let i=0; i<stickers.length; i++) {
	stickers[i].addEventListener('click', e => {
		addSticker(e.target.id);
    click_button.disabled = false;
    click_button.style.cursor = "default";

	})
}

// FUNCTIONS

const addSticker = (sticker) => {
	let selectedSticker = document.getElementById(sticker);
  selected_sticker1.classList.remove("d-none");
  selected_sticker2.classList.remove("d-none");

	switch (sticker) {
		case "sticker1":
      selected_sticker1.src = "../img/stickers/bee_sticker.png";
      sticker1.value = "../img/stickers/bee_webcam.png";
			break;

      case "sticker2":
      selected_sticker2.src = "../img/stickers/best-mom_sticker.png";
      sticker2.value = "../img/stickers/best-mom_webcam.png";
      break;
      
      case "sticker3":
      selected_sticker1.src = "../img/stickers/corgi_sticker.png";
      sticker1.value = "../img/stickers/corgi_webcam.png";
      break;

      case "sticker4":
      selected_sticker2.src = "../img/stickers/dontworry_sticker.png";
      sticker2.value = "../img/stickers/dontworry_webcam.png";
			break;
      
      case "sticker5":
      selected_sticker1.src = "../img/stickers/yass_sticker.png";
      sticker1.value = "../img/stickers/yass_webcam.png";
			break;
	}
}

const remove_stickers = () => {
  selected_sticker1.classList.add("d-none");
  selected_sticker2.classList.add("d-none");
  selected_sticker1.src = '';
  selected_sticker2.src = '';
  sticker1.value = '';
  sticker2.value = '';
}

const clear_canvas = () => {
	canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
	canvas_picture.value = "";
}

const close_video = () => {
  let stream = video.srcObject;
	if (stream) {
		let tracks = stream.getTracks();
	
		for (let i = 0; i < tracks.length; i++) {
				let track = tracks[i];
				track.stop();
		}
		video.srcObject = null;
	}
}

const start_video = async() => {
	let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.srcObject = stream;
}

</script>

<?php require_once("includes/footer.php"); ?>