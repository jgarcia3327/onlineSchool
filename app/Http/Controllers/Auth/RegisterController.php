<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use App\Models\Teacher;
use App\Models\Student;
use App\Http\Controllers\MailController;
use Carbon\Carbon;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile/create';

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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Student::create([
          'user_id' => $user->id,
          'fname' => $data['fname'],
          'lname' => $data['lname'],
          'gender' => $data['gender'],
          'skype' => $data['skype'],
          'contact' => $data['contact'],
          'address' => $data['address']
        ]);

        //Send email to student
        $subject = "EnglishHours.net Registration";
        $body = "Dear ".ucfirst($data['fname']).", \n\nThank you for registering with us. \n\nFrom EnglishHours.net Team";
        MailController::sendMail($data['email'], $subject, $body);
        //Send email to admin
        MailController::sendMail("info@englishhours.net", "Student Registration", "Dear EnglishHours Admin,\n\n".ucfirst($data['fname'])." ".ucfirst($data['lname'])." (".$data['email'].") has successfully registered as Student.\n\nEnglishHours.net");

        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        //return $request;
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return redirect('/profile');
    }

    protected function createTeacher(array $data)
    {

        $user = User::create([
            'is_student' => 0,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Teacher::create([
          'user_id' => $user->id,
          'fname' => $data['fname'],
          'lname' => $data['lname'],
          'gender' => $data['gender'],
          'skype' => $data['skype'],
          'contact' => $data['contact'],
          'address' => $data['address'],
          'esl_experience' => $data['esl_experience']
        ]);

        //Send email to student
        $subject = "EnglishHours.net Teacher Registration";
        $body = "Dear ".ucfirst($data['fname']).", \n\nThank you for registering with us. \n\nFrom EnglishHours.net Team";
        MailController::sendMail($data['email'], $subject, $body);
        //Send email to admin
        MailController::sendMail("info@englishhours.net", "Teacher Registration", "Dear EnglishHours Admin,\n\n".ucfirst($data['fname'])." ".ucfirst($data['lname'])." (".$data['email'].") has successfully registered as Teacher.\n\nEnglishHours.net");

        return $user;
    }

    public function registerTeacher(Request $request)
    {
        $this->validator($request->all())->validate();
        //return $request;
        event(new Registered($user = $this->createTeacher($request->all())));

        $this->guard()->login($user);

        return redirect('/teacherProfile');
    }

}
