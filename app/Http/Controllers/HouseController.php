<?php

namespace App\Http\Controllers;

use App\House;
use Illuminate\Http\Request;
use App\Http\Resources\House as HouseResource;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query_params = [
            ['bedrooms' => '='],
            ['bathrooms' => '='],
            ['storeys' => '='],
            ['garages' => '=']
        ];

        $query_params_prepared = [];

        //forming query clauses for exact params
        foreach ($query_params as $param) {
            if (!empty(request(key($param)))) {
                $query_params_prepared[] = [
                    key($param), $param[key($param)], request(key($param))
                ];
            }
        }

        //forming query clauses for 'price' param (in ranges)
        if (!empty(request('price_starts_at')) && empty(request('price_ends_at'))) {
            $query_params_prepared[] = [
                'price', '>=', request('price_starts_at')
            ];
        } elseif (empty(request('price_starts_at')) && !empty(request('price_ends_at'))) {
            $query_params_prepared[] = [
                'price', '<=', request('price_ends_at')
            ];
        }

        //forming query clauses for 'name' param (contains characters)
        if (!empty(request('name'))) {
            $query_params_prepared[] = [
                'name', 'like', '%'.request('name').'%'
            ];
        }

        if (!empty(request('price_starts_at')) && !empty(request('price_ends_at'))) {
            return HouseResource::collection(House::where($query_params_prepared)->whereBetween('price', [request('price_starts_at'), request('price_ends_at')])->get());
        } else {
            return HouseResource::collection(House::where($query_params_prepared)->get());
        }
        /*$res = House::where($query_params_prepared)->get();
        return HouseResource::collection($res);*/
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
