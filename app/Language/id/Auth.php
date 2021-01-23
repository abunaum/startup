<?php

return [
    // Exceptions
    'invalidModel'              => 'The {0} model must be loaded prior to use.',
    'userNotFound'              => 'Unable to locate a user with ID = {0, number}.',
    'noUserEntity'              => 'User Entity must be provided for password validation.',
    'tooManyCredentials'        => 'You may only validate against 1 credential other than a password.',
    'invalidFields'             => 'The "{0}" field cannot be used to validate credentials.',
    'unsetPasswordLength'       => 'anda harus melihat setting `minimumPasswordLength` pada Auth config file.',
    'unknownError'              => 'Sorry, we encountered an issue sending the email to you. Please try again later.',
    'notLoggedIn'               => 'You must be logged in to access that page.',
    'notEnoughPrivilege'        => 'You do not have sufficient permissions to access that page.',

    // Registration
    'registerDisabled'          => 'Maaf, Akun baru di tutup sementara.',
    'registerSuccess'           => 'Akun berhasil di daftarkan! Silahkan login.',
    'registerCLI'               => 'Akun baru di buat: {0}, #{1}',

    // Activation
    'activationNoUser'          => 'Unable to locate a user with that activation code.',
    'activationSubject'         => 'Aktivasi akun anda',
    'activationSuccess'         => 'Silahkan konfirmasi dengan mengklik tautan yang sudah di kirim.',
    'activationResend'          => 'Kirim aktivasi sekali lagi.',
    'notActivated'              => 'Akun ini belum di aktifkan.',
    'errorSendingActivation'    => 'Gagal mengirim pesan kepada : {0}',

    // Login
    'badAttempt'                => 'Gagal login. Email atau username tidak terdaftar',
    'loginSuccess'              => 'Selamat datang!',
    'invalidPassword'           => 'Gagal login. Password tidak sesuai.',

    // Forgotten Passwords
    'forgotDisabled'            => 'Resset password tidak bisa di lakukan.',
    'forgotNoUser'              => 'Email ini belum di daftarkan.',
    'forgotSubject'             => 'Intruksi Password Reset',
    'resetSuccess'              => 'Password anda berhasil di ubah. Silahkan login dengan password baru.',
    'forgotEmailSent'           => 'Kode token telah di kirim. Masukkan kode token untuk melanjutkan.',
    'errorEmailSent'            => 'Gagal mengirim intruksi reset password ke : {0}',

    // Passwords
    'errorPasswordLength'       => 'Minimal password harus {0, number} karakter.',
    'suggestPasswordLength'     => 'Maksimal password sampai 255 karakter - pastikan password aman dan mudah di ingat.',
    'errorPasswordCommon'       => 'Password baru terlalu lemah.',
    'suggestPasswordCommon'     => 'The password was checked against over 65k commonly used passwords or passwords that have been leaked through hacks.',
    'errorPasswordPersonal'     => 'Password tidak boleh mengandung informasi personal.',
    'suggestPasswordPersonal'   => 'Variasi email dan username tidak boleh digunakan pada password.',
    'errorPasswordTooSimilar'    => 'Password terlalu mirip dengan username.',
    'suggestPasswordTooSimilar'  => 'Jangan gunakan bagian username sebagai password.',
    'errorPasswordPwned'        => 'The password {0} has been exposed due to a data breach and has been seen {1, number} times in {2} of compromised passwords.',
    'suggestPasswordPwned'      => '{0} Password harus fresh (baru). Jika tetap menggunakannya harap segera ubah.',
    'errorPasswordEmpty'        => 'Password dibutuhkan.',
    'passwordChangeSuccess'     => 'Password berhasil di ubah',
    'userDoesNotExist'          => 'Password gagal di ubah. User tidak di temukan',
    'resetTokenExpired'         => 'Maaf. Kode token kadaluarsa.',

    // Groups
    'groupNotFound'             => 'Unable to locate group: {0}.',

    // Permissions
    'permissionNotFound'        => 'Unable to locate permission: {0}',

    // Banned
    'userIsBanned'              => 'User telah terbanned. Hubungi Admin',

    // Too many requests
    'tooManyRequests'           => 'Terlalu banyak requests. Harap tunggu {0, number} detik.',

    // Login views
    'home'                      => 'Home',
    'current'                   => 'Current',
    'forgotPassword'            => 'Lupa Password?',
    'enterEmailForInstructions' => 'Tidak masalah! Masukkan email untuk mengirim intruksi reset password.',
    'email'                     => 'Email',
    'emailAddress'              => 'Alamat email',
    'sendInstructions'          => 'Kirim Intruksi',
    'loginTitle'                => 'Login',
    'loginAction'               => 'Login',
    'rememberMe'                => 'Ingat Saya',
    'needAnAccount'             => 'Butuh akun?',
    'forgotYourPassword'        => 'Lupa password?',
    'password'                  => 'Password',
    'repeatPassword'            => 'Ulangi Password',
    'emailOrUsername'           => 'Email atau username',
    'username'                  => 'Username',
    'register'                  => 'Register',
    'signIn'                    => 'Login',
    'alreadyRegistered'         => 'Sudah mendaftar?',
    'weNeverShare'              => 'Kami merahasiakan email anda.',
    'resetYourPassword'         => 'Reset Password',
    'enterCodeEmailPassword'    => 'Masukkan kode yang di terima pada email, Alamat email anda, dan password anda.',
    'token'                     => 'Token',
    'newPassword'               => 'Password Baru',
    'newPasswordRepeat'         => 'Ulangi Password Baru',
    'resetPassword'             => 'Reset Password',
];
