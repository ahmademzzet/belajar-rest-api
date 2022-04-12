<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use PHPUnit\Util\Xml\Validator as XmlValidator;

class ProductController extends Controller
{
    //menambahkan data ke database
    public function store(Request $request) {
        //mevalidasi inputan
        $validator = Validator::make($request->all(),[
            'product_name'=>'required|max:50',
            'product_type'=>'required|in:snack,drink,fruit,drug,groceries,make-up,cigarette',
            'product_price'=>'required|numeric',
            'expired_at'=>'required|date'
        ]);
        //kondisi apabila inputan yang di inginkan tidak sesuai
        if($validator->fails()){
            //respon json akan dikirim jika ada inputan yang salah
            return response()->json($validator->messages())->setStatusCode(442);
        }
        $payload = $validator->validated();
        //masukan inputan yang benar ke database (table product)
        Product::created([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at']
        ]);
        //respon json akan dikirim jika inputan benar
        return response()->json([
            'msg' => 'Data product berhasil disimpan'
        ],201);
    }

    function showAll(){
        //panggil semua data product dari tabel products
        $products = Product::all();

        //kirim respone json
        return response()->json([
            'msg'=> 'Data product keseluruhan',
            'data'=> $products
        ],200);

    }

    function showById($id){
        //mencari data berdasarkan ID produk
        $products = Product::where('id',$id)->first();

        //kondisi apabila data dengan id ada
        if($product){
            //kondisi apabila data ada
            return response()->json([
                'msg' => 'Data produk dengan ID:'.$id,
                'data' => $products
            ],200);
        }
        //respon ketika data tidak ada
        return response()->json([
            'msg'=> 'Data produk dengan ID:'.$id.'tidak ditemukan',
        ],404);

    }

    function showByName($product_name){

        //cari data berdasarkan nama produk yang mirip
        $product = Product::where('product_name','LIKE','%'.$product_name.'%')->get();

        //apabila data produk ada
        if($product->count() > 0){

            return response()->json([
                'msg' => 'Data produk dengan nama yang mirip:'.$product_name,
                'data' => $product
            ],200);
        }
        //respon ketika tidak ada
        return response()->json([
            'msg'=> 'Data produk dengan nama yang mirip:'.$product_name.'tidak ditemukan',
        ],404);
    }
}
