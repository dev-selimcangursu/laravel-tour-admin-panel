@extends('partials.master')

@section('main')
<div class="page-inner">
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tourInfoUpdateModal">
        Tur Bilgilerini Güncelle
    </button>
    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
       Tur Paket Hizmetlerini Güncelle
    </button>
    @if($tour->status_id == 1)
     <button id="cancelTourButton" class="btn btn-danger mb-3">Turu İptal Et</button>
    @endif
    <button class="btn btn-warning mb-3">Tur Bilgilerini Yazdır</button>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tur Özeti</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $tour->main_picture) }}" alt="">
                    </div>
                    <p><strong>Tur Durumu:</strong>  
                        @if($tour->status_id == 1)
                            <span class="badge text-bg-primary">Aktif Tur</span>
                        @elseif($tour->status_id == 2)
                            <span class="badge text-bg-danger">İptal Edildi</span>
                        @elseif($tour->status_id == 3)
                            <span class="badge text-bg-danger">Tur Tamamlandı</span>
                        @endif
                    </p>
                    <p><strong>Tur Adı:</strong> {{$tour->name}}</p>
                    <p><strong>Başlangıç Tarih:</strong> {{$tour->start_date}}</p>
                    <p><strong>Bitiş Tarih:</strong> {{$tour->end_date}}</p>
                    <p><strong>Toplam Süre:</strong> {{$tour->duration}} Gün</p>
                    <p><strong>Fiyat:</strong> ₺{{$tour->price}}</p>
                    <p><strong>Açıklama:</strong> Ege'nin eşsiz güzelliklerini keşfedin. Denizin ve doğanın keyfini çıkarabileceğiniz bir tatil sizi bekliyor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tur Detayları</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Tur Kategorisi:</strong>
                                @if($tour->category_id == 1)
                                    Yurtiçi Turu
                                @else
                                    Yurtdışı Turu
                                @endif
                            </li>
                            <li><strong>Tur Alt Kategorisi:</strong> {{$tour->subcategory_name}}</li>
                            <li><strong>Kontejan:</strong> {{$tour->quota}} Kişi</li>
                            <li><strong>Ulaşım:</strong> 
                                @if($tour->transportation_id == 1)
                                    Otobüsle Ulaşım
                                @elseif($tour->transportation_id == 2)
                                    Uçakla Ulaşım
                                @elseif($tour->transportation_id == 3)
                                    Trenle Ulaşım
                                @endif
                            </li>
                            <li><strong>Konaklama Bilgisi:</strong> {{$tour->hotel_name}}</li>
                            <li><strong>Tur Danışmanı:</strong> {{$tour->supervisorName}}</li>
                            <li><strong>Tur Rehberi:</strong> {{$tour->directorName}}</li>
                            <li><strong>Turu Oluşturan Personel:</strong> {{$tour->userName}}</li>
                            <li><strong>Tur Oluşturulma Tarihi:</strong> {{$tour->created_at}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tura Dahil Olanlar</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    @foreach($tour_features as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{$item->tourServices}}
                                            <span class="badge badge-success badge-pill">Dahil</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tur Görselleri</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($tour_image as $item)
                                <div class="col-md-6 mt-5">
                                    <img src="{{ asset('storage/' . $item->picture_image) }}" class="img-fluid" alt="Tur Görseli 1">
                                </div>
                            @endforeach  
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tur Bilgilerini Güncelle Modal-->
            <div class="modal fade" id="tourInfoUpdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tur Bilgilerini Güncelle</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateTourForm">
                                @csrf
                                <div class="row">
                                    <!-- Form Fields -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Adı</label>
                                            <input type="text" class="form-control" value="{{$tour->name}}" name="name" id="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Başlangıç Tarihi</label>
                                            <input type="date" class="form-control" value="{{$tour->start_date}}" name="start_date" id="start_date">
                                        </div>
                                    </div>
                                    <!-- Other Form Fields -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Bitiş Tarihi</label>
                                            <input type="date" class="form-control" value="{{$tour->end_date}}" name="end_date" id="end_date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Toplam Gün Sayısı</label>
                                            <input type="text" class="form-control" value="{{$tour->duration}}" name="duration" id="duration">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Fiyatı</label>
                                            <input type="text" class="form-control" value="{{$tour->price}}" name="price" id="price">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Kategorisi</label>
                                            <select class="form-select form-control" name="category_id" id="category_id">
                                                <option value="0" {{ $tour->category_id == 0 ? 'selected' : '' }}>Seçiniz...</option>
                                                <option value="1" {{ $tour->category_id == 1 ? 'selected' : '' }}>Yurtiçi Tur</option>
                                                <option value="2" {{ $tour->category_id == 2 ? 'selected' : '' }}>Yurtdışı Tur</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Alt Kategorisi</label>
                                            <select class="form-select" name="subcategory_id" id="subcategory_id">
                                                @foreach($tourSubCategories as $item)
                                                    <option value="{{ $item->id }}" {{ $tour->subcategory_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Other Fields -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Kontejan Sayısı</label>
                                            <input type="text" class="form-control" value="{{$tour->quota}}" name="quota" id="quota">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Ulaşım Türü</label>
                                            <select class="form-select form-control" name="transportation_id" id="transportation_id">
                                                <option value="0" {{ $tour->transportation_id == 0 ? 'selected' : '' }}>Seçiniz...</option>
                                                <option value="1" {{ $tour->transportation_id == 1 ? 'selected' : '' }}>Otobüs</option>
                                                <option value="2" {{ $tour->transportation_id == 2 ? 'selected' : '' }}>Uçak</option>
                                                <option value="3" {{ $tour->transportation_id == 3 ? 'selected' : '' }}>Tren</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Konaklanacak Otel</label>
                                            <select class="form-select" name="hotel_id" id="hotel_id">
                                                @foreach($hotels as $item)
                                                    <option value="{{ $item->id }}" {{ $tour->hotel_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Rehberi</label>
                                            <select class="form-select" name="director_id" id="director_id">
                                                @foreach($directors as $item)
                                                    <option value="{{ $item->id }}" {{ $tour->directory_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->fullname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tur Danışmanı</label>
                                            <select class="form-select" name="supervisors" id="supervisors">
                                                @foreach($supervisors as $item)
                                                    <option value="{{ $item->id }}" {{ $tour->supervisor_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->fullname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                    <button type="submit" class="btn btn-primary">Tur Bilgilerini Güncelle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tur Paket Hizmetleri Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tur Paket Hizmetleri</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateTourFeaturedForm">
                            <h6><b>Tur Paketine Dahil Hizmetler</b></h6>
                            <div class="row">
                                @foreach($tourServices as $item)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$item->id}}" id="flexCheckDefault" 
                                                @foreach($tourFeatures as $feature)
                                                    @if($feature->featured_id == $item->id && $feature->status_id == 1)
                                                        checked
                                                    @endif
                                                @endforeach
                                            >
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{$item->name}}
                                            </label>
                                        </div>
                                    </div> 
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // Tur Bilgilerini Güncelle
        $('#updateTourForm').submit(function(e) {
            e.preventDefault();
    
            var formData = new FormData(this);  
            let id = {{$tour->id}}; 
    
            $.ajax({
                url: `{{ route('tours.update', '') }}/${id}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            title: response.message,
                            icon: "success",
                            confirmButtonText: 'Tamam',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: response.message,
                            icon: "error",
                            confirmButtonText: 'Tamam',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Bilinmeyen Hata!',
                        icon: 'error',
                        text: 'Bir hata oluştu, lütfen tekrar deneyin.',
                        confirmButtonText: 'Tamam',
                        confirmButtonColor: '#dc3545' 
                    });
                }
            });
        });
    
        // Tur Hizmetlerini Güncelle
        $('#updateTourFeaturedForm').submit(function(e) {
            e.preventDefault();
    
            var selectedFeatures = [];
            $('input[type="checkbox"]:checked').each(function() {
                selectedFeatures.push($(this).val());
            });
    
            $.ajax({
                url: `{{ route('tour.update.features', $tour->id) }}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', 
                    selected_features: selectedFeatures,
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: response.message,
                            icon: "success",
                            confirmButtonText: 'Tamam',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire({
                            title: response.message,
                            icon: "error",
                            confirmButtonText: 'Tamam',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Bilinmeyen Hata!',
                        text: 'Bir hata oluştu, lütfen tekrar deneyin.',
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        });
    
    // Turu İptal Et
    $('#cancelTourButton').click(function(e) {
    e.preventDefault();
    let tourId = {{$tour->id}}; 

    $.ajax({
        url:"{{route('tour.remove')}}",
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status_id: 2,
            tourId:tourId
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: response.message,
                    icon: 'success',
                    confirmButtonText: 'Tamam'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Bir hata oluştu!',
                    icon: 'error',
                    text: response.message,
                    confirmButtonText: 'Tamam'
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Bilinmeyen Hata!',
                icon: 'error',
                text: 'Bir hata oluştu, lütfen tekrar deneyin.',
                confirmButtonText: 'Tamam'
            });
        }
    });
});

    });
    </script>
    

@endsection
