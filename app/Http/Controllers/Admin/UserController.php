<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Requests\Admin\CreateEditUser;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct(
        protected UserRepositoryInterface $repository,
        protected UserService             $service
    )
    {
        $this->middleware('can:xem_danh_sach_nguoi_dung')->only('index');
        $this->middleware('can:them_nguoi_dung')->only('store');
        $this->middleware('can:sua_nguoi_dung')->only('edit', 'update');
        $this->middleware('can:switch_user')->only('switchUserChange', 'switchUserBack');
    }

    public function index(Request $request)
    {
        $search        = $request->get('search', []);
        $user_inactive = User::query()->where('status', 0)->count();
        $roles         = Role::all();
        $users         = $this->service->getTable(20, [], $search);
        
        return view('Admin.pages.users.index', compact('users', 'roles', 'user_inactive'));
    }

    public function create(Request $request)
    {
        $user                  = $this->repository->getModel();
        $user_id               = 0;
        $formOptions           = $this->service->formOptions($user);
        $formOptions['action'] = route('admin.users.store');
        $default_values        = $formOptions['default_values'];

        $view_data = compact('formOptions', 'default_values', 'user_id');

        return view('Admin.pages.users.add-edit', $view_data);
    }

    public function store(CreateEditUser $request)
    {
        // dd($request->input());
        // $inputs = $request->only(['name', 'email', 'role_id', 'status']);
        $inputs             = $request->all();
        $inputs['password'] = Hash::make($inputs['password']);

        $this->service->create($inputs);


        return redirect(route('admin.users.index'))
            ->with('successMessage', 'Thêm mới thành công.');
    }

    public function edit(Request $request, int $user_id)
    {
        $user                  = $this->repository->find($user_id, ['roles',]);
        $formOptions           = $this->service->formOptions($user);
        $formOptions['action'] = route('admin.users.update', $user_id);
        $default_values        = $formOptions['default_values'];

        $view_data = compact('formOptions', 'default_values', 'user_id');

        return view('Admin.pages.users.add-edit', $view_data);
    }

    public function update(CreateEditUser $request, int $user_id)
    {
        $this->service->update($user_id, $request->all());

        return redirect(route('admin.users.index'))
            ->with('successMessage', 'Thay đổi thành công.');
    }

    public function redirectToProvider($provider)
    {
        $url_previous = URL::previous();
        $url_login    = URL::to(route('admin.login'));
        $url_index    = URL::to(route('admin.dashboard.index'));

        if ($url_previous != $url_login) {
            session()->put('pre_url', $url_previous);
        } else {
            session()->put('pre_url', $url_index);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        if (!$authUser) {
            return redirect(route('admin.login'))->withErrors(['email' => 'Người dùng không tồn tại trong hệ thống, bạn liên hệ với quản trị viên để được hỗ trợ.']);
        }

        Auth::guard()->login($authUser, true);
        return redirect(Session::get('pre_url'));
    }

    public function findOrCreateUser($providerUser, $provider)
    {
        $user = $this->repository->getByEmail($providerUser->email);
        if (!$user) {
            return false;
        }
        if ($user->avatar != ($providerUser->avatar ?? '')) {
            $user->update(['avatar' => $providerUser->avatar]);
        }

        return $user;
    }

    public function switchUser(Request $request, int $user_id)
    {
        $user = Helper::currentUser();
        if ($user && $user->other_user && $user->other_user->id == $user_id) {
            Auth::login($user->other_user, true);
            $route = $this->routeFromUser($user->other_user);

            return redirect($route)->with('successMessage', 'Đổi tài khoản thành công.');
        }

        abort(403, 'Bạn không có quyền thực hiện chức năng này.');
    }

    public function switchUserChange(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string']
        ]);
        $email       = $request->input('email');
        $currentUser = Helper::currentUser();
        if ($email == $currentUser->email) {
            return back()->with('errorMessage', 'Bạn đang ở tài khoản này.');
        }
        $authUser = User::query()
            ->where(function ($query) use ($email) {
                if (str_contains($email, '@')) {
                    $query->where('email', $email);
                } else {
                    $query->where('name', $email);
                }
            })
            ->where('status', User::STATUS_ACTIVE)
            ->first();
        if ($authUser) {
            Auth::login($authUser, true);
            session()->put('switch_back', $currentUser->id);

            $route = $this->routeFromUser($authUser);

            return redirect($route)->with('successMessage', 'Đổi tài khoản thành công.');
        } else {
            return back()->with('errorMessage', 'Không tìm thấy tài khoản này.');
        }
    }

    public function switchUserBack(Request $request, int $userId)
    {
        $switchBack = session()->get('switch_back');
        if (!$switchBack || $switchBack != $userId) {
            abort(403);
        }
        $authUser = User::query()->where('id', $userId)->where('status', User::STATUS_ACTIVE)->first();
        if ($authUser) {
            session()->forget('switch_back');
            Auth::login($authUser, true);

            $route = $this->routeFromUser($authUser);

            return redirect($route)->with('successMessage', 'Đổi tài khoản thành công.');
        }
        return back()->with('errorMessage', 'Không tìm thấy tài khoản này.');
    }

    public function routeFromUser($user)
    {
//        if (($user?->roles?->first()?->name ?: '') == User::ROLE_TDV) {
//            return route('admin.tdv.dashboard');
//        }
//
//        if (($user?->roles?->first()?->name ?: '') == User::ROLE_THIEN_DIEU) {
//            return route('admin.thien_dieu.dashboard');
//        }

        return route('admin.dashboard.index');
    }
}
