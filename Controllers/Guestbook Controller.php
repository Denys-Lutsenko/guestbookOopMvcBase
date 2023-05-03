<?php

namespace guestbook\Controllers;

class GuestbookController {

public function execute() {
    // TODO 1: PREPARING ENVIRONMENT: 1) session 2) functions
    session_start();

    $aConfig = require_once 'config.php';

    // TODO 2: ROUTING

    // TODO 3.raw: CODE by REQUEST METHODS (ACTIONS) GET, POST, etc. (handle data from request): 1) validate 2) working with data source 3.raw) transforming data

    // 1. Create empty $infoMessage
    $infoMessage = '';

    // 2. handle form data
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['text'])) {

        // 3. Prepare data
        $aComment = $_POST;
        $aComment['date'] = date('m.d.Y');

        // create new comment
        try {
            $pdo = new \PDO("mysql:host={$aConfig['host']};dbname={$aConfig['name']};charset={$aConfig['charset']}", $aConfig['user'], $aConfig['pass']);

            $stmt = $pdo->prepare("INSERT INTO comments (email, name, text, date) VALUES (:email, :name, :text, :date)");
            $stmt->execute([
                'email' => $aComment['email'],
                'name' => $aComment['name'],
                'text' => $aComment['text'],
                'date' => $aComment['date']
            ]);

            $pdo = null;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            die;
        }

    } elseif (!empty($_POST)) {
        $infoMessage = 'Заполните поля формы!';
    }

    $arguments = [
        'infoMessage' => $infoMessage,
        'aConfig' => $aConfig // добавлено
    ];

    $this->renderView($arguments);
}

public function renderView($arguments = []) {
// TODO 4: RENDER: 1) view (html) 2) data (from php)

?>

<!DOCTYPE html>
<html>

<?php require_once 'ViewSections/sectionHead.php' ?>

<body>

<div class="container">

    <!-- navbar menu -->
    <?php require_once 'ViewSections/sectionNavbar.php' ?>
    <br>

    <!-- guestbook section -->
    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            Guestbook form
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">

                    <!-- form -->
                    <form method="post" name="form" class="fw-bold">
                        <div class="form-group">
                            <label for="exampleInputEmail">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputText">Text</label>
                            <textarea name="text" class="form-control" id="exampleInputText" placeholder="Enter text"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!-- end form -->

                    <br>

                    <?php if (!empty($arguments['infoMessage'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $arguments['infoMessage'] ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

</div>

<?php require_once 'ViewSections/sectionScripts.php' ?>

</body>
    </html>

    <?php
}
}
