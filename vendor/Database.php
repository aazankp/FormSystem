<?php
class Database{
    private $host_name = "localhost";
    private $rootname = "root";
    private $password = "";
    private $dbname = "formsystem";
    private $conn = null;
    private $query = null;
    private $result = null;

    public function __construct(){
        $this->conn = mysqli_connect($this->host_name, $this->rootname, $this->password, $this->dbname);
        if (mysqli_connect_errno()) {
            die("Connection Failed!");
        }
    }

    public function fetch_country_details($country_id){
        $this->query = "SELECT * FROM countries_details WHERE CountryId='$country_id'";
        $this->result = mysqli_query($this->conn, $this->query);
        return $this->result;
    }

    public function AddPersonData($FirstName, $LastName, $Country, $State, $City, $Gender, $ProfileImg){
        $this->query = "INSERT INTO persondata (FirstName, LastName, Gender, Country, State, City, ProfilePic) values ('$FirstName', '$LastName', '$Gender', '$Country', '$State', '$City', '$ProfileImg')";
        $this->result = mysqli_query($this->conn, $this->query);
        return $this->result;
    }

    public function fetch_PersonsData(){
        $this->query = "SELECT * FROM persondata";
        $this->result = mysqli_query($this->conn, $this->query);
        return $this->result;
    }

    public function fetch_PersonData($PersonId){
        $this->query = "SELECT * FROM persondata WHERE PersonId='$PersonId'";
        $this->result = mysqli_query($this->conn, $this->query);
        return $this->result;
    }

    public function UpdatePersonData($PersonId, $FirstName, $LastName, $Country, $State, $City, $Gender, $ProfileImg) {
        $this->query = "UPDATE persondata SET FirstName='$FirstName', LastName='$LastName', Gender='$Gender', Country='$Country', State='$State', City='$City', ProfilePic='$ProfileImg' WHERE PersonId='$PersonId'";
        $this->result = mysqli_query($this->conn, $this->query);
        return $this->result;
    }

    public function Delete_PersonData($PersonId) {
        $this->query = "DELETE FROM persondata WHERE PersonId='$PersonId'";
        $this->result = mysqli_query($this->conn, $this->query);
        return $this->result;
    }

    
}

?>