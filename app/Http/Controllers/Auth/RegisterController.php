<?php

namespace App\Http\Controllers\Auth;

use App\ClubModel;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        $clubes = ClubModel::disabled()->get();

        return view('auth.register', [
            'clubes' => $clubes
        ]);
    }

    public function register(Request $request){
        $error      = false;
        $msg        = '';
        $email      = $request->get('email');
        $password   = $request->get('password');
        $club       = $request->get('club');
        $oUser = new User;

        $oUser->email             =  $email;
        $oUser->password         =  \Hash::make($password);
        $oUser->activation_token =  str_random(150);

        $oClub = ClubModel::findOrFail($club);

        /*
        if(!$oClub->tieneDirector()){
            $error = true;
            $msg = 'Club no tiene Director';
        }
        */

        if(!$error){
            $oUser->save();
            $oClub->idUsuario = $oUser->id;
            $oClub->save();

            $data = array(
                'id_club'   => $oClub->id,
                'club'      => $oClub->nombre,
                //'email'     => MiembroModel::directorDeClub($oClub->id)->first()->email,
                'email'  => $email,
                'password'  => $password,
                'token'     => $oUser->activation_token,
                'domain'    => App::make('url')->to('/')
            );

            $message = "Benvenido";
            \Mail::send('emails.RegisterTmpl', $data, function($message) use ($data)
            {
                $message
                    ->to($data['email'], $data['club'])
                    ->subject("Activación de Cuenta - Regional AMCH");
            });
            return redirect('/register')->with(['alert'=>true,'type'=>'success', 'msg'=>'Se ha enviado un E-Mail al director del club '.$data['club'].' para que active el acceso.']);
        }else{
            return redirect('/register')->with(['alert'=>true,'type'=>'danger', 'msg'=> $msg]);
        }
    }
}
