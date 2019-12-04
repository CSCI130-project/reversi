<?php
    class Player implements JsonSerializable
    {
        private $username;
        private $password;
        private $firstname;
        private $lastname;
        private $age;
        private $gender;
        private $location;
        private $photo;

        function __construct($username, $password, $firstname, $lastname, $age, $gender, $location, $photo)
        {
            $this->username = $username;
            $this->password = $password;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->age = $age;
            $this->gender = $gender;
            $this->location = $location;
            $this->photo = $photo;
        }
        function jsonSerialize()
        {
            return [
                "username" => $this->username,
                "password" => $this->password,
                "firstname" => $this->firstname,
                "lastname" => $this->lastname,
                "age" => $this->age,
                "gender" => $this->gender,
                "location" => $this->location,
                "photo" => $this->photo
            ];
        }
        function setFirstName($firstname)
        {
            $this->firstname = $firstname;
        }
        function getFirstName()
        {
            return $this->firstname;
        }
        function setLastName($lastname)
        {
            $this->lastname = $lastname;
        }
        function getLastName()
        {
            return $this->lastname;
        }
        function setAge($age)
        {
            $this->age = $age;
        }
        function getAge()
        {
            return $this->age;
        }
        function setGender($gender)
        {
            $this->gender = $gender;
        }
        function getGender()
        {
            return $this->gender;
        }
        function setLocation($location)
        {
            $this->location = $location;
        }
        function getLocation()
        {
            return $this->location;
        }
    }

?>