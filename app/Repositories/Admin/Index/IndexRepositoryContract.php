<?php
namespace App\Repositories\Admin\Index;

interface IndexRepositoryContract{

    public function verifyUser($username);

    public function isAdmin();

    public function getUserMenu($uid);

    public function getUserRole($uid);

    public function getSessionAdminVal($var);

    public function getUserRoute($uid);

    public function getAllRoute();


}