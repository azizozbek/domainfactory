<?php

namespace App\Controllers;

use App\Models\DomainModel;
use App\Models\FtpModel;
use App\Services\PleskCreateDomain;
use App\Services\PleskCreateFtp;
use App\Services\PleskRemoveDomain;
use App\View;

class DomainController
{
    private array $errors = [];
    private bool $success = false;

    public function index()
    {
        if ($_POST) {
            $this->handleFormSubmission();
        }

        $view = new View('layout');
        $domainList = new View('domain_list');

        $domainForm = new View('domain_form');
        $domainForm->with([
            'errors' => $this->errors,
            'success' => $this->success,
        ]);

        echo $view->with([
            'domainForm' => $domainForm->render(),
            'domainList' => $domainList->render()
        ]);
    }

    public function handleFormSubmission(): void
    {
        if ($_POST['domain'] === '' || $_POST['ftp_username'] === '' || $_POST['ftp_password'] === '') {

            $this->errors = ['All fields are required.'];

            return;
        }

        $domainModel = new DomainModel(domain: $_POST['domain']);
        $ftpModel = new FtpModel(ftp_username: $_POST['ftp_username'], ftp_password: $_POST['ftp_password']);

        $this->errors = array_merge($domainModel->validate(), $ftpModel->validate());
        if (count($this->errors) > 0) {

            return;
        }

        $pleskCreateDomain = new PleskCreateDomain(domainModel: $domainModel); //todo
        $pleskCreateDomainResponse = $pleskCreateDomain->send();
        if (count($pleskCreateDomainResponse->errors) > 0) {
            $this->errors = $pleskCreateDomainResponse->errors;

            return;
        }

        if ($pleskCreateDomainResponse->success) {
            $pleskCreateFtp = new PleskCreateFtp(
                ftpModel: $ftpModel,
                domainModel: $domainModel,
                webspaceId: $pleskCreateDomain->webspaceId
            );

            $pleskCreateFtpResponse = $pleskCreateFtp->send();
            if (count($pleskCreateFtpResponse->errors) > 0) {

                //rollback
                $pleskRemoveDomain = new PleskRemoveDomain($domainModel, $pleskCreateDomain->webspaceId);
                $pleskRemoveDomainResponse = $pleskRemoveDomain->send();
                $this->errors = array_merge($pleskCreateFtpResponse->errors, $pleskRemoveDomainResponse->errors);

                return;
            }
        }

        $this->success = true;
    }
}