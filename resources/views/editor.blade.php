<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tabloid->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #f0f2f5;
        }

        .editor-container {
            display: flex;
            width: 100%;
            height: 100%;
        }

        .sidebar {
            width: 250px;
            background-color: #34495e;
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            flex-shrink: 0;
        }

        .sidebar h3 {
            margin-top: 0;
            color: #ecf0f1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .layout-palette,
        .content-palette {
            margin-bottom: 30px;
        }

        .layout-template,
        .content-template {
            background-color: #2c3e50;
            color: white;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            cursor: grab;
            transition: background-color 0.2s ease;
            text-align: center;
            border: 1px dashed #7f8c8d;
        }

        .layout-template:hover,
        .content-template:hover {
            background-color: #3a536b;
        }

        .layout-template:active,
        .content-template:active {
            cursor: grabbing;
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: auto;
            padding: 20px;
        }

        .paper-canvas {
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            /* penting */
            border: 1px solid #ccc;
            overflow: hidden;
            /* Tambahkan agar tidak pernah mengecil/membesar */
            /* width: 210mm;
            height: 297mm;
            min-width: 210mm;
            min-height: 297mm;
            max-width: 210mm;
            max-height: 297mm; */
        }

        .paper-canvas.a4-landscape {
            width: 297mm;
            height: 210mm;
            min-width: 297mm;
            min-height: 210mm;
            max-width: 297mm;
            max-height: 210mm;
        }

        .paper-canvas.a4-portrait {
            margin-top: 200px;
            width: 210mm;
            height: 297mm;
            min-width: 210mm;
            min-height: 297mm;
            /* max-width: 210mm;
            max-height: 297mm; */
        }

        .draggable-layout {
            position: absolute;
            /* penting agar .css(top,left) berfungsi */
        }

        .grid-stack-item-content {
            background-color: #ecf0f1;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-sizing: border-box;
            color: #333;
            font-size: 0.9em;
            position: relative;
        }

        .inner-layout-box {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed rgba(0, 123, 255, 0.4);
            border-radius: 3px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.6);
            /* padding: 10px; */
            overflow-y: auto;
        }

        .inner-layout-box.highlight-dropzone {
            border-color: #007bff;
            background-color: rgba(0, 123, 255, 0.1);
        }

        .content-text,
        .content-image {
            display: block;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #fff;
            border: none;
            border-radius: 0;
            box-sizing: border-box;
            word-break: break-word;
            overflow: auto;
        }

        .content-text {
            overflow: hidden;
            font-size: 0.9em;
            color: #555;
        }

        .content-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: fill;
        }

        .content-placeholder {
            color: #888;
            font-style: italic;
            font-size: 0.9em;
            text-align: center;
        }

        .cke_warning,
        .cke_notifications_area {
            display: none !important;
        }
    </style>
</head>

