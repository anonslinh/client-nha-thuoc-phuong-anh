@extends('website.layout.index')

@section('style')
<style>
    .near-branch-page{
        padding: 28px 0 56px;
        background: #f6f8fc;
    }

    .near-branch-container{
        width: min(1280px, calc(100% - 32px));
        margin: 0 auto;
    }

    .near-branch-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        font-size: 14px;
        color: #667085;
    }

    .near-branch-breadcrumb a{
        color: #0ea5c6;
        text-decoration: none;
    }

    .near-branch-breadcrumb a:hover{
        text-decoration: underline;
    }

    .near-branch-hero{
        background: linear-gradient(135deg, #12b8d4 0%, #1687cb 100%);
        border-radius: 28px;
        padding: 34px 36px;
        color: #fff;
        margin-bottom: 22px;
        box-shadow: 0 24px 50px rgba(20, 144, 207, .18);
    }

    .near-branch-hero-badge{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.18);
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .near-branch-hero h1{
        margin: 0 0 12px;
        font-size: 40px;
        line-height: 1.2;
        font-weight: 800;
    }

    .near-branch-hero p{
        margin: 0;
        max-width: 860px;
        font-size: 17px;
        line-height: 1.8;
        color: rgba(255,255,255,.93);
    }

    .near-branch-toolbar{
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto auto;
        gap: 14px;
        margin-bottom: 20px;
        align-items: center;
    }

    .near-branch-status{
        background: #fff;
        border-radius: 18px;
        padding: 14px 18px;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.07);
        color: #475467;
        font-size: 15px;
        line-height: 1.6;
    }

    .near-branch-btn{
        border: 0;
        outline: 0;
        cursor: pointer;
        height: 50px;
        padding: 0 18px;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 800;
        transition: all .2s ease;
    }

    .near-branch-btn--primary{
        background: linear-gradient(135deg, #12b8d4 0%, #1687cb 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(20, 144, 207, .18);
    }

    .near-branch-btn--primary:hover{
        transform: translateY(-1px);
    }

    .near-branch-btn--light{
        background: #fff;
        color: #0f172a;
        border: 1px solid #dbe5ef;
    }

    .near-branch-btn--light:hover{
        border-color: #0ea5c6;
        color: #0ea5c6;
    }

    .near-branch-layout{
        display: grid;
        grid-template-columns: minmax(0, 1.08fr) 420px;
        gap: 22px;
        align-items: start;
    }

    .near-branch-map-card,
    .near-branch-list-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .near-branch-map-head,
    .near-branch-list-head{
        padding: 20px 22px;
        border-bottom: 1px solid #edf2f7;
    }

    .near-branch-map-head h2,
    .near-branch-list-head h2{
        margin: 0 0 6px;
        font-size: 24px;
        line-height: 1.3;
        font-weight: 800;
        color: #0f172a;
    }

    .near-branch-map-head p,
    .near-branch-list-head p{
        margin: 0;
        font-size: 14px;
        color: #667085;
        line-height: 1.6;
    }

    #nearBranchMap{
        width: 100%;
        height: 720px;
        background: #eef3f8;
    }

    .near-branch-list-wrap{
        padding: 16px;
        max-height: 720px;
        overflow: auto;
    }

    .near-branch-empty{
        padding: 30px 20px;
        text-align: center;
        color: #667085;
        font-size: 15px;
    }

    .near-branch-item{
        border: 1px solid #e7eef5;
        border-radius: 20px;
        padding: 16px;
        background: #fff;
        transition: all .2s ease;
    }

    .near-branch-item + .near-branch-item{
        margin-top: 14px;
    }

    .near-branch-item:hover{
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
        transform: translateY(-2px);
    }

    .near-branch-item--active{
        border-color: #16a3cf;
        box-shadow: 0 16px 34px rgba(20, 144, 207, 0.12);
        background: linear-gradient(180deg, #ffffff 0%, #f8fdff 100%);
    }

    .near-branch-item-top{
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
    }

    .near-branch-rank{
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #12b8d4 0%, #1687cb 100%);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(20, 144, 207, .22);
    }

    .near-branch-distance{
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        padding: 8px 12px;
        border-radius: 999px;
        background: #eaf9fd;
        color: #0ea5c6;
        font-size: 13px;
        font-weight: 800;
    }

    .near-branch-name{
        margin: 0 0 8px;
        font-size: 20px;
        line-height: 1.4;
        font-weight: 800;
        color: #0f172a;
    }

    .near-branch-code{
        margin: 0 0 10px;
        font-size: 13px;
        color: #667085;
        font-weight: 700;
    }

    .near-branch-meta{
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 14px;
    }

    .near-branch-meta-item{
        font-size: 14px;
        line-height: 1.6;
        color: #475467;
    }

    .near-branch-meta-item strong{
        color: #0f172a;
    }

    .near-branch-actions{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .near-branch-link{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 0 14px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 800;
        transition: all .2s ease;
    }

    .near-branch-link--primary{
        background: linear-gradient(135deg, #12b8d4 0%, #1687cb 100%);
        color: #fff;
        box-shadow: 0 10px 22px rgba(20, 144, 207, 0.16);
    }

    .near-branch-link--secondary{
        background: #f7fafc;
        border: 1px solid #dbe5ef;
        color: #0f172a;
    }

    .near-branch-link:hover{
        transform: translateY(-1px);
    }

    .near-branch-note{
        margin-top: 18px;
        padding: 14px 16px;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.06);
        color: #667085;
        font-size: 14px;
        line-height: 1.7;
    }

    @media (max-width: 1199px){
        .near-branch-layout{
            grid-template-columns: 1fr;
        }

        #nearBranchMap{
            height: 460px;
        }

        .near-branch-list-wrap{
            max-height: unset;
        }
    }

    @media (max-width: 767px){
        .near-branch-page{
            padding: 20px 0 40px;
        }

        .near-branch-container{
            width: min(100%, calc(100% - 20px));
        }

        .near-branch-hero{
            padding: 22px 18px;
            border-radius: 22px;
        }

        .near-branch-hero h1{
            font-size: 28px;
        }

        .near-branch-hero p{
            font-size: 15px;
        }

        .near-branch-toolbar{
            grid-template-columns: 1fr;
        }

        .near-branch-map-head,
        .near-branch-list-head{
            padding: 18px;
        }

        .near-branch-map-head h2,
        .near-branch-list-head h2{
            font-size: 20px;
        }

        #nearBranchMap{
            height: 360px;
        }

        .near-branch-list-wrap{
            padding: 12px;
        }

        .near-branch-item{
            padding: 14px;
            border-radius: 18px;
        }

        .near-branch-item-top{
            flex-direction: column;
        }

        .near-branch-name{
            font-size: 18px;
        }

        .near-branch-actions{
            flex-direction: column;
        }

        .near-branch-link{
            width: 100%;
        }
    }
