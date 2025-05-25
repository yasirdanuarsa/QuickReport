<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reminder Deadline</title>
</head>
<body>
    <p>Yth. {{ $laporan->petugas->name }},</p>

    <p>Laporan berikut telah melewati batas deadline:</p>

    <ul>
        <li><strong>Perihal:</strong> {{ $laporan->perihal }}</li>
        <li><strong>Tanggal Laporan:</strong> {{ $laporan->tanggal_laporan }}</li>
        <li><strong>Instansi:</strong> {{ $laporan->instansi }}</li>
        <li><strong>Deadline:</strong> {{ $laporan->deadline }}</li>
    </ul>

    <p>Mohon segera ditindaklanjuti. Terima kasih.</p>

    <p><em>Sistem QuickReport</em></p>
</body>
</html>
