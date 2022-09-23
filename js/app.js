const camera_button = document.querySelector("#start-camera");
const video = document.querySelector("#video");
const click_button = document.querySelector("#click-photo");
const canvas = document.querySelector("#canvas");
const stop_button = document.querySelector("#clear-img");
const canvas_picture = document.querySelector('#canvas-picture');
const file_input = document.querySelector("#fileToUpload");
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
			ctx.drawImage(selectedSticker, 500, 40, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker3":
			ctx.drawImage(selectedSticker, 30, 500, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker4":
			ctx.drawImage(selectedSticker, 250, 250, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker5":
			ctx.drawImage(selectedSticker, 500, 500, selectedSticker.width, selectedSticker.height)
			break;
	
		default:
			break;
	}
}

file_input.onchange = () => {
	const [file] = file_input.files;
	if (file) {
		picture.src = URL.createObjectURL(file);
		
		// We have to give it some time to think
		setTimeout(() => {
			let maxDim = 1000;
			if (picture.width > maxDim || picture.height > maxDim) {
					let ratio = picture.width/picture.height;
					if( ratio > 1) {
							picture.width = maxDim;
							picture.height = maxDim/ratio;
							canvas.height = maxDim/ratio;
							canvas.width = maxDim;
						} else {
							picture.width = maxDim*ratio;
							picture.height = maxDim;
							canvas.width = maxDim*ratio;
							canvas.height = maxDim;
					}
				}
				canvas.getContext('2d').drawImage(picture, 0, 0, picture.width, picture.height);
				let image_data_url = canvas.toDataURL();
				canvas_picture.value = image_data_url;
				picture.style.display = "none";
		}, 50);
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