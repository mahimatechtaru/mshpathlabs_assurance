@extends('layout.mainlayout_admin',['activePage' => 'offer'])

@section('title',__('All offer'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Offer'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif
    <div class="section_body">
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('offer_add')
                    <a href="{{ url('offer/create') }}">{{ __('Add New') }}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable table-center mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th>#</th>
                                <th>{{__('Offer Image')}}</th>
                                <th>{{__('Offer Name')}}</th>
                                <th>{{__('Offer code')}}</th>
                                <th>{{__('start_end_date')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('offer_edit') || Gate::check('offer_delete'))
                                    <th>{{__('Actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offers as $offer)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$offer->id}}" id="{{$offer->id}}" data-id="{{ $offer->id }}" class="sub_chk">
                                        <label for="{{$offer->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ $offer->fullImage }}" data-fancybox="gallery2">
                                            <img src="{{ $offer->fullImage }}" width="50" height="50" class="rounded" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        {{ $offer->name }}
                                    </td>
                                    <td>{{ $offer->offer_code }}</td>
                                    <td>{{ $offer->start_end_date }}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$offer->id}}" class="custom-switch-input" name="status" onchange="change_status('offer',{{ $offer->id }})" class="check" {{ $offer->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('offer_edit') || Gate::check('offer_delete'))
                                        <td>
                                            @can('offer_edit')
                                            <a class="text-success" href="{{url('offer/'.$offer->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('offer_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('offer',{{ $offer->id }})">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <input type="button" value="delete selected" onclick="deleteAll('offer_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>
@endsection
