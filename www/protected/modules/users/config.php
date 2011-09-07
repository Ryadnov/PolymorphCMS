<?php
return array('users'=>array(
    'class'=>'modules.users.UsersModule',
    'tableUsers' => 'users',
    'tableProfiles' => 'profiles',
    'tableProfileFields' => 'profiles_fields',
    'sendActivationMail' => false,
    'loginNotActiv' => true,
    'activeAfterRegister' => true,
    'isRegistrationClose' => false,
));
