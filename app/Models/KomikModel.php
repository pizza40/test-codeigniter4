<?php namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table = "komik";
    protected $useTimeStamps = true;
    //memberi field yg bisa diisi manual
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul'];

    public function getKomik($slug = false){
        //if slug is empty
        if($slug == false){
            return $this->findAll();
        }
        //if there is a value, return this
        return $this->where(['slug'=> $slug])->first();
    }
}
