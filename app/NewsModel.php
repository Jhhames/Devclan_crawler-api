<?php
Namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

Class  NewsModel extends Model{
    public function __construct(){

    }

    protected $table = 'news';
}


?>