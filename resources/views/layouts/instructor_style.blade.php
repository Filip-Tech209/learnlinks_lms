<style>
    :root {
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
        --success: #16a34a;
        --success-bg: #f0fdf4;
        --success-border: #bbf7d0;
        --danger: #dc2626;
        --danger-bg: #fef2f2;
        --danger-border: #fecaca;
        --neutral-dark: #1e293b;
        --neutral-light: #f8fafc;
        --border-color: #e2e8f0;
        --input-focus: #3b82f6;
    }

    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: var(--neutral-dark);
        background-color: #f1f5f9;
        margin: 0;
        padding: 2rem 1rem;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    h1 { font-size: 1.75rem; font-weight: 700; margin: 0; color: #0f172a; }
    h3 { font-size: 1.15rem; font-weight: 600; color: #475569; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.5rem; margin-top: 2rem; margin-bottom: 1.25rem; }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 6px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .btn-back { background: #ffffff; border-color: #cbd5e1; color: #475569; }
    .btn-back:hover { background: #f8fafc; }
    .btn-primary { background: var(--primary); color: #ffffff; }
    .btn-primary:hover { background: var(--primary-hover); }
    .btn-success { background: var(--success); color: #ffffff; }
    .btn-success:hover { background: #15803d; }
    .btn-danger { background: var(--danger-bg); color: var(--danger); border: 1px solid var(--danger-border); }
    .btn-danger:hover { background: #fee2e2; }
    .btn-outline { background: transparent; border: 1px dashed var(--primary); color: var(--primary); width: 100%; margin-top: 0.5rem; }
    .btn-outline:hover { background: #eff6ff; }

    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.375rem; }

    input, select, textarea {
        width: 100%; padding: 0.625rem 0.875rem; font-size: 0.95rem; border-radius: 6px;
        border: 1px solid #cbd5e1; box-sizing: border-box; transition: all 0.15s ease;
    }
    input:focus, select:focus, textarea:focus { border-color: var(--input-focus); outline: none; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }

    .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }

    .dynamic-card { background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.25rem; margin-bottom: 1rem; }

    .alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.95rem; font-weight: 500; }
    .alert-success { background: var(--success-bg); color: #15803d; border: 1px solid var(--success-border); }
    
    /* Table Styling */
    .table-responsive { width: 100%; overflow-x: auto; border: 1px solid var(--border-color); border-radius: 8px; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background: #f8fafc; padding: 1rem; font-size: 0.875rem; font-weight: 600; color: #475569; border-bottom: 1px solid var(--border-color); }
    td { padding: 1rem; font-size: 0.95rem; border-bottom: 1px solid var(--border-color); color: var(--neutral-dark); }
    tr:last-child td { border-bottom: none; }
    
    /* Status Badges */
    .badge { display: inline-flex; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 600; border-radius: 50px; text-transform: uppercase; }
    .badge-active { background: var(--success-bg); color: var(--success); }
    .badge-inactive { background: #f1f5f9; color: #64748b; }
    .badge-suspended { background: var(--danger-bg); color: var(--danger); }
</style>