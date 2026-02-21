<?php

namespace App\Controllers;

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
    }
}