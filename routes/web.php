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


Route::get('/auth/google', [SocialController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
// Route::get('/download-image/{id}', [ImageController::class, 'download'])->name('download.image');
Route::get('/download', [ImageController::class, 'download'])->name('download.image');

Route::middleware([LanguageMiddleware::class])->group(function () {
    // trang chủ
    Route::get('/', [ControllersMainController::class, 'index'])->name('home');
    Route::get('/search', [ControllersMainController::class, 'search'])->name('home.search');
    Route::get('/about_us', [ControllersMainController::class, 'about_us'])->name('home.about_us');
    Route::get('/contact_us', [ControllersMainController::class, 'contact_us'])->name('home.contact_us');
    Route::get('/terms_of_Service', [ControllersMainController::class, 'terms_of_Service'])->name('home.terms_of_Service');
    Route::get('/privacy_Policy', [ControllersMainController::class, 'privacy_Policy'])->name('home.privacy_Policy');

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

    // load more
    // Route::get('/get-images', [ControllersMainController::class, 'getImages'])->name('get-images');
    // Route::get('/load-more-images', [ControllersMainController::class, 'loadMoreImages'])->name('load.more.images');

    // cụm danh mục
    Route::get('/images-popular', [ControllersMainController::class, 'popular']);
    Route::get('/images-viewCount', [ControllersMainController::class, 'viewCount']);
    Route::get('/images-random', [ControllersMainController::class, 'random']);
    Route::get('/images-vertical', [ControllersMainController::class, 'verticalImage']);
    Route::get('/images-horizontal', [ControllersMainController::class, 'horizontalmage']);

    // lấy ảnh theo danh mục
    Route::get('/images-categories/{id}', [ControllersMainController::class, 'category_image']);
    // lấy ảnh theo danh mục con
    Route::get('/images-categories-child/{id}', [ControllersMainController::class, 'category_image_chils']);
    //tăng lượt xem 
    Route::post('/update-view/{id}', [HinhAnhController::class, 'updateView']);

    // trang tin tức
    Route::prefix('blog')->group(function () {
        Route::get('/', [BlogController::class, 'index']);
        Route::get('/blogdetail/{id}', [BlogController::class, 'blogdetail']);
        Route::get('/popular', [BlogController::class, 'blog_popular']);
        Route::get('/category/{id}', [BlogController::class, 'blog_category'])->name('danhmuc.category');
        
    });

    //tăng lượt like
    Route::post('/like-image', [HinhAnhController::class, 'likeImage']);

    //kiểm tra có đăng nhập chưa nếu chưa thì code tự hiểu chuyển hướng đến trang login
    Route::middleware(['auth'])->group(function () {
        // Bộ sưu tập
        Route::get('/images-user-like/{id}', [ControllersMainController::class, 'userlike']);
        
        // Báo cáo hình ảnh
        Route::get('/baocao/{idimg}', [BaocaoController::class, 'report']);
        Route::post('/baocao/store', [BaocaoController::class, 'baocao_Store']);

        //đăng xuất
        Route::get('/users/logout', [LoginController::class, 'logout'])->name('logout');

        #account 
        Route::prefix('account-user')->group(function () {
            Route::get('info-user', [Account::class, 'getInfo_user']);
            Route::get('edit-user', [Account::class, 'changePass_user']);
            Route::post('edit-user', [Account::class, 'handelChangePass_user']);
            Route::get('edit-info', [Account::class, 'changeInfo_user']);
            Route::post('edit-info', [Account::class, 'handelChangeInfo_user']);
        });

        Route::prefix('admin')->middleware(\App\Http\Middleware\CheckRole::class)->group(function () {
            Route::get('/', [MainController::class, 'index'])->name('admin');

            #Quản lý tài khoản
            Route::prefix('account')->group(function () {
                Route::get('info', [Account::class, 'getInfo'])->name('info');
                Route::get('edit', [Account::class, 'changePass'])->name('account.changePass');
                Route::post('edit', [Account::class, 'handelChangePass'])->name('account.handelChangePass');
                Route::get('edit-info-admin', [Account::class, 'changeInfo_admin']);
                Route::post('edit-info-admin', [Account::class, 'handelChangeInfo_admin']);
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
                Route::get('edit/{id}', [UserController::class, 'show']);
                Route::post('edit/{id}', [UserController::class, 'update']);
                Route::delete('destroy', [UserController::class, 'destroy'])->name('users.destroy');
            });

            #danh mục ảnh
            Route::prefix('danhmucanh')->group(function () {
                Route::get('add', [DanhmucanhController::class, 'create']);
                Route::post('add', [DanhmucanhController::class, 'store'])->name('menus.store');
                Route::get('list', [DanhmucanhController::class, 'index'])->name('menus.list');
                Route::get('edit/{danhmuc}', [DanhmucanhController::class, 'show']);
                Route::post('edit/{danhmuc}', [DanhmucanhController::class, 'update']);
                Route::delete('destroy', [DanhmucanhController::class, 'destroy']);
            });

            #danh mục con của ảnh
            Route::prefix('danhmuccon_anh')->group(function () {
                Route::get('add', [Danhmuccon_anhController::class, 'create']);
                Route::post('add', [Danhmuccon_anhController::class, 'store']);
                Route::get('list', [Danhmuccon_anhController::class, 'index']);
                Route::get('edit/{danhmuc}', [Danhmuccon_anhController::class, 'show']);
                Route::post('edit/{danhmuc}', [Danhmuccon_anhController::class, 'update']);
                Route::delete('destroy', [Danhmuccon_anhController::class, 'destroy']);
            });

            #danh mục tin
            Route::prefix('danhmuctin')->group(function () {
                Route::get('add', [DanhmuctinController::class, 'create']);
                Route::post('add', [DanhmuctinController::class, 'store']);
                Route::get('list', [DanhmuctinController::class, 'index']);
                Route::get('edit/{danhmuc}', [DanhmuctinController::class, 'show']);
                Route::post('edit/{danhmuc}', [DanhmuctinController::class, 'update']);
                Route::delete('destroy', [DanhmuctinController::class, 'destroy']);
            });

            #Hình ảnh
            Route::prefix('hinhanh')->group(function () {
                Route::get('list', [HinhAnhController::class, 'index'])->name('hinhanh.index');
                Route::get('add', [HinhAnhController::class, 'create'])->name('hinhanh.create');
                Route::post('add', [HinhAnhController::class, 'store'])->name('hinhanh.store');
                Route::post('disable', [HinhAnhController::class, 'disable']);
                Route::post('enable', [HinhAnhController::class, 'enable']);
                Route::get('edit/{hinhanh}', [HinhAnhController::class, 'show']);
                Route::post('edit/{hinhanh}', [HinhAnhController::class, 'update']);
                Route::delete('destroy', [HinhAnhController::class, 'destroy']);
            });

            #Tin tức
            Route::prefix('tintuc')->group(function () {
                Route::get('add', [TinTucController::class, 'create']);
                Route::post('add', [TinTucController::class, 'store'])->name('tintuc.store');
                Route::get('list', [TinTucController::class, 'index']);
                Route::post('disable', [TinTucController::class, 'disable']);
                Route::post('enable', [TinTucController::class, 'enable']);
                Route::get('edit/{tintuc}', [TinTucController::class, 'show']);
                Route::post('edit/{tintuc}', [TinTucController::class, 'update']);
                Route::delete('destroy', [TinTucController::class, 'destroy']);
            });

            #báo cáo
            Route::prefix('baocao')->group(function () {
                Route::get('list', [BaocaoAdminController::class, 'index']);
                Route::delete('destroy', [BaocaoAdminController::class, 'destroy']);
                Route::delete('destroy_img', [BaocaoAdminController::class, 'destroy_img']);
                Route::post('disable', [BaocaoAdminController::class, 'disable']);
                Route::post('enable', [BaocaoAdminController::class, 'enable']);
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
});
