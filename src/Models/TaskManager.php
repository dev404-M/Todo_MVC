<?php
namespace Todo\Models;

use Todo\Models\Todo;
/** Class UserManager **/
class TaskManager {

    private $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function find($name, $list_id)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM Task WHERE name = ? AND list_id = ?");
        $stmt->execute(array(
            $name,
            $list_id
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS,"Todo\Models\Task");

        return $stmt->fetch();
    }

    public function store() {
        $stmt = $this->bdd->prepare("INSERT INTO task(name, list_id) VALUES (?, ?)");
        $stmt->execute(array(
            $_POST["nameTask"],
            $_POST["list_id"]
        ));
    }

    public function getAll($id)
    {
        $stmt = $this->bdd->prepare('SELECT * FROM task WHERE list_id = ?');
        $stmt->execute(array(
            $id
        ));
        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Todo\Models\Task");
    }

}

?>