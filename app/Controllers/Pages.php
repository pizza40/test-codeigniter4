<?php namespace App\Controllers;

class Pages extends BaseController
{
	public function index()
	{   
        $data = [
            'title'=> 'Home | CodeIgniter Ravi',
        ];
        return view('pages/home', $data);
    }
    public function about(){
        $data = [
            'title'=> 'About | CodeIgniter Ravi'
        ];
        return view('pages/about', $data);
    }

    public function contact(){
        $data = [
            'title'=> 'Contact Us | CodeIgniter Ravi',
            'alamat'=> [
                [
                    'tipe' => 'rumah',
                    'alamat'=> 'jalan jalan yuk',
                    'kota'=> 'sukabumi'
                ],
                [
                    'tipe' => 'kantor',
                    'alamat' => 'jalan Uwu',
                    'kota' => 'jakarta'
                ]
            ]
        ];
        return view('pages/contact', $data);
    }

	//--------------------------------------------------------------------

}
