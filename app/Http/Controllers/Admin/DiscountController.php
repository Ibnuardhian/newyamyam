<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Discount::all();
            return DataTables::of($query)
                ->addColumn('action', function($item){
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="mb-1 mr-1 btn btn-primary dropdown-toggle" 
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown" 
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '">
                                    <a class="dropdown-item" href="' . route('discount.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('discount.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $discounts = Discount::all();
        return view('pages.admin.discount.index', compact('discounts'));
    }

    public function create()
    {
        return view('pages.admin.discount.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\DiscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request) // Change Request to DiscountRequest
    {
        $data = $request->all();
        $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
        Discount::create($data);

        return redirect()->route('discount.index');
    }

    public function edit($id)
    {
        $item = Discount::findOrFail($id);

        return view('pages.admin.discount.edit', [
            'item' => $item
        ]);
    }

    public function update(DiscountRequest $request, $id)
    {
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN) : false;
        $item = Discount::findOrFail($id);
        $item->update($data);

        return redirect()->route('discount.index'); // Corrected route name
    }

    public function destroy($id)
    {
        $item = Discount::findorFail($id);
        $item->delete();

        return redirect()->route('discount.index');
    }
}
