<!doctype html>
<html lang="en">

@include('editor._head', ['tabloid' => $tabloid ?? null])

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
                <div class="content-template" data-content-type="text">Teks</div>
                <button id="open-modal-gambar" class="btn btn-primary w-100 mb-2">Gallery</button>

            </div>
            <button id="save-all" class="btn btn-primary mb-2">Simpan semua halaman</button>
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
            <h3>Import Data</h3>
            <div class="import-data">
                <button id="open-modal-import-data" class="btn btn-info w-100 mb-2">Import Data</button>
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

    @include('editor._modal')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        $(function() {
            // Inisialisasi CKEditor
            CKEDITOR.replace('ckeditor-area', {
                toolbar: [{
                        name: 'basicstyles',
                        groups: ['basicstyles', 'cleanup'],
                        items: ['Bold', 'Italic', 'Underline', 'Strike']
                    },
                    {
                        name: 'paragraph',
                        groups: ['list', 'blocks', 'align'],
                        items: ['NumberedList', 'BulletedList', '-', 'Blockquote', '-', 'JustifyLeft',
                            'JustifyCenter', 'JustifyRight', 'JustifyBlock'
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Image', 'Iframe']
                    },
                    '/',
                    {
                        name: 'styles',
                        items: ['Styles', 'Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                ]
            });
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
                    e.stopPropagation();
                    selectedBox = $contentElement;
                    selectedType = type;
                    showEditorSidebar();

                    if (type === 'text' || type === 'title') {
                        $('#cke_ckeditor-area').show();
                        editor.setData($contentElement.html());
                        $('#editor-info').text(`Mengedit: ${selectedType.toUpperCase()}`);
                        $('#editor-action').html(`
                            <button id="delete-layout" class="btn btn-danger btn-sm mb-2">Hapus Layout</button>
                            <button id="delete-content" class="btn btn-warning btn-sm mb-2 ms-2">Hapus Konten</button>
                        `);
                    } else if (type === 'image') {
                        $('#cke_ckeditor-area').hide(); // CKEditor tidak untuk gambar
                        $('#editor-info').text(
                            `Mengedit: ${selectedType.toUpperCase()} (Klik Gallery untuk pilih/upload gambar)`
                        );
                        const currentFit = $contentElement.css('object-fit') || 'contain';
                        $('#editor-action').html(`
                            <div>
                                <button id="delete-layout" class="btn btn-danger btn-sm mb-2">Hapus Layout</button>
                                <button id="delete-content" class="btn btn-warning btn-sm mb-2 ms-2">Hapus Konten</button>
                            </div>
                            <button id="open-modal-gambar" class="btn btn-primary">Ganti gambar</button>
                            <div class="mt-2">
                                <label for="object-fit-select" class="form-label mb-1">Image Style</label>
                                <select id="object-fit-select" class="form-select form-select-sm">
                                    <option value="fill" ${currentFit === 'fill' ? 'selected' : ''}>Fill</option>
                                    <option value="contain" ${currentFit === 'contain' ? 'selected' : ''}>Contain</option>
                                    <option value="cover" ${currentFit === 'cover' ? 'selected' : ''}>Cover</option>
                                    <option value="none" ${currentFit === 'none' ? 'selected' : ''}>None</option>
                                    <option value="scale-down" ${currentFit === 'scale-down' ? 'selected' : ''}>Scale Down</option>
                                </select>
                            </div>
                        `);
                    }
                });
            }

            $(document).on('change', '#object-fit-select', function() {
                if (selectedBox && selectedType === 'image') {
                    const fit = $(this).val();
                    selectedBox.css('object-fit', fit);
                    saveCurrentPage();
                }
            });

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
            // $(document).on('click', function(e) {
            //     if (!$(e.target).closest('.draggable-layout, #editor-sidebar').length) {
            //         hideEditorSidebar();
            //     }
            // });

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
                            content.objectFit = $contentElement.css('object-fit') || 'contain';
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
                                item.content.alt + '" data-content-id="image-' + Date.now() +
                                '" style="object-fit:' + (item.content.objectFit ? item.content
                                    .objectFit : 'contain') + ';">');
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

            $(document).on('click', '#open-modal-gambar', function() {
                loadDaftarGambar();
                $('#input-upload-gambar').val('');
                const modal = new bootstrap.Modal(document.getElementById('modalGambar'));
                modal.show();
            });

            function loadDaftarGambar() {
                $.get('/tabloids/images', function(data) {
                    const images = data.images;
                    console.log(images);
                    const $list = $('#daftar-gambar').empty();
                    if (images.length === 0) {
                        $list.append('<div class="col-12 text-center text-muted">Belum ada gambar.</div>');
                    }
                    images.forEach(img => {
                        $list.append(`
                <div class="col-3 position-relative">
                    <img src="${img.path}" alt="Gambar tabloid" class="img-thumbnail pilih-gambar" style="cursor:pointer;" data-url="${img.path}">
                     <button class="btn btn-danger btn-sm btn-delete-gambar position-absolute"
                        style="top:4px;right:8px;z-index:2;padding:1px 5px;line-height:1;"
                        data-id="${img.id}" title="Hapus Gambar">x</button>
                </div>
            `);
                    });
                });
            }

            // Handle upload gambar
            $('#form-upload-gambar').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                console.log()
                $.ajax({
                    url: '/tabloids/upload-image',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        alert('Gambar berhasil diupload!');
                        loadDaftarGambar(); // Refresh daftar gambar
                    },
                    error: function(xhr) {
                        let msg = 'Gagal upload gambar!';
                        if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON
                            .errors.image) {
                            msg = xhr.responseJSON.errors.image[0];
                        }
                        $('#upload-gambar-error').text(msg);
                    }
                });
            });

            // Pilih gambar dari modal
            $(document).on('click', '.pilih-gambar', function() {
                const url = $(this).data('url');
                console.log(url)
                if (selectedBox && selectedType === 'image') {
                    selectedBox.attr('src', url);
                    saveCurrentPage();
                    // alert('Gambar diperbarui!');
                }
                bootstrap.Modal.getInstance(document.getElementById('modalGambar')).hide();
            });

            $(document).on('click', '.btn-delete-gambar', function(e) {
                e.stopPropagation(); // Jangan trigger pilih gambar
                const id = $(this).data('id');
                if (!confirm('Yakin ingin menghapus gambar ini?')) return;
                $.ajax({
                    url: `/tabloids/images/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        loadDaftarGambar();
                    },
                    error: function() {
                        alert('Gagal menghapus gambar!');
                    }
                });
            });

            $(document).on('mousedown', '.pilih-gambar', function(e) {
                $(this).attr('draggable', true);
            });
            $(document).on('dragstart', '.pilih-gambar', function(e) {
                bootstrap.Modal.getInstance(document.getElementById('modalGambar'))?.hide();
                e.originalEvent.dataTransfer.setData('image-url', $(this).data('url'));
            });

            $(document).on('dragover', '.inner-layout-box', function(e) {
                e.preventDefault();
            });
            $(document).on('drop', '.inner-layout-box', function(e) {
                e.preventDefault();
                const url = (e.originalEvent && e.originalEvent.dataTransfer) ?
                    e.originalEvent.dataTransfer.getData('image-url') :
                    null;
                if (!url) return;

                if ($(this).find('.content-image, .content-text, .content-title').length) return;
                $(this).find('.content-placeholder').remove();
                const $img = $('<img class="content-image" src="' + url +
                    '" alt="Gambar" style="object-fit=cover;">');
                $(this).append($img);
                attachContentClickHandlers($img, 'image');
                saveCurrentPage();
            });

            $('#open-modal-import-data').on('click', function() {
                $('#input-import-data').val('');
                const modal = new bootstrap.Modal(document.getElementById('modalImportData'));
                modal.show();
            });
        });
    </script>
</body>

</html>
