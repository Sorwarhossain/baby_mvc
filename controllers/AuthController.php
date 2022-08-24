<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\core\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){



        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request){

        $user = new User();
        if($request->isPost()){
            $user->loadData($request->getBody());

            if($user->validate() && $user->save()){
                // Show success message

                // Redirect users
                Application::$app->response->redirect('/');
            }

            $this->setLayout('auth');
            return $this->render('register', [
                'model' => $user
            ]);
        }

        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }
}