<body>
    <div class="editor-container">
        <div class="sidebar">
            <h3>Palet Layout</h3>
            <div class="layout-palette">
                <div class="layout-template" data-w="100" data-h="120">Layout Baru</div>
                {{-- <div class="layout-template" data-w="150" data-h="120">Layout Setengah</div> --}}
                {{-- <div class="layout-template" data-w="100" data-h="120">Layout Sepertiga</div> --}}
            </div>
            <h3>Palet Konten</h3>
            <div class="content-palette">
                {{-- <div class="content-template" data-content-type="title">Judul</div> --}}
                <div class="content-template" data-content-type="text">Teks</div>
                <div class="content-template" data-content-type="image">Gambar</div>
            </div>
            {{-- <button id="save-layout" class="btn btn-primary mt-3">Simpan Layout</button> --}}
            <button id="save-all" class="btn btn-primary mb-2">Simpan semua halaman</button>
            {{-- <button id="load-layout" class="btn btn-info mt-2">Muat Layout</button>
            <button id="load-all-page" class="btn btn-info mt-2">Muat semua halaman</button> --}}
            <h3>Navigasi</h3>
            <div class="page-navigation">
                <div class="input-group mb-2">
                    <button id="prev-page" class="btn btn-secondary btn-sm">‹</button>
                    <select id="page-select" class="form-select form-select-sm mx-2" style="max-width:110px;"></select>
                    <button id="next-page" class="btn btn-secondary btn-sm">›</button>
                </div>
                <button id="add-page" class="btn btn-primary btn-sm w-100 mb-2">Tambah Halaman Baru</button>
            </div>
            <h3>Template</h3>
            <div class="template">
                <select id="template-select" class="form-select form-select-sm mb-2"></select>
                <button id="open-modal-simpan-template" class="btn btn-primary mb-2">Simpan sebagai template</button>
                {{-- <button id="open-modal-pilih-template" class="btn btn-info btn-sm w-100 mb-2">Pilih Template</button> --}}
            </div>
            {{-- <a href="/">Ke Gridstack</a> --}}
        </div>
        <div class="main-content">
            <div class="paper-canvas a4-portrait" id="canvas"></div>
        </div>
        <div class="sidebar editor-sidebar" id="editor-sidebar"
            style="width:350px; background:#f8f9fa; color:#222; border-left:1px solid #ddd; display:none; position:relative;">
            <button id="close-editor"
                style="position:absolute;top:8px;right:8px;font-size:18px;background:none;border:none;cursor:pointer;">✖</button>
            <h3 style="color:#222;">Editor Konten</h3>
            <div id="editor-action"></div>
            <textarea id="ckeditor-area"></textarea>
            <div id="editor-info" style="font-size:0.9em; color:#888; margin-top:10px;"></div>
        </div>
    </div>

    <!-- Modal Save as Template -->
    <div class="modal fade" id="modalSimpanTemplate" tabindex="-1" aria-labelledby="modalSimpanTemplateLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <form id="form-save-template" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSimpanTemplateLabel">Simpan Halaman Sebagai Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="input-template-name" class="form-control" placeholder="Nama Template"
                        required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        $(function() {
            // Inisialisasi CKEditor
            CKEDITOR.replace('ckeditor-area');
            const editor = CKEDITOR.instances['ckeditor-area'];
            let selectedBox = null,
                selectedType = null;

            // Tampilkan/hide editor-sidebar
            function showEditorSidebar() {
                $('#editor-sidebar').show();
            }

            function hideEditorSidebar() {
                $('#editor-sidebar').hide();
                selectedBox = null;
                selectedType = null;
                editor.setData('');
                $('#editor-action').html('');
                $('#editor-info').text('');
            }
            $('#close-editor').on('click', hideEditorSidebar);

            // Fungsi reusable untuk melampirkan event handler klik ke elemen konten
            function attachContentClickHandlers($contentElement, type) {
                $contentElement.on('click', e => {
                    e
                        .stopPropagation(); // Hentikan propagasi agar tidak memicu handler layout atau document
                    selectedBox = $contentElement;
                    selectedType = type;
                    showEditorSidebar();

                    if (type === 'text' || type === 'title') {
                        $('#ckeditor-area').show();
                        editor.setData($contentElement.html());
                        $('#editor-info').text(`Mengedit: ${selectedType.toUpperCase()}`);
                        $('#editor-action').html(`
                            <button id="delete-layout" class="btn btn-danger btn-sm mb-2">Hapus Layout</button>
                            <button id="delete-content" class="btn btn-warning btn-sm mb-2 ms-2">Hapus Konten</button>
                        `);
                    } else if (type === 'image') {
                        $('#ckeditor-area').hide(); // CKEditor tidak untuk gambar
                        $('#editor-info').text(
                            `Mengedit: ${selectedType.toUpperCase()} (Klik untuk ganti URL gambar)`);
                        $('#editor-action').html(`
                            <button id="delete-layout" class="btn btn-danger btn-sm mb-2">Hapus Layout</button>
                            <button id="delete-content" class="btn btn-warning btn-sm mb-2 ms-2">Hapus Konten</button>
                            <input type="text" id="image-url-input" class="form-control mt-2" placeholder="URL Gambar Baru" value="${selectedBox.attr('src')}">
                            <button id="update-image-url" class="btn btn-success btn-sm mt-2">Perbarui Gambar</button>
                        `);
                    }
                });
            }

            // Hapus semua handler klik sebelumnya pada .draggable-layout yang umum
            // dan ganti dengan pendekatan yang lebih spesifik
            $(document).off('click', '.draggable-layout'); // Hapus handler lama

            // Event delegation untuk klik pada area kosong inner-layout-box atau placeholder
            // Ini akan memilih layout box itu sendiri jika tidak ada konten yang diklik.
            $(document).on('click', '.inner-layout-box, .content-placeholder', function(e) {
                e.stopPropagation(); // Hentikan propagasi agar tidak memicu event di parent

                let $layout = $(this).closest('.draggable-layout');
                selectedBox = $layout;
                selectedType = 'layout';
                showEditorSidebar();
                $('#ckeditor-area').hide(); // Sembunyikan CKEditor jika hanya layout yang dipilih
                $('#editor-info').text('Layout terpilih.');
                $('#editor-action').html(
                    '<button id="delete-layout" class="btn btn-danger btn-sm mb-2">Hapus Layout</button>'
                );
            });


            // Handler untuk update URL gambar
            $(document).on('click', '#update-image-url', function() {
                if (selectedBox && selectedType === 'image') {
                    const newUrl = $('#image-url-input').val();
                    if (newUrl) {
                        selectedBox.attr('src', newUrl);
                        selectedBox.attr('alt', 'Gambar dari URL baru');
                        saveCurrentPage();
                        alert('URL Gambar diperbarui!');
                    } else {
                        alert('Masukkan URL gambar yang valid.');
                    }
                }
            });

            // Hapus layout
            $(document).on('click', '#delete-layout', function() {
                if (selectedBox) {
                    // Jika yang terpilih konten, hapus parent layout
                    let $layout = selectedBox.hasClass('draggable-layout') ? selectedBox : selectedBox
                        .closest('.draggable-layout');
                    $layout.remove();
                    hideEditorSidebar();
                    saveCurrentPage(); // Simpan perubahan setelah menghapus layout
                }
            });

            // Hapus konten
            $(document).on('click', '#delete-content', function() {
                if (selectedBox && (selectedType === 'text' || selectedType === 'image' || selectedType ===
                        'title')) {
                    let $layout = selectedBox.closest('.draggable-layout');
                    selectedBox.remove();
                    // Jika layout kosong, tambahkan placeholder
                    if ($layout.find('.content-text, .content-title, .content-image').length === 0) {
                        $layout.find('.inner-layout-box').append(
                            '<div class="content-placeholder">Drop Konten Di Sini</div>');
                    }
                    saveCurrentPage(); // Simpan perubahan setelah menghapus konten
                    hideEditorSidebar();
                }
            });

            // Sembunyikan editor jika klik di luar layout/konten/editor
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.draggable-layout, #editor-sidebar').length) {
                    hideEditorSidebar();
                }
            });

            const COLS = 36;
            const ROWS = 40;
            const $canvas = $('#canvas');
            const canvasW = $canvas[0].clientWidth;
            const canvasH = $canvas[0].clientHeight;
            const colWidth = canvasW / COLS;
            const rowHeight = canvasH / ROWS;

            let currentPageId = 1;
            let loadedPagesData = {};
            let loadedTemplates = [];

            // unique id
            let layoutIdCounter = 0; // Inisialisasi counter

            function snapClampCols(ui, $el) {
                // posisi kiri snapped ke kelipatan kolom
                let colStart = Math.round(ui.position.left / colWidth);
                colStart = Math.max(0, Math.min(COLS - 1, colStart));

                let spanCols = Math.round($el.outerWidth() / colWidth);
                spanCols = Math.max(1, Math.min(COLS - colStart, spanCols));

                // terapkan
                const leftPX = colStart * colWidth;
                const widthPX = spanCols * colWidth;

                $el.css({
                    left: leftPX,
                    width: widthPX
                });

                // kalau resize: dihitung ulang spanCols lalu clamp height seperti biasa
                if (ui.size) {
                    let newSpan = Math.round(ui.size.width / colWidth);
                    newSpan = Math.max(1, Math.min(COLS - colStart, newSpan));
                    $el.css('width', newSpan * colWidth);
                }
            }

            function snapClampRows(ui, $el) {
                // posisi atas snapped ke kelipatan row
                let rowStart = Math.round(ui.position.top / rowHeight);
                rowStart = Math.max(0, Math.min(ROWS - 1, rowStart));
                let spanRows = Math.round($el.outerHeight() / rowHeight);
                spanRows = Math.max(1, Math.min(ROWS - rowStart, spanRows));
                const topPX = rowStart * rowHeight;
                const heightPX = spanRows * rowHeight;
                $el.css({
                    top: topPX,
                    height: heightPX
                });
                // kalau resize: dihitung ulang spanRows
                if (ui.size) {
                    let newSpan = Math.round(ui.size.height / rowHeight);
                    newSpan = Math.max(1, Math.min(ROWS - rowStart, newSpan));
                    $el.css('height', newSpan * rowHeight);
                }
            }


            // Draggable layout
            $('.layout-template').draggable({
                helper: 'clone',
                revert: 'invalid',
                appendTo: 'body',
                zIndex: 100,
                start(e, ui) {
                    ui.helper.css('opacity', 0.7);
                }
            });

            // Drop ke canvas
            $('#canvas').droppable({
                accept: '.layout-template',
                drop(e, ui) {
                    const w = +ui.helper.data('w'),
                        h = +ui.helper.data('h'),
                        dropOff = $(this).offset(),
                        x = e.pageX - dropOff.left,
                        y = e.pageY - dropOff.top;

                    // Snap ke kolom terdekat
                    let colStart = Math.floor(x / colWidth);
                    colStart = Math.max(0, Math.min(COLS - 1, colStart));
                    let spanCols = Math.round(w / colWidth);
                    spanCols = Math.max(1, Math.min(COLS - colStart, spanCols));
                    const leftPX = colStart * colWidth;
                    const widthPX = spanCols * colWidth;

                    // Snap ke row terdekat
                    let rowStart = Math.floor(y / rowHeight);
                    rowStart = Math.max(0, Math.min(ROWS - 1, rowStart));
                    let spanRows = Math.round(h / rowHeight);
                    spanRows = Math.max(1, Math.min(ROWS - rowStart, spanRows));
                    const topPX = rowStart * rowHeight;
                    const heightPX = spanRows * rowHeight;

                    const layoutId = 'layout-' + Date.now() + '-' + (layoutIdCounter++);
                    const $layout = $('<div class="draggable-layout" id="' + layoutId + '"></div>').css({
                        position: 'absolute',
                        top: topPX,
                        left: leftPX,
                        width: widthPX,
                        height: heightPX
                    });
                    const $inner = $(
                        '<div class="inner-layout-box"><div class="content-placeholder">Drop Konten Di Sini</div></div>'
                    );
                    $layout.append($inner)
                        .draggable({
                            axis: false,
                            containment: '#canvas',
                            handle: '.inner-layout-box',
                            stop(e, ui) {
                                snapClampCols(ui, $(this));
                                snapClampRows(ui, $(this));
                                saveCurrentPage(); // Simpan setelah drag
                            }
                        })
                        .resizable({
                            handles: 'all', // tampilkan semua handle sudut dan sisi
                            containment: '#canvas',
                            minWidth: colWidth,
                            minHeight: rowHeight,
                            stop(e, ui) {
                                snapClampCols(ui, $(this));
                                snapClampRows(ui, $(this));
                                saveCurrentPage(); // Simpan setelah resize
                            }
                        });
                    $('#canvas').append($layout);

                    // Konten droppable
                    $inner.droppable({
                        accept: '.content-template',
                        hoverClass: 'highlight-dropzone',
                        drop(ev, uii) {
                            if ($inner.find('.content-text, .content-title, .content-image').length)
                                return;
                            $inner.find('.content-placeholder').remove();
                            const type = uii.helper.data('content-type');
                            let $newContent;
                            if (type === 'text') {
                                $newContent = $(
                                    '<div class="content-text" data-content-id="text-' + Date
                                    .now() + '">Ketik teks Anda di sini...</div>'
                                );
                            } else if (type === 'image') {
                                $newContent = $(
                                    '<img class="content-image" src="/image.png" alt="Gambar" data-content-id="image-' +
                                    Date.now() +
                                    '">' // Changed data-content-id prefix to 'image-'
                                );
                            } else if (type === 'title') { // Tambah untuk title jika ada
                                $newContent = $(
                                    '<div class="content-title" data-content-id="title-' + Date
                                    .now() + '">Judul Tabloid Baru</div>'
                                );
                            }

                            if ($newContent) {
                                $inner.append($newContent);
                                attachContentClickHandlers($newContent,
                                    type); // Panggil fungsi reusable
                                saveCurrentPage(); // Simpan setelah drop konten
                            }
                        }
                    });
                    saveCurrentPage(); // Simpan setelah drop layout
                }
            });

            // Draggable konten
            $('.content-template').draggable({
                helper: 'clone',
                revert: 'invalid',
                appendTo: 'body',
                zIndex: 100,
                start(e, ui) {
                    ui.helper.css('opacity', 0.7);
                }
            });

            // Edit via delegation (CKEditor)
            editor.on('change', () => {
                if (selectedBox && (selectedType === 'text' || selectedType === 'title')) {
                    selectedBox.html(editor.getData());
                }
                saveCurrentPage(); // Simpan setelah perubahan editor
            });

            function saveCurrentPage() {
                const layoutData = [];
                $('.draggable-layout').each(function() {
                    const $layout = $(this);
                    const layoutId = $layout.attr('id');
                    const position = $layout.position(); // Mendapatkan top dan left relatif terhadap parent
                    const width = $layout.outerWidth();
                    const height = $layout.outerHeight();

                    // Convert pixel positions and dimensions back to grid units
                    const colStart = Math.round(position.left / colWidth);
                    const rowStart = Math.round(position.top / rowHeight);
                    const spanCols = Math.round(width / colWidth);
                    const spanRows = Math.round(height / rowHeight);


                    const content = {}; // Objek untuk menyimpan detail konten
                    const $contentElement = $layout.find('.content-text, .content-title, .content-image');

                    if ($contentElement.length) {
                        const contentType = $contentElement.data('content-type') ||
                            ($contentElement.hasClass('content-text') ? 'text' :
                                $contentElement.hasClass('content-title') ? 'title' :
                                $contentElement.hasClass('content-image') ? 'image' : null);

                        content.type = contentType;
                        if (contentType === 'text' || contentType === 'title') {
                            content.html = $contentElement.html();
                        } else if (contentType === 'image') {
                            content.src = $contentElement.attr('src');
                            content.alt = $contentElement.attr('alt');
                        }
                    }

                    layoutData.push({
                        id: layoutId, // Simpan ID untuk referensi
                        colStart: colStart,
                        rowStart: rowStart,
                        spanCols: spanCols,
                        spanRows: spanRows,
                        content: content // Sertakan data konten
                    });
                });

                loadedPagesData[currentPageId] = layoutData; // Simpan data halaman saat ini

                console.log("Data halaman saat ini disimpan:", layoutData);
            }

            function saveAllPages() {
                saveCurrentPage();
                $.ajax({
                    url: '/tabloids/{{ $tabloid->id }}/editor',
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: JSON.stringify(loadedPagesData),
                    },
                    type: 'post',
                    beforeSend: function() {
                        loading = true;
                    },
                    success: function(response) {
                        console.log(response)
                    },
                    error: function(xhr) {
                        loading = false;
                    }
                })
                alert('semua halaman disimpan!');
            }

            function loadPage(pageId) {
                // 1. Simpan halaman yang sedang aktif sebelum berpindah
                if (currentPageId && $('#canvas').children().length > 0) {
                    saveCurrentPage();
                }

                currentPageId = pageId; // Update ID halaman aktif

                // 2. Bersihkan canvas
                $('#canvas').empty();

                const pageData = loadedPagesData[pageId];

                if (!pageData) {
                    console.log(`Tidak ada data untuk halaman: ${pageId}. Membuat halaman kosong.`);
                    $('#editor-info').text(`Halaman ${pageId} kosong.`);
                    hideEditorSidebar();
                    return; // Halaman kosong, tidak ada yang perlu dirender
                }

                pageData.forEach(item => {
                    // Konversi unit grid kembali ke piksel
                    const leftPX = item.colStart * colWidth;
                    const topPX = item.rowStart * rowHeight;
                    const widthPX = item.spanCols * colWidth;
                    const heightPX = item.spanRows * rowHeight;

                    const $layout = $('<div class="draggable-layout" id="' + item.id + '"></div>').css({
                        position: 'absolute',
                        top: topPX,
                        left: leftPX,
                        width: widthPX,
                        height: heightPX
                    });

                    const $inner = $('<div class="inner-layout-box"></div>');

                    if (item.content && item.content.type) {
                        let $content;
                        if (item.content.type === 'text') {
                            $content = $('<div class="content-text" data-content-id="text-' + Date.now() +
                                '">' + item.content.html + '</div>');
                        } else if (item.content.type === 'title') {
                            $content = $('<div class="content-title" data-content-id="title-' + Date.now() +
                                '">' + item.content.html + '</div>');
                        } else if (item.content.type === 'image') {
                            $content = $('<img class="content-image" src="' + item.content.src + '" alt="' +
                                item.content.alt + '" data-content-id="image-' + Date.now() + '">');
                        }
                        $inner.append($content);

                        attachContentClickHandlers($content, item.content.type); // Panggil fungsi reusable
                    } else {
                        $inner.append('<div class="content-placeholder">Drop Konten Di Sini</div>');
                    }

                    $layout.append($inner)
                        .draggable({
                            axis: false,
                            containment: '#canvas',
                            handle: '.inner-layout-box',
                            stop(e, ui) {
                                snapClampCols(ui, $(this));
                                snapClampRows(ui, $(this));
                                saveCurrentPage();
                            }
                        })
                        .resizable({
                            handles: 'all',
                            containment: '#canvas',
                            minWidth: colWidth,
                            minHeight: rowHeight,
                            stop(e, ui) {
                                snapClampCols(ui, $(this));
                                snapClampRows(ui, $(this));
                                saveCurrentPage();
                            }
                        });
                    $('#canvas').append($layout);

                    // Re-attach droppable for inner-layout-box
                    $inner.droppable({
                        accept: '.content-template',
                        hoverClass: 'highlight-dropzone',
                        drop(ev, uii) {
                            if ($inner.find('.content-text, .content-title, .content-image').length)
                                return;
                            $inner.find('.content-placeholder').remove();
                            const type = uii.helper.data('content-type');
                            let $newContent;
                            if (type === 'text') {
                                $newContent = $(
                                    '<div class="content-text">Ketik teks Anda di sini...</div>'
                                );
                            } else if (type === 'title') {
                                $newContent = $(
                                    '<div class="content-title">Judul Tabloid Baru</div>');
                            } else if (type === 'image') {
                                $newContent = $(
                                    '<img class="content-image" src="/image.png" alt="Gambar">');
                            }
                            if ($newContent) {
                                $inner.append($newContent);
                                attachContentClickHandlers($newContent,
                                    type); // Panggil fungsi reusable
                                saveCurrentPage();
                            }
                        }
                    });
                });
                $('#editor-info').text(`Halaman ${pageId} dimuat.`);
                hideEditorSidebar(); // Sembunyikan sidebar editor saat berpindah halaman
            }

            function loadTemplateList() {
                $.get('/tabloids/template', function(data) {
                    loadedTemplates = data;
                    const $sel = $('#template-select').empty();
                    $sel.append('<option value="">-- Pilih Template --</option>');
                    data.forEach(tpl => {
                        $sel.append(`<option value="${tpl.name}">${tpl.name}</option>`);
                    });
                })
            }

            function selectTemplate() {
                const name = this.value;
                if (!name) return;

                if (!loadedTemplates) return alert('Template belum dimuat!');
                const tpl = loadedTemplates.find(t => t.name === name);
                if (!tpl) return alert('Template tidak ditemukan!');

                if (!confirm(
                        'Memuat template akan menghapus semua layout yang ada di halaman saat ini. Lanjutkan?')) {
                    return;
                }

                $('#canvas').empty();
                hideEditorSidebar();

                const layouts = tpl.data || [];

                layouts.forEach(item => {
                    const leftPX = item.colStart * colWidth;
                    const topPX = item.rowStart * rowHeight;
                    const widthPX = item.spanCols * colWidth;
                    const heightPX = item.spanRows * rowHeight;

                    const layoutId = 'layout-' + Date.now() + '-' + (++layoutIdCounter); // Generate ID baru
                    const $box = $('<div class="draggable-layout"></div>')
                        .attr('id', layoutId)
                        .css({
                            position: 'absolute',
                            top: topPX,
                            left: leftPX,
                            width: widthPX,
                            height: heightPX,
                            'z-index': item.zIndex
                        });

                    const $inner = $(
                        '<div class="inner-layout-box"><div class="content-placeholder">Drop Konten Di Sini</div></div>'
                    );
                    $box.append($inner);


                    $canvas.append($box);

                    // Reaktifkan draggable & resizable
                    $box.draggable({
                        containment: '#canvas',
                        handle: '.inner-layout-box',
                        stop(e, ui) {
                            snapClampCols(ui, $(this));
                            snapClampRows(ui, $(this));
                            saveCurrentPage();
                        }
                    }).resizable({
                        handles: 'all',
                        containment: '#canvas',
                        minWidth: colWidth,
                        minHeight: rowHeight,
                        stop(e, ui) {
                            snapClampCols(ui, $(this));
                            snapClampRows(ui, $(this));
                            saveCurrentPage();
                        }
                    });

                    // Re-attach droppable for inner-layout-box
                    $inner.droppable({
                        accept: '.content-template',
                        hoverClass: 'highlight-dropzone',
                        drop(ev, uii) {
                            if ($inner.find('.content-text, .content-title, .content-image').length)
                                return;
                            $inner.find('.content-placeholder').remove();
                            const type = uii.helper.data('content-type');
                            let $newContent;
                            if (type === 'text') {
                                $newContent = $(
                                    '<div class="content-text">Ketik teks Anda di sini...</div>'
                                );
                            } else if (type === 'title') {
                                $newContent = $(
                                    '<div class="content-title">Judul Tabloid Baru</div>');
                            } else if (type === 'image') {
                                $newContent = $(
                                    '<img class="content-image" src="/image.png" alt="Gambar">');
                            }
                            if ($newContent) {
                                $inner.append($newContent);
                                attachContentClickHandlers($newContent,
                                    type); // Panggil fungsi reusable
                                saveCurrentPage();
                            }
                        }
                    });
                });
                saveCurrentPage(); // Simpan setelah memuat template
            }

            $('#template-select').on('change', selectTemplate);
            $('#save-all').off('click').on('click', saveAllPages);
            $('#save-layout').on('click', saveCurrentPage); // Menggunakan saveCurrentPage()
            // $('#load-layout').on('click', loadLayout);
            // $('#load-all-page').on('click', loadAllPages);

            $(document).ready(function() {
                $.ajax({
                    url: '/tabloids/{{ $tabloid->id }}/get-pages',
                    success: function(response) {
                        savedProject = response
                        if (savedProject) {
                            let arr = savedProject;
                            if (typeof arr === 'string') arr = JSON.parse(arr);
                            loadedPagesData = {};
                            arr.forEach(pageObj => {
                                if (pageObj.page_number) {
                                    loadedPagesData[parseInt(pageObj.page_number)] =
                                        pageObj.data || [];
                                }
                            });
                            const pageKeys = Object.keys(loadedPagesData).map(Number).sort((a,
                                b) => a - b);
                            if (pageKeys.length > 0) {
                                currentPageId = pageKeys[0];
                                loadPage(currentPageId);
                            } else {
                                loadedPagesData[1] = [];
                                loadPage(1);
                            }
                            // Inisialisasi pageCounter di sini!
                            pageCounter = pageKeys.length > 0 ? Math.max(...pageKeys) : 1;
                        } else {
                            loadedPagesData[1] = [];
                            loadPage(1);
                            pageCounter = 1;
                        }
                        loadTemplateList();
                        $('#current-page-display').text(` ${currentPageId}`);
                        afterPageChange();
                    }
                })
                // Update display saat awal
                $('#current-page-display').text(`${currentPageId}`);
                // Inisialisasi pageCounter berdasarkan halaman yang sudah ada
                pageCounter = Object.keys(loadedPagesData).length > 0 ?
                    Math.max(...Object.keys(loadedPagesData).map(Number)) :
                    1;
                afterPageChange();
            });


            let pageCounter = 1; // Akan diinisialisasi ulang di $(document).ready

            $('#prev-page').on('click', function() {
                const pageKeys = Object.keys(loadedPagesData).map(Number).sort((a, b) => a - b);
                const currentIndex = pageKeys.indexOf(currentPageId);
                if (currentIndex > 0) {
                    loadPage(pageKeys[currentIndex - 1]);
                    currentPageId = pageKeys[currentIndex - 1];
                    afterPageChange();
                } else {
                    alert('Ini adalah halaman pertama.');
                }
            });

            $('#next-page').on('click', function() {
                const pageKeys = Object.keys(loadedPagesData).map(Number).sort((a, b) => a - b);
                const currentIndex = pageKeys.indexOf(currentPageId);
                if (currentIndex < pageKeys.length - 1) {
                    loadPage(pageKeys[currentIndex + 1]);
                    currentPageId = pageKeys[currentIndex + 1];
                    afterPageChange();
                } else {
                    alert('Ini adalah halaman terakhir.');
                }
            });
            // Panggil updatePageSelect setiap kali halaman bertambah/berpindah
            function afterPageChange() {
                updatePageSelect();
                // $('#current-page-display').text(`Halaman ${parseInt(currentPageId.replace('page', ''))}`);
            }

            // Update pada load awal
            $(document).ready(function() {
                // ...existing code...
                afterPageChange();
            });

            $('#prev-page').on('click', function() {
                // ...existing code...
                afterPageChange();
            });
            $('#next-page').on('click', function() {
                // ...existing code...
                afterPageChange();
            });
            $('#add-page').on('click', function() {
                // ...existing code...
                afterPageChange();
            });


            $('#add-page').on('click', function() {
                saveCurrentPage();
                pageCounter++;
                const newPageId = pageCounter;
                loadedPagesData[newPageId] = [];
                loadPage(newPageId);
                currentPageId = newPageId;
                $('#current-page-display').text(`${newPageId}`);
                alert(`Halaman baru ${newPageId} ditambahkan!`);
                afterPageChange();
            });

            function updatePageSelect() {
                const $select = $('#page-select');
                $select.empty();
                const pageKeys = Object.keys(loadedPagesData).map(Number).sort((a, b) => a - b);
                pageKeys.forEach((key, idx) => {
                    $select.append(
                        `<option value="${key}" ${key == currentPageId ? 'selected' : ''}>${key}</option>`
                    );
                });
            }

            $('#page-select').on('change', function() {
                const pageId = parseInt($(this).val());
                if (pageId && loadedPagesData[pageId]) {
                    loadPage(pageId);
                    currentPageId = pageId;
                    afterPageChange();
                }
            });

            // Tampilkan modal simpan template
            $('#open-modal-simpan-template').on('click', function() {
                $('#input-template-name').val('');
                const modal = new bootstrap.Modal(document.getElementById('modalSimpanTemplate'));
                modal.show();
            });

            // Simpan template dari halaman aktif
            $('#form-save-template').on('submit', function(e) {
                e.preventDefault();
                const name = $('#input-template-name').val().trim();
                if (!name) return alert('Masukkan nama template.');
                // Ambil layout current
                const layouts = $('.draggable-layout').map(function() {
                    const $b = $(this);
                    const position = $b.position();

                    const colStart = Math.round(position.left / colWidth);
                    const rowStart = Math.round(position.top / rowHeight);
                    const spanCols = Math.round($b.outerWidth() / colWidth);
                    const spanRows = Math.round($b.outerHeight() / rowHeight);

                    return {
                        colStart: colStart,
                        rowStart: rowStart,
                        spanCols: spanCols,
                        spanRows: spanRows,
                        zIndex: $b.css('z-index')
                    };
                }).get();

                $.ajax({
                    url: '/tabloids/template/save',
                    method: 'POST',
                    data: {
                        name: name,
                        data: JSON.stringify(layouts),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        alert(`Template "${name}" tersimpan!`);
                        bootstrap.Modal.getInstance(document.getElementById(
                            'modalSimpanTemplate')).hide();
                        loadTemplateList();
                    },
                    error: function(xhr) {
                        alert('Gagal menyimpan template!');
                    }
                });
            });
        });
    </script>
</body>

</html>
