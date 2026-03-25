<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            line-height: 1.6;
            margin: 36px;
        }
        .meta {
            margin-bottom: 20px;
        }
        .meta-row {
            margin-bottom: 4px;
        }
        .label {
            display: inline-block;
            width: 110px;
            color: #4b5563;
        }
        .subject {
            margin: 14px 0 18px;
            font-size: 15px;
            font-weight: 700;
        }
        .content {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="meta">
        <div class="meta-row"><span class="label">Nomor Surat</span>: {{ $letter->letter_number ?: '-' }}</div>
        <div class="meta-row"><span class="label">Tanggal</span>: {{ $letter->letter_date?->format('d-m-Y') ?: '-' }}</div>
        <div class="meta-row"><span class="label">Kategori</span>: {{ $letter->category?->name ?: '-' }}</div>
    </div>

    <div class="subject">Perihal: {{ $subject }}</div>

    <div class="content">
        {!! $contentHtml !!}
    </div>
</body>
</html>
