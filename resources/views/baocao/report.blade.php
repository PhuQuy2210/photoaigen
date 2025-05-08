@extends('main')

@section('content')
    <div class="breadcrumb-option spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box-report p-4 shadow rounded bg-white">
                        <h3 class="mb-4">{{ __('messages.copyright_notice') }}</h3>
                        <p class="text-muted">
                            {{ __('messages.report_instructions') }}
                        </p>
                        <hr>
                        <form action="{{ route('images.reportStore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <!-- id của ảnh -->
                            <input type="hidden" name="hinhanh_id" value="{{ $image->id }}">

                            <h2>{{ __('messages.contact_info') }}</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label"><strong>{{ __('messages.full_name') }}: </strong></label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name', Auth::user()->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label"><strong>{{ __('messages.contact_email') }}:</strong></label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            value="{{ old('email', Auth::user()->email) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sdt" class="form-label"><strong>{{ __('messages.phone_number') }}:</strong></label>
                                        <input type="number" name="sdt" class="form-control" id="sdt"
                                            value="{{ old('sdt') }}" placeholder="{{ __('messages.enter_phone') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quocgia" class="form-label"><strong>{{ __('messages.country') }}:</strong></label>
                                        <input type="text" name="quocgia" class="form-control" id="quocgia"
                                            value="{{ old('quocgia') }}" placeholder="{{ __('messages.enter_country') }}" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h2>{{ __('messages.violation_details') }}</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="originalContent" class="form-label"><strong>{{ __('messages.original_link') }}</strong></label>
                                        <input type="url" name="url" class="form-control" id="originalContent"
                                            value="{{ old('url') }}" placeholder="{{ __('messages.paste_original_link') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label"><strong>{{ __('messages.violation_description') }}</strong></label>
                                        <textarea name="description" class="form-control" id="description" rows="4"
                                            placeholder="{{ __('messages.describe_violation') }}" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h2>{{ __('messages.commitment') }}</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="mb-3 form-check">
                                            <input class="custom-control-input" type="checkbox" name="commitment"
                                                id="check_form" {{ old('commitment') ? 'checked' : '' }} required>
                                            <label for="check_form" class="custom-control-label d-block text-wrap">
                                                {{ __('messages.commitment_text') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nút gửi -->
                            <div class="sub-baocao d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger">{{ __('messages.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

