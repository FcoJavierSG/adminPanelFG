<?php

namespace App\Http\Controllers;

use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;


class AuthController extends Controller
{
    /**
     * Variable donde se almacena una instancia de Firebase Authentication
     */
    protected $auth;

    /**
     * Constructor por defecto de la clase, en donde inicializamos $auth
     */
    public function __construct(){
       //Iniciamos una instancia con la BD
       $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
       $factory = (new Factory)
           ->withServiceAccount($serviceAccount)
           ->withDatabaseUri('https://futurguide.firebaseio.com/')->createAuth();

       $this->auth = $factory;
    }

   /**
    * Funcion para loguearnos con Firebase y crear variables de sesión que controlaremos en nuestro panel
    *
    */
   public function login()
   {
       $auth = $this->auth;

       $credentials = $this->validate(request(), [
           'email' => 'email|required|string',
           'password' => 'required|string'
       ]);

       //return $credentials['email'];

       try {
           $idToken = $auth->signInWithEmailAndPassword($credentials['email'], $credentials['password'])->idToken();

           try {
               $verifiedToken = $auth->verifyIdToken($idToken);
           } catch (\InvalidArgumentException $e){
               echo 'The token could not be parsed: '.$e->getMessage();
           } catch (InvalidToken $e) {
               echo 'The token is invalid: '.$e->getMessage();
           }

           $uid = $verifiedToken->getClaim('sub');
           $user = $auth->getUser($uid);



           if (isset($user)) {
               session_start();
               $_SESSION['active'] = true;
               $_SESSION['email'] = $user->email;
               $_SESSION['uid'] = $user->uid;

               return redirect('inicio');
           }


       } catch (Auth\SignIn\FailedToSignIn $e) {
           return back()
               ->withErrors(['email' => 'Los datos no coinciden con los de ningún admin'])
               ->withInput(request(['email']));
       }

   }


   /**
    * Funcion para cerrar la sessión
    */
   public function logout(){
       session_start();
       unset($_SESSION['active']);
       unset($_SESSION['email']);
       unset($_SESSION['uid']);
       session_destroy();
       header('Location:' . '/', true, 301);
       exit();
   }

}
