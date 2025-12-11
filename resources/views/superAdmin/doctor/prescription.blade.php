@extends('layout.mainlayout_admin',['activePage' => 'appointment'])

@section('title',__('Prescription'))
@section('content')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">{{__('Add Prescription')}}</h4>
        </div>
        <div class="card-body">

            <!-- Add Item -->
            <div class="add-more-item text-right">
                <a href="javascript:void(0);" class="AddMoreRow">
                    <i class="fa fa-plus-circle"></i>{{__('Add More')}}
                </a>
            </div>
            <!-- /Add Item -->

            <!-- Prescription Item -->
            <form action="{{ url('addPrescription') }}" method="post" class="myform">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <input type="hidden" name="user_id" value="{{ $appointment->user_id }}">
                <div class="table-responsive">
                    <table class="table table-bordered table-center">
                    <thead>
                        <tr>
                            <th>{{__('Medicine Name')}}</th>
                            <th>{{__('Days')}}</th>
                            <th>{{__('Time')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="tBody">
                        <tr class="trCopy">
                            <td>
                                <select name="medicines[]" class="select2">
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->name }}">{{ $medicine->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input class="form-control" name="day[]" min="1" value="2" min="1" type="number">
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="p-2">
                                        <input type="checkbox" value="1" id="morning0" name="morning0[]">
                                        <label for="morning0" class="ml-1">{{__('morning')}}</label>
                                    </div>
                                    <div class="p-2">
                                        <input type="checkbox" value="1"  id="afternoon0" name="afternoon0[]">
                                        <label for="afternoon0" class="ml-1">{{__('afternoon')}}</label>
                                    </div>
                                    <div class="p-2">
                                        <input type="checkbox" value="1"  id="night0" name="night0[]">
                                        <label for="night0" class="ml-1">{{__('night')}}</label>
                                    </div>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="submit-section w-100 text-center">
                        <button type="submit" class="btn btn-primary submit-btn">{{__('Save and generate PDF')}}</button>
                    </div>
                </div>
        </div>
    </div>
</section>

@endsection
