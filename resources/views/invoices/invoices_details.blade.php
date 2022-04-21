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
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row">
        <div class="panel panel-primary tabs-style-3 bg-white w-100">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li><a href="#tab14" class="active" data-toggle="tab"><i class="fa fa-tasks"></i> تفاصيل
                                الفاتورة </a></li>
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
                        <!--المرفقات-->
                        <div class="card card-statistics">
                            <div class="card-body">
                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                <h5 class="card-title">اضافة مرفقات</h5>
                                <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file_name"
                                            required>
                                        <input type="hidden" id="customFile" name="invoice_number"
                                            value="{{ $invoice->invoice_number }}">
                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                            value="{{ $invoice->id }}">
                                        <label class="custom-file-label" for="customFile">حدد
                                            المرفق</label>
                                    </div><br><br>
                                    <button type="submit" class="btn btn-primary btn-sm " name="uploadedFile">تاكيد</button>
                                </form>
                            </div>
                            <br>
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
                                                    role="button" target="_blank"><i class="fas fa-eye"></i>&nbsp;
                                                    عرض</a>

                                                <a class="btn btn-outline-info btn-sm"
                                                    href="{{ url('Download_file') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                    role="button" target="_blank"><i class="fas fa-download"></i>&nbsp;
                                                    تحميل</a>


                                                <button class="btn btn-outline-danger btn-sm" data-toggle="modal"
                                                    data-file_name="{{ $attachment->file_name }}"
                                                    data-invoice_number="{{ $attachment->invoice_number }}"
                                                    data-id_file="{{ $attachment->id }}"
                                                    data-target="#delete_file">حذف</button>
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
        <!-- delete -->
        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('Delete_file') }}" method="post">

                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p class="text-center">
                            <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                            </p>

                            <input type="hidden" name="id_file" id="id_file" value="">
                            <input type="hidden" name="file_name" id="file_name" value="">
                            <input type="hidden" name="invoice_number" id="invoice_number" value="">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
