@extends('layout.mainlayout',['activePage' => 'user'])

@section('css')
<style>
  .sidebar li.active {
    background: linear-gradient(45deg, #00000000 50%, #f4f2ff);
    border-left: 2px solid var(--site_color);
  }

  .mapClass {
    height: 200px;
    border-radius: 12px;
  }
</style>
@endsection

@section('content')
<div class="xl:w-3/4 mx-auto">
  <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0 pt-10">
    <div class="flex h-full mb-20 xxsm:flex-col sm:flex-col xmd:flex-row xmd:space-x-5">
      <div class="2xl:w-1/5 1xl:w-1/5 xl:w-1/4 xlg:w-80 lg:w-72 xxmd:w-72 xmd:w-72 md:w-72 h-auto">
        @include('website.user.userSidebar',['active' => 'patientAddress'])
      </div>
      <div class="w-full md:w-full xxmd:w-full xmd:w-80 lg:w-2/3 xlg:w-2/3 1xl:w-full 2xl:w-full sm:ml-0 xxsm:ml-0 shadow-lg overflow-hidden p-5 mt-10 2xl:mt-0 xmd:mt-0">
        <div class="border border-white-100 overflow-hidden">
          <div class="flex flex-col p-3 rounded-md">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden table-responsive rounded-sm p-5">
                  <div class="flex justify-end Appointment-detail">
                    <a class="btn ms-auto font-fira-sans" type="button" data-from="add_new" data-modal-target="exampleModalScrollableLabel" data-modal-toggle="exampleModalScrollableLabel" data-te-ripple-color="light">{{ __('Add New') }}</a>
                  </div>
                  <table class="min-w-full datatable ">
                    <thead class="border-b text-center">
                      <tr>
                        <th scope="col" class="text-sm font-semibold font-fira-sans px-6 py-4 text-left">#</th>
                        <th scope="col" class="text-sm font-semibold font-fira-sans px-6 py-4 text-left">{{ __('Address')}}</th>
                        <th scope="col" class="text-sm font-semibold font-fira-sans px-6 py-4 text-left">{{ __('Action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($addresses as $address)
                      <tr class="border-b border-white-100 transition duration-300 ease-in-out hover:bg-gray-50">
                        <td class="text-sm px-6 py-4 font-fira-sans">{{ $loop->iteration }}</td>
                        <td class="text-sm px-6 py-4 font-fira-sans">{{ $address->address }}</td>
                        <td class="text-sm px-6 py-4 flex">
                          <a href="javascript:void(0)" onclick="editAddress({{ $address->id }})" type="button" data-modal-target="editAddress" data-modal-toggle="editAddress" data-te-ripple-color="light" class="bg-[#eef7f2] px-6 whitespace-nowrap pt-2.5 pb-2  font-medium text-xs leading-normal uppercase rounded transition duration-150 ease-in-out align-center">
                            <svg width="15" height="15" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M16.3 6.425L12.05 2.225L13.45 0.825C13.8333 0.441667 14.3043 0.25 14.863 0.25C15.421 0.25 15.8917 0.441667 16.275 0.825L17.675 2.225C18.0583 2.60833 18.2583 3.071 18.275 3.613C18.2917 4.15433 18.1083 4.61667 17.725 5L16.3 6.425ZM14.85 7.9L4.25 18.5H0V14.25L10.6 3.65L14.85 7.9Z" fill="#219653" />
                            </svg>
                            <span class="text-[#3ba267] font-fira-sans">{{ __('Edit') }}</span>
                          </a>
                          <a href="javascript:void(0)" onclick="deleteData({{ $address->id }})" class="bg-[#fcf0f2] ml-2 px-6 whitespace-nowrap pt-2.5 pb-2  font-medium text-xs leading-normal uppercase rounded transition duration-150 ease-in-out align-center">
                            <svg width="15" height="15" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M3 18.5C2.45 18.5 1.97933 18.3043 1.588 17.913C1.196 17.521 1 17.05 1 16.5V3.5H0V1.5H5V0.5H11V1.5H16V3.5H15V16.5C15 17.05 14.8043 17.521 14.413 17.913C14.021 18.3043 13.55 18.5 13 18.5H3ZM5 14.5H7V5.5H5V14.5ZM9 14.5H11V5.5H9V14.5Z" fill="#D34053" />
                            </svg>
                            <span class="text-[#d54b5d] font-fira-sans">{{ __('Delete') }}</span>
                          </a>
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
    </div>
  </div>
</div>
{{-- add address --}}
<div id="exampleModalScrollableLabel" class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" tabindex="-1">
  <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 transition-all duration-300 ease-in-out w-full max-w-2xl max-h-full">
    <div class="pointer-events-auto relative flex max-h-[100%] w-auto flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
      <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
        <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200" id="exampleModalScrollableLabel"> {{ __('Add Address') }}</h5>
        <button type="button" class="box-content rounded-none font-fira-sans border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-modal-hide="exampleModalScrollableLabel" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="relative overflow-y-auto p-4">
        <form class="addAddress" method="post">
          <input type="hidden" name="from" value="add_new">
          <div class="w-auto border border-white-light" id="map" style="height: 200px">{{ __('Rajkot') }}</div>
          <input type="hidden" name="lat" class="lat" value="{{ $setting->lat }}">
          <input type="hidden" name="lang" class="lng" value="{{ $setting->lang }}">
          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
          <textarea name="address" class="mt-2 form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white-50 bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleFormControlTextarea1" rows="3" placeholder="{{ __('Your message') }}"></textarea>
          <span class="invalid-div text-red"><span class="address text-sm  text-red-600 font-fira-sans"></span></span>
        </form>
      </div>
      <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
        <button type="button" class="inline-block rounded bg-white-100 font-fira-sans px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200" data-modal-hide="exampleModalScrollableLabel" data-te-ripple-color="light">
        {{ __('Close') }}
        </button>
        <button type="button" onclick="addAddress()" class="ml-1 inline-block rounded bg-primary font-fira-sans px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"> {{ __('Save changes') }}
        </button>
      </div>
    </div>
  </div>
</div>
</div>

{{-- edit address --}}
<div id="editAddress" class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" tabindex="-1">
  <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 transition-all duration-300 ease-in-out w-full max-w-2xl max-h-full">
    <div class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
      <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
        <h5 class="text-xl font-medium font-fira-sans leading-normal text-neutral-800 dark:text-neutral-200" id="editAddressLabel"> {{ __('Edit Address') }}</h5>
        <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-modal-hide="editAddress" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="relative overflow-y-auto p-4">
        <form class="updateAddress" method="post">
          <input type="hidden" name="from" value="edit">
          <input type="hidden" name="id" id="address_id" value="">
          <div class="w-auto border border-white-light" id="map2" style="height: 200px">{{ __('Rajkot') }}</div>
          <input type="hidden" name="lat" class="lat" value="{{ $setting->lat }}">
          <input type="hidden" name="lang" class="lng" value="{{ $setting->lang }}">
          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
          <textarea name="address" class="mt-2 form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white-50 bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleFormControlTextarea1" rows="3" placeholder="{{ __('Your message') }}"></textarea>
          <span class="invalid-div text-red"><span class="address text-sm  text-red-600 font-fira-sans"></span></span>
        </form>
      </div>
      <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
        <button type="button" class="inline-block rounded bg-white-100 px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200" data-modal-hide="editAddress" data-te-ripple-color="light">
        {{ __('Close') }}
        </button>
        <button type="button" onclick="updateAddress()" class="ml-1 inline-block rounded bg-primary px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"> {{ __('Save changes') }}
        </button>
      </div>
    </div>
  </div>
</div>
</div>

@endsection
@section('js')
<script src="{{url('assets/js/address.js')}}"></script>
@if (App\Models\Setting::first()->map_key)
<script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
@endif
@endsection
