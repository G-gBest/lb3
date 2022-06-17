<?php

class Car
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=127.0.0.1;dbname=car", "root", "");
    }

    public function costInDate($date): void
    {
        $statement = $this->db->prepare("SELECT name, date_start, time_start, cost FROM cars INNER JOIN rent ON ID_Cars=FID_Car WHERE ? BETWEEN date_start and date_end");
        $statement->execute([$date]);
        $str = "<table style='text-align: center'>";
        $str .= " <tr>
         <th> Name  </th>
         <th> Cost </th>
        </tr> ";
        while ($data = $statement->fetch()) {
            $cost = (strtotime($date) - strtotime($data["date_start"]."T".$data["time_start"]))/3600*$data["cost"];
            $str .= " <tr>
             <td> {$data['name']}  </td>
             <td> {$cost} </td>
            </tr> ";
        }
        $str .= "</table>";
        echo $str;
    }

    public function carByVendor($vendor): void
    {
        $statement = $this->db->prepare("SELECT name, release_date, race FROM cars WHERE FID_Vendors=?");
        $statement->execute([$vendor]);
        $str = "<table style='text-align: center'>";
        $str .= " <tr>
         <th> Name  </th>
         <th> Release Date </th>
         <th> Race </th>
        </tr> ";
        while ($data = $statement->fetch()) {
            $str .= " <tr>
             <td> {$data['name']}  </td>
             <td> {$data['release_date']} </td>
             <td> {$data['race']} </td>
            </tr> ";
        }
        $str .= "</table>";
        echo json_encode($str);
    }

    public function freeCarInDate($free_car): void
    {
        $statement = $this->db->prepare("SELECT name, release_date, race FROM cars INNER JOIN rent ON ID_Cars=FID_Car WHERE ? NOT BETWEEN date_start and date_end");
        $statement->execute([$free_car]);
        $str = "<table style='text-align: center'>";
        $str .= " <tr>
         <th> Name  </th>
         <th> Release Date </th>
         <th> Race </th>
        </tr> ";
        while ($data = $statement->fetch()) {
            $str .= " <tr>
             <td> {$data['name']}  </td>
             <td> {$data['release_date']} </td>
             <td> {$data['race']} </td>
            </tr> ";
        }
        $str .= "</table>";
        echo $str;
    }
}

$car = new Car();

if (isset($_POST["date"])) {
    $car->costInDate($_POST["date"]);
} elseif (isset($_POST["vendor"])) {
    $car->carByVendor($_POST["vendor"]);
} elseif (isset($_POST["free_car"])) {
    $car->freeCarInDate($_POST["free_car"]);
}