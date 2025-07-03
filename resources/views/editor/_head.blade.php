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
            /* padding-bottom: 10px; */
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

        @media (max-width: 1366px) {
            .paper-canvas.a4-portrait {
                margin-top: 300px;
                margin-left: 300px;
                margin-right: 200px;
                width: 210mm;
                height: 297mm;
                min-width: 210mm;
                min-height: 297mm;
                /* max-width: 210mm;
            max-height: 297mm; */
            }
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
            /* background-color: #fff; */
            border: none;
            border-radius: 0;
            box-sizing: border-box;
            word-break: break-word;
            overflow: auto;
        }

        .content-text {
            overflow: hidden;
            /* font-size: 0.9em; */
            /* color: #555; */
        }

        .content-image {
            width: 100%;
            height: 100%;
            display: block;
            /* object-fit: fill; */
        }

        .content-placeholder {
            color: #888;
            font-style: italic;
            font-size: 0.9em;
            text-align: center;
        }

        /* Untuk area editor dan export */
        /* .paper-canvas .content-text h1,
        .paper-canvas .content-text h2,
        .paper-canvas .content-text h3,
        .paper-canvas .content-text h4,
        .paper-canvas .content-text h5,
        .paper-canvas .content-text h6 {
            font-family: inherit;
            margin: 0.2em 0;
            line-height: 1.1;
            color: inherit;
        }

        .paper-canvas .content-text h1 {
            font-size: 2em;
        }

        .paper-canvas .content-text h2 {
            font-size: 1.5em;
        }

        .paper-canvas .content-text h3 {
            font-size: 1.17em;
        }

        .paper-canvas .content-text h4 {
            font-size: 1em;
        }

        .paper-canvas .content-text h5 {
            font-size: 0.83em;
        }

        .paper-canvas .content-text h6 {
            font-size: 0.67em;
        } */

        .cke_warning,
        .cke_notifications_area {
            display: none !important;
        }
    </style>
</head>
