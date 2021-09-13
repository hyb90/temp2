<?php

namespace App\Http\Controllers;

use App\Helpers\apiHelper;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::all();
        return apiHelper::sendResponse($notifications,'success');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject'=>'required',
            'body'=>'required',
            'receiver'=>'required',
            'status'=>'nullable|in:0,1,2',
            'type'=>'required|in:0,1',
        ]);
        $notification= Notification::create($request->all());
        if($notification) return apiHelper::sendResponse($notification,'success');
        return apiHelper::sendResponse('null','error',500,1);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($notification)
    {
        $notification=Notification::find($notification);
        if($notification)
            return apiHelper::sendResponse($notification,'success');
        return apiHelper::sendResponse('null','no such record',404,1);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $notification)
    {
        $request->validate([
            'status'=>'nullable|in:pending,fail,success',
            'type'=>'nullable|in:sms,email',
        ]);
        $notification=Notification::find($notification);
        if($notification) {
            $notification->update($request->all());
            return apiHelper::sendResponse($notification,'success');
        }
            return apiHelper::sendResponse('null','no such record',404,1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($notification)
    {
        $notification=Notification::find($notification);
        if($notification) {
            $notification->delete();
            return apiHelper::sendResponse('null','success');
        }
        return apiHelper::sendResponse('null','no such record',404,1);
    }
}
