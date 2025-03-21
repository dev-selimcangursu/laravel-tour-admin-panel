<?php

namespace App\Http\Controllers;

use App\Models\Hotels;
use App\Models\TourFeatures;
use App\Models\TourGuides;
use App\Models\TourImages;
use App\Models\Tours;
use App\Models\TourServices;
use App\Models\TourSubcategories;
use App\Models\TourSupervisors;
use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TourController extends Controller
{
    public function index()
    {
        return view('tours.index');
    }
    // Yeni Tur Ekle Sayfası
    public function create()
    {
        $hotels = Hotels::all();
        $guides = TourGuides::all();
        $supervisors = TourSupervisors::all();
        $tour_subcategories = TourSubcategories::all();
        $tour_services = TourServices::all();
        return view('tours.create', compact('tour_subcategories', 'hotels', 'guides', 'supervisors', 'tour_services'));
    }
    // Yeni Tur Ekle Post İşlemi
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
            $pictures = [
                'picture_first' => $request->file('picture_first'),
                'picture_second' => $request->file('picture_second'),
                'picture_third' => $request->file('picture_third'),
                'picture_fourth' => $request->file('picture_fourth'),
            ];
            foreach ($pictures as $key => $picture) {
                if ($picture && $picture->isValid()) {
                    $imageName = time() . '-' . uniqid() . '.' . $picture->getClientOriginalExtension();
                    $imagePath = $picture->storeAs('assets/img/tours', $imageName, 'public');
                    $tourImage = new TourImages();
                    $tourImage->tour_id = $new_tour->id;
                    $tourImage->picture_image = $imagePath;
                    $tourImage->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'Tur Başarıyla Eklendi']);
        } catch (Exception $error) {
            return response()->json(['success' => false, 'message' => 'Tur Eklenemedi: ' . $error->getMessage()]);
        }
    }
    // Tur Detay Sayfası
    public function edit(Request $request, $id)
    {
        $tour = DB::table('tours')
            ->join('tour_subcategories', 'tour_subcategories.id', '=', 'tours.subcategory_id')
            ->join('hotels', 'hotels.id', '=', 'tours.hotel_id')
            ->join('tour_supervisors', 'tour_supervisors.id', '=', 'tours.supervisor_id')
            ->join('tour_guides', 'tour_guides.id', '=', 'tours.directory_id')
            ->join('users', 'users.id', '=', 'tours.user_id')
            ->where('tours.id', '=', $id)
            ->select('tours.*', 'tour_subcategories.name as subcategory_name', 'hotels.name as hotel_name', 'tour_supervisors.fullname as supervisorName', 'tour_guides.fullname as directorName', 'users.name as userName')
            ->first();
        $tourServices = TourServices::all();
        $tourFeatures = DB::table('tour_features')
            ->where('tour_id', '=', $id)
            ->get();
        $tour_image = DB::table('tour_images')->where('tour_id', '=', $id)->get();
        $tour_features = DB::table('tour_features')
            ->where('tour_features.tour_id', '=', $id)
            ->where('tour_features.status_id', '=', 1)
            ->join('tour_services', 'tour_features.featured_id', '=', 'tour_services.id')
            ->select('tour_features.*', 'tour_services.name as tourServices')
            ->get();
        $tourSubCategories = TourSubcategories::all();
        $hotels = Hotels::all();
        $directors = TourSupervisors::all();
        $supervisors = TourSupervisors::all();


        return view('tours.edit', compact('tour', 'tour_image', 'tour_features', 'tourSubCategories', 'hotels', 'directors', 'supervisors', 'tourServices', 'tourFeatures'));
    }
    // Tur İndex Sayfasında Turların Listelenmesi
    public function fetch(Request $request)
    {
        $tours = Tours::query()
            ->join('tour_supervisors', 'tours.supervisor_id', '=', 'tour_supervisors.id')
            ->select('tours.*', 'tour_supervisors.fullname as supervisor_fullname');

        return datatables()->eloquent($tours)->make(true);
    }
    // Tur Detay Sayfası Tur Bilgilerini Güncelle İşlemi
    public function update(Request $request, $id)
    {

        try {
            $tour = Tours::find($id);

            $tour->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'duration' => $request->duration,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'quota' => $request->quota,
                'transportation_id' => $request->transportation_id,
                'hotel_id' => $request->hotel_id,
                'directory_id' => $request->director_id,
                'supervisor_id' => $request->supervisors,
            ]);
            return response()->json(['success' => true, 'message' => 'Tur Bilgileri Başarıyla Güncellendi !']);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => 'Tur Bilgileri Güncellemedi!' . ' ' . $th->getMessage()]);
        }
    }

    // Tur Özelliklerini Güncelleme İşlemi
    public function updateTourFeatures(Request $request, $tourId)
    {
        // Post edilen hizmetleri al (seçilen hizmetler)
        $selectedFeatures = $request->input('selected_features', []);
        // Mevcut hizmetleri al
        $existingFeatures = DB::table('tour_features')->where('tour_id', $tourId)->get();
        // 1. Önce, mevcut olan tüm 'tour_features' girdilerini kontrol et ve silme işlemi yap
        foreach ($existingFeatures as $existingFeature) {
            // Eğer bu hizmet seçili değilse, veritabanından sil
            if (!in_array($existingFeature->featured_id, $selectedFeatures)) {
                DB::table('tour_features')
                    ->where('id', $existingFeature->id)
                    ->delete(); // Silme işlemi
            }
        }
        // 2. Seçilen özellikleri ekle veya güncelle (status_id 1 veya 0)
        foreach ($selectedFeatures as $featureId) {
            // Eğer özellik zaten var ise, status_id'sini güncelle
            $existingFeature = $existingFeatures->where('featured_id', $featureId)->first();
            if ($existingFeature) {
                // Eğer zaten mevcutsa ve tura dahilse, status_id'yi 1 yap
                DB::table('tour_features')
                    ->where('id', $existingFeature->id)
                    ->update(['status_id' => 1]);
            } else {
                // Eğer yeni bir özellik ekleniyorsa, durumu kontrol et
                $status_id = 1; // Varsayılan olarak tura dahilse (status_id 1)
                // Eğer hizmet tura dahil değilse, status_id'yi 0 yap
                DB::table('tour_features')->insert([
                    'tour_id' => $tourId,
                    'featured_id' => $featureId,
                    'status_id' => $status_id,  // Tura dahilse 1, değilse 0
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Tur özellikleri başarıyla güncellendi.',
        ]);
    }
    // Turu İptal Etme İşlemi
    public function cancelTour(Request $request)
    {
        try {
            $tour = DB::table('tours')->where('id', $request->input('tourId'))->update(['status_id' => 2]);
    
            if ($tour) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tur başarıyla iptal edildi.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tur iptal edilemedi.',
                ]);
            }
    
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => 'Tur İptal Edilemedi: ' . $error->getMessage(),
            ]);
        }
    }
    
}
