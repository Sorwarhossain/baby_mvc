<?php

namespace App\Controllers;

use App\Core\Controller;
use App\core\Request;

class SiteController extends Controller
{

    public function home(){
        $params = [
            'name' => "Baby MVC"
        ];

        return $this->render('home', $params);
    }

    public function contact(){
        return $this->render('contact');
    }

    public function handleContact(Request $request){

        $body = $request->getBody();

        echo "<pre>";
        echo var_dump($body);
        echo "<pre>";
        return 'Handling submitted data';
    }
}