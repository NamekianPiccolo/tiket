 <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #1e2b37 100%);
            --sidebar-color: #e9ecef;
            --sidebar-active-bg: rgba(0, 123, 255, 0.2);
            --sidebar-active-color: #007bff;
            --sidebar-hover-bg: rgba(255, 255, 255, 0.1);
            --sidebar-header-bg: rgba(0, 0, 0, 0.2);
            --sidebar-border-color: rgba(255, 255, 255, 0.05);
            --sidebar-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            --sidebar-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --sidebar-collapsed-width: 80px;
        }
        .input-group {
    position: relative;
    margin: 20px 0;
    width: 300px;
    }

    .input-group input {
        width: 100%;
        padding: 10px 0;
        font-size: 16px;
        color: #333;
        border: none;
        border-bottom: 2px solid #ccc;
        outline: none;
        background: transparent;
        transition: 0.3s;
    }

    .input-group label {
        position: absolute;
        top: 10px;
        left: 0;
        font-size: 16px;
        color: #666;
        pointer-events: none;
        transition: 0.3s;
    }

    .input-group input:focus ~ label,
    .input-group input:valid ~ label {
        top: -15px;
        font-size: 12px;
        color: #3498db;
    }

    .input-group .underline {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: #3498db;
        transition: 0.3s;
    }

    .input-group input:focus ~ .underline {
        width: 100%;
    }

        body {
            display: flex;
            min-height: 100vh;
            padding-left: var(--sidebar-width);
            background-color: #f8f9fa;
            transition: var(--sidebar-transition);
        }

        .sidebar.collapsed .sidebar-header h3,
        .sidebar.collapsed .user-name,
        .sidebar.collapsed .user-role,
        .sidebar.collapsed .sidebar-menu a span,
        .sidebar.collapsed .sidebar-footer {
            display: none;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
            overflow: hidden;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 20px 0;
            text-align: center;
        }

        .sidebar.collapsed .user-profile {
            justify-content: center;
            padding: 15px 0;
        }

        .sidebar.collapsed .user-avatar {
            margin-right: 0;
        }

        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .sidebar-menu i {
            margin-right: 0;
            font-size: 1.3rem;
        }

        .sidebar-close-btn {
            position: absolute;
            right: 10px;
            top: 15px;
            background: transparent;
            border: none;
            color: var(--sidebar-color);
            font-size: 1.2rem;
            cursor: pointer;
            display: none;
        }

        @media (max-width: 992px) {
            .sidebar-close-btn {
                display: block;
            }
        }

        .sidebar.collapsed ~ .main-content .sidebar-toggle {
            left: calc(var(--sidebar-collapsed-width) + 15px);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--sidebar-color);
            padding: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: var(--sidebar-transition);
            box-shadow: var(--sidebar-shadow);
            border-right: 1px solid var(--sidebar-border-color);
        }

        .sidebar-header {
            padding: 20px;
            background: var(--sidebar-header-bg);
            text-align: center;
            border-bottom: 1px solid var(--sidebar-border-color);
        }

        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-weight: 600;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            padding: 15px 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-menu li {
            position: relative;
            margin: 5px 10px;
            border-radius: 6px;
            overflow: hidden;
        }

        .sidebar-menu li.divider {
            height: 1px;
            background-color: var(--sidebar-border-color);
            margin: 15px 20px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--sidebar-color);
            text-decoration: none;
            transition: var(--sidebar-transition);
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 6px;
        }

        .sidebar-menu a:hover {
            background: var(--sidebar-hover-bg);
            color: white;
            transform: translateX(3px);
        }

        .sidebar-menu a.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            font-weight: 600;
            border-left: 3px solid var(--sidebar-active-color);
        }

        .sidebar-menu a.active i {
            color: var(--sidebar-active-color);
        }

        .sidebar-menu i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            transition: var(--sidebar-transition);
        }

        .sidebar-footer {
            padding: 15px;
            text-align: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            border-top: 1px solid var(--sidebar-border-color);
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid var(--sidebar-border-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 2px;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
            display: block;
        }

        .main-content {
            flex: 1;
            padding: 25px;
            transition: var(--sidebar-transition);
        }

        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                width: 100%;
            }
        }

        .sidebar-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 999;
            background: var(--sidebar-active-bg);
            border: none;
            color: var(--sidebar-active-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 992px) {
            .sidebar-toggle {
                display: flex;
            }
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .img-preview-container {
            margin-top: 10px;
            text-align: center;
        }

        .img-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .action-buttons .btn {
            margin: 2px;
            min-width: 70px;
        }

        .deskripsi-cell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 3rem;
            height: 3rem;
        }

        .pagination .page-item .page-link {
            color: #0d6efd;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
        }

        .pagination .page-item:not(.disabled):not(.active) .page-link:hover {
            background-color: #e9ecef;
        }

        .pagination-info {
            font-size: 0.9rem;
        }

        .per-page-selector {
            width: 80px;
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 768px) {
            #tiket-table th:nth-child(7),
            #tiket-table td:nth-child(7),
            #tiket-table th:nth-child(8),
            #tiket-table td:nth-child(8) {
                display: none;
            }

            #tiket-table th,
            #tiket-table td {
                padding: 8px 5px;
                font-size: 0.85rem;
            }

            .action-buttons .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-reset-btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .content {
            margin-left: 25px;
            padding: 20px;
            width: 100%;
        }

        .qr-scanner-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(0, 123, 255, 0.2);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
             display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    padding: 20px;
        }

        .qr-input-section {
            margin-bottom: 20px;
            width: 100%;
    max-width: 600px;
    display: flex;
    flex-direction: column;
    align-items: center;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
             max-width: 300px;
    margin: 10px 0;
        }

        .btn {
            padding: 10px 15px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .ticket-info {
            margin-top: 20px;
            padding: 15px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #qr-reader {
            margin: 15px 0;

            padding: 10px;
            border-radius: 8px;
        }

        #qr-reader img {
            max-width: 100%;
        }
    </style>
