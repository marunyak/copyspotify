<?php
    class Playlist{
        private $con;
        private $id;
        private $owner;
        private $name;


        public function __construct($con,$data){
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
    }
?>