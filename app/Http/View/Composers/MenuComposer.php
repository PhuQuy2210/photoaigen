<?php


namespace App\Http\View\Composers;
use App\Models\DanhMucAnh;
use Illuminate\View\View;

class MenuComposer
{
    protected $users;

    public function __construct()
    {
    }

    public function compose(View $view)
    {
        $danhmucs = DanhMucAnh::select('id', 'name')->orderByDesc('id')->get();

        $view->with('danhmuc', $danhmucs);
    }
}
