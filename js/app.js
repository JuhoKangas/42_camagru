const camera_button = document.querySelector("#start-camera");
const video = document.querySelector("#video");
const click_button = document.querySelector("#click-photo");
const canvas = document.querySelector("#canvas");
const stop_button = document.querySelector("#stop-webcam");
const webcam_picture = document.querySelector('#webcam-picture');
const file_input = document.querySelector("#fileToUpload");
const picture = document.querySelector("#picture");

const sticker = document.querySelectorAll(".sticker");

for (let i=0; i<sticker.length; i++) {
	sticker[i].addEventListener('click', e => {
		console.log(e.target.id);

	})
}

file_input.onchange = () => {
	const [file] = file_input.files;
	if (file) {
		picture.src = URL.createObjectURL(file);

		// We have to give it some time to think
		setTimeout(() => {
			let maxDim = 800;
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
				webcam_picture.value = image_data_url;
				picture.remove();
		}, 50);
	}
}

camera_button.addEventListener('click', async () => {
	let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.srcObject = stream;
});

click_button.addEventListener('click', () => {
	if (video.srcObject) {
		canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
		let image_data_url = canvas.toDataURL();
	
		webcam_picture.value = image_data_url;
	}

});

stop_button.addEventListener('click', () => {
	let stream = video.srcObject;
	let tracks = stream.getTracks();

	for (let i = 0; i < tracks.length; i++) {
			let track = tracks[i];
			track.stop();
	}
	video.srcObject = null;

	canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
})