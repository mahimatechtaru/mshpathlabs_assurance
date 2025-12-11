@extends('layout.mainlayout',['activePage' => 'pharmacy'])

@section('content')
<input type="hidden" name="pharmacy_id" value="{{ Session::get('pharmacy')->id }}">

<div class="xl:w-3/4 mx-auto pt-10 pb-10">
    <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0">
        <h1 class="font-fira-sans font-medium text-4xl text-left leading-10 pb-5">{{__('Shopping Cart')}}</h1>
        <div class="flex w-full 2xl:mx-0 xl:mx-5 2xl:flex-row xl:flex-row xlg:flex-col lg:flex-col xmd:flex-col md:flex-col sm:flex-col xsm:flex-col xxsm:flex-col overflow-x-auto">
            <div class="w-full">
                <div class=" overflow-hidden">
                    <div class="flex flex-col p-3 rounded-md">
                        <div class="overflow-x-auto">
                            <div class="py-2 inline-block min-w-full">
                                <div class="overflow-hidden table-responsive rounded-sm">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs font-fira-sans  text-gray uppercase">
                                            <tr class="">
                                                <th scope="col" class="py-3 px-6">
                                                    {{__('Product Name')}}
                                                </th>
                                                <th scope="col" class="py-3 px-9">
                                                    {{__('Price')}}
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    {{__('Qty')}}
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    {{__('Total')}}
                                                </th>
                                                <th scope="col" class="p-4">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (Session::get('cart') as $cart)
                                            <tr class=" border-b border-white-light">
                                                <th scope="row" class="flex items-center py-6 px-6 mr-10 text-gray-900 whitespace-nowrap dark:text-white">
                                                    <img width="60px" height="63px" src="{{ $cart['image'] }}" alt="" class="max-w-0">
                                                    <div class="pl-3">
                                                        <div class="text-base font-semibold">{{ $cart['name'] }}</div>
                                                    </div>
                                                </th>
                                                <td class="py-4 px-9">
                                                    {{ $currency }}{{ $cart['original_price'] }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                                        <button id="minus{{ $cart['id'] }}" onclick="addCart({{$cart['id']}},`minus`)" data-action="decrement" class="border-l border-t border-b border-white-light text-black-600 hover:text-black-700 h-8 w-6 cursor-pointer rounded-l-md">
                                                            <span class="m-auto text-2xl font-thin">−</span>
                                                        </button>
                                                        <input type="number" id="txtCart{{ $cart['id'] }}" readonly class="border-t border-b border-white-light outline-none focus:outline-none text-center w-10 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-primary h-8 p-1" name="custom-input-number" value="{{ $cart['qty'] }}">
                                                        <button onclick="addCart({{$cart['id']}},`plus`)" data-action="increment" class="border-r border-t border-b border-white-light text-black-600 hover:text-black-700 h-8 w-6 cursor-pointer rounded-r-md">
                                                            <span class="m-auto text-2xl font-thin">+</span>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6">
                                                    <p class="font-medium text-primary dark:text-blue-500">{{ $currency }}
                                                        <span class="item_price{{ $cart['id'] }}">{{ $cart['price'] }}</span>
                                                    </p>
                                                </td>
                                                <td class="p-4 w-4">
                                                    <div class="flex items-center">
                                                        <a href="{{ url('remove_single_item/'.$cart['id']) }}" class="bg-white py-2 px-3 rounded-full"><i class="fa-solid fa-xmark text-xl"></i></a>
                                                    </div>
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
            </div>

            <div class="2xl:w-1/4 xl:w-1/4 xlg:w-1/4 lg:w-72 xmd:w-72 md:w-60 sm:w-full msm:w-full xsm:w-full xxsm:w-full" style="background: #f4fbfd;">
                <div class="pt-8 pl-8 pr-8">
                    <div>
                        <h1 class="font-fira-sans font-normal leading-5 text-xl">{{__('Cart Total')}}</h1>
                        <div class="flex justify-between border-b border-white-light pt-5 pb-2">
                            <div>
                                <h1 class="font-fira-sans text-sm font-normal leading-5 text-gray">{{__('Total Item')}}</h1>
                            </div>
                            <div>
                                <h1 class="font-fira-sans text-sm font-medium leading-5 text-black">{{
                                count(Session::get('cart')) }}</h1>
                            </div>
                        </div>
                        <div class="flex justify-between pt-2 pb-8">
                            <div>
                                <h1 class="font-fira-sans text-sm font-medium leading-5 text-black">{{__('Total')}}</h1>
                            </div>
                            <div>
                                <h1 class="font-fira-sans text-sm font-medium leading-5 text-black ">{{ $currency }}
                                    <span class="total_price">{{array_sum(array_column(Session::get('cart'), 'price')) }}
                                    </span>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mb-5">
                        <a href="{{ url('checkout') }}" class="bg-primary text-white w-full px-4 py-2 flex justify-center">{{ __('Checkout') }}</a>
                        {{-- <button
                        class="w-full text-white bg-primary text-center px-4 py-2 text-base font-normal leading-5 font-fira-sans">{{__('Check
                        Out')}}</button> --}}
                        {{-- <a href="{{ url('checkout') }}"
                        class="w-full text-white bg-primary text-center px-4 py-2 text-base font-normal leading-5 font-fira-sans ">{{__('Check
                        Out')}}</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script src="{{ url('assets/js/medicine_list.js') }}"></script>
@endsection
