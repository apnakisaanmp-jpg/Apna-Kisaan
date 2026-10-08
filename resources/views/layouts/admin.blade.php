<!doctype html>
<html lang="hi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Apna Kisaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Noto+Sans+Devanagari:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: #f5faf5;
            font-family: 'DM Sans', 'Noto Sans Devanagari', sans-serif;
            color: #173426;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: #073b27;
            color: #fff;
            padding: 24px 18px;
        }

        .sidebar a {
            color: #dbeadd;
            text-decoration: none;
            display: flex;
            gap: .6rem;
            align-items: center;
            padding: .62rem .7rem;
            border-radius: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #1d6f35;
            color: #fff;
        }

        .content {
            padding: clamp(18px, 3vw, 36px);
        }

        .card {
            border-radius: 10px;
            border: 1px solid #dfe8dc;
            box-shadow: 0 8px 20px rgba(30, 60, 30, .06);
        }

        .table thead th {
            color: #617568;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .table td {
            font-size: .92rem;
        }

        .table td {
            vertical-align: middle;
        }

        @media(max-width:900px) {
            .admin-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }

            .sidebar nav {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: .25rem;
            }
        }
    </style>
</head>

<body>
    <div class="admin-shell">
        <aside class="sidebar">
            <div class="mb-4">
                <div class="text-warning small fw-bold">APNA KISAAN</div>
                <h5 class="fw-bold mb-1">Admin workspace</h5><small
                    class="text-white-50">{{ auth()->user()->name }}</small>
            </div>
            @php $links = ['dashboard'=>'Dashboard','contacts'=>'Contact Leads','inquiries'=>'User Inquiries','registrations'=>'Registrations','transport'=>'Transport','services'=>'Services','districts'=>'Districts','prices'=>'Prices','crops'=>'Crop Categories','faqs'=>'FAQs','sliders'=>'Sliders','team'=>'Team','users'=>'Users']; @endphp
            <nav>
                <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Website</a>
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                @foreach ($links as $key => $label)
                    @continue($key === 'dashboard')
                    <a class="{{ request('resource') === $key ? 'active' : '' }}"
                        href="{{ route('admin.resources.index', $key) }}"><i class="fa-solid fa-circle-dot"></i>
                        {{ $label }}</a>
                @endforeach
                <a href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
            <form method="post" action="{{ route('logout') }}" class="mt-3">@csrf<button
                    class="btn btn-outline-light w-100">Logout</button></form>
        </aside>
        <main class="content">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
