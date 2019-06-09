var currentlyPlaying = [];
var audioElement;

function Audio(){
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.setTrack = function(src){
        this.audio.src = src;
        this.audio.currentTime = 0;
        this.audio.type = "audio/mpeg";
    }

    this.play = function(){
        this.audio.play();
    }

    this.pause = function(){
        this.audio.pause();
    }
}