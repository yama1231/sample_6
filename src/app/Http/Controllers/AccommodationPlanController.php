<?php

namespace App\Http\Controllers;

use App\Models\AccommodationPlan;
use App\Models\PlanImage;
use App\Models\RoomType;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AccommodationPlanController extends Controller
{


    public function index()
    {  
        $plans = AccommodationPlan::with('images')->paginate('10');
        return view('admin.accommodation_plan.index', compact('plans'));
    }


    public function create()
    {
        $roomTypes = RoomType::all();
        return view('admin.accommodation_plan.create',compact('roomTypes'));
        
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',//各要素のチェック
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'roomtype' => 'required|array',
            'roomtype.*'=> 'required|numeric',
        ]);

        $plan = AccommodationPlan::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);
        
        foreach($validated['roomtype'] as $index => $_){
            Price::create([
                'accommodation_plan_id' => $plan->id,
                'room_type_id' =>$validated['roomtype'][$index],
                'price' => $validated['prices'][$index],
            ]);
        }

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
    }


    public function show(AccommodationPlan $accommodationPlan)
    {   
        $accommodationPlan->load('images')->load('prices.roomType');

        return view('admin.accommodation_plan.show', compact('accommodationPlan'));
    }


    public function edit(AccommodationPlan $accommodationPlan)
    {
        $accommodationPlan->load('images');

        return view('admin.accommodation_plan.edit', compact('accommodationPlan'));
    }


    public function update(Request $request, AccommodationPlan $accommodationPlan)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',//各要素のチェック
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'array',
            'delete_images.*' => 'exists:plan_images,id',
        ]);
        $accommodationPlan->update([
            'title' => $validated['title'],
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

        // 新規画像追加 
        if($request->hasFile('images')){
            $max_number = $accommodationPlan->images()->max('display_order')??-1;
            foreach($request->file('images') as $index => $image){
                $path = $image->store('plan_images','public');
                PlanImage::create([
                    'accommodation_plan_id' => $accommodationPlan->id,
                    'image_path' => $path,
                    'display_order' =>$max_number + $index + 1,
                ]);
            }
        }


        // 料金の変更　　追加する！！！！！！！！！！！！！！！！１


        return redirect()->route('accommodation-plans.index')->with('success','宿泊プランを更新しました！');
    }


    public function destroy(AccommodationPlan $accommodationPlan)
    {
        foreach($accommodationPlan->images as $image){
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        foreach($accommodationPlan->prices as $price){
            $price->delete();
        }

        $accommodationPlan->delete();

        return redirect()->route('accommodation-plans.index')->with('success','宿泊プランを削除しました！');
    }



    ///////////以下、ユーザー側///////////////////////////////////////////



    public function top()
    {  
        $plans = AccommodationPlan::with(['images','prices'])->OrderBy('created_at', 'desc')->paginate('10');

        return view('user.accommodation-plan.top', compact('plans'));
    }


    public function search(Request $request)
    {  
        $keyword = $request->input('keyword');
        $plans = AccommodationPlan::query()
            // 最初の$keywordは実行可否の条件(bool)
            // fnの第一引数はクエリビルダ、第二引数は条件時の使用データ
            // whereの最後に；
            ->when($keyword, function($query, $keyword){
                return $query->where('title','like',"%{$keyword}%")
                ->orWhere('description','like',"%{$keyword}%")
                ->orWhereHas('prices', function($price_q) use ($keyword){
                    $price_q->where('price', 'like', "%$keyword%")
                    ;
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate('10');

        return view('user.accommodation-plan.top', compact('plans'));
    }


        public function detail(Request $request)
    {  
        $plan_id = $request->plan_id;
        $plan = AccommodationPlan::with(['images','prices'])->findOrFail($plan_id);

        return view('user.accommodation-plan.detail', compact('plan'));
    }


    public function calendar(Request $request)
    {  
        $plan_id = $request->plan_id;
        $plan = AccommodationPlan::findOrFail($plan_id);
        
        return view('user.accommodation-plan.calendar', compact('plan'));
    }
}
