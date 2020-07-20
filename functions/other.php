<?php
namespace main;

class responses {
    //login
    const user_doesnt_exist = 'user_doesnt_exist';
    const password_is_wrong = 'password_is_wrong';
    const no_active_subscription = 'no_active_subscription';

    //register
    const user_already_exists = 'user_already_exists';
    const not_valid_length = 'not_valid_length';

    //activate
    const license_doesnt_exist = 'license_doesnt_exist';
    const license_was_already_used = 'license_was_already_used';

    //other
    const success = 'success';
}
