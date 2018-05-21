<?php

namespace App\Http\Controllers;

use App\UserWidget;
use App\Widget;
use Illuminate\Http\Request;

class WidgetController extends BackendController
{

    public function Add(Request $request)
    {
        $Widget = Widget::where('id', $request->WidgetID)->first();

        $UserWidget = new UserWidget();
        $UserWidget->owner_id = $this->user->id;
        $UserWidget->page_id = $request->Page;
        $UserWidget->widget_id = $Widget->id;
        $UserWidget->x_position = $Widget->x_position;
        $UserWidget->y_position = $Widget->y_position;
        $UserWidget->width = $Widget->width;
        $UserWidget->height = $Widget->height;
        $UserWidget->save();
    }

    public function Delete(Request $request)
    {
        UserWidget::where('owner_id', $this->user->id)->where('page_id', $request->Page)->where('widget_id', $request->WidgetID)->delete();
    }

    public function UpdateSettings(Request $request)
    {
        $WidgetName = str_replace("Widget", "", $request->WidgetName);
        $WidgetName = preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', $WidgetName);

        $Widget = Widget::where('name', $WidgetName)->first();
        $UserWidget = UserWidget::where('owner_id', $this->user->id)->where('page_id', $this->PageID)->where('widget_id', $Widget->id)->first();

        $UserWidget->x_position = $request->X;
        $UserWidget->y_position = $request->Y;
        $UserWidget->width = $request->Width;
        $UserWidget->height = $request->Height;

        $UserWidget->save();
    }

}
