<x-filament-panels::page>
    <style>
        .edu-sync-shell {
            display: grid;
            gap: 24px;
        }

        .edu-sync-hero {
            display: grid;
            gap: 24px;
            padding: 28px;
            border: 1px solid rgba(148, 163, 184, 0.14);
            border-radius: 28px;
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.18), transparent 30%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.14), transparent 22%),
                linear-gradient(135deg, #0f172a 0%, #111827 45%, #020617 100%);
            color: #f8fafc;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.28);
        }

        @media (min-width: 1100px) {
            .edu-sync-hero {
                grid-template-columns: minmax(0, 1.45fr) minmax(320px, 1fr);
            }
        }

        .edu-sync-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #cbd5e1;
        }

        .edu-sync-title {
            margin: 14px 0 8px;
            font-size: clamp(2rem, 3vw, 3rem);
            line-height: 1.04;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: #ffffff;
        }

        .edu-sync-lead {
            max-width: 760px;
            margin: 0;
            font-size: 15px;
            line-height: 1.7;
            color: rgba(226, 232, 240, 0.9);
        }

        .edu-sync-warning {
            margin-top: 18px;
            padding: 16px 18px;
            border-radius: 22px;
            border: 1px solid rgba(251, 191, 36, 0.2);
            background: rgba(251, 191, 36, 0.1);
            color: #fef3c7;
        }

        .edu-sync-warning-title {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .edu-sync-warning ul {
            margin: 0;
            padding-left: 18px;
        }

        .edu-sync-mini-grid {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        @media (min-width: 700px) {
            .edu-sync-mini-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .edu-sync-mini-card,
        .edu-sync-focus-card {
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
        }

        .edu-sync-mini-card {
            padding: 18px;
        }

        .edu-sync-mini-label,
        .edu-sync-focus-label,
        .edu-sync-panel-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .edu-sync-mini-label,
        .edu-sync-focus-label {
            color: rgba(203, 213, 225, 0.82);
        }

        .edu-sync-mini-value {
            margin-top: 10px;
            font-size: 30px;
            line-height: 1;
            font-weight: 800;
            color: #ffffff;
        }

        .edu-sync-mini-title {
            margin-top: 10px;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }

        .edu-sync-mini-text {
            margin-top: 10px;
            font-size: 12px;
            line-height: 1.65;
            color: rgba(203, 213, 225, 0.82);
        }

        .edu-sync-focus-card {
            padding: 22px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
        }

        .edu-sync-focus-header {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: flex-start;
        }

        .edu-sync-focus-title {
            margin-top: 10px;
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
        }

        .edu-sync-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .edu-sync-focus-grid {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        @media (min-width: 700px) {
            .edu-sync-focus-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .edu-sync-focus-item {
            padding: 16px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(2, 6, 23, 0.18);
        }

        .edu-sync-focus-item strong {
            display: block;
            margin-top: 10px;
            color: #f8fafc;
            font-size: 14px;
            line-height: 1.6;
            word-break: break-word;
        }

        .edu-sync-stat-grid {
            display: grid;
            gap: 16px;
        }

        @media (min-width: 700px) {
            .edu-sync-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1280px) {
            .edu-sync-stat-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        .edu-sync-stat-card {
            padding: 22px;
            border-radius: 26px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
        }

        .edu-sync-stat-card--amber {
            border-color: #fde68a;
            background: linear-gradient(180deg, #fffbeb 0%, #fef3c7 100%);
        }

        .edu-sync-stat-card--emerald {
            border-color: #a7f3d0;
            background: linear-gradient(180deg, #ecfdf5 0%, #d1fae5 100%);
        }

        .edu-sync-stat-card--rose {
            border-color: #fecdd3;
            background: linear-gradient(180deg, #fff1f2 0%, #ffe4e6 100%);
        }

        .edu-sync-stat-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #64748b;
        }

        .edu-sync-stat-value {
            margin-top: 12px;
            font-size: 34px;
            line-height: 1;
            font-weight: 800;
            letter-spacing: -0.05em;
            color: #0f172a;
        }

        .edu-sync-stat-text {
            margin-top: 10px;
            font-size: 13px;
            line-height: 1.7;
            color: #475569;
        }

        .edu-sync-panel {
            border: 1px solid #e2e8f0;
            border-radius: 28px;
            background: #ffffff;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
        }

        .edu-sync-panel-header {
            padding: 22px 24px 18px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
        }

        .edu-sync-panel-title {
            margin: 0;
            font-size: 20px;
            font-weight: 750;
            color: #0f172a;
        }

        .edu-sync-panel-text {
            margin-top: 6px;
            font-size: 13px;
            line-height: 1.7;
            color: #64748b;
        }

        .edu-sync-pill {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .edu-sync-filter-grid {
            display: grid;
            gap: 14px;
            padding: 22px 24px 24px;
        }

        @media (min-width: 1100px) {
            .edu-sync-filter-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        .edu-sync-field-label {
            display: block;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #64748b;
        }

        .edu-sync-select {
            width: 100%;
            min-height: 48px;
            padding: 0 14px;
            border: 1px solid #cbd5e1;
            border-radius: 18px;
            background: #f8fafc;
            color: #0f172a;
            font-size: 14px;
            outline: none;
        }

        .edu-sync-actions {
            display: flex;
            gap: 10px;
            align-items: end;
            flex-wrap: wrap;
        }

        .edu-sync-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 16px;
            border-radius: 18px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 160ms ease;
            cursor: pointer;
        }

        .edu-sync-btn--primary {
            background: #0f172a;
            color: #ffffff;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.14);
        }

        .edu-sync-btn--secondary {
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
        }

        .edu-sync-layout-2 {
            display: grid;
            gap: 24px;
        }

        @media (min-width: 1280px) {
            .edu-sync-layout-2 {
                grid-template-columns: minmax(0, 1.2fr) minmax(330px, 0.9fr);
            }
        }

        .edu-sync-table-wrap {
            overflow-x: auto;
        }

        .edu-sync-table {
            width: 100%;
            border-collapse: collapse;
        }

        .edu-sync-table thead {
            background: #f8fafc;
        }

        .edu-sync-table th,
        .edu-sync-table td {
            padding: 16px 20px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
        }

        .edu-sync-table th {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
        }

        .edu-sync-table td {
            font-size: 13px;
            color: #334155;
        }

        .edu-sync-table-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            font-size: 12px;
            color: #0f172a;
        }

        .edu-sync-muted {
            color: #64748b;
        }

        .edu-sync-empty {
            padding: 44px 24px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .edu-sync-attention-list {
            display: grid;
        }

        .edu-sync-attention-item {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
        }

        .edu-sync-attention-item:last-child {
            border-bottom: 0;
        }

        .edu-sync-attention-head {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
        }

        .edu-sync-attention-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }

        .edu-sync-attention-subtitle {
            margin-top: 4px;
            font-size: 12px;
            color: #64748b;
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
        }

        .edu-sync-attention-grid {
            display: grid;
            gap: 12px;
            margin-top: 14px;
        }

        @media (min-width: 700px) {
            .edu-sync-attention-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .edu-sync-attention-box {
            padding: 14px;
            border-radius: 18px;
            background: #f8fafc;
        }

        .edu-sync-attention-error {
            margin-top: 14px;
            padding: 14px;
            border-radius: 18px;
            border: 1px solid #fecdd3;
            background: #fff1f2;
            color: #be123c;
            font-size: 12px;
            line-height: 1.7;
        }

        .edu-sync-panel-label {
            color: #64748b;
        }
    </style>
    @if (! $this->hasSyncTables())
        <div class="rounded-2xl border border-danger-200 bg-danger-50 p-5 text-sm text-danger-700 shadow-sm">
            Tabel sinkronisasi belum tersedia. Jalankan migrasi terlebih dahulu agar fitur sinkronisasi dapat digunakan dari panel admin.
        </div>
    @else
        @php($configWarnings = $this->getConfigWarnings())
        @php($stats = $this->getSyncStats())
        @php($batches = $this->getRecentBatches())
        @php($outboxItems = $this->getRecentOutboxItems())
        @php($failedOutboxItems = $this->getFailedOutboxItems())
        @php($activeBatch = $this->getActiveBatchSummary())
        @php($activeBatchProgress = $this->getBatchProgress($activeBatch))

        <div class="edu-sync-shell">
            <section class="edu-sync-hero">
                <div>
                    <div class="edu-sync-kicker">
                            Integrasi Sistem
                    </div>
                    <h1 class="edu-sync-title">Sinkronisasi EDUSYNC OS</h1>
                    <p class="edu-sync-lead">
                        Terinspirasi dari pola dashboard operasional seperti GitHub Actions dan AWS DataSync:
                        fokus pada status aktif, prioritas tindakan, dan pemantauan batch yang cepat dipahami.
                    </p>

                        @if (count($configWarnings))
                            <div class="edu-sync-warning">
                                <div class="edu-sync-warning-title">Konfigurasi perlu dilengkapi</div>
                                <ul>
                                    @foreach ($configWarnings as $warning)
                                        <li>{{ $warning }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="edu-sync-mini-grid">
                            <div class="edu-sync-mini-card">
                                <div class="edu-sync-mini-label">Kondisi</div>
                                <div class="edu-sync-mini-title">
                                    {{ $activeBatch ? 'Perlu dipantau' : 'Stabil' }}
                                </div>
                                <p class="edu-sync-mini-text">
                                    {{ $activeBatch ? 'Masih ada batch aktif yang sedang berjalan atau perlu tindak lanjut.' : 'Tidak ada batch aktif yang memerlukan tindakan segera.' }}
                                </p>
                            </div>
                            <div class="edu-sync-mini-card">
                                <div class="edu-sync-mini-label">Batch Aktif</div>
                                <div class="edu-sync-mini-value">{{ $activeBatch ? 1 : 0 }}</div>
                                <p class="edu-sync-mini-text">Batch yang sedang menunggu, masuk antrean, atau masih proses kirim.</p>
                            </div>
                            <div class="edu-sync-mini-card">
                                <div class="edu-sync-mini-label">Item Retry</div>
                                <div class="edu-sync-mini-value">{{ $stats['retry'] }}</div>
                                <p class="edu-sync-mini-text">Jumlah item yang dapat diproses ulang dari panel ini.</p>
                            </div>
                        </div>
                </div>

                    <div class="edu-sync-focus-card">
                        <div class="edu-sync-focus-header">
                            <div>
                                <div class="edu-sync-focus-label">Batch Prioritas</div>
                                <div class="edu-sync-focus-title">
                                    {{ $activeBatch ? $this->getBatchStatusLabel($activeBatch->status) : 'Tidak ada batch aktif' }}
                                </div>
                            </div>

                            @if ($activeBatch)
                                <span class="edu-sync-badge {{ $this->getStatusBadgeClasses($activeBatch->status) }}">
                                    {{ $this->getBatchStatusLabel($activeBatch->status) }}
                                </span>
                            @endif
                        </div>

                        @if ($activeBatch)
                            <div class="edu-sync-progress">
                                <div class="edu-sync-progress-meta">
                                    <span>Progress batch aktif</span>
                                    <span>{{ $activeBatchProgress }}%</span>
                                </div>
                                <div class="edu-sync-progress-bar">
                                    <div class="edu-sync-progress-fill" style="width: {{ $activeBatchProgress }}%"></div>
                                </div>
                            </div>

                            <div class="edu-sync-focus-grid">
                                <div class="edu-sync-focus-item">
                                    <div class="edu-sync-focus-label">Batch</div>
                                    <strong>{{ $activeBatch->batch_id }}</strong>
                                </div>
                                <div class="edu-sync-focus-item">
                                    <div class="edu-sync-focus-label">Total Item</div>
                                    <strong>{{ $activeBatch->total_items }}</strong>
                                </div>
                                <div class="edu-sync-focus-item">
                                    <div class="edu-sync-focus-label">Terakhir Diperbarui</div>
                                    <strong>{{ \Illuminate\Support\Carbon::parse($activeBatch->updated_at)->diffForHumans() }}</strong>
                                </div>
                                <div class="edu-sync-focus-item">
                                    <div class="edu-sync-focus-label">Catatan</div>
                                    <strong>{{ $activeBatch->last_error ?: 'Tidak ada kendala yang tercatat.' }}</strong>
                                </div>
                            </div>
                        @else
                            <p class="edu-sync-mini-text">Semua batch saat ini sudah bersih atau belum ada data baru yang perlu diproses.</p>
                        @endif
                    </div>
            </section>

            <section class="edu-sync-stat-grid">
                <div class="edu-sync-stat-card">
                    <div class="edu-sync-stat-label">Menunggu Dikirim</div>
                    <div class="edu-sync-stat-value">{{ $stats['pending'] }}</div>
                    <p class="edu-sync-stat-text">Item yang sudah siap, tetapi belum diproses ke antrean pengiriman.</p>
                </div>
                <div class="edu-sync-stat-card edu-sync-stat-card--amber">
                    <div class="edu-sync-stat-label">Perlu Dicoba Lagi</div>
                    <div class="edu-sync-stat-value">{{ $stats['retry'] }}</div>
                    <p class="edu-sync-stat-text">Item yang gagal pada percobaan sebelumnya dan bisa diproses ulang.</p>
                </div>
                <div class="edu-sync-stat-card edu-sync-stat-card--emerald">
                    <div class="edu-sync-stat-label">Berhasil Sinkron</div>
                    <div class="edu-sync-stat-value">{{ $stats['synced'] }}</div>
                    <p class="edu-sync-stat-text">Total item yang sudah diterima dengan baik oleh server EDUSYNC OS.</p>
                </div>
                <div class="edu-sync-stat-card edu-sync-stat-card--rose">
                    <div class="edu-sync-stat-label">Batch Gagal</div>
                    <div class="edu-sync-stat-value">{{ $stats['failed_batches'] }}</div>
                    <p class="edu-sync-stat-text">Batch yang membutuhkan perhatian karena seluruh kirimannya tidak berhasil.</p>
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Filter Pemantauan</h2>
                        <p class="mt-1 text-sm text-slate-500">Gunakan filter untuk fokus pada batch atau jenis data tertentu.</p>
                    </div>

                    <div class="text-xs text-slate-400">
                        Tampilan tabel di bawah akan menyesuaikan filter yang dipilih.
                    </div>
                </div>

                <form method="GET" class="edu-sync-filter-grid">
                    <label>
                        <span class="edu-sync-field-label">Status batch</span>
                        <select name="batch_status" class="edu-sync-select">
                            @foreach ($this->getBatchStatusOptions() as $value => $label)
                                <option value="{{ $value }}" @selected(request()->query('batch_status', '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <span class="edu-sync-field-label">Status item</span>
                        <select name="outbox_status" class="edu-sync-select">
                            @foreach ($this->getOutboxStatusOptions() as $value => $label)
                                <option value="{{ $value }}" @selected(request()->query('outbox_status', '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <span class="edu-sync-field-label">Jenis data</span>
                        <select name="entity" class="edu-sync-select">
                            <option value="">Semua jenis data</option>
                            @foreach ($this->getEntityOptions() as $value => $label)
                                <option value="{{ $value }}" @selected(request()->query('entity', '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="edu-sync-actions">
                        <button type="submit" class="edu-sync-btn edu-sync-btn--primary">
                            Terapkan Filter
                        </button>
                        <a href="{{ request()->url() }}" class="edu-sync-btn edu-sync-btn--secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </section>

            <div class="edu-sync-layout-2">
                <section class="edu-sync-panel">
                    <div class="edu-sync-panel-header">
                        <div>
                            <h2 class="edu-sync-panel-title">Batch Sinkronisasi</h2>
                            <p class="edu-sync-panel-text">Daftar batch yang paling relevan berdasarkan filter dan status terkini.</p>
                        </div>
                        <span class="edu-sync-pill">Maks. 10 batch</span>
                    </div>

                    <div class="edu-sync-table-wrap">
                        <table class="edu-sync-table">
                            <thead>
                                <tr>
                                    <th>Batch</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Kendala</th>
                                    <th>Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($batches as $batch)
                                    <tr>
                                        <td><div class="edu-sync-table-mono">{{ $batch->batch_id }}</div></td>
                                        <td>
                                            <span class="edu-sync-badge {{ $this->getStatusBadgeClasses($batch->status) }}">
                                                <span class="edu-sync-status-icon edu-sync-status-icon--{{ $this->getStatusIcon($batch->status) }}"></span>
                                                {{ $this->getBatchStatusLabel($batch->status) }}
                                            </span>
                                        </td>
                                        <td><strong>{{ $batch->total_items }}</strong></td>
                                        <td class="edu-sync-muted">{{ $batch->last_error ?: 'Tidak ada kendala.' }}</td>
                                        <td class="edu-sync-muted">{{ \Illuminate\Support\Carbon::parse($batch->updated_at)->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="edu-sync-empty">Belum ada batch yang sesuai dengan filter saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="edu-sync-panel">
                    <div class="edu-sync-panel-header">
                        <div>
                            <h2 class="edu-sync-panel-title">Item Perlu Perhatian</h2>
                            <p class="edu-sync-panel-text">Item retry terbaru yang bisa diproses ulang dari panel ini.</p>
                        </div>
                        <span class="edu-sync-pill" style="background:#fef3c7;color:#92400e;">Retry</span>
                    </div>

                    <div class="edu-sync-attention-list">
                        @forelse ($failedOutboxItems as $item)
                            <div class="edu-sync-attention-item">
                                <div class="edu-sync-attention-head">
                                    <div>
                                        <div class="edu-sync-attention-title">{{ $this->getEntityLabel($item->entity) }}</div>
                                        <div class="edu-sync-attention-subtitle">Record ID: {{ $item->record_id }}</div>
                                    </div>
                                    <span class="edu-sync-badge {{ $this->getStatusBadgeClasses($item->status) }}">
                                        <span class="edu-sync-status-icon edu-sync-status-icon--{{ $this->getStatusIcon($item->status) }}"></span>
                                        {{ $this->getOutboxStatusLabel($item->status) }}
                                    </span>
                                </div>

                                <div class="edu-sync-attention-grid">
                                    <div class="edu-sync-attention-box">
                                        <div class="edu-sync-panel-label">Percobaan</div>
                                        <strong>{{ $item->attempt_count }}</strong>
                                    </div>
                                    <div class="edu-sync-attention-box">
                                        <div class="edu-sync-panel-label">Terakhir Diperbarui</div>
                                        <strong>{{ \Illuminate\Support\Carbon::parse($item->updated_at)->diffForHumans() }}</strong>
                                    </div>
                                </div>

                                @if ($item->last_error)
                                    <details class="edu-sync-details">
                                        <summary>Lihat detail kendala</summary>
                                        <div class="edu-sync-details-body">{{ $item->last_error }}</div>
                                    </details>
                                @endif
                            </div>
                        @empty
                            <div class="edu-sync-empty">Tidak ada item retry. Semua data pada filter saat ini sudah bersih.</div>
                        @endforelse
                    </div>
                </section>
            </div>

            <section class="edu-sync-panel">
                <div class="edu-sync-panel-header">
                    <div>
                        <h2 class="edu-sync-panel-title">Riwayat Item Outbox</h2>
                        <p class="edu-sync-panel-text">Item sinkronisasi terbaru sesuai filter yang sedang aktif.</p>
                    </div>
                    <span class="edu-sync-pill">Maks. 10 item</span>
                </div>

                <div class="edu-sync-table-wrap">
                    <table class="edu-sync-table">
                        <thead>
                            <tr>
                                <th>Jenis Data</th>
                                <th>Record ID</th>
                                <th>Status</th>
                                <th>Detail</th>
                                <th>Diperbarui</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($outboxItems as $item)
                                <tr>
                                    <td><strong>{{ $this->getEntityLabel($item->entity) }}</strong></td>
                                    <td><span class="edu-sync-table-mono">{{ $item->record_id }}</span></td>
                                    <td>
                                        <span class="edu-sync-badge {{ $this->getStatusBadgeClasses($item->status) }}">
                                            <span class="edu-sync-status-icon edu-sync-status-icon--{{ $this->getStatusIcon($item->status) }}"></span>
                                            {{ $this->getOutboxStatusLabel($item->status) }}
                                        </span>
                                    </td>
                                    <td class="edu-sync-muted">{{ $item->last_error ?: 'Tidak ada kendala.' }}</td>
                                    <td class="edu-sync-muted">{{ \Illuminate\Support\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="edu-sync-empty">Belum ada item outbox yang sesuai dengan filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    @endif
</x-filament-panels::page>
