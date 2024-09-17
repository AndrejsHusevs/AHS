<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;

abstract class Attribute extends Model {

    abstract public function getType();

}
