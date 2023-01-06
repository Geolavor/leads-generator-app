@extends('admin::layouts.dashboard')

@section('page_title')
{{ __('admin::app.user.account.my_account') }}
@stop

@section('css')
<style>
    .panel-header,
    .panel-body {
        margin: 0 auto;
        max-width: 800px;
    }

</style>
@stop

@section('content-wrapper')
<div class="content full-page adjacent-center">
    <div class="row">
        <div class="col-3">
            <x-core.account.sidebar />
        </div>
        <div class="col-9">
            <form method="POST" action="{{ route('user.account.update') }}" enctype="multipart/form-data" @submit.prevent="onSubmit">
                <div class="page-content">
                    <div class="form-container">

                        <div class="panel">
                            <div class="panel-header">
                                {!! view_render_event('user_profile.edit.form_buttons.before', ['user' => $user])
                                !!}

                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin::app.user.account.update_details') }}
                                </button>

                                <a href="{{ route('dashboard.index') }}">{{ __('admin::app.common.back') }}</a>

                                {!! view_render_event('user_profile.edit.form_buttons.after', ['user' => $user])
                                !!}
                            </div>

                            <div class="panel-body">

                                {!! view_render_event('user_profile.edit.form_controls.before', ['user' => $user])
                                !!}

                                @csrf()

                                <input name="_method" type="hidden" value="PUT">

                                <upload-profile-image></upload-profile-image>
                                <input type="checkbox" name="remove_image" />
                                <label for="remove" class="">
                                    {{ __('admin::app.user.account.remove-image') }}
                                </label>

                                <div class="row">

                                    <div class="form-group" :class="[errors.has('name') ? 'has-error' : '']">
                                        <label for="name" class="required">
                                            {{ __('admin::app.user.account.name') }}
                                        </label>

                                        <input type="text" name="name" class="control" id="name"
                                            value="{{ old('name') ?: $user->name }}" v-validate="'required'"
                                            data-vv-as="{{ __('admin::app.user.account.name') }}" />

                                        <small class="control-error" v-if="errors.has('name')">
                                            @{{ errors.first('name') }}
                                        </small>
                                    </div>

                                    <div class="form-group" :class="[errors.has('email') ? 'has-error' : '']">
                                        <label for="email" class="required">
                                            {{ __('admin::app.user.account.email') }}
                                        </label>

                                        <input type="text" name="email" class="control" disabled="true" id="email"
                                            value="{{ old('email') ?: $user->email }}" v-validate="'required'"
                                            data-vv-as="{{ __('admin::app.user.account.email') }}" />

                                        <small class="control-error" v-if="errors.has('email')">
                                            @{{ errors.first('email') }}
                                        </small>
                                    </div>

                                    <div class="form-group" :class="[errors.has('current_password') ? 'has-error' : '']">
                                        <label for="current_password" class="required">
                                            {{ __('admin::app.user.account.current_password') }}
                                        </label>

                                        <input type="password" name="current_password" class="control" id="current_password"
                                            v-validate="'required'"
                                            data-vv-as="{{ __('admin::app.user.account.current_password') }}" />

                                        <small class="control-error" v-if="errors.has('current_password')">
                                            @{{ errors.first('current_password') }}
                                        </small>
                                    </div>

                                    <div class="form-group col-6" :class="[errors.has('password') ? 'has-error' : '']">
                                        <label for="password">
                                            {{ __('admin::app.user.account.password') }}
                                        </label>

                                        <input type="password" name="password" class="control" id="password" ref="password"
                                            data-vv-as="{{ __('admin::app.user.account.password') }}" />

                                        <small class="control-error" v-if="errors.has('password')">
                                            @{{ errors.first('password') }}
                                        </small>
                                    </div>

                                    <div class="form-group col-6" :class="[errors.has('confirm_password') ? 'has-error' : '']">
                                        <label for="confirm_password">
                                            {{ __('admin::app.user.account.confirm_password') }}
                                        </label>

                                        <input type="password" name="password_confirmation" class="control"
                                            id="confirm_password" v-validate="'confirmed:password'"
                                            data-vv-as="{{ __('admin::app.user.account.confirm_password') }}" />

                                        <small class="control-error" v-if="errors.has('confirm_password')">
                                            @{{ errors.first('confirm_password') }}
                                        </small>
                                    </div>

                                    <div class="form-group col-6" :class="[errors.has('tax_number') ? 'has-error' : '']">
                                        <label for="tax_number" class="required">
                                            {{ __('admin::app.user.account.tax_number') }}
                                        </label>

                                        <input type="text" name="tax_number" class="control" id="tax_number"
                                            value="{{ old('tax_number') ?: $user->tax_number }}"
                                            data-vv-as="{{ __('admin::app.user.account.tax-number') }}" />

                                        <small class="control-error" v-if="errors.has('tax_number')">
                                            @{{ errors.first('tax_number') }}
                                        </small>
                                    </div>

                                    <div class="form-group col-6" :class="[errors.has('phone') ? 'has-error' : '']">
                                        <label for="phone" class="required">
                                            {{ __('admin::app.user.account.phone') }}
                                        </label>

                                        <input type="number" name="phone" class="control" id="phone"
                                            value="{{ old('phone') ?: $user->phone }}"
                                            data-vv-as="{{ __('admin::app.user.account.phone') }}" />

                                        <small class="control-error" v-if="errors.has('phone')">
                                            @{{ errors.first('phone') }}
                                        </small>
                                    </div>

                                    <div class="form-check col-12 mb-3">
                                        <input type="checkbox" class="form-check-input" id="signupHeroFormPrivacyCheck"
                                            name="signupFormPrivacyCheck" value="{{ $user->allow_marketing }}"
                                            {{ $user->allow_marketing ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="signupHeroFormPrivacyCheck"> Accept our
                                            <a href="./page-privacy.html">Marketing</a> contact</label>
                                    </div>

                                </div>

                                {!! view_render_event('user_profile.edit.form_controls.after', ['user' => $user]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form method="POST" action="{{ route('user.account.delete') }}">
                @csrf()
                <div class="page-content">
                    <div class="form-container">

                        <div class="panel">
                            <div class="panel-header">
                                <button type="submit" class="btn btn-transparent">
                                    {{ __('admin::app.user.account.remove') }}
                                </button>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop


@push('scripts')
<script type="text/x-template" id="upload-profile-image-template">
    <div class="form-group">

            <!-- <div class="image-upload-brick">
                <input
                    type="file"
                    name="image"
                    id="upload-profile"
                    ref="imageInput"
                    @change="addImageView($event)"
                >
            </div> -->

            <div class="image-upload-brick">
                
                <label class="avatar avatar-xxl avatar-circle avatar-uploader" for="upload-profile">
                    <img id="upload-profile-image" class="avatar-img" v-if="imageData.length > 0" :src="imageData" alt="Image Description">

                    <input
                        type="file"
                        name="image"
                        class="js-file-attach avatar-uploader-input"
                        id="upload-profile"
                        @change="addImageView($event)"
                        ref="imageInput"
                    >

                    <span class="avatar-uploader-trigger">
                        <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
                    </span>
                </label>
            </div>

            <div class="image-info-brick">
                <span class="field-info">
                    Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format
                </span>
            </div>
        </div>
    </script>

<script>
    Vue.component('upload-profile-image', {
        template: '#upload-profile-image-template',

        data: function () {
            return {
                imageData: "{{ $user->image_url }}",
            }
        },

        methods: {
            addImageView() {
                var imageInput = this.$refs.imageInput;

                if (imageInput.files && imageInput.files[0]) {
                    if (imageInput.files[0].type.includes('image/')) {
                        var reader = new FileReader();

                        reader.onload = (e) => {
                            this.imageData = e.target.result;
                        }

                        reader.readAsDataURL(imageInput.files[0]);
                    } else {
                        imageInput.value = '';

                        alert('Only images (.jpeg, .jpg, .png, ..) are allowed.');
                    }
                }
            }
        }
    });

</script>
@endpush
