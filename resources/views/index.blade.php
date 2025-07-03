@extends('layouts.management.app')
@section('content')
    <style>
        .tabloid-card-fixed {
            width: 300px;
            min-width: 300px;
            max-width: 300px;
        }

        /* Paksa font-size kecil untuk semua isi preview tabloid */
        /* .tabloid-preview .content-text * {
                                                        font-size: 12px !important;
                                                        line-height: 1.1 !important;
                                                    } */
    </style>
    <div class="card">
        <h5 class="card-header">List Tabloid</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4 tabloid-card-fixed">
                    <form action="{{ url('/tabloids') }}" method="POST" id="form-common">
                        <button type="submit" class="text-decoration-none btn p-0 w-100 h-100"
                            style="background: none; border: none;">
                            <div class="card h-100 shadow-sm d-flex align-items-center justify-content-center"
                                style="min-height: 446px;">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <span class="display-4 text-primary">
                                            <i class="fas fa-plus-circle"></i>
                                        </span>
                                    </div>
                                    <h6 class="card-title mb-0 text-primary">Buat Baru Tabloid</h6>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
                @foreach ($tabloids as $tabloid)
                    <div class="col-md-3 mb-4 tabloid-card-fixed">
                        <div class="card h-100 shadow-sm">
                            <div
                                class="tabloid-preview-container d-flex justify-content-center align-items-center mt-3 mb-2">
                                @php
                                    $page = $tabloid->pages[0] ?? null;
                                    $layouts = $page ? $page->data : [];
                                    // Ukuran asli A4 grid (misal 360x508px, 10px/grid)
                                    $fullW = 360;
                                    $fullH = 508;
                                    $scale = 0.5;
                                @endphp
                                <div
                                    style="width:{{ $fullW * $scale }}px;height:{{ $fullH * $scale }}px;overflow:hidden;position:relative;">
                                    <div class="tabloid-preview"
                                        style="width:{{ $fullW }}px;height:{{ $fullH }}px;transform:scale({{ $scale }});transform-origin:top left;position:relative;background:#f8f9fa;border:1px solid #ddd;overflow:hidden;">
                                        @if ($layouts)
                                            @foreach ($layouts as $layout)
                                                <div class="draggable-layout"
                                                    style="position:absolute;left:{{ $layout->colStart * 10 }}px;top:{{ $layout->rowStart * 12.7 }}px;width:{{ $layout->spanCols * 10 }}px;height:{{ $layout->spanRows * 12.7 }}px;">
                                                    @if (isset($layout->content) && !empty($layout->content))
                                                        <div class="inner-layout-box"
                                                            style="width:100%;height:100%;overflow:hidden;">
                                                            @if (($layout->content->type ?? null) === 'text')
                                                                <div class="content-text"
                                                                    style="font-size:12px;line-height:1.1;width:100%;height:100%;overflow:hidden;">
                                                                    {!! $layout->content->html ?? '' !!}</div>
                                                            @elseif (($layout->content->type ?? null) === 'image')
                                                                <img class="content-image"
                                                                    src="{{ asset($layout->content->src ?? '') }}"
                                                                    alt=""
                                                                    style="width:100%;height:100%;object-fit:fit;display:block;" />
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex">
                                    <h6 spellcheck="false" class="card-title py-2 px-1 editable-title" id="tabloid-title"
                                        data-id="{{ $tabloid->id }}">
                                        {{ $tabloid->title }}</h6>
                                    <span><i class='bx bx-edit'></i> </span>
                                </div>
                                <p class="card-text text-muted mb-2" style="font-size: 0.9rem;">
                                    {{ Str::limit($tabloid->description, 60) }}</p>
                                <a href="{{ route('tabloid.export', $tabloid->id) }}"
                                    class="btn btn-sm btn-primary mt-auto mb-2">Preview</a>
                                <a href="{{ route('tabloid.edit', $tabloid->id) }}"
                                    class="btn btn-sm btn-primary mt-auto">Buka Editor</a>
                                <a href="javascript:void(0);" onclick="_delete_data(this)" data-id="{{ $tabloid->id }}"
                                    data-uri="{{ route('tabloid.destroy', [$tabloid->id]) }}"
                                    class="btn btn-sm btn-danger mt-2">Delete <i class="bx bx-trash me-1"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            $(document).ready(() => {
                $('.card-title#tabloid-title').each(function() {
                    const $title = $(this);
                    $title.attr('contenteditable', true);
                    $title.css('cursor', 'text');

                    let oldTitle = $title.text().trim();

                    $title.on('focus', function() {
                        oldTitle = $title.text().trim();
                    });

                    $title.on('blur', function() {
                        const newTitle = $title.text().trim();
                        const tabloidId = $title.data('id');
                        if (newTitle === oldTitle) return; // Tidak ada perubahan
                        $.ajax({
                            url: `/tabloids/${tabloidId}/update-title`,
                            method: 'PUT',
                            data: {
                                title: newTitle,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                // Optionally show a success message
                                if (res.error == false) {
                                    Swal.fire("Updated!", res.message, "success");
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },
                            error: function(res) {
                                Swal.fire("Error", "Terjadi kesalahan silahkan coba lagi",
                                    "error");
                            }
                        });
                    });

                    $title.on('keydown', function(e) {
                        if (e.key === 'Escape') {
                            e.preventDefault();
                            $title.text(oldTitle);
                            $title.blur();
                        } else if (e.key === 'Enter') {
                            e.preventDefault();
                            $title.blur();
                        }
                    });
                });
            })

            $(document).on('keypress', '.editable-title', function(e) {
                if (e.which == 13) { // 13 is the Enter key code
                    e.preventDefault(); // Prevent new line
                    $(this).blur(); // Trigger blur event to save
                }
            });
        </script>
    @endsection
