<?php
    class Artist{
        private $con;
        private $id;
        private $name;

        public function __constructor($con,$id){
            $this->con = $con;
            $this->id = $id;
        }

        public function getName(){
            $artistQuery = mysqli_query($this->con, "SELECT * FROM artists WHERE id ='{$this->id}'");
            $artist      = mysqli_fetch_array($artistQuery);
            return $artist['name'];
        }
    }
?>