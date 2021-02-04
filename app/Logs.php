<?php
namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Logs extends model
{
    protected $connection = 'mongodb';

    protected $table = 'log2';
}
