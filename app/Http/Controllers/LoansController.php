<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    public function index()
    {
        $loans = Loans::all();
        return response()->json(Loans::all());

        return response()->json([
            'status' => 200,
            'message' => 'Loans retrieved successfully.',
            'data' => $loans
        ], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
            'loan_date' => 'required|date_format: Y-m-d',
            'return_date' => 'required|date_format: Y-m-d',
            'status' => 'required|integer'
        ]);

        $loans = Loans::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'Loans created succesfully',
            'data' => $loans

        ], 201);
    }
    
    public function show($id)
    {
        $loans = Loans::find($id);

        if (!$loans) {
            return response()->json([
                'status' => 404,
                'message' => 'Loans not found',
                'data' => null
            ],404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Loans retrieved succesfully',
            'data' => $loans
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $loans = Loans::find($id);

        if(!$loans) {
            return response()->json([
                'status' => 404,
                'message' => 'Loans not found',
                'data' => null
            ], 404);
        }

        $request->validate([
            'book_id' => 'integer',
            'user_id' => 'integer',
            'loans_date' => 'date_format:Y-m-d',
            'return_date' => 'date_format:Y-m-d',
            'status' => 'integer'
        ]);

        $loans->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Loans updated succesfully',
            'data' => $loans
        ], 200);
    }

    public function destroy($id)
    {
        $loans = Loans::find($id);

        if(!$loans) {
            return response()->json([
                'status' => 404,
                'message' => 'Loans not found',
                'data' => null
            ], 404);
        }

        $loans->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Loans deleted succesfully',
            'data' => null
        ], 200);
    }
}