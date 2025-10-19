<?php

namespace App\Http\Controllers;

use App\Models\AccommodationPlan;
use App\Models\PlanImage;
use App\Models\ReservationSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccommodationPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        // withに入るのは、リレーションメソッド（モデルに記載）
        $plans = AccommodationPlan::with('images')->paginate('10');
        return view('admin.accommodation_plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reservationSlots = ReservationSlot::with('roomType')
            ->where('plan_flag', 0)
        ->orderBy('reservation_date','desc')->get();


        // $plans = AccommodationPlan::query()
        //     // 最初の$keywordは実行可否の条件(bool)
        //     // fnの第一引数はクエリビルダ、第二引数は条件時の使用データ
        //     ->when($keyword, function($query, $keyword){
        //         return $query->where('title','like',"%{$keyword}%")
        //         ->orWhere('price',"%{$keyword}%")
        //         ->orWhere('description','like',"%{$keyword}%");
        //     })
        //     ->orderBy('created_at', 'desc')
        //     ->paginate('10');

        // return view('accommodation_plan.index', compact('plans'));

        // var_dump($reservationSlots);
        return view('admin.accommodation_plan.create',compact('reservationSlots'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'reservation_slot_id' => 'required|exists:reservation_slots,id',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $plan = AccommodationPlan::create([
            'title' => $validated['title'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'reservation_slot_id' => $validated['reservation_slot_id'],
        ]);
        // var_dump($plan);
        ReservationSlot::where('id', $validated['reservation_slot_id'])
            ->update(['plan_flag' => 1 ]);

        if($request->hasFile('images')){
            foreach($request->file('images') as $index => $image){
                $path = $image->store('plan_images','public');
                PlanImage::create([
                    'accommodation_plan_id' => $plan->id,
                    'image_path' => $path,
                    'display_order' => $index,
                ]);
            }
        }
        return redirect()->route('accommodation-plans.index')->with('success','宿泊プランを作成しました！');
        
        //Route [accomodation--plans.index] not defined.　　　accomm！！！odation
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccommodationPlan  $accommodationPlan
     * @return \Illuminate\Http\Response
     */
    public function show(AccommodationPlan $accommodationPlan)
    {   
        // with()でリレーションができてないので、loadを使用、下記('メソッド名')
        $accommodationPlan->load('images');
        // return view('accommodation_plans.show', compact('accommodationPlan')); adminがない、planにsが多い
        return view('admin.accommodation_plan.show', compact('accommodationPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccommodationPlan  $accommodationPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(AccommodationPlan $accommodationPlan)
    {
        $accommodationPlan->load('images');
        return view('admin.accommodation_plan.edit', compact('accommodationPlan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccommodationPlan  $accommodationPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccommodationPlan $accommodationPlan)
    {
        // 予約枠IDは固定として、変更不可とする
        $validated = $request->validate([
            'title' => 'required|string',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'array',
            'delete_images.*' => 'exists:plan_images,id',
        ]);

        $accommodationPlan->update([
            'title' => $validated['title'],
            'price' => $validated['price'],
            'description' => $validated['description'],
        ]);
        // 画像削除
        if($request->has('delete_images')){
            // whereInの第2引数は配列、削除予定のインスタンスを取得
            $delete_images = PlanImage::whereIn('id', $validated['delete_images'])->get();
            foreach($delete_images as $image){
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        
        if($request->hasFile('images')){
            // 新規画像追加 with()もload()も多いので、画像自体のメソッドで繋がっているインスタンスの中で一番後ろの番号を取得
            $max_number = $accommodationPlan->images()->max('display_order')??-1;
            // var_dump($max_number);
            foreach($request->file('images') as $index => $image){
                $path = $image->store('plan_images','public');
                // var_dump($accommodationPlan);
                PlanImage::create([
                    'accommodation_plan_id' => $accommodationPlan->id,
                    'image_path' => $path,
                    'display_order' =>$max_number + $index + 1,
                ]);
            }
        }
        return redirect()->route('accommodation-plans.index')->with('success','宿泊プランを更新しました！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccommodationPlan  $accommodationPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccommodationPlan $accommodationPlan)
    {
        // 🌟publicディレクトリから画像が消えていないので、修正🌟
        // 
        foreach($accommodationPlan->images as $image){
            // var_dump($image->image_path);
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        $accommodationPlan->delete();
        ReservationSlot::where('id', $accommodationPlan->reservation_slot_id)
        ->update(['plan_flag' => 0]);
        return redirect()->route('accommodation-plans.index')->with('success','宿泊プランを削除しました！');
    }

    ///////////以下、ユーザー側///////////////////////////////////////////

    public function top()
    {  
        // withに入るのは、リレーションメソッド（モデルに記載）
        $plans = AccommodationPlan::OrderBy('created_at', 'desc')->paginate('10');
        return view('accommodation_plan.index', compact('plans'));
    }

    public function search(Request $request)
    {  
        $keyword = $request->input('keyword');
        // withに入るのは、リレーションメソッド（モデルに記載）
        $plans = AccommodationPlan::query()
            // 最初の$keywordは実行可否の条件(bool)
            // fnの第一引数はクエリビルダ、第二引数は条件時の使用データ
            ->when($keyword, function($query, $keyword){
                return $query->where('title','like',"%{$keyword}%")
                ->orWhere('price',"%{$keyword}%")
                ->orWhere('description','like',"%{$keyword}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate('10');

        return view('accommodation_plan.index', compact('plans'));
    }

        public function detail(AccommodationPlan $accommodationPlan)
    {  
        // withに入るのは、リレーションメソッド（モデルに記載）
        $plan = AccommodationPlan::findOrFail($accommodationPlan);
        return view('accommodation_plan.detail', compact('plan'));
    }






}
