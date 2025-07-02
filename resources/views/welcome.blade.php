<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/gridstack@latest/dist/gridstack-all.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/gridstack@latest/dist/gridstack.min.css" rel="stylesheet">
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
            border: 1px solid #ccc;
            overflow: hidden;
        }

        .paper-canvas.a4-potrait {
            margin-top: 300px;
            width: 794px;
            height: 1123px;
        }

        .tabloid-grid {
            height: 100%;
            width: 100%;
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
            padding: 10px;
            /* Tambahkan padding agar tidak terlalu mepet */
            background-color: transparent;
            /* Ubah agar menyatu dengan inner-box */
            border: none;
            box-sizing: border-box;
            word-break: break-word;
            overflow: hidden;
            /* Ubah dari auto ke hidden agar lebih rapi */
        }

        .content-image {
            max-width: 100%;
            height: 100%;
            object-fit: cover;
            /* Agar gambar mengisi box dengan baik */
            padding: 0;
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
                <div class="layout-template" data-w="24" data-h="10" draggable="true">Layout Penuh</div>
                <div class="layout-template" data-w="12" data-h="10" draggable="true">Layout Setengah</div>
                <div class="layout-template" data-w="8" data-h="10" draggable="true">Layout Sepertiga</div>
            </div>

            <h3>Palet Konten</h3>
            <div class="content-palette">
                <div class="content-template" data-content-type="title" draggable="true">Judul</div>
                <div class="content-template" data-content-type="text" draggable="true">Teks</div>
                <div class="content-template" data-content-type="image" draggable="true">Gambar</div>
            </div>

            <button id="save-button" class="btn btn-primary w-100 mt-4">Save to Console</button>

        </div>

        <div class="main-content">
            <div class="paper-canvas a4-potrait">
                <div class="grid-stack tabloid-grid">
                </div>
            </div>
        </div>

        <div class="sidebar editor-sidebar"
            style="width:350px; background:#f8f9fa; color:#222; border-left:1px solid #ddd;">
            <h3 style="color:#222;">Editor Konten</h3>
            <textarea id="ckeditor-area"></textarea>
            <div id="editor-info" style="font-size:0.9em; color:#888; margin-top:10px;"></div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        let selectedContentBox = null;
        let selectedType = null;
        let editorInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            const paperHeight = 1123;
            const cellHeight = 20;
            const minRow = Math.ceil(paperHeight / cellHeight);

            const grid = GridStack.init({
                column: 24,
                cellHeight: 'auto',
                float: true,
                acceptWidgets: true,
                animate: true,
                margin: 0,
                minRow: minRow,
            }, '.tabloid-grid');

            // FUNGSI SAVE BARU
            function saveGridState() {
                // 1. Dapatkan data serialisasi dari Gridstack (posisi, ukuran, id)
                const serializedData = grid.save();

                // 2. Iterasi setiap widget untuk mengambil konten HTML di dalamnya
                serializedData.forEach(widget => {
                    if (widget.id) {
                        const widgetElement = document.getElementById(widget.id);
                        if (widgetElement) {
                            const innerBox = widgetElement.querySelector('.inner-layout-box');
                            if (innerBox) {
                                // 3. Tambahkan properti baru 'contentHTML' ke objek widget
                                widget.contentHTML = innerBox.innerHTML;
                            }
                        }
                    }
                });

                // 4. Tampilkan hasil akhir di console
                console.log('--- GRID STATE SAVED ---');
                console.log(serializedData); // Tampilkan sebagai objek yang bisa di-inspeksi

                console.log('--- JSON REPRESENTATION ---');
                // Tampilkan sebagai string JSON, cocok untuk dikirim ke server
                console.log(JSON.stringify(serializedData, null, 2));
            }

            // Tambahkan event listener ke tombol save
            const saveButton = document.getElementById('save-button');
            saveButton.addEventListener('click', saveGridState);


            const layoutTemplates = document.querySelectorAll('.layout-template');
            const gridElement = document.querySelector('.tabloid-grid');

            layoutTemplates.forEach(template => {
                template.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', JSON.stringify({
                        w: parseInt(this.dataset.w),
                        h: parseInt(this.dataset.h),
                        type: 'layout'
                    }));
                    e.dataTransfer.effectAllowed = 'copyMove';
                });
            });

            gridElement.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
            });

            gridElement.addEventListener('drop', function(e) {
                e.preventDefault();
                const data = JSON.parse(e.dataTransfer.getData('text/plain'));

                if (data.type === 'layout') {
                    const gridRect = gridElement.getBoundingClientRect();
                    const mouseX = e.clientX - gridRect.left;
                    const mouseY = e.clientY - gridRect.top;

                    let x, y;
                    if (typeof grid.getCellFromPixel === 'function') {
                        const cell = grid.getCellFromPixel({
                            left: mouseX,
                            top: mouseY
                        });
                        x = cell.x;
                        y = cell.y;
                    } else {
                        const cellWidth = gridElement.offsetWidth / grid.column;
                        const cellHeight = parseFloat(grid.cellHeight());
                        x = Math.floor(mouseX / cellWidth);
                        y = Math.floor(mouseY / cellHeight);
                    }

                    grid.addWidget({
                        x: x,
                        y: y,
                        w: data.w,
                        h: data.h,
                    });
                }
            });

            const contentTemplates = document.querySelectorAll('.content-template');

            contentTemplates.forEach(template => {
                template.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', JSON.stringify({
                        type: this.dataset.contentType,
                    }));
                    e.dataTransfer.effectAllowed = 'copyMove';
                });
            });

            CKEDITOR.replace('ckeditor-area');
            CKEDITOR.instances['ckeditor-area'].on('change', function() {
                if (selectedContentBox && (selectedType === 'text' || selectedType === 'title')) {
                    selectedContentBox.innerHTML = CKEDITOR.instances['ckeditor-area'].getData();
                }
            });
            editorInstance = CKEDITOR.instances['ckeditor-area'];

            grid.on('added', function(event, items) {
                items.forEach(item => {
                    // **PERUBAHAN: Beri ID unik agar bisa diidentifikasi saat menyimpan**
                    if (!item.el.id) {
                        item.el.id = 'widget-' + Date.now() + Math.random().toString(36).substring(
                            2, 9);
                    }

                    const itemContent = item.el.querySelector('.grid-stack-item-content');
                    if (itemContent) {
                        itemContent.innerHTML = `<div class="inner-layout-box"></div>`;
                        const innerBox = itemContent.querySelector('.inner-layout-box');
                        if (innerBox) {
                            innerBox.addEventListener('dragover', function(e) {
                                e.preventDefault();
                                if (this.children.length > 0 && !this.querySelector(
                                        '.content-placeholder')) {
                                    e.dataTransfer.dropEffect = 'none';
                                } else {
                                    e.dataTransfer.dropEffect = 'copy';
                                    this.classList.add('highlight-dropzone');
                                }
                            });
                            innerBox.addEventListener('dragleave', function() {
                                this.classList.remove('highlight-dropzone');
                            });
                            innerBox.addEventListener('drop', function(e) {
                                e.preventDefault();
                                e
                                    .stopPropagation(); // Hentikan propagasi agar tidak ditangani grid utama
                                this.classList.remove('highlight-dropzone');

                                const placeholder = this.querySelector(
                                    '.content-placeholder');
                                if (placeholder) {
                                    this.removeChild(placeholder);
                                }

                                if (this.querySelector(
                                        '.content-text, .content-image, .content-title')) {
                                    console.warn('Box layout sudah memiliki konten.');
                                    return;
                                }

                                const contentData = JSON.parse(e.dataTransfer.getData(
                                    'text/plain'));
                                let contentElement;
                                switch (contentData.type) {
                                    case 'text':
                                        contentElement = document.createElement('div');
                                        contentElement.className = 'content-text';
                                        contentElement.innerHTML =
                                            'Ketik teks Anda di sini...';
                                        break;
                                    case 'image':
                                        contentElement = document.createElement('img');
                                        contentElement.className = 'content-image';
                                        contentElement.src =
                                            'https://via.placeholder.com/400x300'; // Placeholder URL
                                        contentElement.alt = 'Gambar';
                                        break;
                                    case 'title':
                                        contentElement = document.createElement('h2');
                                        contentElement.className = 'content-title';
                                        contentElement.innerHTML = 'Judul Tabloid Baru';
                                        break;
                                    default:
                                        return;
                                }
                                if (contentElement) {
                                    this.appendChild(contentElement);
                                    if (contentData.type === 'text' || contentData.type ===
                                        'title') {
                                        contentElement.addEventListener('click', function(
                                            ev) {
                                            ev.stopPropagation();
                                            selectedContentBox = this;
                                            selectedType = contentData.type;
                                            editorInstance.setData(this.innerHTML);
                                            document.getElementById('editor-info')
                                                .innerText = 'Mengedit ' + (
                                                    contentData.type === 'text' ?
                                                    'Teks' : 'Judul');
                                        });
                                    }
                                }
                            });
                            const placeholder = document.createElement('div');
                            placeholder.className = 'content-placeholder';
                            placeholder.innerText = 'Drop Konten Di Sini';
                            innerBox.appendChild(placeholder);
                        }
                    }
                });
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('content-text') || e.target.classList.contains(
                        'content-title')) {
                    selectedContentBox = e.target;
                    selectedType = e.target.classList.contains('content-text') ? 'text' : 'title';
                    editorInstance.setData(e.target.innerHTML);
                    document.getElementById('editor-info').innerText = 'Mengedit ' + (selectedType ===
                        'text' ? 'Teks' : 'Judul');
                }
            });
        });
    </script>
</body>

</html>
