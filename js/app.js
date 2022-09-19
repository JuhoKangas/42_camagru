const camera_button = document.querySelector("#start-camera");
const video = document.querySelector("#video");
const click_button = document.querySelector("#click-photo");
const canvas = document.querySelector("#canvas");
const stop_button = document.querySelector("#stop-webcam");

camera_button.addEventListener('click', async () => {
	let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.srcObject = stream;
});

click_button.addEventListener('click', () => {
   	canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
   	let image_data_url = canvas.toDataURL();

   	// data url of the image
   	console.log(image_data_url);
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