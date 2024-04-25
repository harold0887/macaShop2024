<?php

namespace App\Providers;

use App\Models\Ips;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse
        {
            public function toResponse($request)
            {
                $user = User::findOrFail(Auth::user()->id);
                $user->assignRole('customer');
                Ips::create([
                    'user_id' => Auth::user()->id,
                    'ip' => $request->ip(),
                    'tipo' => 'Register',
                    'last_entry' => now(),
                    'last_type' => 'Register',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return redirect('/email/verify');
            }
        });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request)
            {
                $userIps = Ips::where('user_id', Auth::user()->id)
                    ->where('ip', $request->ip())->get();

                if ($userIps->count() == null) {
                    Ips::create([
                        'user_id' => Auth::user()->id,
                        'ip' => $request->ip(),
                        'tipo' => 'Login',
                        'last_entry' => now(),
                        'last_type' => 'Login',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {

                    foreach ($userIps as $ip) {
                        Ips::findOrFail($ip->id)->update([
                            'last_entry' => now(),
                            'last_type' => 'Login',
                        ]);
                    }
                }
                return redirect('/');
            }
        });




        // $this->app->instance(VerifyEmailViewResponse::class, new class implements VerifyEmailViewResponse
        // {
        //     public function toResponse($request)
        //     {
        //         return redirect('/');
        //     }
        // });

        // $this->app->instance(LogoutResponse::class, new class implements LogoutResponse
        // {
        //     public function toResponse($request)
        //     {
        //         return redirect('/home');
        //     }
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
        Fortify::loginView(function () {
            return view('auth.login');
        });
        Fortify::registerView(function () {
            return view('auth.register');
        });

        //reestablecer contraseña vista para ingresar email y enviar link
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.passwords.forgot-password');
        });

        //reestablecer contraseña vista para cambiar la contraseña
        Fortify::resetPasswordView(function (Request $request) {
            return view('auth.passwords.reset', ['request' => $request]);
        });



        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
