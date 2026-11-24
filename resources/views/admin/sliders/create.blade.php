@extends('layouts.admin.layout')

@section('content')
<div class="main-content">
<section class="section">

<div class="section-header">
    <h1>Hero Section</h1>
</div>

<div class="row">
<div class="col-12">
<div class="card">

<form method="POST"
      action="{{ isset($hero) ? route('hero.update',$hero->id) : route('hero.store') }}"
      enctype="multipart/form-data">

    @csrf
    @if(isset($hero))
        @method('PUT')
    @endif

    <div class="card-header">
        <h4>{{ isset($hero) ? 'Edit Hero Section' : 'Create Hero Section' }}</h4>
    </div>

    <div class="card-body">

        {{-- Title --}}
        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                Title <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12 col-md-7">
                <input type="text"
                       name="title"
                       value="{{ old('title', $hero->title ?? '') }}"
                       required
                       class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                <small class="text-danger">{{ $errors->first('title') }}</small>
            </div>
        </div>

        {{-- Subtitle --}}
        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                Sub Title
            </label>
            <div class="col-sm-12 col-md-7">
                <textarea
                    class="form-control {{ $errors->has('subtitle') ? ' is-invalid' : '' }}"
                    name="subtitle"
                    id="subtitle">{{ old('subtitle', $hero->subtitle ?? '') }}</textarea>
                <small class="text-danger">{{ $errors->first('subtitle') }}</small>
            </div>
        </div>

        {{-- Background Image --}}
        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                Background Image <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12 col-md-7">
                <input type="file"
                       name="background_image"
                       {{ isset($hero) ? '' : 'required' }}
                       class="form-control {{ $errors->has('background_image') ? ' is-invalid' : '' }}"
                       accept="image/*">

                <span class="form-text">Recommended size: 979px × 600px</span>

                @if(isset($hero) && $hero->background_image)
                    <img src="{{ asset($hero->background_image) }}"
                         class="mt-2"
                         height="80">
                @endif

                <small class="text-danger">{{ $errors->first('background_image') }}</small>
            </div>
        </div>

        {{-- Status --}}
        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                Status
            </label>
            <div class="col-sm-12 col-md-7">
                <select name="status" class="form-control">
                    <option value="1" {{ old('status', $hero->status ?? 1) == 1 ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0" {{ old('status', $hero->status ?? 1) == 0 ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>
        </div>

        {{-- Submit Button (THIS WAS MISSING) --}}
        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
                <button type="submit" class="btn btn-primary">
                    {{ isset($hero) ? 'Update' : 'Submit' }}
                </button>
                <a href="{{ route('hero.index') }}" class="btn btn-secondary ml-2">
                    Cancel
                </a>
            </div>
        </div>

    </div>
</form>

</div>
</div>
</div>

</section>
</div>
@endsection