</style>

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
/>
@endsection

@section('content')
<section class="near-branch-page">
    <div class="near-branch-container">
        <nav class="near-branch-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <span>Chi nhánh gần tôi</span>
        </nav>

        <div class="near-branch-hero">
            <div class="near-branch-hero-badge">
                <span>📍</span>
                <span>Tìm nhà thuốc gần nhất</span>
            </div>
            <h1>Chi nhánh gần tôi</h1>
            <p>
                Cho phép truy cập vị trí để hệ thống xác định các chi nhánh Nhà thuốc Phương Anh gần bạn nhất,
                sắp xếp theo khoảng cách thực tế và hỗ trợ chỉ đường nhanh bằng Google Maps.
            </p>
        </div>

        <div class="near-branch-toolbar">
            <div class="near-branch-status" id="nearBranchStatus">
                Hệ thống đang chờ bạn cấp quyền truy cập vị trí để sắp xếp chi nhánh theo khoảng cách gần nhất.
            </div>

            <button type="button" class="near-branch-btn near-branch-btn--primary" id="btnGetLocation">
                Dùng vị trí của tôi
            </button>

            <button type="button" class="near-branch-btn near-branch-btn--light" id="btnResetBranches">
                Xem mặc định
            </button>
        </div>

        <div class="near-branch-layout">
            <div>
                <div class="near-branch-map-card">
                    <div class="near-branch-map-head">
                        <h2>Bản đồ chi nhánh</h2>
                        <p>Chạm vào marker để xem thông tin nhanh và mở chỉ đường.</p>
                    </div>
                    <div id="nearBranchMap"></div>
                </div>

                <div class="near-branch-note">
                    Khoảng cách hiển thị được tính từ vị trí hiện tại của bạn tới từng chi nhánh theo tọa độ vĩ độ - kinh độ.
                    Sai số nhỏ có thể xảy ra tùy vào độ chính xác GPS của thiết bị.
                </div>
            </div>

            <div class="near-branch-list-card">
                <div class="near-branch-list-head">
                    <h2>Danh sách chi nhánh</h2>
                    <p>Sắp xếp từ gần tới xa sau khi cấp quyền vị trí.</p>
                </div>

                <div class="near-branch-list-wrap" id="nearBranchList"></div>
            </div>
        </div>
    </div>
