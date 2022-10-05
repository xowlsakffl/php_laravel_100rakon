<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Date;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialUser;
use Illuminate\Auth\Events\Registered;

class SocialController extends Controller
{
    use AuthenticatesUsers;

    /**
     * 주어진 provider에 대하여 소셜 응답을 처리합니다.
     *
     * @param Request $request
     * @param string  $provider
     * @return RedirectResponse|Response
     */
    public function execute(Request $request, string $provider)
    {
        if (! array_key_exists($provider, config('services'))) {
            return $this->sendNotSupportedResponse($provider);
        }

        if (! $request->has('code')) {
            return $this->redirectToProvider($provider);
        }

        return $this->handleProviderCallback($request, $provider);
    }

    /**
     * 사용자를 주어진 공급자의 OAuth 서비스로 리디렉션합니다.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    protected function redirectToProvider(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 소셜에서 인증을 받은 후 응답입니다.
     *
     * @param Request $request
     * @param string  $provider
     * @return RedirectResponse|Response
     */
    protected function handleProviderCallback(Request $request, string $provider)
    {
        $socialUser = Socialite::driver($provider)->user();
        // 해당 프로바이더로 가입한 상태이면 로그인 처리
        if ($user = User::where('email', $socialUser->getEmail())->where('join_from', $provider)->first())
        {
            $this->guard()->login($user, true);

            return $this->sendLoginResponse($request);
        }
        // 해당 프로바이더로 가입은 하지 않았지만 가입은 되어 있음
        if ($user = User::where('email', $socialUser->getEmail())->first())
        {
            return '<center><br/><br/>이미 ['.$user->getJoinFromText().']로 가입된 이메일 입니다.<br/><br/><a href="/login">로그인으로 돌아가기</a></center>';
        }
        return $this->register($request, $socialUser, $provider);
    }

    /**
     * 주어진 소셜 회원을 응용 프로그램에 등록합니다.
     *
     * @param Request    $request
     * @param SocialUser $socialUser
     * @return mixed
     */
    protected function register(Request $request, SocialUser $socialUser, $provider)
    {
        if($provider == 'naver')
        {
            $user = User::create([
                'name' => $socialUser->user['response']['name'],
                'email' => $socialUser->user['response']['email'],
                'email_auth' => 'Y',
                'cell' => $socialUser->user['response']['mobile'],
                'cell_auth' => 'Y',
                'join_from' => $provider,
            ]);
        }
        if($provider == 'kakao')
        {
            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'email_auth' => 'Y',
                'join_from' => $provider,
            ]);
        }

        $user->email_verified_at = Date::now();
        $user->remember_token = Str::random(60);
        $user->save();

        $this->guard()->login($user, true);

        return $this->sendLoginResponse($request);
    }

    /**
     * 사용자 인증을 받았습니다.
     *
     * @param Request $request
     * @param User    $user
     */
    protected function authenticated(Request $request, User $user): void
    {
        flash()->success(__('auth.welcome', ['name' => $user->name]));
    }

    /**
     * 지원하지 않는 소셜 공급자에 대한 응답입니다.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    protected function sendNotSupportedResponse(string $provider): RedirectResponse
    {
        flash()->error(trans('auth.social.not_supported', ['provider' => $provider]));

        return back();
    }

    /**
     * 결과 페이지
     *
     * @param Request $request
     */
    protected function sendLoginResponse($request): RedirectResponse
    {
        return redirect('/');
    }
}
