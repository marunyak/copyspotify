var currentlyPlaylist = [];
var audioElement;

function Audio(){
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.setTrack = function(track){
        this.audio.currentlyPlaying = track;
        this.audio.src = track.path;
        this.audio.type = "audio/mpeg";
    }

    this.play = function(){
        this.audio.play();
    }

    this.pause = function(){
        this.audio.pause();
    }
}