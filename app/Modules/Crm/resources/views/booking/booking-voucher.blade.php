@extends('admin.app')
@section('title') {{ isset($pageTitle)?$pageTitle:'Buildings' }} @endsection
@push('styles')
    @include('admin.datatable_styles')
    <style>

        .ne ol {
            list-style-type: bengali;
        }

        .ch ul
        {
            list-style-type: none;
        }

        .ch ul li:before {
            font-family: 'FontAwesome';
            content: '\f0a1';
            margin:0 5px 0 -15px;
            color: #f00;
        }

        .page-setup {font-size: 15px; padding-left: 70px; padding-right: 70px;}
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
                color-adjust: exact !important;                 /*Firefox*/
            }
            .page-setup {font-size: 20px; padding-left: 70px; padding-right: 70px;}
            .page-2 {page-break-after: always;}
        }
    </style>
@endpush

@section('content')
    @include('admin.master.flash')

    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('crm.seat-booking.booking') }}" class="btn btn-icon btn-secondary"><i class="fa fa-backward"></i> Go
            Back</a>
        <a href="{{ route('crm.seat-booking.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-list-ul"></i>
            Invoice Manage</a>
        <a href="#" class="btn btn-icon btn-secondary" onclick="printDiv('printableArea')"><i class="fa fa-print"></i>
            Print</a>
    </div>
    <section class="card bg_image" id="printableArea">
        <div id="invoice-template" class="card-body page-setup" >

            <div class="container-fluid">
                <div class="row" style="height: 150px;">
                    <div class="col-md-4 d-flex justify-content-center text-center" ><div class="d-flex justify-content-center align-items-center" style="border: 1px solid black; height: 150px; width: 150px;">অভিভাবকের ছবি</div></div>
                    <div class="col-md-4 ml-auto text-center"><img style="width: 240px; margin-top: -50px;" src="{{asset('app-assets/images/city_logo.png')}}"></div>
                    <div class="col-md-4 d-flex justify-content-center text-center" ><div class="d-flex justify-content-center align-items-center" style="border: 1px solid black; height: 150px; width: 150px;">আবেদনকারীর ছবি</div></div>
                </div>
                <div class="row d-flex justify-content-center text-center" style="border-bottom: 1px solid black">
                    <b class="text-center">ভর্তি ফর্ম</b>
                </div>
                <div class="row" style="padding-top: 10px;padding-bottom: 10px;">
                    <div class="col-md-6 ml-auto"><table class="table-striped">
                            <tr><td>আবেদনকারীর নামঃ</td> <td><span id="aname">{{$booking->customer->name}}</span></td></tr>
                            <tr><td>পিতার নামঃ </td><td><span id="fname">{{$booking->customer->fathers_name}}</span></td></tr>
                            <tr><td>মাতার নামঃ </td><td><span id="mname">{{$booking->customer->mothers_name}}</span></td></tr>
                            <tr><td>পিতার পেশাঃ </td><td><span id="fprofession">{{$booking->customer->fathers_profession}}</span></td></tr>
                            <tr><td>জাতীয় পরিচয়পত্র নংঃ </td><td><span id="anid">{{$booking->customer->nid}}</span></td></tr>
                            <tr><td>লিঙ্গঃ</td> <td><span id="agender">{{\App\Modules\Config\Models\lookup::getLookupByCode(\App\Modules\Config\Models\lookup::GENDER,$booking->customer->gender)}}</span></td></tr>
                            <tr><td>বৈবাহিক অবস্থাঃ </td><td><span id="amarital">{{\App\Modules\Config\Models\lookup::getLookupByCode(\App\Modules\Config\Models\lookup::MARITAL_STATUS,$booking->customer->marital_status)}}</span></td></tr>
                            <tr><td>অভিভাবকের নামঃ </td><td><span id="gname">{{$booking->customer->guardian_name}}</span></td></tr>
                            <tr><td>অভিভাবকের সাথে সম্পর্কঃ </td><td><span id="rwg">{{\App\Modules\Config\Models\lookup::getLookupByCode(\App\Modules\Config\Models\lookup::RELATION,$booking->customer->relation_with_guardian)}}</span></td></tr>

                        </table></div>
                    <div class="col-md-6 ml-auto"><table class="table-striped">
                            <tr><td>মোবাইল নংঃ </td><td><span id="aphone">{{$booking->customer->phone_no}}</span></td></tr>
                            <tr><td>মোবাইল নংঃ </td><td><span id="fphone">{{$booking->customer->fathers_phone}}</span></td></tr>
                            <tr><td>মোবাইল নংঃ </td><td><span id="mphone">{{$booking->customer->mothers_phone}}</span></td></tr>
                            <tr><td>থাকার কারণঃ </td><td><span id="reason">{{$booking->customer->reason_to_stay}}</span></td></tr>
                            <tr><td>ইমেইলঃ </td><td><span id="aemail">{{$booking->customer->email}}</span></td></tr>
                            <tr><td>ধর্মঃ </td><td><span id="arel">{{\App\Modules\Config\Models\lookup::getLookupByCode(\App\Modules\Config\Models\lookup::RELIGION,$booking->customer->religion)}}</span></td></tr>
                            <tr><td>পেশাঃ </td><td><span id="aprof">{{\App\Modules\Config\Models\lookup::getLookupByCode(\App\Modules\Config\Models\lookup::PROFESSION,$booking->customer->profession)}}</span></td></tr>
                            <tr><td>মোবাইল নংঃ </td><td><span id="gph">{{$booking->customer->guardian_phone_no}}</span></td></tr>
                        </table></div>
                    <div class="col-md-12 ml-auto"><table class="table-striped">
                            <tr><td>ঠিকানাঃ </td><td><span id="paddress">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$booking->customer->address}}</span></td></tr>
                        </table></div>
                </div>

                <div class="row d-flex justify-content-center text-center" style="border-bottom: 1px solid black">
                    <b class="text-center">বরাদ্দকৃত রুমের বিবরণ</b>
                </div>
                <div class="row" style="padding-top: 10px;padding-bottom: 10px;">
                    <div class="col-md-6 ml-auto"><table class="table-striped">
                            <tr><td>বুকিং এর তারিখঃ</td> <td><span id="bdate">{{$booking->booking_date}}</span></td></tr>
                            <tr><td>বাসার নামঃ</td> <td><span id="build">{{$booking->room->flat->floor->building->name}}</span></td></tr>
                            <tr><td>ফ্লাটের নামঃ </td><td><span id="flat">{{$booking->room->flat->floor->name}}</span></td></tr>
                            <tr><td>সিট সংখ্যাঃ </td><td><span id="seat">{{$booking->seat_qty}}</span></td></tr>
                        </table></div>
                    <div class="col-md-6 ml-auto"><table class="table-striped">
                            <tr><td>ওঠার তারিখঃ </td><td><span id="edate">{{$booking->start_date}}</span></td></tr>
                            <tr><td>ফ্লোর নংঃ </td><td><span id="floor"></span>{{$booking->room->flat->name}}</td></tr>
                            <tr><td>রুম নংঃ </td><td><span id="room">{{$booking->room->name}}</span></td></tr>
                        </table></div>
                </div>
                <hr>
                <div class="row" style="padding-top: 10px;padding-bottom: 10px;">
                    <div class="col-md-6 ml-auto"><table class="table-striped">
                            <tr><td>সার্ভিস চার্জঃ </td> <td><span id="service">{{$booking->service_charge}}</span></td></tr>
                        </table></div>
                    <div class="col-md-6 ml-auto"><table class="table-striped">
                            <tr><td>মাসিক চার্জঃ </td><td><span id="monthly">{{$booking->monthly_charge}}</span></td></tr>
                        </table></div>
                </div>
                <div class="row" style="padding-top: 10px;padding-bottom: 10px;">
                    <div class="col-md-6 d-flex justify-content-center text-center " ><div class="d-flex justify-content-center align-items-center align-bottom" style=" height: 120px; "></div></div>
                    <div class="col-md-6 d-flex justify-content-center text-center " ><div class="d-flex justify-content-center align-items-center align-bottom" style=" height: 120px; ">_________________________<br>কর্তৃপক্ষের স্বাক্ষর</div></div>

                </div>
                <br>
                <div class="row d-flex justify-content-center text-center" style="border-bottom: 1px solid black">
                    <b class="text-center">ভর্তির আবেদন</b>
                </div>
                <div class="row page-2 " style="padding-top: 10px;padding-bottom: 10px;"><br><p>
                    জনাব/জনাবা,
                    আমি {{$booking->customer->name}} {{$booking->start_date}} তাং হইতে আপনার হোষ্টেলে ভর্তি হয়েছি। আমি এই মর্মে ওয়াদা করছি যে, আমি উল্লেখিত কোন নিয়মের অবাধ্য হব না। কর্তৃপক্ষের যে কোন নিয়ম মেনে চলব এবং নিদৃষ্ট ভাড়া প্রতি মাসের নিদৃষ্ট সময়ে পরিশোধ করব এবং আমি কন বেআইনী কাজে জড়িত নই।
                    </p>
                    <div class="col-md-6 d-flex justify-content-center text-center " ><div class="d-flex justify-content-center align-items-center align-bottom" style=" height: 120px; ">_________________________<br>অভিভাবকের স্বাক্ষর</div></div>
                    <div class="col-md-6 d-flex justify-content-center text-center " ><div class="d-flex justify-content-center align-items-center align-bottom" style=" height: 120px; ">_________________________<br>আবেদনকারীর স্বাক্ষর</div></div>
                </div>

                <div class="row d-flex justify-content-center text-center " style="border-bottom: 1px solid black">
                    <b class="text-center">নিয়মাবলী</b>
                </div>
                <div class="row ne" style="padding-top: 10px;padding-bottom: 10px;"><br>
                        <ol>
                        <li>সন্ধ্যা ৮টার ভিতরে অবশ্যই হোষ্টেলে প্রবেশ করতে হবে। </li>
                        <li>এন্ট্রি খাতায় ইন/আউট এর সময় উল্লেখসহ নাম এন্ট্রি করতে হবে এবং স্বাক্ষর দিতে হবে। হোষ্টেলের বাহিরে কোন সমস্যা হলে তার জন্য হোষ্টেল কর্তৃপক্ষ দায়ী নহে। </li>
                        <li>নির্দিষ্ট সময়ে খাবার নিতে হবে। নির্দিষ্ট সময়ের পরে খাবার পাওয়া যাবে না। </li>
                        <li>এক রুম  থেকে অন্য রুমে বা এক ফ্লাট থেকে অন্য ফ্লাটে গিয়ে আড্ডা দেওয়া যাবে না। </li>
                        <li>কোন মুল্যবান জিনিস। অধিক পরিমান টাকা হোষ্টেলে রাখা যাবে না। কোন জিনিষপত্র অর্থ্যাৎ	মোবাইল, টাকা-পয়সা ও অলংকার চুরি বা হারিয়ে গেলে কর্তৃপক্ষ দায়ী নহে। </li>
                        <li>বাব-মা ও অভিভাবক ছাড়া কোন বান্ধবী/বন্ধু হোষ্টেলের সামনে আনা যাবে না। </li>
                        <li>রাত ১২.০০ টার পরে মোবাইলে কথা বলা সম্পুর্ন নিষেধ। </li>
                        <li>হোষ্টেলে কার্ড খেলা ও ধুমপান করা সম্পুর্ন নিষেধ। ধরা পড়লে সিট বাতিল করা হবে। </li>
                        <li>হোষ্টেলেরর কোন স্ট্যাফ বা বিল্ডিং এ নিয়োজিত কোন স্ট্যাফের সাথে কোনরূপ খারাপ ব্যবহার করা যাবে না, করলে সাথে সাথে সিট বাতিল করে দেওয়া হবে। এ ব্যাপারে কোনরূপ খারাপ ব্যবহার করা যাবে না, করলে সাথে সাথে সিট বাতিল করে দেওয়া হবে। এ ব্যাপারে কোনরূপ আপত্তি চলবে না। </li>
                        <li>কোচিংকৃত ছাত্র জুন মাসের যে কোন তারিখেই হোষ্টেলে উঠুক না কেন সকল চার্জ ১লা জুন থেকে হিসাব ধরা হবে এবং প্রত্যেক ছাত্রকে সেই চার্জ প্রদান করতে হবে। </li>
                        <li>হোষ্টেল ছেড়ে যাওয়ার সময় হোষ্টেলের ব্যবহারকৃত সকল জিনিষ হোষ্টেল কর্তৃপক্ষকে বুঝিয়ে দিতে হবে। ছাত্র কোন কিছুই সঙ্গে নিয়ে যেতে পারবে না। </li>
                        <li>ছাত্রের জন্ম নিবন্ধনী কার্ডের ফটোকপি জমা দিতে হবে। </li>
                        <li>ছাত্রের ৩ কপি, অভিভাবকের ১ কপি পাসপোর্ট সাইজের ছবি জমা দিতে হবে। </li>
                    </ol>
                </div>

                <div class="row d-flex justify-content-center text-center" style="border-bottom: 1px solid black">
                    <b class="text-center">চুক্তিনামা</b>
                </div>
                <div class="row ch" style="padding-top: 10px;padding-bottom: 10px;"><br><ul>
                        <li>মাসের ভাড়া জামানত হিসাবে কর্তৃপক্ষের নিকট জমা থাকিবে।</li>
                        <li>চলতি মাসের মাসিক ভাড়া চলতি মাসের ১-৫ তারিখের মধ্যে পরিশোধ করতে হবে।</li>
                        <li>আমি হোষ্টেলে ভর্তি ফি/সার্ভিস চার্জ {{$booking->service_charge}} পরিশোধ করেছি যা যে কোন অবস্থাতেই ফেরতযোগ্য নহে।</li>
                        <li>আমি মাসিক চার্জ বাবদ {{$booking->monthly_charge}} টাকা হারে পরিশোধ করিব।</li>
                        <li>হোষ্টেল ছেড়ে দিতে চাইলে লিখিত দরখাস্তের মাধ্যমে ৩০ দিন পুর্বে হোষ্টেল সুপারকে জানাতে হবে।</li>
                        <li>আমি যদি হোষ্টেলে ছাড়ার ৩০ দিন পুর্বে জানাতে না পারি তাহলে কর্তৃপক্ষের নিকট আমি আমার জামানত ফেরৎ চাইবো না।</li>
                        <li>হোষ্টেলের কোন জিনিষ নষ্ট করলে উপযুক্ত ক্ষতিপুরণ দিতে বাধ্য থাকিব। আমার কোন নিয়ম অমান্য হলে কর্তৃপক্ষ জরিমানা সহ যে কোন সিদ্ধান্ত নিতে পারবেন।</li>
                        <li>ওয়াটার হিটার এবং আয়রণ ব্যবহার সম্পুর্ন নিষেধ। ওয়াটার হিটার ব্যবহার করলে ১০০০/= (এক হাজার) টাকা জরিমানা  এবং আয়রণ ব্যবহার করলে ১৫০০/-  (পনের শত) টাকা জরিমানা দিতে হবে এবং ব্যবহারকৃত ওয়াটার হিটার/আয়রণ ফেরত দেওয়া হবে না।</li>
                        <li>দেয়ালে লেখা, পোষ্টার লাগানো এবং ছবি আঁকা সম্পুর্ন নিষেধ। এগুলো করলে রঙ করার টাকা দিতে হবে।</li>
                    </ul>
                    <div class="col-md-6 d-flex justify-content-center text-center " ><div class="d-flex justify-content-center align-items-center align-bottom" style=" height: 120px; ">_________________________<br>অভিভাবকের স্বাক্ষর</div></div>
                    <div class="col-md-6 d-flex justify-content-center text-center " ><div class="d-flex justify-content-center align-items-center align-bottom" style=" height: 120px; ">_________________________<br>আবেদনকারীর স্বাক্ষর</div></div>

                </div>

            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
