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
                <h2 class="text-white font-weight-bold my-2 mr-5">Data Nomor Surat</h2>
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
                    <a href="" class="text-white text-hover-white opacity-75 hover-opacity-100">Data Nomor Surat</a>
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
                        <span class="card-label font-weight-bolder text-dark font-size-h1">Data Nomor Surat</span>
                        {{--<span class="text-muted mt-3 font-weight-bold font-size-sm">Memuat daftar data-data bahan baku</span>--}}
                    </h3>
                    <div class="card-toolbar">
                        <button  class="btn btn-danger btn-pil font-weight-bolder font-size-sm px-5" onclick="create()" style="border-radius: 1.5rem;"><i class="flaticon2-plus mr-2"></i>Buat Nomor Baru</button>
                    </div>
                    <!--end::Title-->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 mb-8">
                            <select class="form-control select2" id="select-sector-penomoran" name="sector-id[]" multiple="multiple" style="width:100%">
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button  class="btn btn-outline-success btn-pil font-weight-bolder font-size-sm px-5 w-100" onclick="filtered()"><i class="fas fa-filter mr-2"></i>Filter</button>
                        </div>
                    </div>
                    <!--begin::Table--> 
                    <div class="kt-portlet__body">
                        <div id="table-wrapper"></div>
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
<script>
    var imgDetail="{{asset('assets/extends/images/ic_empty.svg')}}"
</script>

@include('components.modal') 
<script src="{{asset('assets/extends')}}/plugins/masking-input.js" data-autoinit="true"></script>
<script src="{{asset('assets/extends/js/grid.js')}}"></script>
@endsection