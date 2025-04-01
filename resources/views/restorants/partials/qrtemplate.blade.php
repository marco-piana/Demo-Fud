{{-- Brij Negi Update --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
    }

    .image-item {
        position: relative;
    }

    .image-item img {
        width: 100%;
        height: auto;
        display: block;
    }

    .delete-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: red;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        padding: 5px;
    }

    #loading {
        text-align: center;
        margin-top: 20px;
    }
</style>
<div class="card card-profile bg-secondary shadow">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{ __('QR Template') }}</h3>
            </div>
            <div class="col-4 text-right">
                <button id="zipButton" class="btn btn-sm btn-info">
                    <i class="fas fa-file-archive"></i> {{ __('Zip Images') }}
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form id="imageUploadForm" enctype="multipart/form-data" class="mb-4">
            <div class="form-group">
                <label for="image" class="form-label">Select Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
                <input type="hidden" id="restaurant_id" value="{{ $restorant->id }}">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload"></i> {{ __('Upload') }}
            </button>
        </form>
        <hr>
        <div class="image-grid row" id="imagesContainer">
        </div>
        <div id="loading" class="text-center text-muted mt-3">
            {{ __('Loading...') }}
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const restaurantId = {{ $restorant->id }};
    let currentPage = 1;
    let loading = false;

    function fetchImages(page = 1) {
        if (loading) return;
        loading = true;
        console.log('Fetching images for page:', page);
        $('#loading').text('Loading...');

        $.ajax({
            type: 'GET',
            url: '{{ route('qrtemplate.image.fetch') }}',
            data: {
                page: page,
                restaurant_id: restaurantId
            },
            success: function(response) {
                console.log('Server Response:', response);

                if (!response.images) {
                    console.error('No images key in the response.');
                    $('#loading').text('No images found.');
                    loading = false;
                    return;
                }

                if (response.images.length === 0 && page === 1) {
                    $('#loading').text('No images found.');
                } else if (response.images.length === 0) {
                    $('#loading').text('No more images to load.');
                } else {
                    let imagesHtml = '';
                    response.images.forEach(image => {
                        imagesHtml += `
                        <div class="image-item">
                            <img src="${image.url}" alt="{{ __('Uploaded Image') }}">
                            <button class="delete-btn" onclick="deleteImage(${image.id})">{{ __('Delete') }}</button>
                        </div>
                    `;
                    });
                    $('#imagesContainer').append(imagesHtml);
                    $('#loading').text('');
                }
                loading = false;
            },
            error: function(error) {
                console.error('AJAX Request Error:', error);
                alert('Failed to fetch images!');
                $('#loading').text('Error loading images.');
                loading = false;
            }
        });
    }

    $('#imageUploadForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData();

        formData.append('image', $('#image')[0].files[0]);
        formData.append('restaurant_id', restaurantId);

        $.ajax({
            type: 'POST',
            url: '{{ route('qrtemplate.image.upload') }}',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Image Uploaded',
                    text: response.message,
                });

                $('#imageUploadForm')[0].reset();
                $('#imagesContainer').empty();
                currentPage = 1;
                fetchImages(currentPage);
                toggleZipButton();
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: 'Something went wrong. Please try again.',
                });
                console.error(error);
            }
        });
    });

    function deleteImage(imageId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route('qrtemplate.image.delete') }}',
                    data: {
                        id: imageId,
                        restaurant_id: restaurantId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Your image has been deleted.',
                        });

                        $('#imagesContainer').empty();
                        currentPage = 1;
                        fetchImages(currentPage);
                        toggleZipButton();
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Delete Failed',
                            text: 'Could not delete the image. Please try again.',
                        });
                        console.error(error);
                    }
                });
            }
        });
    }

    $('#zipButton').on('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will zip all images for the restaurant!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Zip it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/qrtemplate/${restaurantId}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Success', response.message, 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message ||
                            'Failed to zip images.', 'error');
                    }
                });
            }
        });
    });

    // function toggleZipButton() {
    //     if ($('#imagesContainer .image-item').length > 0) {
    //         $('#zipButton').removeClass('d-none'); // Show button
    //     } else {
    //         $('#zipButton').addClass('d-none'); // Hide button
    //     }
    // }

    function refreshImages() {
        toggleZipButton();
    }

    $(document).ready(() => refreshImages());

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
            currentPage++;
            fetchImages(currentPage);
        }
    });
    fetchImages(currentPage);
</script>
