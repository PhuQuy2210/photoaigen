<?php

use App\Http\Controllers\Admin\DanhmucanhController;
use App\Http\Controllers\Admin\DanhmuctinController;
use App\Http\Controllers\Admin\Danhmuccon_anhController;
use App\Http\Controllers\Admin\TinTucController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\Users\Account;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\Users\RegisterController;
use App\Http\Controllers\Admin\HinhAnhController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BaocaoController;
use App\Http\Controllers\Admin\BaocaoAdminController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\LanguageMiddleware;
use Illuminate\Http\Request;
use App\Http\Controllers\MainController as ControllersMainController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Response;
use App\Models\DanhMucAnh;
use App\Models\CatagoryImgChild;
use App\Models\HinhAnh;
use App\Models\TinTuc;

Route::get('/auth/google', [SocialController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback'])->name('google.store');
Route::get('/download', [ImageController::class, 'download'])->name('download.image');
Route::get('/sitemap.xml', function () {
    $danhmuc = DanhMucAnh::all();
    $danhmuccon = CatagoryImgChild::all();
    $hinhanhs = HinhAnh::latest()->take(100)->get();
    $blogs = TinTuc::latest()->take(100)->get();

    $content = view('sitemap', compact('danhmuc', 'danhmuccon', 'hinhanhs', 'blogs'));

    return Response::make($content, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::middleware([LanguageMiddleware::class])->group(function () {
    // Phiên đăng nhập đăng kí tài khoản
    Route::prefix('admin')->group(function () {
        Route::prefix('users')->group(function () {
            //đăng nhập
            Route::get('login', [LoginController::class, 'index'])->name('login');
            //Xử lý đăng nhập
            Route::post('login/store', [LoginController::class, 'store'])->name('xllogin');
            //đăng ký
            Route::get('register', [RegisterController::class, 'index'])->name('register');
            //Xử lý đăng ký
            Route::post('register/store', [RegisterController::class, 'store'])->name('users.register.store');
        });
    });

    // trang chủ
    Route::get('/', [ControllersMainController::class, 'index'])->name('home');
    Route::get('/search', [ControllersMainController::class, 'search'])->name('home.search');
    Route::get('/about_us', [ControllersMainController::class, 'about_us'])->name('home.about_us');
    Route::get('/contact_us', [ControllersMainController::class, 'contact_us'])->name('home.contact_us');
    Route::get('/terms_of_Service', [ControllersMainController::class, 'terms_of_Service'])->name('home.terms_of_Service');
    Route::get('/privacy_Policy', [ControllersMainController::class, 'privacy_Policy'])->name('home.privacy_Policy');

    // cụm danh mục
    Route::get('/images-popular', [ControllersMainController::class, 'popular'])->name('images.popular');
    Route::get('/images-viewCount', [ControllersMainController::class, 'viewCount'])->name('images.viewCount');
    Route::get('/images-random', [ControllersMainController::class, 'random'])->name('images.random');
    Route::get('/images-vertical', [ControllersMainController::class, 'verticalImage'])->name('images.vertical');
    Route::get('/images-horizontal', [ControllersMainController::class, 'horizontalmage'])->name('images.horizontal');

    // xem danh sách ảnh theo danh mục
    Route::get('/images-categories/{id}', [ControllersMainController::class, 'category_image'])->name('images.categories');

    // xem danh sách ảnh theo danh mục con
    Route::get('/images-categories-child/{id}', [ControllersMainController::class, 'category_image_chils'])->name('images.categoriesChild');

    // trang tin tức
    Route::prefix('blog')->group(function () {
        // Trang chủ xem danh sách tin tức
        Route::get('/', [BlogController::class, 'index'])->name('blog.index');
        // xem chi tiết bài viết
        Route::get('/blogdetail/{id}', [BlogController::class, 'blogdetail'])->name('blog.detail');
        // xem danh sách bài viết phổ biến
        Route::get('/popular', [BlogController::class, 'blog_popular'])->name('blog.popular');
        // xem danh sách bài viết theo danh mục
        Route::get('/category/{id}', [BlogController::class, 'blog_category'])->name('blog.category');
    });


    // tăng lượt xem
    Route::post('/update-view/{id}', [HinhAnhController::class, 'updateView'])->name('images.updateView');

    // tăng lượt like
    Route::post('/like-image', [HinhAnhController::class, 'likeImage'])->name('images.like');

    // kiểm tra có đăng nhập chưa
    Route::middleware(['auth'])->group(function () {
        // Bộ sưu tập
        Route::get('/images-user-like/{id}', [ControllersMainController::class, 'userlike'])->name('images.userLike');

        // Báo cáo hình ảnh
        Route::get('/baocao/{idimg}', [BaocaoController::class, 'report'])->name('images.report');
        Route::post('/baocao/store', [BaocaoController::class, 'baocao_Store'])->name('images.reportStore');

        // đăng xuất
        Route::get('/users/logout', [LoginController::class, 'logout'])->name('users.logout');

        // account
        Route::prefix('account-user')->group(function () {
            Route::get('info-user', [Account::class, 'getInfo_user'])->name('account.infoUser');
            Route::get('edit-user', [Account::class, 'changePass_user'])->name('account.editUser');
            Route::post('edit-user', [Account::class, 'handelChangePass_user'])->name('account.handleEditUser');
            Route::get('edit-info', [Account::class, 'changeInfo_user'])->name('account.editInfo');
            Route::post('edit-info', [Account::class, 'handelChangeInfo_user'])->name('account.handleEditInfo');
        });

        Route::prefix('admin')->middleware(\App\Http\Middleware\CheckRole::class)->group(function () {
            Route::get('/', [MainController::class, 'index'])->name('admin');

            #Quản lý tài khoản
            Route::prefix('account')->group(function () {
                Route::get('info', [Account::class, 'getInfo'])->name('info');
                Route::get('edit', [Account::class, 'changePass'])->name('account.changePass');
                Route::post('edit', [Account::class, 'handelChangePass'])->name('account.handelChangePass');
                Route::get('edit-info-admin', [Account::class, 'changeInfo_admin'])->name('account.changeInfo_admin');
                Route::post('edit-info-admin', [Account::class, 'handelChangeInfo_admin'])->name('account.handelChangeInfo_admin');
            });

            #users 
            Route::prefix('users')->group(function () {
                Route::get('add', [UserController::class, 'create'])->name('users.create');
                Route::post('add', [UserController::class, 'store'])->name('users.store');
                Route::get('list', [UserController::class, 'list'])->name('users.list');
                Route::get('upgrade/{id}', [UserController::class, 'upgradeRole'])->name('users.upgrade');
                Route::get('downgrade/{id}', [UserController::class, 'downgradeRole'])->name('users.downgrade');
                Route::get('lock/{id}', [UserController::class, 'lockAccount'])->name('users.lock');
                Route::get('unlock/{id}', [UserController::class, 'unlockAccount'])->name('users.unlock');
                Route::get('edit/{id}', [UserController::class, 'show'])->name('users.show');
                Route::post('edit/{id}', [UserController::class, 'update'])->name('users.update');
                Route::delete('destroy', [UserController::class, 'destroy'])->name('users.destroy');
            });

            #danh mục ảnh
            Route::prefix('danhmucanh')->group(function () {
                Route::get('add', [DanhmucanhController::class, 'create'])->name('menus.create');
                Route::post('add', [DanhmucanhController::class, 'store'])->name('menus.store');
                Route::get('list', [DanhmucanhController::class, 'index'])->name('menus.list');
                Route::get('edit/{danhmuc}', [DanhmucanhController::class, 'show'])->name('menus.show');
                Route::post('edit/{danhmuc}', [DanhmucanhController::class, 'update'])->name('menus.update');
                Route::delete('destroy', [DanhmucanhController::class, 'destroy'])->name('menus.destroy');
            });

            #danh mục con của ảnh
            Route::prefix('danhmuccon_anh')->group(function () {
                Route::get('add', [Danhmuccon_anhController::class, 'create'])->name('danhmuccon.create');
                Route::post('add', [Danhmuccon_anhController::class, 'store'])->name('danhmuccon.store');
                Route::get('list', [Danhmuccon_anhController::class, 'index'])->name('danhmuccon.index');
                Route::get('edit/{danhmuc}', [Danhmuccon_anhController::class, 'show'])->name('danhmuccon.show');
                Route::post('edit/{danhmuc}', [Danhmuccon_anhController::class, 'update'])->name('danhmuccon.update');
                Route::delete('destroy', [Danhmuccon_anhController::class, 'destroy'])->name('danhmuccon.destroy');
            });

            # danh mục tin
            Route::prefix('danhmuctin')->group(function () {
                Route::get('add', [DanhmuctinController::class, 'create'])->name('danhmuctin.add');
                Route::post('add', [DanhmuctinController::class, 'store'])->name('danhmuctin.store');
                Route::get('list', [DanhmuctinController::class, 'index'])->name('danhmuctin.list');
                Route::get('edit/{danhmuc}', [DanhmuctinController::class, 'show'])->name('danhmuctin.edit');
                Route::post('edit/{danhmuc}', [DanhmuctinController::class, 'update'])->name('danhmuctin.update');
                Route::delete('destroy', [DanhmuctinController::class, 'destroy'])->name('danhmuctin.destroy');
            });

            # Hình ảnh
            Route::prefix('hinhanh')->group(function () {
                Route::get('list', [HinhAnhController::class, 'index'])->name('hinhanh.list');
                Route::get('add', [HinhAnhController::class, 'create'])->name('hinhanh.add');
                Route::post('add', [HinhAnhController::class, 'store'])->name('hinhanh.store');
                Route::post('disable', [HinhAnhController::class, 'disable'])->name('hinhanh.disable');
                Route::post('enable', [HinhAnhController::class, 'enable'])->name('hinhanh.enable');
                Route::get('edit/{hinhanh}', [HinhAnhController::class, 'show'])->name('hinhanh.edit');
                Route::post('edit/{hinhanh}', [HinhAnhController::class, 'update'])->name('hinhanh.update');
                Route::delete('destroy', [HinhAnhController::class, 'destroy'])->name('hinhanh.destroy');
            });

            # Tin tức
            Route::prefix('tintuc')->group(function () {
                Route::get('add', [TinTucController::class, 'create'])->name('tintuc.add');
                Route::post('add', [TinTucController::class, 'store'])->name('tintuc.store');
                Route::get('list', [TinTucController::class, 'index'])->name('tintuc.list');
                Route::post('disable', [TinTucController::class, 'disable'])->name('tintuc.disable');
                Route::post('enable', [TinTucController::class, 'enable'])->name('tintuc.enable');
                Route::get('edit/{tintuc}', [TinTucController::class, 'show'])->name('tintuc.edit');
                Route::post('edit/{tintuc}', [TinTucController::class, 'update'])->name('tintuc.update');
                Route::delete('destroy', [TinTucController::class, 'destroy'])->name('tintuc.destroy');
            });

            # Báo cáo
            Route::prefix('baocao')->group(function () {
                Route::get('list', [BaocaoAdminController::class, 'index'])->name('baocao.list');
                Route::delete('destroy', [BaocaoAdminController::class, 'destroy'])->name('baocao.destroy');
                Route::delete('destroy_img', [BaocaoAdminController::class, 'destroy_img'])->name('baocao.destroy_img');
                Route::post('disable', [BaocaoAdminController::class, 'disable'])->name('baocao.disable');
                Route::post('enable', [BaocaoAdminController::class, 'enable'])->name('baocao.enable');
                Route::get('/{id}', [BaocaoAdminController::class, 'report'])->name('admin.baocao');
                Route::post('/store', [BaocaoAdminController::class, 'baocao_Store'])->name('admin.baocao.store');
            });

            #Upload dùng để up ảnh
            // Route::post('upload/services', [\App\Http\Controllers\Admin\UploadController::class, 'store']);
            // Route::post('/ckeditor/upload', [UploadController::class, 'upload'])->name('ckeditor.upload');
        });
    });
});

// Route chuyển đổi ngôn ngữ
Route::get('/switch-language/{lang}', function ($lang) {
    $supportedLangs = ['en', 'vi'];

    if (in_array($lang, $supportedLangs)) {
        Session::put('lang', $lang);
        App::setLocale($lang);
    }

    return redirect()->back();
})->name('switch.language');

Route::post('/save-theme', function (Request $request) {
    Session::put('theme', $request->theme);
    return response()->json(['status' => 'success']);
})->name('save.theme');
