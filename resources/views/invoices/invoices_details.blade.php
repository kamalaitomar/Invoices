@extends('layouts.master')
@section('css')
@endsection
@section('title')
تفاصيل الفاتورة
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة
                            </span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <div class="panel panel-primary tabs-style-3 bg-white">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li><a href="#tab14" class="active" data-toggle="tab"><i class="fa fa-tasks"></i> تفاصيل الفاتورة </a></li>
                                    <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i> مرفقات الفاتورة </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab14">
                                    <table class="table mg-b-0 text-md-nowrap">
										<tr>
                                                <th>رقم الفاتورة</th>
                                                <td>{{$invoiceDetails->invoice_number}}</td>
                                        </tr>
										<tr>
                                                <th>المنتج</th>
                                                <td>{{$invoiceDetails->product}}</td>
                                        </tr>
										<tr>
                                                <th>القسم</th>
                                                <td>{{$invoice->section->section_name}}</td>
                                        </tr>
										<tr>
                                                <th>الحالة</th>
                                                <td>{{$invoiceDetails->Status}}</td>
                                        </tr>
										<tr>
                                                <th>تاريخ الدفع</th>
                                                <td>{{$invoiceDetails->Payment_Date}}</td>
                                        </tr>
										<tr>
                                                <th>ملاحظات</th>
                                                <td>{{$invoiceDetails->note}}</td>
                                        </tr>
										<tr>
                                                <th>أنشأت من طرف</th>
                                                <td>{{$invoiceDetails->user}}</td>
                                        </tr>
									</table>
                                </div>
                                <div class="tab-pane" id="tab12">
                                    <table class="table mg-b-0 text-md-nowrap">
										<tr>
                                            <th scope="row">1</th>
                                            <td>Joan Powell</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Joan Powell</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Joan Powell</td>
                                        </tr>
									</table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection