<!doctype HTML>
<html>

<head>
    <title>{{__('doctro')}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="{{asset('css/vanilla-calendar.min.css')}}" rel="stylesheet" />
    <script src="{{asset('js/vanilla-calendar.min.js')}}"></script>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

</head>

<body>
    <nav class="border-gray-200 rounded dark:bg-gray-900 m-0  pb-8">
        {{-- navbar --}}
        <div
        class="flex lg:flex-row xmd:flex-row md:flex-row sm:flex-col msm:flex-col xsm:flex-col xxsm:flex-col justify-between border-b border-b-slate mx-auto px-4 py-2">
        <a href="{{url('/')}}" class="px-6 items-center md:py-3">
            <img src="{{asset('image/Doctro.png')}}" class="mr-3 h-5 sm:h-9" alt="Logo">
        </a>
        <div class="justify-between items-center p-6 sm:items-left w-auto">
            <ul class="flex mt-4 bg-gray-50 lg:flex-row xmd:flex-row md:flex-row md:text-xs md:-space-x-3 sm:flex-row msm:flex-row xsm:flex-col xxsm:flex-col 
                msm:space-x-3 sm:space-x-2 lg:space-x-10 md:mt-0 font-fira-sans font-normal text-sm text-black leading-5 capitalize">
                <li>
                    <a href="{{url('/find_doctors')}}" class="md:px-3 capitalize">{{__('Find Doctors')}}</a>
                </li>
                <li>
                    <a href="{{url('/pharmacy')}}" class="md:px-3 capitalize text-primary font-semibold">{{__('Pharmacy')}}</a>
                </li>
                <li>
                    <a href="{{url('/laboratory')}}" class="md:px-3 capitalize">{{__('Lab Tests')}}</a>
                </li>
                <li>
                    <a href="{{url('/our_offers')}}" class="md:px-3 capitalize">{{__('Offers')}}</a>
                </li>
                <li>
                    <a href="{{url('/our_blogs')}}" class="md:px-3 capitalize">{{__('Blog')}}</a>
                </li>
            </ul>
        </div>
        <div class="w-32 sm:px-4  md:py-3 ">
            <a type="button" href="{{url('/signup')}}" class="px-5 py-3 text-white bg-primary text-center font-fira-sans font-normal text-sm leading-4">{{__('Sign Up')}}</a>
        </div>
    </div>
    </nav>
    
    {{-- Appointment calender --}}
    <div class="container mx-auto pt-10">
        <h1 class="font-fira-sans font-medium text-4xl text-left leading-10 pb-5 xlg:mx-10 lg:mx-10 xmd:mx-10 md:mx-10 sm:mx-10 msm:mx-10 xsm:mx-5 xxsm:mx-5">{{__('Appointment Booking')}}</h1>

        <div class="border border-white-light flex 2xl:flex-row xl:flex-row xlg:mx-10 lg:mx-10 xmd:flex-row xmd:mx-10 md:flex-col md:mx-10 sm:flex-col sm:mx-10 msm:flex-col sms:mx-10 xsm:flex-col xsm:mx-5 xxsm:flex-col xxsm:mx-5">
            
                <div class="2xl:w-1/3 xl:w-1/3 xlg:w-1/2 border-r border-white-light p-10">
                    <div id="vanilla-calendar" class="h-auto w-auto"></div>                    
                </div>
                <div class="2xl:w-2/3 xl:w-2/3  xlg:w-1/2 ml-14 2xl:mr-36 xl:mr-36 xlg:mr-20 pt-10  xmd:mr-10 md:mr-28 sm:mr-20  msm:mr-14 xsm:mr-10  xxsm:mr-5 space-y-4 pb-10">

                    <div class="p-5 pt-8">
                        <h1 class="font-fira-sans font-medium text-xl leading-6 pb-3">{{__('18th August, Availibility')}}</h1>
                        <div class="flex pt-3 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-col xmd:flex-col md:flex-row sm:flex-row msm:flex-row xsm:flex-col xxsm:flex-col
                            2xl:space-x-1 2xl:space-y-0 xl:space-x-1 xl:space-y-0 xlg:space-y-0 xlg:space-x-1 lg:space-x-0 lg:space-y-1 md:space-x-1 md:space-y-0 xmd:space-x-0 xmd:space-y-1 sm:space-x-1 sm:space-y-0
                            msm:space-x-1 msm:space-y-0 xms:space-x-0 xms:space-y-1 xxsm:space-x-0 xxsm:space-y-1">
                            <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-1  leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1 xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-black">{{__('9:00 AM')}}</p>
                            <p class="border border-white-100 text-white-100 text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1  xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                             mx-1">{{__('10:00 PM')}}</p>
                            <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1  xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-black">{{__('11:00 AM')}}</p>
                            <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1 xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-black mx-1">{{__('12:00 AM')}}</p>
                        </div>

                        <div class="flex pt-3 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-col xmd:flex-col md:flex-row sm:flex-row msm:flex-row xsm:flex-col xxsm:flex-col
                            2xl:space-x-1 2xl:space-y-0 xl:space-x-1 xl:space-y-0 xlg:space-y-0 xlg:space-x-1 lg:space-x-0 lg:space-y-1 md:space-x-1 md:space-y-0 xmd:space-x-0 xmd:space-y-1 sm:space-x-1 sm:space-y-0
                            msm:space-x-1 msm:space-y-0 xms:space-x-0 xms:space-y-1 xxsm:space-x-0 xxsm:space-y-1">
                            <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-1  leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1 xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-black">{{__('1:00 AM')}}</p>
                            <p class="border border-primary bg-primary text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1  xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-white mx-1">{{__('2:00 PM')}}</p>
                            <p class="border border-white-100 text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1  xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-white-100">{{__('4:00 AM')}}</p>
                            <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1 xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-black mx-1">{{__('5:00 AM')}}</p>
                        </div>
                        <div class="flex pt-3 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-col xmd:flex-col md:flex-row sm:flex-row msm:flex-row xsm:flex-col xxsm:flex-col
                            2xl:space-x-1 2xl:space-y-0 xl:space-x-1 xl:space-y-0 xlg:space-y-0 xlg:space-x-1 lg:space-x-0 lg:space-y-1 md:space-x-1 md:space-y-0 xmd:space-x-0 xmd:space-y-1 sm:space-x-1 sm:space-y-0
                            msm:space-x-1 msm:space-y-0 xms:space-x-0 xms:space-y-1 xxsm:space-x-0 xxsm:space-y-1">
                            <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-1  leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1 xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-black">{{__('6:00 AM')}}</p>
                            <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1  xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                             mx-1">{{__('7:00 PM')}}</p>
                            <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1  xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            ">{{__('8:00 AM')}}</p>
                            {{-- <p class="border border-gray text-center py-1 2xl:text-sm 2xl:px-1 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1 xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28
                            text-black mx-1">{{__('12:00 AM')}}</p> --}}
                        </div>                       
                     </div>
 
                    </div>
                </div>
            
            
        </div>
      
        <div class="pt-7 pb-16 justify-between flex xlg:mx-10 lg:mx-10 xmd:mx-10 md:mx-10 sm:mx-10 msm:mx-10 xsm:mx-5 xxsm:mx-5">
            <button type="button"  class="text-primary border border-primary text-center px-6 py-2 text-base font-normal leading-5 font-fira-sans "> {{__('Privious')}}</button>
            <button type="button"  class="text-white bg-primary text-center px-6 py-2 text-base font-normal leading-5 font-fira-sans "> {{__('Next')}}</button>
        </div>
        
    </div>

  

    {{-- footer--}}

    <div class="flex bg-black lg:py-8 justify-evenly md:py-5 md:px-5 lg:flex-row md:flex-row sm:flex-col sm:px-10 sm:py-5 msm:flex-col xsm:flex-col xxsm:flex-col msm:px-10 xsm:px-10 xxsm:px-10 msm:py-5 xsm:py-5 xxsm:py-5">
        <div>
            <a href="#" class="lg:px-6 items-center md:py-3 msm:py-3 sm:py-3 xxsm:py-3 xsm:py-3">
                <img src="{{asset('image/Doctro1.png')}}" class="mr-3 h-6 sm:h-9 msm:h-9  xsm:h-9 xxsm:h-9" alt="Logo">
            </a>
            <p class="font-semibold text-white text-sm leading-4 font-fira-sans md:pt-3">{{__('Address:')}}</p>
            <p class="text-white text-sm leading-4 font-fira-sans font-normal pt-2">{{__('4140 Parker Rd. Allentown, New
                Mexico 31134')}}</p>

            <p class="text-white font-semibold text-sm leading-4 font-fira-sans pt-5">{{__('Contact:')}}</p>
            <p class="text-white text-sm leading-4 font-fira-sans font-normal underline pt-2">{{__('+91 9876543210')}}</p>
            <p class="text-white text-sm leading-4 font-fira-sans font-normal underline pt-2">
                {{__('info@support@doctro.com')}}</p>

            <div class="flex pt-5">
                <a href="#" class=""><i class="fa-brands fa-facebook text-white border rounded-full p-2"></i></a>
                <a href="#" class="lg:mx-4 md:mx-2 xsm:mx-1 xxsm:mx-1"><i
                        class="fa-brands fa-twitter text-white border rounded-full p-2"></i></a>
                <a href="#" class=""><i class="fa-brands fa-instagram text-white border rounded-full p-2"></i></a>
                <a href="#" class="lg:mx-4 md:mx-2 xsm:mx-1 xxsm:mx-1"><i
                        class="fa-brands fa-linkedin-in text-white border rounded-full p-2"></i></a>
            </div>
        </div>
        <div class="flex justify-between lg:pt-5 md:pt-4 sm:pt-5 msm:pt-5 xsm:pt-5 xxsm:pt-5 sm:flex-col msm:flex-col xsm:flex-col xxsm:flex-col lg:flex-row md:flex-row">
            <div class="lg:mx-10">
                <h1 class="text-primary font-medium text-lg leading-5 font-fira-sans">{{__('For Patients')}}</h1>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-10">{{__('Search for Doctors')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Ion Anton')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Lab Tests')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Offers')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Blog')}}</p>
            </div>
            <div class="lg:mx-10 md:mx-5 lg:pt-0 md:pt-0 sm:pt-4 msm:pt-5 xsm:pt-5 xxsm:pt-5">
                <h1 class="text-primary font-medium text-lg leading-5 font-fira-sans">{{__('Company')}}</h1>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-10">{{__('Find Doctors')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Pharmacy')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Lab Tests')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Offers')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Blog')}}</p>
            </div>
            <div class="lg:mx-10 sm:pt-4 msm:pt-4 xsm:pt-4 xxsm:pt-4 md:pt-0 lg:pt-0">
                <h1 class="text-primary font-medium text-lg leading-5 font-fira-sans">{{__('Services')}}</h1>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-10">{{__('Cardiology')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Diabetes')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Plastic Surgery')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Gastroenterology')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Gynecology')}}</p>
            </div>
            <div class="lg:mx-10 md:mx-5">
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-14">{{__('Hepatology')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Neurology')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Radiology')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Rhinology')}}</p>
                <p class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Obstetrics')}}</p>
            </div>
        </div>
    </div>

    <div class="border-t border-gray flex bg-black py-6 justify-between lg:flex-row md:flex-row sm:flex-col msm:flex-col xsm:flex-col xxsm:flex-col sm:px-10 msm:px-10 xsm:px-10 xxsm:px-10">
        <div class="2xl:mx-40 xl:mx-20 xlg:mx-1 lg:-mx-5 md:mx-5 pt-3">
            <p class="text-white text-base font-normal leading-5 font-fira-sans">{{__('@ 2022 Doctro. All Right Researved')}}</p>
        </div>
        <div class="flex 2xl:mx-52 xl:mx-32 xlg:mx-14 lg:mx-6 md:mx-6 sm:pt-4 msm:pt-4 xsm:pt-4 xxsm:pt-5">
            <p class="text-white text-sm font-normal leading-5 font-fira-sans xl:mx-20 xlg:mx-20 lg:mx-10 md:mx-10">{{__('Terms of Service')}}</p>
            <p class="text-white text-sm font-normal leading-5 font-fira-sans">{{__('Privacy Policy')}}</p>
        </div>
    </div>

</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
       
        const calendar = new VanillaCalendar('#vanilla-calendar', {
            settings: {
                lang: 'en',
                iso8601: false,
                selection: {
                    time: 12,
                },
                visibility: {
                    weekNumbers: true,
                },
            },
          
        });
        calendar.init();
    });
</script>
</html>