</section>

<script id="branchDataJson" type="application/json">
{!! json_encode($branches, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
></script>

<script>
    (function () {
        const rawData = document.getElementById('branchDataJson');
        const listEl = document.getElementById('nearBranchList');
        const statusEl = document.getElementById('nearBranchStatus');
        const btnGetLocation = document.getElementById('btnGetLocation');
        const btnReset = document.getElementById('btnResetBranches');

        if (!rawData || !listEl) return;

        let branches = [];
        try {
            branches = JSON.parse(rawData.textContent || '[]');
        } catch (e) {
            branches = [];
        }

        branches = branches.map((item) => ({
            ...item,
            lat: Number(item.lat),
            lng: Number(item.lng),
            distance_km: null
        }));

        const defaultCenter = branches.length
            ? [branches[0].lat, branches[0].lng]
            : [21.0285, 105.8542];

        const map = L.map('nearBranchMap', {
            zoomControl: true
        }).setView(defaultCenter, branches.length ? 12 : 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let branchMarkersLayer = L.layerGroup().addTo(map);
        let userMarker = null;
        let currentUserLatLng = null;

        function escapeHtml(str) {
            return String(str || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatKm(km) {
            if (km === null || km === undefined || Number.isNaN(km)) {
                return 'Chưa xác định';
            }
            if (km < 1) {
                return (km * 1000).toFixed(0) + ' m';
            }
            return km.toFixed(2) + ' km';
        }

        function haversineDistance(lat1, lon1, lat2, lon2) {
            const toRad = (deg) => deg * Math.PI / 180;
            const R = 6371;
            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(lon2 - lon1);

            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function buildPopupHtml(item) {
            const directionLink = item.google_maps_direction || ('https://www.google.com/maps/dir/?api=1&destination=' + item.lat + ',' + item.lng);
            const mapLink = item.google_maps_pin || ('https://www.google.com/maps/search/?api=1&query=' + item.lat + ',' + item.lng);

            return `
                <div style="min-width:220px">
                    <div style="font-weight:800;font-size:16px;color:#0f172a;margin-bottom:8px;">
                        ${escapeHtml(item.branch_name)}
                    </div>
                    <div style="font-size:13px;line-height:1.6;color:#475467;margin-bottom:8px;">
                        ${escapeHtml(item.full_address || '')}
                    </div>
                    <div style="font-size:13px;line-height:1.6;color:#0ea5c6;font-weight:700;margin-bottom:10px;">
                        Khoảng cách: ${escapeHtml(formatKm(item.distance_km))}
                    </div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <a href="${directionLink}" target="_blank" rel="noopener noreferrer"
                           style="text-decoration:none;background:#12b8d4;color:#fff;padding:8px 12px;border-radius:10px;font-size:12px;font-weight:800;">
                           Chỉ đường
                        </a>
                        <a href="${mapLink}" target="_blank" rel="noopener noreferrer"
                           style="text-decoration:none;background:#f4f8fb;color:#0f172a;padding:8px 12px;border-radius:10px;font-size:12px;font-weight:800;border:1px solid #dbe5ef;">
                           Xem bản đồ
                        </a>
                    </div>
                </div>
            `;
        }

        function renderMarkers(data) {
            branchMarkersLayer.clearLayers();

            if (!data.length) return;

            const bounds = [];

            data.forEach((item, index) => {
                const marker = L.marker([item.lat, item.lng]).addTo(branchMarkersLayer);
                marker.bindPopup(buildPopupHtml(item));

                marker.on('click', function () {
                    highlightListItem(item.id);
                });

                bounds.push([item.lat, item.lng]);
            });

            if (currentUserLatLng) {
                bounds.push([currentUserLatLng.lat, currentUserLatLng.lng]);
            }

            if (bounds.length) {
                map.fitBounds(bounds, { padding: [40, 40] });
            }
        }

        function renderList(data) {
            if (!data.length) {
                listEl.innerHTML = '<div class="near-branch-empty">Hiện chưa có dữ liệu chi nhánh để hiển thị.</div>';
                return;
            }

            listEl.innerHTML = data.map((item, index) => {
                const directionLink = item.google_maps_direction || ('https://www.google.com/maps/dir/?api=1&destination=' + item.lat + ',' + item.lng);
                const mapLink = item.google_maps_pin || ('https://www.google.com/maps/search/?api=1&query=' + item.lat + ',' + item.lng);
                const branchMapLink = item.google_map_link || mapLink;

                return `
                    <article class="near-branch-item" data-branch-id="${item.id}">
                        <div class="near-branch-item-top">
                            <div style="display:flex;gap:12px;align-items:flex-start;">
                                <span class="near-branch-rank">${index + 1}</span>
                                <div>
                                    <h3 class="near-branch-name">${escapeHtml(item.branch_name)}</h3>
                                    <div class="near-branch-code">Mã chi nhánh: ${escapeHtml(item.account_code || 'Đang cập nhật')}</div>
                                </div>
                            </div>

                            <div class="near-branch-distance">📍 ${escapeHtml(formatKm(item.distance_km))}</div>
                        </div>

                        <div class="near-branch-meta">
                            <div class="near-branch-meta-item">
                                <strong>Địa chỉ:</strong> ${escapeHtml(item.full_address || 'Đang cập nhật')}
                            </div>
                            <div class="near-branch-meta-item">
                                <strong>Điện thoại:</strong> ${escapeHtml(item.contact_number || 'Đang cập nhật')}
                            </div>
                            <div class="near-branch-meta-item">
                                <strong>Email:</strong> ${escapeHtml(item.email || 'Đang cập nhật')}
                            </div>
                        </div>

                        <div class="near-branch-actions">
                            <a href="${directionLink}" target="_blank" rel="noopener noreferrer" class="near-branch-link near-branch-link--primary">
                                Chỉ đường
                            </a>
                            <a href="${branchMapLink}" target="_blank" rel="noopener noreferrer" class="near-branch-link near-branch-link--secondary">
                                Xem trên Google Maps
                            </a>
                        </div>
                    </article>
                `;
            }).join('');

            listEl.querySelectorAll('.near-branch-item').forEach((card) => {
                card.addEventListener('click', function (e) {
                    if (e.target.closest('a')) return;

                    const branchId = this.getAttribute('data-branch-id');
                    const found = data.find(item => String(item.id) === String(branchId));
                    if (!found) return;

                    map.flyTo([found.lat, found.lng], 16, {
                        animate: true,
                        duration: 0.8
                    });

                    highlightListItem(found.id);

                    branchMarkersLayer.eachLayer((layer) => {
                        const latlng = layer.getLatLng && layer.getLatLng();
                        if (!latlng) return;

                        if (
                            Math.abs(latlng.lat - found.lat) < 0.000001 &&
                            Math.abs(latlng.lng - found.lng) < 0.000001
                        ) {
                            layer.openPopup();
                        }
                    });
                });
            });
        }

        function highlightListItem(branchId) {
            listEl.querySelectorAll('.near-branch-item').forEach((item) => {
                item.classList.toggle('near-branch-item--active', item.getAttribute('data-branch-id') === String(branchId));
            });
        }

        function sortByDistance(userLat, userLng) {
            branches = branches.map((item) => ({
                ...item,
                distance_km: haversineDistance(userLat, userLng, item.lat, item.lng)
            })).sort((a, b) => a.distance_km - b.distance_km);

            renderMarkers(branches);
            renderList(branches);

            if (branches.length) {
                highlightListItem(branches[0].id);
            }
        }

        function resetDefaultView() {
            currentUserLatLng = null;

            if (userMarker) {
                map.removeLayer(userMarker);
                userMarker = null;
            }

            branches = branches.map((item) => ({
                ...item,
                distance_km: null
            })).sort((a, b) => String(a.branch_name).localeCompare(String(b.branch_name), 'vi'));

            renderMarkers(branches);
            renderList(branches);

            if (branches.length) {
                map.setView([branches[0].lat, branches[0].lng], 12);
            }

            statusEl.textContent = 'Đang hiển thị danh sách chi nhánh mặc định. Bấm "Dùng vị trí của tôi" để sắp xếp từ gần tới xa.';
        }

        function locateUser() {
            if (!navigator.geolocation) {
                statusEl.textContent = 'Thiết bị của bạn không hỗ trợ định vị vị trí.';
                return;
            }

            statusEl.textContent = 'Đang lấy vị trí hiện tại của bạn...';

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    currentUserLatLng = { lat: userLat, lng: userLng };

                    if (userMarker) {
                        map.removeLayer(userMarker);
                    }

                    userMarker = L.marker([userLat, userLng], {
                        title: 'Vị trí của bạn'
                    }).addTo(map).bindPopup('Bạn đang ở đây').openPopup();

                    sortByDistance(userLat, userLng);

                    if (branches.length) {
                        statusEl.textContent = 'Đã xác định vị trí thành công. Hệ thống đang hiển thị các chi nhánh theo khoảng cách gần nhất tới bạn.';
                    } else {
                        statusEl.textContent = 'Đã xác định vị trí, nhưng hiện chưa có chi nhánh nào để hiển thị.';
                    }
                },
                function (error) {
                    if (error.code === 1) {
                        statusEl.textContent = 'Bạn đã từ chối quyền truy cập vị trí. Hãy cấp quyền vị trí để xem chi nhánh gần bạn nhất.';
                    } else if (error.code === 2) {
                        statusEl.textContent = 'Không thể xác định vị trí hiện tại của bạn. Vui lòng thử lại.';
                    } else if (error.code === 3) {
                        statusEl.textContent = 'Hết thời gian lấy vị trí. Vui lòng thử lại.';
                    } else {
                        statusEl.textContent = 'Có lỗi xảy ra khi lấy vị trí hiện tại.';
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 12000,
                    maximumAge: 0
                }
            );
        }

        btnGetLocation?.addEventListener('click', locateUser);
        btnReset?.addEventListener('click', resetDefaultView);

        resetDefaultView();

        setTimeout(() => {
            locateUser();
        }, 500);
    })();
</script>
@endsection