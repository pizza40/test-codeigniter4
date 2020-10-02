<?php

namespace App\Controllers;

use App\Models\OrangModel;

class Orang extends BaseController
{
    //all method can use this constructor
    protected $orangModel;
    public function __construct()
    {
        $this->orangModel = new OrangModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') :
        1;

        $data = [
            'title' => 'Daftar Orang',
            // 'orang' => $this->orangModel->findAll()
            'orang' => $this->orangModel->paginate(6, 'orang'),
            'pager' => $this->orangModel->pager,
            'currentPage' =>$currentPage
        ];

        return view('orang/index', $data);
    }
}
