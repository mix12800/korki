<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCommentStorage;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function myorder()
    {
        return response()->json(['Orders' => Order::with('Course')->where('user_id', Auth::id())->get()]);
    }

    public function commentAdd(RequestCommentStorage $request, Order $order)
    {
        if (Auth::id() == $order->user_id && $order->status == 'completed') {
            return response()->json(['error' => ['code' => 403, 'message' => 'Доступ запрещён']], 403);
        }

        $order->comment = $request->comment;
        return response()->json(['order' => $order]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['orders' => Order::paginate('11')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        if (Order::where('user_id', Auth::id())->where('course_id', $request->course_id)->first()) {
            return response()->json(['errors' => ['course_id' => ['Вы уже записаны на этот курс']]], 422);
        }

        $order = Order::create(array_merge($request->all(), ['user_id' => Auth::id()]));
        return response()->json(['order' => $order]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->status = $request->status;
        return response()->json(['order' => $order]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            return response()->json(['error' => ['code' => 403, 'message' => 'Доступ запрещён']], 403);
        }

        $order->delete();
        return response()->json(['message' => 'ok']);
    }
}
