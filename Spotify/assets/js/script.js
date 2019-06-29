var currentPlayList = [];
var shufflePlayList = [];
var tempPlayList = [];
var newPlayList;
var audioElement;
var userLoggedIn;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var timer;


$(window).scroll(function(){
    hideOptionsMenu();
});

$(document).click(function(click){
    var targett= $(click.target);
    if(!targett.hasClass("item") && !targett.hasClass("optionsButton")){
        hideOptionsMenu();
    }
});

$(document).on("change","select.playlist",function(){
    var select = $(this);
    var playlistId = select.val();
    var songId = select.prev(".songId").val();

    $.ajax({
        type:"POST",
        url:"includes/handlers/addToPlaylist.php",
        data:{songId:songId,playlistId:playlistId},
        success:function(date){
            if(date != ""){
                alert(date);
                return;
            }
            hideOptionsMenu();
            select.val("");
        }
    });
});

function openPage(url){
    if(timer != null){
        clearTimeout(timer);
    }
    if(url.indexOf('?') == -1){
        url = url + "?";
    }

    var encodedUrl = encodeURI(url + "&username=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null,null,url);
}

function logout(){
    $.post("includes/handlers/logout.php",function(){
        location.reload();
    })
}

function removeFromPlaylist(button,playlistId){
    var songId = $(button).prevAll(".songId").val();
    $.ajax({
        type:"POST",
        url:"includes/handlers/removeFromPlaylist.php",
        data:{playlistId:playlistId,songId:songId},
        success:function(date){
            if(date != ""){
                alert(date);
                return;
            }
            openPage("playlist.php?id="+playlistId);
        }
    });
}

function hideOptionsMenu(){
    var menu = $('.optionsMenu');
    if(menu.css("display") != "none"){
        menu.css("display","none");
    }
}

function showOptionsMenu(button){
    var songId = $(button).prevAll(".songId").val();
    var menu = $('.optionsMenu');
    var menuWidth = menu.width();
    menu.find(".songId").val(songId);

    var scrollTopp = $(window).scrollTop();
    var offsetElement = $(button).offset().top;
    
    var top = scrollTopp >= offsetElement?scrollTopp - offsetElement:offsetElement - scrollTopp;
    var left = $(button).position().left;

    menu.css({"top":top+"px","left":left - menuWidth +"px","display":"inline"});
}

function createPlaylist(){
    var songAdd = prompt("Please enter the name for your playlist");
    if(songAdd != null){
        $.ajax({
            type:"POST",
            url:"includes/handlers/createPlaylist.php",
            data:{name:songAdd,username:userLoggedIn},
            success:function(date){
                if(date != ""){
                    alert(date);
                    return;
                }
                openPage("yourMusic.php");
            }
        });
    }
}

function deletePlaylist(playlistId){
    var songDel = confirm("Are you sure to delete this playlist?");
    if(songDel != null){
        $.ajax({
            type:"POST",
            url:"includes/handlers/deletePlaylist.php",
            data:{playlistId:playlistId},
            success:function(date){
                if(date != ""){
                    alert(date);
                    return;
                }
                openPage("yourMusic.php");
            }
        });
    }
}

function playFirstSong(){
    setTrack(tempPlayList[0],tempPlayList,true);
}

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

function updateVolumeProgressBar(audio){
    var volume = audio.volume*100;
    $(".volumeBar .progress").css("width",volume+"%");
}

function Audio(){
    this.currentlyPlaying;
    this.audio = document.createElement('audio');
    this.audio.addEventListener("canplay",function(){
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("volumechange",function(){
        updateVolumeProgressBar(this);
    });

    this.setTrack = function(track){
        //this.audio.currentlyPlaying = track;
        this.currentlyPlaying = track;
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