<?php
namespace App\Http\Controllers;

class ControllerSample extends Controller{
        public function hello($name){
        	  return "Hello  $name" ;
        }

        public function add($a, $b){
            return "A+B=" .$a+$b;
        }
}

?>