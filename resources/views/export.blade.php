<!DOCTYPE html>
<html>

<head>
    <title>{{ $tabloid->title }}</title>
    <style>
        /* Tambahkan CSS yang relevan untuk rendering PDF di sini */
        body {
            /* font-family: sans-serif; */
            margin: 0;
            padding: 0;
        }

        .paper-canvas {
            width: 210mm;
            height: 297mm;
            position: relative;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .draggable-layout {
            position: absolute;
            /* border: 1px solid #eee;
            background-color: #f9f9f9;
            box-sizing: border-box; */
        }

        .inner-layout-box {
            width: 100%;
            height: 100%;
            /* display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; */
        }

        .content-text,
        .content-image {
            display: block;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: auto;
        }


        .content-text {
            overflow: hidden;
            font-size: 0.9em;
            /* color: #555; */
        }

        /* .content-text {
            font-size: 12px;
            padding: 5px;
            box-sizing: border-box;
        } */

        .content-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: fill;
        }
    </style>
</head>

<body>
    @foreach ($tabloid->pages as $page)
        <div class="paper-canvas" style="page-break-after: always;">
            <div class="page"> {{-- Penting untuk halaman terpisah --}}
                {{-- Render layout untuk halaman ini --}}
                {{-- /* Konversi grid unit ke mm, sesuaikan dengan skala Anda */ --}}
                @foreach ($page->data as $layout)
                    <div class="draggable-layout"
                        style="
                        top: {{ $layout->rowStart * 7.42 }}mm;
                        left: {{ $layout->colStart * 5.83 }}mm;
                        width: {{ $layout->spanCols * 5.83 }}mm;
                        height: {{ $layout->spanRows * 7.42 }}mm;
                    ">
                        @if (isset($layout->content) && !empty($layout->content))
                            <div class="inner-layout-box">
                                @if ($layout->content->type === 'text')
                                    <div class="content-text">{!! $layout->content->html !!}</div>
                                @elseif ($layout->content->type === 'image')
                                    {{-- Pastikan ini adalah URL publik yang bisa diakses Dompdf --}}
                                    <img class="content-image" src="{{ asset($layout->content->src) }}"
                                        alt="{{ $layout->content->alt }}">
                                    {{-- <img class="content-image"
                                        src="{{ asset('storage/' . $layout->image->storage_path) }}"
                                        alt="{{ $layout->image->file_name }}"> --}}
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>

</html>
