@extends('layouts.admin')

@section('content')
<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="header-title">User Management</h1>
                <p class="header-subtitle">Manage and monitor all system users</p>
            </div>
            <button class="add-user-btn" onclick="window.location.href='{{ route('admin.users.create') }}'">
                <i class="fas fa-user-plus me-2"></i>
                Add New User
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $users->total() }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon admin">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $users->where('role', 'admin')->count() }}</div>
                <div class="stat-label">Administrators</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon staff">
                <i class="fas fa-user-cog"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $users->where('role', 'petugas')->count() }}</div>
                <div class="stat-label">Staff Members</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon teacher">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $users->whereIn('role', ['guru', 'siswa'])->count() }}</div>
                <div class="stat-label">Academic Users</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-card">
        <!-- Search and Filters -->
        <div class="search-section">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search users by name, username, or email..." class="search-input">
                <button class="clear-search" id="clearSearch">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="filter-section">
                <span class="filter-label">Filter by Role:</span>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">All Users</button>
                    <button class="filter-btn" data-filter="admin">Administrators</button>
                    <button class="filter-btn" data-filter="petugas">Staff</button>
                    <button class="filter-btn" data-filter="guru">Teachers</button>
                    <button class="filter-btn" data-filter="siswa">Students</button>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        @if($users->count() > 0)
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="user-col">User Information</th>
                        <th class="contact-col">Contact</th>
                        <th class="role-col">Role</th>
                        <th class="date-col">Registration Date</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTable">
                    @foreach($users as $user)
                    <tr class="user-row" data-role="{{ $user->role }}" data-search="{{ strtolower($user->username . ' ' . $user->nama_pengguna . ' ' . $user->email) }}">
                        <td class="user-col">
                            <div class="user-info-cell">
                                <div class="user-avatar {{ $user->role }}">
                                    {{ strtoupper(substr($user->nama_pengguna, 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->nama_pengguna }}</div>
                                    <div class="user-username">{{ $user->username }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="contact-col">
                            @if($user->email)
                            <div class="contact-info">
                                <i class="fas fa-envelope contact-icon"></i>
                                <span class="email-text">{{ $user->email }}</span>
                            </div>
                            @else
                            <span class="no-email">No email provided</span>
                            @endif
                        </td>
                        <td class="role-col">
                            <span class="role-badge {{ $user->role }}">
                                <i class="fas
                                    @if($user->role == 'admin') fa-user-shield
                                    @elseif($user->role == 'petugas') fa-user-cog
                                    @elseif($user->role == 'guru') fa-chalkboard-teacher
                                    @elseif($user->role == 'siswa') fa-user-graduate
                                    @else fa-user @endif role-icon">
                                </i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="date-col">
                            <div class="join-date">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M d, Y') : 'N/A' }}
                            </div>
                        </td>
                        <td class="actions-col">
                            <div class="action-buttons">
                                <button class="table-btn edit-btn" onclick="window.location.href='{{ route('admin.users.edit', $user->id_user) }}'" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </button>
                                <button class="table-btn delete-btn"
                                        onclick="openDeleteOffcanvas({{ $user->id_user }}, '{{ $user->nama_pengguna }}')"
                                        title="Delete User">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-section">
            <div class="pagination-info">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
            </div>
            <div class="pagination">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>No Users Found</h3>
            <p>Get started by adding your first user to the system</p>
            <button class="primary-btn" onclick="window.location.href='{{ route('admin.users.create') }}'">
                <i class="fas fa-user-plus me-2"></i>
                Add First User
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Delete Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="deleteOffcanvas" aria-labelledby="deleteOffcanvasLabel">
    <div class="offcanvas-header">
        <div class="warning-icon text-warning me-2">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h5 class="offcanvas-title" id="deleteOffcanvasLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>Yakin ingin menghapus user <strong id="userName"></strong>?</p>
        <p class="text-danger small">Aksi ini tidak dapat dibatalkan dan akan menghapus user secara permanen dari sistem.</p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="d-flex gap-2 mt-4">
                <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="offcanvas">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-danger flex-fill">
                    <i class="fas fa-trash-alt me-1"></i> Hapus User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Success Message -->
<div class="notification" id="successNotification">
    <div class="notification-content">
        <i class="fas fa-check-circle notification-icon"></i>
        <span class="notification-text" id="notificationMessage"></span>
    </div>
</div>

<style>
/* Base Styles */
.admin-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8fafc;
    min-height: 100vh;
}

/* Header */
.admin-header {
    margin-bottom: 32px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
    letter-spacing: -0.5px;
}

.header-subtitle {
    color: #718096;
    font-size: 16px;
    margin: 8px 0 0 0;
    font-weight: 400;
}

.add-user-btn {
    background: #2d3748;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
    font-size: 14px;
}

.add-user-btn:hover {
    background: #4a5568;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.2s ease;
    border: 1px solid #e2e8f0;
}

.stat-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.stat-icon.total { background: #4c51bf; }
.stat-icon.admin { background: #e53e3e; }
.stat-icon.staff { background: #3182ce; }
.stat-icon.teacher { background: #38a169; }

.stat-number {
    font-size: 28px;
    font-weight: 700;
    color: #1a202c;
    line-height: 1;
}

.stat-label {
    color: #718096;
    font-weight: 500;
    font-size: 14px;
    margin-top: 4px;
}

/* Content Card */
.content-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 32px;
    border: 1px solid #e2e8f0;
}

/* Search Section */
.search-section {
    margin-bottom: 24px;
}

.search-box {
    position: relative;
    max-width: 400px;
    margin-bottom: 20px;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #a0aec0;
}

.search-input {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s ease;
    background: white;
    color: #4a5568;
}

.search-input:focus {
    outline: none;
    border-color: #4c51bf;
    box-shadow: 0 0 0 3px rgba(76, 81, 191, 0.1);
}

.clear-search {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 14px;
    color: #a0aec0;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.clear-search:hover {
    background: #f7fafc;
    color: #718096;
}

/* Filter Section */
.filter-section {
    display: flex;
    align-items: center;
    gap: 16px;
}

.filter-label {
    font-size: 14px;
    font-weight: 600;
    color: #4a5568;
}

.filter-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 8px 16px;
    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    font-size: 13px;
    color: #718096;
    transition: all 0.2s ease;
}

.filter-btn.active,
.filter-btn:hover {
    background: #4c51bf;
    color: white;
    border-color: #4c51bf;
}

/* Modern Table */
.table-container {
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 14px;
}

.modern-table thead {
    background: #f7fafc;
    border-bottom: 2px solid #e2e8f0;
}

.modern-table th {
    padding: 16px 20px;
    text-align: left;
    color: #4a5568;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table th.user-col { width: 30%; }
.modern-table th.contact-col { width: 25%; }
.modern-table th.role-col { width: 15%; }
.modern-table th.date-col { width: 15%; }
.modern-table th.actions-col { width: 15%; }

.modern-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s ease;
}

.modern-table tbody tr:hover {
    background: #f8fafc;
}

.modern-table tbody tr:last-child {
    border-bottom: none;
}

.modern-table td {
    padding: 16px 20px;
    vertical-align: middle;
}

/* User Info Cell */
.user-info-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
    color: white;
    flex-shrink: 0;
}

.user-avatar.admin { background: #e53e3e; }
.user-avatar.petugas { background: #3182ce; }
.user-avatar.guru { background: #38a169; }
.user-avatar.siswa { background: #805ad5; }

.user-details {
    flex: 1;
}

.user-name {
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 2px;
    font-size: 14px;
}

.user-username {
    color: #718096;
    font-weight: 400;
    font-size: 13px;
}

/* Contact Info */
.contact-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.contact-icon {
    font-size: 12px;
    color: #a0aec0;
}

.email-text {
    color: #4a5568;
    font-size: 14px;
}

.no-email {
    color: #a0aec0;
    font-style: italic;
    font-size: 13px;
}

/* Role Badge */
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.role-badge.admin { background: #fed7d7; color: #c53030; }
.role-badge.petugas { background: #bee3f8; color: #2b6cb0; }
.role-badge.guru { background: #c6f6d5; color: #276749; }
.role-badge.siswa { background: #e9d8fd; color: #6b46c1; }

.role-icon {
    font-size: 11px;
}

/* Date */
.join-date {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #718096;
    font-weight: 400;
    font-size: 13px;
}

.date-icon {
    font-size: 12px;
    color: #a0aec0;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.table-btn {
    padding: 6px 12px;
    border: 1px solid;
    border-radius: 4px;
    font-weight: 500;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 4px;
}

.edit-btn {
    background: white;
    border-color: #e2e8f0;
    color: #4a5568;
}

.edit-btn:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
}

.delete-btn {
    background: white;
    border-color: #fed7d7;
    color: #e53e3e;
}

.delete-btn:hover {
    background: #fff5f5;
    border-color: #feb2b2;
}

/* Pagination */
.pagination-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
    margin-top: 20px;
}

.pagination-info {
    color: #718096;
    font-weight: 400;
    font-size: 14px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    font-size: 48px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #4a5568;
    margin-bottom: 8px;
    font-weight: 600;
}

.empty-state p {
    color: #718096;
    margin-bottom: 24px;
    font-size: 14px;
}

.primary-btn {
    background: #2d3748;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
}

.primary-btn:hover {
    background: #4a5568;
}

/* Notification */
.notification {
    position: fixed;
    top: 24px;
    right: 24px;
    background: #38a169;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    display: none;
    align-items: center;
    gap: 8px;
    z-index: 1001;
    max-width: 400px;
}

.notification-icon {
    font-size: 16px;
}

.notification-text {
    font-weight: 500;
    font-size: 14px;
}

/* Offcanvas Custom Styles */
.offcanvas-header {
    border-bottom: 1px solid #e2e8f0;
    padding: 20px;
}

.offcanvas-title {
    font-weight: 600;
    color: #1a202c;
}

.offcanvas-body {
    padding: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-container {
        padding: 16px;
    }

    .header-content {
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
    }

    .header-title {
        font-size: 24px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .table-container {
        overflow-x: auto;
    }

    .modern-table {
        min-width: 800px;
    }

    .pagination-section {
        flex-direction: column;
        gap: 12px;
        text-align: center;
    }

    .filter-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .filter-buttons {
        width: 100%;
        justify-content: flex-start;
    }

    .action-buttons {
        flex-direction: column;
        gap: 4px;
    }

    .table-btn {
        font-size: 11px;
        padding: 4px 8px;
    }
}
</style>

<script>
// Delete Offcanvas Function
function openDeleteOffcanvas(userId, userName) {
    // Set user name
    document.getElementById('userName').textContent = userName;

    // Set form action
    const form = document.getElementById('deleteForm');
    form.action = `/admin/users/${userId}`;

    // Show offcanvas
    const deleteOffcanvas = new bootstrap.Offcanvas(document.getElementById('deleteOffcanvas'));
    deleteOffcanvas.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const userRows = document.querySelectorAll('.user-row');
    const successNotification = document.getElementById('successNotification');
    const notificationMessage = document.getElementById('notificationMessage');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();

        userRows.forEach(row => {
            const searchData = row.getAttribute('data-search');
            const role = row.getAttribute('data-role');
            const currentFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');

            const matchesSearch = searchData.includes(searchTerm);
            const matchesFilter = currentFilter === 'all' || role === currentFilter;

            if (matchesSearch && matchesFilter) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });

        clearSearch.style.display = searchTerm ? 'block' : 'none';
    });

    // Clear search
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    });

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Trigger search to apply filter
            searchInput.dispatchEvent(new Event('input'));
        });
    });

    // Show success message from session
    @if(session('success'))
        showNotification('{{ session('success') }}');
    @endif

    function showNotification(message) {
        notificationMessage.textContent = message;
        successNotification.style.display = 'flex';

        setTimeout(() => {
            successNotification.style.display = 'none';
        }, 4000);
    }
});
</script>
@endsection
