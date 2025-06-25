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
            /* Menggunakan flexbox untuk layout editor */
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
            /* Jangan biarkan sidebar menyusut */
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
            /* Konten utama mengambil sisa ruang */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: auto;
            /* Untuk scroll jika canvas lebih besar dari viewport */
            padding: 20px;
        }

        /* Canvas Ukuran Kertas */
        .paper-canvas {
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            border: 1px solid #ccc;
            overflow: hidden;
            /* Penting agar item tidak keluar saat di-drag keluar batas canvas */
        }

        /* Contoh Ukuran A4 Landscape - (297mm x 210mm @ 96 DPI = 1123px x 794px) */
        .paper-canvas.a4-landscape {
            width: 1123px;
            height: 794px;
        }

        .paper-canvas.a4-potrait {
            margin-top: 300px;
            width: 794px;
            height: 1123px;
        }

        /* Tambahkan ukuran kertas lain jika diperlukan */

        .tabloid-grid {
            height: 100%;
            width: 100%;
        }

        /* Gaya untuk item Gridstack */
        .grid-stack-item-content {
            background-color: #ecf0f1;
            /* Warna latar belakang item layout */
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            /* Penting untuk inner-layout-box */
            box-sizing: border-box;
            color: #333;
            font-size: 0.9em;
            position: relative;
            /* Untuk positioning child elements */
        }

        /* Gaya untuk inner-layout-box sebagai dropzone konten */
        .inner-layout-box {
            width: 100%;
            height: 100%;
            display: flex;
            /* Untuk menampung konten */
            flex-direction: column;
            /* Konten disusun vertikal */
            align-items: center;
            /* Pusatkan secara horizontal */
            justify-content: center;
            /* Pusatkan secara vertikal */
            border: 2px dashed rgba(0, 123, 255, 0.4);
            /* Border default */
            border-radius: 3px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.6);
            /* padding: 10px; */
            overflow-y: auto;
            /* Scroll jika konten melebihi */
        }

        .inner-layout-box.highlight-dropzone {
            border-color: #007bff;
            /* Warna highlight saat dragover */
            background-color: rgba(0, 123, 255, 0.1);
        }

        /* Gaya untuk konten yang di-drop */
        .content-text,
        .content-image,
        .content-title {
            display: block;
            /* Pastikan konten teks/judul tampil vertikal */
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #fff;
            border: none;
            /* Hapus border agar seamless */
            border-radius: 0;
            /* Hapus border-radius */
            box-sizing: border-box;
            word-break: break-word;
            overflow: auto;
            /* Potong konten jika terlalu besar */
        }

        .content-text {
            font-size: 0.9em;
            color: #555;
        }

        .content-image {
            max-width: 100%;
            height: auto;
            display: block;
            /* Hapus spasi bawah img */
        }

        .content-title {
            font-size: 1.5em;
            /* Ukuran font lebih besar untuk judul */
            font-weight: bold;
            color: #222;
            text-align: center;
            /* Tambahkan pengaturan gaya judul jika diperlukan */
        }

        /* Gaya untuk placeholder */
        .content-placeholder {
            color: #888;
            font-style: italic;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>

<body>
    {{-- <h1>gridstack testing!</h1> --}}
    <div class="editor-container">
        <div class="sidebar">
            <h3>Palet Layout</h3>
            <div class="layout-palette">
                <div class="layout-template" data-w="12" data-h="4" draggable="true">Layout Penuh</div>
                <div class="layout-template" data-w="6" data-h="4" draggable="true">Layout Setengah</div>
                <div class="layout-template" data-w="4" data-h="4" draggable="true">Layout Sepertiga</div>
            </div>

            <h3>Palet Konten</h3>
            <div class="content-palette">
                <div class="content-template" data-content-type="title" draggable="true">Judul</div>
                <div class="content-template" data-content-type="text" draggable="true">Teks</div>
                <div class="content-template" data-content-type="image" draggable="true">Gambar</div>
            </div>

            <a href="/jquery">
                <h4>Ke jquery draggable</h4>
            </a>

        </div>

        <div class="main-content">
            <div class="paper-canvas a4-potrait">
                <div class="grid-stack tabloid-grid">
                </div>
            </div>
        </div>
        <!-- Sidebar Editor Konten -->
        <div class="sidebar editor-sidebar"
            style="width:350px; background:#f8f9fa; color:#222; border-left:1px solid #ddd;">
            <h3 style="color:#222;">Editor Konten</h3>
            <textarea id="ckeditor-area"></textarea>
            <div id="editor-info" style="font-size:0.9em; color:#888; margin-top:10px;"></div>
        </div>
    </div>

    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        let selectedContentBox = null;
        let selectedType = null;
        let editorInstance = null;
        document.addEventListener('DOMContentLoaded', function() {
            const grid = GridStack.init({
                column: 24,
                cellHeight: '20px',
                float: true,
                acceptWidgets: true,
                animate: true,
                margin: 0,
            }, '.tabloid-grid');

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

                    const cellWidth = gridElement.offsetWidth / grid.column;
                    const cellHeight = grid.cellHeight();

                    const x = Math.floor(mouseX / cellWidth);
                    const y = Math.floor(mouseY / cellHeight);

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

            // Inisialisasi CKEditor
            CKEDITOR.replace('ckeditor-area');
            CKEDITOR.instances['ckeditor-area'].on('change', function() {
                if (selectedContentBox && (selectedType === 'text' || selectedType === 'title')) {
                    selectedContentBox.innerHTML = CKEDITOR.instances['ckeditor-area'].getData();
                }
            });
            editorInstance = CKEDITOR.instances['ckeditor-area'];

            grid.on('added', function(event, items) {
                items.forEach(item => {
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
                                this.classList.remove('highlight-dropzone');
                                const placeholder = this.querySelector(
                                    '.content-placeholder');
                                if (placeholder) {
                                    this.removeChild(placeholder);
                                }
                                const existingContent = Array.from(this.children).filter(
                                    child => !child.classList.contains(
                                        'content-placeholder'));
                                if (existingContent.length > 0) {
                                    console.warn(
                                        'Box layout sudah memiliki konten. Hanya satu konten diizinkan.'
                                    );
                                    return;
                                }
                                const contentData = JSON.parse(e.dataTransfer.getData(
                                    'text/plain'));
                                let contentElement;
                                switch (contentData.type) {
                                    case 'text':
                                        contentElement = document.createElement('div');
                                        contentElement.className = 'content-text';
                                        // contentElement.contentEditable = true; // Dihapus, edit via CKEditor
                                        contentElement.innerHTML =
                                            'Ketik teks Anda di sini...';
                                        break;
                                    case 'image':
                                        contentElement = document.createElement('img');
                                        contentElement.className = 'content-image';
                                        contentElement.src =
                                            '/image.png';
                                        contentElement.alt = 'Gambar';
                                        break;
                                    case 'title':
                                        contentElement = document.createElement('h2');
                                        contentElement.className = 'content-title';
                                        // contentElement.contentEditable = true; // Dihapus, edit via CKEditor
                                        contentElement.innerHTML = 'Judul Tabloid Baru';
                                        break;
                                    default:
                                        console.warn('Tipe konten tidak dikenal:',
                                            contentData.type);
                                        return;
                                }
                                if (contentElement) {
                                    this.appendChild(contentElement);
                                    // Tambahkan event click untuk memilih box ke editor
                                    if (contentData.type === 'text' || contentData.type ===
                                        'title') {
                                        contentElement.addEventListener('click', function(
                                            e) {
                                            e.stopPropagation();
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
                            // Tambahkan placeholder awal agar dropzone terlihat kosong
                            const placeholder = document.createElement('div');
                            placeholder.className = 'content-placeholder';
                            placeholder.innerText = 'Drop Konten Di Sini';
                            innerBox.appendChild(placeholder);
                        }
                    }
                });
            });
            // Event delegation untuk box yang sudah ada (jika reload)
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
