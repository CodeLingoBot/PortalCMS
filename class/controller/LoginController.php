<?php

/**
 * LoginController
 * Controls everything that is authentication-related
 */
class LoginController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class. The parent::__construct thing is necessary to
     * put checkAuthentication in here to make an entire controller only usable for logged-in users (for sure not
     * needed in the LoginController).
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index, default action (shows the login form), when you do login/index
     */
    public static function index()
    {
        // if user is logged in redirect to main-page, if not show the view
        if (!LoginModel::isUserLoggedIn()) {
            // $data = array('redirect' => Request::get('redirect') ? Request::get('redirect') : NULL);
            // $this->View->render('login/index', $data);
            Redirect::redirectPage('login/login.php');
        } else {
            Redirect::home();
        }
    }

    /**
     * The login action, when you do login/login
     */
    public static function loginWithPassword()
    {
        // check if csrf token is valid
        if (!Csrf::isTokenValid()) {
            LoginModel::logout();
            Redirect::home();
            return false;
        }

        // perform the login method, put result (true or false) into $login_successful
        $login_successful = LoginModel::loginWithPassword(
            Request::post('user_name'), Request::post('user_password'), Request::post('set_remember_me_cookie')
        );

        // check login status: if true, then redirect user to user/index, if false, then to login form again
        if ($login_successful) {
            if (Request::post('redirect')) {
                Redirect::toPreviousViewedPageAfterLogin(ltrim(urldecode(Request::post('redirect')), '/'));
                return true;
            }
            Redirect::home();
            return true;
        }
        if (Request::post('redirect')) {
            Redirect::redirectPage('login/login.php?redirect='.ltrim(urlencode(Request::post('redirect')), '/'));
            return false;
        }
        Redirect::redirectPage('login/login.php');
        return false;
    }

    /**
     * Login with cookie
     */
    public function loginWithCookie()
    {
        $login_successful = LoginModel::loginWithCookie(Request::cookie('remember_me'));
        if ($login_successful) {
            Redirect::home();
        } else {
            // if not, delete cookie (outdated? attack?) and route user to login form to prevent infinite login loops
            LoginModel::deleteCookie();
            Redirect::redirectPage('login/index.php');
        }
    }

    /**
     * Login with Facebook
     */
    public static function loginWithFacebook($fbid)
    {
        $login_successful = LoginModel::loginWithFacebook($fbid);
        if ($login_successful) {
            if (Request::post('redirect')) {
                Redirect::toPreviousViewedPageAfterLogin(ltrim(urldecode(Request::post('redirect')), '/'));
                exit();
            }
            Redirect::home();
            exit();
        }
        if (Request::post('redirect')) {
            Redirect::redirectPage('login/login.php?redirect='.ltrim(urlencode(Request::post('redirect')), '/'));
            exit();
        }
        Redirect::redirectPage('login/login.php');
        exit();
    }

    /**
     * The logout action
     * Perform logout, redirect user to main-page
     */
    public static function logout()
    {
        LoginModel::logout();
        Redirect::home();
        exit();
    }

}