@extends('layouts.app')

@section('title')
    {{ __('Settings') }}
@endsection

@section('css')
    <!-- Colorpicker -->
    <link rel="stylesheet" href="{{ url('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Switch -->
    <link rel="stylesheet" href="{{ url('plugins/swtich-netliva/css/netliva_switch.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Settings') }}</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h5 class="card-title">
            </h5>
        </div>
        <div class="card-body pt-2">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="nav flex-column nav-tabs  h-100" id="vert-tabs-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" data-toggle="pill" href="#general_settings" role="tab"
                            aria-controls="general_settings" aria-selected="true"><i class="fas fa-cog"></i>
                            {{ __('General') }}</a>
                        <a class="nav-link" data-toggle="pill" href="#reports_settings" role="tab"
                            aria-controls="reports_settings" aria-selected="true"><i class="fas fa-file-alt"></i>
                            {{ __('Reports') }}</a>

                        <a class="nav-link" data-toggle="pill" href="#Invoices_settings" role="tab"
                            aria-controls="Invoices_settings" aria-selected="true"><i class="fas fa-file-alt"></i>
                            {{ __('Invoices_settings') }}</a>

                        <a class="nav-link" data-toggle="pill" href="#barcode_settings" role="tab"
                            aria-controls="barcode_settings" aria-selected="true"><i class="fas fa-barcode"></i>
                            {{ __('Barcode') }}</a>
                        <a class="nav-link" data-toggle="pill" href="#medical_settings" role="tab"
                            aria-controls="medical_settings" aria-selected="true"><i class="fas fa-book-medical"></i>
                            {{ __('Tests') }}</a>
                        @if (isset($printer_settings) && $printer_settings != null)
                            <a class="nav-link" data-toggle="pill" href="#printer_settings" role="tab"
                                aria-controls="printer_settings" aria-selected="true"><i class="fas fa-print"></i>
                                {{ __('Printer') }}</a>
                        @endif
                        <a class="nav-link" data-toggle="pill" href="#emails_settings" role="tab"
                            aria-controls="emails_settings" aria-selected="true"><i class="fas fa-envelope"></i>
                            {{ __('Emails') }}</a>
                        <a class="nav-link" data-toggle="pill" href="#sms_settings" role="tab"
                            aria-controls="sms_settings" aria-selected="true"><i class="fas fa-sms"></i>
                            {{ __('SMS') }}</a>
                        <a class="nav-link" data-toggle="pill" href="#whatsapp_settings" role="tab"
                            aria-controls="whatsapp_settings" aria-selected="true"><i class="fab fa-whatsapp"></i>
                            {{ __('Whatsapp') }}</a>
                        <a class="nav-link" data-toggle="pill" href="#api_keys_settings" role="tab"
                            aria-controls="api_keys_settings" aria-selected="true"><i class="fas fa-key"></i>
                            {{ __('Api Keys') }}</a>
                        <a class="nav-link" data-toggle="pill" href="#accounting" role="tab" aria-controls="accounting"
                            aria-selected="true"><i class="fas fa-key"></i> {{ __('Accounting') }}</a>
                        <a class="nav-link" data-toggle="pill" href="#taxesSetting" role="tab"
                            aria-controls="taxesSetting" aria-selected="true"><i class="fas fa-key"></i>
                            {{ __('taxesSetting') }}</a>


                    </div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <div class="tab-content" id="vert-tabs-tabContent">

                        <!-- General Settings -->
                        <div class="tab-pane text-left fade show active" id="general_settings" role="tabpanel"
                            aria-labelledby="general_settings">
                            <div class="col-12 col-sm-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title">{{ __('General Settings') }}</h5>
                                    </div>
                                    <form action="{{ route('admin.settings.info_submit') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="card card-primary card-tabs">

                                                <div class="card-header p-0 pt-1">
                                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="custom-tabs-one-home-tab"
                                                                data-toggle="pill" href="#general" role="tab"
                                                                aria-controls="general"
                                                                aria-selected="false">{{ __('General') }}</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="social-tab" data-toggle="pill"
                                                                href="#social" role="tab" aria-controls="social"
                                                                aria-selected="false">{{ __('Social') }}</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="logos-tab" data-toggle="pill"
                                                                href="#logos" role="tab" aria-controls="logos"
                                                                aria-selected="true">{{ __('Images') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="card-body">
                                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                                        <div class="tab-pane active fade show" id="general"
                                                            role="tabpanel" aria-labelledby="general-tab">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-file-signature"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ $settings['name'] }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-pound-sign"></i>
                                                                            </span>
                                                                        </div>
                                                                        <select name="currency" id="currency"
                                                                            class="form-control select2">
                                                                            @foreach ($currencies as $currency)
                                                                                <option value="{{ $currency['iso'] }}"
                                                                                    @if ($settings['currency'] == $currency['iso']) selected @endif>
                                                                                    {{ $currency['name'] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-clock"></i>
                                                                            </span>
                                                                        </div>
                                                                        <select name="timezone" id="timezone"
                                                                            class="form-control">
                                                                            @if (isset($timezone_settings))
                                                                                <option
                                                                                    value="{{ $timezone_settings['timezone'] }}"
                                                                                    selected>
                                                                                    {{ $timezone_settings['name'] }}
                                                                                </option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-language"></i>
                                                                            </span>
                                                                        </div>
                                                                        <select name="language" id="language"
                                                                            class="form-control">
                                                                            @if (isset($info['language']))
                                                                                <option value="{{ $info['language'] }}"
                                                                                    selected>{{ $info['language'] }}
                                                                                </option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-search-location"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="address"
                                                                            id="address" class="form-control"
                                                                            value="{{ $settings['address'] }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-phone-square-alt"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="phone"
                                                                            id="phone" class="form-control"
                                                                            value="{{ $settings['phone'] }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-envelope-square"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="email" name="email"
                                                                            id="email" class="form-control"
                                                                            value="{{ $settings['email'] }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-globe"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="website"
                                                                            id="website" class="form-control"
                                                                            value="{{ $settings['website'] }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <div class="input-group form-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-copyright"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" name="footer"
                                                                                id="footer"
                                                                                placeholder="{{ __('Footer') }}"
                                                                                class="form-control"
                                                                                value="{{ $settings['footer'] }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <div class="input-group form-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-copyright"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" name="portalID"
                                                                                id="portalID"
                                                                                placeholder="{{ __('PortalID') }}"
                                                                                class="form-control"
                                                                                @if (isset($settings['portalID'])) value="{{ $settings['portalID'] }}" @endif
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade" id="social" role="tabpanel"
                                                            aria-labelledby="social-tab">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fab fa-facebook"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="facebook"
                                                                            id="facebook" class="form-control"
                                                                            value="{{ $settings['socials']['facebook'] }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fab fa-twitter"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="twitter"
                                                                            id="twitter" class="form-control"
                                                                            value="{{ $settings['socials']['twitter'] }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fab fa-instagram"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="instagram"
                                                                            id="instagram" class="form-control"
                                                                            value="{{ $settings['socials']['instagram'] }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group form-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fab fa-youtube"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="youtube"
                                                                            id="youtube" class="form-control"
                                                                            value="{{ $settings['socials']['youtube'] }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade" id="logos" role="tabpanel"
                                                            aria-labelledby="logos-tab">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="banner"
                                                                                    accept="image/*"
                                                                                    class="custom-file-input"
                                                                                    id="banner">
                                                                                <label class="custom-file-label"
                                                                                    for="banner">{{ __('Login banner') }}
                                                                                    [1200 X 1200]</label>
                                                                            </div>
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"
                                                                                    id="">
                                                                                    <a href="{{ url('assets/images/banner.jpg') }}"
                                                                                        data-toggle="lightbox"
                                                                                        data-title="Reports logo">
                                                                                        <i class="fa fa-image"></i>
                                                                                    </a>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="reports_logo"
                                                                                    accept="image/*"
                                                                                    class="custom-file-input"
                                                                                    id="reports_logo">
                                                                                <label class="custom-file-label"
                                                                                    for="reports_logo">{{ __('Choose Report Logo') }}
                                                                                    [300 X 300]</label>
                                                                            </div>
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"
                                                                                    id="">
                                                                                    <a href="{{ url('img/reports_logo.png') }}"
                                                                                        data-toggle="lightbox"
                                                                                        data-title="Reports logo">
                                                                                        <i class="fa fa-image"></i>
                                                                                    </a>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="logo"
                                                                                    accept="image/*"
                                                                                    class="custom-file-input"
                                                                                    id="logo">
                                                                                <label class="custom-file-label"
                                                                                    for="logo">{{ __('Choose Logo') }}
                                                                                    [300 X 300]</label>
                                                                            </div>
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"
                                                                                    id="">
                                                                                    <a href="{{ url('img/logo.png') }}"
                                                                                        data-toggle="lightbox"
                                                                                        data-title="Logo">
                                                                                        <i class="fa fa-image"></i>
                                                                                    </a>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="Letterhead-bg"
                                                                                    accept="image/*"
                                                                                    class="custom-file-input"
                                                                                    id="Letterhead-bg">
                                                                                <label class="custom-file-label"
                                                                                    for="Letterhead-bg">{{ __('Report Back Ground') }}
                                                                                    [500 X 400]</label>
                                                                            </div>
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"
                                                                                    id="">
                                                                                    <a @if (isset($settings['Letterhead-bg'])) href="{{ url('img/' . $settings['Letterhead-bg']) }}" @endif
                                                                                        data-toggle="lightbox"
                                                                                        data-title="Logo">
                                                                                        <i class="fa fa-image"></i>
                                                                                    </a>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- /.card -->
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i>
                                                {{ __('Save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- \General Settings -->

                        <!-- Reports settings -->
                        <div class="tab-pane text-left fade show" id="reports_settings" role="tabpanel"
                            aria-labelledby="reports_settings">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Reports Settings') }}</h3>
                                </div>
                                <form action="{{ route('admin.settings.reports_submit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 mt-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            <label for="QR_Code"
                                                                style="font-weight: 600">{{ __('QR Code & Print Settings') }}</label>
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">

                                                            <div class="col-lg-12">

                                                                <div class="row">

                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <input type="checkbox" name="show_qrcode"
                                                                                id="show_qrcode"
                                                                                @if ($reports_settings['show_qrcode']) checked @endif>
                                                                            <label for="show_qrcode"><i
                                                                                    class="fas fa-qrcode"></i>
                                                                                {{ __('Show QR Code') }}</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <input type="checkbox"
                                                                                name="qrcode_to_account"
                                                                                id="qrcode_to_account"
                                                                                @if (isset($reports_settings['qrcode_to_account']) && $reports_settings['qrcode_to_account']) checked @endif>
                                                                            <label for="qrcode_to_account"><i
                                                                                    class="fas fa-qrcode"></i>
                                                                                {{ __('QR Code Open Account') }}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <input type="checkbox" name="qrcode_to_pdf"
                                                                                id="qrcode_to_pdf"
                                                                                @if (isset($reports_settings['qrcode_to_pdf']) && $reports_settings['qrcode_to_pdf']) checked @endif>
                                                                            <label for="qrcode_to_pdf"><i
                                                                                    class="fas fa-qrcode"></i>
                                                                                {{ __('QR Code Open PDF') }}</label>
                                                                        </div>
                                                                    </div>


                                                                </div>


                                                            </div>
                                                            <div class="row">

                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="report_paid_stauts"
                                                                            id="report_paid_stauts"
                                                                            @if (isset($reports_settings['report_paid_stauts']) && $reports_settings['report_paid_stauts']) checked @endif>
                                                                        <label for="report_paid_stauts"><i
                                                                                class="fas fa-user-circle"></i>
                                                                            {{ __('Show Reports If Not Paid') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="report_sign_stauts"
                                                                            id="report_sign_stauts"
                                                                            @if (isset($reports_settings['report_sign_stauts']) && $reports_settings['report_sign_stauts']) checked @endif>
                                                                        <label for="report_sign_stauts"><i
                                                                                class="fas fa-user-circle"></i>
                                                                            {{ __('Show Reports If Not Sign') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="show_header"
                                                                            id="show_header"
                                                                            @if ($reports_settings['show_header']) checked @endif>
                                                                        <label for="show_header"><i
                                                                                class="fa fa-arrow-up"></i>
                                                                            {{ __('Show Header') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="show_footer"
                                                                            id="show_footer"
                                                                            @if ($reports_settings['show_footer']) checked @endif>
                                                                        <label for="show_footer"><i
                                                                                class="fas fa-arrow-down"></i>
                                                                            {{ __('Show Footer') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="show_signature"
                                                                            id="show_signature"
                                                                            @if ($reports_settings['show_signature']) checked @endif>
                                                                        <label for="show_signature"><i
                                                                                class="fas fa-signature"></i>
                                                                            {{ __('Show signature') }}</label>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="show_avatar"
                                                                            id="show_avatar"
                                                                            @if ($reports_settings['show_avatar']) checked @endif>
                                                                        <label for="show_avatar"><i
                                                                                class="fas fa-user-circle"></i>
                                                                            {{ __('Show patient avatar') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="qrcode-dimension"><i
                                                                                class="fa fa-qrcode"></i>
                                                                            {{ __('Qrcode dimension') }}</label>
                                                                        <input type="number" min="50"
                                                                            id="qrcode-dimension" name="qrcode-dimension"
                                                                            class="form-control"
                                                                            @if (isset($reports_settings['content-margin-bottom'])) value="{{ $reports_settings['qrcode-dimension'] }}" @endif
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="direction"
                                                                            id="direction"
                                                                            @if (isset($reports_settings['direction']) && $reports_settings['direction']) checked @endif>
                                                                        <label for="direction"><i
                                                                                class="fas fa-user-circle"></i>
                                                                            {{ __('Direction RLT') }}</label>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="test_title_color">{{ __('Status') }}</label>
                                                                <div class="input-group">
                                                                    <input id="" type="checkbox"
                                                                        class="form-control" name="show_status"
                                                                        @if (isset($reports_settings['show_status']) && $reports_settings['show_status'] == false) @else
                                                                checked @endif
                                                                        value="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="test_title_color">{{ __('Unit') }}</label>
                                                                <div class="input-group">
                                                                    <input id="" type="checkbox"
                                                                        class="form-control" name="show_unit"
                                                                        @if (isset($reports_settings['show_unit']) && $reports_settings['show_unit'] == false) @else
                                                                checked @endif
                                                                        value="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label
                                                                    for="test_title_color">{{ __('Normal Range') }}</label>
                                                                <div class="input-group">
                                                                    <input id="" type="checkbox"
                                                                        class="form-control" name="show_range"
                                                                        @if (isset($reports_settings['show_range']) && $reports_settings['show_range'] == false) @else
                                                                checked @endif
                                                                        value="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label
                                                                    for="test_title_color">{{ __('Single Page') }}</label>
                                                                <div class="input-group">
                                                                    <input id="" type="checkbox"
                                                                        class="form-control" name="new_line"
                                                                        @if (isset($reports_settings['new_line']) && $reports_settings['new_line'] == true) checked @endif
                                                                        value="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="test_title_color">{{ __('HighLite') }}</label>
                                                                <div class="input-group">
                                                                    <input id="" type="checkbox"
                                                                        class="form-control" name="highlite"
                                                                        @if (isset($reports_settings['highlite']) && $reports_settings['highlite'] == true) checked @endif
                                                                        value="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 style="font-weight: 600">{{ __('Report With Header') }}</h4>
                                        </br>
                                        <div class="row">

                                            <div class="col-lg-2">
                                                <label for="header-margin-top"><i class="fa fa-arrow-up"></i>
                                                    {{ __('Margin top') }}</label>
                                                <input type="number" min="0" id="header-margin-top"
                                                    name="header-margin-top"class="form-control"
                                                    @if (isset($reports_settings['header-margin-top'])) value="{{ $reports_settings['header-margin-top'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="header-margin-right"><i class="fa fa-arrow-right"></i>
                                                    {{ __('Margin right') }}</label>
                                                <input type="number" min="0" id="header-margin-right"
                                                    name="header-margin-right" class="form-control"
                                                    @if (isset($reports_settings['header-margin-right'])) value="{{ $reports_settings['header-margin-right'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="header-margin-bottom"><i class="fa fa-arrow-down"></i>
                                                    {{ __('Margin bottom') }}</label>
                                                <input type="number" min="0" name="header-margin-bottom"
                                                    id="header-margin-bottom" class="form-control"
                                                    @if (isset($reports_settings['header-margin-bottom'])) value="{{ $reports_settings['header-margin-bottom'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="header-margin-left"><i class="fa fa-arrow-left"></i>
                                                    {{ __('Margin left') }}</label>
                                                <input type="number" min="0" id="header-margin-left"
                                                    name="header-margin-left" class="form-control"
                                                    @if (isset($reports_settings['header-margin-left'])) value="{{ $reports_settings['header-margin-left'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="content-header-margin-top"><i class="fa fa-arrow-up"></i>
                                                    {{ __('Content margin top') }}</label>
                                                <input type="number" min="0" id="content-header-margin-top"
                                                    name="content-header-margin-top" class="form-control"
                                                    @if (isset($reports_settings['content-header-margin-top'])) value="{{ $reports_settings['content-header-margin-top'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="content-header-margin-bottom"><i class="fa fa-arrow-down"></i>
                                                    {{ __('Content margin bottom') }}</label>
                                                <input type="number" min="0" id="content-header-margin-bottom"
                                                    name="content-header-margin-bottom" class="form-control"
                                                    @if (isset($reports_settings['content-header-margin-bottom'])) value="{{ $reports_settings['content-header-margin-bottom'] }}" @endif
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="show_sign_with_header"
                                                        id="show_sign_with_header"
                                                        @if (isset($reports_settings['show_sign_with_header']) && $reports_settings['show_sign_with_header']) checked @endif>
                                                    <label for="show_sign_with_header"><i class="fas fa-signature"></i>
                                                        {{ __('Show sign') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="">{{ __('Sgin option') }}</label>
                                                <select class="form-control" name="sign_with_header" required>

                                                    <option value="1"
                                                        @if (isset($reports_settings['sign_with_header']) && $reports_settings['sign_with_header'] == '1') selected @endif>
                                                        {{ __('Design') }} 1</option>
                                                    <option value="2"
                                                        @if (isset($reports_settings['sign_with_header']) && $reports_settings['sign_with_header'] == '2') selected @endif>
                                                        {{ __('Design') }} 2</option>
                                                    <option value="3"
                                                        @if (isset($reports_settings['sign_with_header']) && $reports_settings['sign_with_header'] == '3') selected @endif>
                                                        {{ __('Design') }} 3</option>
                                                    <option value="4"
                                                        @if (isset($reports_settings['sign_with_header']) && $reports_settings['sign_with_header'] == '4') selected @endif>
                                                        {{ __('Design') }} 4</option>
                                                </select>
                                            </div>
                                        </div>
                                        <h4 style="font-weight: 600">{{ __('Report Without Header') }}</h4>
                                        </br>
                                        <div class="row">

                                            <div class="col-lg-2">
                                                <label for="margin-top"><i class="fa fa-arrow-up"></i>
                                                    {{ __('Margin top') }}</label>
                                                <input type="number" min="0" id="margin-top"
                                                    name="margin-top"class="form-control"
                                                    @if (isset($reports_settings['margin-top'])) value="{{ $reports_settings['margin-top'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="margin-right"><i class="fa fa-arrow-right"></i>
                                                    {{ __('Margin right') }}</label>
                                                <input type="number" min="0" id="margin-right"
                                                    name="margin-right" class="form-control"
                                                    @if (isset($reports_settings['margin-right'])) value="{{ $reports_settings['margin-right'] }}" @endif
                                                    value="{{ $reports_settings['margin-right'] }}" required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="margin-bottom"><i class="fa fa-arrow-down"></i>
                                                    {{ __('Margin bottom') }}</label>
                                                <input type="number" min="0" name="margin-bottom"
                                                    id="margin-bottom" class="form-control"
                                                    @if (isset($reports_settings['margin-bottom'])) value="{{ $reports_settings['margin-bottom'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="margin-left"><i class="fa fa-arrow-left"></i>
                                                    {{ __('Margin left') }}</label>
                                                <input type="number" min="0" id="margin-left" name="margin-left"
                                                    class="form-control"
                                                    @if (isset($reports_settings['margin-left'])) value="{{ $reports_settings['margin-left'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="content-margin-top"><i class="fa fa-arrow-up"></i>
                                                    {{ __('Content margin top') }}</label>
                                                <input type="number" min="0" id="content-margin-top"
                                                    name="content-margin-top" class="form-control"
                                                    @if (isset($reports_settings['content-margin-top'])) value="{{ $reports_settings['content-margin-top'] }}" @endif
                                                    required>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="content-margin-bottom"><i class="fa fa-arrow-down"></i>
                                                    {{ __('Content margin bottom') }}</label>
                                                <input type="number" min="0" id="content-margin-bottom"
                                                    name="content-margin-bottom" class="form-control"
                                                    @if (isset($reports_settings['content-margin-bottom'])) value="{{ $reports_settings['content-margin-bottom'] }}" @endif
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="show_sign_without_header"
                                                        id="show_sign_without_header"
                                                        @if (isset($reports_settings['show_sign_without_header']) && $reports_settings['show_sign_without_header']) checked @endif>
                                                    <label for="show_sign_without_header"><i class="fas fa-signature"></i>
                                                        {{ __('Show sign') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="">{{ __('Sgin option') }}</label>
                                                <select class="form-control" name="sign_without_header" required>

                                                    <option value="1"
                                                        @if (isset($reports_settings['sign_without_header']) && $reports_settings['sign_without_header'] == '1') selected @endif>
                                                        {{ __('Design') }} 1</option>
                                                    <option value="2"
                                                        @if (isset($reports_settings['sign_without_header']) && $reports_settings['sign_without_header'] == '2') selected @endif>
                                                        {{ __('Design') }} 2</option>
                                                    <option value="3"
                                                        @if (isset($reports_settings['sign_without_header']) && $reports_settings['sign_without_header'] == '3') selected @endif>
                                                        {{ __('Design') }} 3</option>
                                                    <option value="4"
                                                        @if (isset($reports_settings['sign_without_header']) && $reports_settings['sign_without_header'] == '4') selected @endif>
                                                        {{ __('Design') }} 4</option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-lg-12 mt-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            <label for="report_header">{{ __('Header') }}</label>
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">

                                                            <div class="col-lg-12">

                                                                <div class="row">

                                                                    <div class="col-lg-3">
                                                                        <label
                                                                            for="report_header_text_align">{{ __('Align') }}</label>
                                                                        <select class="form-control"
                                                                            name="report_header[text-align]"
                                                                            id="report_header_text_align" required>
                                                                            <option value="center"
                                                                                @if (isset($reports_settings['report_header']['text-align']) &&
                                                                                        $reports_settings['report_header']['text-align'] == 'center') selected @endif>
                                                                                {{ __('Center') }}</option>
                                                                            <option value="left"
                                                                                @if (isset($reports_settings['report_header']['text-align']) &&
                                                                                        $reports_settings['report_header']['text-align'] == 'left') selected @endif>
                                                                                {{ __('Left') }}</option>
                                                                            <option value="right"
                                                                                @if (isset($reports_settings['report_header']['text-align']) &&
                                                                                        $reports_settings['report_header']['text-align'] == 'right') selected @endif>
                                                                                {{ __('Right') }}</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="report_header_border_color">{{ __('Border color') }}</label>
                                                                            <div class="input-group">
                                                                                <input id="report_header_border_color"
                                                                                    type="text"
                                                                                    class="form-control color_input"
                                                                                    name="report_header[border-color]"
                                                                                    @if (isset($reports_settings['report_header']['border-color'])) value="{{ $reports_settings['report_header']['border-color'] }}" @endif
                                                                                    required>
                                                                                <div class="input-group-append color_tool">
                                                                                    <span class="input-group-text"><i
                                                                                            class="fas fa-square"
                                                                                            @if (isset($reports_settings['report_header']['border-color'])) style="color: {{ $reports_settings['report_header']['border-color'] }}" @endif></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <label
                                                                            for="report_header_border_width">{{ __('Border width') }}</label>
                                                                        <input type="number" class="form-control"
                                                                            name="report_header[border-width]"
                                                                            id="report_header_border_width" min="1"
                                                                            @if (isset($reports_settings['report_header']['border-width'])) value="{{ $reports_settings['report_header']['border-width'] }}" @endif
                                                                            required>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="report_header_background_color">{{ __('Background color') }}</label>
                                                                            <div class="input-group">
                                                                                <input id="report_header_background_color"
                                                                                    type="text"
                                                                                    class="form-control color_input"
                                                                                    name="report_header[background-color]"
                                                                                    @if (isset($reports_settings['report_header']['background-color'])) value="{{ $reports_settings['report_header']['background-color'] }}" @endif
                                                                                    required>
                                                                                <div class="input-group-append color_tool">
                                                                                    @if (isset($reports_settings['report_header']['background-color']))
                                                                                        <span class="input-group-text"><i
                                                                                                class="fas fa-square"
                                                                                                style="color: {{ $reports_settings['report_header']['background-color'] }}"></i></span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Branch name') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="branch_name_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="branch_name_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="branch_name[color]"
                                                                            @if (isset($reports_settings['branch_name']['color'])) value="{{ $reports_settings['branch_name']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            <span class="input-group-text"><i
                                                                                    class="fas fa-square"
                                                                                    @if (isset($reports_settings['branch_name']['color'])) style="color: {{ $reports_settings['branch_name']['color'] }}" @endif></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="branch_name_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="branch_name[font-family]"
                                                                    id="branch_name_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="branch_name_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="branch_name[font-size]"
                                                                    id="branch_name_font_size" min="1"
                                                                    @if (isset($reports_settings['branch_name']['font-size'])) value="{{ $reports_settings['branch_name']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Branch info') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="branch_info_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="branch_info_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="branch_info[color]"
                                                                            @if (isset($reports_settings['branch_info']['color'])) value="{{ $reports_settings['branch_info']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['branch_info']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['branch_info']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="branch_info_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="branch_info[font-family]"
                                                                    id="branch_info_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="branch_info_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="branch_info[font-size]"
                                                                    id="branch_info_font_size" min="1"
                                                                    @if (isset($reports_settings['branch_info']['font-size'])) value="{{ $reports_settings['branch_info']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Patient title') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="patient_title_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="patient_title_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="patient_title[color]"
                                                                            @if (isset($reports_settings['patient_title']['color'])) value="{{ $reports_settings['patient_title']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['patient_title']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['patient_title']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="patient_title_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="patient_title[font-family]"
                                                                    id="patient_title_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="patient_title_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="patient_title[font-size]"
                                                                    id="patient_title_font_size" min="1"
                                                                    @if (isset($reports_settings['patient_title']['font-size'])) value="{{ $reports_settings['patient_title']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Patient data') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="patient_data_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="patient_data_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="patient_data[color]"@if (isset($reports_settings['patient_data']['color'])) value="{{ $reports_settings['patient_data']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['patient_data']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['patient_data']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="patient_data_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="patient_data[font-family]"
                                                                    id="patient_data_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="patient_data_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="patient_data[font-size]"
                                                                    id="patient_data_font_size" min="1"
                                                                    @if (isset($reports_settings['patient_data']['font-size'])) value="{{ $reports_settings['patient_data']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Test title') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="test_title_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="test_title_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="test_title[color]"
                                                                            @if (isset($reports_settings['test_title']['color'])) value="{{ $reports_settings['test_title']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['test_title']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['test_title']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label
                                                                    for="test_title_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="test_title[font-family]"
                                                                    id="test_title_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="test_title_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="test_title[font-size]" id="test_title_font_size"
                                                                    min="1"
                                                                    @if (isset($reports_settings['test_title']['font-size'])) value="{{ $reports_settings['test_title']['font-size'] }}" @endif
                                                                    required>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="">{{ __('Height') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="test_title[height]" id=""
                                                                    min="1"
                                                                    value="{{ isset($reports_settings['test_title']['height']) ? $reports_settings['test_title']['height'] : '' }}"
                                                                    required>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="report_header_text_align">{{ __('Align') }}</label>
                                                                <select class="form-control" name="test_title[text-align]"
                                                                    required>

                                                                    <option value="center"
                                                                        @if (isset($reports_settings['test_title']['text-align']) && $reports_settings['test_title']['text-align'] == 'center') selected @endif>
                                                                        {{ __('Center') }}</option>
                                                                    <option value="left"
                                                                        @if (isset($reports_settings['test_title']['text-align']) && $reports_settings['test_title']['text-align'] == 'left') selected @endif>
                                                                        {{ __('Left') }}</option>
                                                                    <option value="right"
                                                                        @if (isset($reports_settings['test_title']['text-align']) && $reports_settings['test_title']['text-align'] == 'right') selected @endif>
                                                                        {{ __('Right') }}</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Test name') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="test_name_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="test_name_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="test_name[color]"
                                                                            @if (isset($reports_settings['test_name']['color'])) value="{{ $reports_settings['test_name']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['test_name']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['test_name']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label
                                                                    for="test_name_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control" name="test_name[font-family]"
                                                                    id="test_name_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="test_name_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="test_name[font-size]" id="test_name_font_size"
                                                                    min="1"
                                                                    @if (isset($reports_settings['test_name']['font-size'])) value="{{ $reports_settings['test_name']['font-size'] }}" @endif
                                                                    required>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="test_name_font_size">{{ __('Height') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="test_name[height]" id=""
                                                                    min="1"
                                                                    @if (isset($reports_settings['test_name']['height'])) value="{{ $reports_settings['test_name']['height'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="report_header_text_align">{{ __('Align') }}</label>
                                                                <select class="form-control" name="test_name[text-align]"
                                                                    required>

                                                                    <option value="center"
                                                                        @if (isset($reports_settings['test_name']['text-align']) && $reports_settings['test_name']['text-align'] == 'center') selected @endif>
                                                                        {{ __('Center') }}</option>
                                                                    <option value="left"
                                                                        @if (isset($reports_settings['test_name']['text-align']) && $reports_settings['test_name']['text-align'] == 'left') selected @endif>
                                                                        {{ __('Left') }}</option>
                                                                    <option value="right"
                                                                        @if (isset($reports_settings['test_name']['text-align']) && $reports_settings['test_name']['text-align'] == 'right') selected @endif>
                                                                        {{ __('Right') }}</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Test head') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="test_head_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="test_head_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="test_head[color]"
                                                                            @if (isset($reports_settings['test_head']['color'])) value="{{ $reports_settings['test_head']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['test_head']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['test_head']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label
                                                                    for="test_head_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control" name="test_head[font-family]"
                                                                    id="test_head_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="test_head_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="test_head[font-size]" id="test_head_font_size"
                                                                    min="1"
                                                                    @if (isset($reports_settings['test_head']['font-size'])) value="{{ $reports_settings['test_head']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="test_name_font_size">{{ __('Height') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="test_head[height]" id=""
                                                                    min="1"
                                                                    @if (isset($reports_settings['test_head']['height'])) value="{{ $reports_settings['test_head']['height'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="report_header_text_align">{{ __('Align') }}</label>
                                                                <select class="form-control" name="test_head[text-align]"
                                                                    required>
                                                                    <option value="center"
                                                                        @if (isset($reports_settings['test_head']['text-align']) && $reports_settings['test_head']['text-align'] == 'center') selected @endif>
                                                                        {{ __('Center') }}</option>
                                                                    <option value="left"
                                                                        @if (isset($reports_settings['test_head']['text-align']) && $reports_settings['test_head']['text-align'] == 'left') selected @endif>
                                                                        {{ __('Left') }}</option>
                                                                    <option value="right"
                                                                        @if (isset($reports_settings['test_head']['text-align']) && $reports_settings['test_head']['text-align'] == 'right') selected @endif>
                                                                        {{ __('Right') }}</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Result') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="result_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="result_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="result[color]"
                                                                            @if (isset($reports_settings['result']['color'])) value="{{ $reports_settings['result']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['result']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['result']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label
                                                                    for="result_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control" name="result[font-family]"
                                                                    id="result_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="result_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="result[font-size]" id="result_font_size"
                                                                    min="1"
                                                                    @if (isset($reports_settings['result']['font-size'])) value="{{ $reports_settings['result']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="test_name_font_size">{{ __('Height') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="result[height]" id="" min="1"
                                                                    @if (isset($reports_settings['result']['height'])) value="{{ $reports_settings['result']['height'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="report_header_text_align">{{ __('Align') }}</label>
                                                                <select class="form-control" name="result[text-align]"
                                                                    required>
                                                                    <option value="center"
                                                                        @if (isset($reports_settings['result']['text-align']) && $reports_settings['result']['text-align'] == 'center') selected @endif>
                                                                        {{ __('Center') }}</option>
                                                                    <option value="left"
                                                                        @if (isset($reports_settings['result']['text-align']) && $reports_settings['result']['text-align'] == 'left') selected @endif>
                                                                        {{ __('Left') }}</option>
                                                                    <option value="right"
                                                                        @if (isset($reports_settings['result']['text-align']) && $reports_settings['result']['text-align'] == 'right') selected @endif>
                                                                        {{ __('Right') }}</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Test unit') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="unit_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="unit_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="unit[color]"
                                                                            @if (isset($reports_settings['unit']['color'])) value="{{ $reports_settings['unit']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['unit']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['unit']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label
                                                                    for="unit_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control" name="unit[font-family]"
                                                                    id="unit_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="unit_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="unit[font-size]" id="unit_font_size"
                                                                    min="1"
                                                                    @if (isset($reports_settings['unit']['font-size'])) value="{{ $reports_settings['unit']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="test_name_font_size">{{ __('Height') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="unit[height]" id="" min="1"
                                                                    @if (isset($reports_settings['unit']['height'])) value="{{ $reports_settings['unit']['height'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="report_header_text_align">{{ __('Align') }}</label>
                                                                <select class="form-control" name="unit[text-align]"
                                                                    required>
                                                                    <option value="center"
                                                                        @if (isset($reports_settings['unit']['text-align']) && $reports_settings['unit']['text-align'] == 'center') selected @endif>
                                                                        {{ __('Center') }}</option>
                                                                    <option value="left"
                                                                        @if (isset($reports_settings['unit']['text-align']) && $reports_settings['unit']['text-align'] == 'left') selected @endif>
                                                                        {{ __('Left') }}</option>
                                                                    <option value="right"
                                                                        @if (isset($reports_settings['unit']['text-align']) && $reports_settings['unit']['text-align'] == 'right') selected @endif>
                                                                        {{ __('Right') }}</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Test reference range') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="reference_range_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="reference_range_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="reference_range[color]"
                                                                            @if (isset($reports_settings['reference_range']['color'])) value="{{ $reports_settings['reference_range']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            <span class="input-group-text"><i
                                                                                    class="fas fa-square"
                                                                                    style="color: {{ $reports_settings['reference_range']['color'] }}"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label
                                                                    for="reference_range_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="reference_range[font-family]"
                                                                    id="reference_range_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="reference_range_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="reference_range[font-size]"
                                                                    id="reference_range_font_size" min="1"
                                                                    @if (isset($reports_settings['reference_range']['font-size'])) value="{{ $reports_settings['reference_range']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label for="">{{ __('Height') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="reference_range[height]" id=""
                                                                    min="1"
                                                                    @if (isset($reports_settings['reference_range']['height'])) value="{{ $reports_settings['reference_range']['height'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="report_header_text_align">{{ __('Align') }}</label>
                                                                <select class="form-control"
                                                                    name="reference_range[text-align]" required>
                                                                    <option value="center"
                                                                        @if (isset($reports_settings['reference_range']['text-align']) &&
                                                                                $reports_settings['reference_range']['text-align'] == 'center') selected @endif>
                                                                        {{ __('Center') }}</option>
                                                                    <option value="left"
                                                                        @if (isset($reports_settings['reference_range']['text-align']) &&
                                                                                $reports_settings['reference_range']['text-align'] == 'left') selected @endif>
                                                                        {{ __('Left') }}</option>
                                                                    <option value="right"
                                                                        @if (isset($reports_settings['reference_range']['text-align']) &&
                                                                                $reports_settings['reference_range']['text-align'] == 'right') selected @endif>
                                                                        {{ __('Right') }}</option>
                                                                </select>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Test status') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="status_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="status_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="status[color]"
                                                                            @if (isset($reports_settings['status']['color'])) value="{{ $reports_settings['status']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['status']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['status']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label
                                                                    for="status_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control" name="status[font-family]"
                                                                    id="status_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="status_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="status[font-size]" id="status_font_size"
                                                                    min="1"
                                                                    @if (isset($reports_settings['status']['font-size'])) value="{{ $reports_settings['status']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label for="">{{ __('Height') }}</label>

                                                                <input type="number" class="form-control"
                                                                    name="status[height]" id=""
                                                                    min="1"
                                                                    @if (isset($reports_settings['status']['height'])) value="{{ $reports_settings['status']['height'] }}" @endif
                                                                    required>

                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="report_header_text_align">{{ __('Align') }}</label>
                                                                <select class="form-control" name="status[text-align]"
                                                                    required>
                                                                    <option value="center"
                                                                        @if (isset($reports_settings['status']['text-align']) && $reports_settings['status']['text-align'] == 'center') selected @endif>
                                                                        {{ __('Center') }}</option>
                                                                    <option value="left"
                                                                        @if (isset($reports_settings['status']['text-align']) && $reports_settings['status']['text-align'] == 'left') selected @endif>
                                                                        {{ __('Left') }}</option>
                                                                    <option value="right"
                                                                        @if (isset($reports_settings['status']['text-align']) && $reports_settings['status']['text-align'] == 'right') selected @endif>
                                                                        {{ __('Right') }}</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Test comment') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="comment_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="comment_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="comment[color]"
                                                                            @if (isset($reports_settings['comment']['color'])) value="{{ $reports_settings['comment']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['comment']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['comment']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label
                                                                    for="comment_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control" name="comment[font-family]"
                                                                    id="comment_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="comment_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="comment[font-size]" id="comment_font_size"
                                                                    min="1"
                                                                    @if (isset($reports_settings['comment']['font-size'])) value="{{ $reports_settings['comment']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label for="">{{ __('Height') }}</label>

                                                                <input type="number" class="form-control"
                                                                    name="comment[height]" id=""
                                                                    min="1"
                                                                    @if (isset($reports_settings['comment']['height'])) value="{{ $reports_settings['comment']['height'] }}" @endif
                                                                    required>

                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label
                                                                    for="report_header_text_align">{{ __('Align') }}</label>
                                                                <select class="form-control" name="comment[text-align]"
                                                                    required>
                                                                    <option value="center"
                                                                        @if (isset($reports_settings['comment']['text-align']) && $reports_settings['comment']['text-align'] == 'center') selected @endif>
                                                                        {{ __('Center') }}</option>
                                                                    <option value="left"
                                                                        @if (isset($reports_settings['comment']['text-align']) && $reports_settings['comment']['text-align'] == 'left') selected @endif>
                                                                        {{ __('Left') }}</option>
                                                                    <option value="right"
                                                                        @if (isset($reports_settings['comment']['text-align']) && $reports_settings['comment']['text-align'] == 'right') selected @endif>
                                                                        {{ __('Right') }}</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Report signature') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="signature_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="signature_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="signature[color]"
                                                                            @if (isset($reports_settings['signature']['color'])) value="{{ $reports_settings['signature']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['signature']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['signature']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="signature_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="signature[font-family]"
                                                                    id="signature_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="signature_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="signature[font-size]" id="signature_font_size"
                                                                    min="1"
                                                                    @if (isset($reports_settings['signature']['font-size'])) value="{{ $reports_settings['signature']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Antibiotic name') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="antibiotic_name_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="antibiotic_name_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="antibiotic_name[color]"
                                                                            @if (isset($reports_settings['antibiotic_name']['color'])) value="{{ $reports_settings['antibiotic_name']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['antibiotic_name']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['antibiotic_name']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="antibiotic_name_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="antibiotic_name[font-family]"
                                                                    id="antibiotic_name_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="antibiotic_name_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="antibiotic_name[font-size]"
                                                                    id="antibiotic_name_font_size" min="1"
                                                                    @if (isset($reports_settings['antibiotic_name']['font-size'])) value="{{ $reports_settings['antibiotic_name']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Antibiotic sensitivity') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="sensitivity_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="sensitivity_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="sensitivity[color]"
                                                                            @if (isset($reports_settings['sensitivity']['color'])) value="{{ $reports_settings['sensitivity']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['sensitivity']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['sensitivity']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="sensitivity_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="sensitivity[font-family]"
                                                                    id="sensitivity_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="sensitivity_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="sensitivity[font-size]"
                                                                    id="sensitivity_font_size" min="1"
                                                                    @if (isset($reports_settings['sensitivity']['font-size'])) value="{{ $reports_settings['sensitivity']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Antibiotic commercial name') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="commercial_name_color">{{ __('Color') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="commercial_name_color" type="color"
                                                                            class="form-control color_input"
                                                                            name="commercial_name[color]"
                                                                            @if (isset($reports_settings['commercial_name']['color'])) value="{{ $reports_settings['commercial_name']['color'] }}" @endif
                                                                            required>
                                                                        <div class="input-group-append color_tool">
                                                                            @if (isset($reports_settings['commercial_name']['color']))
                                                                                <span class="input-group-text"><i
                                                                                        class="fas fa-square"
                                                                                        style="color: {{ $reports_settings['commercial_name']['color'] }}"></i></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="commercial_name_font_family">{{ __('Font type') }}</label>
                                                                <select class="form-control"
                                                                    name="commercial_name[font-family]"
                                                                    id="commercial_name_font_family" required>
                                                                    @include('admin.settings.fonts')
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label
                                                                    for="commercial_name_font_size">{{ __('Font size') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="commercial_name[font-size]"
                                                                    id="commercial_name_font_size" min="1"
                                                                    @if (isset($reports_settings['commercial_name']['font-size'])) value="{{ $reports_settings['commercial_name']['font-size'] }}" @endif
                                                                    required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 mt-3">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            <label for="report_footer">{{ __('Footer') }}</label>
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">

                                                            <div class="col-lg-12">

                                                                <div class="row">

                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="report_footer_color">{{ __('Color') }}</label>
                                                                            <div class="input-group">
                                                                                <input id="report_footer_color"
                                                                                    type="color"
                                                                                    class="form-control color_input"
                                                                                    name="report_footer[color]"
                                                                                    value="{{ $reports_settings['report_footer']['color'] }}"
                                                                                    required>
                                                                                <div
                                                                                    class="input-group-append color_tool">
                                                                                    <span class="input-group-text"><i
                                                                                            class="fas fa-square"
                                                                                            style="color: {{ $reports_settings['report_footer']['color'] }}"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <label
                                                                            for="report_footer_font_family">{{ __('Font type') }}</label>
                                                                        <select class="form-control"
                                                                            name="report_footer[font-family]"
                                                                            id="report_footer_font_family" required>
                                                                            @include('admin.settings.fonts')
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <label
                                                                            for="report_footer_font_size">{{ __('Font size') }}</label>
                                                                        <input type="number" class="form-control"
                                                                            name="report_footer[font-size]"
                                                                            id="report_footer_font_size" min="1"
                                                                            value="{{ $reports_settings['report_footer']['font-size'] }}"
                                                                            required>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <label
                                                                            for="report_footer_text_align">{{ __('Align') }}</label>
                                                                        <select class="form-control"
                                                                            name="report_footer[text-align]"
                                                                            id="report_footer_text_align" required>
                                                                            <option value="center"
                                                                                @if ($reports_settings['report_footer']['text-align'] == 'center') selected @endif>
                                                                                {{ __('Center') }}</option>
                                                                            <option value="left"
                                                                                @if ($reports_settings['report_footer']['text-align'] == 'left') selected @endif>
                                                                                {{ __('Left') }}</option>
                                                                            <option value="right"
                                                                                @if ($reports_settings['report_footer']['text-align'] == 'right') selected @endif>
                                                                                {{ __('Right') }}</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="report_footer_border_color">{{ __('Border color') }}</label>
                                                                            <div class="input-group">
                                                                                <input id="report_footer_border_color"
                                                                                    type="text"
                                                                                    class="form-control color_input"
                                                                                    name="report_footer[border-color]"
                                                                                    value="{{ $reports_settings['report_footer']['border-color'] }}"
                                                                                    required>
                                                                                <div
                                                                                    class="input-group-append color_tool">
                                                                                    <span class="input-group-text"><i
                                                                                            class="fas fa-square"
                                                                                            style="color: {{ $reports_settings['report_footer']['border-color'] }}"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <label
                                                                            for="report_footer_border_width">{{ __('Border width') }}</label>
                                                                        <input type="number" class="form-control"
                                                                            name="report_footer[border-width]"
                                                                            id="report_footer_border_width"
                                                                            min="1"
                                                                            value="{{ $reports_settings['report_footer']['border-width'] }}"
                                                                            required>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="report_footer_background_color">{{ __('Background color') }}</label>
                                                                            <div class="input-group">
                                                                                <input id="report_footer_background_color"
                                                                                    type="text"
                                                                                    class="form-control color_input"
                                                                                    name="report_footer[background-color]"
                                                                                    value="{{ $reports_settings['report_footer']['background-color'] }}"
                                                                                    required>
                                                                                <div
                                                                                    class="input-group-append color_tool">
                                                                                    <span class="input-group-text"><i
                                                                                            class="fas fa-square"
                                                                                            style="color: {{ $reports_settings['report_footer']['background-color'] }}"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            {{ __('Show Patiens Data') }}
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12">
                                                                <div class="card card-primary card-tabs">

                                                                    <div class="card-body">
                                                                        <div class="tab-content"
                                                                            id="custom-tabs-one-tabContent">
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <input type="checkbox"
                                                                                        name="show_branch"
                                                                                        id="show_branch"
                                                                                        @if (isset($reports_settings['show_branch']) && $reports_settings['show_branch']) checked @endif>
                                                                                    <label for="show_branch"><i
                                                                                            class="fas fa-qrcode"></i>
                                                                                        {{ __('Show Branch') }}</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <input type="checkbox"
                                                                                        name="show_d_collection"
                                                                                        id="show_d_collection"
                                                                                        @if (isset($reports_settings['show_d_collection']) && $reports_settings['show_d_collection']) checked @endif>
                                                                                    <label for="show_d_collection"><i
                                                                                            class="fas fa-qrcode"></i>
                                                                                        {{ __('Show D.Collection') }}</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <input type="checkbox"
                                                                                        name="show_s_collection"
                                                                                        id="show_s_collection"
                                                                                        @if (isset($reports_settings['show_s_collection']) && $reports_settings['show_s_collection']) checked @endif>
                                                                                    <label for="show_s_collection"><i
                                                                                            class="fas fa-qrcode"></i>
                                                                                        {{ __('Show S.Collection') }}</label>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!-- /.card -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            {{ __('Branches report') }}
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12">
                                                                <div class="card card-primary card-tabs">
                                                                    <div class="card-header p-0 pt-1">
                                                                        <ul class="nav nav-tabs"
                                                                            id="custom-tabs-one-tab" role="tablist">
                                                                            @foreach ($report_branches as $branch)
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link @if ($report_branches[0]['id'] == $branch['id']) active @endif"
                                                                                        id="custom-tabs-one-home-tab"
                                                                                        data-toggle="pill"
                                                                                        href="#report_branch_{{ $branch['id'] }}"
                                                                                        role="tab"
                                                                                        aria-controls="custom-tabs-one-home"
                                                                                        aria-selected="false">{{ $branch['name'] }}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="tab-content"
                                                                            id="custom-tabs-one-tabContent">
                                                                            @foreach ($report_branches as $branch)
                                                                                <div class="tab-pane fade @if ($report_branches[0]['id'] == $branch['id']) active show @endif"
                                                                                    id="report_branch_{{ $branch['id'] }}"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="report_branch_{{ $branch['id'] }}-tab">
                                                                                    <div class="row mt-3">
                                                                                        <div class="col-lg-4">
                                                                                            <div
                                                                                                class="card card-primary">
                                                                                                <div class="card-header">
                                                                                                    <h5
                                                                                                        class="card-title">
                                                                                                        {{ __('Header') }}
                                                                                                    </h5>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <div class="row">
                                                                                                        <div
                                                                                                            class="col-lg-12">
                                                                                                            <label
                                                                                                                for="show_header_image_{{ $branch['id'] }}">{{ __('Show') }}</label>
                                                                                                            <br>
                                                                                                            <label
                                                                                                                class="switch">
                                                                                                                <input
                                                                                                                    type="checkbox"
                                                                                                                    name="branches[{{ $branch['id'] }}][show_header_image]"
                                                                                                                    id="show_header_image_{{ $branch['id'] }}"
                                                                                                                    @if ($branch['show_header_image']) checked @endif>
                                                                                                                <span
                                                                                                                    class="slider round"></span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-12">
                                                                                                            <div
                                                                                                                class="form-group">
                                                                                                                <label
                                                                                                                    for="header_image_{{ $branch['id'] }}">{{ __('Upload report header') }}</label>
                                                                                                                <p>
                                                                                                                    Maximum:
                                                                                                                    [ 1000 X
                                                                                                                    300 ]
                                                                                                                    <br>
                                                                                                                    Extensions:
                                                                                                                    .jpg ,
                                                                                                                    .png
                                                                                                                </p>
                                                                                                                <div
                                                                                                                    class="input-group">
                                                                                                                    <div
                                                                                                                        class="custom-file">
                                                                                                                        <input
                                                                                                                            type="file"
                                                                                                                            name="branches[{{ $branch['id'] }}][header_image]"
                                                                                                                            class="custom-file-input"
                                                                                                                            id="header_image_{{ $branch['id'] }}">
                                                                                                                        <label
                                                                                                                            class="custom-file-label"
                                                                                                                            for="header_image_{{ $branch['id'] }}">{{ __('Select report header') }}</label>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="input-group-append">
                                                                                                                        <span
                                                                                                                            class="input-group-text"
                                                                                                                            id="">
                                                                                                                            <a href="{{ url('uploads/branches/' . $branch['header_image']) }}"
                                                                                                                                data-toggle="lightbox"
                                                                                                                                data-title="Report header">
                                                                                                                                <i
                                                                                                                                    class="fa fa-image"></i>
                                                                                                                            </a>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-4">
                                                                                            <div
                                                                                                class="card card-primary">
                                                                                                <div class="card-header">
                                                                                                    <h5
                                                                                                        class="card-title">
                                                                                                        {{ __('Watermark') }}
                                                                                                    </h5>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <div class="row">
                                                                                                        <div
                                                                                                            class="col-lg-12">
                                                                                                            <label
                                                                                                                for="show_watermark_image_{{ $branch['id'] }}">{{ __('Show') }}</label>
                                                                                                            <br>
                                                                                                            <label
                                                                                                                class="switch">
                                                                                                                <input
                                                                                                                    type="checkbox"
                                                                                                                    name="branches[{{ $branch['id'] }}][show_watermark_image]"
                                                                                                                    id="show_watermark_image_{{ $branch['id'] }}"
                                                                                                                    @if ($branch['show_watermark_image']) checked @endif>
                                                                                                                <span
                                                                                                                    class="slider round"></span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-12">
                                                                                                            <div
                                                                                                                class="form-group">
                                                                                                                <label
                                                                                                                    for="watermark_image_{{ $branch['id'] }}">{{ __('Upload watermark') }}</label>
                                                                                                                <p>
                                                                                                                    Maximum:
                                                                                                                    [ 1000 X
                                                                                                                    1000 ]
                                                                                                                    <br>
                                                                                                                    Extensions:
                                                                                                                    .jpg ,
                                                                                                                    .png
                                                                                                                </p>
                                                                                                                <div
                                                                                                                    class="input-group">
                                                                                                                    <div
                                                                                                                        class="custom-file">
                                                                                                                        <input
                                                                                                                            type="file"
                                                                                                                            name="branches[{{ $branch['id'] }}][watermark_image]"
                                                                                                                            class="custom-file-input"
                                                                                                                            id="watermark_image_{{ $branch['id'] }}">
                                                                                                                        <label
                                                                                                                            class="custom-file-label"
                                                                                                                            for="watermark_image">{{ __('Select waktermark') }}</label>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="input-group-append">
                                                                                                                        <span
                                                                                                                            class="input-group-text"
                                                                                                                            id="">
                                                                                                                            <a href="{{ url('uploads/branches/' . $branch['watermark_image']) }}"
                                                                                                                                data-toggle="lightbox"
                                                                                                                                data-title="Report waktermark">
                                                                                                                                <i
                                                                                                                                    class="fa fa-image"></i>
                                                                                                                            </a>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-4">
                                                                                            <div
                                                                                                class="card card-primary">
                                                                                                <div class="card-header">
                                                                                                    <h5
                                                                                                        class="card-title">
                                                                                                        {{ __('Footer') }}
                                                                                                    </h5>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <div class="row">
                                                                                                        <div
                                                                                                            class="col-lg-12">
                                                                                                            <label
                                                                                                                for="show_footer_image_{{ $branch['id'] }}">{{ __('Show') }}</label>
                                                                                                            <br>
                                                                                                            <label
                                                                                                                class="switch">
                                                                                                                <input
                                                                                                                    type="checkbox"
                                                                                                                    name="branches[{{ $branch['id'] }}][show_footer_image]"
                                                                                                                    id="show_footer_image_{{ $branch['id'] }}"
                                                                                                                    @if ($branch['show_footer_image']) checked @endif>
                                                                                                                <span
                                                                                                                    class="slider round"></span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-12">
                                                                                                            <div
                                                                                                                class="form-group">
                                                                                                                <label
                                                                                                                    for="footer_image_{{ $branch['id'] }}">{{ __('Upload report footer') }}</label>
                                                                                                                <p>
                                                                                                                    Maximum:
                                                                                                                    [ 1000 X
                                                                                                                    300 ]
                                                                                                                    <br>
                                                                                                                    Extensions:
                                                                                                                    .jpg ,
                                                                                                                    .png
                                                                                                                </p>
                                                                                                                <div
                                                                                                                    class="input-group">
                                                                                                                    <div
                                                                                                                        class="custom-file">
                                                                                                                        <input
                                                                                                                            type="file"
                                                                                                                            name="branches[{{ $branch['id'] }}][footer_image]"
                                                                                                                            class="custom-file-input"
                                                                                                                            id="footer_image_{{ $branch['id'] }}">
                                                                                                                        <label
                                                                                                                            class="custom-file-label"
                                                                                                                            for="footer_image">{{ __('Select report footer') }}</label>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="input-group-append">
                                                                                                                        <span
                                                                                                                            class="input-group-text"
                                                                                                                            id="">
                                                                                                                            <a href="{{ url('uploads/branches/' . $branch['footer_image']) }}"
                                                                                                                                data-toggle="lightbox"
                                                                                                                                data-title="Report footer">
                                                                                                                                <i
                                                                                                                                    class="fa fa-image"></i>
                                                                                                                            </a>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="report_footer_{{ $branch['id'] }}">{{ __('Footer') }}</label>
                                                                                                <textarea name="branches[{{ $branch['id'] }}][report_footer]" id="report_footer_{{ $branch['id'] }}"
                                                                                                    cols="30" rows="5" class="form-control">
@if (isset($branch))
{{ $branch['report_footer'] }}
@endif
</textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.card -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button class="btn btn-primary"> <i class="fa fa-check"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \Reports Settings -->


                        <!-- Reports settings -->
                        <div class="tab-pane text-left fade show" id="Invoices_settings" role="tabpanel"
                            aria-labelledby="Invoices_settings">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Invoices_settings') }}</h3>
                                </div>
                                <form action="{{ route('admin.settings.invoices_submit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <p id="test_text">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti magnam ratione

                                        </p>
                                        <div class="row">

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">
                                                        {{ __('direction') }}
                                                    </label>
                                                    <select onchange="liveTest('direction')" name="direction"
                                                        class="form-control">
                                                        <option selected>
                                                            {{ __('Select Direction') }}
                                                        </option>
                                                        <option value="rtl"
                                                            @if (isset($invoice_setting['direction']) && $invoice_setting['direction'] == 'rtl') selected @endif>
                                                            RTL (Arabic)
                                                        </option>

                                                        <option value="ltr"
                                                            @if (isset($invoice_setting['direction']) && $invoice_setting['direction'] == 'ltr') selected @endif>
                                                            LTR (English)
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">
                                                        {{ __('font Size') }}
                                                    </label>
                                                    <input onchange="liveTest('font-size')" type="number"
                                                        class="form-control" name="font_size"
                                                        @if (isset($invoice_setting['font_size'])) value="{{ $invoice_setting['font_size'] }}" @endif>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="test_name_font_family">{{ __('Font type') }}</label>
                                                <select onchange="liveTest('font-family')" class="form-control"
                                                    name="font-family" id="invoice-font-family">
                                                    @include('admin.settings.fonts')
                                                </select>
                                            </div>




                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button class="btn btn-primary"> <i class="fa fa-check"></i>
                                                {{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \Reports Settings -->


                        <!-- Barcode Settings -->
                        <div class="tab-pane text-left fade show" id="barcode_settings" role="tabpanel"
                            aria-labelledby="api_keys_settings">
                            <div class="card card-primary">

                                <form action="{{ route('admin.settings.barcode_submit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @foreach ($report_branches as $branch)
                                        <div class="card-header">
                                            <h5 class="card-title">{{ $branch->name }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="barcode_settings_type">{{ __('Type') }}</label>
                                                        <select name="type[{{ $branch->id }}]"
                                                            id="barcode_settings_type_{{ $branch->id }}"
                                                            class="form-control" required>
                                                            <option value="" disabled selected>
                                                                {{ __('Barcode type') }}</option>
                                                            <option value="C39">C39</option>
                                                            <option value="C39+">C39+</option>
                                                            <option value="C39E">C39E</option>
                                                            <option value="C39E+">C39E+</option>
                                                            <option value="C93">C93</option>
                                                            <option value="S25">S25</option>
                                                            <option value="S25+">S25+</option>
                                                            <option value="I25">I25</option>
                                                            <option value="I25+">I25+</option>
                                                            <option value="C128">C128</option>
                                                            <option value="C128A">C128A</option>
                                                            <option value="C128B">C128B</option>
                                                            <option value="C128C">C128C</option>
                                                            <option value="EAN2">EAN2</option>
                                                            <option value="EAN5">EAN5</option>
                                                            <option value="EAN8">EAN8</option>
                                                            <option value="EAN13">EAN13</option>
                                                            <option value="UPCA">UPCA</option>
                                                            <option value="UPCE">UPCE</option>
                                                            <option value="MSI">MSI</option>
                                                            <option value="MSI+">MSI+</option>
                                                            <option value="POSTNET">POSTNET</option>
                                                            <option value="PLANET">PLANET</option>
                                                            <option value="RMS4CC">RMS4CC</option>
                                                            <option value="KIX">KIX</option>
                                                            <option value="IMB">IMB</option>
                                                            <option value="CODABAR">CODABAR</option>
                                                            <option value="CODE11">CODE11</option>
                                                            <option value="PHARMA">PHARMA</option>
                                                            <option value="PHARMA2T">PHARMA2T</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="barcode_settings_width">{{ __('Barcode Width mm') }}</label>
                                                        <input type="number" name="width[{{ $branch->id }}]"
                                                            id="barcode_settings_width_{{ $branch->id }}"
                                                            class="form-control"
                                                            @if (isset($barcode_settings['width'][$branch->id])) value="{{ $barcode_settings['width'][$branch->id] }}" @endif
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="barcode_settings_height">{{ __('Barcode Height mm') }}</label>
                                                        <input type="number" name="height[{{ $branch->id }}]"
                                                            id="barcode_settings_height_{{ $branch->id }}"
                                                            class="form-control"
                                                            @if (isset($barcode_settings['height'][$branch->id])) value="{{ $barcode_settings['height'][$branch->id] }}" @endif
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="barcode_settings_fontSize">{{ __('Barcode Font Size mm') }}</label>
                                                        <input type="number" name="font_size[{{ $branch->id }}]"
                                                            id="barcode_settings_fontSize{{ $branch->id }}"
                                                            class="form-control"
                                                            @if (isset($barcode_settings['font_size'][$branch->id])) value="{{ $barcode_settings['font_size'][$branch->id] }}" @endif
                                                            required>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \Barcode Settings -->

                        <!-- medical Settings -->
                        <div class="tab-pane text-left fade show" id="medical_settings" role="tabpanel"
                            aria-labelledby="medical_settings">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('Tests') }}</h5>
                                </div>
                                <form action="{{ route('admin.settings.medical_submit') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label
                                                        for="barcode_settings_type">{{ __('Report Notice') }}</label></br>
                                                    {{ __('Print Notice if the resualt is differnent than latest report') }}
                                                    <input type="number" name="report_notice" id="report_notice"
                                                        class="form-control"
                                                        value="{{ $medical_settings['report_notice'] }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="pt_control_time">{{ __('PT Control Time') }}</label>
                                                    <input type="number" name="pt_control_time" id="pt_control_time"
                                                        class="form-control"
                                                        value="{{ $medical_settings['pt_control_time'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="isi">{{ __('ISI') }}</label>
                                                    <input type="number" name="isi" id="isi"
                                                        class="form-control" value="{{ $medical_settings['isi'] }}"
                                                        required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="checkbox" name="histogram_status"
                                                        id="histogram_status"
                                                        @if (isset($medical_settings['histogram_status']) && $medical_settings['histogram_status']) checked @endif>
                                                    <label for="histogram_status"><i class="fas fa-qrcode"></i>
                                                        {{ __('Show Histogram') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-check">
                                            <p>{{ __('HistoGram') }}</p>
                                            <input class="form-check-input" type="radio" id="Program"
                                                name="histogram_conection" value="program"
                                                @if (isset($medical_settings['histogram_conection']) && $medical_settings['histogram_conection'] == 'program') checked @endif>
                                            <label class="form-check-label"
                                                for="Program">{{ __('From Stop4labs System') }}</label><br>
                                            <input class="form-check-input" type="radio" id="device"
                                                name="histogram_conection" value="device"
                                                @if (isset($medical_settings['histogram_conection']) && $medical_settings['histogram_conection'] == 'device') checked @endif>
                                            <label class="form-check-label"
                                                for="device">{{ __('From Device') }}</label><br>
                                        </div>



                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group d-flex ">
                                                    <input type="checkbox" name="sameRefRang" id="sameRefRang"
                                                        @if (isset($medical_settings['sameRefRang']) && $medical_settings['sameRefRang']) checked @endif>
                                                    <label for="sameRefRang" class="mx-3">
                                                        {{ __('The Same Refrence Range in All Branch') }}</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group d-flex ">
                                                    <input type="checkbox" name="samePrice" id="samePrice"
                                                        @if (isset($medical_settings['samePrice']) && $medical_settings['samePrice']) checked @endif>
                                                    <label for="samePrice" class="mx-3">
                                                        {{ __('The Same Price In All Branches') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group d-flex ">
                                                    <input type="checkbox" name="low_culture" id="low_culture"
                                                        @if (isset($medical_settings['low_culture']) && $medical_settings['low_culture']) checked @endif>
                                                    <label for="low_culture" class="mx-3">
                                                        {{ __('LOW in Culture') }}</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group d-flex ">
                                                    <input type="checkbox" name="resistant_culture"
                                                        id="resistant_culture"
                                                        @if (isset($medical_settings['resistant_culture']) && $medical_settings['resistant_culture']) checked @endif>
                                                    <label for="resistant_culture" class="mx-3">
                                                        {{ __('Resistant in Culture') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="semen_layout">
                                                        {{ __('Semen Layout') }}</label>

                                                    <select class="form-control" id="semen_layout"
                                                        name="semen_layout">
                                                        <option
                                                            @if (isset($medical_settings['semen_layout'])) @if ($medical_settings['semen_layout'] == 'with_graph') selected @endif
                                                            @endif
                                                            value="with_graph" selected>
                                                            {{ __('with Graph') }}
                                                        </option>

                                                        <option
                                                            @if (isset($medical_settings['semen_layout'])) @if ($medical_settings['semen_layout'] == 'without_graph') selected @endif
                                                            @endif
                                                            value="without_graph">
                                                            {{ __('withOut Graph') }}
                                                        </option>
                                                    </select>


                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="fasting_layout">
                                                        {{ __('Fasting Layout') }}</label>

                                                    <select class="form-control" id="fasting_layout"
                                                        name="fasting_layout">
                                                        <option value="with_graph"
                                                            @if (isset($medical_settings['fasting_layout'])) @if ($medical_settings['fasting_layout'] == 'with_graph') selected @endif
                                                            @endif
                                                            >
                                                            {{ __('with Graph') }}
                                                        </option>

                                                        <option value="without_graph"
                                                            @if (isset($medical_settings['fasting_layout'])) @if ($medical_settings['fasting_layout'] == 'without_graph') selected @endif
                                                            @endif
                                                            >
                                                            {{ __('WithOut Graph') }}
                                                        </option>
                                                    </select>


                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="wokingPaper_layout">
                                                        {{ __('Woking Paper Layout') }}</label>

                                                    <select class="form-control" id="wokingPaper_layout"
                                                        name="wokingPaper_layout">
                                                        <option value="layout1"
                                                            @if (isset($medical_settings['wokingPaper_layout'])) @if ($medical_settings['wokingPaper_layout'] == 'layout1') selected @endif
                                                            @endif
                                                            >
                                                            {{ __('Layout 1') }}
                                                        </option>

                                                        <option value="layout2"
                                                            @if (isset($medical_settings['wokingPaper_layout'])) @if ($medical_settings['wokingPaper_layout'] == 'layout2') selected @endif
                                                            @endif
                                                            >
                                                            {{ __('Layout 2') }}
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="cbc">
                                                        {{ __('CBC') }}</label>

                                                        <select class="form-control test" name="cbc[]"  multiple>
                                                            @foreach ($tests as $test)
                                                            @if (isset($medical_settings['cbc'])) @if (in_array($test->id,$medical_settings['cbc']))
                                                            
                                                            <option 
                                                                selected 
                                                                
                                                                value="{{ $test->id }}">{{ $test->name }}
                                                            </option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </select>

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="semen">
                                                        {{ __('semen') }}</label>

                                                        <select class="form-control test" name="semen[]"  multiple>
                                                            @foreach ($tests as $test)
                                                            @if (isset($medical_settings['semen'])) @if (in_array($test->id,$medical_settings['semen']))
                                                            
                                                            <option 
                                                                selected 
                                                                
                                                                value="{{ $test->id }}">{{ $test->name }}
                                                            </option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </select>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \medical Settings -->

                        <!-- printer Settings -->
                        @if (isset($printer_settings) && $printer_settings != null)
                            <div class="tab-pane text-left fade show" id="printer_settings" role="tabpanel"
                                aria-labelledby="printer_settings">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title">{{ __('Printer') }}</h5>
                                    </div>
                                    <form action="{{ route('admin.settings.printer_submit') }}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label
                                                            for="barcode_settings_type">{{ __('Working Paper') }}</label>
                                                        <input type="text" name="working_paper" id="working_paper"
                                                            class="form-control"
                                                            value="{{ $printer_settings['working_paper'] }}" required>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="barcode_settings_type">{{ __('Parcode') }}</label>
                                                        <input type="text" name="parcode" id="parcode"
                                                            class="form-control"
                                                            value="{{ $printer_settings['parcode'] }}" required>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="barcode_settings_type">{{ __('Receipt') }}</label>
                                                        <input type="text" name="receipt" id="receipt"
                                                            class="form-control"
                                                            value="{{ $printer_settings['receipt'] }}" required>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="barcode_settings_type">{{ __('Report') }}</label>
                                                        <input type="text" name="report" id="report"
                                                            class="form-control"
                                                            value="{{ $printer_settings['report'] }}" required>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary"> <i
                                                    class="fa fa-check"></i> {{ __('Save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <!-- \printer Settings -->

                        <!-- Email settings -->
                        <div class="tab-pane text-left fade show" id="emails_settings" role="tabpanel"
                            aria-labelledby="emails_settings">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Email Settings') }}</h3>
                                </div>
                                <form action="{{ route('admin.settings.emails_submit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="host">{{ __('Host') }}</label>
                                                    <input type="text" name="host" id="host"
                                                        value="{{ $emails_settings['host'] }}" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="port">{{ __('Port') }}</label>
                                                    <input type="text" name="port" id="port"
                                                        value="{{ $emails_settings['port'] }}" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="username">{{ __('Username') }}</label>
                                                    <input type="text" name="username" id="username"
                                                        value="{{ $emails_settings['username'] }}"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="password">{{ __('Password') }}</label>
                                                    <input type="text" name="password" id="password"
                                                        value="{{ $emails_settings['password'] }}"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <label for="encryption">{{ __('Encryption') }}</label>
                                                    <input type="text" name="encryption" id="encryption"
                                                        value="{{ $emails_settings['encryption'] }}"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="from_address">{{ __('From Address') }}</label>
                                                    <input type="email" name="from_address" id="from_address"
                                                        value="{{ $emails_settings['from_address'] }}"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="from_name">{{ __('From Name') }}</label>
                                                    <input type="text" name="from_name" id="from_name"
                                                        value="{{ $emails_settings['from_name'] }}"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label
                                                        for="header_color">{{ __('Header background color') }}</label>
                                                    <div class="input-group">
                                                        <input id="header_color" type="text" class="form-control"
                                                            name="header_color"
                                                            value="{{ $emails_settings['header_color'] }}" required>
                                                        <div class="input-group-append header_color">
                                                            <span class="input-group-text"><i class="fas fa-square"
                                                                    style="color: {{ $emails_settings['header_color'] }}"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label
                                                        for="footer_color">{{ __('Footer background color') }}</label>
                                                    <div class="input-group">
                                                        <input id="footer_color" type="text" class="form-control"
                                                            name="footer_color"
                                                            value="{{ $emails_settings['footer_color'] }}" required>
                                                        <div class="input-group-append footer_color">
                                                            <span class="input-group-text"><i class="fas fa-square"
                                                                    style="color:{{ $emails_settings['footer_color'] }}"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card card-primary card-tabs">
                                                    <div class="card-header p-0 pt-1">
                                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab"
                                                            role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="patient_code_tab"
                                                                    data-toggle="pill" href="#patient_code"
                                                                    role="tab" aria-controls="patient_code"
                                                                    aria-selected="true">
                                                                    {{ __('Patient Code') }}
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="resetting_password_tab"
                                                                    data-toggle="pill" href="#resetting_password"
                                                                    role="tab" aria-controls="resetting_password"
                                                                    aria-selected="true">
                                                                    {{ __('Resetting Password') }}
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="receipt_tab"
                                                                    data-toggle="pill" href="#receipt" role="tab"
                                                                    aria-controls="receipt" aria-selected="true">
                                                                    {{ __('Receipt') }}
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="report_tab" data-toggle="pill"
                                                                    href="#report" role="tab"
                                                                    aria-controls="report" aria-selected="true">
                                                                    {{ __('Report') }}
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                                            <div class="tab-pane fade show active" id="patient_code"
                                                                role="tabpanel" aria-labelledby="patient_code_tab">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <input name="patient_code[active]"
                                                                            type="checkbox"
                                                                            @if (!empty($emails_settings['patient_code']) && $emails_settings['patient_code']['active']) checked @endif
                                                                            netliva-switch
                                                                            data-active-text="{{ __('Active') }}"
                                                                            data-passive-text=" {{ __('Deactive') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <p class="text-danger">
                                                                        {{ __('Do not change variables') }}:<br>{patient_code}
                                                                        <br> {patient_name}</p>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="patient_code_subject">{{ __('subject') }}</label>
                                                                            <input type="text"
                                                                                id="patient_code_subject"
                                                                                class="form-control"
                                                                                name="patient_code[subject]"
                                                                                value="{{ $emails_settings['patient_code']['subject'] }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="patient_code_body">{{ __('Body') }}</label>
                                                                            <textarea class="form-control summernote" name="patient_code[body]" id="patient_code_body" cols="30"
                                                                                rows="10" required>{{ $emails_settings['patient_code']['body'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="resetting_password"
                                                                role="tabpanel" aria-labelledby="resetting_password">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <input name="reset_password[active]"
                                                                            type="checkbox"
                                                                            @if (!empty($emails_settings['reset_password']) && $emails_settings['reset_password']['active']) checked @endif
                                                                            netliva-switch
                                                                            data-active-text="{{ __('Active') }}"
                                                                            data-passive-text=" {{ __('Deactive') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="reset_password_subject">{{ __('subject') }}</label>
                                                                            <input type="text"
                                                                                id="reset_password_subject"
                                                                                class="form-control"
                                                                                name="reset_password[subject]"
                                                                                value="{{ $emails_settings['reset_password']['subject'] }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="reset_password_body">{{ __('Body') }}</label>
                                                                            <textarea class="form-control summernote" name="reset_password[body]" id="reset_password_body" cols="30"
                                                                                rows="10" required>{{ $emails_settings['reset_password']['body'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="receipt" role="tabpanel"
                                                                aria-labelledby="receipt">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <input name="receipt[active]" type="checkbox"
                                                                            @if (!empty($emails_settings['receipt']) && $emails_settings['receipt']['active']) checked @endif
                                                                            netliva-switch
                                                                            data-active-text="{{ __('Active') }}"
                                                                            data-passive-text=" {{ __('Deactive') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <p class="text-danger">
                                                                        {{ __('Do not change variables') }}:<br>{patient_name}
                                                                    </p>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="receipt_subject">{{ __('subject') }}</label>
                                                                            <input type="text" id="receipt_subject"
                                                                                class="form-control"
                                                                                name="receipt[subject]"
                                                                                value="{{ $emails_settings['receipt']['subject'] }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="receipt_body">{{ __('Body') }}</label>
                                                                            <textarea class="form-control summernote" name="receipt[body]" id="receipt_body" cols="30" rows="10"
                                                                                required>{{ $emails_settings['receipt']['body'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="report" role="tabpanel"
                                                                aria-labelledby="report">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <input name="report[active]" type="checkbox"
                                                                            @if (!empty($emails_settings['report']) && $emails_settings['report']['active']) checked @endif
                                                                            netliva-switch
                                                                            data-active-text="{{ __('Active') }}"
                                                                            data-passive-text=" {{ __('Deactive') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <p class="text-danger">
                                                                        {{ __('Do not change variables') }}:<br>{patient_name}
                                                                    </p>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="report_subject">{{ __('subject') }}</label>
                                                                            <input type="text" id="report_subject"
                                                                                class="form-control"
                                                                                name="report[subject]"
                                                                                value="{{ $emails_settings['report']['subject'] }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="report_body">{{ __('Body') }}</label>
                                                                            <textarea class="form-control summernote" name="report[body]" id="report_body" cols="30" rows="10"
                                                                                required>{{ $emails_settings['report']['body'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button class="btn btn-primary"> <i class="fa fa-check"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \Email Settings -->

                        <!-- sms settings -->
                        <div class="tab-pane text-left fade show" id="sms_settings" role="tabpanel"
                            aria-labelledby="sms_settings">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('SMS Settings') }}</h3>
                                </div>
                                <form action="{{ route('admin.settings.sms_submit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="sms_gateway">{{ __('Active Gateway') }}</label>
                                                    <select name="gateway" id="sms_gateway" class="form-control"
                                                        required>
                                                        <option value="" disabled selected>
                                                            {{ __('Select gateway') }}</option>
                                                        <option value="nexmo">Nexmo</option>
                                                        <option value="twilio">Twilio</option>
                                                        <option value="textLocal">Local Text (indian)</option>
                                                        <option value="infobip">Infobip</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mb-2">
                                                <div class="card card-primary card-tabs sms-gateways-tabs">
                                                    <div class="card-header p-0 pt-1">
                                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab"
                                                            role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="sms-nexmo-tab"
                                                                    data-toggle="pill" href="#sms-nexmo-card"
                                                                    role="tab" aria-controls="sms-nexmo-card"
                                                                    aria-selected="true">Nexmo</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="sms-twilio-tab"
                                                                    data-toggle="pill" href="#sms-twilio-card"
                                                                    role="tab" aria-controls="sms-twilio-card"
                                                                    aria-selected="true">Twilio</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="sms-textLocal-tab"
                                                                    data-toggle="pill" href="#sms-textLocal-card"
                                                                    role="tab" aria-controls="sms-textLocal-card"
                                                                    aria-selected="true">Local Text (Indian)</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="sms-infobip-tab"
                                                                    data-toggle="pill" href="#sms-infobip-card"
                                                                    role="tab" aria-controls="sms-infobip-card"
                                                                    aria-selected="true">Infobip</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                                            <div class="tab-pane fade show active" id="sms-nexmo-card"
                                                                role="tabpanel" aria-labelledby="sms-nexmo-card">
                                                                <div class="row">
                                                                    <div class="col-lg-12 alert alert-info">
                                                                        <i class="fa fa-info-circle"></i>
                                                                        Go to nexmo :
                                                                        <a href="https://dashboard.nexmo.com"
                                                                            target="_blank">https://dashboard.nexmo.com</a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="nexmo_key">{{ __('API Key') }}</label>
                                                                            <input type="text" name="nexmo[key]"
                                                                                id="nexmo_key" class="form-control"
                                                                                value="{{ $sms_settings['nexmo']['key'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="nexmo_secret">{{ __('Secret Key') }}</label>
                                                                            <input type="text" name="nexmo[secret]"
                                                                                id="nexmo_secret" class="form-control"
                                                                                value="{{ $sms_settings['nexmo']['secret'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="sms-twilio-card"
                                                                role="tabpanel" aria-labelledby="sms-twilio-card">
                                                                <div class="row">
                                                                    <div class="col-lg-12 alert alert-info">
                                                                        <i class="fa fa-info-circle"></i>
                                                                        Go to Twilio :
                                                                        <a href="https://www.twilio.com"
                                                                            target="_blank"> https://www.twilio.com</a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="twilio_sid">{{ __('SID') }}</label>
                                                                            <input type="text" name="twilio[sid]"
                                                                                id="twilio_sid" class="form-control"
                                                                                value="{{ $sms_settings['twilio']['sid'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="twilio_token">{{ __('API Token') }}</label>
                                                                            <input type="text" name="twilio[token]"
                                                                                id="twilio_token" class="form-control"
                                                                                value="{{ $sms_settings['twilio']['token'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="twilio_from">{{ __('From Number') }}</label>
                                                                            <input type="text" name="twilio[from]"
                                                                                id="twilio_from" class="form-control"
                                                                                value="{{ $sms_settings['twilio']['from'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="sms-textLocal-card"
                                                                role="tabpanel" aria-labelledby="sms-textLocal-card">
                                                                <div class="row">
                                                                    <div class="col-lg-12 alert alert-info">
                                                                        <i class="fa fa-info-circle"></i>
                                                                        Local Text gateway is available only in India <br>
                                                                        <i class="fa fa-link"></i>
                                                                        Go to Text Local :
                                                                        <a href="https://www.textlocal.com"
                                                                            target="_blank"> https://www.textlocal.com</a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="textLocal_key">{{ __('API Key') }}</label>
                                                                            <input type="text" name="textLocal[key]"
                                                                                id="textLocal_key" class="form-control"
                                                                                value="{{ $sms_settings['textLocal']['key'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="textLocal_sender">{{ __('Sender') }}</label>
                                                                            <input type="text"
                                                                                name="textLocal[sender]"
                                                                                id="textLocal_sender"
                                                                                class="form-control"
                                                                                value="{{ $sms_settings['textLocal']['sender'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="sms-infobip-card"
                                                                role="tabpanel" aria-labelledby="sms-textLocal-card">
                                                                <div class="row">
                                                                    <div class="col-lg-12 alert alert-info">
                                                                        <i class="fa fa-info-circle"></i>
                                                                        Go to Infobip :
                                                                        <a href="https://www.infobip.com"
                                                                            target="_blank"> https://www.infobip.com</a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="infobip_base_url">{{ __('Base url') }}</label>
                                                                            <input type="text"
                                                                                name="infobip[base_url]"
                                                                                id="infobip_base_url"
                                                                                class="form-control"
                                                                                value="{{ $sms_settings['infobip']['base_url'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="infobip_key">{{ __('API Key') }}</label>
                                                                            <input type="text" name="infobip[key]"
                                                                                id="infobip_key" class="form-control"
                                                                                value="{{ $sms_settings['infobip']['key'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="infobip_from">{{ __('From') }}</label>
                                                                            <input type="text" name="infobip[from]"
                                                                                id="infobip_from" class="form-control"
                                                                                value="{{ $sms_settings['infobip']['from'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card card-primary card-tabs">
                                                    <div class="card-header p-0 pt-1">
                                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab"
                                                            role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="patient_code_tab"
                                                                    data-toggle="pill" href="#sms_patient_code_tab"
                                                                    role="tab" aria-controls="patient_code"
                                                                    aria-selected="true">
                                                                    {{ __('Patient Code') }}
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="tests_notification_tab"
                                                                    data-toggle="pill"
                                                                    href="#sms_tests_notification_tab" role="tab"
                                                                    aria-controls="tests_notification"
                                                                    aria-selected="true">
                                                                    {{ __('Tests Notification') }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                                            <div class="tab-pane fade show active"
                                                                id="sms_patient_code_tab" role="tabpanel"
                                                                aria-labelledby="patient_code_tab">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <input name="patient_code[active]"
                                                                            type="checkbox"
                                                                            @if ($sms_settings['patient_code']['active']) checked @endif
                                                                            netliva-switch
                                                                            data-active-text="{{ __('Active') }}"
                                                                            data-passive-text=" {{ __('Deactive') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <p class="text-danger">
                                                                                {{ __('Do not change variables') }}:<br>{patient_name}<br>
                                                                                {patient_code}</p>
                                                                            <label
                                                                                for="sms_patient_code_body">{{ __('Message') }}</label>
                                                                            <textarea class="form-control" name="patient_code[message]" id="sms_patient_code_body" cols="30"
                                                                                rows="3" required>{{ $sms_settings['patient_code']['message'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade show"
                                                                id="sms_tests_notification_tab" role="tabpanel"
                                                                aria-labelledby="tests_notification_tab">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <input name="tests_notification[active]"
                                                                            type="checkbox"
                                                                            @if ($sms_settings['tests_notification']['active']) checked @endif
                                                                            netliva-switch
                                                                            data-active-text="{{ __('Active') }}"
                                                                            data-passive-text=" {{ __('Deactive') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <p class="text-danger">
                                                                                {{ __('Do not change variables') }}:
                                                                                <br>{patient_name} <br> {patient_code}</p>
                                                                            <label
                                                                                for="sms_tests_notification_body">{{ __('Message') }}</label>
                                                                            <textarea class="form-control" name="tests_notification[message]" id="sms_tests_notification_body"
                                                                                cols="30" rows="3" required>{{ $sms_settings['tests_notification']['message'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button class="btn btn-primary"> <i class="fa fa-check"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \sms Settings -->

                        <!-- whatsapp settings -->
                        <div class="tab-pane text-left fade show" id="whatsapp_settings" role="tabpanel"
                            aria-labelledby="whatsapp_settings">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Whatsapp Settings') }}</h3>
                                </div>
                                <form action="{{ route('admin.settings.whatsapp_submit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card card-primary card-tabs">
                                                    <div class="card-header p-0 pt-1">
                                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab"
                                                            role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="whatsapp_receipt_link"
                                                                    data-toggle="pill" href="#whatsapp_receipt_tab"
                                                                    role="tab" aria-controls="whatsapp_receipt_tab"
                                                                    aria-selected="true">
                                                                    {{ __('Receipt link') }}
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="whatsapp_report_link"
                                                                    data-toggle="pill" href="#whatsapp_report_tab"
                                                                    role="tab" aria-controls="whatsapp_report_tab"
                                                                    aria-selected="true">
                                                                    {{ __('Report link') }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                                            <div class="tab-pane fade show active"
                                                                id="whatsapp_receipt_tab" role="tabpanel"
                                                                aria-labelledby="whatsapp_receipt_tab">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <input name="receipt[active]" type="checkbox"
                                                                            @if ($whatsapp_settings['receipt']['active']) checked @endif
                                                                            netliva-switch
                                                                            data-active-text="{{ __('Active') }}"
                                                                            data-passive-text=" {{ __('Deactive') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <p class="text-danger">
                                                                                {{ __('Do not change variables') }}:<br>{patient_name}<br>
                                                                                {receipt_link}</p>
                                                                            <label
                                                                                for="whatsapp_receipt_body">{{ __('Message') }}</label>
                                                                            <textarea class="form-control" name="receipt[message]" id="whatsapp_receipt_body" cols="30"
                                                                                rows="3" required>{{ $whatsapp_settings['receipt']['message'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade show" id="whatsapp_report_tab"
                                                                role="tabpanel" aria-labelledby="whatsapp_report_tab">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <input name="report[active]" type="checkbox"
                                                                            @if ($whatsapp_settings['report']['active']) checked @endif
                                                                            netliva-switch
                                                                            data-active-text="{{ __('Active') }}"
                                                                            data-passive-text=" {{ __('Deactive') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <p class="text-danger">
                                                                                {{ __('Do not change variables') }}:
                                                                                <br>{patient_name} <br> {report_link}</p>
                                                                            <label
                                                                                for="whatsapp_report_body">{{ __('Message') }}</label>
                                                                            <textarea class="form-control" name="report[message]" id="whatsapp_report_body" cols="30" rows="3"
                                                                                required>{{ $whatsapp_settings['report']['message'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button class="btn btn-primary"> <i class="fa fa-check"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \whatsapp Settings -->

                        <!-- Api keys Settings -->
                        <div class="tab-pane text-left fade show" id="api_keys_settings" role="tabpanel"
                            aria-labelledby="api_keys_settings">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('Api Keys') }}</h5>
                                </div>
                                <form action="{{ route('admin.settings.api_keys_submit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <label for="google_map"> <i class="fas fa-map-marker-alt"></i>
                                            {{ __('Google maps') }}</label><br>
                                        <div class="mt-1 mb-3 alert alert-info">
                                            <i class="fa fa-info-circle"></i>
                                            <a href="https://www.youtube.com/watch?v=OGTG1l7yin4" target="_blank">How to
                                                generate Google api key ?</a>
                                        </div>
                                        <input type="text" class="form-control" id="google_map" name="google_map"
                                            placeholder="{{ __('Google map key') }}"
                                            value="{{ $api_keys_settings['google_map'] }}">
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \Api Keys Settings -->


                        <!-- Accounting Settings -->
                        <div class="tab-pane text-left fade show" id="accounting" role="tabpanel"
                            aria-labelledby="accounting">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('Accounting') }}</h5>
                                </div>
                                <form action="{{ route('admin.settings.accounting') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row form-check">
                                            <p>{{ __('Calculate Expenses') }}</p>
                                            <input class="form-check-input" type="radio" id="custody"
                                                name="expenses_type" value="custody"
                                                @if (isset($account_settings['expenses_type']) && $account_settings['expenses_type'] == 'custody') checked @endif>
                                            <label class="form-check-label"
                                                for="custody">{{ __('From Custody') }}</label><br>
                                            <input class="form-check-input" type="radio" id="cach"
                                                name="expenses_type" value="cach"
                                                @if (isset($account_settings['expenses_type']) && $account_settings['expenses_type'] == 'cach') checked @endif>
                                            <label class="form-check-label"
                                                for="cach">{{ __('From Cach') }}</label><br>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="branch">{{ __('Main Branch') }}</label>
                                                <select class="form-control" name="branch" id="branch" required>
                                                    @foreach ($report_branches as $branch)
                                                        <option value="{{ $branch['id'] }}"
                                                            @if (isset($account_settings['branch']) && $account_settings['branch'] == $branch['id']) selected @endif>
                                                            {{ $branch['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="payment">{{ __('Main Payment') }}</label>
                                                <select class="form-control" name="payment" id="payment" required>
                                                    @foreach ($payment_methods as $payment)
                                                        <option value="{{ $payment['id'] }}"
                                                            @if (isset($account_settings['payment']) && $account_settings['payment'] == $payment['id']) selected @endif>
                                                            {{ $payment['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="show_discount_value"
                                                        id="show_discount_value"
                                                        @if (isset($account_settings['show_discount_value']) && $account_settings['show_discount_value']) checked @endif>
                                                    <label for="show_discount_value"><i class="fas fa-qrcode"></i>
                                                        {{ __('show Discount Value') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="show_discount_persentage"
                                                        id="show_discount_persentage"
                                                        @if (isset($account_settings['show_discount_persentage']) && $account_settings['show_discount_persentage']) checked @endif>
                                                    <label for="show_discount_persentage"><i
                                                            class="fas fa-persentage"></i>
                                                        {{ __('show Discount Persentage') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="show_test_prices"
                                                        id="show_test_prices"
                                                        @if (isset($account_settings['show_test_prices']) && $account_settings['show_test_prices']) checked @endif>
                                                    <label for="show_test_prices"><i class="fas fa-qrcode"></i>
                                                        {{ __('Show Test Prices') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="show_test_name" id="show_test_name"
                                                        @if (isset($account_settings['show_test_name']) && $account_settings['show_test_name']) checked @endif>
                                                    <label for="show_test_name"><i class="fas fa-qrcode"></i>
                                                        {{ __('Show Test Name') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="show_test_" id="show_test_"
                                                        @if (isset($account_settings['show_test_']) && $account_settings['show_test_']) checked @endif>
                                                    <label for="show_test_"><i class="fas fa-qrcode"></i>
                                                        {{ __('Show D.Reporting') }}</label>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <label for="show_groups">{{ __('Show Invoices') }}</label>
                                                <select class="form-control" name="show_groups" id="show_groups"
                                                    required>
                                                    <option @if (isset($account_settings['show_groups']) && $account_settings['show_groups'] == 'all') selected @endif
                                                        value="all">{{ __('All') }}</option>
                                                    <option @if (isset($account_settings['show_groups']) && $account_settings['show_groups'] == 'current') selected @endif
                                                        value="current">{{ __('Current Branch') }}</option>
                                                    <option @if (isset($account_settings['show_groups']) && $account_settings['show_groups'] == 'available') selected @endif
                                                        value="available">{{ __('Available Branch') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <label for="show_medical">{{ __('Show Medical Reports') }}</label>
                                                <select class="form-control" name="show_medical" id="show_medical"
                                                    required>
                                                    <option @if (isset($account_settings['show_medical']) && $account_settings['show_medical'] == 'all') selected @endif
                                                        value="all">{{ __('All') }}</option>
                                                    <option @if (isset($account_settings['show_medical']) && $account_settings['show_medical'] == 'current') selected @endif
                                                        value="current">{{ __('Current Branch') }}</option>
                                                    <option @if (isset($account_settings['show_medical']) && $account_settings['show_medical'] == 'available') selected @endif
                                                        value="available">{{ __('Available Branch') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <label for="invoice_layout">{{ __('Invoices Layouts') }}</label>
                                                <select class="form-control" name="invoice_layout" id="invoice_layout"
                                                    required>
                                                    <option @if (isset($account_settings['invoice_layout']) && $account_settings['invoice_layout'] == 'with_header') selected @endif
                                                        value="with_header">{{ __('With Header') }}</option>
                                                    <option @if (isset($account_settings['invoice_layout']) && $account_settings['invoice_layout'] == 'without_header') selected @endif
                                                        value="without_header">{{ __('Without Header') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="checkbox" name="tax" id="tax"
                                                        @if (isset($account_settings['tax']) && $account_settings['tax']) checked @endif>
                                                    <label for="tax"><i class="fas fa-tax"></i>
                                                        {{ __('Tax') }}</label>

                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="tax_persentage"><i class="fa fa-qrcode"></i>
                                                        {{ __('tax Persentage') }} %</label>
                                                    <input type="number" id="tax_persentage" name="tax_persentage"
                                                        class="form-control"
                                                        @if (isset($account_settings['tax_persentage'])) value="{{ $account_settings['tax_persentage'] }}" @endif>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- \Accounting Settings -->

                        {{-- portal Setting --}}
                        <div class="tab-pane text-left fade show" id="taxesSetting" role="tabpanel"
                            aria-labelledby="accounting">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('taxesSetting') }}</h5>
                                </div>
                                <form action="{{ route('admin.settings.portal') }}" method="POST">
                                    @csrf
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name">
                                                        {{ __('name') }}
                                                    </label>
                                                    <input
                                                        @if (isset($portal_settings)) value="{{ $portal_settings['name'] }}" @endif
                                                        id="name" type="text" name="name"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="gov">
                                                        {{ __('gov') }}
                                                    </label>
                                                    <input id="gov"
                                                        @if (isset($portal_settings)) value="{{ $portal_settings['gov'] }}" @endif
                                                        type="text" name="gov" class="form-control">
                                                </div>
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="ClientID">
                                                        {{ __('ClientID') }}
                                                    </label>
                                                    <input id="ClientID"
                                                        @if (isset($portal_settings)) value="{{ $portal_settings['ID'] }}" @endif
                                                        type="text" name="ID" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="ClientID">
                                                        {{ __('ClientSecret') }}
                                                    </label>
                                                    <input id="ClientSecret"
                                                        @if (isset($portal_settings)) value="{{ $portal_settings['Secret'] }}" @endif
                                                        type="text" name="Secret" class="form-control">
                                                </div>
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="RegisterationNumber">
                                                        {{ __('RegisterationNumber') }}
                                                    </label>
                                                    <input id="RegisterationNumber"
                                                        @if (isset($portal_settings)) value="{{ $portal_settings['registerationNumber'] }}" @endif
                                                        type="text" name="registerationNumber"
                                                        class="form-control">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="TaxType1">
                                                        {{ __('TaxType1') }}
                                                    </label>

                                                    <select class="form-control" id="type1Tax" name="taxType1[id]">
                                                        <option selected value="V009"
                                                            style="font-size: 15px;width: 100px;">@lang('without')
                                                        </option>
                                                        @if (isset($portal_settings['taxType1']))
                                                            @php
                                                                $tax = App\Models\TaxType::where('id', $portal_settings['taxType1']['id'])->first();
                                                            @endphp
                                                            <option value="{{ $tax->id }}" selected
                                                                style="font-size: 15px;width: 100px;">
                                                                {{ $tax->name_ar }}
                                                            </option>
                                                        @endif

                                                    </select>
                                                    {{-- <input id="TaxType1" @if (isset($portal_settings['taxType1'])) value="{{$portal_settings['registerationNumber']}}" @endif type="text" name="registerationNumber" class="form-control"> --}}
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="valueType1">
                                                        {{ __('value') }}
                                                    </label>


                                                    <input id="valueType1"
                                                        @if (isset($portal_settings['taxType1'])) value="{{ $portal_settings['taxType1']['value'] }}" @endif
                                                        type="text" name="taxType1[value]" class="form-control">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="TaxType2">
                                                        {{ __('TaxType2') }}
                                                    </label>

                                                    <select class="form-control" id="type2Tax" name="taxType2[id]">
                                                        <option value="W015" selected>@lang('without')</option>

                                                        {{-- @foreach ($taxType as $type) --}}
                                                        @if (isset($portal_settings['taxType2']))
                                                            @php
                                                                $tax = App\Models\TaxType::where('id', $portal_settings['taxType2']['id'])->first();
                                                            @endphp

                                                            <option value="{{ $tax->id }}" selected
                                                                style="font-size: 15px;width: 100px;">
                                                                {{ $tax->name_ar }}
                                                            </option>
                                                        @endif
                                                        {{-- @endforeach --}}
                                                    </select>
                                                    {{-- <input id="TaxType1" @if (isset($portal_settings['taxType1'])) value="{{$portal_settings['registerationNumber']}}" @endif type="text" name="registerationNumber" class="form-control"> --}}
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="valueType1">
                                                        {{ __('value') }}
                                                    </label>
                                                    <input id="valueType2"
                                                        @if (isset($portal_settings['taxType2'])) value="{{ $portal_settings['taxType2']['value'] }}" @endif
                                                        type="text" name="taxType2[value]" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i>
                                    {{ __('Save') }}</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    {{-- end Portal Setting --}}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <!-- Colorpicker -->
    <script src="{{ url('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- Switch -->
    <script src="{{ url('plugins/swtich-netliva/js/netliva_switch.js') }}"></script>
    <script src="{{ url('js/admin/settings.js') }}"></script>
    <script src="{{ url('plugins/ekko-lightbox/ekko-lightbox.js') }}"></script>

    <script>
        function liveTest(property) {
            value = event.target.value;
            if (property == 'direction') {
                property = "text-align";
                value = value == 'rtl' ? 'start' : 'end';
            }
            if (property == 'font-size') {
                value += 'px';
            }
            $('#test_text').css(property, value);
        }
        $(document).ready(function() {
            $('#branch_name_font_family').val('{{ $reports_settings['branch_name']['font-family'] }}');
            $('#branch_info_font_family').val('{{ $reports_settings['branch_info']['font-family'] }}');
            $('#patient_title_font_family').val('{{ $reports_settings['patient_title']['font-family'] }}');
            $('#patient_data_font_family').val('{{ $reports_settings['patient_data']['font-family'] }}');
            $('#test_title_font_family').val('{{ $reports_settings['test_title']['font-family'] }}');
            $('#test_name_font_family').val('{{ $reports_settings['test_name']['font-family'] }}');
            $('#test_head_font_family').val('{{ $reports_settings['test_head']['font-family'] }}');
            $('#result_font_family').val('{{ $reports_settings['result']['font-family'] }}');
            $('#unit_font_family').val('{{ $reports_settings['unit']['font-family'] }}');
            $('#reference_range_font_family').val('{{ $reports_settings['reference_range']['font-family'] }}');
            $('#status_font_family').val('{{ $reports_settings['status']['font-family'] }}');
            $('#comment_font_family').val('{{ $reports_settings['comment']['font-family'] }}');
            $('#signature_font_family').val('{{ $reports_settings['signature']['font-family'] }}');
            $('#antibiotic_name_font_family').val('{{ $reports_settings['antibiotic_name']['font-family'] }}');
            $('#sensitivity_font_family').val('{{ $reports_settings['sensitivity']['font-family'] }}');
            $('#commercial_name_font_family').val('{{ $reports_settings['commercial_name']['font-family'] }}');
            $('#report_footer_font_family').val('{{ $reports_settings['report_footer']['font-family'] }}');
            $('#invoice-font-family').val('{{ $invoice_setting['font-family'] }}');
            $('#sms_gateway').val('{{ $sms_settings['gateway'] }}').trigger('change');

            @foreach ($report_branches as $branch)
                @isset($barcode_settings['type'][$branch->id])
                    $('#barcode_settings_type_{{ $branch->id }}').val(
                        '{{ $barcode_settings['type'][$branch->id] }}')
                @endisset
            @endforeach
        });
        $('.test').select2({
        width:"100%",
        placeholder:trans("Test"),
        multiple: true,
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url:ajax_url('get_tests'),
           processResults: function (data) {
                 return {
                       results: $.map(data, function (item) {
                          return {
                             text: item.name,
                             id: item.id
                          }
                       })
                 };
              },
              complete:function()
              {
                 $('.preloader').hide();
                 $('.loader').hide();
              }
           }
    });
    </script>
@endsection
