<?php
    class Playlist{
        private $con;
        private $id;
        private $owner;
        private $name;


        public function __construct($con,$data){

            if(!is_array($data)){
                $query = mysqli_query($con, "SELECT * FROM playlists WHERE id = '$data'");
                $data = mysqli_fetch_array($query);
            }
            $this->con = $con;
            $this->owner = $data['owner'];
            $this->name  = $data['name'];
            $this->id    = $data['id'];
        }

        public function getId(){
            return $this->id;
        }

        public function getName(){
            return $this->name;
            
        }

        public function getOwner(){
            return $this->owner;
        }

        public function getNumberOfSongs(){
            $query = mysqli_query($this->con,"SELECT songId FROM playlistSongs WHERE playlistId = '$this->id'");
            return mysqli_num_rows($query);
        }

        public function getSongsIds(){
            $query = mysqli_query($this->con,"SELECT songId FROM playlistSongs WHERE playlistId = '$this->id' ORDER BY playlistOrder DESC"); 
            $array = [];
            while($row = mysqli_fetch_array($query)){
                array_push($array,$row['songId']);
            }
            return $array;
        }
    }
?>