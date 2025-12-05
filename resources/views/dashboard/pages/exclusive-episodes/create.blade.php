<x-dashboard.layout :title="__('label.new_exclusive_episode')">
    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.exclusive_episodes') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.exclusive-episodes.index') }}">
                                {{ __('label.exclusive_episodes') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_exclusive_episode') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_exclusive_episode') }}</h4>
            </div>
            <form action="{{ route('admin.exclusive-episodes.store') }}" method="POST" enctype="multipart/form-data" id="episode_form">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="user_id">{{ __('label.the_podcaster') }}</label>
                                <select name="user_id" id="user_id" class="select2 form-select" required>
                                    <option value="" selected disabled>
                                        {{ __('label.select_podcaster') }}
                                    </option>
                                    @foreach ($podcasters as $podcaster)
                                        <option value="{{ $podcaster->id }}" @selected(old('user_id') == $podcaster->id)
                                            data-img="{{ displayFile($podcaster->profile_img) }}">
                                            {{ $podcaster->name . ' (' . $podcaster->email . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="channel_id">{{ __('label.channel') }}</label>
                                <select name="channel_id" id="channel_id" class="select2 form-select" required>
                                    <option value="" selected disabled>
                                        {{ __('label.select_channel') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="season_id">{{ __('label.season') }}</label>
                                <select name="season_id" id="season_id" class="select2 form-select" required>
                                    <option value="" selected disabled>
                                        {{ __('label.select_season') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="name">{{ __('label.name') }}</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="{{ __('label.name') }}" required />
                            </div>
                        </div>

                        <div class="col-md-6 col-12 d-flex align-items-center gap-2 parent">
                            <div class="mb-2 flex-grow-1">
                                <label for="image" class="form-label">
                                    {{ __('label.image') }}
                                </label>
                                <input type="file" id="image" name="image" class="form-control image"
                                    accept=".jpg,.jpeg,.png,.webp" required>
                            </div>
                            <img id="image_preview" class="preview rounded" width="60px" style="display:none;" />
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="description">{{ __('label.description') }}</label>
                                <textarea rows="4" id="description" name="description" class="form-control"
                                    placeholder="{{ __('label.description') }}" required>{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="media_type">{{ __('label.media_type') }}</label>
                                <select name="media_type" id="media_type" class="form-select" required>
                                    <option value="" selected disabled>{{ __('label.select_type') }}</option>
                                    <option value="video" @selected(old('media_type') == 'video')>{{ __('label.video') }}</option>
                                    <option value="audio" @selected(old('media_type') == 'audio')>{{ __('label.audio') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="media_source">{{ __('label.media_source') }}</label>
                                <select name="media_source" id="media_source" class="form-select" required>
                                    <option value="" selected disabled>{{ __('label.select_type') }}</option>
                                    <option value="link" @selected(old('media_source') == 'link')>{{ __('label.link') }}</option>
                                    <option value="fileupload" @selected(old('media_source') == 'fileupload')>{{ __('label.file') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-12" id="link_field" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label" for="link">{{ __('label.link') }}</label>
                                <input type="url" id="link" name="link" value="{{ old('link') }}"
                                    class="form-control" placeholder="{{ __('label.link') }}" />
                            </div>
                        </div>

                        <div class="col-md-12 col-12" id="file_field" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label" for="media_file">{{ __('label.file') }}</label>
                                <input type="file" id="media_file" name="media_file" class="form-control"
                                    accept="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
                        {{ __('action.save') }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    @push('js')
        <x-dashboard.scripts.select2-img-option id="user_id" />
        <x-dashboard.scripts.select2-img-option id="channel_id" />

        <script>
            $(document).ready(function() {
                // Load channels and seasons when podcaster is selected
                $('#user_id').on('change', function() {
                    const podcasterId = $(this).val();
                    const channelSelect = $('#channel_id');
                    const seasonSelect = $('#season_id');

                    channelSelect.empty().append('<option value="" selected disabled>{{ __('label.select_channel') }}</option>');
                    seasonSelect.empty().append('<option value="" selected disabled>{{ __('label.select_season') }}</option>');

                    if (podcasterId) {
                        $.ajax({
                            url: "{{ route('admin.exclusive-episodes.channelSeasons') }}",
                            type: 'GET',
                            data: {
                                podcaster_id: podcasterId
                            },
                            success: function(response) {
                                channelSelect.html(response.channel_options);
                                seasonSelect.html(response.season_options);
                                
                                // Reinitialize select2 after updating options
                                channelSelect.trigger('change');
                                seasonSelect.trigger('change');
                            },
                            error: function(xhr) {
                                console.error('Error loading channels and seasons:', xhr);
                            }
                        });
                    }
                });

                // Show/hide link or file field based on media_source
                $('#media_source').on('change', function() {
                    const mediaSource = $(this).val();
                    
                    if (mediaSource === 'link') {
                        // Hide file field first and remove required
                        $('#file_field').hide();
                        $('#media_file').prop('required', false).val('');
                        
                        // Show link field and add required
                        $('#link_field').show();
                        $('#link').prop('required', true);
                    } else if (mediaSource === 'fileupload') {
                        // Hide link field first and remove required
                        $('#link_field').hide();
                        $('#link').prop('required', false).val('');
                        
                        // Show file field and add required
                        $('#file_field').show();
                        $('#media_file').prop('required', true);
                    } else {
                        // Hide both and remove required
                        $('#link_field').hide();
                        $('#file_field').hide();
                        $('#link').prop('required', false);
                        $('#media_file').prop('required', false);
                    }
                });

                // Update file accept attribute based on media_type
                $('#media_type').on('change', function() {
                    const mediaType = $(this).val();
                    const fileInput = $('#media_file');
                    if (mediaType === 'video') {
                        fileInput.attr('accept', '.mp4,.avi,.mov,.wmv,.flv,.webm');
                    } else if (mediaType === 'audio') {
                        fileInput.attr('accept', '.mp3,.wav,.ogg,.aac,.m4a');
                    }
                });

                // Show/hide fields based on current values on page load
                const currentMediaSource = $('#media_source').val();
                if (currentMediaSource === 'link') {
                    $('#link_field').show();
                    $('#file_field').hide();
                    $('#link').prop('required', true);
                    $('#media_file').prop('required', false);
                } else if (currentMediaSource === 'fileupload') {
                    $('#link_field').hide();
                    $('#file_field').show();
                    $('#link').prop('required', false);
                    $('#media_file').prop('required', true);
                }
                
                // Trigger change for media_type to set accept attribute
                $('#media_type').trigger('change');

                // Image preview
                $('#image').on('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#image_preview').attr('src', e.target.result).show();
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Remove required from hidden fields before form submission
                $('#episode_form').on('submit', function(e) {
                    // Always remove required from hidden fields before validation
                    // This must happen synchronously before browser validation
                    const linkField = $('#link_field');
                    const fileField = $('#file_field');
                    
                    if (linkField.is(':hidden') || linkField.css('display') === 'none') {
                        $('#link').removeAttr('required');
                    }
                    if (fileField.is(':hidden') || fileField.css('display') === 'none') {
                        $('#media_file').removeAttr('required');
                    }
                });
            });
        </script>
    @endpush

    </x-dashboard.layout.master>

