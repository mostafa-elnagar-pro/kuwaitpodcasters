const video = document.getElementById('myVideo');
const playPauseBtn = document.getElementById('playPauseBtn');
const seekBar = document.getElementById('seekBar');
const currentTimeDisplay = document.getElementById('currentTime');
const durationDisplay = document.getElementById('duration');
const muteBtn = document.getElementById('muteBtn');
const volumeBar = document.getElementById('volumeBar');
const fullScreenBtn = document.getElementById('fullScreenBtn');

function togglePlayPause() {
    if (video.paused) {
        video.play();
        playPauseBtn.innerHTML = '<i class="fa-solid fa-pause"></i>';
    } else {
        video.pause();
        playPauseBtn.innerHTML = '<i class="fa-solid fa-play"></i>';
    }
}

function updateSeekBar() {
    seekBar.value = (video.currentTime / video.duration) * 100;
    const minutes = Math.floor(video.currentTime / 60);
    const seconds = Math.floor(video.currentTime % 60);
    currentTimeDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
}

function seekVideo() {
    video.currentTime = (seekBar.value / 100) * video.duration;
}

function updateVolume() {
    video.volume = volumeBar.value;
}

function toggleMute() {
    if (video.muted) {
        video.muted = false;
        muteBtn.innerHTML = '<i class="fa-solid fa-volume-high"></i>';
    } else {
        video.muted = true;
        muteBtn.innerHTML = '<i class="fa-solid fa-volume-xmark"></i>';
    }
}

function updateDuration() {
    const minutes = Math.floor(video.duration / 60);
    const seconds = Math.floor(video.duration % 60);
    durationDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
}

function toggleFullScreen() {
    if (video.requestFullscreen) {
        video.requestFullscreen();
    } else if (video.mozRequestFullScreen) { // Firefox
        video.mozRequestFullScreen();
    } else if (video.webkitRequestFullscreen) { // Chrome, Safari and Opera
        video.webkitRequestFullscreen();
    } else if (video.msRequestFullscreen) { // IE/Edge
        video.msRequestFullscreen();
    }
}

playPauseBtn.addEventListener('click', togglePlayPause);
video.addEventListener('timeupdate', updateSeekBar);
seekBar.addEventListener('input', seekVideo);
volumeBar.addEventListener('input', updateVolume);
muteBtn.addEventListener('click', toggleMute);
video.addEventListener('loadedmetadata', updateDuration);
fullScreenBtn.addEventListener('click', toggleFullScreen);
