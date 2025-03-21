<?php

namespace App\Http\Controllers;

use App\Models\Hotels;
use App\Models\TourFeatures;
use App\Models\TourGuides;
use App\Models\Tours;
use App\Models\TourServices;
use App\Models\TourSubcategories;
use App\Models\TourSupervisors;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TourController extends Controller
{
    public function index()
    {
        return view('tours.index');
    }

    public function create()
    {
        $hotels = Hotels::all();
        $guides = TourGuides::all();
        $supervisors = TourSupervisors::all();
        $tour_subcategories = TourSubcategories::all();
        $tour_services = TourServices::all();
        return view('tours.create',compact('tour_subcategories','hotels','guides','supervisors','tour_services'));
    }
    public function store(Request $request)
    {
        try {
            // Veritabanında Tur Tablosuna Kayıt
            $new_tour = new Tours();
            $new_tour->name = $request->input('name');
            $new_tour->category_id = $request->input('category_id');
            $new_tour->subcategory_id = $request->input('subcategory_id');
            $new_tour->start_date = $request->input('start_date');
            $new_tour->end_date = $request->input('end_date');
            $new_tour->duration = $request->input('duration');
            $new_tour->quota = $request->input('quota');
            $new_tour->transportation_id = $request->input('transportation_id');
            $new_tour->starting_place = $request->input('starting_place');
            $new_tour->hotel_id = $request->input('hotel_id');
            $new_tour->price = $request->input('price');
    
            if ($request->hasFile('tour_picture') && $request->file('tour_picture')->isValid()) {
                $image = $request->file('tour_picture');
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('assets/img/tours', $imageName, 'public');
                $new_tour->main_picture = $imagePath;
            }
    
            $new_tour->directory_id = $request->input('directory_id');
            $new_tour->supervisor_id = $request->input('supervisor_id');
            $new_tour->status_id = 1;
            $new_tour->user_id = Auth::user()->id;
            $new_tour->save();

            // Tur Özelliklerini Veritabanına Eklenmesi.
            if ($request->has('included_services') && is_array($includedServices = json_decode($request->input('included_services')))) {
                foreach ($includedServices as $value) {
                    $tour_service = new TourFeatures();
                    $tour_service->tour_id = $new_tour->id;
                    $tour_service->featured_id = $value;
                    $tour_service->status_id = 1;
                    $tour_service->save();
                }
            }
             if ($request->has('excluded_services') && is_array($excludedServices = json_decode($request->input('excluded_services')))) {
                foreach ($excludedServices as $value) {
                    $tour_service = new TourFeatures();
                    $tour_service->tour_id = $new_tour->id;
                    $tour_service->featured_id = $value;
                    $tour_service->status_id = 0;
                    $tour_service->save();
                }
            }

            // Tur Görsellerinin Veritabanına Eklenmesi.


    
            return response()->json(['success' => true, 'message' => 'Tur Başarıyla Eklendi']);
        } catch (Exception $error) {
            return response()->json(['success' => false, 'message' => 'Tur Eklenemedi: ' . $error->getMessage()]);
        }
    }
    
    
}
