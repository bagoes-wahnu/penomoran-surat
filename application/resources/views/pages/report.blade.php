@extends('layout.main')
@section('content')
<link href="{{asset('assets/extends')}}/plugins/masking-input.css" rel="stylesheet" type="text/css"/>
<div class="subheader min-h-lg-175px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            <!--begin::Heading-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h2 class="text-white font-weight-bold my-2 mr-5">Report</h2>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <div class="d-flex align-items-center font-weight-bold my-2">
                    <!--begin::Item-->
                    <a href="#" class="opacity-75 hover-opacity-100">
                        <i class="flaticon2-shelter text-white icon-1x"></i>
                    </a>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                    <a href="" class="text-white text-hover-white opacity-75 hover-opacity-100">Report</a>
                    <!--end::Item-->
                </div>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Heading-->
        </div>
        <!--end::Details-->
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="col=md-12 row">
            <!--begin::Tiles Widget 3-->
            <div class="w-100 card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b">
                <div class="card-header border-0 py-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark font-size-h1">Report</span>
                        {{--<span class="text-muted mt-3 font-weight-bold font-size-sm">Memuat daftar data-data bahan baku</span>--}}
                    </h3>
                    
                    <!--end::Title-->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8 row">
                            <div class="col-md-12">
                                <p class="font-weight-bolder">Harap isi form dibawah untuk melakukan cetak report</p>
                            </div>
                            <div class="col-md-3 py-2 text-center mb-4"><label>Range Number</label></div>
                            <div class="col-md-4 p-0">
                                <input type="number" id="num-awal" class="form-control" placeholder="cth:01" />
                            </div>
                            <div class="col-md-1 text-center py-2 px-0">
                                <span class="mx-4 font-weight-bolder">S/d</span>
                            </div>
                            <div class="col-md-4 p-0">
                                <input type="number" id="num-akhir" class="form-control" placeholder="cth:01" />
                            </div>
                            <div class="col-md-3 py-2 text-center"><label>Range Tanggal</label></div>
                            <div class="col-md-4 p-0">
                               <input type="text" id="tgl-awal" class="form-control" readonly="readonly" placeholder="Pilih Tanggal Mulai" />
                            </div>
                            <div class="col-md-1 text-center py-2 px-0">
                                <span class="mx-4 font-weight-bolder">S/d</span>
                            </div>
                            <div class="col-md-4 p-0">
                               <input type="text" id="tgl-akhir" class="form-control" readonly="readonly" placeholder="Pilih Tanggal Selesai" />
                            </div>
                    
                            
                            
                            <div class="col-md-2"></div>
                            <div class="col-md-10 mt-12">
                                <button class="btn btn-light font-weight-bolder font-size-sm px-5 w-25" onclick="perview()">Perview</button>
                                <button  class="btn btn-light-success font-weight-bolder font-size-sm px-5 w-25" onclick="cetak()">Export Excel</button>
                            </div>
                            
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                                       
                </div>
            </div>
            <!--end::Tiles Widget 3-->
        </div>
        <!--end::Row-->
        <!--end::Dashboard-->
    </div>
    <!--end::Container-->
</div>


@include('components.modal') 
<script src="{{asset('assets/extends')}}/plugins/masking-input.js" data-autoinit="true"></script>
<script src="{{asset('assets/extends/js/report.js')}}"></script>
@endsection