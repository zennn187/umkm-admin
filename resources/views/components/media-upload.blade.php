{{-- Media Upload Component --}}
<div class="media-upload-section mb-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-images"></i> Upload Media
            </h5>
        </div>
        <div class="card-body">
            {{-- Dropzone Area --}}
            <div id="mediaDropzone" class="dropzone mb-4">
                <div class="dz-message">
                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                    <h5>Drop files here or click to upload</h5>
                    <p class="text-muted">Maximum file size: 5MB per file</p>
                    <p class="text-muted">Supported: JPG, PNG, PDF, DOC, XLS</p>
                </div>
            </div>

            {{-- Upload Progress --}}
            <div id="uploadProgress" class="progress mb-3 d-none">
                <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                    role="progressbar" style="width: 0%">0%</div>
            </div>

            {{-- Uploaded Files Preview --}}
            <div id="uploadedFiles" class="row mt-4">
                @if (isset($existingMedia) && $existingMedia->count() > 0)
                    @foreach ($existingMedia as $media)
                        <div class="col-md-3 col-sm-4 col-6 mb-3 media-item" data-id="{{ $media->media_id }}">
                            <div class="card h-100 position-relative">
                                @if (strpos($media->mime_type, 'image/') === 0)
                                    <img src="{{ $media->file_url }}" class="card-img-top" alt="{{ $media->caption }}"
                                        style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                        style="height: 150px;">
                                        <div class="text-center">
                                            <i class="fas fa-file fa-3x text-secondary"></i>
                                            <p class="mt-2 mb-0 small">{{ $media->extension }}</p>
                                        </div>
                                    </div>
                                @endif



                                <div class="card-body p-2">
                                    <textarea name="captions[{{ $media->media_id }}]" class="form-control form-control-sm mb-2 caption-input" rows="2"
                                        placeholder="Caption">{{ $media->caption }}</textarea>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input type="radio" name="featured_image" value="{{ $media->media_id }}"
                                                id="featured_{{ $media->media_id }}"
                                                class="form-check-input featured-radio"
                                                {{ $media->sort_order == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="featured_{{ $media->media_id }}">
                                                Utama
                                            </label>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-danger delete-media"
                                            data-id="{{ $media->media_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="media_order[]" value="{{ $media->media_id }}">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Hidden Inputs --}}
            <input type="hidden" name="uploaded_files" id="uploadedFilesInput">
            <input type="hidden" name="deleted_files" id="deletedFilesInput" value="[]">
        </div>
    </div>
</div>

@push('styles')
    <style>
        .dz-preview {
            margin: 10px;
        }

        .dz-image {
            border-radius: 10px;
        }

        .dz-success-mark,
        .dz-error-mark {
            display: none;
        }

        .media-item {
            transition: transform 0.2s;
        }

        .media-item:hover {
            transform: translateY(-5px);
        }

        .caption-input {
            font-size: 12px;
            resize: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Initialize Dropzone
        Dropzone.autoDiscover = false;

        $(document).ready(function() {
            let uploadedFiles = [];
            let deletedFiles = [];

            // Initialize Dropzone
            const mediaDropzone = new Dropzone("#mediaDropzone", {
                url: "{{ route('media.upload') }}",
                paramName: "file",
                maxFilesize: 5, // MB
                maxFiles: 10,
                acceptedFiles: "image/*,.pdf,.doc,.docx,.xls,.xlsx",
                addRemoveLinks: true,
                dictDefaultMessage: "<i class='fas fa-cloud-upload-alt fa-3x text-primary mb-3'></i><h5>Drop files here or click to upload</h5>",
                dictRemoveFile: "Hapus",
                dictCancelUpload: "Batal",
                dictFileTooBig: "File terlalu besar ({{ maxFileSize }}MB).",
                dictInvalidFileType: "Tipe file tidak didukung.",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function() {
                    this.on("addedfile", function(file) {
                        // Show progress bar
                        $('#uploadProgress').removeClass('d-none');
                    });

                    this.on("sending", function(file, xhr, formData) {
                        // Add ref_table and ref_id for new items
                        formData.append("ref_table", "{{ $refTable ?? 'umkm' }}");
                        formData.append("ref_id", "{{ $refId ?? '0' }}");
                    });

                    this.on("success", function(file, response) {
                        if (response.success) {
                            // Add to uploaded files array
                            uploadedFiles.push({
                                id: response.data.media_id,
                                name: response.data.file_name,
                                path: response.data.file_path,
                                mime_type: response.data.mime_type,
                                caption: ''
                            });

                            // Update hidden input
                            $('#uploadedFilesInput').val(JSON.stringify(uploadedFiles));

                            // Add to preview
                            addMediaToPreview(response.data);

                            // Remove from dropzone
                            this.removeFile(file);
                        }
                    });

                    this.on("complete", function(file) {
                        // Update progress
                        const progress = Math.round((this.uploadProgress * 100) / this.files
                            .length);
                        $('#uploadProgressBar').css('width', progress + '%').text(progress +
                            '%');

                        if (progress === 100) {
                            setTimeout(() => {
                                $('#uploadProgress').addClass('d-none');
                                $('#uploadProgressBar').css('width', '0%').text('0%');
                            }, 1000);
                        }
                    });

                    this.on("queuecomplete", function() {
                        // Hide progress when all files uploaded
                        setTimeout(() => {
                            $('#uploadProgress').addClass('d-none');
                            $('#uploadProgressBar').css('width', '0%').text('0%');
                        }, 1000);
                    });
                }
            });

            // Function to add media to preview
            function addMediaToPreview(media) {
                const isImage = media.mime_type.startsWith('image/');
                const html = `
                <div class="col-md-3 col-sm-4 col-6 mb-3 media-item" data-id="${media.media_id}">
                    <div class="card h-100">
                        ${isImage ?
                            `<img src="${media.file_url}" class="card-img-top" alt="${media.caption}" style="height: 150px; object-fit: cover;">` :
                            `<div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <div class="text-center">
                                        <i class="fas fa-file fa-3x text-secondary"></i>
                                        <p class="mt-2 mb-0 small">${media.extension}</p>
                                    </div>
                                </div>`
                        }
                        <div class="card-body p-2">
                            <textarea name="new_captions[${media.media_id}]"
                                      class="form-control form-control-sm mb-2 caption-input"
                                      rows="2"
                                      placeholder="Caption">${media.caption || ''}</textarea>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="radio"
                                           name="featured_image"
                                           value="${media.media_id}"
                                           id="featured_${media.media_id}"
                                           class="form-check-input featured-radio">
                                    <label class="form-check-label small" for="featured_${media.media_id}">
                                        Utama
                                    </label>
                                </div>

                                <button type="button"
                                        class="btn btn-sm btn-danger delete-media"
                                        data-id="${media.media_id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="media_order[]" value="${media.media_id}">
                    </div>
                </div>
            `;

                $('#uploadedFiles').append(html);

                // Initialize sortable after adding new item
                initSortable();
            }

            // Delete media handler
            $(document).on('click', '.delete-media', function() {
                const mediaId = $(this).data('id');
                const mediaItem = $(this).closest('.media-item');

                if (confirm('Apakah Anda yakin ingin menghapus media ini?')) {
                    // If it's a newly uploaded file (not saved to DB yet)
                    if (uploadedFiles.some(file => file.id === mediaId)) {
                        uploadedFiles = uploadedFiles.filter(file => file.id !== mediaId);
                        $('#uploadedFilesInput').val(JSON.stringify(uploadedFiles));
                    } else {
                        // If it's an existing file from DB
                        deletedFiles.push(mediaId);
                        $('#deletedFilesInput').val(JSON.stringify(deletedFiles));
                    }

                    // Remove from DOM
                    mediaItem.remove();

                    // Show message
                    showToast('Media berhasil dihapus', 'success');
                }
            });

            // Featured radio handler
            $(document).on('change', '.featured-radio', function() {
                $('.featured-radio').not(this).prop('checked', false);
            });

            // Initialize Sortable for media ordering
            function initSortable() {
                const el = document.getElementById('uploadedFiles');
                if (el) {
                    Sortable.create(el, {
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        handle: '.card',
                        onEnd: function(evt) {
                            // Update order inputs
                            $('.media-item').each(function(index) {
                                const mediaId = $(this).data('id');
                                $(this).find('input[name="media_order[]"]').val(mediaId);
                            });
                        }
                    });
                }
            }

            // Initialize sortable on page load
            initSortable();

            // Form submission handler
            $('form').on('submit', function(e) {
                // Update hidden inputs
                $('#uploadedFilesInput').val(JSON.stringify(uploadedFiles));
                $('#deletedFilesInput').val(JSON.stringify(deletedFiles));

                // Validate at least one featured image if there are images
                const hasImages = $('.media-item').length > 0;
                const hasFeatured = $('.featured-radio:checked').length > 0;

                if (hasImages && !hasFeatured) {
                    e.preventDefault();
                    alert('Pilih salah satu gambar sebagai gambar utama (featured)');
                    return false;
                }
            });

            // Toast notification
            function showToast(message, type = 'success') {
                const toast = $(`
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `);

                $('.toast-container').remove();
                $('body').append('<div class="toast-container position-fixed top-0 end-0 p-3"></div>');
                $('.toast-container').append(toast);

                const bsToast = new bootstrap.Toast(toast[0]);
                bsToast.show();
            }
        });
    </script>
@endpush
