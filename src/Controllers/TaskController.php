<?php

namespace Todo\Controllers;

use Todo\Models\TaskManager;
use Todo\Validator;

class TaskController {
    private $manager;
    private $validator;

    public function __construct()
    {
        $this->manager = new TaskManager();
        $this->validator = new Validator();
    }
    public function index() {
        require VIEWS . 'Todo/homepage.php';
    }
    public function store(){
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
            
        }
        echo 'test';
       // $this->validator->validate([
       //     "name"=>["required", "min:2", "alphaNumDash"]
       // ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTask"], $_POST['list_id']);

            if (empty($res)) {
                $this->manager->store();
                header("Location: /dashboard/". $_POST["nameList"]);
            } else {
                $_SESSION["error"]['name'] = "Le nom de la task est déjà utilisé !";
                header("Location: /dashboard/nouveau");
            }
        }
    }
    /*
    public function showAll() {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $tasks = $this->manager->getAll();

        require VIEWS . 'Todo/index.php';
    }
*/
    public function show($slug) {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $todo = $this->manager->find($slug, $_SESSION["user"]["id"]);
        if (!$todo) {
            header("Location: /error");
        }
        require VIEWS . 'Todo/show.php';
    }
}