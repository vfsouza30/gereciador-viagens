<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Enums\StatusOrderEnum;

use App\Notifications\OrderApprovedNotification;

use App\Http\Requests\Store\StoreOrderRequest;

use App\Services\StatusOrderService;
use App\Services\DestinationService;

use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'destination']);
        if(auth()->user()->profile !== 'administrador') {
            $orders = $orders->where('user_id', auth()->id());
        }
                
           $orders = $orders->orderBy('created_at', 'desc')        
            ->get()->map(function ($order) {
                return [
                    'id' => $order->id,
                    'user_name' => $order->user->name,
                    'destination_name' => "{$order->destination->city} - {$order->destination->state} ({$order->destination->airport})",
                    'departure_date' => Carbon::createFromFormat('Y-m-d', $order->departure_date)->format('d/m/Y'),
                    'return_date' => Carbon::createFromFormat('Y-m-d', $order->return_date)->format('d/m/Y'),
                    'status' => $this->getStatusOrderName($order->status),
                ];
            })->toArray();
            
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        Order::create([
            'user_id' => auth()->id(),
            'destination_id' => $request->destination_id,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'status' => StatusOrderEnum::REQUESTED->value,
        ]);

        return response()->json(['message' => 'Pedido criado com sucesso!!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        $order->destination_name = "{$order->destination->city} - {$order->destination->state} ({$order->destination->airport})";
        $order->departure_date = Carbon::createFromFormat('Y-m-d', $order->departure_date)->format('d/m/Y');
        $order->return_date = Carbon::createFromFormat('Y-m-d', $order->return_date)->format('d/m/Y');
        $order->status = $this->getStatusOrderName($order->status);

        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->update([
            'status' => $request->status
        ]);
        
        if ($oldStatus != $request->status && $request->status == StatusOrderEnum::APPROVED->value) {
            $order->user->notify(new OrderApprovedNotification($order));
        }

        return response()->json(['message' => 'Pedido atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function destinations()
    {        
        return response()->json(DestinationService::all());
    }

    public function statusOrders()
    {
        return response()->json(StatusOrderService::all());
    }

    private function getStatusOrderName($status)
    {
        return StatusOrderEnum::from($status)->label();
    }
}
