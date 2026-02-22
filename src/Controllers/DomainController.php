<?php

namespace App\Controllers;

use App\Models\DomainModel;
use App\Services\PleskCreateDomain;
use App\View;

class DomainController
{
    public function index()
    {
        $view = new View('layout');
        $domainForm = new View('domain_form');
        $domainList = new View('domain_list');

        echo $view->with([
            'domainForm' => $domainForm->render(),
            'domainList' => $domainList->render()
        ]);
    }

    public function handleFormSubmission()
    {
        $errors = [];

        $domainModel = new DomainModel(
            domain: $_POST['domain'],
            ftp_username: $_POST['ftp_username'],
            ftp_password: $_POST['ftp_password']
        );

        $validate = $domainModel->validate();
        if ($validate) {
            $pleskCreateDomain = new PleskCreateDomain(domainModel: $domainModel); //todo
        }

        return $errors;
    }
}