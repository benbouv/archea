/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

function switchDiv() {
    var div1 = document.getElementById("login");
    var div2 = document.getElementById("register");
    if (div1.style.display === "none") {
        div1.style.display = "block";
        div2.style.display = "none";
    } else {
        div1.style.display = "none";
        div2.style.display = "block";
    }
}
window.switchDiv = switchDiv;

// initialize the map
var map = L.map('map').setView([48.8566, 2.3522], 13); // Paris coordinates (latitude, longitude)

// add the tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
  maxZoom: 19,
}).addTo(map);

const video = document.getElementById('video');
const videoWrapper = document.getElementById('video-wrapper');
const canvas = document.getElementById('canvas');
const startButton = document.getElementById('startButton');
const captureButton = document.getElementById('captureButton');
const constraints = {
    video: {
    width: window.innerWidth,
    height: window.innerHeight,
    }
};

canvas.height = window.innerHeight
canvas.width = window.innerWidth

// Request permission to access the camera
async function startCamera() {
    try {
    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    handleSuccess(stream);
    } catch (e) {
    console.error('Error accessing media devices.', e);
    }
}

// Attach the camera stream to the video element
function handleSuccess(stream) {
    video.srcObject = stream;
}

// Capture a still image from the video stream
function captureImage() {
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    const image = canvas.toDataURL('image/png');
    // Send the image to the server for processing
    console.log(image);
    // Stop the video stream
    const tracks = video.srcObject.getVideoTracks();
    tracks[0].stop();
    // Hide the video element and show the canvas element
    // video.style.display = 'none';
    videoWrapper.style.display = 'none'
    canvas.style.display = 'block';
}

startButton.addEventListener('click', () => {
    startCamera();
    startButton.disabled = true;
    captureButton.disabled = false;
    videoWrapper.style.display = "block";
});

captureButton.addEventListener('click', () => {
    captureImage();
    startButton.replaceWith(captureButton);
});

// initialize the map
// var map = L.map('map').setView([48.8566, 2.3522], 13); // Paris coordinates (latitude, longitude)

// // add the tile layer
// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
//     maxZoom: 19,
// }).addTo(map);

// const video = document.getElementById('video');
// const videoWrapper = document.getElementById('video-wrapper');
// const canvas = document.getElementById('canvas');
// const startButton = document.getElementById('startButton');
// const captureButton = document.getElementById('captureButton');
// const constraints = {
//     video: {
//     width: window.innerWidth,
//     height: window.innerHeight,
//     }
// };

// canvas.height = window.innerHeight
// canvas.width = window.innerWidth

// // Request permission to access the camera
// async function startCamera() {
//     try {
//     const stream = await navigator.mediaDevices.getUserMedia(constraints);
//     handleSuccess(stream);
//     } catch (e) {
//     console.error('Error accessing media devices.', e);
//     }
// }

// // Attach the camera stream to the video element
// function handleSuccess(stream) {
//     video.srcObject = stream;
// }

// // Capture a still image from the video stream
// function captureImage() {
//     canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
//     const image = canvas.toDataURL('image/png');
//     // Send the image to the server for processing
//     console.log(image);
//     // Stop the video stream
//     const tracks = video.srcObject.getVideoTracks();
//     tracks[0].stop();
//     // Hide the video element and show the canvas element
//     // video.style.display = 'none';
//     videoWrapper.style.display = 'none'
//     canvas.style.display = 'block';
// }

// startButton.addEventListener('click', () => {
//     startCamera();
//     startButton.disabled = true;
//     captureButton.disabled = false;
// });

// captureButton.addEventListener('click', () => {
//     captureImage();
//     startButton.replaceWith(captureButton);
// });
