@extends('layouts.admin')

@section('title', 'Dashboard Analytics')
@section('page_title', 'Dashboard Analytics')
@section('page_subtitle', 'Statistik posting berita harian, bulanan, dan tahunan FZN NEWS')

@push('styles')
<style>
/* ─── STAT CARDS ─────────────────────────────────────── */
.admin-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 24px;
}

.stat-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 18px 16px;
    display: flex;
    flex-direction: row;         /* ALWAYS row — never column */
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    transition: transform .2s, box-shadow .2s;
    position: relative;
    overflow: visible;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 4px; height: 100%;
    background: var(--admin-primary);
    border-radius: 14px 0 0 14px;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(28,68,36,.12);
}

.stat-icon-wrap {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #1c4424 0%, #2e6b3c 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.stat-info {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.stat-count {
    font-size: 1.6rem;
    font-weight: 900;
    color: #1e293b;
    line-height: 1.1;
    white-space: nowrap;
}

.stat-label {
    font-size: 0.74rem;
    color: #64748b;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.stat-badge {
    font-size: 0.68rem;
    font-weight: 800;
    padding: 4px 8px;
    border-radius: 20px;
    white-space: nowrap;
    flex-shrink: 0;
    align-self: flex-start;
}

.badge-up { background: #d1fae5; color: #065f46; }
.badge-down { background: #fee2e2; color: #991b1b; }
.badge-neutral { background: #e2e8f0; color: #475569; }

/* ─── CHARTS ROW ─────────────────────────────────────── */
.admin-charts-row {
    display: grid;
    grid-template-columns: 2.2fr 1fr;
    gap: 18px;
    margin-bottom: 24px;
}

.chart-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.chart-header h2 {
    font-size: 0.95rem;
    font-weight: 800;
    color: #1e293b;
}

.chart-header p {
    font-size: 0.72rem;
    color: #94a3b8;
    margin-top: 2px;
}

.chart-tabs {
    display: flex;
    gap: 3px;
    background: #f1f5f9;
    padding: 3px;
    border-radius: 8px;
    flex-shrink: 0;
}

.chart-tab-btn {
    background: transparent;
    border: none;
    padding: 5px 10px;
    font-size: 0.71rem;
    font-weight: 700;
    color: #64748b;
    border-radius: 6px;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
}

.chart-tab-btn.active {
    background: #1c4424;
    color: #fff;
}

.chart-tab-btn:hover:not(.active) {
    background: #e2e8f0;
    color: #1e293b;
}

.chart-body {
    flex: 1;
    position: relative;
    min-height: 220px;
}

.chart-body--center {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Doughnut legend */
.donut-legend {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.donut-legend-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.72rem;
    font-weight: 600;
    color: #475569;
    gap: 6px;
}

.donut-legend-dot {
    width: 10px; height: 10px;
    border-radius: 3px;
    margin-right: 6px;
    flex-shrink: 0;
}

/* ─── BOTTOM ROW (Activity + Quick Actions) ──────────── */
.admin-bottom-row {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 18px;
    margin-bottom: 24px;
}

/* ─── RECENT ACTIVITY ────────────────────────────────── */
.activity-card,
.quick-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    min-width: 0;
}

.card-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
    flex-wrap: nowrap;
}

.card-head h2 {
    font-size: 0.95rem;
    font-weight: 800;
    color: #1e293b;
    white-space: nowrap;
}

.card-head a {
    font-size: 0.74rem;
    font-weight: 700;
    color: #1c4424;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
}

.card-head a:hover { text-decoration: underline; }

.activity-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.activity-item:last-child { border-bottom: none; padding-bottom: 0; }

.activity-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    margin-top: 5px;
    flex-shrink: 0;
}

.dot-green { background: #10b981; }
.dot-blue  { background: #3b82f6; }
.dot-amber { background: #f59e0b; }
.dot-red   { background: #ef4444; }

.activity-text { flex: 1; min-width: 0; }

.activity-text strong {
    font-size: 0.82rem;
    font-weight: 700;
    color: #1e293b;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.activity-text small {
    font-size: 0.7rem;
    color: #94a3b8;
}

.activity-badge {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 3px 7px;
    border-radius: 10px;
    white-space: nowrap;
    flex-shrink: 0;
}

.ab-published { background: #d1fae5; color: #065f46; }
.ab-draft     { background: #fef3c7; color: #92400e; }

/* ─── QUICK ACTIONS ──────────────────────────────────── */
.quick-card h2 {
    font-size: 0.95rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 14px;
}

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.quick-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 14px;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: all .2s;
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.quick-btn span {
    font-size: 1.1rem;
    flex-shrink: 0;
}

.qb-primary {
    background: linear-gradient(135deg, #1c4424, #2e6b3c);
    color: #fff;
}

.qb-primary:hover { opacity: .9; transform: translateX(3px); }

.qb-outline {
    background: #f8fafc;
    color: #1e293b;
    border: 1.5px solid #e2e8f0;
}

.qb-outline:hover {
    background: #e2e8f0;
    transform: translateX(3px);
}

.quick-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 2px 0;
}

/* ─── PROGRESS BARS ──────────────────────────────────── */
.progress-section {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    margin-bottom: 24px;
}

.progress-section h2 {
    font-size: 1rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 18px;
}

.progress-list { display: flex; flex-direction: column; gap: 14px; }

.progress-item {}

.progress-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
}

.progress-meta span { font-size: 0.8rem; font-weight: 600; color: #475569; }
.progress-meta strong { font-size: 0.8rem; font-weight: 800; color: #1e293b; }

.progress-bar-bg {
    height: 8px;
    background: #f1f5f9;
    border-radius: 99px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, #1c4424, #62c47a);
    transition: width .8s ease;
    width: 0;
}

/* ─── RESPONSIVE ─────────────────────────────────────── */

/* --- Large tablet (≤ 1100px): stack charts and bottom row --- */
@media (max-width: 1100px) {
    .admin-charts-row { grid-template-columns: 1fr; }
    .admin-bottom-row { grid-template-columns: 1fr; }
}

/* --- Tablet (≤ 768px) --- */
@media (max-width: 768px) {
    .admin-stats {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    /* Stat card: always horizontal row */
    .stat-card {
        flex-direction: row;
        align-items: center;
        padding: 14px 12px;
        gap: 12px;
    }

    .stat-icon-wrap {
        width: 42px; height: 42px;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-count { font-size: 1.35rem; }

    .stat-badge {
        align-self: center;
        flex-shrink: 0;
    }

    /* Chart tabs become equal-width */
    .chart-header {
        flex-direction: column;
        align-items: stretch;
    }

    .chart-tabs {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }

    .chart-tab-btn { text-align: center; }

    .admin-bottom-row { grid-template-columns: 1fr; }

    /* Card head: never overflow */
    .card-head {
        flex-wrap: nowrap;
        gap: 6px;
    }

    .card-head h2 { font-size: 0.88rem; }
    .card-head a  { font-size: 0.72rem; }

    /* Quick buttons: fixed layout */
    .quick-btn {
        padding: 10px 12px;
        font-size: 0.8rem;
    }
}

/* --- Phone (≤ 480px) --- */
@media (max-width: 480px) {
    .admin-stats { gap: 8px; }

    .stat-card { padding: 12px 10px; gap: 10px; }
    .stat-icon-wrap { width: 36px; height: 36px; font-size: 1rem; }
    .stat-count { font-size: 1.2rem; }
    .stat-label { font-size: 0.7rem; }

    .chart-card,
    .activity-card,
    .quick-card,
    .progress-section { padding: 14px; }

    .chart-header h2 { font-size: 0.88rem; }
    .progress-section h2 { font-size: 0.9rem; }
}
</style>
@endpush

@section('content')

{{-- ─── STAT CARDS ───────────────────────────────────────── --}}
<section class="admin-stats">
    <div class="stat-card">
        <div class="stat-icon-wrap">📝</div>
        <div class="stat-info">
            <div class="stat-count" data-count="{{ $stats['today'] }}">0</div>
            <div class="stat-label">Berita Diposting <strong>Hari Ini</strong></div>
        </div>
        <span class="stat-badge badge-neutral">Hari Ini</span>
    </div>

    <div class="stat-card">
        <div class="stat-icon-wrap">📅</div>
        <div class="stat-info">
            <div class="stat-count" data-count="{{ $stats['this_month'] }}">0</div>
            <div class="stat-label">Berita Diposting <strong>Bulan Ini</strong></div>
        </div>
        <span class="stat-badge badge-neutral">Bulan Ini</span>
    </div>

    <div class="stat-card">
        <div class="stat-icon-wrap">📈</div>
        <div class="stat-info">
            <div class="stat-count" data-count="{{ $stats['this_year'] }}">0</div>
            <div class="stat-label">Berita Diposting <strong>Tahun Ini</strong></div>
        </div>
        <span class="stat-badge badge-neutral">Tahun {{ date('Y') }}</span>
    </div>
</section>

{{-- ─── CHARTS ROW ───────────────────────────────────────── --}}
<section class="admin-charts-row">

    {{-- Bar Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <h2>Grafik Banyak Berita Diposting</h2>
                <p id="chartSubtitle">Visualisasi jumlah posting berita per bulan (2026)</p>
            </div>
            <div class="chart-tabs">
                <button class="chart-tab-btn" onclick="updateChart(this,'today')">Hari Ini</button>
                <button class="chart-tab-btn active" onclick="updateChart(this,'month')">Bulan Ini</button>
                <button class="chart-tab-btn" onclick="updateChart(this,'year')">Tahun Ini</button>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="postsChart"></canvas>
        </div>
    </div>

    {{-- Doughnut Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <h2>Distribusi Kategori</h2>
                <p>Persentase posting per kategori</p>
            </div>
        </div>
        <div class="chart-body chart-body--center">
            <canvas id="categoryChart"></canvas>
        </div>
        <div class="donut-legend" id="donutLegend"></div>
    </div>

</section>

{{-- ─── BOTTOM ROW ───────────────────────────────────────── --}}
<div class="admin-bottom-row">

    {{-- Recent Activity --}}
    <div class="activity-card">
        <div class="card-head">
            <h2>📋 Aktivitas Terbaru</h2>
            <a href="{{ route('admin.kelola-berita') }}">Lihat Semua →</a>
        </div>
        <ul class="activity-list">
            @forelse($recentArticles as $article)
                <li class="activity-item">
                    <span class="activity-dot {{ $article->status === 'published' ? 'dot-green' : 'dot-amber' }}"></span>
                    <div class="activity-text">
                        <strong>{{ $article->title }}</strong>
                        <small>Diposting oleh {{ $article->user ? $article->user->name : 'Admin' }} · {{ $article->created_at ? $article->created_at->diffForHumans() : '' }}</small>
                    </div>
                    <span class="activity-badge {{ $article->status === 'published' ? 'ab-published' : 'ab-draft' }}">{{ ucfirst($article->status) }}</span>
                </li>
            @empty
                <li class="activity-item" style="border:none;">
                    <div class="activity-text" style="text-align:center; padding:20px 0;">
                        <small>Belum ada aktivitas berita baru.</small>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>

    {{-- Quick Actions --}}
    <div class="quick-card">
        <h2>⚡ Aksi Cepat</h2>
        <div class="quick-actions">
            <a href="{{ route('admin.post-berita') }}" class="quick-btn qb-primary">
                <span>📝</span> Post Berita Baru
            </a>
            <div class="quick-divider"></div>
            <a href="{{ route('admin.layout-mapping') }}" class="quick-btn qb-outline">
                <span>⚡</span> Lihat Layout Mapping
            </a>
            <a href="{{ route('admin.kelola-berita') }}" class="quick-btn qb-outline">
                <span>📰</span> Kelola Semua Berita
            </a>
            <a href="{{ route('home') }}" target="_blank" class="quick-btn qb-outline">
                <span>🌐</span> Buka Landing Page
            </a>
        </div>

        {{-- Mini Summary --}}
        <div style="margin-top:20px; padding-top:16px; border-top:1px solid #f1f5f9;">
            <p style="font-size:.75rem; font-weight:700; color:#94a3b8; margin-bottom:10px;">RINGKASAN SLOT HERO</p>
            <div style="display:flex; justify-content:space-between; font-size:.82rem; margin-bottom:6px;">
                <span style="color:#475569;">Slot Terisi</span>
                <strong style="color:#1c4424;">7 / 7</strong>
            </div>
            <div class="progress-bar-bg" style="margin-bottom:8px;">
                <div class="progress-bar-fill" data-width="100" style="background:linear-gradient(90deg,#1c4424,#62c47a);"></div>
            </div>
            <p style="font-size:.72rem; color:#10b981; font-weight:700;">✅ Semua slot terpenuhi</p>
        </div>
    </div>

</div>

{{-- ─── CATEGORY PROGRESS BARS ──────────────────────────── --}}
<section class="progress-section">
    <h2>📊 Produktivitas Per Kategori</h2>
    <div class="progress-list">
        @php
            $colors = ['#1c4424', '#2e6b3c', '#429b57', '#62c47a', '#8fe0a2', '#c2f3cc'];
            $maxArticles = $categories->max('articles_count') ?: 1;
        @endphp
        @foreach($categories as $index => $cat)
            @php $color = $colors[$index % count($colors)]; @endphp
            <div class="progress-item">
                <div class="progress-meta">
                    <span>{{ $cat->name }}</span>
                    <strong>{{ $cat->articles_count }} berita</strong>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill"
                         data-width="{{ round(($cat->articles_count / $maxArticles) * 100) }}"
                         style="background: {{ $color }};"></div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection

@push('scripts')
<script>
/* ─── DATA FROM SERVER ───────────────────────── */
const monthlyData = {
    labels: {!! json_encode($chartMonthly['labels']) !!},
    data:   {!! json_encode($chartMonthly['data']) !!}
};
const dailyData = {
    labels: {!! json_encode($chartDaily['labels']) !!},
    data:   {!! json_encode($chartDaily['data']) !!}
};
const yearlyData = {
    labels: {!! json_encode($chartYearly['labels']) !!},
    data:   {!! json_encode($chartYearly['data']) !!}
};
const categoryData = {
    labels: {!! json_encode($chartCategory['labels']) !!},
    data:   {!! json_encode($chartCategory['data']) !!}
};

/* ─── STAT COUNTER ANIMATION ─────────────────── */
document.querySelectorAll('.stat-count').forEach(el => {
    const target = parseInt(el.dataset.count, 10);
    const duration = 900;
    const step = Math.ceil(target / (duration / 16));
    let current = 0;
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = current.toLocaleString('id-ID');
        if (current >= target) clearInterval(timer);
    }, 16);
});

/* ─── BAR CHART ──────────────────────────────── */
const ctxPosts = document.getElementById('postsChart').getContext('2d');
let postsChart = new Chart(ctxPosts, {
    type: 'bar',
    data: {
        labels: monthlyData.labels,
        datasets: [{
            label: 'Jumlah Berita Diposting',
            data: monthlyData.data,
            backgroundColor: ctx => {
                const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 260);
                g.addColorStop(0, '#2e6b3c');
                g.addColorStop(1, '#1c4424');
                return g;
            },
            borderColor: '#123018',
            borderWidth: 0,
            borderRadius: 6,
            hoverBackgroundColor: '#62c47a'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 600, easing: 'easeInOutQuart' },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1c4424',
                titleColor: '#fff',
                bodyColor: '#d1fae5',
                borderColor: '#2e6b3c',
                borderWidth: 1,
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                    label: ctx => ` ${ctx.parsed.y} berita`
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9', drawBorder: false },
                ticks: { font: { size: 11 }, color: '#94a3b8' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 }, color: '#64748b' }
            }
        }
    }
});

/* ─── DOUGHNUT CHART ─────────────────────────── */
const donutColors = ['#1c4424','#2e6b3c','#429b57','#62c47a','#8fe0a2','#c2f3cc'];
const ctxCat = document.getElementById('categoryChart').getContext('2d');
new Chart(ctxCat, {
    type: 'doughnut',
    data: {
        labels: categoryData.labels,
        datasets: [{
            data: categoryData.data,
            backgroundColor: donutColors,
            borderWidth: 3,
            borderColor: '#fff',
            hoverOffset: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1c4424',
                titleColor: '#fff',
                bodyColor: '#d1fae5',
                borderColor: '#2e6b3c',
                borderWidth: 1,
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed} artikel`
                }
            }
        }
    }
});

/* Build custom legend */
const legendWrap = document.getElementById('donutLegend');
categoryData.labels.forEach((label, i) => {
    legendWrap.innerHTML += `
        <div class="donut-legend-item">
            <div style="display:flex;align-items:center;">
                <span class="donut-legend-dot" style="background:${donutColors[i]};"></span>
                ${label}
            </div>
            <strong>${categoryData.data[i]} artikel</strong>
        </div>`;
});

/* ─── CHART PERIOD SWITCHER ──────────────────── */
const chartSubtitles = {
    today: 'Visualisasi jumlah posting harian (minggu ini)',
    month: 'Visualisasi jumlah posting berita per bulan (2026)',
    year:  'Visualisasi jumlah posting berita per tahun'
};

function updateChart(btn, period) {
    document.querySelectorAll('.chart-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const map = { today: dailyData, month: monthlyData, year: yearlyData };
    const labels = {
        today: 'Berita Harian (Minggu Ini)',
        month: 'Berita Bulanan (2026)',
        year:  'Berita Tahunan'
    };

    postsChart.data.labels = map[period].labels;
    postsChart.data.datasets[0].data = map[period].data;
    postsChart.data.datasets[0].label = labels[period];
    postsChart.update();

    document.getElementById('chartSubtitle').textContent = chartSubtitles[period];
}

/* ─── PROGRESS BAR ANIMATION ─────────────────── */
window.addEventListener('load', () => {
    setTimeout(() => {
        document.querySelectorAll('.progress-bar-fill').forEach(bar => {
            bar.style.width = (bar.dataset.width || '0') + '%';
        });
    }, 300);
});
</script>
@endpush
