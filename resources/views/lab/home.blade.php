@extends('layout.mainlayout_admin', ['activePage' => 'pathologist'])

@section('title', __('Pathologist name'))

@section('content')

    <section class="section">
        @include('layout.breadcrumb', [
            'title' => __('Dashboard'),
        ])
        <div class="section_body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-vials"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Total Pathology') }}</h4>
                            </div>
                            <div class="card-body">
                                <h3>{{ $pathology }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-x-ray"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h6 class="text-muted">{{ __('Total Radiology') }}</h6>
                            </div>
                            <div class="card-body">
                                <h3>{{ $radiology }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card">
                    <div class="card-header w-100 text-right d-flex justify-content-between">
                        <h6>{{ __('Todays Report') }}</h6>
                        @include('superAdmin.auth.exportButtons')
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        @if (!auth()->user()->hasRole('laboratory') && Gate::check('radiology_access'))
                                        <th>{{ __('Laboratory Name') }}</th>
                                            <th>{{ __('Report') }}</th>
                                        @endif
                                        <th>{{ __('Prescription') }}</th>
                                        <th>{{ __('Date time') }}</th>
                                        <th>{{ __('Payment Type') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('View') }}</th>
                                        @if (auth()->user()->hasRole('laboratory'))
                                            <th>{{ __('Upload Report') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($test_reports as $test_report)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @if (!auth()->user()->hasRole('laboratory') && Gate::check('radiology_access'))
                                            <td>{{ $test_report->lab['name'] }}</td>
                                                <td>
                                                    @if ($test_report->upload_report == null)
                                                        {{ __('Report Not Available.') }}
                                                    @else
                                                        <a href="{{ 'report_prescription/report/' . $test_report->upload_report }}"
                                                            data-fancybox="gallery2">
                                                            {{ __('Report') }}
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif
                                            <td class="d-flex">
                                                @if ($test_report->prescription != null)
                                                    <a href="{{ 'report_prescription/upload/' . $test_report->prescription }}"
                                                        data-fancybox="gallery2">
                                                        <img src="{{ 'report_prescription/upload/' . $test_report->prescription }}"
                                                            alt="Feature Image" width="50px" height="50px">
                                                    </a>
                                                @else
                                                    {{ __('Prescription Not available') }}
                                                @endif
                                            </td>
                                            <td>{{ $test_report->date }}<span
                                                    class="d-block text-info">{{ $test_report->time }}</span></td>
                                            <td>{{ $test_report->payment_type }}</td>
                                            <td>{{ $currency }}{{ $test_report->amount }}</td>
                                            <td>
                                                <a onclick="single_report({{ $test_report->id }})" class="text-info ml-2"
                                                    href="#edit_specialities_details" data-toggle="modal">
                                                    {{ __('View') }}
                                                </a>
                                            </td>
                                            @if (auth()->user()->hasRole('laboratory'))
                                                <td>
                                                    @if ($test_report->upload_report == null)
                                                        <a onclick="upload_report({{ $test_report->id }})"
                                                            class="text-info ml-2" href="#upload_report"
                                                            data-toggle="modal">
                                                            {{ __('Upload Report') }}
                                                        </a>
                                                    @else
                                                        <a class="text-success"
                                                            href="{{ 'report_prescription/report/' . $test_report->upload_report }}"
                                                            data-fancybox="gallery2">
                                                            {{ __('Report') }}
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card_fotter">
                        <input type="button" value="delete selected" onclick="deleteAll('doctor_all_delete')"
                            class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="edit_specialities_details" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Test Report') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>{{ __('Report Id') }}</td>
                            <td class="report_id"></td>
                        </tr>
                        <tr>
                            <td>{{ __('patient name') }}</td>
                            <td class="patient_name"></td>
                        </tr>
                        <tr>
                            <td>{{ __('patient phone number') }}</td>
                            <td class="patient_phone"></td>
                        </tr>
                        <tr>
                            <td>{{ __('patient age') }}</td>
                            <td class="patient_age"></td>
                        </tr>
                        <tr>
                            <td>{{ __('patient gender') }}</td>
                            <td class="patient_gender"></td>
                        </tr>
                        <tr>
                            <td>{{ __('amount') }}</td>
                            <td class="amount"></td>
                        </tr>
                        <tr>
                            <td>{{ __('payment status') }}</td>
                            <td class="payment_status"></td>
                        </tr>
                        <tr>
                            <td>{{ __('payment type') }}</td>
                            <td class="payment_type"></td>
                        </tr>
                        <tr class="pathology_category_id">
                            <td>{{ __('Pathology category') }}</td>
                            <td class="pathology_category"></td>
                        </tr>
                        <tr class="radiology_category_id">
                            <td>{{ __('Radiology category') }}</td>
                            <td class="radiology_category"></td>
                        </tr>
                        <table class="table types">
                        </table>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload_report" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Upload Report') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('upload_report') }}" method="post" enctype="multipart/form-data" class="myform">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="report_id">
                        <div class="form-group">
                            <label for="email" class="col-form-label"> {{ __('Upload Report') }}</label>
                            <input type="file" name="upload_report"
                                class="form-control @error('upload_report') is-invalid @enderror" required>
                            @error('upload_report')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
