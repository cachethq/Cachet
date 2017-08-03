<?php
namespace CachetHQ\Cachet\Http\Controllers;

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


use CachetHQ\Cachet\Bus\Events\User\UserFailedTwoAuthEvent;
use CachetHQ\Cachet\Bus\Events\User\UserLoggedInEvent;
use CachetHQ\Cachet\Bus\Events\User\UserLoggedOutEvent;
use CachetHQ\Cachet\Bus\Events\User\UserPassedTwoAuthEvent;
use GrahamCampbell\Binput\Facades\Binput;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Vendor\Laravel\Facade as Google2FA;
use CachetHQ\Cachet\Models\User;
use Illuminate\Session\FileSessionHandler;
use Illuminate\Filesystem\Filesystem;

class AuthController extends Controller
{
    
        /**Shows the login view.
         *
         * @return \Illuminate\View\View
         */
       public function showLogin()
         {
            return View::make('auth.login')
                 ->withPageTitle(trans('dashboard.login.login'));
        }
 
        /**
         * Logs the user in.
        *
         * @return \Illuminate\Http\RedirectResponse
      */
    public function postLogin()
         {
         $loginData = Binput::only(['username', 'password']);
        // Login with username or email.
        $loginKey = Str::contains($loginData['username'], '@') ? 'email' : 'username';
        $loginData[$loginKey] = array_pull($loginData, 'username');

        // Validate login credentials.
        if (Auth::validate($loginData)) {
            // Log the user in for one request.
            Auth::once($loginData);
            // Do we have Two Factor Auth enabled?
            if (Auth::user()->hasTwoFactor) {

                // Temporarily store the user.
                Session::put('2fa_id', Auth::user()->id);

                return cachet_redirect('auth.two-factor');
            }

            // We probably want to add support for "Remember me" here.
            Auth::attempt($loginData);

            event(new UserLoggedInEvent(Auth::user()));

            return Redirect::intended('dashboard');
        }

        return cachet_redirect('auth.login')
            ->withInput(Binput::except('password'))
            ->withError(trans('forms.login.invalid'));
    }

    /**
     * Shows the two-factor-auth view.
     *
     * @return \Illuminate\View\View
     */
    public function showTwoFactorAuth()
    {
        return View::make('auth.two-factor-auth');
    }
    
     /**
     * Function to add TwoFactor Google Auth to an existing user
     **/
     
     public function generateSecretKey(){
         
         $user = User::find(1);
        
         $key = Google2FA::generateSecretKey();
         $user->google_2fa_secret=$key;

         $user->update();


     }
     
    /**
     * function to show qr code for 2fa auth
     * 
     *  @return \Illuminate\View\View
     **/
    public function showQrCode(){

        $session = Session::getFacadeRoot();
    

       if ($userId = $session->pull('2fa_id')) {
            // Maybe a temp login here.
            
            $secret = Binput::get('secret');
            Auth::loginUsingId($userId);
            $user = Auth::user();
            
            $google2fa_url = Google2FA::getQRCodeGoogleUrl(
                                        'Cachet',
                                        $user->email,
                                        $user->get2faSecretKey()
                                        );
        return View::make('auth.two-factor-auth-code', array(
            'google_2fa_url' => $google2fa_url)
            );
       }
       
               return Redirect::route('auth.login')->withError(trans('forms.login.invalid-token'));

    
     }
     



    /**
     * Validates the Two Factor token.
     *
     * This feels very hacky, but we have to juggle authentication and codes.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTwoFactor()
    {
        // Check that we have a session.

        $session = Session::getFacadeRoot();
    
       if ($userId = $session->pull('2fa_id')) {
            $code = Binput::get('code');

           Auth::loginUsingId($userId);
            $valid = Google2FA::verifyKey(Auth::user()->google_2fa_secret, $code);
            if ($valid) {
                event(new UserPassedTwoAuthEvent(Auth::user()));
                event(new UserLoggedInEvent(Auth::user()));
                return Redirect::intended('dashboard');
            } else {
                event(new UserFailedTwoAuthEvent(Auth::user()));
                // Failed login, log back out.
                Auth::logout();
                return cachet_redirect('auth.login')->withError(trans('forms.login.invalid-token'));
            }
       }
        
        return cachet_redirect('auth.login')->withError(trans('forms.login.invalid-token'));
    }
     
        /**
         * Logs the user out, deleting their session etc.
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function logoutAction()
        {
            event(new UserLoggedOutEvent(Auth::user()));
    
            Auth::logout();
    
            return Redirect::to('/');
        }

    }
