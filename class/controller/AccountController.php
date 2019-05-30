<?php
class AccountController extends Controller
{
    public function __construct() {
        if (isset($_POST['changeUsername'])) {
            User::editUserName($_POST['user_name']);
        }
        if (isset($_POST['changepassword'])) {
            Password::changePassword(Session::get('user_name'), $_POST['currentpassword'], $_POST['newpassword'], $_POST['newconfirmpassword']);
        }
        if (isset($_POST['clearUserFbid'])) {
            User::clearFbid();
        }
    }
}