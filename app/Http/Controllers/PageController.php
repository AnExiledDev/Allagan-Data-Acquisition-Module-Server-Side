<?php

namespace App\Http\Controllers;

use App\UserPage;
use App\UserWidget;
use App\Widget;
use Illuminate\Http\Request;

class PageController extends BackendController
{
    public function index(Request $request)
    {
        return view('Backend.Dashboard.Dashboard');
    }

    public function add(Request $request)
    {
        $page = new UserPage();
        $page->owner_id = $this->user->id;
        $page->page_name = $request->PageName;
        $page->page_icon = $request->PageIcon;
        $page->save();
    }

    public function delete(Request $request)
    {
        UserPage::where('owner_id', $this->user->id)->where('id', $request->Page)->delete();
        Widget::where('owner_id', $this->user->id)->where('page_id', $request->Page)->delete();
    }

    public function UpdateName(Request $request)
    {
        $page = UserPage::where('owner_id', $this->user->id)->where('id', $request->Page)->first();
        $page->page_name = $request->value;
        $page->save();

        return $request->value;
    }

    public function UpdateIcon(Request $request)
    {
        $page = UserPage::where('owner_id', $this->user->id)->where('id', $request->Page)->first();
        $page->page_icon = $request->value;
        $page->save();

        return $request->value;
    }
}
