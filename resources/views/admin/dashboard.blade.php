<x-app-layout :title="'Dashboard — SMK ABC Library'">
    <div class="page-header">
        <h1>Library Dashboard</h1>
        <p>Overview of the collection and circulation</p>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-value">{{ number_format($summary['totalTitles']) }}</div>
            <div class="stat-label">Titles in catalog</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($summary['totalCopies']) }}</div>
            <div class="stat-label">Total copies</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($summary['totalStudents']) }}</div>
            <div class="stat-label">Registered students</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($summary['activeCheckouts']) }}</div>
            <div class="stat-label">Books checked out</div>
        </div>
        <div class="stat-card alert">
            <div class="stat-value">{{ number_format($summary['overdueCount']) }}</div>
            <div class="stat-label">Overdue right now</div>
        </div>
        <div class="stat-card gold">
            <div class="stat-value">{{ number_format($summary['waitingHolds']) }}</div>
            <div class="stat-label">Holds waiting</div>
        </div>
    </div>

    <div class="panel">
        <h2>Quick actions</h2>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('admin.books.add') }}" class="btn btn-accent">+ Add a book</a>
            <a href="{{ route('admin.checkouts') }}" class="btn btn-outline">View active checkouts</a>
            <a href="{{ route('admin.reports') }}" class="btn btn-outline">View reports</a>
        </div>
    </div>
</x-app-layout>
