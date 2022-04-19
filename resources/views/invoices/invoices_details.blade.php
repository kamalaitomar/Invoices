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
                    <div class="panel panel-primary tabs-style-3 bg-white w-100">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li><a href="#tab14" class="active" data-toggle="tab"><i class="fa fa-tasks"></i> تفاصيل الفاتورة </a></li>
                                    <li><a href="#tab13" data-toggle="tab"><i class="fa fa-cogs"></i> حالات الدفع </a></li>
                                    <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i> مرفقات الفاتورة </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab14">
                                    <table class="table table-striped mg-b-0 text-md-nowrap">
										<tbody>
											<tr>
												<th scope="row">رقم الفاتورة</th>
												<td>{{ $invoice->invoice_number }}</td>
												<th scope="row">تاريخ الفاتورة</th>
												<td>{{ $invoice->invoice_date }}</td>
												<th scope="row">تاريخ الاستحقاق</th>
												<td>{{ $invoice->due_date }}</td>
                                            </tr>
                                            <tr>
												<th scope="row">القسم</th>
												<td>{{ $invoice->section->section_name }}</td>
												<th scope="row">المنتج</th>
												<td>{{ $invoice->product }}</td>
												<th scope="row">مبلغ التحصيل</th>
												<td>{{ $invoice->amount_collection }}</td>
                                            </tr>
                                            <tr>
												<th scope="row">مبلغ العمولة</th>
												<td>{{ $invoice->amount_commission }}</td>
												<th scope="row">الخصم</th>
												<td>{{ $invoice->discount }}</td>
												<th scope="row">نسبة الضريبة</th>
												<td>{{ $invoice->rate_vat }}</td>
											</tr>
                                            <tr>
												<th scope="row">قيمة الضريبة</th>
												<td>{{ $invoice->value_vat }}</td>
												<th scope="row">الاجمالي شامل الضريبة</th>
												<td>{{ $invoice->total }}</td>
												<th scope="row">الحالة الحالية</th>
												<td>
                                                    @if ($invoice->value_status == 1)
                                                        <span class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                    @elseif ($invoice->value_status == 2)
                                                        <span class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                    @else 
                                                        <span class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                                    @endif
                                                </td>
											</tr>
                                            <tr>
												<th scope="row">ملاحظات</th>
												<td>{{ $invoice->note }}</td>
											</tr>
										</tbody>
									</table>
                                </div>
                                <div class="tab-pane" id="tab13">
                                    <table class="table mg-b-0 text-md-nowrap">
										<thead>
											<tr>
												<th>#</th>
												<th>رقم الفاتورة</th>
												<th>المنتج</th>
												<th>القسم</th>
												<th>الحالة</th>
												<th>تاريخ الدفع</th>
												<th>ملاحظات</th>
												<th>تاريخ الإضافة</th>
												<th>المستخدم</th>
											</tr>
										</thead>
										<tbody>
                                            @php $i = 0 @endphp
                                            @foreach ($invoiceDetails as $detail)
                                                @php $i++ @endphp
                                                <tr>
                                                    <th scope="row">$i</th>
                                                    <td>{{ $detail->invoice_number }}</td>
                                                    <td>{{ $detail->product }}</td>
                                                    <td>{{ $invoice->section->section_name }}</td>
                                                    <td>
                                                        @if ($detail->Value_Status == 1)
                                                            <span class="badge badge-pill badge-success">{{ $detail->Status }}</span>
                                                        @elseif ($detail->Value_Status == 2)
                                                            <span class="badge badge-pill badge-danger">{{ $detail->Status }}</span>
                                                        @else 
                                                            <span class="badge badge-pill badge-warning">{{ $detail->Status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($detail->Payment_Date)
                                                            <span>{{ $detail->Payment_Date }}</span>
                                                        @else
                                                            <span class="badge badge-pill badge-warning">لم تدفع بعد</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $detail->note }}</td>
                                                    <td>{{ $detail->created_at }}</td>
                                                    <td>{{ $detail->user }}</td>
                                                </tr>
                                            @endforeach
										</tbody>
									</table>
                                </div>
                                <div class="tab-pane" id="tab12">
                                    <table class="table mg-b-0 text-md-nowrap">
										<thead>
											<tr>
												<th>#</th>
												<th>اسم الملف</th>
												<th>قام بالاضافة</th>
												<th>تاريخ الإضافة</th>
												<th>العمليات</th>
											</tr>
										</thead>
										<tbody>
                                            @php $x = 0 @endphp
                                            @foreach ($attachments as $attachment)
                                                @php $x++ @endphp
                                                <tr>
                                                    <th scope="row">$x</th>
                                                    <td>{{ $attachment->file_name }}</td>
                                                    <td>{{ $attachment->Created_by }}</td>
                                                    <td>{{ $attachment->created_at }}</td>
                                                    <td>
                                                        <a class="btn btn-outline-success btn-sm"
                                                        href="{{ url('View_file') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                                        عرض</a>

                                                    {{-- <a class="btn btn-outline-info btn-sm"
                                                        href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                        role="button"><i
                                                            class="fas fa-download"></i>&nbsp;
                                                        تحميل</a>

                                                    @can('حذف المرفق')
                                                        <button class="btn btn-outline-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-file_name="{{ $attachment->file_name }}"
                                                            data-invoice_number="{{ $attachment->invoice_number }}"
                                                            data-id_file="{{ $attachment->id }}"
                                                            data-target="#delete_file">حذف</button>
                                                    @endcan --}}
                                                    </td>
                                                </tr>
                                            @endforeach
										</tbody>
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