@extends('partials.master')
@section('main')
<div class="page-inner">

    <div class="col-md-12">
      <div class="card">
          <div class="card-header">
              <h4 class="card-title">Yeni Tur Oluştur</h4>
          </div>
          <div class="card-body">
              <form enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tur Adı:</b></label>
                            <input
                              type="text"
                              class="form-control"
                              id="name"
                              placeholder="Tur Adını Giriniz..."
                            />
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tur Kategorisi:</b></label>
                            <select class="form-select form-control" id="category_id">
                              <option value="0" selected>Seçiniz...</option>
                              <option value="1">Yurtiçi Tur</option>
                              <option value="2">Yurtdışı Tur</option>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tur Alt Kategorisi:</b></label>
                            <select class="form-select form-control" id="subcategory_id">
                            <option value="0" selected>Seçiniz...</option>
                             @foreach ($tour_subcategories as $item)
                               <option value="{{$item->id}}">{{$item->name}}</option> 
                             @endforeach
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tur Başlangıç Tarihi:</b></label>
                            <input
                              type="date"
                              class="form-control"
                              id="start_date"
                            />
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tur Bitiş Tarihi:</b></label>
                            <input
                              type="date"
                              class="form-control"
                              id="end_date"
                            />
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tur Süresi:</b></label>
                            <input
                              type="text"
                              class="form-control"
                              id="duration"
                              placeholder="Gün Sayısını Giriniz.."
                            />
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Kontejan Bilgisi: </b></label>
                            <input
                              type="text"
                              class="form-control"
                              id="quota"
                              placeholder="Tur Kontejan Sayısını Giriniz..."
                            />
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Ulaşım Türü:</b></label>
                            <select class="form-select form-control" id="transportation_id">
                             <option value="0" selected>Seçiniz...</option>
                              <option value="1">Otobüs </option>
                              <option value="2">Uçak</option>
                              <option value="3">Bireysel Ulaşım</option>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tur Kalkış Yeri:</b></label>
                            <select class="form-select form-control" id="starting_place">
                                <option value="0" selected>Seçiniz...</option>
                              <option value="1">İstanbul </option>
                              <option value="2">Samsun</option>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Otel Bilgisi:</b></label>
                            <select class="form-select form-control" id="hotel_id">
                                <option value="0" selected>Seçiniz...</option>
                                @foreach ($hotels as $item)
                                <option value="{{$item->id}}">{{$item->name}} </option>
                                @endforeach
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Kişi Başı Tur Fiyatı Fiyat:</b></label>
                            <input
                              type="text"
                              class="form-control"
                              id="price"
                              placeholder="Fiyat Giriniz.."
                            />
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tur Ana Görseli</b></label>
                            <input
                              type="file"
                              class="form-control"
                              id="tour_picture"
                            />
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Rehber Bilgisi</b></label>
                            <select class="form-select form-control" id="directory_id">
                                <option value="0" selected>Seçiniz...</option>
                                @foreach ($guides as $item)
                                <option value="{{$item->id}}">{{$item->fullname}} </option>
                                @endforeach
                              </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Danışman Bilgisi</b></label>
                            <select class="form-select form-control" id="supervisor_id">
                                <option value="0" selected>Seçiniz...</option>
                                @foreach ($supervisors as $item)
                                <option value="{{$item->id}}">{{$item->fullname}} </option>
                                @endforeach
                              </select>
                          </div>
                    </div>
                    <div class="col-md-12">
                      <h6><b>Tura Dahil Olan Hizmetler:</b></h6>
                      <div class="row">
                          @foreach ($tour_services as $item)
                          <div class="col-md-3">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="included_services[]" value="{{$item->id}}">
                                <label class="form-check-label">
                                      {{$item->name}}
                                  </label>
                              </div>
                          </div>  
                          @endforeach              
                      </div>
                  </div>
                  <div class="col-md-12">
                      <h6><b>Tura Dahil Olmayan Olan Hizmetler:</b></h6>
                      <div class="row">
                          @foreach ($tour_services as $item)
                          <div class="col-md-3">
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="excluded_services[]" value="{{$item->id}}">
                                  <label class="form-check-label">
                                      {{$item->name}}
                                  </label>
                              </div>
                          </div>  
                          @endforeach                                    
                      </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><b>Tur Görseli 1 </b></label>
                          <input
                            type="file"
                            class="form-control"
                            id="picture_first"
                          />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><b>Tur Görseli 2 </b></label>
                          <input
                            type="file"
                            class="form-control"
                            id="picture_second"
                          />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><b>Tur Görseli 3 </b></label>
                          <input
                            type="file"
                            class="form-control"
                            id="picture_third"
                          />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><b>Tur Görseli 4 </b></label>
                          <input
                            type="file"
                            class="form-control"
                            id="picture_fourth"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
                <button id="save" class="btn btn-success float-end"> <i class="fas fa-save"></i>Turu Oluştur</button>
              </form>
          </div>
      </div>
    </div>
</div>
<script>
  $(document).ready(function(){
    $('#save').click(function(e) {
        e.preventDefault();
        
        let formData = new FormData(); 

        formData.append('name', $('#name').val());
        formData.append('category_id', $('#category_id').val());
        formData.append('subcategory_id', $('#subcategory_id').val());
        formData.append('start_date', $('#start_date').val());
        formData.append('end_date', $('#end_date').val());
        formData.append('duration', $('#duration').val());
        formData.append('quota', $('#quota').val());
        formData.append('transportation_id', $('#transportation_id').val());
        formData.append('starting_place', $('#starting_place').val());
        formData.append('hotel_id', $('#hotel_id').val());
        formData.append('price', $('#price').val());
        formData.append('directory_id', $('#directory_id').val());
        formData.append('supervisor_id', $('#supervisor_id').val());
        
        let includedServices = [];
         $('input[name="included_services[]"]:checked').each(function() {
         includedServices.push($(this).val());
        });
        formData.append('included_services', JSON.stringify(includedServices));  

        let excludedServices = [];
         $('input[name="excluded_services[]"]:checked').each(function() {
          excludedServices.push($(this).val());
        });
        formData.append('excluded_services', JSON.stringify(excludedServices)); 

        let tour_picture = $('#tour_picture')[0].files[0];
        if (tour_picture) {
            formData.append('tour_picture', tour_picture);
        }
        let picture_first = $('#picture_first')[0].files[0];
        if (picture_first) {
            formData.append('picture_first', picture_first);
        }
        let picture_second = $('#picture_second')[0].files[0];
        if (picture_second) {
            formData.append('picture_second', picture_second);

        }  
        let picture_third = $('#picture_third')[0].files[0];
        if (picture_third) {
            formData.append('picture_third', picture_third);
        }  
        let picture_fourth = $('#picture_fourth')[0].files[0];
        if (picture_fourth) {
            formData.append('picture_fourth', picture_fourth);
        }
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            type: "POST",
            url: "{{ route('tours.store') }}",  
            data: formData,
            contentType: false,  
            processData: false,  
            success: function(response) {
				     	swal(response.message, {
					    	icon : "success",
					    	buttons: {        			
						  	confirm: {
								className : 'btn btn-success'
						  	}},
				     	});
              console.log(response);
            },
            error: function(xhr, status, error) {
              swal(response.message, {
					    	icon : "error",
					    	buttons: {        			
						  	confirm: {
								className : 'btn btn-success'
						  	}},
				     	});
                console.log('Hata: ' + error);  
                console.log(xhr.responseText);
            }
        });
    });
});

</script>
@endsection