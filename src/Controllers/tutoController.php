<?php

namespace tutoAPI\Controllers;

use tutoAPI\Models\TutoManager;
use tutoAPI\Models\Tuto;
use tutoAPI\Controllers\abstractController;

class tutoController extends abstractController
{

    public function show($id)
    {

        // Données issues du Modèle

        $manager = new TutoManager();

        $tuto = $manager->find($id);

        // Template issu de la Vue

        return $this->jsonResponse($tuto, 200);
    }

    public function index()
    {

        $tutos = [];

        $manager = new TutoManager();

        $tutos = $manager->findAll();

        if (isset($_GET['max']) && !empty($_GET['max'])) {

            if (isset($_GET['start']) && !empty($_GET['start'])) {
                $start = $_GET['start'] ;
                $tutos = array_slice($tutos,$start , intval($_GET['max']));
            } else {
                $tutos = array_slice($tutos,0 , intval($_GET['max']));
            }

        }

        return $this->jsonResponse($tutos, 200);
    }

    public function add()
    {

        $manager = new TutoManager();
        $tuto = new Tuto();

        $tuto->setTitle($_POST['title']);
        $tuto->setDescription($_POST['description']);
        $tuto->setCreatedAt($_POST['createdAt']);

        $createdTuto = $manager->add($tuto);

        return $this->jsonResponse($createdTuto, 201);
    }

    public function edit($id)
    {

        parse_str(file_get_contents('php://input'), $_PATCH);

        $manager = new TutoManager();
        $tuto = $manager->find($id);

        if (isset($_PATCH['title']) && !empty($_PATCH['title'])) {
            $tuto->setTitle($_PATCH['title']);
        }

        if (isset($_PATCH['description']) && !empty($_PATCH['description'])) {
            $tuto->setDescription($_PATCH['description']);
        }

        if (isset($_PATCH['createdAt']) && !empty($_PATCH['createdAt'])) {
            $tuto->setCreatedAt($_PATCH['createdAt']);
        }

        $tuto = $manager->update($tuto);

        return $this->jsonResponse($tuto, 200);
    }

    public function delete($id)
    {

        $manager = new TutoManager();

        $tuto = $manager->delete($id);

        return $this->jsonResponse($tuto, 200);
    }

}