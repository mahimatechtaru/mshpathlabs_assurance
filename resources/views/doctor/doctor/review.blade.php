@extends('layout.mainlayout_admin',['activePage' => 'review'])

@section('title',__('Doctor Review'))

@section('content')
<section class="section">
        @include('layout.breadcrumb',[
            'title' => __('Review'),
        ])

        @if (session('status'))
            @include('superAdmin.auth.status',[
                'status' => session('status')])
            @endif
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0 text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Appointment Id')}}</th>
                                <th>{{__('User name')}}</th>
                                <th>{{__('Review')}}</th>
                                <th>{{__('Rate')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- @if($review->appointment) --}}
                                    <td>{{ $review->appointment['appointment_id'] }}</td>
                                {{-- @endif --}}
                                <td>{{ $review->user['name'] }}</td>
                                <td>{{ $review->review }}</td>
                                <td>
                                    @for ($i = 1; $i < 6; $i++)
                                        @if ($review->rate >= $i)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
@endsection
