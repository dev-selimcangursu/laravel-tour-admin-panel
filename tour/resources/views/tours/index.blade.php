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
                            <tr>
                                <td>1</td>
                                <td>System Architect</td>
                                <td>Yurtiçi Tur</td>
                                <td>25.03.2025</td>
                                <td>30.03.2025</td>
                                <td>5500 TL</td>
                                <td>200</td>
                                <td>Beklemede</td>
                                <td>Selimcan Gürsu</td>
                                <td><Button class="btn btn-success btn-sm">Detay</Button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
  </div>

@endsection
