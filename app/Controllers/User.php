<?php namespace App\Controllers;
use App\Models\Usermodel;
use CodeIgniter\Controller;
class User extends BaseController
{
    protected $usermodel;
    public function __construct()
    {
        \Config\Services::session();
        $this->Usermodel = new Usermodel();
    }



    public function index()
    {
        $model = $this->Usermodel->testodbc();
        var_dump($model);
        // return view('headers/header');
    }


    public function test()
    {   
        // $_SESSION['cid'] = 'apk456';
        $model = $this->Usermodel->getdata();
        var_dump($model);
    }
    public function test1()
    {   
        echo $_SESSION['ccid'];
        $model = $this->Usermodel->getsingledata();
        var_dump($model);
    }
    public function test2()
    {   
        $model = $this->Usermodel->insertdata('abab');
        var_dump($model);
    }
    public function test3()
    {   
        $model = $this->Usermodel->updatedata();
        var_dump($model);
    }
}
