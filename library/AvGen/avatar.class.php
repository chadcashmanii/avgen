<?php
    class AvatarClass extends stdClass {
        protected $dbo = false;
        public  function setDB($databaseObject) {
            $this->dbo = $databaseObject;
        }
    }