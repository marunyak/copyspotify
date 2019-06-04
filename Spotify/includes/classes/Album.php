<?php
    class Album{
        private $con;
        private $id;
        private $title;
        private $artistId;
        private $genre;
        private $artworkPath;


        public function __construct($con,$id){
            $this->id  = $id;
            $this->con = $con;

            $albumQuery = mysqli_query($this->con, "SELECT * FROM albums WHERE id ='{$this->id}'");
            $album      = mysqli_fetch_array($albumQuery);

            $this->artistId    = $album['artist'];
            $this->title       = $album['title'];
            $this->genre       = $album['genre'];
            $this->artworkPath = $album['artworkPath'];
        }

        public function getTitle(){
            return $this->title;
        }

        public function getArtist(){
            return new Artist($this->con, $this->artistId);
        }

        public function getGenre(){
            return $this->genre;
        }

        public function getArtWorkPath(){
            return $this->artworkPath;
        }

        public function getNumberOfSongs(){
            $query = mysqli_query($this->con,"SELECT id FROM songs WHERE album = '{$this->id}'");
            return mysqli_num_rows($query);
        }

        public function getSongsIds(){
            $query = mysqli_query($this->con,"SELECT id FROM songs WHERE album = '{$this->id}' ORDER BY albumOrder ASC");
            $array = [];
            while($row = mysqli_fetch_array($query)){
                array_push($array,$row['id']);
            }
            return $array;
        }
    }
?>