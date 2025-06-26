<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery Draggable Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .paper-canvas.a4-landscape {
            width: 1123px;
            height: 794px;
        }

        .paper-canvas.a4-portrait {
            margin-top: 200px;
            width: 794px;
            height: 1123px;
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
            max-width: 100%;
            height: auto;
            display: block;
        }

        .content-placeholder {
            color: #888;
            font-style: italic;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="editor-container">
        <div class="sidebar">
            <h3>Palet Layout</h3>
            <div class="layout-palette">
                <div class="layout-template" data-w="300" data-h="120">Layout Penuh</div>
                <div class="layout-template" data-w="150" data-h="120">Layout Setengah</div>
                <div class="layout-template" data-w="100" data-h="120">Layout Sepertiga</div>
            </div>
            <h3>Palet Konten</h3>
            <div class="content-palette">
                {{-- <div class="content-template" data-content-type="title">Judul</div> --}}
                <div class="content-template" data-content-type="text">Teks</div>
                <div class="content-template" data-content-type="image">Gambar</div>
            </div>
            <button id="save-layout" class="btn btn-primary mt-3">Simpan Layout</button>
            <button id="save-all" class="btn btn-primary mt-3">Simpan semua halaman</button>
            <button id="load-layout" class="btn btn-info mt-2">Muat Layout</button>
            <button id="load-all-page" class="btn btn-info mt-2">Muat semua halaman</button>
            <br>
            <h3>Navigasi Halaman</h3>
            <div class="page-navigation">
                <button id="prev-page" class="btn btn-secondary btn-sm me-2">‹ Sebelumnya</button>
                <span id="current-page-display" class="fw-bold">Halaman 1</span>
                <button id="next-page" class="btn btn-secondary btn-sm ms-2">Berikutnya ›</button>
                <button id="add-page" class="btn btn-primary btn-sm mt-2 w-100">Tambah Halaman Baru</button>
            </div>
            <a href="/">Ke Gridstack</a>
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

            // Pilih layout box (draggable-layout) atau konten di dalamnya
            $(document).on('click', '.draggable-layout', function(e) {
                e.stopPropagation();
                let $target = $(e.target);
                console.log($target)
                let $layout = $(this);
                let $content = null;
                let type = null;
                $content = $target;
                type = 'content';
                // Cek jika klik pada konten di dalam layout
                if ($target.hasClass('content-text')) {
                    console.log('pante1')
                    $content = $target;
                    type = 'text';
                } else if ($target.hasClass('content-image')) {
                    console.log('pante3')
                    $content = $target;
                    type = 'image';
                }

                //    let contentEl = $layout[0].querySelector('.content-text, .content-title, .content-image');
                // if (contentEl && contentEl.contains($target[0])) {
                //     if (contentEl.classList.contains('content-text')) {
                //         console.log()
                //         $content = $(contentEl);
                //         type = 'text';
                //     } else if (contentEl.classList.contains('content-title')) {
                //         $content = $(contentEl);
                //         type = 'title';
                //     } else if (contentEl.classList.contains('content-image')) {
                //         $content = $(contentEl);
                //         type = 'image';
                //     }
                // }
                // if ($target.hasClass('content-image')) {
                //     console.log('pante3')
                //     $content = $target;
                //     type = 'image';
                // }
                selectedBox = $layout;
                selectedType = 'layout';
                showEditorSidebar();
                let actionHtml =
                    '<button id="delete-layout" class="btn btn-danger btn-sm mb-2">Hapus Layout</button>';
                if ($content) {
                    selectedBox = $content;
                    selectedType = type;
                    actionHtml +=
                        ' <button id="delete-content" class="btn btn-warning btn-sm mb-2 ms-2">Hapus Konten</button>';
                }
                $('#editor-action').html(actionHtml);
                if (type === 'text') {
                    $('#ckeditor-area').show();
                    editor.setData($content.html());
                } else {
                    $('#ckeditor-area').hide();
                }
                if (type) {
                    $('#editor-info').text('Mengedit');
                } else {
                    $('#editor-info').text('Layout terpilih.');
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
                }
            });

            // Hapus konten
            $(document).on('click', '#delete-content', function() {
                if (selectedBox && (selectedType === 'text' || selectedType ===
                        'image')) {
                    let $layout = selectedBox.closest('.draggable-layout');
                    selectedBox.remove();
                    // Jika layout kosong, tambahkan placeholder
                    if ($layout.find('.content-text, .content-image').length === 0) {
                        $layout.find('.inner-layout-box').append(
                            '<div class="content-placeholder">Drop Konten Di Sini</div>');
                    }
                    // hideEditorSidebar();
                }
            });
            // // Sembunyikan editor jika klik di luar layout/konten/editor
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

            let currentPageId = "page1"; // Variabel untuk melacak halaman yang sedang aktif
            let loadedPagesData = {}; // Objek untuk menyimpan semua data halaman yang

            // unique id
            let layoutIdCounter = 0;

            function snapClamp(ui, $el) {
                // hitung posisi snapped
                let left = Math.floor(ui.position.left / GRID) * GRID;
                let top = Math.floor(ui.position.top / GRID) * GRID;
                // clamp agar tidak keluar
                left = Math.min(Math.max(0, left), canvasW - $el.outerWidth());
                top = Math.min(Math.max(0, top), canvasH - $el.outerHeight());
                $el.css({
                    left,
                    top
                });

                // --- KLAMP DIMENSI (khusus untuk resizable) ---
                // Jika elemen ini di-resize (yaitu, memiliki ui.size dari resizable)
                if (ui.size) {
                    let width = Math.round(ui.size.width / GRID) * GRID;
                    let height = Math.round(ui.size.height / GRID) * GRID;

                    // Pastikan ukuran tidak membuat elemen keluar batas
                    width = Math.min(width, canvasW - left); // width tidak boleh melebihi sisa ruang kanan
                    height = Math.min(height, canvasH - top); // height tidak boleh melebihi sisa ruang bawah

                    $el.css({
                        width: width,
                        height: height
                    });
                }
            }


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
                            }
                        });
                    $('#canvas').append($layout);

                    // Konten droppable
                    $inner.droppable({
                        accept: '.content-template',
                        hoverClass: 'highlight-dropzone',
                        drop(ev, uii) {
                            if ($inner.find('.content-text, .content-image').length)
                                return;
                            $inner.find('.content-placeholder').remove();
                            const type = uii.helper.data('content-type');
                            let $content;
                            if (type === 'text') {
                                $content = $(
                                    '<div class="content-text" data-content-id="text-' + Date
                                    .now() + '">Ketik teks Anda di sini...</div>'
                                );
                            } else if (type === 'image') {
                                $content = $(
                                    '<img class="content-image" src="/image.png" alt="Gambar" data-content-id="text-' +
                                    Date.now() + '">'
                                );
                            }
                            if ($content) {
                                $inner.append($content);
                                if (type === 'text') {
                                    $content.on('click', e => {
                                        e.stopPropagation();
                                        selectedBox = $content;
                                        selectedType = type;
                                        editor.setData($content.html());
                                    });
                                }
                            }
                        }
                    });
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
                if (selectedBox && (selectedType === 'text')) {
                    selectedBox.html(editor.getData());
                }
            });

            function saveLayout() {
                const layoutData = [];
                $('.draggable-layout').each(function() {
                    const $layout = $(this);
                    const layoutId = $layout.attr('id');
                    const position = $layout.position(); // Mendapatkan top dan left relatif terhadap parent
                    const width = $layout.outerWidth();
                    const height = $layout.outerHeight();

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
                        top: position.top,
                        left: position.left,
                        width: width,
                        height: height,
                        content: content // Sertakan data konten
                    });
                });

                console.log("Data layout yang akan disimpan:", layoutData); // Untuk debug

                // Contoh: Simpan ke LocalStorage
                localStorage.setItem('savedTabloidLayout', JSON.stringify(layoutData));
                alert('Layout disimpan!');
            }

            function loadLayout() {
                const savedData = localStorage.getItem('savedTabloidLayout');
                if (!savedData) {
                    console.log("Tidak ada layout yang disimpan.");
                    return;
                }

                // Bersihkan canvas sebelum memuat ulang
                $('#canvas').empty();

                const layoutData = JSON.parse(savedData);
                layoutData.forEach(item => {
                    const $layout = $('<div class="draggable-layout" id="' + item.id + '"></div>').css({
                        position: 'absolute',
                        top: item.top,
                        left: item.left,
                        width: item.width,
                        height: item.height
                    });

                    const $inner = $('<div class="inner-layout-box"></div>');

                    // Rekonstruksi konten
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

                        // Re-attach click handlers for editing
                        if (item.content.type === 'text' || item.content.type === 'title') {
                            $content.on('click', e => {
                                e.stopPropagation();
                                selectedBox = $content;
                                selectedType = item.content.type;
                                editor.setData($content.html());
                            });
                        } else if (item.content.type === 'image') {
                            $content.on('click', e => {
                                e.stopPropagation();
                                selectedBox = $content;
                                selectedType = item.content.type;
                                editor.setData(`<img src="${$content.attr('src')}" />`);
                            });
                        }
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
                                if (type === 'text' || type === 'title') {
                                    $newContent.on('click', e => {
                                        e.stopPropagation();
                                        selectedBox = $newContent;
                                        selectedType = type;
                                        editor.setData($newContent.html());
                                    });
                                } else if (type === 'image') {
                                    $newContent.on('click', e => {
                                        e.stopPropagation();
                                        selectedBox = $newContent;
                                        selectedType = type;
                                        editor.setData(
                                            `<img src="${$newContent.attr('src')}" />`);
                                    });
                                }
                            }
                        }
                    });
                });
                alert('Layout dimuat!');
            }


            function saveCurrentPage() {
                const layoutData = [];
                $('.draggable-layout').each(function() {
                    const $layout = $(this);
                    const layoutId = $layout.attr('id');
                    const position = $layout.position();
                    const width = $layout.outerWidth();
                    const height = $layout.outerHeight();

                    const content = {};
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
                        id: layoutId,
                        top: position.top,
                        left: position.left,
                        width: width,
                        height: height,
                        content: content
                    });
                });

                loadedPagesData[currentPageId] = layoutData; // Simpan data halaman saat ini

                console.log("Data halaman saat ini disimpan:", layoutData);
            }

            function saveAllPages() {
                saveCurrentPage(); // Pastikan halaman saat ini sudah tersimpan di loadedPagesData
                localStorage.setItem('savedTabloidProject', JSON.stringify(loadedPagesData));
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
                    return; // Halaman kosong, tidak ada yang perlu dirender
                }

                pageData.forEach(item => {
                    // Logika pembuatan $layout, $inner, dan konten $content
                    // Sama persis dengan fungsi loadLayout() Anda yang sekarang,
                    // Cukup pindahkan logika itu ke sini.
                    const $layout = $('<div class="draggable-layout" id="' + item.id + '"></div>').css({
                        position: 'absolute',
                        top: item.top,
                        left: item.left,
                        width: item.width,
                        height: item.height
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

                        // Re-attach click handlers for editing (PENTING!)
                        if (item.content.type === 'text' || item.content.type === 'title') {
                            $content.on('click', e => {
                                e.stopPropagation();
                                selectedBox = $content;
                                selectedType = item.content.type;
                                editor.setData($content.html());
                                showEditorSidebar();
                                $('#editor-info').text(`Mengedit: ${selectedType.toUpperCase()}`);
                            });
                        } else if (item.content.type === 'image') {
                            $content.on('click', e => {
                                e.stopPropagation();
                                selectedBox = $content;
                                selectedType = item.content.type;
                                editor.setData(`<img src="${$content.attr('src')}" />`);
                                showEditorSidebar();
                                $('#editor-info').text(
                                    `Mengedit: ${selectedType.toUpperCase()} (Klik untuk ganti URL gambar)`
                                );
                            });
                        }
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
                                // Panggil saveCurrentPage() setelah drag/resize
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
                                // Panggil saveCurrentPage() setelah drag/resize
                                saveCurrentPage();
                            }
                        });
                    $('#canvas').append($layout);

                    // Re-attach droppable for inner-layout-box (PENTING!)
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
                                if (type === 'text' || type === 'title') {
                                    $newContent.on('click', e => {
                                        e.stopPropagation();
                                        selectedBox = $newContent;
                                        selectedType = type;
                                        editor.setData($newContent.html());
                                        showEditorSidebar();
                                        $('#editor-info').text(
                                            `Mengedit: ${selectedType.toUpperCase()}`);
                                    });
                                } else if (type === 'image') {
                                    $newContent.on('click', e => {
                                        e.stopPropagation();
                                        selectedBox = $newContent;
                                        selectedType = type;
                                        editor.setData(
                                            `<img src="${$newContent.attr('src')}" />`);
                                        showEditorSidebar();
                                        $('#editor-info').text(
                                            `Mengedit: ${selectedType.toUpperCase()} (Klik untuk ganti URL gambar)`
                                        );
                                    });
                                }
                                // Panggil saveCurrentPage() setelah drop konten baru
                                saveCurrentPage();
                            }
                        }
                    });
                });
                $('#editor-info').text(`Halaman ${pageId} dimuat.`);
                hideEditorSidebar(); // Sembunyikan sidebar editor saat berpindah halaman
            }

            // 4. Fungsi `loadAllPages()` (dipanggil saat startup)
            function loadAllPages() {
                const savedData = localStorage.getItem('savedTabloidProject');
                if (savedData) {
                    loadedPagesData = JSON.parse(savedData);
                    // Tentukan halaman pertama yang akan dimuat, default ke 'page1' atau yang terakhir diedit
                    const initialPageId = Object.keys(loadedPagesData)[0] || "page1";
                    loadPage(initialPageId);
                } else {
                    loadedPagesData["page1"] = []; // Inisialisasi halaman 1 jika tidak ada data
                    loadPage("page1");
                }
            }

            $('#save-all').off('click').on('click', saveAllPages);
            $('#save-layout').on('click', saveCurrentPage);
            $('#load-layout').on('click', loadLayout);
            $('#load-all-page').on('click', loadAllPages);


            let pageCounter = Object.keys(loadedPagesData).length > 0 ? Math.max(...Object.keys(loadedPagesData)
                .map(p => parseInt(p.replace('page', '')))) + 1 : 1;

            $('#prev-page').on('click', function() {
                const pageKeys = Object.keys(loadedPagesData).sort();
                const currentIndex = pageKeys.indexOf(currentPageId);
                if (currentIndex > 0) {
                    loadPage(pageKeys[currentIndex - 1]);
                    $('#current-page-display').text(
                        `Halaman ${parseInt(pageKeys[currentIndex - 1].replace('page', ''))}`);
                } else {
                    alert('Ini adalah halaman pertama.');
                }
            });

            $('#next-page').on('click', function() {
                const pageKeys = Object.keys(loadedPagesData).sort();
                const currentIndex = pageKeys.indexOf(currentPageId);
                if (currentIndex < pageKeys.length - 1) {
                    loadPage(pageKeys[currentIndex + 1]);
                    $('#current-page-display').text(
                        `Halaman ${parseInt(pageKeys[currentIndex + 1].replace('page', ''))}`);
                } else {
                    alert('Ini adalah halaman terakhir.');
                }
            });

            $('#add-page').on('click', function() {
                saveCurrentPage(); // Simpan halaman aktif sebelum membuat yang baru
                pageCounter++;
                const newPageId = `page${pageCounter}`;
                loadedPagesData[newPageId] = []; // Inisialisasi halaman baru kosong
                loadPage(newPageId);
                $('#current-page-display').text(`Halaman ${pageCounter}`);
                alert(`Halaman baru ${newPageId} ditambahkan!`);
            });

            // Update display saat awal
            $('#current-page-display').text(`Halaman ${parseInt(currentPageId.replace('page', ''))}`);
        });
    </script>
</body>

</html>
