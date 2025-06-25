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
        .content-image,
        .content-title {
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

        .content-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #222;
            text-align: center;
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
                <div class="content-template" data-content-type="title">Judul</div>
                <div class="content-template" data-content-type="text">Teks</div>
                <div class="content-template" data-content-type="image">Gambar</div>
            </div>
            <a href="/">Ke Gridstack</a>
        </div>
        <div class="main-content">
            <div class="paper-canvas a4-portrait" id="canvas"></div>
        </div>
        <div class="sidebar editor-sidebar"
            style="width:350px; background:#f8f9fa; color:#222; border-left:1px solid #ddd;">
            <h3 style="color:#222;">Editor Konten</h3>
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

            editor.on('change', () => {
                if (selectedBox && (selectedType === 'text' || selectedType === 'title')) {
                    selectedBox.html(editor.getData());
                }
            });

            const GRID = 10;
            const $canvas = $('#canvas');
            const canvasW = $canvas.width();
            const canvasH = $canvas.height();

            function snapClamp(ui, $el) {
                // hitung posisi snapped
                let left = Math.round(ui.position.left / GRID) * GRID;
                let top = Math.round(ui.position.top / GRID) * GRID;
                // clamp agar tidak keluar
                left = Math.min(Math.max(0, left), canvasW - $el.outerWidth());
                top = Math.min(Math.max(0, top), canvasH - $el.outerHeight());
                $el.css({
                    left,
                    top
                });
            }


            // Draggable layout
            $('.layout-template').draggable({
                helper: 'clone',
                revert: 'invalid',
                appendTo: 'body',
                grid: [GRID, GRID],
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
                        x = ui.offset.left - dropOff.left,
                        y = ui.offset.top - dropOff.top;

                    const $layout = $('<div class="draggable-layout"></div>').css({
                        position: 'absolute',
                        top: y,
                        left: x,
                        width: w,
                        height: h
                    });
                    const $inner = $(
                        '<div class="inner-layout-box"><div class="content-placeholder">Drop Konten Di Sini</div></div>'
                    );
                    $layout.append($inner)
                        .draggable({
                            grid: [GRID, GRID],
                            containment: '#canvas',
                            handle: '.inner-layout-box',
                            stop(e, ui) {
                                // snap & clamp
                                snapClamp(ui, $(this));
                            }
                        })
                        .resizable({
                            grid: [GRID, GRID],
                            containment: '#canvas',
                            minWidth: 80,
                            minHeight: 60,
                            stop(e, ui) {
                                snapClamp(ui, $(this));
                                // // setelah resize juga kita snap dimensi & posisi
                                // const $el = $(this);
                                // // snap ukuran
                                // let w = Math.round($el.width() / GRID) * GRID;
                                // let h = Math.round($el.height() / GRID) * GRID;
                                // // clamp ukuran agar muat
                                // w = Math.min(w, canvasW - parseInt($el.css('left')));
                                // h = Math.min(h, canvasH - parseInt($el.css('top')));
                                // $el.css({
                                //     width: w,
                                //     height: h
                                // });
                                // // pastikan posisi juga masih valid
                                // snapClamp({
                                //     position: $el.position()
                                // }, $el);
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
                            let $content;
                            if (type === 'text') {
                                $content = $(
                                    '<div class="content-text">Ketik teks Anda di sini...</div>'
                                );
                            } else if (type === 'title') {
                                $content = $('<div class="content-title">Judul Tabloid Baru</div>');
                            } else if (type === 'image') {
                                $content = $(
                                    '<img class="content-image" src="/image.png" alt="Gambar">'
                                );
                            }
                            if ($content) {
                                $inner.append($content);
                                if (type === 'text' || type === 'title') {
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

            // Edit via delegation
            $(document).on('click', '.content-text, .content-title', function(e) {
                selectedBox = $(this);
                selectedType = $(this).hasClass('content-text') ? 'text' : 'title';
                editor.setData($(this).html());
            });
        });
    </script>
</body>

</html>
