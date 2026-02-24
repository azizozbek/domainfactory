<?php

namespace App\Controllers;

use App\Models\DomainModel;
use App\Models\FtpModel;
use App\Services\CacheService;
use App\Services\PleskCreateDomain;
use App\Services\PleskCreateFtp;
use App\Services\PleskCreateWebspace;
use App\Services\PleskGetWebspaces;
use App\Services\PleskRemoveDomain;
use App\View;

class DomainController
{
    private array $errors = [];

    public function index()
    {
        if ($_POST) {
            $this->handleFormSubmission();
        }

        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);

        $view = new View('layout');

        $pleskGetWebSpaces = new PleskGetWebSpaces();
        if (count($pleskGetWebSpaces->webspaces) === 0) {
            $pleskGetWebSpaces->send();
        }
        $domainList = new View('domain_list');
        $domainList->with([
            'list' => $pleskGetWebSpaces->webspaces
        ]);

        $domainForm = new View('domain_form');
        $domainForm->with([
            'errors' => $this->errors,
            'success' => $success,
        ]);

        echo $view->with([
            'domainForm' => $domainForm->render(),
            'domainList' => $domainList->render()
        ]);
    }

    public function refreshDomainList()
    {
        $cacheService = CacheService::getInstance();
        $cacheService->forget("webspaces");

        header('Location: /');
    }

    public function handleFormSubmission(): void
    {
        if ($_POST[DomainModel::DOMAIN_FIELD] === '' || $_POST[FtpModel::FTP_USERNAME_FIELD] === '' || $_POST[FtpModel::FTP_PASSWORD_FIELD] === '') {

            $this->errors = ['All fields are required.'];

            return;
        }

        $domainModel = new DomainModel(domain: $_POST[DomainModel::DOMAIN_FIELD]);
        $ftpModel = new FtpModel(ftp_username: $_POST[FtpModel::FTP_USERNAME_FIELD], ftp_password: $_POST[FtpModel::FTP_PASSWORD_FIELD]);

        $this->errors = array_merge($domainModel->validate(), $ftpModel->validate());
        if (count($this->errors) > 0) {

            return;
        }

        $pleskCreateWebspace = new PleskCreateWebspace(domainModel: $domainModel, ftpModel: $ftpModel);
        $pleskCreateWebspaceResponse = $pleskCreateWebspace->send();
        if (count($pleskCreateWebspaceResponse->errors) > 0) {
            $this->errors = $pleskCreateWebspaceResponse->errors;

            return;
        }

        $_SESSION['success'] = true;
        $this->resetForm();

        header('Location: /');
        exit;
    }

    private function resetForm(): void
    {
        unset($_POST[DomainModel::DOMAIN_FIELD]);
        unset($_POST[FtpModel::FTP_USERNAME_FIELD]);
        unset($_POST[FtpModel::FTP_PASSWORD_FIELD]);

    }
}