<?php

// Definitions
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as Model;

// Database Capsule
$capsule = new Capsule;
$capsule->addConnection(array(
  'driver'    => 'mysql',
  'host'      => DB_HOST,
  'database'  => DB_NAME,
  'username'  => DB_USERNAME,
  'password'  => DB_PASSWORD,
  'charset'   => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix'    => '',
));
$capsule->bootEloquent();

// A Resource
class Resource extends Model {

  protected $table = 'resource';
  public $timestamps = false;

  public function relation1() {
    return $this->hasMany('ClassName', 'fk_column_name');
  }

  public function relation2() {
    return $this->belongsTo('relation2');
  }

}

?>
