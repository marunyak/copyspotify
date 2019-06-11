var currentlyPlaylist = [];
var audioElement;
var mouseDown = false;

function formatTime(seconds){
    var time = Math.round(seconds);
    var minutes = Math.floor(time/60);
    var seconds = time - (minutes*60);
    var zero = seconds < 10?"0":"";
    return minutes + ":" + zero + seconds;
}

function updateTimeProgressBar(audio){
    $('.progressTime.current').text(formatTime(audio.currentTime));
    $('.progressTime.remaining').text(formatTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime/audio.duration*100;
    $(".playbackBar .progress").css("width",progress+"%");
}

function Audio(){
    this.currentlyPlaying;
    this.audio = document.createElement('audio');
    this.audio.addEventListener("canplay",function(){
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.setTrack = function(track){
        this.audio.currentlyPlaying = track;
        this.audio.src = track.path;
        this.audio.type = "audio/mpeg";
    }

    this.audio.addEventListener("timeupdate",function(){
        if(this.duration){
            updateTimeProgressBar(this);
        }
    });

    this.play = function(){
        this.audio.play();
    }

    this.pause = function(){
        this.audio.pause();
    }

    this.setTime = function(time){
        this.audio.currentTime = time;
    }
}