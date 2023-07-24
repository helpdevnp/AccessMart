@extends('layouts.admin.app')

@section('title', translate('business_setup'))


@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/business.png') }}" class="w--26" alt="">
                </span>
                <span>
                    {{ translate('messages.business') }} {{ translate('messages.settings') }}
                </span>
            </h1>
            @include('admin-views.business-settings.partials.nav-menu')
        </div>
        <!-- End Page Header -->
        <div class="card mb-3">
            <div class="card-body">
                <div
                    class="maintainance-mode-toggle-bar d-flex flex-wrap justify-content-between border border-info rounded align-items-center p-2">
                    @php($config = \App\CentralLogics\Helpers::get_business_settings('maintenance_mode'))
                    <h5 class="text-capitalize m-0 text--primary">
                        <i class="tio-settings-outlined"></i>
                        {{ translate('messages.maintenance_mode') }}
                    </h5>
                    <label class="toggle-switch toggle-switch-sm">
                        <input type="checkbox" class="status toggle-switch-input" onclick="maintenance_mode()"
                            {{ isset($config) && $config ? 'checked' : '' }}>
                        <span class="toggle-switch-label text mb-0">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>
                <div class="mt-2">
                    {{ translate('messages.maintainance_txt') }}
                </div>
            </div>
        </div>
        <form action="{{ route('admin.business-settings.update-setup') }}" method="post" enctype="multipart/form-data">
            @csrf
            @php($name = \App\Models\BusinessSetting::where('key', 'business_name')->first())

            <div class="row g-3">
                <div class="col-lg-12">
                    <h4 class="card-title mb-3 mt-1">
                        <span class="card-header-icon mr-2"><i class="tio-user"></i></span>
                        <span>{{ translate('Company Information') }}</span>
                    </h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="exampleFormControlInput1">{{ translate('messages.company') }}
                                            {{ translate('messages.name') }}</label>
                                        <input type="text" name="store_name" value="{{ $name->value ?? '' }}"
                                            class="form-control" placeholder="{{ translate('messages.new_company') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                @php($email = \App\Models\BusinessSetting::where('key', 'email_address')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="exampleFormControlInput1">{{ translate('messages.email') }}</label>
                                        <input type="email" value="{{ $email->value ?? '' }}" name="email"
                                            class="form-control" placeholder="{{ translate('messages.Ex_:_ex@example.com') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                @php($phone = \App\Models\BusinessSetting::where('key', 'phone')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="exampleFormControlInput1">{{ translate('messages.phone') }}</label>
                                        <input type="tel" value="{{ $phone->value ?? '' }}" name="phone"
                                            class="form-control" placeholder="{{ translate('messages.Ex: +3264124565') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    <div class="form-group mb-0">
                                        <label class="form-label text-capitalize"
                                            for="country">{{ translate('messages.country') }}</label>
                                        <select id="country" name="country" class="form-control  js-select2-custom">
                                            <option value="AF">Afghanistan</option>
                                            <option value="AX">Åland Islands</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia, Plurinational State of</option>
                                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BV">Bouvet Island</option>
                                            <option value="BR">Brazil</option>
                                            <option value="IO">British Indian Ocean Territory</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="CV">Cape Verde</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CX">Christmas Island</option>
                                            <option value="CC">Cocos (Keeling) Islands</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo</option>
                                            <option value="CD">Congo, the Democratic Republic of the</option>
                                            <option value="CK">Cook Islands</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Côte d'Ivoire</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CW">Curaçao</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                            <option value="FO">Faroe Islands</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="GF">French Guiana</option>
                                            <option value="PF">French Polynesia</option>
                                            <option value="TF">French Southern Territories</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GI">Gibraltar</option>
                                            <option value="GR">Greece</option>
                                            <option value="GL">Greenland</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GP">Guadeloupe</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GG">Guernsey</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HM">Heard Island and McDonald Islands</option>
                                            <option value="VA">Holy See (Vatican City State)</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HK">Hong Kong</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran, Islamic Republic of</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IM">Isle of Man</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JE">Jersey</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KR">Korea, Republic of</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MO">Macao</option>
                                            <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MQ">Martinique</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="YT">Mayotte</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia, Federated States of</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MS">Montserrat</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="NC">New Caledonia</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="MP">Northern Mariana Islands</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PS">Palestinian Territory, Occupied</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PN">Pitcairn</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="PR">Puerto Rico</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RE">Réunion</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="BL">Saint Barthélemy</option>
                                            <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="MF">Saint Martin (French part)</option>
                                            <option value="PM">Saint Pierre and Miquelon</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SX">Sint Maarten (Dutch part)</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                            <option value="SZ">Swaziland</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TL">Timor-Leste</option>
                                            <option value="TG">Togo</option>
                                            <option value="TK">Tokelau</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TC">Turks and Caicos Islands</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US">United States</option>
                                            <option value="UM">United States Minor Outlying Islands</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela, Bolivarian Republic of</option>
                                            <option value="VN">Viet Nam</option>
                                            <option value="VG">Virgin Islands, British</option>
                                            <option value="VI">Virgin Islands, U.S.</option>
                                            <option value="WF">Wallis and Futuna</option>
                                            <option value="EH">Western Sahara</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <div class="row g-3">
                                        <div class="col-sm-12">
                                            @php($address = \App\Models\BusinessSetting::where('key', 'address')->first())
                                            <div class="form-group mb-0">
                                                <label class="form-label"
                                                    for="exampleFormControlInput1">{{ translate('messages.address') }}</label>
                                                <textarea type="text" id="address" name="address" class="form-control h--90px" placeholder="{{ translate('messages.Ex: address') }}" rows="1" required>{{ $address->value ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            @php($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first())
                                            @php($default_location = $default_location->value ? json_decode($default_location->value, true) : 0)
                                            <div class="form-group mb-0">
                                                <label class="form-label text-capitalize"
                                                    for="latitude">{{ translate('messages.latitude') }}<span
                                                        class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('messages.click_on_the_map_select_your_defaul_location') }}"><img
                                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                            alt="{{ translate('messages.click_on_the_map_select_your_defaul_location') }}"></span></label>
                                                <input type="text" id="latitude" name="latitude" class="form-control"
                                                    placeholder="{{ translate('messages.Ex:') }} -94.22213"
                                                    value="{{ $default_location ? $default_location['lat'] : 0 }}" required
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-0">
                                                <label class="form-label text-capitalize"
                                                    for="longitude">{{ translate('messages.longitude') }}<span
                                                        class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('messages.click_on_the_map_select_your_defaul_location') }}"><img
                                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                            alt="{{ translate('messages.click_on_the_map_select_your_defaul_location') }}"></span></label>
                                                <input type="text" name="longitude" class="form-control"
                                                    placeholder="{{ translate('messages.Ex:') }} 103.344322" id="longitude"
                                                    value="{{ $default_location ? $default_location['lng'] : 0 }}" required
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex __gap-12px mt-4">
                                        <label class="__custom-upload-img mr-lg-5">
                                            @php($logo = \App\Models\BusinessSetting::where('key', 'logo')->first())
                                            @php($logo = $logo->value ?? '')
                                            <label class="form-label">
                                                {{ translate('logo') }} <span class="text--primary">( {{ translate('3:1') }} )</span>
                                            </label>
                                            <center>
                                                <img class="img--vertical" id="viewer"
                                                    onerror="this.src='{{ asset('public/assets/admin/img/upload-img.png') }}'"
                                                    src="{{ asset('storage/app/public/business/' . $logo) }}"
                                                    alt="logo image" />
                                            </center>
                                            <input type="file" name="logo" id="customFileEg1"
                                                class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        </label>
                                        
                                        <label class="__custom-upload-img">
                                            @php($icon = \App\Models\BusinessSetting::where('key', 'icon')->first())
                                            @php($icon = $icon->value ?? '')
                                            <label class="form-label">
                                                {{ translate('Favicon') }}  <span class="text--primary">( {{ translate('1:1') }} )</span>
                                            </label>
                                            <center>
                                                <img class="img--110" id="iconViewer"
                                                    onerror="this.src='{{ asset('public/assets/admin/img/upload-img.png') }}'"
                                                    src="{{ asset('storage/app/public/business/' . $icon) }}"
                                                    alt="Fav icon" />
                                            </center>
                                            <input type="file" name="icon" id="favIconUpload"
                                                class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-md-4">
                                        <input id="pac-input" class="controls rounded" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.search_your_location_here') }}" type="text" placeholder="{{ translate('messages.search_here') }}" />
                                        <div id="location_map_canvas" class="overflow-hidden rounded height-285px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h4 class="card-title mb-3">
                        <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span>
                        <span>{{ translate('General Settings') }}</span>
                    </h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                {{-- <div class="col-sm-6 col-md-4 col-xl-3">
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="exampleFormControlInput1">{{ translate('messages.language') }} </label>
                                        <select name="language[]" id="language" data-maximum-selection-length="3"
                                            class="form-control js-select2-custom" required multiple=true
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('messages.add_language_warrning') }}">
                                            <option value="en">English(default)</option>
                                            <option value="af">Afrikaans</option>
                                            <option value="sq">Albanian - shqip</option>
                                            <option value="am">Amharic - አማርኛ</option>
                                            <option value="ar">Arabic - العربية</option>
                                            <option value="an">Aragonese - aragonés</option>
                                            <option value="hy">Armenian - հայերեն</option>
                                            <option value="ast">Asturian - asturianu</option>
                                            <option value="az">Azerbaijani - azərbaycan dili</option>
                                            <option value="eu">Basque - euskara</option>
                                            <option value="be">Belarusian - беларуская</option>
                                            <option value="bn">Bengali - বাংলা</option>
                                            <option value="bs">Bosnian - bosanski</option>
                                            <option value="br">Breton - brezhoneg</option>
                                            <option value="bg">Bulgarian - български</option>
                                            <option value="ca">Catalan - català</option>
                                            <option value="ckb">Central Kurdish - کوردی (دەستنوسی عەرەبی)</option>
                                            <option value="zh">Chinese - 中文</option>
                                            <option value="zh-HK">Chinese (Hong Kong) - 中文（香港）</option>
                                            <option value="zh-CN">Chinese (Simplified) - 中文（简体）</option>
                                            <option value="zh-TW">Chinese (Traditional) - 中文（繁體）</option>
                                            <option value="co">Corsican</option>
                                            <option value="hr">Croatian - hrvatski</option>
                                            <option value="cs">Czech - čeština</option>
                                            <option value="da">Danish - dansk</option>
                                            <option value="nl">Dutch - Nederlands</option>
                                            <option value="en-AU">English (Australia)</option>
                                            <option value="en-CA">English (Canada)</option>
                                            <option value="en-IN">English (India)</option>
                                            <option value="en-NZ">English (New Zealand)</option>
                                            <option value="en-ZA">English (South Africa)</option>
                                            <option value="en-GB">English (United Kingdom)</option>
                                            <option value="en-US">English (United States)</option>
                                            <option value="eo">Esperanto - esperanto</option>
                                            <option value="et">Estonian - eesti</option>
                                            <option value="fo">Faroese - føroyskt</option>
                                            <option value="fil">Filipino</option>
                                            <option value="fi">Finnish - suomi</option>
                                            <option value="fr">French - français</option>
                                            <option value="fr-CA">French (Canada) - français (Canada)</option>
                                            <option value="fr-FR">French (France) - français (France)</option>
                                            <option value="fr-CH">French (Switzerland) - français (Suisse)</option>
                                            <option value="gl">Galician - galego</option>
                                            <option value="ka">Georgian - ქართული</option>
                                            <option value="de">German - Deutsch</option>
                                            <option value="de-AT">German (Austria) - Deutsch (Österreich)</option>
                                            <option value="de-DE">German (Germany) - Deutsch (Deutschland)</option>
                                            <option value="de-LI">German (Liechtenstein) - Deutsch (Liechtenstein) </option>
                                            <option value="de-CH">German (Switzerland) - Deutsch (Schweiz)</option>
                                            <option value="el">Greek - Ελληνικά</option>
                                            <option value="gn">Guarani</option>
                                            <option value="gu">Gujarati - ગુજરાતી</option>
                                            <option value="ha">Hausa</option>
                                            <option value="haw">Hawaiian - ʻŌlelo Hawaiʻi</option>
                                            <option value="he">Hebrew - עברית</option>
                                            <option value="hi">Hindi - हिन्दी</option>
                                            <option value="hu">Hungarian - magyar</option>
                                            <option value="is">Icelandic - íslenska</option>
                                            <option value="id">Indonesian - Indonesia</option>
                                            <option value="ia">Interlingua</option>
                                            <option value="ga">Irish - Gaeilge</option>
                                            <option value="it">Italian - italiano</option>
                                            <option value="it-IT">Italian (Italy) - italiano (Italia)</option>
                                            <option value="it-CH">Italian (Switzerland) - italiano (Svizzera)</option>
                                            <option value="ja">Japanese - 日本語</option>
                                            <option value="kn">Kannada - ಕನ್ನಡ</option>
                                            <option value="kk">Kazakh - қазақ тілі</option>
                                            <option value="km">Khmer - ខ្មែរ</option>
                                            <option value="ko">Korean - 한국어</option>
                                            <option value="ku">Kurdish - Kurdî</option>
                                            <option value="ky">Kyrgyz - кыргызча</option>
                                            <option value="lo">Lao - ລາວ</option>
                                            <option value="la">Latin</option>
                                            <option value="lv">Latvian - latviešu</option>
                                            <option value="ln">Lingala - lingála</option>
                                            <option value="lt">Lithuanian - lietuvių</option>
                                            <option value="mk">Macedonian - македонски</option>
                                            <option value="ms">Malay - Bahasa Melayu</option>
                                            <option value="ml">Malayalam - മലയാളം</option>
                                            <option value="mt">Maltese - Malti</option>
                                            <option value="mr">Marathi - मराठी</option>
                                            <option value="mn">Mongolian - монгол</option>
                                            <option value="ne">Nepali - नेपाली</option>
                                            <option value="no">Norwegian - norsk</option>
                                            <option value="nb">Norwegian Bokmål - norsk bokmål</option>
                                            <option value="nn">Norwegian Nynorsk - nynorsk</option>
                                            <option value="oc">Occitan</option>
                                            <option value="or">Oriya - ଓଡ଼ିଆ</option>
                                            <option value="om">Oromo - Oromoo</option>
                                            <option value="ps">Pashto - پښتو</option>
                                            <option value="fa">Persian - فارسی</option>
                                            <option value="pl">Polish - polski</option>
                                            <option value="pt">Portuguese - português</option>
                                            <option value="pt-BR">Portuguese (Brazil) - português (Brasil)</option>
                                            <option value="pt-PT">Portuguese (Portugal) - português (Portugal)</option>
                                            <option value="pa">Punjabi - ਪੰਜਾਬੀ</option>
                                            <option value="qu">Quechua</option>
                                            <option value="ro">Romanian - română</option>
                                            <option value="mo">Romanian (Moldova) - română (Moldova)</option>
                                            <option value="rm">Romansh - rumantsch</option>
                                            <option value="ru">Russian - русский</option>
                                            <option value="gd">Scottish Gaelic</option>
                                            <option value="sr">Serbian - српски</option>
                                            <option value="sh">Serbo-Croatian - Srpskohrvatski</option>
                                            <option value="sn">Shona - chiShona</option>
                                            <option value="sd">Sindhi</option>
                                            <option value="si">Sinhala - සිංහල</option>
                                            <option value="sk">Slovak - slovenčina</option>
                                            <option value="sl">Slovenian - slovenščina</option>
                                            <option value="so">Somali - Soomaali</option>
                                            <option value="st">Southern Sotho</option>
                                            <option value="es">Spanish - español</option>
                                            <option value="es-AR">Spanish (Argentina) - español (Argentina)</option>
                                            <option value="es-419">Spanish (Latin America) - español (Latinoamérica) </option>
                                            <option value="es-MX">Spanish (Mexico) - español (México)</option>
                                            <option value="es-ES">Spanish (Spain) - español (España)</option>
                                            <option value="es-US">Spanish (United States) - español (Estados Unidos) </option>
                                            <option value="su">Sundanese</option>
                                            <option value="sw">Swahili - Kiswahili</option>
                                            <option value="sv">Swedish - svenska</option>
                                            <option value="tg">Tajik - тоҷикӣ</option>
                                            <option value="ta">Tamil - தமிழ்</option>
                                            <option value="tt">Tatar</option>
                                            <option value="te">Telugu - తెలుగు</option>
                                            <option value="th">Thai - ไทย</option>
                                            <option value="ti">Tigrinya - ትግርኛ</option>
                                            <option value="to">Tongan - lea fakatonga</option>
                                            <option value="tr">Turkish - Türkçe</option>
                                            <option value="tk">Turkmen</option>
                                            <option value="tw">Twi</option>
                                            <option value="uk">Ukrainian - українська</option>
                                            <option value="ur">Urdu - اردو</option>
                                            <option value="ug">Uyghur</option>
                                            <option value="uz">Uzbek - o‘zbek</option>
                                            <option value="vi">Vietnamese - Tiếng Việt</option>
                                            <option value="wa">Walloon - wa</option>
                                            <option value="cy">Welsh - Cymraeg</option>
                                            <option value="fy">Western Frisian</option>
                                            <option value="xh">Xhosa</option>
                                            <option value="yi">Yiddish</option>
                                            <option value="yo">Yoruba - Èdè Yorùbá</option>
                                            <option value="zu">Zulu - isiZulu</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    @php($tz = \App\Models\BusinessSetting::where('key', 'timezone')->first())
                                    @php($tz = $tz ? $tz->value : 0)
                                    <div class="form-group mb-0">
                                        <label
                                            class="form-label text-capitalize">{{ translate('messages.time_zone') }}</label>
                                        <select name="timezone" class="form-control js-select2-custom">
                                            <option value="UTC" {{ $tz ? ($tz == '' ? 'selected' : '') : '' }}>UTC </option>
                                            <option value="Etc/GMT+12"
                                                {{ $tz ? ($tz == 'Etc/GMT+12' ? 'selected' : '') : '' }}>(GMT-12:00)International Date Line West</option>
                                            <option value="Pacific/Midway"
                                                {{ $tz ? ($tz == 'Pacific/Midway' ? 'selected' : '') : '' }}>
                                                (GMT-11:00) Midway Island, Samoa</option>
                                            <option value="Pacific/Honolulu"
                                                {{ $tz ? ($tz == 'Pacific/Honolulu' ? 'selected' : '') : '' }}>
                                                (GMT-10:00) Hawaii</option>
                                            <option value="US/Alaska"
                                                {{ $tz ? ($tz == 'US/Alaska' ? 'selected' : '') : '' }}>(GMT-09:00)Alaska</option>
                                            <option value="America/Los_Angeles"
                                                {{ $tz ? ($tz == 'America/Los_Angeles' ? 'selected' : '') : '' }}>
                                                (GMT-08:00) Pacific Time
                                                (US & Canada)</option>
                                            <option value="America/Tijuana"
                                                {{ $tz ? ($tz == 'America/Tijuana' ? 'selected' : '') : '' }}>
                                                (GMT-08:00) Tijuana, Baja California</option>
                                            <option value="US/Arizona"
                                                {{ $tz ? ($tz == 'US/Arizona' ? 'selected' : '') : '' }}>(GMT-07:00)Arizona</option>
                                            <option value="America/Chihuahua"
                                                {{ $tz ? ($tz == 'America/Chihuahua' ? 'selected' : '') : '' }}>(GMT-07:00)Chihuahua, La
                                                Paz, Mazatlan</option>
                                            <option value="US/Mountain"
                                                {{ $tz ? ($tz == 'US/Mountain' ? 'selected' : '') : '' }}>(GMT-07:00)Mountain Time (US & Canada)</option>
                                            <option value="America/Managua"
                                                {{ $tz ? ($tz == 'America/Managua' ? 'selected' : '') : '' }}>
                                                (GMT-06:00) Central America</option>
                                            <option value="US/Central"
                                                {{ $tz ? ($tz == 'US/Central' ? 'selected' : '') : '' }}>(GMT-06:00)Central Time (US & Canada)</option>
                                            <option value="America/Mexico_City"
                                                {{ $tz ? ($tz == 'America/Mexico_City' ? 'selected' : '') : '' }}>
                                                (GMT-06:00) Guadalajara,
                                                Mexico City, Monterrey</option>
                                            <option value="Canada/Saskatchewan"
                                                {{ $tz ? ($tz == 'Canada/Saskatchewan' ? 'selected' : '') : '' }}>
                                                (GMT-06:00) Saskatchewan </option>
                                            <option value="America/Bogota"
                                                {{ $tz ? ($tz == 'America/Bogota' ? 'selected' : '') : '' }}>
                                                (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                            <option value="US/Eastern"
                                                {{ $tz ? ($tz == 'US/Eastern' ? 'selected' : '') : '' }}>(GMT-05:00)Eastern Time (US & Canada)</option>
                                            <option value="US/East-Indiana"
                                                {{ $tz ? ($tz == 'US/East-Indiana' ? 'selected' : '') : '' }}>
                                                (GMT-05:00) Indiana (East)</option>
                                            <option value="Canada/Atlantic"
                                                {{ $tz ? ($tz == 'Canada/Atlantic' ? 'selected' : '') : '' }}>
                                                (GMT-04:00) Atlantic Time (Canada)</option>
                                            <option value="America/Caracas"
                                                {{ $tz ? ($tz == 'America/Caracas' ? 'selected' : '') : '' }}>
                                                (GMT-04:00) Caracas, La Paz</option>
                                            <option value="America/Manaus"
                                                {{ $tz ? ($tz == 'America/Manaus' ? 'selected' : '') : '' }}>
                                                (GMT-04:00) Manaus</option>
                                            <option value="America/Santiago"
                                                {{ $tz ? ($tz == 'America/Santiago' ? 'selected' : '') : '' }}>
                                                (GMT-04:00) Santiago</option>
                                            <option value="Canada/Newfoundland"
                                                {{ $tz ? ($tz == 'Canada/Newfoundland' ? 'selected' : '') : '' }}>
                                                (GMT-03:30) Newfoundland </option>
                                            <option value="America/Sao_Paulo"
                                                {{ $tz ? ($tz == 'America/Sao_Paulo' ? 'selected' : '') : '' }}>(GMT-03:00)Brasilia</option>
                                            <option value="America/Argentina/Buenos_Aires"
                                                {{ $tz ? ($tz == 'America/Argentina/Buenos_Aires' ? 'selected' : '') : '' }}>
                                                (GMT-03:00)Buenos Aires, Georgetown</option>
                                            <option value="America/Godthab"
                                                {{ $tz ? ($tz == 'America/Godthab' ? 'selected' : '') : '' }}>
                                                (GMT-03:00) Greenland</option>
                                            <option value="America/Montevideo"
                                                {{ $tz ? ($tz == 'America/Montevideo' ? 'selected' : '') : '' }}>
                                                (GMT-03:00) Montevideo </option>
                                            <option value="America/Noronha"
                                                {{ $tz ? ($tz == 'America/Noronha' ? 'selected' : '') : '' }}>
                                                (GMT-02:00) Mid-Atlantic</option>
                                            <option value="Atlantic/Cape_Verde"
                                                {{ $tz ? ($tz == 'Atlantic/Cape_Verde' ? 'selected' : '') : '' }}>
                                                (GMT-01:00) Cape Verde Is. </option>
                                            <option value="Atlantic/Azores"
                                                {{ $tz ? ($tz == 'Atlantic/Azores' ? 'selected' : '') : '' }}>
                                                (GMT-01:00) Azores</option>
                                            <option value="Africa/Casablanca"
                                                {{ $tz ? ($tz == 'Africa/Casablanca' ? 'selected' : '') : '' }}>(GMT+00:00)Casablanca,
                                                Monrovia, Reykjavik</option>
                                            <option value="Etc/Greenwich"
                                                {{ $tz ? ($tz == 'Etc/Greenwich' ? 'selected' : '') : '' }}>
                                                (GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                                            <option value="Europe/Amsterdam"
                                                {{ $tz ? ($tz == 'Europe/Amsterdam' ? 'selected' : '') : '' }}>
                                                (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                            <option value="Europe/Belgrade"
                                                {{ $tz ? ($tz == 'Europe/Belgrade' ? 'selected' : '') : '' }}>
                                                (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                            <option value="Europe/Brussels"
                                                {{ $tz ? ($tz == 'Europe/Brussels' ? 'selected' : '') : '' }}>
                                                (GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                            <option value="Europe/Sarajevo"
                                                {{ $tz ? ($tz == 'Europe/Sarajevo' ? 'selected' : '') : '' }}>
                                                (GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                            <option value="Africa/Lagos"
                                                {{ $tz ? ($tz == 'Africa/Lagos' ? 'selected' : '') : '' }}>
                                                (GMT+01:00) West Central Africa</option>
                                            <option value="Asia/Amman"
                                                {{ $tz ? ($tz == 'Asia/Amman' ? 'selected' : '') : '' }}>(GMT+02:00)Amman</option>
                                            <option value="Europe/Athens"
                                                {{ $tz ? ($tz == 'Europe/Athens' ? 'selected' : '') : '' }}>
                                                (GMT+02:00) Athens, Bucharest, Istanbul</option>
                                            <option value="Asia/Beirut"
                                                {{ $tz ? ($tz == 'Asia/Beirut' ? 'selected' : '') : '' }}>(GMT+02:00)Beirut</option>
                                            <option value="Africa/Cairo"
                                                {{ $tz ? ($tz == 'Africa/Cairo' ? 'selected' : '') : '' }}>
                                                (GMT+02:00) Cairo</option>
                                            <option value="Africa/Harare"
                                                {{ $tz ? ($tz == 'Africa/Harare' ? 'selected' : '') : '' }}>
                                                (GMT+02:00) Harare, Pretoria</option>
                                            <option value="Europe/Helsinki"
                                                {{ $tz ? ($tz == 'Europe/Helsinki' ? 'selected' : '') : '' }}>
                                                (GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                                            <option value="Asia/Jerusalem"
                                                {{ $tz ? ($tz == 'Asia/Jerusalem' ? 'selected' : '') : '' }}>
                                                (GMT+02:00) Jerusalem</option>
                                            <option value="Europe/Minsk"
                                                {{ $tz ? ($tz == 'Europe/Minsk' ? 'selected' : '') : '' }}>
                                                (GMT+02:00) Minsk</option>
                                            <option value="Africa/Windhoek"
                                                {{ $tz ? ($tz == 'Africa/Windhoek' ? 'selected' : '') : '' }}>
                                                (GMT+02:00) Windhoek</option>
                                            <option value="Asia/Kuwait"
                                                {{ $tz ? ($tz == 'Asia/Kuwait' ? 'selected' : '') : '' }}>(GMT+03:00)Kuwait, Riyadh Baghdad</option>
                                            <option value="Europe/Moscow"
                                                {{ $tz ? ($tz == 'Europe/Moscow' ? 'selected' : '') : '' }}>
                                                (GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                            <option value="Africa/Nairobi"
                                                {{ $tz ? ($tz == 'Africa/Nairobi' ? 'selected' : '') : '' }}>
                                                (GMT+03:00) Nairobi</option>
                                            <option value="Asia/Tbilisi"
                                                {{ $tz ? ($tz == 'Asia/Tbilisi' ? 'selected' : '') : '' }}>
                                                (GMT+03:00) Tbilisi</option>
                                            <option value="Asia/Tehran"
                                                {{ $tz ? ($tz == 'Asia/Tehran' ? 'selected' : '') : '' }}>(GMT+03:30)Tehran</option>
                                            <option value="Asia/Muscat"
                                                {{ $tz ? ($tz == 'Asia/Muscat' ? 'selected' : '') : '' }}>(GMT+04:00)Abu Dhabi,Muscat</option>
                                            <option value="Asia/Baku"
                                                {{ $tz ? ($tz == 'Asia/Baku' ? 'selected' : '') : '' }}>(GMT+04:00)Baku</option>
                                            <option value="Asia/Yerevan"
                                                {{ $tz ? ($tz == 'Asia/Yerevan' ? 'selected' : '') : '' }}>
                                                (GMT+04:00) Yerevan</option>
                                            <option value="Asia/Kabul"
                                                {{ $tz ? ($tz == 'Asia/Kabul' ? 'selected' : '') : '' }}>(GMT+04:30)Kabul</option>
                                            <option value="Asia/Yekaterinburg"
                                                {{ $tz ? ($tz == 'Asia/Yekaterinburg' ? 'selected' : '') : '' }}>
                                                (GMT+05:00) Yekaterinburg </option>
                                            <option value="Asia/Karachi"
                                                {{ $tz ? ($tz == 'Asia/Karachi' ? 'selected' : '') : '' }}>
                                                (GMT+05:00) Islamabad, Karachi, Tashkent</option>
                                            <option value="Asia/Calcutta"
                                                {{ $tz ? ($tz == 'Asia/Calcutta' ? 'selected' : '') : '' }}>
                                                (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                            <!-- <option value="Asia/Calcutta"  {{ $tz ? ($tz == 'Asia/Calcutta' ? 'selected' : '') : '' }}>(GMT+05:30) Sri Jayawardenapura</option> -->
                                            <option value="Asia/Katmandu"
                                                {{ $tz ? ($tz == 'Asia/Katmandu' ? 'selected' : '') : '' }}>
                                                (GMT+05:45) Kathmandu</option>
                                            <option value="Asia/Almaty"
                                                {{ $tz ? ($tz == 'Asia/Almaty' ? 'selected' : '') : '' }}>(GMT+06:00)Almaty, Novosibirsk</option>
                                            <option value="Asia/Dhaka"
                                                {{ $tz ? ($tz == 'Asia/Dhaka' ? 'selected' : '') : '' }}>(GMT+06:00)Astana, Dhaka</option>
                                            <option value="Asia/Rangoon"
                                                {{ $tz ? ($tz == 'Asia/Rangoon' ? 'selected' : '') : '' }}>
                                                (GMT+06:30) Yangon (Rangoon)</option>
                                            <option value="Asia/Bangkok"
                                                {{ $tz ? ($tz == 'Asia/Bangkok' ? 'selected' : '') : '' }}>
                                                (GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                            <option value="Asia/Krasnoyarsk"
                                                {{ $tz ? ($tz == 'Asia/Krasnoyarsk' ? 'selected' : '') : '' }}>
                                                (GMT+07:00) Krasnoyarsk</option>
                                            <option value="Asia/Hong_Kong"
                                                {{ $tz ? ($tz == 'Asia/Hong_Kong' ? 'selected' : '') : '' }}>
                                                (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                            <option value="Asia/Kuala_Lumpur"
                                                {{ $tz ? ($tz == 'Asia/Kuala_Lumpur' ? 'selected' : '') : '' }}>
                                                (GMT+08:00) Kuala Lumpur,
                                                Singapore</option>
                                            <option value="Asia/Irkutsk"
                                                {{ $tz ? ($tz == 'Asia/Irkutsk' ? 'selected' : '') : '' }}>
                                                (GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                            <option value="Australia/Perth"
                                                {{ $tz ? ($tz == 'Australia/Perth' ? 'selected' : '') : '' }}>
                                                (GMT+08:00) Perth</option>
                                            <option value="Asia/Taipei"
                                                {{ $tz ? ($tz == 'Asia/Taipei' ? 'selected' : '') : '' }}>(GMT+08:00)Taipei</option>
                                            <option value="Asia/Tokyo"
                                                {{ $tz ? ($tz == 'Asia/Tokyo' ? 'selected' : '') : '' }}>(GMT+09:00)Osaka, Sapporo, Tokyo</option>
                                            <option value="Asia/Seoul"
                                                {{ $tz ? ($tz == 'Asia/Seoul' ? 'selected' : '') : '' }}>(GMT+09:00)Seoul</option>
                                            <option value="Asia/Yakutsk"
                                                {{ $tz ? ($tz == 'Asia/Yakutsk' ? 'selected' : '') : '' }}>
                                                (GMT+09:00) Yakutsk</option>
                                            <option value="Australia/Adelaide"
                                                {{ $tz ? ($tz == 'Australia/Adelaide' ? 'selected' : '') : '' }}>
                                                (GMT+09:30) Adelaide </option>
                                            <option value="Australia/Darwin"
                                                {{ $tz ? ($tz == 'Australia/Darwin' ? 'selected' : '') : '' }}>
                                                (GMT+09:30) Darwin</option>
                                            <option value="Australia/Brisbane"
                                                {{ $tz ? ($tz == 'Australia/Brisbane' ? 'selected' : '') : '' }}>
                                                (GMT+10:00) Brisbane </option>
                                            <option value="Australia/Canberra"
                                                {{ $tz ? ($tz == 'Australia/Canberra' ? 'selected' : '') : '' }}>
                                                (GMT+10:00) Canberra,
                                                Melbourne, Sydney</option>
                                            <option value="Australia/Hobart"
                                                {{ $tz ? ($tz == 'Australia/Hobart' ? 'selected' : '') : '' }}>
                                                (GMT+10:00) Hobart</option>
                                            <option value="Pacific/Guam"
                                                {{ $tz ? ($tz == 'Pacific/Guam' ? 'selected' : '') : '' }}>
                                                (GMT+10:00) Guam, Port Moresby</option>
                                            <option value="Asia/Vladivostok"
                                                {{ $tz ? ($tz == 'Asia/Vladivostok' ? 'selected' : '') : '' }}>
                                                (GMT+10:00) Vladivostok</option>
                                            <option value="Asia/Magadan"
                                                {{ $tz ? ($tz == 'Asia/Magadan' ? 'selected' : '') : '' }}>
                                                (GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
                                            <option value="Pacific/Auckland"
                                                {{ $tz ? ($tz == 'Pacific/Auckland' ? 'selected' : '') : '' }}>
                                                (GMT+12:00) Auckland, Wellington</option>
                                            <option value="Pacific/Fiji"
                                                {{ $tz ? ($tz == 'Pacific/Fiji' ? 'selected' : '') : '' }}>
                                                (GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                            <option value="Pacific/Tongatapu"
                                                {{ $tz ? ($tz == 'Pacific/Tongatapu' ? 'selected' : '') : '' }}>
                                                (GMT+13:00) Nuku'alofa </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    @php($tf = \App\Models\BusinessSetting::where('key', 'timeformat')->first())
                                    @php($tf = $tf ? $tf->value : '24')
                                    <div class="form-group mb-0">
                                        <label
                                            class="form-label text-capitalize">{{ translate('messages.time_format') }}</label>
                                        <select name="time_format" class="form-control">
                                            <option value="12" {{ $tf == '12' ? 'selected' : '' }}>
                                                {{ translate('messages.12_hour') }} </option>
                                            <option value="24" {{ $tf == '24' ? 'selected' : '' }}>
                                                {{ translate('messages.24_hour') }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    @php($currency_code = \App\Models\BusinessSetting::where('key', 'currency')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="exampleFormControlInput1">{{ translate('Currency Symbol') }}</label>
                                        <select name="currency" class="form-control js-select2-custom">
                                            @foreach (\App\Models\Currency::orderBy('currency_code')->get() as $currency)<option value="{{ $currency['currency_code'] }}"
                                                    {{ $currency_code ? ($currency_code->value == $currency['currency_code'] ? 'selected' : '') : '' }}>
                                                    {{ $currency['currency_code'] }} ({{ $currency['currency_symbol'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    @php($currency_symbol_position = \App\Models\BusinessSetting::where('key', 'currency_symbol_position')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label text-capitalize"
                                            for="currency_symbol_position">{{ translate('Currency Position') }} 
                                        </label>
                                        <div class="resturant-type-group border">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="left" name="currency_symbol_position" {{ $currency_symbol_position ? ($currency_symbol_position->value == 'left' ? 'checked' : '') : '' }}>
                                                <span class="form-check-label">
                                                    ($) {{translate('Left')}}
                                                </span>
                                            </label>
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="right" name="currency_symbol_position" {{ $currency_symbol_position ? ($currency_symbol_position->value == 'right' ? 'checked' : '') : '' }}>
                                                <span class="form-check-label">
                                                    {{translate('Right')}} ($)
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    @php($digit_after_decimal_point = \App\Models\BusinessSetting::where('key', 'digit_after_decimal_point')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label text-capitalize"
                                            for="digit_after_decimal_point">{{ translate('messages.Digit after decimal point') }}
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('how_many_fractional_digit_to_show_after_decimal_value') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span>
                                        </label>
                                        <input type="number" name="digit_after_decimal_point" class="form-control"
                                            id="digit_after_decimal_point" placeholder="{{ translate('messages.ex_:_2') }}"
                                            value="{{ $digit_after_decimal_point ? $digit_after_decimal_point->value : 0 }}"
                                            min="0" max="4" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xl-5">
                                    @php($footer_text = \App\Models\BusinessSetting::where('key', 'footer_text')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="exampleFormControlInput1">{{ translate('Copyright Text') }}
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.make_visitors_aware_of_your_business‘s_rights_&_legal_information.') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span>
                                        </label>
                                        <textarea type="text" value="" name="footer_text" class="form-control h--45"
                                            placeholder="{{ translate('messages.Ex_:_Copyright_Text') }}" required>{{ $footer_text->value ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xl-4">
                                    @php($cookies_text = \App\Models\BusinessSetting::where('key', 'cookies_text')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="exampleFormControlInput1">{{ translate('Cookies Text') }}
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.make_visitors_aware_of_your_business‘s_rights_&_legal_information.') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span>
                                        </label>
                                        <textarea type="text" value="" name="cookies_text" class="form-control h--45"
                                            placeholder="{{ translate('messages.Ex_:_Cookies_Text') }}" required>{{ $cookies_text->value ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h4 class="card-title mb-3 d-flex align-items-center"> <span class="card-header-icon mr-2"><i
                                class="tio-neighborhood"></i></span>
                        <span>{{ translate('messages.Business_Rules_setup') }}</span></h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-sm-6 col-lg-4">
                                    @php($admin_commission = \App\Models\BusinessSetting::where('key', 'admin_commission')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label text-capitalize"
                                            for="admin_commission">
                                            {{ translate('messages.Default_Commission_Rate_On_Order') }}
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.Set_up_‘Default_Commission_Rate’_on_every_Order._Admin_can_also_set_store-wise_different_commission_rates_from_respective_store_settings.') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span>
                                        </label>
                                        <input type="number" name="admin_commission" class="form-control"
                                            id="admin_commission"
                                            value="{{ $admin_commission ? $admin_commission->value : 0 }}"
                                            min="0" max="100" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    @php($delivery_charge_comission = \App\Models\BusinessSetting::where('key', 'delivery_charge_comission')->first())
                                    <div class="form-group mb-0">
                                        <label class="input-label text-capitalize d-flex alig-items-center"
                                        for="admin_comission_in_delivery_charge">
                                        {{translate('messages.Commission_Rate_On_Delivery_Charge')}}
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.Set_a_default_‘Commission_Rate’_for_freelance_deliverymen_(under_admin)_on_every_deliveryman. ') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span>
                                        </label>
                                            <input type="number" name="admin_comission_in_delivery_charge" class="form-control" id="admin_comission_in_delivery_charge"
                                            min="0" max="100" step="0.01" value="{{ $delivery_charge_comission ? $delivery_charge_comission->value: 0 }}">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6">
                                    @php($order_confirmation_model = \App\Models\BusinessSetting::where('key', 'order_confirmation_model')->first())
                                    @php($order_confirmation_model = $order_confirmation_model ? $order_confirmation_model->value : 'deliveryman')
                                    <div class="form-group mb-0">
                                        <label class="input-label text-capitalize d-flex alig-items-center"><span
                                                class="line--limit-1">{{ translate('messages.Who_Will_Confirm_Order?') }}
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.After_a_customer_order_placement,_Admin_can_define_who_will_confirm_the_order_first-_Deliveryman_or_Store?_For_example,_if_you_choose_‘Delivery_man’,_the_deliveryman_nearby_will_confirm_the_order_and_forward_it_to_the_related_store_to_process_the_order._It_works_vice-versa_if_you_choose_‘Store’.') }}" alt="">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span>
                                            </span>
                                        </label>
                                        <div class="resturant-type-group border">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="store"
                                                    name="order_confirmation_model" id="order_confirmation_model"
                                                    {{ $order_confirmation_model == 'store' ? 'checked' : '' }}>
                                                <span class="form-check-label">
                                                    {{ translate('messages.store') }}
                                                </span>
                                            </label>
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="deliveryman"
                                                    name="order_confirmation_model" id="order_confirmation_model2"
                                                    {{ $order_confirmation_model == 'deliveryman' ? 'checked' : '' }}>
                                                <span class="form-check-label">
                                                    {{ translate('messages.deliveryman') }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    @php($tax_included = \App\Models\BusinessSetting::where('key', 'tax_included')->first())
                                    @php($tax_included = $tax_included ? $tax_included->value : 0)
                                    <div class="form-group mb-0">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border rounded px-3 form-control">
                                        <span class="pr-1 d-flex align-items-center"><span class="line--limit-1">{{ translate('Include_TAX_Amount') }}</span>
                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{translate('messages.If_enabled,_the_customer_will_see_the_total_product_price,_including_VAT/Tax._If_it’s_disabled,_the_VAT/Tax_will_be_added_separately_with_the_total_cost_of_the_product.')}}">
                                            <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                        </span>
                                        </span>
                                            <input type="checkbox" onclick="toogleModal(event,'tax_included','tax-on.png','tax-off.png','{{translate('messages.Want_to')}} <strong>{{translate('messages.‘Include_Tax_Amount?’')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('messages.Tax_Amount’?')}}</strong>',`<p>{{translate('messages.If_you_enable_it,_customers_will_see_the_product_Price_including_Tax,_during_checkout. ')}}</p>`,`<p>{{translate('messages.If_you_disable_it,_customers_will_see_the_product_or_service_price_without_Tax,_during_checkout.')}}</p>`)"  class="toggle-switch-input" value="1" name="tax_included" id="tax_included"
                                            {{ $tax_included == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    @php($minimum_shipping_charge = \App\Models\BusinessSetting::where('key', 'minimum_shipping_charge')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label text-capitalize"
                                            for="minimum_shipping_charge">{{ translate('messages.minimum_shipping_charge') }}</label>
                                        <input type="number" name="minimum_shipping_charge" class="form-control"
                                            id="minimum_shipping_charge" min="0" step=".01"
                                            value="{{ $minimum_shipping_charge ? $minimum_shipping_charge->value : 0 }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    @php($per_km_shipping_charge = \App\Models\BusinessSetting::where('key', 'per_km_shipping_charge')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label text-capitalize"
                                            for="per_km_shipping_charge">{{ translate('messages.per_km_shipping_charge') }}</label>
                                        <input type="number" name="per_km_shipping_charge" class="form-control"
                                            id="per_km_shipping_charge" min="0" step=".01"
                                            value="{{ $per_km_shipping_charge ? $per_km_shipping_charge->value : 0 }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    @php($vnv = \App\Models\BusinessSetting::where('key', 'toggle_veg_non_veg')->first())
                                    @php($vnv = $vnv ? $vnv->value : 0)
                                    <div class="form-group mb-0">

                                        <label
                                            class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                            <span class="pr-1 d-flex align-items-center switch--label">
                                                <span class="line--limit-1">
                                                    {{ translate('messages.Customer’s_Food_Preference') }}
                                                </span>
                                                <span class="form-label-secondary text-danger d-flex"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="{{ translate('messages.If_this_feature_is_active,_customers_can_filter_food_according_to_their_preference_from_the_Customer_App_or_Website.') }}"><img
                                                        src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                        alt="{{ translate('messages.veg_non_veg') }}"> * </span>
                                            </span>
                                            <input type="checkbox" onclick="toogleModal(event,'vnv1','veg-on.png','veg-off.png','{{translate('messages.Want_to_enable_the')}} <strong>{{translate('messages.‘Veg/Non-Veg’_feature?')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('messages.the_Veg/Non-Veg_Feature?')}}</strong>',`<p>{{translate('messages.If_you_enable_this,_customers_can_filter_food_items_by_choosing_food_from_the_Veg/Non-Veg_feature.')}}</p>`,`<p>{{translate('messages.If_you_disable_this,_the_Veg/Non-Veg_feature_will_be_hidden_in_the_Customer_App_&_Website.')}}</p>`)" class="toggle-switch-input" value="1"
                                                name="vnv" id="vnv1" {{ $vnv == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    @php($free_delivery_over = \App\Models\BusinessSetting::where('key', 'free_delivery_over')->first())
                                    @php($free_delivery_over_status = \App\Models\BusinessSetting::where('key', 'free_delivery_over_status')->first())
                                    <div class="form-group mb-0">
                                        <label class="form-label d-flex justify-content-between text-capitalize mb-1"
                                            for="free_delivery_over_status">
                                            <span class="line--limit-1">{{ translate('messages.free_delivery_over') }}
                                                ({{ \App\CentralLogics\Helpers::currency_symbol() }}) <small
                                                class="text-danger"><span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="{{ translate('messages.Set_a_minimum_order_value_for_automated_free_delivery._If_the_minimum_amount_is_exceeded,_the_Delivery_Fee_is_deducted_from_Admin’s_commission_and_added_to_Admin’s_expense.') }}"><img
                                                        src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                        alt="{{ translate('messages.free_over_delivery_message') }}"></span>
                                                *</small></span>
                                            <span class="toggle-switch toggle-switch-sm pr-sm-3">
                                                <input type="checkbox" onclick="toogleModal(event,'free_delivery_over_status','free-delivery-on.png','free-delivery-off.png','<strong>{{translate('messages.Want_to_enable_Free_Delivery_on_Minimum_Orders?')}}</strong>','<strong>{{translate('messages.Want_to_disable_Free_Delivery_on_Minimum_Order?')}}</strong>',`<p>{{translate('messages.If_you_enable_this,_customers_can_get_FREE_Delivery_by_fulfilling_the_minimum_order_requirement.')}}</p>`,`<p>{{translate('messages.If_you_disable_this,_the_FREE_Delivery_option_will_be_hidden_from_the_Customer_App_or_Website.')}}</p>`)" class="status toggle-switch-input"
                                                    name="free_delivery_over_status" id="free_delivery_over_status"
                                                    value="1"
                                                    {{ isset($free_delivery_over_status->value) ? 'checked' : '' }}>
                                                <span class="toggle-switch-label text mb-0"><span
                                                        class="toggle-switch-indicator"></span></span>
                                            </span>
                                        </label>

                                        <input type="number" name="free_delivery_over" class="form-control"
                                            id="free_delivery_over"
                                            value="{{ $free_delivery_over ? $free_delivery_over->value : 0 }}"
                                            min="0" step=".01" required
                                            {{ isset($free_delivery_over_status->value) ? '' : 'readonly' }}>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    @php($admin_order_notification = \App\Models\BusinessSetting::where('key', 'admin_order_notification')->first())
                                    @php($admin_order_notification = $admin_order_notification ? $admin_order_notification->value : 0)
                                    <div class="form-group mb-0">

                                        <label
                                            class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                            <span class="pr-1 d-flex align-items-center switch--label">
                                                <span class="line--limit-1">
                                                    {{ translate('messages.Order_Notification_for_Admin') }}
                                                </span>
                                                <span class="form-label-secondary text-danger d-flex"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="{{ translate('messages.Admin_will_get_a_pop-up_notification_with_sounds_for_any_order_placed_by_customers.') }}"><img
                                                        src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                        alt="{{ translate('messages.customer_varification_toggle') }}"> *
                                                </span>
                                            </span>
                                            <input type="checkbox" onclick="toogleModal(event,'aon1','order-notification-on.png','order-notification-off.png','{{translate('messages.Want_to_enable')}} <strong>{{translate('messages.Order_Notification_for_Admin?')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('messages.Order_Notification_for_Admin?')}}</strong>',`<p>{{translate('messages.If_you_enable_this,_the_Admin_will_receive_a_Notification_for_every_order_placed.')}}</p>`,`<p>{{translate('messages.If_you_disable_this,_the_Admin_will_NOT_receive_a_Notification_for_every_order_placed.')}}</p>`)" class="toggle-switch-input" value="1"
                                                name="admin_order_notification" id="aon1"
                                                {{ $admin_order_notification == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-3">
                                <button type="reset" class="btn btn--reset">{{ translate('messages.reset') }}</button>
                                <button type="{{ env('APP_MODE') != 'demo' ? 'submit' : 'button' }}"
                                    onclick="{{ env('APP_MODE') != 'demo' ? '' : 'call_demo()' }}"
                                    class="btn btn--primary">{{ translate('save_information') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('script_2')
    <script>
        @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
        @php($language = $language->value ?? null)
        let language = <?php echo $language; ?>;
        $('[id=language]').val(language);

        function maintenance_mode() {
            @if (env('APP_MODE') == 'demo')
                toastr.warning('Sorry! You can not enable maintainance mode in demo!');
            @else
                Swal.fire({
                    title: '{{ translate('messages.Are you sure?') }}',
                    text: '{{ translate('messages.all_your_apps_and_customer_website_will_be_disabled_until_you_‘Turn_Off’ _maintenance_mode.') }}',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#00868F',
                    cancelButtonText: '{{ translate('messages.no') }}',
                    confirmButtonText: '{{ translate('messages.yes') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.get({
                            url: '{{ route('admin.maintenance-mode') }}',
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                $('#loading').show();
                            },
                            success: function(data) {
                                toastr.success(data.message);
                            },
                            complete: function() {
                                $('#loading').hide();
                            },
                        });
                    } else {
                        location.reload();
                    }
                })
            @endif
        };

        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + viewer).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this, 'viewer');
        });

        $("#favIconUpload").change(function() {
            readURL(this, 'iconViewer');
        });
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&libraries=places&v=3.45.8">
    </script>
    <script>
        function initAutocomplete() {
            var myLatLng = {
                lat: {{ $default_location ? $default_location['lat'] : '-33.8688' }},
                lng: {{ $default_location ? $default_location['lng'] : '151.2195' }}
            };
            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: {
                    lat: {{ $default_location ? $default_location['lat'] : '-33.8688' }},
                    lng: {{ $default_location ? $default_location['lng'] : '151.2195' }}
                },
                zoom: 13,
                mapTypeId: "roadmap",
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
            });

            marker.setMap(map);
            var geocoder = geocoder = new google.maps.Geocoder();
            google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                var coordinates = JSON.parse(coordinates);
                var latlng = new google.maps.LatLng(coordinates['lat'], coordinates['lng']);
                marker.setPosition(latlng);
                map.panTo(latlng);

                document.getElementById('latitude').value = coordinates['lat'];
                document.getElementById('longitude').value = coordinates['lng'];


                geocoder.geocode({
                    'latLng': latlng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            document.getElementById('address').innerHtml = results[1].formatted_address;
                        }
                    }
                });
            });
            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var mrkr = new google.maps.Marker({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                    });
                    google.maps.event.addListener(mrkr, "click", function(event) {
                        document.getElementById('latitude').value = this.position.lat();
                        document.getElementById('longitude').value = this.position.lng();
                    });

                    markers.push(mrkr);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        };
        $(document).on('ready', function() {
            initAutocomplete();
            @php($country = \App\Models\BusinessSetting::where('key', 'country')->first())

            @if ($country)
                $("#country option[value='{{ $country->value }}']").attr('selected', 'selected').change();
            @endif



            $("#free_delivery_over_status").on('change', function() {
                if ($("#free_delivery_over_status").is(':checked')) {
                    $('#free_delivery_over').removeAttr('readonly');
                } else {
                    $('#free_delivery_over').attr('readonly', true);
                    $('#free_delivery_over').val(null);
                }
            });
        });

        $(document).on("keydown", "input", function(e) {
            if (e.which == 13) e.preventDefault();
        });
    </script>
@endpush
