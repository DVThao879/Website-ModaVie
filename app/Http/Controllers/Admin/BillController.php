<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Bill::class);
        $query = Bill::with(['user'])
            ->orderBy('status', 'asc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $data = $query->get();
        $statusCounts = [
            'all' => Bill::all()->count(),
            'pending' => Bill::where('status', 1)->count(),
            'processing' => Bill::where('status', 2)->count(),
            'shipping' => Bill::where('status', 3)->count(),
            'completed' => Bill::where('status', 4)->count(),
            'pending_cancel' => Bill::where('status', 5)->count(),
            'canceled' => Bill::where('status', 6)->count(),
        ];
        return view('admin.orders.index', compact('data', 'statusCounts'));
    }

    public function detail($order_id)
    {
        $bill = Bill::with(['user', 'voucher', 'billDetails'])->findOrFail($order_id);

        $this->authorize('view', $bill);

        return view('admin.orders.show', compact('bill'));
    }

    public function confirmBill($bill_id)
    {
        $bill = Bill::find($bill_id);

        $this->authorize('update', $bill);

        if ($bill->status == 1) {
            $bill->status = 2;
            $bill->save();
            return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận');
        } else {
            return redirect()->back()->with('error', 'Không thể xác nhận đơn hàng với trạng thái hiện tại');
        }
    }

    public function shipBill($bill_id)
    {
        $bill = Bill::find($bill_id);

        $this->authorize('update', $bill);

        if ($bill->status == 2) {
            $bill->status = 3;
            $bill->save();
            return redirect()->back()->with('success', 'Đơn hàng đang được giao');
        } else {
            return redirect()->back()->with('error', 'Không thể giao hàng với trạng thái hiện tại');
        }
    }

    public function confirmShipping($bill_id)
    {
        $bill = Bill::find($bill_id);

        $this->authorize('update', $bill);

        if ($bill->status == 3) {
            $bill->status = 4;
            $bill->save();
            return redirect()->back()->with('success', 'Đơn hàng đã được giao thành công');
        } else {
            return redirect()->back()->with('error', 'Không thể xác nhận giao hàng với trạng thái hiện tại');
        }
    }

    public function cancelBill($bill_id)
    {
        $bill = Bill::find($bill_id);

        $this->authorize('update', $bill);

        if ($bill->status == 5) {
            $bill->status = 6;
            $bill->save();
            return redirect()->back()->with('success', 'Đơn hàng đã bị hủy');
        } else {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng với trạng thái hiện tại');
        }
    }

    public function gerenatePdf($order_code)
    {
        $bill = Bill::with(['user', 'voucher', 'billDetails'])
            ->where('order_code', $order_code)
            ->firstOrFail();
        if ($bill->status == 4) {
            $data = [
                'title' => "Hóa đơn chi tiết",
                'date' => date('m/d/Y'),
                'bill' => $bill
            ];

            $pdf = Pdf::loadView('admin.orders.generate-bill-pdf', $data);
            return $pdf->stream();
        } else {
            return redirect()->back()->with('error', 'Không hợp lệ');
        }
    }
}
