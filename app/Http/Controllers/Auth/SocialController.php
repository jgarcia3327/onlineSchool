<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialController extends Controller
{
  protected $providers = [
      'facebook' => FacebookServiceProvider::class,
  ];

  /**
   *  Create a new controller instance
   *
   * @return  void
   */
  public function __construct()
  {
      $this->middleware('guest');
  }

  /**
   *  Redirect the user to provider authentication page
   *
   *  @param  string $driver
   *  @return \Illuminate\Http\Response
   */
  public function redirectToProvider($driver)
  {
      return (new $this->providers[$driver])->redirect();
  }

  /**
   *  Handle provider response
   *
   *  @param  string $driver
   *  @return \Illuminate\Http\Response
   */
  public function handleProviderCallback($driver)
  {
      try {
          return (new $this->providers[$driver])->handle();
      } catch (InvalidStateException $e) {
          return $this->redirectToProvider($driver);
      } catch (ClientException $e) {
          return $this->redirectToProvider($driver);
      } catch (CredentialsException $e) {
          return $this->redirectToProvider($driver);
      }
  }
}
