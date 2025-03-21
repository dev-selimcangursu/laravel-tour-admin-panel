@extends('partials.master')
@section('main')
<div class="page-inner">

      <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tur Yönetimi</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tur Adı</th>
                                <th>Tur Kategorisi</th>
                                <th>Tur Tarihi</th>
                                <th>Bitiş Tarihi</th>
                                <th>Fiyat</th>
                                <th>Kontenjan</th>
                                <th>Durum</th>
                                <th>Tur Danışmanı</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
  </div>
  <script>
    $(document).ready(function(){
        $('#basic-datatables').DataTable({
            'serverSide': true,
            'processing': true,
            ajax: {
                type: "GET",
                url: "{{route('tours.fetch')}}",
            },
            columns: [
                {data: "id", name: "id"},
                {data: "name", name: "name"},
                {data: "category_id", name: "category_id", render: function(data, type, row) {
                  return data == 1 ? 'Yurtiçi Seyehat' : 'Yurtdışı Seyehat';
                }},
                {data: "start_date", name: "start_date"},
                {data: "end_date", name: "end_date"},
                {data: "price", name: "price" ,render:function(data,type,row){
                    return `${data}₺`
                }},
                {data: "quota", name: "quota"},      
                {data: "status_id", name: "status_id",render:function(data,type,row){
                    return data== 1 ? "Aktif Tur" : "Tur Gerçekleştirildi"
                }},
                {data: "supervisor_fullname", name: "supervisor_fullname"},
                {data: "action", render: function(data, type, row) {
                    return `<a href="/tours/edit/${row.id}" class="btn btn-success btn-sm">Detay</a>`;
                }},
            ]
        });
    })
</script>

@endsection
