<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Mail;
use App\User;
use App\ConfirmUser;
use App\Profile;

class CustomAuthController extends Controller
{
    public function postLogin(Request $request)
    {
    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1]))
		{
			return redirect('/');
		}
		else
		{
			return redirect()->back()->with('status', 'Не правильный логин или пароль или не подтвержден email.');
		}
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'city_id' => 'required|numeric',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
            'rules' => 'accepted'
        ]);

        $user = User::where('email', $request->email)->first();

        if ( ! empty($user->email))
        {
        	if ($user->status == 0)
        	{
        		return redirect()->back()->withInput()->with('status', 'Такой email уже зарегестрирован, но не подтвержден. Проверьте почту или запросите повторное подтверждение email.');
        	}
        	else
        	{
        		return redirect()->back()->withInput()->with('status', 'Пользователь с таким email уже зарегестрирован.');
        	}
        }

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
            'ip' => $request->ip(),
            'location' => serialize($request->ips()),
		]);

		if ($user)
		{
			$confirm = new ConfirmUser;
			$confirm->email = $user->email;
			$confirm->token = str_random(32);
			$confirm->city_id = $request->city_id;
			$confirm->save();

			Mail::send('emails.confirm', ['token' => $confirm->token], function($u) use ($user) {
				$u->from('electron.servant@gmail.com', 'Vizov.kz');
				$u->to($user->email);
				$u->subject('Потдверждение регистрации');
			});

			return redirect('auth/login')->with('status', 'На вашу почту было выслано письмо, для подтверждения регистрации пройдите по ссылке в нем.');
		}
		else
		{
			return redirect()->back()->with('status', 'Возникла ошибка, попробуйте позже!');
		}
	}

	public function confirm($token)
	{
		$confirm = ConfirmUser::where('token', $token)->firstOrFail();

		$user = User::where('email', $confirm->email)->first();
        $user->attachRole(3);
		$user->status = 1;
		$user->save();

        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->city_id = $confirm->city_id;

        $contacts = [
            'phone' => null,
            'telegram' => null,
            'whatsapp' => null,
            'viber' => null,

            'phone2' => null,
            'telegram2' => null,
            'whatsapp2' => null,
            'viber2' => null
        ];

        $profile->phone = json_encode($contacts);
        $profile->save();

		$confirm->delete();

		return redirect('auth/login')->with('status', 'Вы успешно потдвердили регистрацию. Теперь войдите в систему используя свой email и пароль.');
	}

	public function getRepeat()
	{
		return view('auth.repeat');
	}

	public function postRepeat(Request $request)
	{
		$user = User::where('email', $request->email)->firstOrFail();

		if ($user)
		{
			if ($user->status == 0)
			{
				$user->touch();

				$confirm = ConfirmUser::where('email', $request->email)->first();
				$confirm->touch();

				Mail::send('emails.confirm',['token' => $confirm->token], function($u) use ($user) {
					$u->from('electron.servant@gmail.com', 'Vizov.kz');
					$u->to($user->email);
					$u->subject('Подтверждение регистрации');
				});

				return redirect()->back()->with('status', 'Письмо для активации успешно выслано на указанный email.');
			}
			else
			{
				return redirect()->back()->with('status', 'Такой email уже подтвержден!');
			}
		}
		else
		{
			return redirect()->back()->with('status', 'Нет пользователя с таким email.');
		}
	}
}
